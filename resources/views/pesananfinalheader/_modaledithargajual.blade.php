<div class="modal modal-fullscreen" id="editHargaJualModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editHargaJualForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editHargaJualModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <!-- <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl pengiriman<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglpengirimanjual" id="tglpengirimanjual" class="form-control lg-form datepicker filled-row">
                                </div>
                            </div>
                        </div> -->
                        <div class="overflow  scroll-container mb-2">
                            <div class="table-container">
                                <table class="table table-lookup table-bold table-bindkeys " id="detailEdit">
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
                        <button id="btnSubmitEditHargaJual" class="btn btn-primary">
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

<!-- SCRIPT EDIT HARGA JUAL -->
@push('scripts')
<script>
    hasFormBindKeys = false
    let editHargaJualModal = $('#editHargaJualModal').find('.modal-body').html()
  

    $(document).ready(function() {
        $(document).on('click', "#addRowEditHargaJual", function() {
            addRowEditHargaJual()
        });

        // $(document).on('change', `#editHargaJualForm [id="tglpengirimanjual"]`, function() {
        //     // console.log(selectedRows);
        //     getProductPesananJual()
        // });


        $('#btnSubmitEditHargaJual').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#editHargaJualForm')
            let action = form.data('action')
            let dataEdit = $('#editHargaJualForm .filled-row').serializeArray()

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $('#editHargaJualForm tbody tr.filled-row').each(function(index, element) {

                if ($(this).hasClass('filled-row')) {

                    let row_index = $(this).index();
                    dataEdit.push({
                        name: `productid[${row_index}]`,
                        value: $(this).find(`[name="productid[]"]`).val()
                    })
                    dataEdit.push({
                        name: `productnama[${row_index}]`,
                        value: $(this).find(`[name="productnama[]"]`).val()
                    })
                    dataEdit.push({
                        name: `hargajual[${row_index}]`,
                        value: parseFloat($(this).find(`[name="hargajual[]"]`).val().replace(/,/g, ''))
                    })
                }
            })

            $('#editHargaJualForm').find(`.filled-row[name="hargajual[]"]`).each((index, element) => {
                dataEdit.filter((row) => row.name === 'hargajual[]')[index].value = AutoNumeric.getNumber($(`#editHargaJualForm  .filled-row[name="hargajual[]"]`)[index])
            })
            console.log(dataEdit)

            $.ajax({
                url: `${apiUrl}pesananfinalheader/edithargajual`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: dataEdit,
                success: response => {
                    $('#editHargaJualForm').trigger('reset')
                    $('#editHargaJualModal').modal('hide')

                    showSuccessDialog(response.message)
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                    }).trigger('reloadGrid');
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

    $('#editHargaJualModal').on('shown.bs.modal', () => {
        let form = $('#editHargaJualForm')
        setFormBindKeys(form)
        activeGrid = null

        initDatepicker()
        getMaxLength(form)
    })

    $('#editHargaJualModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editHargaJualModal').find('.modal-body').html(editHargaJualModal)
        initDatepicker('datepickerIndex')
    })

    function editHargaJual() {

        let form = $('#editHargaJualModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditHargaJual').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'edithargajual')
        form.find(`.sometimes`).hide()
        $('#editHargaJualModalTitle').text('Edit Harga Jual')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        // var besok = new Date();
        // besok.setDate(besok.getDate() + 1);
        // $('#editHargaJualForm').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

        Promise
            .all([

            ])
            .then(() => {
                $('#editHargaJualModal').modal('show')
                getProductPesananJual()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
        initAutoNumericNoDoubleZero(form.find(`[name="hargajual"]`))
    }

    function addRowEditHargaJual(show = 0) {
        form = $('#detailEdit')
        if (detectDeviceType() == "desktop") {
            let tableHeader = $(`
                <th style="width: 50px; min-width: 50px;" >No.</th>
                <th style="width: 250px; min-width: 200px;">Produk</th>
                <th class="wider-hargajual" style="width: 120px; min-width: 150px;">Harga Jual</th>
            `);

            if (!show) {
                $('#detailEdit thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }

            let detailRow = $(`
                <tr data-trindex="${selectIndex}" >
                    <td  class="table-bold">
                    </td>
                    <td class="table-bold">
                    <input type="hidden" name="productid[]" class="form-control">
                        <input type="text" name="productnama[]" id="ItemEdit_Id${selectIndex}" class="form-control lg-form productedit-lookup${selectIndex}" autocomplete="off">
                    </td>
                    <td id="hargajual${selectIndex}" class="table-bold">
                        <input type="text" name="hargajual[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0">
                    </td>
                </tr>
            `)

            $('#detailEdit tbody').append(detailRow)
            initAutoNumeric(detailRow.find('.autonumeric'))
            initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
            clearButton(form, `#addRowEditHargaJual_${selectIndex}`)
            rowLookup = selectIndex
            setRowNumbersEdit()
            selectIndex++

        } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
                <th style="width: 500px; min-width: 250px;">No.</th>
                <th style="width: 250px; min-width: 200px;">Customer</th>
                <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
                <th class="wider-hargajual text-right" style="width: 120px; min-width: 150px;">Harga Jual</th>
                <th class="wider-hargabeli text-right" style="width: 120px; min-width: 150px;">Harga Beli</th>
            `);

            $(".wider-qty").remove();
            if (!show) {
                $('#detailEdit thead tr').prepend(tableHeader);
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
                                <input type="text" name="hargajual[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>

                                <div class="col-6">
                                <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">HARGA BELI</label>
                                <input type="text" name="hargabeli[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr> `)

                detailRow.on('input', 'input[name="hargajual[]"]', function() {
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

                $('#detailEdit tbody').append(detailRow)
                clearButton(form, `#addRowEditHargaJual_${selectIndex}`)
                initDatepicker()
                rowLookup = selectIndex
                selectIndex++
            }
            initAutoNumeric($('#detailEdit').find('.autonumeric'))
            initAutoNumericNoDoubleZero($('#detailEdit').find('.autonumeric-nozero'))
        }
    }

    function getProductPesananJual() {
        $.ajax({
            url: `${apiUrl}pesananfinalheader/cekproductpesanan`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                // tglpengirimanjual: $('#editHargaJualForm').find('[id=tglpengirimanjual]').val(),
                id: selectedRows
            },
            success: response => {
                $('#detailEdit tbody').html('')
                $.each(response, (index, detail) => {
                    selectIndex = index;
                    let detailRow = $(`
                        <tr>
                        <td class="table-bold">
                        </td>
                        <td class="table-bold">
                            <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                            <input type="text" name="productnama[]" id="ProductEdit_Id${selectIndex}" class="form-control filled-row lg-form productedit-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off" >
                        </td>
                        <td id="hargajual" class="table-bold"> 
                            <input type="text" name="hargajual[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="0" autofocus >
                        </td>
                    </tr>`)
                    
                    $(document).on("keydown", '#editHargaJualForm input[type="text"]', function (event) {
                            let currentRowIndex = $(this).closest('tr').index();

                            switch (event.keyCode) {
                                case 9: // Tab key
                                    event.preventDefault();

                                    if (event.shiftKey) {
                                        // Shift + Tab: Move to the previous row
                                        moveFocusToRow(currentRowIndex - 1);
                                    } else {
                                        // Tab: Move to the next row
                                        moveFocusToRow(currentRowIndex + 1);
                                    }
                                    break;

                                case 38: // Up arrow key
                                    event.preventDefault();
                                    moveFocusToRow(currentRowIndex - 1);
                                    break;

                                case 40: // Down arrow key
                                    event.preventDefault();
                                    moveFocusToRow(currentRowIndex + 1);
                                    break;
                            }
                        });

                        function moveFocusToRow(rowIndex) {
                            let targetRowInput = $('#detailEdit tbody tr:eq(' + rowIndex + ')').find('input[name="hargajual[]"]');

                            if (targetRowInput.length > 0) {
                                targetRowInput.focus();
                            }
                        }


                    detailRow.find(`[name="productid[]"]`).val(detail.productid)
                    detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                    detailRow.find(`[name="hargajual[]"]`).val(detail.hargajual)
                    initAutoNumericNoDoubleZero(detailRow.find(`[name="hargajual[]"]`))
                    // form.find(`[name="productnama[]"]`).prop('readonly', true).addClass('bg-white state-delete')

                    $('#detailEdit tbody').append(detailRow)
                    rowIndex = index
                    clearButton('detailEdit', `#detail_${index}`)
                    setRowNumbersEdit()
                })
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

    function setRowNumbersEdit() {
        let elements = $('#detailEdit tbody tr td:nth-child(1)')


        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }
</script>
@endpush()