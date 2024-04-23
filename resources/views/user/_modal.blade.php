<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div> 
        <form action="" method="post">
          <div class="modal-body">
            {{-- <div class="row form-group" >
              <div class="col-12 col-sm-3 col-md-2" style="display:none">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  User <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="user" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Nama User <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="name" class="form-control">
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
            <div class="row form-group sometimes">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Password <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="password" name="password" class="form-control">
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
                  Dashboard
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dashboard" class="form-control">
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
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  AKSES <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusakses" class="filled-row">
                <input type="text" name="statusaksesnama" id="statusaksesnama" class="form-control lg-form statusakses-lookup filled-row" autocomplete="off">
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
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=id]').val()
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
          url = `${apiUrl}user`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}user/${userId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}user/${userId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}user`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
  })

  function createUser() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setCabangOptions(form),
        setStatusKaryawanOptions(form),
        setStatusOptions(form),
        setStatusAkses(form),
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

  function editUser(userId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setCabangOptions(form),
        setStatusKaryawanOptions(form),
        setStatusOptions(form),
        setStatusAkses(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUser(form, userId)
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

  function deleteUser(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setCabangOptions(form),
        setStatusKaryawanOptions(form),
        setStatusOptions(form),
        setStatusAkses(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUser(form, userId)
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
          url: `${apiUrl}user/field_length`,
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

  const setCabangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=cabang_id]').empty()
      relatedForm.find('[name=cabang_id]').append(
        new Option('-- PILIH CABANG --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}cabang`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(cabang => {
            let option = new Option(cabang.namacabang, cabang.id)

            relatedForm.find('[name=cabang_id]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusKaryawanOptions = function setStatusKaryawanOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=karyawan_id]').empty()
      relatedForm.find('[name=karyawan_id]').append(
        new Option('-- PILIH STATUS KARYAWAN --', '', false, true)
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
              "data": "STATUS KARYAWAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusKaryawan => {
            let option = new Option(statusKaryawan.text, statusKaryawan.id)

            relatedForm.find('[name=karyawan_id]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=status]').empty()
      relatedForm.find('[name=status]').append(
        new Option('-- PILIH STATUS AKTIF --', '', false, true)
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

  const setStatusAkses = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusakses]').empty()
      relatedForm.find('[name=statusakses]').append(
        new Option('-- PILIH STATUS AKSES --', '', false, true)
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
              "data": "STATUS AKSES"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAkses => {
            let option = new Option(statusAkses.text, statusAkses.id)

            relatedForm.find('[name=statusakses]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function showUser(form, userId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}user/${userId}`,
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

  function initLookup() {
    $('.customer-lookup').lookup({
      title: 'customer Lookup',
      fileName: 'customer',
      typeSearch: 'ALL',
      searching: 2,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 2,
          valueName: 'customer_id',
          searchText: 'customer-lookup',
          singleColumn: true,
          hideLabel: true,
          title: 'Customer',
          // typeSearch: 'ALL',
        }
      },
      onSelectRow: (customer, element) => {
        $('#crudForm [name=customerid]').first().val(customer.id)

        console.log(customer.alamat)

        $('#crudForm [name=alamatpengiriman]').first().val(customer.alamat)
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

    $('.karyawan-lookup').lookup({
      title: 'karyawan Lookup',
      fileName: 'karyawan',
      typeSearch: 'ALL',
      searching: 2,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 2,
          valueName: 'karyawanid',
          searchText: 'karyawan-lookup',
          singleColumn: true,
          hideLabel: true,
          title: 'karyawan',
          // typeSearch: 'ALL',
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

    $(`.statusakses-lookup`).lookup({
      title: 'statusakses Lookup',
      fileName: 'parameter',
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'status akses',
          subgrp: 'status akses',
          searching: 1,
          valueName: `statusakses`,
          searchText: `statusakses-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'akses'
        };
      },
      onSelectRow: (statusakses, element) => {
        $('#crudForm [name=statusakses]').first().val(statusakses.id)
        element.val(statusakses.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let statusakses_id_input = element.parents('td').find(`[name="statusakses"]`).first();
        statusakses_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });
  }



  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}user/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
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
</script>
@endpush()