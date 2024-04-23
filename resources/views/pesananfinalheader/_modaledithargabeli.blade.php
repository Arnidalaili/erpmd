<div class="modal modal-fullscreen" id="editHargaBeliModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editHargaBeliForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editHargaBeliModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl pengiriman<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglpengirimanbeli" id="tglpengirimanbeli" class="form-control lg-form datepicker filled-row">
                                </div>
                            </div>
                        </div>
                        <div class="overflow  scroll-container mb-2">
                            <div class="table-container ">
                                <table class="table table-lookup table-bold table-bindkeys " id="detailEditHargaBeli">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body" class="form-group">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitEditHargaBeli" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-warning" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT EDIT HARGA BELI -->
@push('scripts')
<script>
    hasFormBindKeys = false
    let editHargaBeliModal = $('#editHargaBeliModal').find('.modal-body').html()

    $(document).ready(function() {
        $(document).on('click', "#addRowEditHargaBeli", function() {
            addRowEditHargaBeli()
        });

        $(document).on('change', `#editHargaBeliForm [id="tglpengirimanbeli"]`, function() {
            getProductPesananBeli()
        });

        $(document).on('input', `#editHargaBeliForm [name="harga[]"]`, function(event) {
            setTotalHargaBeli($(this))
            setSubTotalHargaBeli($(this))
        })


        $('#btnSubmitEditHargaBeli').click(function(event) {

            event.preventDefault()
            let method
            let url
            let form = $('#editHargaBeliForm')
            let action = form.data('action')
            let dataEdit = $('#editHargaBeliForm .filled-row').serializeArray()

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $('#editHargaBeliForm').find(`.filled-row[name="harga[]"]`).each((index, element) => {
                dataEdit.filter((row) => row.name === 'harga[]')[index].value = AutoNumeric.getNumber($(`#editHargaBeliForm  .filled-row[name="harga[]"]`)[index])
            })

            $.ajax({
                url: `${apiUrl}pesananfinalheader/edithargabeli`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: dataEdit,
                success: response => {
                    $('#editHargaBeliForm').trigger('reset')
                    $('#editHargaBeliModal').modal('hide')

                    showSuccessDialog(response.message)
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        })
    })

    $('#editHargaBeliModal').on('shown.bs.modal', () => {
        let form = $('#editHargaBeliForm')
        setFormBindKeys(form)
        activeGrid = null

        initDatepicker()
        getMaxLength(form)
    })

    $('#editHargaBeliModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editHargaBeliModal').find('.modal-body').html(editHargaBeliModal)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        initDatepicker('datepickerIndex')
    })

    function editHargaBeli() {

        let form = $('#editHargaBeliModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditHargaBeli').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'edithargabeli')
        form.find(`.sometimes`).hide()
        $('#editHargaBeliModalTitle').text('Edit Harga Beli')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate() + 1);
        $('#editHargaBeliForm').find('[name=tglpengirimanbeli]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

        Promise
            .all([

            ])
            .then(() => {
                $('#editHargaBeliModal').modal('show')
                addRowEditHargaBeli()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
        initAutoNumericNoDoubleZero(form.find(`[name="hargabeli"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="totalharga"]`))
    }

    function addRowEditHargaBeli(show = 0) {
        form = $('#detailEditHargaBeli')
        if (detectDeviceType() == "desktop") {
            $('#detailEditHargaBeli').html('');

            let supplierTable = $('<table></table>');
            let tableHeader = $('<thead></thead>');
            let supplierNameRow = $('<tr><th colspan="5">Supplier: ' + '' + '</th></tr>');
            tableHeader.append(supplierNameRow);

            let headerRow = $('<tr></tr>');
            let no = $('<th style="width: 60px">No. </th>');
            let product = $('<th style="width: 300px">Product</th>');
            let qty = $('<th style="width: 250px">Qty</th>');
            let totalqty = $('<th style="width: 150px">Total Qty</th>');
            let hargabeli = $('<th style="width: 150px">Harga Beli</th>');
            let totalhargabeli = $('<th style="width: 150px">Total Harga Beli</th>');

            headerRow.append(no);
            headerRow.append(product);
            headerRow.append(qty);
            headerRow.append(totalqty);
            headerRow.append(hargabeli);
            headerRow.append(totalhargabeli);
            tableHeader.append(headerRow);

            supplierTable.append(tableHeader);

            let emptyRow = $('<tr></tr>');
            let nocell = $(`<td style="width: 60px" id="nocell">1</td>`);
            let productidcell = $(`<input type="hidden" name="productid[]" class="form-control lg-form filled-row" autocomplete="off"/>`);
            let productcell = $(`<input type="text" name="productnama[]" class="form-control lg-form filled-row" autocomplete="off" style="width: 100%; height: 30px;" />`);
            let combinedTd = $('<td style="width: 300px"></td>').append(productidcell).append(productcell);
            let qtycell = $(`<td style="width: 250px"><input type="text" name="qty[]" class="form-control lg-form" autocomplete="off" style="width: 100%; height: 30px;" /></td>`);
            let totalqtycell = $(`<td style="width: 150px"><input type="text" name="totalqty[]" class="form-control lg-form autonumeric" autocomplete="off" style="width: 100%; height: 30px;" /></td>`);
            let hargacell = $(`<td style="width: 150px"><input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" style="width: 100%; height: 30px;" /></td>`);
            let totalhargacell = $(`<td style="width: 150px"><input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" style="width: 100%; height: 30px;" /></td>`);

            emptyRow.append(nocell);
            emptyRow.append(combinedTd);
            emptyRow.append(qtycell);
            emptyRow.append(totalqtycell);
            emptyRow.append(hargacell);
            emptyRow.append(totalhargacell);

            supplierTable.append(emptyRow);

            form.append(supplierTable);

        } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
                <th style="width: 500px; min-width: 250px;">No.</th>
                <th style="width: 250px; min-width: 200px;">Customer</th>
                <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
                <th class="wider-hargabeli text-right" style="width: 120px; min-width: 150px;">Harga Jual</th>
                <th class="wider-hargabeli text-right" style="width: 120px; min-width: 150px;">Harga Beli</th>
            `);

            $(".wider-qty").remove();
            if (!show) {
                $('#detailEditHargaBeli thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }
            for (let i = show; i < 50; i++) {
                let urut = i + 1;
                let detailRow = $(`
                    <tr>
                        <td class="table-bold" >
                            <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">${urut}. &ensp; customer</label>
                            <input type="hidden" name="customerid[]" class="form-control  detail_stok_${selectIndex}">
                            <input type="text" name="customer_name[]" id="CustomerEdit_Id${selectIndex}" class="form-control lg-form numeric customeredit-lookup${selectIndex}" autocomplete="off">

                            
                    
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                <div class="col-6">
                                <label class="col-form-label label-top label-mobile" style=" min-width: 25px;">QTY </label>
                                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                </div>
                            </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                <div class="col-6">
                                <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA JUAL</label>
                                <input type="text" name="hargabeli[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>

                                <div class="col-6">
                                <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">HARGA BELI</label>
                                <input type="text" name="hargabeli[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr> `)

                detailRow.on('input', 'input[name="hargabeli[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="hargabeli[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });

                $('#detailEditHargaBeli tbody').append(detailRow)
                clearButton(form, `#addRowEditHargaBeli_${selectIndex}`)
                initDatepicker()
                rowLookup = selectIndex
                selectIndex++
            }
            initAutoNumeric($('#detailEditHargaBeli').find('.autonumeric'))
            initAutoNumericNoDoubleZero($('#detailEditHargaBeli').find('.autonumeric-nozero'))
        }
    }

    function setTotalHargaBeli(element, id = 0) {
        let totalqty = parseFloat(element.parents('tr').find(` [name="totalqty[]"]`).val().replace(/,/g, ''))
        let harga = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
        let totalharga = totalqty * harga;
        initAutoNumericNoDoubleZero(element.parents('tr').find(`[name="totalharga[]"]`).val(totalharga))
    }

    function setSubTotalHargaBeli(element) {
        let totalhargas = element.parents('tbody').find(`[name="totalharga[]"]`)
        let potongan = $(element.parents('tbody').find(`[name="potongan"]`)).data('value')

        let subtotal = 0;
        let grandtotal = 0;
        $.each(totalhargas, (index, harga) => {
            subtotal += AutoNumeric.getNumber($(harga)[0])
            
        });
        grandtotal += subtotal - potongan

        $(element.parents('tbody').find(`[name="subtotal"]`)).data('value', subtotal)
        initAutoNumericNoDoubleZero($(element.parents('tbody').find(`[name="subtotal"]`)).text(subtotal))

        $(element.parents('tbody').find(`[name="grandtotal"]`)).data('value', grandtotal)
        initAutoNumericNoDoubleZero($(element.parents('tbody').find(`[name="grandtotal"]`)).text(grandtotal))
    }

    function getProductPesananBeli() {
        $.ajax({
            url: `${apiUrl}pesananfinalheader/cekproductpesanan`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                tglpengirimanbeli: $('#editHargaBeliForm').find('[id=tglpengirimanbeli]').val(),
            },
            success: response => {

                if (response && response.length > 0) {

                    let supplierDataArray = Object.values(response);
                    console.log(supplierDataArray)
                    supplierDataArray.sort((a, b) => {
                        let supplierNameA = a.suppliernama.toUpperCase();
                        let supplierNameB = b.suppliernama.toUpperCase();
                        if (supplierNameA < supplierNameB) {
                            return -1;
                        }
                        if (supplierNameA > supplierNameB) {
                            return 1;
                        }
                        return 0;
                    });
                    $('#detailEditHargaBeli').html('');
                    let groupedBySupplier = {};

                    let totalHargaElement = $(`[name="totalharga[]"]`);

                    supplierDataArray.forEach((supplierData, index) => {
                        let supplierTable = $('<table class="table-bordered"></table>');
                        let tableHeader = $('<thead></thead>');
                        let supplierNameRow = $('<tr><th colspan="2">Supplier: ' + supplierData.suppliernama + '</th><th colspan="4">Karyawan: ' + supplierData.karyawannama + '</th></tr>');

                        tableHeader.append(supplierNameRow);

                        let supplierSubTotal = 0;
                        let supplierPotongan = 0;
                        let subTotal = 0;
                        let potongan = 0;

                        let headerRow = $('<tr></tr>');
                        let no = $('<th style="width: 60px">No. </th>');
                        let product = $('<th style="width: 300px">Product</th>');
                        let qty = $('<th style="width: 250px">Qty</th>');
                        let totalqty = $('<th style="width: 150px">Total Qty</th>');
                        let hargabeli = $('<th style="width: 150px">Harga Beli</th>');
                        let totalhargabeli = $('<th style="width: 150px">Total Harga Beli</th>');

                        headerRow.append(no);
                        headerRow.append(product);
                        headerRow.append(qty);
                        headerRow.append(totalqty);
                        headerRow.append(hargabeli);
                        headerRow.append(totalhargabeli);
                        tableHeader.append(headerRow);

                        supplierTable.append(tableHeader);
                        let tableBody = $('<tbody></tbody>');
                        supplierData.productid.forEach((productId, index) => {
                            let hiddenProductId = supplierData.productid[index];

                            let detailRow = $('<tr></tr>');
                            let nocell = $(`<td style="width: 60px" id="nocell">${index + 1} </td>`);
                            let productidcell = $(`<input type="hidden" name="productid[]" class="form-control lg-form filled-row" autocomplete="off" value="${hiddenProductId}" />`);
                            let productcell = $(`<input type="text" name="productnama[]" class="form-control lg-form filled-row" autocomplete="off" value="${supplierData.productnama[index]}" style="width: 100%; height: 30px;" />`);
                            let combinedTd = $('<td style="width: 300px"></td>').append(productidcell).append(productcell);
                            let qtycell = $(`<td style="width: 250px"><input type="text" name="qty[]" class="form-control lg-form" autocomplete="off" value="${supplierData.qty[index]}" style="width: 100%; height: 30px; text-align: right;" /></td>`);
                            let totalqtycell = $(`<td style="width: 150px"><input type="text" name="totalqty[]" class="form-control lg-form autonumeric" autocomplete="off" value="${supplierData.totalproductqty[index]}" style="width: 100%; height: 30px;" /></td>`);
                            let hargacell = $(`<td style="width: 150px"><input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric-nozero" autocomplete="off" value="${supplierData.harga[index]}" style="width: 100%; height: 30px;" /></td>`);
                            let totalhargacell = $(`<td style="width: 150px"><input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric-nozero" autocomplete="off" style="width: 100%; height: 30px;" /></td>`);

                            detailRow.append(nocell);
                            detailRow.append(combinedTd);
                            detailRow.append(qtycell);
                            detailRow.append(totalqtycell);
                            detailRow.append(hargacell);
                            detailRow.append(totalhargacell);
                            tableBody.append(detailRow);

                            setTotalHargaBeli(totalqtycell.find(` [name="totalqty[]"]`));



                            let totalHargaItem = parseFloat(totalhargacell.find(` [name="totalharga[]"]`).val().replace(/,/g, '') || 0);
                            supplierSubTotal += totalHargaItem;
                        });
                        // setSubTotalHargaBeli(tableBody.find(` [name="totalharga[]"]`))
                        subTotal += supplierSubTotal;

                        let subTotalRow = $('<tr></tr>');
                        let subTotalLabelCell = $(`<th colspan="5">Sub Total : </th>`);
                        let subTotalValueCell = $(`<th style="text-align: right;" class="autonumeric-nozero">${supplierSubTotal.toFixed(2)}</th>`);
                        subTotalValueCell.attr('name', 'subtotal');
                        subTotalRow.append(subTotalLabelCell);
                        subTotalRow.append(subTotalValueCell);
                        tableBody.append(subTotalRow);

                        potongan += supplierData.potongan.toFixed(2);

                        let potonganRow = $('<tr></tr>');
                        let potonganLabelCell = $(`<th colspan="5">Potongan : </th>`);
                        // let potonganValueCell = $(`<th style="text-align: right;" class="autonumeric-nozero">${supplierData.potongan.toFixed(2)}</th>`);
                        // potonganValueCell.attr('name', 'potongan');
                        let potonganValueCell = $(`<th style="text-align: right;" class="autonumeric-nozero" data-value="${supplierData.potongan.toFixed(2)}">${supplierData.potongan.toFixed(2)}</th>`);
                        potonganValueCell.attr('name', 'potongan');

                        potonganRow.append(potonganLabelCell);
                        potonganRow.append(potonganValueCell);
                        tableBody.append(potonganRow);

                        let grandTotal = subTotal - potongan;

                        let grandTotalRow = $('<tr></tr>');
                        let grandTotalLabelCell = $(`<th colspan="5">Grand Total : </th>`);
                        let grandTotalValueCell = $(`<th style="text-align: right;" class="autonumeric-nozero">${grandTotal.toFixed(2)}</th>`);
                        grandTotalValueCell.attr('name', 'grandtotal');
                        grandTotalRow.append(grandTotalLabelCell);
                        grandTotalRow.append(grandTotalValueCell);
                        tableBody.append(grandTotalRow);


                        supplierTable.append(tableBody);
                        $('#detailEditHargaBeli').append(supplierTable.prop('outerHTML'));

                        // Add empty row between suppliers
                        if (index < supplierDataArray.length - 1) {
                            let emptyRow = $('<tr><td colspan="6">&nbsp;</td></tr>');
                            $('#detailEditHargaBeli').append(emptyRow);
                        }
                    })

                    initAutoNumeric($('#detailEditHargaBeli').find('.autonumeric'))
                    initAutoNumericNoDoubleZero($('#detailEditHargaBeli').find('.autonumeric-nozero'))
                } else {
                    addRowEditHargaBeli()
                }
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            },
        })
    }

    function setRowNumbersEditBeli() {
        let elements = $('#detailEditHargaBeli tbody tr td:nth-child(1)')


        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }
</script>
@endpush()