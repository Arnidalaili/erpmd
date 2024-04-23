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
                                    perkiraan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="perkiraanid" class="filled-row">
                                <input type="text" name="perkiraannama" id="perkiraannama" class="form-control lg-form perkiraan-lookup filled-row" autocomplete="off">
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
                                <label class="col-form-label ">
                                    nominal<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="nominal" id="nominal" class="form-control  text-right lg-form filled-row" value="0">
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


        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            // let data = $('#crudForm').serializeArray()
            let data = []

            data.push({
                name: `perkiraanid`,
                value: form.find(`[name="perkiraanid"]`).val()
            })

            data.push({
                name: `perkiraannama`,
                value: form.find(`[name="perkiraannama"]`).val()
            })

            data.push({
                name: `tglbukti`,
                value: form.find(`[name="tglbukti"]`).val()
            })

            data.push({
                name: `karyawanid`,
                value: form.find(`[name="karyawanid"]`).val()
            })

            data.push({
                name: `karyawannama`,
                value: form.find(`[name="karyawannama"]`).val()
            })

            data.push({
                name: `pembelianid`,
                value: form.find(`[name="pembelianid"]`).val()
            })

            data.push({
                name: `pembeliannobukti`,
                value: form.find(`[name="pembeliannobukti"]`).val()
            })

            data.push({
                name: `nominal`,
                value: AutoNumeric.getNumber(form.find(`[name="nominal"]`)[0])
            })

            data.push({
                name: `keterangan`,
                value: form.find(`[name="keterangan"]`).val()
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

            console.log(data)

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}transaksibelanja`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}transaksibelanja/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}transaksibelanja/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}transaksibelanja`
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
                   

                    selectedRows = []

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        // postData: {
                        //     tgldari: dateFormat(response.data.tgldariheader),
                        //     tglsampai: dateFormat(response.data.tglsampaiheader)
                        // }
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
        initDatepicker()
    });

    $('#crudModal').on('hidden.bs.modal', () => {
        selectedRows = []
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        initDatepicker('datepickerIndex')
    })

    function createTransaksiBelanja() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        $('#crudModalTitle').text('create transaksi belanja')
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
                showDefault(form),
                getMaxLength(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                // addRow()

                form.find('.ui-datepicker-trigger').prop('disabled', true)

                setDefault(form)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })

        initAutoNumericNoDoubleZero(form.find(`[name="nominal"]`))
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

            if (index == 'perkiraannama') {
                element.val(value)
            }

            if (index == 'perkiraannama') {
                element.data('current-value', value)
            }
        })
    }

    function editTransaksiBelanja(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'edit')
        form.trigger('reset')
        $('#crudModalTitle').text('edit transaksi belanja')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showTransaksiBelanja(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        initAutoNumericNoDoubleZero(form.find(`[name="nominal"]`))
                        form.find('.ui-datepicker-trigger').prop('disabled', true)
                    })
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deleteTransaksiBelanja(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('delete transaksi belanja')
        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)

        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Transaksi Belanja')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showTransaksiBelanja(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                        initAutoNumericNoDoubleZero(form.find(`[name="nominal"]`))
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function viewTransaksiBelanja(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Transaksi Belanja')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                ShowTransaksiBelanja(form, userId)
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
    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
        return new Promise((resolve, reject) => {
            $.ajax({
            url: `${apiUrl}transaksibelanja/field_length`,
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

                form.find(`[name=perkiraannama]`).attr('maxlength', 100)
                form.find(`[name=karyawannama]`).attr('maxlength', 100)
                form.find(`[name=nominal]`).attr('maxlength', 18)
                
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

    function showTransaksiBelanja(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}transaksibelanja/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        // console.log(index, value)
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            if (response.data.karyawannama !== null) {
                                let newOption = new Option(response.data.karyawannama, value);
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
                                        $('.select2-search__field').val(response.data.karyawannama).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'karyawannama') {
                            element.data('current-value', value)
                        }

                        if (index == 'perkiraannama') {
                            element.data('current-value', value)
                        }
                    })

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

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}transaksibelanja/default`,
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

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}transaksibelanja/${Id}/cekValidasiAksi`,
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
                        editTransaksiBelanja(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deleteTransaksiBelanja(Id)
                    }
                }

            }
        })
    }


    function initLookup() {
        $('.perkiraan-lookup').lookup({
            title: 'perkiraan Lookup',
            fileName: 'perkiraan',
            typeSearch: 'ALL',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'perkiraan_id',
                    searchText: 'perkiraan-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    group: 'belanja',
                    title: 'perkiraan'
                }
            },
            onSelectRow: (perkiraan, element) => {
                $('#crudForm [name=perkiraanid]').first().val(perkiraan.id)
                $('#crudForm [name=keterangan]').first().val(perkiraan.keterangan)
                element.val(perkiraan.nama)

                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=perkiraanid]').first().val('')
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
                    title: 'karyawan'
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