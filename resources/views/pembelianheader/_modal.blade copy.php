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
                                    supplier <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supplierid" class="filled-row">
                                <input type="text" name="suppliernama" id="suppliernama" class="form-control lg-form supplier-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    karyawan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="karyawanid" class="filled-row">
                                <input type="text" name="karyawannama" id="karyawannama" class="form-control lg-form karyawan-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl terima<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglterima" id="tglterima" class="form-control lg-form datepicker filled-row">
                                </div>
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
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="status" class="filled-row">
                                <input type="text" name="statusnama" id="statusnama" class="form-control lg-form status-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="overflow  scroll-container mb-2">
                            <div class="table-container">
                                <table class="table table-lookup table-bold table-bindkeys " id="detailList">
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="10">
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-10 text-lg-right">
                                                        <label class="col-form-label ">
                                                            subtotal
                                                        </label>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <input type="text" name="subtotal" id="subtotal" class="form-control  text-right lg-form filled-row" value="0">
                                                        {{-- <p class="text-right font-weight-bold " id="subtotal">0</p> --}}
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-10 text-lg-right">
                                                        <label class="col-form-label">
                                                            potongan
                                                        </label>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <input type="text" name="potongan" id="potongan" class="form-control  text-right lg-form filled-row" value="0">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-10 text-lg-right">
                                                        <label class="col-form-label">
                                                            total
                                                        </label>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <input type="text" name="grandtotal" id="grandtotal" class="form-control  text-right lg-form filled-row" value="0">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                          <button class="btn btn-warning btn-cancel btn-batal" >
              <i class="fa fa-times"></i>
              Tutup            </button>
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
            setTotalDetail($(this))
            setSubTotal()
            setGrandTotal()
        })

        $(document).on('input', `#table_body [name="harga[]"]`, function(event) {
            setTotalDetail($(this))
            setSubTotal()
            setGrandTotal()
        })

        $(document).on('input', `#crudForm [name="potongan"]`, function(event) {
            setGrandTotal()
        })

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#crudForm').data('action') == 'edit') {

                console.log($('#crudForm').find('.filled-row[name=id]').val())

                $.ajax({
                url: `{{ config('app.api_url') }}pembelianheader/editingat`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    id: $('#crudForm').find('[name=id]').val(),
                    btn: 'batal'
                },
                success: response => {
                    $("#crudModal").modal("hide")
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
            } else {
                $("#crudModal").modal("hide")
            }
         })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm .filled-row').serializeArray()

            $('#crudForm tbody tr.filled-row').each(function (index, element) {

            if ($(this).hasClass('filled-row')) {

                let row_index = $(this).index();
                data.push({
                    name: `productid[${row_index}]`,
                    value: $(this).find(`[name="productid[]"]`).val()
                })
                data.push({
                    name: `customerid[${row_index}]`,
                    value: $(this).find(`[name="customerid[]"]`).val()
                })
                data.push({
                    name: `customernama[${row_index}]`,
                    value: $(this).find(`[name="customernama[]"]`).val()
                })
                data.push({
                    name: `productnama[${row_index}]`,
                    value: $(this).find(`[name="productnama[]"]`).val()
                })
                data.push({
                    name: `qty[${row_index}]`,
                    value: parseFloat($(this).find(`[name="qty[]"]`).val().replace(/,/g, ''))
                })
                data.push({
                    name: `satuanid[${row_index}]`,
                    value: $(this).find(`[name="satuanid[]"]`).val()
                })
                data.push({
                    name: `satuannama[${row_index}]`,
                    value: $(this).find(`[name="satuannama[]"]`).val()
                })
                data.push({
                    name: `keterangandetail[${row_index}]`,
                    value: $(this).find(`[name="keterangandetail[]"]`).val()
                })
                data.push({
                    name: `qtyretur[${row_index}]`,
                    value: parseFloat($(this).find(`[name="qtyretur[]"]`).val().replace(/,/g, ''))
                })
                data.push({
                    name: `stok[${row_index}]`,
                    value: parseFloat($(this).find(`[name="stok[]"]`).val().replace(/,/g, ''))
                })
                data.push({
                    name: `harga[${row_index}]`,
                    value: parseFloat($(this).find(`[name="harga[]"]`).val().replace(/,/g, ''))
                })
                data.push({
                    name: `pesananfinalid[${row_index}]`,
                    value: parseFloat($(this).find(`[name="pesananfinalid[]"]`).val().replace(/,/g, ''))
                })
            }
            })

            $('#crudForm ').find(`.filled-row[name="qty[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="qty[]"]`)[index])
            })

            $('#crudForm ').find(`.filled-row[name="qtyretur[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'qtyretur[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="qtyretur[]"]`)[index])
            })

            $('#crudForm ').find(`.filled-row[name="stok[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'stok[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="stok[]"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="harga[]"]`).each((index, element) => {
                data.filter((row) => row.name === 'harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="harga[]"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="subtotal"]`).each((index, element) => {
                data.filter((row) => row.name === 'subtotal')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="subtotal"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="potongan"]`).each((index, element) => {
                data.filter((row) => row.name === 'potongan')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="potongan"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="grandtotal"]`).each((index, element) => {
                data.filter((row) => row.name === 'grandtotal')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="grandtotal"]`)[index])
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

            data.push({
                name: 'periode',
                value: $('#formCrud').find('[name=periode]').val()
            })

            let periode = $('#formCrud').find('[name=periode]').val()

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pembelianheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pembelianheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pembelianheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pembelianheader`
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

                    $('#crudForm').find('[name=periode]').val(dateFormat(response.data.tglpengiriman)).trigger('change');
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            periode: periode,
                            tgldari: dateFormat(response.data.tgldariheader),
                            tglsampai: dateFormat(response.data.tglsampaiheader)
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

        initLookup()
        getMaxLength(form)
        initDatepicker()


    });

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function createPembelianHeader() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        $('#crudModalTitle').text('create pembelian')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
        form.data('action', 'add')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')
        $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglterima]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                showDefault(form),
                setStatusOptions(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                addRow()
                form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                form.find(`[name="nobukti"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                setDefault(form)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

        initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
    }

    var SetDefaultValue;

    function setDefault(form) {
        $.each(SetDefaultValue, (index, value) => {

            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
                element.val(value).trigger('change')
            } else {
                element.val(value)
            }

            if (index == 'statusnama') {
                element.val(value)
            }

            if (index == 'statusnama') {
                element.data('current-value', value)
            }
        })
    }

    function enableLookup() {
        let suppliernama = $('#crudForm').find(`[name="suppliernama"]`).parents('.input-group').children()
        suppliernama.find(`.lookup-toggler`).attr("disabled", true);
        suppliernama.find(`.button-clear`).attr("disabled", true);
        suppliernama.prop('readonly', true)
    }

    function editingAt(id, btn) {
        return new Promise((resolve, reject) => {
        $.ajax({
            url: `{{ config('app.api_url') }}pembelianheader/editingat`,
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

    function editPembelianHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('edit pembelian')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                editingAt(id, 'EDIT'),
            ])
            .then(() => {
                showPembelianHeader(form, id)
                    .then((response) => {
                        $('#crudModal').modal('show')
                        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        form.find(`[name="nobukti"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                        initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
                        setGrandTotal()
                        enableLookup()
                      
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

    function disabledDetail(detail) {
        detail.find(`[name="customerid[]"]`).prop('readonly', true)
        detail.find(`[name="customernama[]"]`).prop('readonly', true)
        detail.find(`[name="productnama[]"]`).prop('readonly', true)
        detail.find(`[name="productid[]"]`).prop('readonly', true)
        detail.find(`[name="satuanid[]"]`).prop('readonly', true)
        detail.find(`[name="satuannama[]"]`).prop('readonly', true)
        detail.find(`[name="qty[]"]`).prop('readonly', true)
        detail.find(`[name="harga[]"]`).prop('readonly', true)
        detail.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        detail.find(`[name="stok[]"]`).prop('readonly', true)
        detail.find(`[name="keterangandetail[]"]`).prop('readonly', true)



        let productnama = $(`#crudForm [name="productnama[]"]`)
        productnama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
        productnama.parent('.input-group').find('.button-clear').prop('disabled', true);

        let satuannama = $(`#crudForm [name="satuannama[]"]`)
        satuannama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
        satuannama.parent('.input-group').find('.button-clear').prop('disabled', true);

        let customernama = $(`#crudForm [name="customernama[]"]`)
        customernama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
        customernama.parent('.input-group').find('.button-clear').prop('disabled', true);

        $('#crudForm').find(`.delete-row`).prop('disabled', true);
    }

    function deletePembelianHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('delete pembelian')
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
                showPembelianHeader(form, id),
                setStatusOptions(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })


    }

    const setStatusOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=status]').empty()
            relatedForm.find('[name=status]').append(
                new Option('-- PILIH STATUS --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: "STATUS",
                    subgrp: "STATUS"
                },
                success: response => {
                    response.data.forEach(status => {
                        let option = new Option(status.text, status.id)

                        relatedForm.find('[name=status]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function viewPembelianHeader(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('view pembelian')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPembelianHeader(form, userId)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                form.find(`.tbl_aksi`).hide()

                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
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

    function setSubTotal() {
        let nominalDetails = $(`#detailList [name="totalharga[]"]`)
      
        let subtotal = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            subtotal += AutoNumeric.getNumber(nominalDetail)
        });
        initAutoNumericNoDoubleZero($(`#crudForm [name="subtotal"]`).val(subtotal))
    }

    function setGrandTotal() {
        let grandtotal;
        let subtotal = AutoNumeric.getNumber($(`#crudForm .filled-row[name="subtotal"]`)[0])
        let potongan = AutoNumeric.getNumber($(`#crudForm .filled-row[name="potongan"]`)[0])

        grandtotal = subtotal - potongan

        initAutoNumericNoDoubleZero($(`#crudForm [name="grandtotal"]`).val(grandtotal))
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}pembelianheader/field_length`,
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
                    })
                    form.attr('has-maxlength', true)
                },
                error: error => {
                    showDialog(error.statusText)
                }
            })
        }
    }

    function showPembelianHeader(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}pembelianheader/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            if (response.data.suppliernama !== null) {
                                let newOption = new Option(response.data.suppliernama, value);
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
                                        $('.select2-search__field').val(response.data.suppliernama).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'suppliernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'karyawannama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusnama') {
                            element.data('current-value', value)
                        }
                    })

                    $('#detailList tbody').html('')

                    if (detectDeviceType() == "desktop") {
                        let tableHeader = $(`
                            <th style="width: 50px; min-width: 50px;">No.</th>
                            <th style="width: 250px; min-width: 250px;">Customer</th>
                            <th style="width: 250px; min-width: 250px;">Produk</th>
                            <th class="wider-qty" style="width: 225px; min-width: 150px;">Qty</th>
                            <th style="width: 225px; min-width: 200px;">Satuan</th>
                            <th class="wider-harga" style="width: 225px; min-width: 150px; text-align:right">Harga</th>
                            <th class="wider-totalharga" style="width: 225px; min-width: 200px;">Total</th>
                            <th class="wider-qtyretur" style="width: 225px; min-width: 150px;">Qty Retur</th>
                            <th class="wider-stok" style="width: 225px; min-width: 150px;">Stok</th>
                            <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan</th>
                            <th width="1%" class="tbl_aksi">Aksi</th>
                        `);
                        // Sisipkan elemen <th> di awal baris
                        $('#detailList thead tr').prepend(tableHeader);
                        $.each(response.detail, (index, detail) => {
                            selectIndex = index;
                            let detailRow = $(`
                                <tr>
                                    <td class="table-bold">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="customerid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control filled-row lg-form customer-lookup${selectIndex}" data-current-value="${detail.customernama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control filled-row lg-form item-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric-nozero " autocomplete="off" value="0">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="totalharga[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" value="0">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="qtyretur[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="stok[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="keterangandetail[]" class="form-control filled-row lg-form " autocomplete="off" >
                                        <input type="text" name="pesananfinalid[]" class="form-control filled-row lg-form " value="0" autocomplete="off" hidden >
                                    </td>
                                    
                                    <td class="tbl_aksi table-bold">
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                                    </td>
                                </tr>`)

                            detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
                            detailRow.find(`[name="productid[]"]`).val(detail.productid)
                            detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                            detailRow.find(`[name="qty[]"]`).val(detail.qty)
                            detailRow.find(`[name="qtyretur[]"]`).val(detail.qtyretur)
                            detailRow.find(`[name="stok[]"]`).val(detail.stok)
                            detailRow.find(`[name="harga[]"]`).val(detail.harga)
                            detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)
                            detailRow.find(`[name="customerid[]"]`).val(detail.customerid)
                            detailRow.find(`[name="customernama[]"]`).val(detail.customernama)
                            detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                            detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                            detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) != undefined ? detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) : 0;

                            initAutoNumeric(detailRow.find(`[name="qty[]"]`))
                            initAutoNumeric(detailRow.find(`[name="qtyretur[]"]`))
                            initAutoNumeric(detailRow.find(`[name="stok[]"]`))
                            initAutoNumericNoDoubleZero(detailRow.find(`[name="harga[]"]`))
                            initAutoNumericNoDoubleZero(detailRow.find(`[name="totalharga[]"]`))
                            
                            // Jika baris diisi, tambahkan kelas 'filled-row'
               detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="customernama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="satuannama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
                            HargaCek !== 0 ||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="keterangandetail[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //keterangan
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="harga[]"]', function() {
                setTotalHarga($(this))
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="totalharga[]"]', function() {

                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qtyretur[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="stok[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                            $('#detailList tbody').append(detailRow)

                            rowIndex = index

                            initDatepicker()
                            form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                            initLookupDetail(rowIndex);

                            clearButton('detailList', `#detail_${index}`)
                            setRowNumbers()

                        })
                        addRow(response.detail.length)

                    } else if (detectDeviceType() == "mobile") {
                        let tableHeader = $(`
                            <th style="width: 250px; min-width: 250px;">No. Produk</th>
                        `);
                        // Sisipkan elemen <th> di awal baris
                        $('#detailList thead tr').prepend(tableHeader);
                        $.each(response.detail, (index, detail) => {
                            selectIndex = index;

                            let detailRow = $(`
                                <tr>
                                    <td class="table-bold">
                                        <label class="col-form-label mt-2 label-mobile" style="font-size:13px">${index+1}. &ensp; customer</label>
                                        <input type="hidden" name="customerid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form customer-lookup${selectIndex}" data-current-value="${detail.customernama}" autocomplete="off">

                                        <label class="col-form-label mt-2 label-mobile" style="font-size:13px">product</label>
                                        <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2 label-mobile" style="font-size: 13px; min-width: 50px;">QTY</label>
                                                    <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off">
                                                </div>
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2 label-mobile" style="font-size: 13px; min-width: 50px;">Satuan</label>
                                                    <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY RETUR</label>
                                                    <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                                                </div>

                                                <div class="col-6">
                                                    <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">stok</label>
                                                    <input type="text" name="stok[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label" id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                                                    <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero filled-row text-right" autocomplete="off" >
                                                </div>

                                                <div class="col-6">
                                                    <label class="col-form-label" id="total${selectIndex}" style="font-size:13px">Total</label>
                                                    <input type="text" name="totalharga[]" class="form-control mb-2 lg-form autonumeric-nozero text-right filled-row " autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>

                                        <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                                        <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">
                                        <input type="text" name="pesananfinalid[]" class="form-control filled-row lg-form "  autocomplete="off" hidden >

                                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                                    </td>
                                </tr> `)

                            detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
                            detailRow.find(`[name="productid[]"]`).val(detail.productid)
                            detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                            detailRow.find(`[name="qty[]"]`).val(detail.qty)
                            detailRow.find(`[name="qtyretur[]"]`).val(detail.qtyretur)
                            detailRow.find(`[name="stok[]"]`).val(detail.stok)
                            detailRow.find(`[name="harga[]"]`).val(detail.harga)
                            detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)
                            detailRow.find(`[name="customerid[]"]`).val(detail.customerid)
                            detailRow.find(`[name="customernama[]"]`).val(detail.customernama)
                            detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) != undefined ? detailRow.find(`[name="pesananfinalid[]"]`).val(detail.pesananfinalid) : 0;
                            
                            // Jika baris diisi, tambahkan kelas 'filled-row'
               detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="customernama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="satuannama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
                            HargaCek !== 0 ||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="keterangandetail[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //keterangan
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="harga[]"]', function() {
                setTotalHarga($(this))
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="totalharga[]"]', function() {

                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                    detailRow.on('input', 'input[name="qtyretur[]"]', function() {
                        let value = $(this).val();

                        let currentRow = $(this).closest('tr');
                        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                        let qtyReturCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                        let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                        let isRowFilled = 
                                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                                qtycek !== 0 ||
                                qtyReturCek !== 0||
                                StokCek !== 0||
                                HargaCek !== 0||
                                TotalHargaCek !== 0;

                        if (isRowFilled) {
                        currentRow.addClass('filled-row');
                        } else {
                        currentRow.removeClass('filled-row');
                        }
                    });

                    detailRow.on('input', 'input[name="stok[]"]', function() {
                        let value = $(this).val();

                        let currentRow = $(this).closest('tr');
                        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                        let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                        let StokCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                        let isRowFilled = 
                                currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                                currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                                qtycek !== 0 ||
                                qtyReturCek !== 0||
                                StokCek !== 0||
                                HargaCek !== 0||
                                TotalHargaCek !== 0;

                        if (isRowFilled) {
                        currentRow.addClass('filled-row');
                        } else {
                        currentRow.removeClass('filled-row');
                        }
                    });

                            $('#detailList tbody').append(detailRow)
                            rowIndex = index
                            initDatepicker()
                            form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                            initLookupDetail(rowIndex);
                            clearButton('detailList', `#detail_${index}`)
                        })
                        addRow(response.detail.length)
                        form.find(`[name="subtotal"]`).val(response.data.subtotal)
                        form.find(`[name="potongan"]`).val(response.data.potongan)
                        form.find(`[name="grandtotal"]`).val(response.data.grandtotal)
                        initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))


                        // setTotalDetail()
                        setSubTotal()
                        setGrandTotal()
                    }

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

    let selectIndex = 0

    function addRow(show = 0) {
        form = $('#detailList')
        if (detectDeviceType() == "desktop") {
            let tableHeader = $(`
                <th style="width: 50px; min-width: 50px;">No.</th>
                <th style="width: 250px; min-width: 250px;">Customer</th>
                <th style="width: 250px; min-width: 250px;">Produk</th>
                <th class="wider-qty" style="width: 225px; min-width: 150px;">Qty</th>
                <th style="width: 225px; min-width: 200px;">Satuan</th>
                <th class="wider-harga" style="width: 225px; min-width: 150px;">Harga</th>
                <th class="wider-totalharga" style="width: 225px; min-width: 200px;">Total</th>
                <th class="wider-qtyretur" style="width: 225px; min-width: 150px;">Qty Retur</th>
                <th class="wider-stok" style="width: 225px; min-width: 150px;">Stok</th>
                <th class="wider-keterangan" style="width: 225px; min-width: 250px;">Keterangan</th>
                <th width="1%" class="tbl_aksi">Aksi</th>
            `);
            // Sisipkan elemen <th> di awal baris

            if (!show) {
                $('#detailList thead tr').prepend(tableHeader);
            } else {

                selectIndex = show
            }

            for (let i = show; i < 50; i++) {
                let detailRow = $(`
                    <tr>
                        <td class="table-bold">
                        </td>
                        <td class="table-bold">
                            <input type="hidden" name="customerid[]" class="form-control detail_stok_${selectIndex}">
                            <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form customer-lookup${selectIndex}" autocomplete="off">
                        </td>
                        <td class="table-bold">
                            <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                            <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
                        </td>
                        <td class="table-bold">
                            <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                        </td>
                        <td class="table-bold">
                            <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                            <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                        </td>
                        <td class="table-bold" id="harga${selectIndex}">
                            <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0">
                        </td>
                        <td class="table-bold" id="total${selectIndex}">
                            <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero " autocomplete="off" value="0">
                        </td>
                        <td class="table-bold">
                            <input type="text" name="qtyretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                        </td>
                        <td class="table-bold">
                            <input type="text" name="stok[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                        </td>
                        <td class="table-bold">
                            <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                            <input type="text" name="pesananfinalid[]" class="form-control lg-form " autocomplete="off" value="0" hidden >
                        </td>
                        <td class="tbl_aksi table-bold">
                            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                        </td>
                    </tr>
                `)

                tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
                detailRow.find(`[name="tglbukti[]"]`).val(tglbukti).trigger('change');

               // Jika baris diisi, tambahkan kelas 'filled-row'
               detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="customernama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="satuannama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
                            HargaCek !== 0 ||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="keterangandetail[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //keterangan
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="harga[]"]', function() {
                setTotalHarga($(this))
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="totalharga[]"]', function() {

                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qtyretur[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="stok[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                $('#detailList tbody').append(detailRow)
                initAutoNumeric(detailRow.find('.autonumeric'))
                initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
                clearButton(form, `#addRow_${selectIndex}`)
                rowLookup = selectIndex
                initLookupDetail(selectIndex);
                setRowNumbers()
                selectIndex++
            }
        } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
                <th style="width: 500px; min-width: 250px;">No. Produk</th>
            `);

            $(".wider-qty").remove();
            $(".wider-keterangan").remove();

            let newTfoot = $(`
                <tfoot>
                <tr>
                    <td colspan="9">
                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label ">
                                subtotal
                            </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="subtotal" id="subtotal" class="form-control  text-right lg-form filled-row" value="0">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-10 text-lg-right">
                                <label class="col-form-label">
                                    potongan
                                </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="potongan" id="potongan" class="form-control text-right lg-form filled-row" value="0">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-10 text-lg-right">
                                <label class="col-form-label">
                                    Total
                                </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="grandtotal" id="grandtotal" class="form-control autonumeric-nozero text-right lg-form filled-row" value="0">
                            </div>
                        </div>
                    </td>
                </tr>
                </tfoot>
            `);

            $('#detailList tfoot').replaceWith(newTfoot);
            if (!show) {
                $('#detailList thead tr').prepend(tableHeader);
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
                            <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form numeric customer-lookup${selectIndex}" autocomplete="off">

                            <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">produk</label>
                            <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                            <input type="text" name="product_name[]" id="ItemId_${selectIndex}" class="form-control lg-form numeric item-lookup${selectIndex}" autocomplete="off">
                            
                            <div class="d-flex align-items-center mt-2 mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label label-top label-mobile" style=" min-width: 25px;">QTY </label>
                                        <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="col-form-label label-mobile" style=" min-width: 50px;">SATUAN </label>
                                        <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}"  class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label mt-2 " style="font-size: 13px; min-width: 50px;">qty retur</label>
                                        <input type="text" name="qtyretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                        <div class="col-6">
                                        <label class="col-form-label mt-2 " >stok</label>
                                        <input type="text" name="stok[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                                        <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">Total</label>
                                        <input type="text" name="totalharga[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                                        <input type="text" name="pesananfinalid[]" class="form-control lg-form " autocomplete="off" value="0" hidden >
                                    </div>
                                </div>
                            </div>
                            <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                            <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">
                            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                        </td>
                    </tr> `)


                tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()

                detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="customernama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //produk nama
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="satuannama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
                            HargaCek !== 0 ||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="keterangandetail[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            value.trim() !== "" || //keterangan
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                });

                detailRow.on('input', 'input[name="harga[]"]', function() {
                setTotalHarga($(this))
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="totalharga[]"]', function() {

                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="qtyretur[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="stok[]"]', function() {
                    let value = $(this).val();

                    let currentRow = $(this).closest('tr');
                    let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                    let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                    let StokCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                    let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                    let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                    let isRowFilled = 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                    if (isRowFilled) {
                    currentRow.addClass('filled-row');
                    } else {
                    currentRow.removeClass('filled-row');
                    }
                });
                $('#detailList tbody').append(detailRow)
                initDatepicker()
                clearButton(form, `#addRow_${selectIndex}`)
                rowLookup = selectIndex
                initLookupDetail(selectIndex);
                selectIndex++
            }
            initAutoNumeric($('#detailList').find('.autonumeric'))
            initAutoNumericNoDoubleZero($('#detailList').find('.autonumeric-nozero'))

            if ($('#crudForm').data('action') != "edit") {
                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            }
        }
    }

    function initLookupDetail(index) {
        let rowLookup = index;

        $(`.item-lookup${rowLookup}`).lookup({
            title: 'Item Lookup',
            fileName: 'product',
            detail: true,
            miniSize: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    supplierid: $('#crudForm').find('[name="supplierid"]').val(),
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

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            valueItem.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                setTotalDetail(element)
                setSubTotal()

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

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            valueItem.trim() !== "" || //produk nama
                            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
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

        $(`.customer-lookup${rowLookup}`).lookup({
            title: 'customer Lookup',
            fileName: 'customer',
            typeSearch: 'ALL',
            detail: true,
            miniSize: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `CustomerId_${index}`,
                    id: `CustomerId_${rowLookup}`,
                    searchText: `customer-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Customer',
                    // typeSearch: 'ALL',
                }
            },
            onSelectRow: (customer, element) => {

                let customer_id_input = element.parents('td').find(`[name="customerid[]"]`);

                customer_id_input.val(customer.id);

                element.val(customer.nama);

                let customerValue = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            customerValue.trim() !== "" || 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }

                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                let customer_id_input = element.parents('td').find(`[name="customerid[]"]`).first();
                customer_id_input.val('');
                element.val('');

                let customerValue = $(element).val();

                let currentRow = $(element).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            customerValue.trim() !== "" || 
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="satuanama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0||
                            StokCek !== 0||
                            HargaCek !== 0||
                            TotalHargaCek !== 0;

                if (isRowFilled) {
                    currentRow.addClass('filled-row');
                } else {
                    currentRow.removeClass('filled-row');
                }
                
                element.data('currentValue', element.val());
            }
        });

        $(`.satuan-lookup${rowLookup}`).lookup({
            title: 'Satuan Lookup',
            fileName: 'satuan',
            detail: true,
            miniSize: true,
            rowIndex: rowLookup,
            totalRow: 49,
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

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            valueSatuan.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
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

                let qtyReturCek = (currentRow.find('input[name="qtyretur[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyretur[]"]').val().replace(/,/g, ''));
                let StokCek = (currentRow.find('input[name="stok[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="stok[]"]').val().replace(/,/g, ''));
                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled = 
                            valueSatuan.trim() !== "" || //satuan nama
                            currentRow.find(`input[name="customernama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                            qtycek !== 0 ||
                            qtyReturCek !== 0 ||
                            StokCek !== 0 ||
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

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pembelianheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)


                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
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

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}pembelianheader/${Id}/cekValidasiAksi`,
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
                        editPembelianHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePembelianHeader(Id)
                    }
                }

            }
        })
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function initLookup() {
        $(`.status-lookup`).lookup({
            title: 'Status Lookup',
            fileName: 'parameter',
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS',
                    subgrp: 'STATUS',
                    searching: 1,
                    valueName: `status`,
                    searchText: `status-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'status'
                };
            },
            onSelectRow: (status, element) => {

                $('#crudForm [name=status]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let status_id_input = element.parents('td').find(`[name="status"]`).first();
                status_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $('.supplier-lookup').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            typeSearch: 'ALL',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplier_id',
                    searchText: 'supplier-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Supplier',
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplierid]').first().val(supplier.id)
                element.val(supplier.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplierid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.karyawan-lookup').lookup({
            title: 'karyawan Lookup',
            fileName: 'karyawan',
            typeSearch: 'ALL',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'karyawan_id',
                    searchText: 'karyawan-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'karyawan',
                }
            },
            onSelectRow: (karyawan, element) => {
                $('#crudForm [name=karyawanid]').first().val(karyawan.id)
                element.val(karyawan.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=karyawanid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()