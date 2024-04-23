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
                    <div class="modal-body">
                        {{-- <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">ID</label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="id" class="form-control" readonly>
                            </div>
                        </div> --}}
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    TANGGAL<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgl" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Keterangan<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="status" class="form-select select2bs4" style="width: 100%;">
                                    <option value="">-- PILIH STATUS --</option>
                                </select>
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


    $(window).on('beforeunload', function() {
        var keterangan = $('#keterangan').val();
        var tgl = $('#tgl').val();

        console.log('onload', keterangan)

        localStorage.setItem('keterangan', keterangan);
        localStorage.setItem('tgl', tgl);
    });

    // Fungsi untuk mengisi nilai input dari localStorage saat halaman dimuat
    function isiInput() {
        var keterangan = localStorage.getItem('keterangan');

        console.log('local', keterangan)
        var tgl = localStorage.getItem('tgl');

        if (keterangan !== null && tgl !== null) {
            $('#keterangan').val(keterangan);
            $('#tgl').val(tgl);
        }
    }

    $(document).ready(function() {
        
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let hariLiburId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

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

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}harilibur`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}harilibur/${hariLiburId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}harilibur`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')


                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page
                    }).trigger('reloadGrid');

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
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }

        
        initSelect2($(`[name="status"]`), true)
        initDatepicker()

         isiInput()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function createHariLibur() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tgl]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                setStatusOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showDefault(form)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function editHariLibur(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')


        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Simpan
        `)
        $('#crudModalTitle').text('Edit Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()



        Promise
            .all([
                setStatusOptions(form),
                getMaxLength(form)

            ])
            .then(() => {
                showHariLibur(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function deleteHariLibur(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Hapus
        `)
        $('#crudModalTitle').text('Delete Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showHariLibur(form, id)
                    .then(() => {
                        $('#crudModal').modal('show')
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function viewHariLibur(id) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
        form.find('#btnSubmit').prop('disabled', true)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Hari Libur')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showHariLibur(form, id)
                    .then(userId => {
                        setFormBindKeys(form)
                        initSelect2(form.find('.select2bs4'), true)
                        form.find('[name]').removeAttr('disabled')
                        form.find('select').each((index, select) => {
                            let element = $(select)
                            if (element.data('select2')) {
                                element.select2('destroy')
                            }
                        })
                        form.find('[name]').attr('disabled', 'disabled').css({
                            background: '#fff'
                        })
                        form.find('[name=id]').prop('disabled', false)
                    })
                    .then(() => {
                        $('#crudModal').modal('show')

                        form.find(`.hasDatepicker`).prop('readonly', true)
                        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()

                        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
                        let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
                        name.attr('disabled', true)
                        name.find('.lookup-toggler').remove()
                        nameFind.find('button.button-clear').remove()
                        $('#crudForm').find(`.tbl_aksi`).hide()
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
        return new Promise((resolve, reject) => {
            $.ajax({
            url: `${apiUrl}harilibur/field_length`,
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

                form.find(`[name=customernama]`).attr('maxlength', 100)
                
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
                    grp : "STATUS", 
                    subgrp : "STATUS"
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

    function showHariLibur(form, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/${id}`,
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
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }
                    })
                    console.log(form.data('action'))
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

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}harilibur/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        console.log(index)
                        let element = form.find(`[name="${index}"]`)
                        // let element = form.find(`[name="status"]`)

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
</script>
@endpush()