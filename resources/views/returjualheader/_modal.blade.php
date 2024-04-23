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
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    no bukti <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="nobukti" class="form-control lg-form filled-row" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl bukti<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" id="tglbukti" class="form-control lg-form datepicker filled-row" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    penjualan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="penjualanid" class="filled-row">
                                <input type="text" name="penjualannobukti" id="penjualannobukti" class="form-control lg-form penjualan-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    customer <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="customerid" class="filled-row">
                                <input type="text" name="customernama" id="customernama" class="form-control lg-form customer-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    keterangan
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="keterangan" id="keterangan" class="form-control lg-form filled-row">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    total
                                </label>
                            </div>
                            <div class="col-12 col-md-10 text-right">
                                <input type="text" name="total" id="total" class="form-control text-right lg-form filled-row" value="0">
                            </div>
                        </div>
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
                        <button class="btn btn-warning btn-cancel btn-batal" data-dismiss="modal">
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

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="qty[]"]`, function(event) {
            setMaxQty($(this))
            setTotalHarga($(this))
            setTotal()
        })

        $(document).on('input', `#table_body [name="harga[]"]`, function(event) {
            setTotalHarga($(this))
            setTotal()
        })

        // $(document).on('click', '.btn-batal', function(event) {
        //     event.preventDefault()
        //     if ($('#crudForm').data('action') == 'edit') {

        //         console.log($('#crudForm').find('.filled-row[name=id]').val())

        //         $.ajax({
        //             url: `{{ config('app.api_url') }}returjualaheader/editingat`,
        //             method: 'POST',
        //             dataType: 'JSON',
        //             headers: {
        //                 Authorization: `Bearer ${accessToken}`
        //             },
        //             data: {
        //                 id: $('#crudForm').find('[name=id]').val(),
        //                 btn: 'batal'
        //             },
        //             success: response => {
        //                 $("#crudModal").modal("hide")
        //             },
        //             error: error => {
        //                 if (error.status === 422) {
        //                     $('.is-invalid').removeClass('is-invalid')
        //                     $('.invalid-feedback').remove()

        //                     setErrorMessages(form, error.responseJSON.errors);
        //                 } else {
        //                     showDialog(error.responseJSON)
        //                 }
        //             },
        //         }).always(() => {
        //             $('#processingLoader').addClass('d-none')
        //             $(this).removeAttr('disabled')
        //         })
        //     } else {
        //         $("#crudModal").modal("hide")
        //     }
        // })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            // let data = $('#crudForm .filled-row').serializeArray()
            let data = []
            let details = []

            data.push({
                name: `nobukti`,
                value: form.find(`[name="nobukti"]`).val()
            })

            data.push({
                name: `tglbukti`,
                value: form.find(`[name="tglbukti"]`).val()
            })

            data.push({
                name: `penjualanid`,
                value: form.find(`[name="penjualanid"]`).val()
            })
            data.push({
                name: `penjualannobukti`,
                value: form.find(`[name="penjualannobukti"]`).val()
            })

            data.push({
                name: `customerid`,
                value: form.find(`[name="customerid"]`).val()
            })

            data.push({
                name: `customernama`,
                value: form.find(`[name="customernama"]`).val()
            })

            data.push({
                name: `keterangan`,
                value: form.find(`[name="keterangan"]`).val()
            })

            data.push({
                name: `total`,
                value: parseFloat(form.find(`[name="total"]`).val().replace(/,/g, ''))
            })

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            $.each(selectedRows, function(index, value) {
                data.push({
                    name: 'productid[]',
                    value: value
                })
            })

            $.each(selectedRows, function(index, value) {   
                element = `#crudForm tbody tr.${value}`;
                details[value] = {
                    id: $(element).find(`[name="id[]"]`).val(),
                    // iddetail: $(element).find(`[name="iddetail[]"]`).val(),
                    productnama: $(element).find(`[name="productnama[]"]`).val(),
                    qty: AutoNumeric.getNumber($(element).find(`[name="qty[]"]`)[0]),
                    penjualandetailid: $(element).find(`[name="penjualandetailid[]"]`).val(),
                    pesananfinaldetailid: $(element).find(`[name="pesananfinaldetailid[]"]`).val(),
                    satuanid: $(element).find(`[name="satuanid[]"]`).val(),
                    satuannama: $(element).find(`[name="satuannama[]"]`).val(),
                    keterangandetail: $(element).find(`[name="keterangandetail[]"]`).val(),
                    harga: AutoNumeric.getNumber($(element).find(`[name="harga[]"]`)[0]),
                    totalharga: AutoNumeric.getNumber($(element).find(`[name="totalharga[]"]`)[0]),
                };
            });

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

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}returjualheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}returjualheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}returjualheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}returjualheader`
                    break;
            }
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    id = response.data.id
                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    periode = $('#crudForm').find('[name=periode]').val(dateFormat(response.data.tglpengiriman)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            tgldari: $('#tgldariheader').val(),
                            tglsampai: $('#tglsampaiheader').val()
                        }
                    }).trigger('reloadGrid');

                    if (id == 0) {
                        $('#detailGrid').jqGrid().trigger('reloadGrid')
                    }

                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
                    }
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessagesNew(form, error.responseJSON.errors);
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

        initLookup()
        initDatepicker()
    });

    $('#crudModal').on('hidden.bs.modal', () => {
        selectedRows = []
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function createReturJualHeader() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        $('#crudModalTitle').text('create Retur Jual')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
        form.data('action', 'add')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')
        $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                addRow()
                form.find(`[name="productnama[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="satuannama[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="qtypesanan[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="qty[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="harga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function editingAt(id, btn) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `{{ config('app.api_url') }}returjualheader/editingat`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    id: id,
                    btn: btn
                },
                success: response => {
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function editReturJualHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('edit retur jual')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                editingAt(id, 'EDIT'),
                getMaxLength(form)
            ])
            .then(() => {
                showReturJualHeader(form, id)
                    .then((response) => {
                        $('#crudModal').modal('show')
                        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        form.find('[name=penjualannobukti]').prop('readonly', true).addClass('bg-white state-delete')
                        form.find('[name=customernama]').prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find('[name=penjualannobukti]').parents('.input-group').find('.lookup-toggler').attr('disabled', true)
                        form.find('[name=customernama]').parents('.input-group').find('.lookup-toggler').attr('disabled', true)
                        form.find('[name=customernama]').parents('.input-group').find('.button-clear').attr('disabled', true)
                        form.find('[name=penjualannobukti]').parents('.input-group').find('.button-clear').attr('disabled', true)
                        initAutoNumericNoDoubleZero(form.find(`[name="total"]`))
                    })
            })
            .catch((error) => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    setErrorMessages(form, error.responseJSON.errors);
                } else {
                    showDialog(error.responseJSON)
                }
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteReturJualHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('delete Retur Jual')
        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
                  <i class="fa fa-save"></i>
                  Hapus
                `)
        form.find(`.sometimes`).hide()

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showReturJualHeader(form, id),
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function viewReturJualHeader(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('view Retur Jual')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showReturJualHeader(form, userId)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                form.find(`.tbl_aksi`).hide()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function setTotalDetail(element) {
        let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let harga = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
        let amount = qty * harga;
        initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(amount))
    }

    function setTotal() {
        let nominalDetails = $(`#detailList [name="totalharga[]"]`)
        let totaljual = 0
        $.each(nominalDetails, (index, nominalDetail) => {

            totaljual += AutoNumeric.getNumber(nominalDetail)
        });
        initAutoNumericNoDoubleZero($(`#crudForm [name="total"]`).val(totaljual))
    }

    function setMaxQty(element, id = 0) {
        let qtypesanan = parseFloat(element.parents('tr').find(` [name="qtypesanan[]"]`).val().replace(/,/g, ''))
        let qtysdhretur = parseFloat(element.parents('tr').find(` [name="qtysdhretur[]"]`).val().replace(/,/g, ''))
        let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let difference = qtypesanan - qtysdhretur;
        
        if (qty > difference) {1
            showDialog(`Qty tidak boleh lebih dari ${difference}`);
        }
    }

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}returjualheader/${Id}/cekvalidasiaksi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editReturJualHeader(Id)
                    }

                    if (Aksi == 'DELETE') {
                        deleteReturJualHeader(Id)
                    }
                }

            }
        })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
        return new Promise((resolve, reject) => {
            $.ajax({
            url: `${apiUrl}returjualheader/field_length`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            success: response => {
                $.each(response.data, (index, value) => {
                if (value !== null && value !== 0 && value !== undefined) {
                    form.find(`[name=${index}]`).attr('maxlength', value)
                }

                form.find(`[name=penjualannama]`).attr('maxlength', 100)
                form.find(`[name=customernama]`).attr('maxlength', 100)
                form.find(`[name=total]`).attr('maxlength', 18)
                
                })
                dataMaxLength = response.data
                form.attr('has-maxlength', true)
                resolve()
            },
            error: error => {
                showDialog(error.statusText)
                reject()
            }
            })
        })
        } else {

        return new Promise((resolve, reject) => {
            $.each(dataMaxLength, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
                form.find(`[name=${index}]`).attr('maxlength', value)
            }
            })
            resolve()
        })
        }
    }

    function showReturJualHeader(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}returjualheader/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        

                        if (element.is('select')) {
                            if (response.data.penjualannobukti !== null) {
                                let newOption = new Option(response.data.penjualannobukti, value);
                                element.append(newOption);
                                element.val(value);
                                element.trigger('change');
                                element.on('select2:open', function() {

                                    setTimeout(function() {
                                        $(".select2-search__field").focus();
                                    }, 50);
                                })

                                element.on('select2:opening', function() {
                                    setTimeout(function() {
                                        $('.select2-search__field').val(response.data.penjualannobukti).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'penjualannobukti') {
                            element.data('current-value', value)
                        }
                    })

                    $('#detailList tbody').html('')

                    let penjualandetailId;
                    response.detail.forEach(detail => {
                        penjualandetailId = detail.penjualandetailid;
                    })

                    getEditPenjualanDetails(response.data.id, response.data.penjualanid, penjualandetailId)

                    // $('#detailList tbody').find('input[type="text"]').prop('readonly',true)
                    selectIndex += 1;

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve(response)
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function getEditPenjualanDetails(id, penjualanid, penjualandetailId) {
        $.ajax({
            url: `${apiUrl}returjualheader/geteditpenjualandetail`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id : id,
                penjualanid : penjualanid,
                penjualandetailid : penjualandetailId,
            },
            success: response => {
                if (response.data.length > 0) {
                    $('#detailList tbody').html('')

                    if (detectDeviceType() == "desktop") {

                        let tableHeader = $(`
                            <th style="width: 50px; min-width: 50px;">No.</th>
                            <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                            <th style="width: 250px; min-width: 250px;">Produk</th>
                            <th style="width: 225px; min-width: 200px;">Satuan</th>
                            <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Pesanan</th>
                            <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Sudah Retur</th>
                            <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Retur</th>
                            <th class="wider-harga" style="width: 225px; min-width: 150px; text-align:right">Harga</th>
                            <th class="wider-totalharga" style="width: 225px; min-width: 200px; text-align:right">Total</th>
                            <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan</th>
                        `);
                        // Sisipkan elemen <th> di awal baris
                        $('#detailList thead tr').prepend(tableHeader);

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
                                        <input type="hidden" name="id[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="hidden" name="iddetail[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="hidden" name="penjualandetailid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="hidden" name="productid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control filled-row lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="satuanid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qtypesanan[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" ">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qtysdhretur[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" ">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="harga[]" class="form-control filled-row lg-form autonumeric-nozero" autocomplete="off" >
                                        <input type="hidden" name="originalharga[]">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="totalharga[]" class="form-control filled-row lg-form autonumeric-nozero" autocomplete="off" >
                                        <input type="hidden" name="originaltotalharga[]">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="keterangandetail[]" class="form-control filled-row lg-form " autocomplete="off" >
                                    </td>
                                </tr>`)

                                // console.log(detail)
                            detailRow.find('input[type="text"]').prop('readonly',true).addClass('bg-white state-delete');
                            detailRow.find(`[name="iddetail[]"]`).val(detail.id)
                            detailRow.find(`[name="id[]"]`).val(detail.returjualid)
                            detailRow.find(`[name="check[]"]`).val(detail.productid)
                            detailRow.find(`[name="productid[]"]`).val(detail.id)
                            detailRow.find(`[name="penjualandetailid[]"]`).val(detail.penjualandetailid)
                            detailRow.find(`[name="pesananfinaldetailid[]"]`).val(detail.pesananfinaldetailid)
                            detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                            detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                            detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                            detailRow.find(`[name="qtypesanan[]"]`).val(detail.qtypesanan)
                            detailRow.find(`[name="qtysdhretur[]"]`).val(detail.qtysdhretur)
                            detailRow.find(`[name="qty[]"]`).val(detail.qty)
                            detailRow.find(`[name="harga[]"]`).val(detail.harga)
                            detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)

                            if (detail.returjualnobukti != null) {
                                selectedRows.push(detail.id)
                                detailRow.find(`[name="check[]"]`).attr('checked', true)
                            }

                            initAutoNumeric(detailRow.find(`[name="qtysdhretur[]"]`))
                            initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                            initAutoNumeric(detailRow.find(`[name="qtypesanan[]"]`))
                            initAutoNumericNoDoubleZero(detailRow.find(`[name="harga[]"]`))
                            initAutoNumericNoDoubleZero(detailRow.find(`[name="totalharga[]"]`))

                            $('#detailList tbody').append(detailRow)

                            rowIndex = index
                            initDatepicker()
                            clearButton('detailList', `#detail_${index}`)
                            setRowNumbers()
                        })
                    }
                    selectIndex += 1;
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

    let selectIndex = 0

    function addRow(show = 0) {
        form = $('#detailList')
        // if (detectDeviceType() == "desktop") {
            let tableHeader = $(`
                <th style="width: 50px; min-width: 50px;">No.</th>
                <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                <th style="width: 250px; min-width: 250px;">Produk</th>
                <th style="width: 225px; min-width: 200px;">Satuan</th>
                <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Pesanan</th>
                <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Sudah Retur</th>
                <th class="wider-qty" style="width: 225px; min-width: 150px; text-align:right">Qty Retur</th>
                <th class="wider-harga" style="width: 225px; min-width: 150px; text-align:right">Harga</th>
                <th class="wider-totalharga" style="width: 225px; min-width: 200px; text-align:right">Total</th>
                <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan</th>
            `);
            // Sisipkan elemen <th> di awal baris

            if (!show) {
                $('#detailList thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }

            let detailRow = $(`
                <tr>
                    <td class="table-bold">
                    </td>
                    <td class="table-bold">
                        <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                    </td>
                    <td class="table-bold">
                        <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
                    </td>
                    <td class="table-bold">
                        <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                    </td>
                    <td class="table-bold">
                        <input type="text" name="qtypesanan[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </td>
                    <td class="table-bold">
                        <input type="text" name="qtysdhretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </td>
                    <td class="table-bold">
                        <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </td>
                    <td class="table-bold" id="harga${selectIndex}">
                        <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0">
                    </td>
                    <td class="table-bold" id="total${selectIndex}">
                        <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0">
                    </td>
                    <td class="table-bold">
                        <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                </tr>
            `)

            $('#detailList tbody').append(detailRow)
            initAutoNumeric(detailRow.find('.autonumeric'))
            initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
            clearButton(form, `#addRow_${selectIndex}`)
            rowLookup = selectIndex
            initLookupDetail(selectIndex);
            setRowNumbers()
            selectIndex++

        // } else if (detectDeviceType() == "mobile") {
            // let tableHeader = $(`
            //     <th style="width: 500px; min-width: 250px;">No. Produk</th>
            // `);

            // $(".wider-qty").remove();
            // $(".wider-keterangan").remove();

            // $('#detailList tfoot').replaceWith(newTfoot);
            // if (!show) {
            //     $('#detailList thead tr').prepend(tableHeader);
            // } else {
            //     selectIndex = show
            // }

            // initAutoNumeric($('#detailList').find('.autonumeric'))
            // initAutoNumericNoDoubleZero($('#detailList').find('.autonumeric-nozero'))

            // if ($('#crudForm').data('action') != "edit") {
            //     initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
            //     initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
            //     initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            // }
        // }
    }

    function setTotalHarga(element, id = 0) {
        let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let harga = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))

        let amount = qty * harga;
        initAutoNumericNoDoubleZero(element.parents('tr').find(`[name="totalharga[]"]`).val(amount))
    }

    function getPenjualanDetails() {
        $.ajax({
            url: `${apiUrl}returjualheader/getpenjualandetail`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                penjualanid: $('#crudForm').find('[name=penjualanid]').val(),
            },
            success: response => {
                if (response.data.length > 0) {
                    $('#detailList tbody').html('')
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
                                <input type="hidden" name="penjualandetailid[]" class="form-control detail_stok_${selectIndex}">
                                <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
                            </td>
                            <td class="table-bold">
                                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="qtypesanan[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="qtysdhretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                            </td>
                            <td id="harga${selectIndex}" >
                                <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0">
                            </td>
                            <td id="totaljual${selectIndex}" >
                                <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0" >
                            </td>
                            <td class="table-bold">
                                <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                            </td>
                        </tr>`)

                        detailRow.find('input[type="text"]').prop('readonly',true).addClass('bg-white state-delete');

                        detailRow.find(`[name="check[]"]`).val(detail.id)
                        detailRow.find(`[name="productid[]"]`).val(detail.id)
                        detailRow.find(`[name="penjualandetailid[]"]`).val(detail.penjualandetailid)
                        detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                        detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                        detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                        detailRow.find(`[name="qtypesanan[]"]`).val(detail.qtypesanan)
                        detailRow.find(`[name="qtysdhretur[]"]`).val(detail.qtysdhretur)
                        detailRow.find(`[name="harga[]"]`).val(detail.harga)

                        initAutoNumeric(detailRow.find(`[name="qtypesanan[]"]`))
                        initAutoNumeric(detailRow.find(`[name="qtysdhretur[]"]`))
                        initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="harga[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="totalharga[]"]`))

                        $('#detailList tbody').append(detailRow)
                        rowIndex = index
                        clearButton('detailList', `#detail_${index}`)
                        setRowNumbers()

                    })
                } else {
                    addRow();
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

    function initLookupDetail(index) {
        let rowLookup = index;

        $(`.item-lookup${rowLookup}`).lookup({
            title: 'Item Lookup',
            fileName: 'product',
            detail: true,
            miniSize: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    // supplierid: $('#crudForm').find('[name="supplierid"]').val(),
                    searching: 1,
                    valueName: `ItemId_${index}`,
                    id: `ItemId_${rowLookup}`,
                    searchText: `item-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Produk',
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (item, element) => {

                let item_id_input = element.parents('td').find(`[name="productid[]"]`);

                element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
                element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)

                // element.parents('tr').find('td [name="harga[]"]').val(item.hargabeli)
                // element.parents('tr').find('td [name="harga[]"]').val(item.hargajual)
                if (detectDeviceType() == "desktop") {

                    element.parents('tr').find(`td [name="harga[]"]`).remove();
                    element.parents('tr').find(`td [name="totalharga[]"]`).remove();

                    let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`
                    let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric bg-white state-delete" value="0" readonly>`


                    element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
                    element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)

                    element.parents('tr').find(`#total${rowLookup}`).prop('readonly', true).addClass('bg-white state-delete')
                } else {
                    let elementharga = element.parents('tr')

                    elementharga.find(`[name="harga[]"]`).remove();
                    $(`<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`).insertAfter(`#harga${rowLookup}`)

                    element.parents('tr')

                }

                initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))

                element.parents('tr').find('td [name="qty[]"]').focus()

                item_id_input.val(item.id);

                element.val(item.nama);

                let valueItem = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                    valueItem.trim() !== "" || //produk nama
                    currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                    qtycek !== 0 ||
                    HargaCek !== 0 ||
                    TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                // setTotalDetail(element)
                // setSubTotal()

                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
                item_id_input.val('');
                element.val('');

                let valueItem = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                    valueItem.trim() !== "" || //produk nama
                    currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                    qtycek !== 0 ||
                    HargaCek !== 0 ||
                    TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                element.data('currentValue', element.val());

                initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
            },
        });

        $(`.satuan-lookup${rowLookup}`).lookup({
            title: 'Satuan Lookup',
            fileName: 'satuan',
            detail: true,
            miniSize: true,
            rowIndex: rowLookup,
            totalRow: 49,
            searching: 1,
            alignRightMobile: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `satuanId_${index}`,
                    id: `SatuanId_${rowLookup}`,
                    searchText: `satuan-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Satuan',
                };
            },
            onSelectRow: (satuan, element) => {

                let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`);


                satuan_id_input.val(satuan.id);

                element.val(satuan.nama);

                let valueSatuan = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                    valueSatuan.trim() !== "" || //satuan nama
                    currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                    qtycek !== 0 ||
                    HargaCek !== 0 ||
                    TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`).first();
                satuan_id_input.val('');
                element.val('');

                let valueSatuan = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                    valueSatuan.trim() !== "" || //satuan nama
                    currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                    qtycek !== 0 ||
                    HargaCek !== 0 ||
                    TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                element.data('currentValue', element.val());
            },
        });
    }

    function deleteRow(row) {
        if (row.siblings().length == 0) {
            noUrut = 1
            row.remove()
            addRow()
        } else {
            row.remove()

        }
        row.remove()

        if (detectDeviceType() == "desktop") {
            setRowNumbers()
            setSubTotal()
        } else {
            setSubTotal()
        }
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function initLookup() {
        $('.penjualan-lookup').lookup({
            title: 'penjualan Lookup',
            fileName: 'penjualan',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'penjualan_id',
                    searchText: 'penjualan-lookup',
                    singleColumn: true,
                    // hideLabel: false,
                    title: 'penjualan',
                }
            },
            onSelectRow: (penjualan, element) => {
                $('#crudForm [name=penjualanid]').first().val(penjualan.id)
                element.val(penjualan.nobukti)

                $('#crudForm [name=customerid]').first().val(penjualan.customerid)
                $('#crudForm [name=customernama]').first().val(penjualan.customernama)

                getPenjualanDetails()
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=penjualanid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })


        $('.customer-lookup').lookup({
            title: 'customer Lookup',
            fileName: 'customer',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'customer_id',
                    searchText: 'customer-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'customer',
                }
            },
            onSelectRow: (customer, element) => {
                $('#crudForm [name=customerid]').first().val(customer.id)
                element.val(customer.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=customerid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()