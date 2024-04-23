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
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Nama <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="nama" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Nama 2 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="nama2" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="username" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Telepon 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="telepon" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Alamat 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="alamat" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Keterangan 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Owner <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="ownerid" class="filled-row">
                                <input type="text" name="ownernama" id="ownernama" class="form-control lg-form owner-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    HARGA PRODUCT <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="hargaproduct" class="filled-row">
                                <input type="text" name="hargaproductnama" id="hargaproductnama" class="form-control lg-form hargaproduct-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    Group
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="groupid" class="filled-row">
                                <input type="text" name="groupnama" id="groupnama" class="form-control lg-form group-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">tax</label>
                            </div>
                            <div class="col-md-4  ">
                                <div class="input-group">
                                    <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row" value="0">
                                    <div class="input-group-append">
                                        <span class="input-group-text">% </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form " value="0">
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
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                          <button class="btn btn-warning btn-cancel btn-batal">
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

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#crudForm').data('action') == 'edit') {


                $.ajax({
                url: `{{ config('app.api_url') }}customer/editingat`,
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
            let customerId = form.find('[name=id]').val()
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
                    url = `${apiUrl}customer`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}customer/${customerId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}customer/${customerId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}customer`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    id = response.data.id
                    $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page
                        })
                        .trigger('reloadGrid');

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


        
        initLookup()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function createCustomer() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Customer')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setHargaProductOptions(form),
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

    function editingAt(id, btn) {
        return new Promise((resolve, reject) => {
        $.ajax({
            url: `{{ config('app.api_url') }}customer/editingat`,
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

    function editCustomer(customerId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Customer')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setHargaProductOptions(form),
                editingAt(customerId, 'EDIT'),
                getMaxLength(form)
            ])
            .then(() => {
                showCustomer(form, customerId)
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

    function deleteCustomer(customerId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Customer')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setHargaProductOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showCustomer(form, customerId)
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

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
        return new Promise((resolve, reject) => {
            $.ajax({
            url: `${apiUrl}customer/field_length`,
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

                form.find(`[name=ownernama]`).attr('maxlength', 100)
                form.find(`[name=hargaproductnama]`).attr('maxlength', 100)
                form.find(`[name=groupnama]`).attr('maxlength', 100)
                form.find(`[name=statusnama]`).attr('maxlength', 100)
                
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

    const setHargaProductOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=hargaproduct]').empty()
            relatedForm.find('[name=hargaproduct]').append(
                new Option('-- PILIH HARGA PRODUCT --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: "HARGA PRODUCT",
                    subgrp: "HARGA PRODUCT"
                },
                success: response => {
                    response.data.forEach(hargaproduct => {
                        let option = new Option(hargaproduct.text, hargaproduct.id)

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

    function showCustomer(form, customerId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}customer/${customerId}`,
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

                        if (index == 'ownernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'hargaproductnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusnama') {
                            element.data('current-value', value)
                        }
                    })

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
                url: `${apiUrl}customer/default`,
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
                        if (index == 'statusnama') {
                            element.data('current-value', value)
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

    function cekValidasiAksi(Id, Aksi){
        if (Aksi == 'EDIT') {
            $.ajax({
                url: `{{ config('app.api_url') }}customer/${Id}/cekvalidasi`,
                method: 'POST',
                dataType: 'JSON',
                data:{
                    button: 'EDIT'
                },
                beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    editCustomer(Id)
                }
                }
            })
        }

        if (Aksi == 'DELETE') {
            $.ajax({
                url: `{{ config('app.api_url') }}customer/${Id}/cekvalidasi`,
                method: 'POST',
                dataType: 'JSON',
                data:{
                    button: 'DELETE'
                },
                beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    deleteCustomer(Id)
                }
                }
            })
    }
    }

    function initLookup() {
        $('.owner-lookup').lookup({
            title: 'owner Lookup',
            fileName: 'owner',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'owner_id',
                    searchText: 'owner-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Owner',
                }
            },
            onSelectRow: (owner, element) => {
                $('#crudForm [name=ownerid]').first().val(owner.id)
                element.val(owner.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=ownerid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $(`.hargaproduct-lookup`).lookup({
            title: 'hargaproduct Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'HARGA PRODUCT',
                    subgrp: 'HARGA PRODUCT',
                    searching: 1,
                    valueName: `hargaproduct`,
                    searchText: `hargaproduct-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Harga Product'
                };
            },
            onSelectRow: (hargaproduct, element) => {

                $('#crudForm [name=hargaproduct]').first().val(hargaproduct.id)
                element.val(hargaproduct.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let hargaproduct_id_input = element.parents('td').find(`[name="hargaproduct"]`).first();
                hargaproduct_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $('.group-lookup').lookup({
            title: 'group Lookup',
            fileName: 'groupCustomer',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'group_id',
                    searchText: 'group-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'group',
                }
            },
            onSelectRow: (group, element) => {
                $('#crudForm [name=groupid]').first().val(group.id)
                element.val(group.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=groupid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $(`.status-lookup`).lookup({
            title: 'Status Lookup',
            fileName: 'parameter',
            searching: 1,
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
    }
</script>
@endpush()