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

          <div class="modal-body modal-overflow" style="overflow-y: auto; overflow-x: hidden;">
            <input type="hidden" name="id" class="filled-row">

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  no invoice <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="noinvoice" class="form-control lg-form filled-row" readonly>
              </div>
            </div>
           
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                      INVOICE DATE<span class="text-danger">*</span>
                  </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                  <div class="input-group">
                      <input type="text" name="invoicedate" id="invoicedate" class="form-control lg-form datepicker filled-row" readonly>
                  </div>
              </div>
          </div>
         

          <div class="row form-group">
            {{-- <div class="col-12 col-sm-3 col-md-2">
              <label class="col-form-label">
                customer
              </label>
            </div>
            <div class="col-12 col-sm-9 col-md-10">
              <select id="customer" class="form-control lg-form select2bs4 select-2" name="customer_id" style="height:50px">
              </select>
            </div> --}}
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                customer <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="hidden" name="customer_id" class="filled-row">
              <input type="text" name="customer_name" id="customer_name" class="form-control lg-form customer-lookup filled-row" autocomplete="off">
            </div>
          </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  no po 
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nopo" id="nopo" class="form-control lg-form form-control lg-form-lg-mobile filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ship to
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="shipto" class="form-control lg-form filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  rate
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="rate" class="form-control lg-form filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  fob
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="fob" class="form-control lg-form filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  terms
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="terms" class="form-control lg-form filled-row">
              </div>
            </div>

           
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  fiscal rate
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="fiscalrate" class="form-control lg-form filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                      SHIP DATE<span class="text-danger">*</span>
                  </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                  <div class="input-group">
                      <input type="text" name="shipdate" id="shipdate" class="form-control lg-form datepicker filled-row">
                  </div>
              </div>
          </div>
           

          {{-- <div class="row form-group">
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                sales 2 <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="hidden" name="sales_id">
              <input type="text" name="sales_name" id="sales_name" class="form-control lg-form sales-lookup">
            </div>
          </div> --}}

          <div class="row form-group">
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                ship via
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="text" name="shipvia" id="shipvia" class="form-control lg-form filled-row">
            </div>
          </div>

          <div class="row form-group">
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                receivable account
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="text" name="receivableacoount" class="form-control lg-form filled-row">
            </div>
          </div>

          {{-- <div class="row form-group">
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                sales single colom <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="hidden" name="sales2_id">
              <input type="text" name="sales2_name" id="sales2_name" class="form-control lg-form single-lookup" autocomplete="off">
            </div>
          </div>
 --}}

          <div class="row form-group">
            <div class="col-12 col-md-2">
              <label class="col-form-label">
                sales <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-12 col-md-10">
              <input type="hidden" name="sales_id" class="filled-row">
              <input type="text" name="sales_name" id="sales_name" class="form-control lg-form sales-lookup filled-row" autocomplete="off">
            </div>
          </div>

          


            <div class="table-responsive table-lookup overflow" >
              <table class="table table-bordered table-bindkeys " id="detailList">
                <thead>
                  <tr>
                    <th class="wider" style="width: 50px; min-width: 50px;">NO</th>
                    <th style="width: 250px; min-width: 250px;">Item</th>
                    <th style="width: 225px; min-width: 225px;">Description</th>
                    <th class="wider-qty" style="width: 150px; min-width: 150px;">Qty</th>
                    <th style="width: 200px; min-width: 200px;">Price</th>
                    <th style="width: 200px; min-width: 200px;">Amount</th>
                    <th class="wider-aksi" id="aksi">Action</th>
                  </tr>
                </thead>
                <tbody id="table_body">
               
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4" id="colspan"></td>
                    <td>
                      <p class="text-right font-weight-bold">TOTAL:</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td>
                      <button type="button" class="btn  btn-primary btn-add-row" id="addRow">Tambah</button>
                    </td>
                  </tr>
  
                </tfoot>

              </table>
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

  let importModal = $('#importModal')
  let importForm = importModal.find('form')



  $(document).ready(function() {


    $("#crudForm [name]").attr("autocomplete", "off");
    $('#nopo').focus();
    $(document).on('click', "#addRow", function() {

      // event.preventDefault()
      // let method = `POST`
      // let url = `${apiUrl}fakturpenjualandetail/addrow`
      // let form = $('#crudForm')
      // let Id = form.find('[name=id]').val()
      // let action = form.data('action')
      // let data = $('#crudForm').serializeArray()
      // $.ajax({
      //   url: url,
      //   method: method,
      //   dataType: 'JSON',
      //   headers: {
      //     Authorization: `Bearer ${accessToken}`
      //   },
      //   data: data,
      //   success: response => {
      //     $('.is-invalid').removeClass('is-invalid')
      //     $('.invalid-feedback').remove()
          addRow()
    //     },
    //     error: error => {
    //       if (error.status === 422) {
    //         $('.is-invalid').removeClass('is-invalid')
    //         $('.invalid-feedback').remove()

    //         setErrorMessages(form, error.responseJSON.errors);
    //       } else {
    //         showDialog(error.responseJSON)
    //       }
    //     },
    //   }).always(() => {
    //     $('#processingLoader').addClass('d-none')
    //     $(this).removeAttr('disabled')
    //   })
    });

    $(document).on('change', `#crudForm [name="invoicedate"]`, function() {
      $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
    });

    $(document).on('input', `#table_body [name="hargasatuan[]"]`, function(event) {
      setAmount($(this))
      setTotal()
    })

    $(document).on('input', `#table_body [name="qty[]"]`, function(event) {
      setAmount($(this))
      setTotal()
    })

    $(document).on('input', `#table_body [name="amount[]"]`, function(event) {
      setTotal()
    })

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
      let data = $('#crudForm .filled-row').serializeArray()

      console.log($('#crudForm .filled-row').serializeArray())


      $('#crudForm ').find(`.filled-row[name="hargasatuan[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'hargasatuan[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="hargasatuan[]"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="amount[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'amount[]')[index].value = AutoNumeric.getNumber($(`#crudForm .filled-row[name="amount[]"]`)[index])
      })


      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
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

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}fakturpenjualanheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}fakturpenjualanheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}fakturpenjualanheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}fakturpenjualanheader`
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

          $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
          $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
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
    dropzone = initDropzone($('#importModal').find('#dropzoneFile')[0])

    importForm.on('input', function() {
      importForm.data('hasChanged', true)
    })

    importForm.on('submit', function(event) {
      event.preventDefault()
      importItem(importForm)
    })

  })

  $('#crudModal').on('shown.bs.modal', () => {

    var crudModal = $('#crudModal')
    let form = $('#crudForm')
    setFormBindKeys(form)
    activeGrid = null
    paginateSelect2('#customer', 'customer')
    clearButton(form, '#customer')
    // initializeSelect2('#detail');
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

  function setAmount(element) {
    let qty = element.parents('tr').find(`td [name="qty[]"]`).val();
    let hargasatuan = parseFloat(element.parents('tr').find(`td [name="hargasatuan[]"]`).val().replace(/,/g, ''))
    let amount = qty * hargasatuan;
    initAutoNumeric(element.parents('tr').find(`td [name="amount[]"]`).val(amount))
  }

  function setTotal() {
    let nominalDetails = $(`#detailList [name="amount[]"]`)
    let total = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    new AutoNumeric('#total').set(total)
  }

  let dataParameter
  const setParameterOptions = function() {
    $.ajax({
      url: `${apiUrl}customer`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        filters: JSON.stringify({
          groupOp: "AND",
          rules: [{
            field: "text",
            op: "cn",
            data: ''
          }, ],
        }),
        offset: (1 - 1) * 10,
        limit: 10,
        paginate: true
      },
      success: response => {
        dataParameter = response.data;
        var pageSize = 10;
        var results = response.data;
      },

    })
  }

  function initializeSelect2(selector) {
    var currentQuery
    $(selector).select2({
      placeholder: 'Pilih',
      multiple: false,
      width: '100%',
      data: dataParameter, // Set the data here
      templateResult: formatSearchResult,

    }).on('select2:closing', function() {
      var selectedOption = $(this).find(':selected');
      if (selectedOption.length > 0) {
        currentQuery = selectedOption.text();
      }
    }).on('select2:opening', function() {
      if (currentQuery) {
        setTimeout(function() {
          $('.select2-search__field').val(currentQuery).trigger('input');
        }, 50);
      }
    });
  }

  function paginateSelect2(selector, url) {
    var currentQuery;
    var isInsideModal = true

    $(`${selector}`).select2({
      placeholder: 'Pilih',
      multiple: false,
      width: '100%',
      dropdownParent: isInsideModal ? $(selector).parents('.modal-content') : "",
      ajax: {
        url: `${apiUrl}${url}`,
        data: function(params) {
          return {
            filters: JSON.stringify({
              groupOp: "AND",
              rules: [{
                field: "text",
                op: "cn",
                data: params.term
              }, ],
            }),
            offset: params.page || 1,
            paginate: true
          };
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        dataType: 'json',
        delay: 250,

        processResults: function(response) {
          var pageSize = 10;
          var results = response.data;

          return {
            results: results,
            pagination: {
              more: results.length >= pageSize
            }
          };
        },
        cache: true
      },
      templateResult: formatSearchResult
    }).on('select2:closing', function() {
      var selectedOption = $(this).find(':selected');
      if (selectedOption.length > 0) {
        currentQuery = selectedOption.text();
      }
    }).on('select2:open', function() {
      // const modal = $(".modal-body");
      // const selectTop =$(this).offset().top;

      // console.log(selectTop)

      // const lookupBottom =
      //   $(this).offset().top + $(this).outerHeight();
      // const modalBottom = modal.offset().top + modal.height();
      // const modalTop = modal.offset().top;

     
      // if (selectTop > 250) {
        
      //     const scrollDistance =
      //         selectTop + $(this).height() - modalBottom + 20; // Jarak scroll yang diinginkan
      //     modal.animate(
      //         {
      //             scrollTop: modalBottom + scrollDistance,
      //         },
      //         300
      //     );
      // }

      console.log($(this))
      if (window.innerWidth < 768) {
        adjustScrollForMobile()
      }
      document.querySelector(".select2-search__field").focus();
      

     
    }).on('select2:opening', function() {
      if (currentQuery) {

        setTimeout(function() {
          $('.select2-search__field').val(currentQuery).trigger('input');
        }, 50);
      }
    });
  }
  
  // Fungsi untuk mengatur scroll saat keyboard muncul
  function adjustScrollForMobile() {
        const activeElement = document.activeElement;
        const modalContent = document.querySelector(".overflow"); // Ganti dengan selektor sesuai struktur Anda

        if (
            activeElement &&
            "scrollIntoView" in activeElement &&
            modalContent
        ) {
            activeElement.scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "end",
            });
        }
    }

  function createFakturPenjualanHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
    form.data('action', 'add')
    form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
    form .find(`[name="shipdate"]`).prop('readonly', true).addClass('bg-white state-delete')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    $('#crudForm').find('[name=invoicedate]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=shipdate]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    addRow()
    setTotal()
  }

  function editFakturPenjualanHeader(id) {

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
        setParameterOptions(),
        showFakturPenjualanHeader(form, id)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteFakturPenjualanHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

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
        showFakturPenjualanHeader(form, id)
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

  function viewFakturPenjualanHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Piutang Header')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showFakturPenjualanHeader(form, userId)
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
      $.ajax({
        url: `${apiUrl}fakturpenjualanheader/field_length`,
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

  


  function showFakturPenjualanHeader(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}fakturpenjualanheader/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              if (response.data.customer_name !== null) {
                let newOption = new Option(response.data.customer_name, value);
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
                    $('.select2-search__field').val(response.data.customer_name).trigger('input');
                    $('.select2-search__field').focus();
                  }, 50);

                });
              }
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })

          $('#detailList tbody').html('')

          if (detectDeviceType() == "desktop") {
                $.each(response.detail, (index, detail) => {
                selectIndex = index;
                let detailRow = $(`
                    <tr>
                      <td>
              
                      </td>
                      <td>
                        <input type="hidden" name="item_id[]" class="filled-row" >
                        <input type="text" name="item_name[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex} filled-row" autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="description[]" class="form-control lg-form filled-row" autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="qty[]" class="form-control lg-form numbernoseparate filled-row" autocomplete="off" >
                        </td>
                        <td>
                          <input type="text" name="hargasatuan[]" class="form-control lg-form autonumeric filled-row" autocomplete="off" >
                        </td>
                        <td>
                          <input type="text" name="amount[]" class="form-control lg-form autonumeric filled-row"  autocomplete="off">
                        </td>
                        <td>
                          <button type="button" class="btn btn-sm btn-danger delete-row"  >Hapus</button>
                        </td>
                    </tr>
                  `)

                detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                detailRow.find(`[name="amount[]"]`).val(detail.amount)
                detailRow.find(`[name="description[]"]`).val(detail.description)
                detailRow.find(`[name="item_id[]"]`).val(detail.item_id)
                detailRow.find(`[name="item_name[]"]`).val(detail.item_name)
                detailRow.find(`[name="qty[]"]`).val(detail.qty)
                detailRow.find(`[name="hargasatuan[]"]`).val(detail.hargasatuan)
                detailRow.find(`[name="amount[]"]`).prop('readonly', true)
                initAutoNumeric(detailRow.find(`[name="amount[]"]`))
                initAutoNumeric(detailRow.find(`[name="hargasatuan[]"]`))
                $('#detailList tbody').append(detailRow)

                rowIndex = index

                initDatepicker(detailRow.find('.datepicker'))
                form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                paginateSelect2(`#detail_${index}`, 'customer')
                initLookupDetail(rowIndex);
                form .find(`[name="shipdate"]`).attr('disabled', 'disabled').addClass('bg-white state-delete')
              
                clearButton('detailList', `#detail_${index}`)
                setTotal()
              })
          }else if(detectDeviceType() == "mobile"){
             $(".wider-qty").remove();
            $("#colspan").attr("colspan", "3"); // Ubah nilai "2" sesuai kebutuhan Anda
              $.each(response.detail, (index, detail) => {
                selectIndex = index;
                  let detailRow = $(`
                    <tr>
                      <td>
                        
                    </td>
                    <td>
                        <input type="hidden" name="item_id[]" class="form-control detail_stok_${selectIndex} filled-row">
                        <input type="text" name="item_name[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex} filled-row" autocomplete="off">
                        <br>
                        <label class="col-form-label" style="font-size:16px">
                          QTY
                        </label>
                        <input type="text" name="qty[]" class="form-control lg-form numbernoseparate filled-row" autocomplete="off" >
                      </td>
                      <td>
                        <input type="text" name="description[]" class="form-control lg-form filled-row" autocomplete="off" ">
                      </td>
                    
                      <td>
                        <input type="text" name="hargasatuan[]" class="form-control lg-form autonumeric filled-row" autocomplete="off" >
                      </td>
                      <td>
                        <input type="text" name="amount[]" class="form-control lg-form autonumeric filled-row"  autocomplete="off" readonly>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger delete-row"  >Hapus</button>
                      </td>
                  </tr> `)

                detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
                detailRow.find(`[name="amount[]"]`).val(detail.amount)
                detailRow.find(`[name="description[]"]`).val(detail.description)
                detailRow.find(`[name="item_id[]"]`).val(detail.item_id)
                detailRow.find(`[name="item_name[]"]`).val(detail.item_name)
                detailRow.find(`[name="qty[]"]`).val(detail.qty)
                detailRow.find(`[name="hargasatuan[]"]`).val(detail.hargasatuan)
                detailRow.find(`[name="amount[]"]`).prop('readonly', true)
                initAutoNumeric(detailRow.find(`[name="amount[]"]`))
                initAutoNumeric(detailRow.find(`[name="hargasatuan[]"]`))
                $('#detailList tbody').append(detailRow)

                rowIndex = index

                initDatepicker(detailRow.find('.datepicker'))
                form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                paginateSelect2(`#detail_${index}`, 'customer')
                initLookupDetail(rowIndex);
                form .find(`[name="shipdate"]`).attr('disabled', 'disabled').addClass('bg-white state-delete')
              
                clearButton('detailList', `#detail_${index}`)
                setTotal()
              })
          }

          selectIndex += 1;

          setRowNumbers()
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



  let selectIndex = 0

  function addRow() {
    form = $('#detailList')

    if (detectDeviceType() == "desktop") {
      
      let detailRow = $(`
            <tr>
              <td>
                
            </td>
            <td>
              <select name="item_id[]" id="addRow_${selectIndex}" class="form-select select2bs4 scroll-select" style="width: 100%;">
              
              </select> 
                  
              </td>
              <td>
                <input type="text" name="description[]" class="form-control lg-form" autocomplete="off" ">
              </td>
              <td>
                <input type="text" name="qty[]" class="form-control lg-form numbernoseparate" autocomplete="off" >
              </td>
              <td>
                <input type="text" name="hargasatuan[]" class="form-control lg-form autonumeric" autocomplete="off" >
              </td>
              <td>
                <input type="text" name="amount[]" class="form-control lg-form autonumeric"  autocomplete="off" readonly>
              </td>
              <td>
                <button type="button" class="btn btn-danger delete-row"  >Hapus</button>
              </td>
        </tr>`)

     

        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

        // Jika baris diisi, tambahkan kelas 'filled-row'
        detailRow.on('input', 'input[name="item_name[]"]', function() {
            let value = $(this).val();
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
              $(this).parents('td').find('[name="item_name[]"]').addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
                $(this).parents('td').find('[name="item_name[]"]').removeClass('filled-row');
            }
        });

       

        detailRow.on('input', 'input[name="description[]"]', function() {
            let value = $(this).val();
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
            }
        });

        detailRow.on('change', 'select[name="item_id[]"]', function() {
          let value = $(this).find(":selected").val();
          console.log(value);
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
        detailRow.on('input', 'input[name="hargasatuan[]"]', function() {
            let value = $(this).val();
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
              $(this).parents('tr').find('[name="amount[]"]').addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
                $(this).parents('td').find('[name="item_name[]"]').removeClass('filled-row');
            }
        });
        detailRow.on('input', 'input[name="amount[]"]', function() {
            let value = $(this).val();
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
            }
        });

        

        $('#detailList tbody').append(detailRow)

        initDatepicker(detailRow.find('.datepicker'))

        initAutoNumeric(detailRow.find('.autonumeric'))

        paginateSelect2(`#addRow_${selectIndex}`, 'customer')
        clearButton(form, `#addRow_${selectIndex}`)

        rowLookup = selectIndex

        initLookupDetail(selectIndex);


        // initializeSelect2('#addRow')
        setRowNumbers()

        selectIndex++
      
       

    } else if (detectDeviceType() == "mobile") {
      $(".wider-qty").remove();
      $("#colspan").attr("colspan", "3"); // Ubah nilai "2" sesuai kebutuhan Anda
     
      let detailRow = $(`
            <tr>
              <td>
                
            </td>
            <td>
              <select name="item_id[]" id="addRow_${selectIndex}" class="form-select select2bs4" style="width: 100%;">
              
              </select>     
             
                <br>
                <label class="col-form-label justify-content-end" style="font-size:16px">
                  QTY
                </label>
                <input type="text" name="qty[]" class="form-control lg-form numbernoseparate" autocomplete="off" >
              </td>
              <td>
                <input type="text" name="description[]" class="form-control lg-form" autocomplete="off" ">
              </td>
             
              <td>
                <input type="text" name="hargasatuan[]" class="form-control lg-form autonumeric" autocomplete="off" >
              </td>
              <td>
                <input type="text" name="amount[]" class="form-control lg-form autonumeric"  autocomplete="off" readonly>
              </td>
              <td>
                <button type="button" class="btn btn-danger delete-row"  >Hapus</button>
              </td>
        </tr> `)

        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

         // Jika baris diisi, tambahkan kelas 'filled-row'
         detailRow.on('input', 'input[name="item_name[]"]', function() {
            let value = $(this).val();
            console.log('Nilai dari item_name[]:', value);
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
              $(this).parents('td').find('[name="item_name[]"]').addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
                $(this).parents('td').find('[name="item_name[]"]').removeClass('filled-row');
            }
        });

        detailRow.on('change', 'select[name="item_id[]"]', function() {
          let value = $(this).find(":selected").val();
          console.log(value);
          if (value.trim() !== "") {
              $(this).addClass('filled-row');
          } else {
              $(this).removeClass('filled-row');
          }
      });

       

        detailRow.on('input', 'input[name="description[]"]', function() {
            let value = $(this).val();
            console.log('Nilai dari description[]:', value);
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
            }
        });

        detailRow.on('input', 'input[name="qty[]"]', function() {
            let value = $(this).val();
            console.log('Nilai dari qty[]:', value);
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
            }
        });
        detailRow.on('input', 'input[name="hargasatuan[]"]', function() {
            let value = $(this).val();
            console.log('Nilai dari hargasatuan[]:', value);
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
              $(this).parents('tr').find('[name="amount[]"]').addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
                $(this).parents('td').find('[name="item_name[]"]').removeClass('filled-row');
            }
        });
        detailRow.on('input', 'input[name="amount[]"]', function() {
            let value = $(this).val();
            console.log('Nilai dari amount[]:', value);
            if (value.trim() !== "") {
              $(this).addClass('filled-row');
            } else {
                $(this).removeClass('filled-row');
            }
        });


        $('#detailList tbody').append(detailRow)
        initDatepicker(detailRow.find('.datepicker'))

        initAutoNumeric(detailRow.find('.autonumeric'))

        paginateSelect2(`#addRow_${selectIndex}`, 'customer')
        clearButton(form, `#addRow_${selectIndex}`)

        rowLookup = selectIndex

        initLookupDetail(selectIndex);


        // initializeSelect2('#addRow')
        setRowNumbers()

        selectIndex++
     
    }

    // let detailRow = $(`
    //         <tr>
    //           <td>
                
    //         </td>
    //         <td>
    //             <input type="hidden" name="item_id[]" class="form-control detail_stok_${selectIndex}">
    //             <input type="text" name="item_name[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
    //           </td>
    //           <td>
    //             <input type="text" name="description[]" class="form-control lg-form" autocomplete="off" ">
    //           </td>
    //           <td>
    //             <input type="text" name="qty[]" class="form-control lg-form numbernoseparate" autocomplete="off" >
    //           </td>
    //           <td>
    //             <input type="text" name="hargasatuan[]" class="form-control lg-form autonumeric" autocomplete="off" >
    //           </td>
    //           <td>
    //             <input type="text" name="amount[]" class="form-control lg-form autonumeric"  autocomplete="off" readonly>
    //           </td>
    //           <td>
    //             <button type="button" class="btn btn-danger delete-row"  >Hapus</button>
    //           </td>
    //     </tr>`)


    

    // tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
    // detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');



    // $('#detailList tbody').append(detailRow)
    // initDatepicker(detailRow.find('.datepicker'))

    // initAutoNumeric(detailRow.find('.autonumeric'))

    // paginateSelect2(`#addRow_${selectIndex}`, 'customer')
    // clearButton(form, `#addRow_${selectIndex}`)

    // rowLookup = selectIndex

    // initLookupDetail(selectIndex);


    // // initializeSelect2('#addRow')
    // setRowNumbers()

    // selectIndex++

  }

  function initLookupDetail(index) {
    let rowLookup = index;

    $(`.item-lookup${rowLookup}`).lookup({
      title: 'Item Lookup',
      fileName: 'sales',
      detail: true,
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: `ItemId_${index}`,
          id: `ItemId_${rowLookup}`,
          searchText: `item-lookup${rowLookup}`,
        };
      },
      onSelectRow: (item, element) => {
       
        let item_id_input = element.parents('td').find(`[name="item_id[]"]`);
        item_id_input.val(item.id);
       
        element.val(item.name);

        element.addClass('filled-row')
        item_id_input.addClass('filled-row')
        element.data('currentValue', element.val());
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let item_id_input = element.parents('td').find(`[name="item_id[]"]`).first();
        item_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.bank-lookup${rowLookup}`).lookup({
      title: 'Bank Lookup',
      fileName: 'sales',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: `bankId_${index}`,
          id: `bankId_${rowLookup}`,
          searchText: `bank-lookup${rowLookup}`,
        };
      },
      onSelectRow: (bank, element) => {
        let bank_id_input = element.parents('td').find(`[name="bank_id[]"]`);
        bank_id_input.val(bank.id);
        element.val(bank.name);
        element.data('currentValue', element.val());
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let bank_id_input = element.parents('td').find(`[name="bank_id[]"]`).first();
        bank_id_input.val('');
        element.val('');
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

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function initLookup() {

    $('.sales-lookup').lookup({
      title: 'Sales Lookup',
      fileName: 'sales',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'sales_id',
          searchText: 'sales-lookup',
        }
      },
      onSelectRow: (sales, element) => {
        $('#crudForm [name=sales_id]').first().val(sales.id)
        element.val(sales.name)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=sales_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.customer-lookup').lookup({
      title: 'customer Lookup',
      fileName: 'customer',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'customer_id',
          searchText: 'customer-lookup',
        }
      },
      onSelectRow: (customer, element) => {
        $('#crudForm [name=customer_id]').first().val(customer.id)
        element.val(customer.name)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=customer_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.single-lookup').lookup({
      title: 'single Lookup',
      fileName: 'customer',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'sales2_id',
          searchText: 'single-lookup',
        }
      },
      onSelectRow: (sales2, element) => {
        $('#crudForm [name=sales2_id]').first().val(sales2.id)
        element.val(sales2.name)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=sales2_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }
</script>
@endpush()