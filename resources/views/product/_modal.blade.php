<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" >
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                  </div> 
                <form action="" method="post">
                    <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <input type="text" name="id" class="form-control" hidden>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    nama <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="nama" class="form-control">
                            </div>
                        </div>
                        {{-- <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    group <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="groupid" class="filled-row">
                                <input type="text" name="groupnama" id="groupnama" class="form-control lg-form group-lookup filled-row" autocomplete="off">
                            </div>
                        </div> --}}
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    supplier <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supplierid" class="filled-row">
                                <input type="text" name="suppliernama" id="suppliernama" class="form-control lg-form supplier-lookup-benar filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    satuan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="satuanid" class="filled-row">
                                <input type="text" name="satuannama" id="satuannama" class="form-control lg-form satuan-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    keterangan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga jual <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargajual" class="form-control autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga beli <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargabeli" class="form-control  autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 1 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak1" class="form-control  autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 2 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak2" class="form-control  autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 3 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak3" class="form-control  autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 4 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak4" class="form-control  autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 5 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak5" class="form-control autonumerics text-right" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    harga kontrak 6 
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="hargakontrak6" class="form-control autonumerics  text-right" value="0">
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
                            Tutup                            </button>
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
          url: `{{ config('app.api_url') }}product/editingat`,
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
            let productId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            data.filter((row) => row.name === 'hargajual')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargajual"]`)[0])
            data.filter((row) => row.name === 'hargabeli')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargabeli"]`)[0])
            data.filter((row) => row.name === 'hargakontrak1')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak1"]`)[0])
            data.filter((row) => row.name === 'hargakontrak2')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak2"]`)[0])
            data.filter((row) => row.name === 'hargakontrak3')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak3"]`)[0])
            data.filter((row) => row.name === 'hargakontrak4')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak4"]`)[0])
            data.filter((row) => row.name === 'hargakontrak5')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak5"]`)[0])
            data.filter((row) => row.name === 'hargakontrak6')[0].value = AutoNumeric.getNumber($(`#crudForm [name="hargakontrak6"]`)[0])

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
                    url = `${apiUrl}product`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}product/${productId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}product/${productId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}product`
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

    function createProduct() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Product')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

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
        initAutoNumericNoDoubleZero(form.find(`[name="hargajual"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargabeli"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak1"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak2"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak3"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak4"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak5"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak6"]`))
    }

    function editingAt(id, btn) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `{{ config('app.api_url') }}product/editingat`,
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

    function editProduct(productId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit Product')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                editingAt(productId, 'EDIT'),
                getMaxLength(form)
            ])
            .then(() => {
                showProduct(form, productId)
                    .then(() => {
                        $('#crudModal').modal('show')
                        initAutoNumericNoDoubleZero(form.find(`[name="hargajual"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargabeli"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak1"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak2"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak3"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak4"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak5"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="hargakontrak6"]`))
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

    function deleteProduct(productId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete Product')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                getMaxLength(form)
            ])
            .then(() => {
                showProduct(form, productId)
                    .then(() => {
                        $('#crudModal').modal('show')
                        initAutoNumeric(form.find(`[name="hargajual"]`))
                        initAutoNumeric(form.find(`[name="hargabeli"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak1"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak2"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak3"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak4"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak5"]`))
                        initAutoNumeric(form.find(`[name="hargakontrak6"]`))
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
            url: `${apiUrl}product/field_length`,
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

    function showProduct(form, productId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}product/${productId}`,
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

                        // if (index == 'groupnama') {
                        //     element.data('current-value', value)
                        // }

                        if (index == 'suppliernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'satuannama') {
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
                url: `${apiUrl}product/default`,
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

    function initLookup() {
        $('.group-lookup').lookup({
            title: 'group Lookup',
            fileName: 'groupProduct',
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
                    title: 'Group',
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

        $('.supplier-lookup-benar').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplier_id',
                    searchText: 'supplier-lookup-benar',
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

        $('.satuan-lookup').lookup({
            title: 'satuan Lookup',
            fileName: 'satuan',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'satuan_id',
                    searchText: 'satuan-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Satuan',
                }
            },
            onSelectRow: (satuan, element) => {
                $('#crudForm [name=satuanid]').first().val(satuan.id)
                element.val(satuan.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=satuanid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

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
    }
</script>
@endpush()