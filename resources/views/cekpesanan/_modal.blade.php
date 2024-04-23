<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <input type="hidden" name="id" class="filled-row">
                        <div class="scroll-container overflow">
                            <div class="table-container">
                                <table class="table table-lookup table-bold table-bindkeys " id="detailList">
                                    <thead>
                                        <tr class="table-bold">
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-warning btn-cancel" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    $(document).ready(function() {
        $("#crudForm [name]").attr("autocomplete", "off");
        $('#nopo').focus();
        $(document).on('click', "#addRow", function() {
            addRow()
        });
        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = []
            let details = []

            $('#crudForm ').find(`.filled-row[name="qty[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="qty[]"]`)[index])
            })

            $.each(selectedRows, function(index, value) {
                data.push({
                    name: 'id[]',
                    value: value
                })
            })

            data.push({
                name: 'periode',
                value: $('#formCrud').find('[name=periode]').val()
            })

            let periode = $('#formCrud').find('[name=periode]').val()

            $.each(selectedRows, function(index, value) {
                element = `#crudForm tbody tr.${value}`;
                console.log($(element).find(`[name="qty[]"]`));
                details[value] = {
                    pesananfinalid: $(element).find(`[name="pesananfinalid[]"]`).val(),
                    pesananfinaldetailid: $(element).find(`[name="pesananfinaldetailid[]"]`).val(),
                    productid: $(element).find(`[name="productid[]"]`).val(),
                    customerid: $(element).find(`[name="customerid[]"]`).val(),
                    qty: AutoNumeric.getNumber($(element).find(`[name="qty[]"]`)[0]),
                    satuanid: $(element).find(`[name="satuanid[]"]`).val(),
                    keterangan: $(element).find(`[name="keterangan[]"]`).val(),
                    cekpesanandetail: $(element).find(`[name="cekpesanandetail[]"]`).val(),
                };
            })

            // Convert the array to an object with indices as keys
            const detail = details.reduce((acc, item, index) => {
                acc[index] = item;
                return acc;
            }, {});
            // Stringify the object
            const jsonString = JSON.stringify(detail);

            data.push({
                name: 'detail',
                value: jsonString
            })

            console.log(data)


            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}cekpesanan`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    id = response.data
                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    // $('#crudForm').find('[name=periode]').val(dateFormat(response.data.tglpengiriman)).trigger('change');

                    selectedRows = []
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            periode: periode,
                        }
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

    $('#crudModal').on('shown.bs.modal', () => {
        var crudModal = $('#crudModal')
        let form = $('#crudForm')
        setFormBindKeys(form)
        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }

    });
    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        selectedRows = []
        selectedRowsDetailCek = []
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function cekPesanan() {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        Promise
            .all([
                showCekPesanan(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                disabledDetail($('#detailList'))
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')
        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function disabledDetail(detail) {
        detail.find(`[name="pesananfinalid[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="pesananfinalnobukti[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="satuanid[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="satuannama[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="customerid[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="customernama[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="productid[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="productnama[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="qty[]"]`).prop('readonly', true).addClass('bg-white state-delete')

        $('#crudForm').find(`.delete-row`).prop('disabled', true);
    }

    function showCekPesanan(form) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}cekpesanan`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data : {
                    periode : $('#formCrud').find('[name=periode]').val()
                },
                success: response => {
                    console.log(response)

                    $('#detailList tbody').html('')

                    if (detectDeviceType() == "desktop") {

                        let tableHeader = $(`
                            <th style="width: 2%;">No.</th>
                            <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                            <th style="width: 250px; min-width: 200px;">No Bukti Pesanan Final</th>
                            <th style="width: 250px; min-width: 200px;">Customer</th>
                            <th style="width: 250px; min-width: 350px;">Produk</th>
                            <th class="wider-qty" style="width: 120px; min-width: 200px;">Qty</th>
                            <th class="wider-satuan" style="width: 170px; min-width: 200px;">Satuan</th>
                            <th class="wider-keterangan" style="width: 300px; min-width: 600px;">Keterangan</th>
                        `);

                        console.log(response.data.length);
                        // Sisipkan elemen <th> di awal baris
                        $('#detailList thead tr').prepend(tableHeader);

                        if (response.data.length === 0) {
                            $('#detailList tbody').append('<tr><td colspan="8" style="text-align:center;" >No data available</td></tr>');
                        } else{
                            $.each(response.data, (index, detail) => {
                                selectIndex = index;
                                let detailRow = $(`
                                    <tr class='${detail.id}'>
                                    <td class="table-bold">
                                        
                                    </td>
                                    <td class="table-bold">
                                        <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="pesananfinalid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="hidden" name="pesananfinaldetailid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="pesananfinalnobukti[]" id="pesananfinalId_${selectIndex}" class="form-control lg-form" data-current-value="${detail.pesananfinalnobukti}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="customerid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form" data-current-value="${detail.customernama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form" data-current-value="${detail.productnama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qty[]" class="form-control lg-form autonumeric " autocomplete="off" ">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form " data-current-value="${detail.satuannama}"  autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="cekpesanandetail[]" class="form-control lg-form" autocomplete="off">
                                        <input type="text" name="keterangan[]" class="form-control lg-form" autocomplete="off">
                                    </td>
                                </tr>`)


                                detailRow.find(`[name="check[]"]`).val(detail.id)
                                detailRow.find(`[name="cekpesanandetail[]"]`).val(detail.cekpesanandetail)
                                detailRow.find(`[name="pesananfinaldetailid[]"]`).val(detail.pesananfinaldetailid)
                                detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
                                detailRow.find(`[name="customerid[]"]`).val(detail.customerid)
                                detailRow.find(`[name="customernama[]"]`).val(detail.customernama)
                                detailRow.find(`[name="productid[]"]`).val(detail.productid)
                                detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                                detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                                detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                                detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid)
                                detailRow.find(`[name="pesananfinalnobukti[]"]`).val(detail.pesananfinalnobukti)
                                detailRow.find(`[name="qty[]"]`).val(detail.qty)

                                if (detail.cekpesanandetail != null) {
                                    selectedRows.push(detail.id)
                                    detailRow.find(`[name="check[]"]`).attr('checked', true)
                                }   

                                initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                                $('#detailList tbody').append(detailRow)
                                rowIndex = index
                                initDatepicker()
                                form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                                initLookupDetail(rowIndex);
                                clearButton('detailList', `#detail_${index}`)
                                setRowNumbers()
                            })
                        }
                       

                    } else if (detectDeviceType() == "mobile") {
                        let tableHeader = $(`
                            <th style="width: 50px; min-width: 50px;"><input type="checkbox" id="selectAllCheckbox" class="checkbox-table" onchange="handlerSelectAll(this)"></th>
                            <th style="width: 500px; min-width: 250px;">No. &ensp;Produk</th>
                        `);

                        // Sisipkan elemen <th> di awal baris
                        $('#detailList thead tr').prepend(tableHeader);
                        
                        if (response.data.length === 0) {
                            $('#detailList tbody').append('<tr><td colspan="2" style="text-align:center;" >No data available</td></tr>');
                        } else{
                        $.each(response.data, (index, detail) => {
                            selectIndex = index;

                            let detailRow = $(`
                                    <tr class='${detail.id}'>
                                        <td class="table-checkbox-first">
                                            <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)" >
                                        </td>
                                        <td class="table-checkbox">
                                        <label class="col-form-label mt-2">${index+1}. &ensp; Customer</label>
                                        <input type="hidden" name="pesananfinalid[]" class="form-control detail_stok_${selectIndex}">
                                            <input type="hidden" name="customerid[]" class="form-control detail_stok_${selectIndex}">
                                            <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form customer-lookup${selectIndex}" autocomplete="off">

                                            <label class="col-form-label mt-2"> Produk</label>
                                            <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                                            <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">

                                            <label class="col-form-label mt-2">QTY </label>
                                            <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off">

                                         

                                            <div class="d-flex align-items-center">
                                                <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <label class="col-form-label" style="min-width: 100px;">Satuan </label>
                                                        <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" style="width: 50%!important;" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="col-form-label">KETERANGAN</label>
                                                    <input type="text" name="keterangan[]" class="form-control lg-form" autocomplete="off">
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                `);

                            detailRow.find(`[name="check[]"]`).val(detail.id)
                            detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
                            detailRow.find(`[name="customerid[]"]`).val(detail.customerid)
                            detailRow.find(`[name="customernama[]"]`).val(detail.customernama)
                            detailRow.find(`[name="productid[]"]`).val(detail.productid)
                            detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                            detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                            detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                            detailRow.find(`[name="qty[]"]`).val(detail.qty)
                            detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid)

                            if (detail.cekpesanandetail != null) {
                                    selectedRows.push(detail.id)
                                    detailRow.find(`[name="check[]"]`).attr('checked', true)
                            }

                            $('#detailList tbody').append(detailRow)
                            rowIndex = index
                            initAutoNumeric(detailRow.find('.autonumeric'))
                            initDatepicker()
                            form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                            initLookupDetail(rowIndex);
                            form.find(`[name="tglpengiriman"]`).attr('disabled', 'disabled').addClass('bg-white state-delete')
                            clearButton('detailList', `#detail_${index}`)
                        })
                        }
                    }
                    // selectIndex += 1;

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function initLookupDetail(index) {
        let rowLookup = index;

        // $(`.item-lookup${rowLookup}`).lookup({
        //     title: 'Item Lookup',
        //     fileName: 'product',
        //     detail: true,
        //     miniSize: true,
        //     beforeProcess: function() {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: `ItemId_${index}`,
        //             id: `ItemId_${rowLookup}`,
        //             searchText: `item-lookup${rowLookup}`,
        //             singleColumn: true,
        //             hideLabel: true,
        //             title: 'Produk',
        //             customerid: $('#crudForm').find('[name=customerid]').val(),
        //         };
        //     },
        //     onSelectRow: (item, element) => {

        //         let item_id_input = element.parents('td').find(`[name="productid[]"]`);

        //         element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
        //         element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)

        //         // element.parents('tr').find('td [name="harga[]"]').val(item.hargajual)
        //         if (detectDeviceType() == "desktop") {

        //             element.parents('tr').find(`td [name="harga[]"]`).remove();
        //             element.parents('tr').find(`td [name="totalharga[]"]`).remove();

        //             let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`
        //             let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`


        //             element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
        //             element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)

        //         } else {
        //             let elementharga = element.parents('tr')

        //             elementharga.find(`[name="harga[]"]`).remove();
        //             $(`<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`).insertAfter(`#harga${rowLookup}`)

        //             element.parents('tr')

        //         }
        //         initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
        //         element.parents('tr').find('td [name="satuanid[]"]').addClass('filled-row')
        //         element.parents('tr').find('td [name="satuannama[]"]').addClass('filled-row')
        //         element.parents('tr').find('td [name="harga[]"]').addClass('filled-row')

        //         element.parents('tr').find('td [name="qty[]"]').focus()

        //         item_id_input.val(item.id);
        //         element.val(item.nama);
        //         element.addClass('filled-row')
        //         item_id_input.addClass('filled-row')

        //         setTotalHarga(element)

        //         setSubTotal()
        //         // setTotal()

        //         element.data('currentValue', element.val());
        //         element.parents('tr').find('td [name="satuannama[]"]').data('currentValue', element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama))

        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'));
        //     },
        //     onClear: (element) => {
        //         let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
        //         item_id_input.val('');
        //         element.val('');
        //         // element.parents('tr').find('td [name="harga[]"]').val(0)
        //         // element.parents('tr').find('td [name="harga[]"]').autoNumeric('wipe')

        //         if (detectDeviceType() == "desktop") {
        //             element.parents('tr').find(`td [name="harga[]"]`).remove();
        //             element.parents('tr').find(`td [name="totalharga[]"]`).remove();
        //             let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`
        //             let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`

        //             element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
        //             element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)
        //         } else {
        //             // let elementharga = $('#detailList tbody tr td')

        //             element.parents('td').find(`[name="harga[]"]`).remove();
        //             element.parents('td').find(`[name="totalharga[]"]`).remove();
        //             $(`<input type="text" name="harga[]" class="form-control autonumeric" value="0">`).insertAfter(`#harga${rowLookup}`)
        //             $(`<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`).insertAfter(`#total${rowLookup}`)

        //         }

        //         initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))

        //         element.data('currentValue', element.val());
        //     },
        // });

        // $(`.satuan-lookup${rowLookup}`).lookup({
        //     title: 'Satuan Lookup',
        //     fileName: 'satuan',
        //     detail: true,
        //     miniSize: true,
        //     rowIndex: rowLookup,
        //     totalRow: 49,
        //     alignRightMobile: true,
        //     searching: 1,
        //     beforeProcess: function() {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 1,
        //             valueName: `satuanId_${index}`,
        //             id: `SatuanId_${rowLookup}`,
        //             searchText: `satuan-lookup${rowLookup}`,
        //             singleColumn: true,
        //             hideLabel: true,
        //             title: 'Satuan',
        //             limit: 0
        //         };
        //     },
        //     onSelectRow: (satuan, element) => {

        //         let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`);


        //         satuan_id_input.val(satuan.id);

        //         element.val(satuan.nama);

        //         element.addClass('filled-row')
        //         satuan_id_input.addClass('filled-row')
        //         element.data('currentValue', element.val());
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'));
        //     },
        //     onClear: (element) => {
        //         let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`).first();
        //         satuan_id_input.val('');
        //         element.val('');
        //         element.data('currentValue', element.val());
        //     },
        // });

        // $(`.customer-lookup${rowLookup}`).lookup({
        //     title: 'customer Lookup',
        //     fileName: 'customer',
        //     detail: true,
        //     miniSize: true,
        //     rowIndex: rowLookup,
        //     totalRow: 49,
        //     alignRightMobile: true,
        //     searching: 2,
        //     beforeProcess: function() {
        //         this.postData = {
        //             Aktif: 'AKTIF',
        //             searching: 2,
        //             valueName: 'customer_id',
        //             searchText: 'customer-lookup',
        //             singleColumn: true,
        //             hideLabel: true,
        //             title: 'Customer',
        //             // typeSearch: 'ALL',
        //         }
        //     },
        //     onSelectRow: (customer, element) => {
        //         $('#crudForm [name=customerid]').first().val(customer.id)

        //         $('#crudForm [name=alamatpengiriman]').first().val(customer.alamat)
        //         element.val(customer.nama)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=customerid]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })
    }
</script>
@endpush()