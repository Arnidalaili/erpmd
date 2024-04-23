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
                                    SeqNo <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="seqno" class="form-control">
                            </div>
                        </div>
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
                                    Operator <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="operator" class="filled-row">
                                <input type="text" name="operatornama" id="operatornama" class="form-control lg-form operator-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Group <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="groupperkiraan" class="filled-row">
                                <input type="text" name="groupperkiraannama" id="groupperkiraannama" class="form-control lg-form groupperkiraan-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Status Perkiraan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="statusperkiraan" class="filled-row">
                                <input type="text" name="statusperkiraannama" id="statusperkiraannama" class="form-control lg-form statusperkiraan-lookup filled-row" autocomplete="off">
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

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#crudForm').data('action') == 'edit') {
                $.ajax({
                    url: `{{ config('app.api_url') }}perkiraan/editingat`,
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
            let perkiraanId = form.find('[name=id]').val()
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
                    url = `${apiUrl}perkiraan`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}perkiraan/${perkiraanId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}perkiraan/${perkiraanId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}perkiraan`
                    break;
            }

            console.log(data)

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

    function createPerkiraan() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Perkiraan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setOperatorOptions(form),
                setGroupOptions(form),
                setStatusPerkiraanOptions(form),
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
                url: `{{ config('app.api_url') }}perkiraan/editingat`,
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


    function editPerkiraan(perkiraanId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Perkiraan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setOperatorOptions(form),
                setGroupOptions(form),
                setStatusPerkiraanOptions(form),
                editingAt(perkiraanId, 'EDIT'),
                getMaxLength(form)
            ])
            .then(() => {
                showPerkiraan(form, perkiraanId)
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

    function deletePerkiraan(perkiraanId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Perkiraan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setOperatorOptions(form),
                setGroupOptions(form),
                setStatusPerkiraanOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showPerkiraan(form, perkiraanId)
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
            url: `${apiUrl}pesananfinalheader/field_length`,
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

                form.find(`[name=statusperkiraannama]`).attr('maxlength', 100)
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

    const setGroupOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=groupperkiraan]').empty()
            relatedForm.find('[name=groupperkiraan]').append(
                new Option('-- PILIH GROUP --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": ""
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(groupperkiraan => {
                        let option = new Option(groupperkiraan.text, groupperkiraan.id)

                        relatedForm.find('[name=groupperkiraan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setStatusPerkiraanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=perkiraan]').empty()
            relatedForm.find('[name=perkiraan]').append(
                new Option('-- PILIH STATUS PERKIRAAN --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": ""
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(statusperkiraan => {
                        let option = new Option(statusperkiraan.text, statusperkiraan.id)

                        relatedForm.find('[name=statusperkiraan]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setOperatorOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=operator]').empty()
            relatedForm.find('[name=operator]').append(
                new Option('-- PILIH OPERATOR --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    filters: JSON.stringify({
                        "groupOp": "AND",
                        "rules": [{
                            "field": "grp",
                            "op": "cn",
                            "data": ""
                        }]
                    })
                },
                success: response => {
                    response.data.forEach(operator => {
                        let option = new Option(operator.text, operator.id)

                        relatedForm.find('[name=operator]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function showPerkiraan(form, perkiraanId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}perkiraan/${perkiraanId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        console.log(index, value)

                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }

                        if (index == 'statusnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'operatornama') {
                            element.data('current-value', value)
                        }

                        if (index == 'groupperkiraannama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusperkiraannama') {
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

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}perkiraan/${Id}/cekValidasiAksi`,
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
                        editPerkiraan(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePerkiraan(Id)
                    }
                }

            }
        })
    }

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}perkiraan/default`,
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

                        if (index == 'operatornama') {
                            element.data('current-value', value)
                        }

                        if (index == 'groupperkiraannama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusperkiraannama') {
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

    function initLookup() {
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

        $(`.operator-lookup`).lookup({
            title: 'operator Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'OPERATOR',
                    subgrp: 'OPERATOR',
                    searching: 1,
                    valueName: `operator`,
                    searchText: `operator-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'operator'
                };
            },
            onSelectRow: (operator, element) => {

                $('#crudForm [name=operator]').first().val(operator.id)
                element.val(operator.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let operator_id_input = element.parents('td').find(`[name="operator"]`).first();
                operator_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $(`.groupperkiraan-lookup`).lookup({
            title: 'groupperkiraan Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'group perkiraan',
                    subgrp: 'group perkiraan',
                    searching: 1,
                    valueName: `groupperkiraan`,
                    searchText: `groupperkiraan-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'group perkiraan'
                };
            },
            onSelectRow: (groupperkiraan, element) => {

                $('#crudForm [name=groupperkiraan]').first().val(groupperkiraan.id)
                element.val(groupperkiraan.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let groupperkiraan_id_input = element.parents('td').find(`[name="groupperkiraan"]`).first();
                groupperkiraan_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $(`.statusperkiraan-lookup`).lookup({
            title: 'statusperkiraan Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'perkiraan',
                    subgrp: 'perkiraan',
                    searching: 1,
                    valueName: `statusperkiraan`,
                    searchText: `statusperkiraan-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'status perkiraan'
                };
            },
            onSelectRow: (statusperkiraan, element) => {

                $('#crudForm [name=statusperkiraan]').first().val(statusperkiraan.id)
                element.val(statusperkiraan.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let statusperkiraan_id_input = element.parents('td').find(`[name="statusperkiraan"]`).first();
                statusperkiraan_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });
    }
</script>
@endpush()