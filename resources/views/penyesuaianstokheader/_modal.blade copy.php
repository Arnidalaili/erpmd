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
                  alamat pengiriman <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="alamatpengiriman" id="alamatpengiriman" class="form-control lg-form form-control lg-form-lg-mobile filled-row">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL PENGIRIMAN<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglpengiriman" id="tglpengiriman" class="form-control lg-form datepicker filled-row">
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

            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="status" class="filled-row">
                <input type="text" name="statusnama" id="statusnama" class="form-control lg-form status-lookup filled-row" autocomplete="off">
              </div>
            </div> --}}

            <div class="scroll-container overflow">
              <div class="table-container" >
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
               <button class="btn btn-warning  btn-batal btn-cancel" data-dismiss="modal">
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
      addRow()
    });

 
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('click', '.btn-batal', function(event) {
      event.preventDefault()
      if ($('#crudForm').data('action') == 'edit') {


        $.ajax({
          url: `{{ config('app.api_url') }}pesananheader/editingat`,
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
        });

        data.push({
            name: `productnama[${row_index}]`,
            value: $(this).find(`[name="productnama[]"]`).val()
        });

        data.push({
            name: `qty[${row_index}]`,
            value: parseFloat($(this).find(`[name="qty[]"]`).val().replace(/,/g, ''))
        });

        data.push({
            name: `satuanid[${row_index}]`,
            value: $(this).find(`[name="satuanid[]"]`).val()
        });

        data.push({
            name: `satuannama[${row_index}]`,
            value: $(this).find(`[name="satuannama[]"]`).val()
        });

        data.push({
            name: `keterangandetail[${row_index}]`,
            value: $(this).find(`[name="keterangandetail[]"]`).val()
        });
      }
    });

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
          url = `${apiUrl}pesananheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pesananheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pesananheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pesananheader`
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
   
    initSelect2($(`[name="statusaktif"]`), true)

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    
    $('#detailList').find(`[name="productnama[]"]`).first().focus()
    initLookup()
    getMaxLength(form)
    initDatepicker()

  });
  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
  })



  function createPesananHeader() {
    let form = $('#crudForm')
   

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Pesanan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

  

    $('#table_body').html('')
    $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

   var besok = new Date();
    besok.setDate(besok.getDate() + 1);

    $('#crudForm').find('[name=tglpengiriman]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');
   

    Promise
      .all([
        showDefault(form)
        
      ])
      .then(() => {
            $('#crudModal').modal('show')
            addRow()
            form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
            form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
            enableLookup()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
        
     
  }


  function enableLookup(){
    let customernama = $('#crudForm').find(`[name="customernama"]`).parents('.input-group').children()

    customernama.find(`.lookup-toggler`).attr("disabled", true);
    customernama.find(`.button-clear`).attr("disabled", true);
    customernama.prop('readonly', true)
  }

  function editingAt(id, btn) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `{{ config('app.api_url') }}pesananheader/editingat`,
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

  function editPesananHeader(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'edit')
    $('#crudModalTitle').text('Edit Pesanan')
    form.trigger('reset')
    form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
    form.find(`.sometimes`).hide()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPesananHeader(form, id),
        editingAt(id, 'EDIT'),
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

  function deletePesananHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
                  <i class="fa fa-save"></i>
                  Hapus
                `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Hapus Pesanan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPesananHeader(form, id)
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

  function viewPesananHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pesanan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPesananHeader(form, userId)
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
        url: `${apiUrl}pesananheader/field_length`,
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

  function showPesananHeader(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}pesananheader/${userId}`,
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

            if (index == 'customernama') {
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
            <th style="width: 250px; min-width: 250px;">Produk</th>
            <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
            <th class="wider-qty" style="width: 170px; min-width: 130px;">Satuan</th>
            <th class="wider-keterangan" style="width: 300px; min-width: 750px;">Keterangan</th>
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
                    <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="qty[]" class="form-control lg-form autonumeric " autocomplete="off" ">
                  </td>
                  <td class="table-bold">
                    <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                  </td>
            </tr>`)

              detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              detailRow.find(`[name="productid[]"]`).val(detail.productid)
              detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
              detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)

              initAutoNumeric(detailRow.find(`[name="qty[]"]`))


              $('#detailList tbody').append(detailRow)

              rowIndex = index

              initDatepicker()
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              initLookupDetail(rowIndex);
             

              clearButton('detailList', `#detail_${index}`)
              setRowNumbers()

            })
          } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
      
            <th style="width: 500px; min-width: 250px;">No. Produk</th>
          
              `);

            // Sisipkan elemen <th> di awal baris
            $('#detailList thead tr').prepend(tableHeader);

         
            $.each(response.detail, (index, detail) => {
              selectIndex = index;
            
              let detailRow = $(`
            <tr>
            
            <td class="table-bold">
              <label class="col-form-label mt-2" style="font-size:16px">${index+1}. &ensp; produk</label>
                <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                <input type="text" name="product_name[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
                <br>
               
                <label class="col-form-label mt-2" style="font-size: 16px; min-width: 50px;">QTY </label>
                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" >
                <br>

                <label class="col-form-label mt-2" style="font-size: 16px; min-width: 50px;">Satuan </label>
                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" style="width: 10%!important;" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
               
                <br>
                <label class="col-form-label" style="font-size:16px">KETERANGAN</label>
                <input type="text" name="keterangandetail[]" class="form-control  lg-form" autocomplete="off" ">
              </td>
             
             
             
        </tr> `)

              detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              detailRow.find(`[name="productid[]"]`).val(detail.productid)
              detailRow.find(`[name="product_name[]"]`).val(detail.productnama)
              detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)

           
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

          selectIndex += 1;

        
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

      let tableHeader = $(`
        <th style="width: 50px; min-width: 50px;">No.</th>
        <th style="width: 250px; min-width: 250px;">Produk</th>
        <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
        <th class="wider-qty" style="width: 170px; min-width: 130px;">Satuan</th>
        <th class="wider-keterangan" style="width: 300px; min-width: 750px;">Keterangan</th>
    `);

    // Sisipkan elemen <th> di awal baris
    $('#detailList thead tr').prepend(tableHeader);

      for (let i = 0; i < 50; i++) {
        let detailRow = $(`
            <tr>
              <td class="table-bold">
                
            </td>
            <td class="table-bold">
                <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off" autofocus>
              </td>
              <td class="table-bold">
                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td class="table-bold">
                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
              </td>
              <td class="table-bold">
                <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
              </td>
        </tr>`)



        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

        // Jika baris diisi, tambahkan kelas 'filled-row'
        detailRow.on('input', 'input[name="productnama[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let isRowFilled =
              value.trim() !== "" ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() !== '' ||
              qtycek !== 0;

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
          let isRowFilled =
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              value.trim() !== "" ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() != '' ||
              qtycek !== 0;

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
          let isRowFilled =
              value.trim() !== '' ||
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              qtycek !== 0;

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

          let isRowFilled =
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() != '' ||
              qtycek !== 0;
        
          if (isRowFilled) {
              currentRow.addClass('filled-row');
          } else {
              currentRow.removeClass('filled-row');
          }
        });

        $('#detailList tbody').append(detailRow)

      
        initAutoNumeric(detailRow.find('.autonumeric'))

      
        clearButton(form, `#addRow_${selectIndex}`)

        rowLookup = selectIndex

        initLookupDetail(selectIndex);
        initSelect2($(`[name="statusaktif"]`), true)
        setRowNumbers()

        selectIndex++
      }


    } else if (detectDeviceType() == "mobile") {
      let tableHeader = $(`
      
      <th style="width: 500px; min-width: 250px;">No. Produk</th>
        <th class="wider-qty" style="width: 225px; min-width: 225px;">Qty</th>
        <th class="wider-keterangan" style="width: 300px; min-width: 150px;">Keterangan</th>
    `);

    // Sisipkan elemen <th> di awal baris
    $('#detailList thead tr').prepend(tableHeader);


      $(".wider-qty").remove();
      $(".wider-keterangan").remove();
      $("#colspan").attr("colspan", "3");
      for (let i = 0; i < 50; i++) {

        let urut  = i+1;

        let detailRow = $(`
            <tr>
            
            <td class="table-bold">
              <label class="col-form-label mt-2" style="font-size:13x">${urut}. &ensp; produk</label>
                <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">


                <div class="d-flex align-items-center mt-2 mb-2">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY </label>
                      <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </div>

                    <div class="col-6">
                      <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">Satuan </label>
                      <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                      <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" style="width: 10%!important;" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                    </div>
                  </div>
                </div>

                <label class="col-form-label" style="font-size:13px">KETERANGAN</label>
                <input type="text" name="keterangandetail[]" class="form-control  lg-form" autocomplete="off" ">
              </td>
             
             
             
        </tr> `)

        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

        // Jika baris diisi, tambahkan kelas 'filled-row'
        detailRow.on('input', 'input[name="productnama[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));
          let isRowFilled =
              value.trim() !== "" ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() !== '' ||
              qtycek !== 0;

          console.log('isRowFilled',isRowFilled)
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
          let isRowFilled =
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              value.trim() !== "" ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() != '' ||
              qtycek !== 0;

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
          let isRowFilled =
              value.trim() !== '' ||
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              qtycek !== 0;

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

          let isRowFilled =
              currentRow.find('input[name="productnama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="satuannama[]"]').val().trim() !== '' ||
              currentRow.find('input[name="keterangandetail[]"]').val().trim() != '' ||
              qtycek !== 0;
        
          if (isRowFilled) {
              currentRow.addClass('filled-row');
          } else {
              currentRow.removeClass('filled-row');
              $(this).removeClass('filled-row-done');
          }
        });
       

        $('#detailList tbody').append(detailRow)
        initDatepicker()

        initAutoNumeric(detailRow.find('.autonumeric'))

        // paginateSelect2(`#addRow_${selectIndex}`, 'customer')
        clearButton(form, `#addRow_${selectIndex}`)

        rowLookup = selectIndex

        initLookupDetail(selectIndex);

        // setRowNumbers()

        selectIndex++
      }
    }



  }

  function initLookupDetail(index) {
    let rowLookup = index;

    $(`.item-lookup${rowLookup}`).lookup({
      title: 'Item Lookup',
      fileName: 'product',
      detail: true,
      miniSize : true,
      beforeProcess: function() {
        this.postData = {
          Aktif: 'AKTIF',
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

        // element.parents('tr').find('td [name="satuanid[]"]').addClass('filled-row')
        // element.parents('tr').find('td [name="satuannama[]"]').addClass('filled-row')

        element.parents('tr').find('td [name="qty[]"]').focus()

        item_id_input.val(item.id);

        element.val(item.nama);

        let valueItem = $(element).val();

        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));
      
        let isRowFilled = 
                    valueItem != '' ||
                    currentRow.find(`input[name="satuannama[]"]`).val() != '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val() != '' ||
                    qtycek != 0;
         
          if (isRowFilled) {
            console.log("onSelect",isRowFilled)
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }

        // element.addClass('filled-row')
        // item_id_input.addClass('filled-row')
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
        let isRowFilled = currentRow.find(`input[name="productnama[]"]`).val() != '' ||
                    currentRow.find(`input[name="satuannama[]"]`).val() != '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val() != '' ||
                    qtycek != 0;

          if (isRowFilled) {
            console.log("onclear",isRowFilled)
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }


        element.data('currentValue', element.val());
      },
    });

    $(`.satuan-lookup${rowLookup}`).lookup({
      title: 'Satuan Lookup',
      fileName: 'satuan',
      detail: true,
      miniSize : true,
      alignRightMobile:true,
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
          // typeSearch: 'ALL',
        };
      },
      onSelectRow: (satuan, element) => {

        let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`);


        satuan_id_input.val(satuan.id);

        element.val(satuan.nama);

        // element.addClass('filled-row')
        // satuan_id_input.addClass('filled-row')

        let valueItem = $(element).val();
        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));
        let isRowFilled = currentRow.find(`input[name="productnama[]"]`).val() != '' ||
                    currentRow.find(`input[name="satuannama[]"]`).val() != '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val() != '' ||
                    qtycek != 0;

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
        let isRowFilled = currentRow.find(`input[name="productnama[]"]`).val() != '' ||
                    currentRow.find(`input[name="satuannama[]"]`).val() != '' ||
                    currentRow.find(`input[name="keterangandetail[]"]`).val() != '' ||
                    qtycek != 0;

          

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
        url: `${apiUrl}pesananheader/default`,
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

    $('.customer-lookup').lookup({
      title: 'customer Lookup',
      fileName: 'customer',
      typeSearch: 'ALL',
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