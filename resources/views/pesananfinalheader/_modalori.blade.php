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
          <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
            <input type="hidden" name="id" class="filled-row">
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  no bukti <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control lg-form filled-row " readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  no bukti pesanan <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobuktipesanan" class="form-control lg-form filled-row " readonly>
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
                  <input type="text" name="tglbukti" id="tglbukti" class="form-control lg-form datepicker  filled-row" readonly>
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
                      {{-- <td colspan="3"></td> --}}
                      <td colspan="9">
                        <div class="row form-group">
                          <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label ">
                              sub total
                            </label>
                          </div>
                          <div class="col-md-2 text-right">
                            <input type="text" name="subtotal" id="subtotal" class="form-control  text-right lg-form filled-row" value="0">
                            {{-- <p class="text-right font-weight-bold " id="total">0</p> --}}
                          </div>
                        </div>

                        <div class="row form-group">
                          <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">tax</label>
                          </div>
                          <div class="col-md-2 text-right">
                            <div class="row">
                              <div class="col-md-5">
                                <div class="input-group">
                                  <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row small-input" value="0">
                                  <div class="input-group-append">
                                    <span class="input-group-text">% </span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form filled-row" value="0">
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="row form-group">
                          <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">
                              discount
                            </label>
                          </div>
                          <div class="col-md-2 text-right">
                            <input type="text" name="discount" id="discount" class="form-control  text-right lg-form filled-row" value="0">
                          </div>
                        </div>
                        <div class="row form-group">
                          <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label">
                              total
                            </label>
                          </div>
                          <div class="col-md-2 text-right">
                            <input type="text" name="total" id="total" class="form-control  text-right lg-form filled-row" value="0">
                          </div>
                        </div>
                      </td>
                      <td></td>
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
            <button class="btn btn-warning btn-cancel btn-batal">
              <i class="fa fa-times"></i>
              Tutup
            </button>
          </div>
        </form>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  let hasFormBindKeys = false
  let modalBody = $('#crudForm').find('.modal-body').html()


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


    $(document).on('input', `#table_body [name="qty[]"]`, function(event) {
      setTotalHarga($(this))
      setSubTotal()
      setTax()
      setTotal()
    })

    $(document).on('input', `#table_body [name="harga[]"]`, function(event) {
      setTotalHarga($(this))
      setSubTotal()
      setTax()
      setTotal()

    })


    $(document).on('input', `#crudForm .filled-row[name="tax"]`, function(event) {
      setTax()
      setTotal()
    })


    $(document).on('input', `#crudForm .filled-row[name="discount"]`, function(event) {
      setTotal()
      // calculateTax()

    })

    $(document).on('click', '.btn-batal', function(event) {
      event.preventDefault()
      if ($('#crudForm').data('action') == 'edit') {


        $.ajax({
          url: `{{ config('app.api_url') }}pesananfinalheader/editingat`,
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

      $('#crudForm tbody tr.filled-row').each(function(index, element) {

        if ($(this).hasClass('filled-row')) {

          let row_index = $(this).index();
          data.push({
            name: `productid[${row_index}]`,
            value: $(this).find(`[name="productid[]"]`).val()
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
            name: `qtyreturjual[${row_index}]`,
            value: parseFloat($(this).find(`[name="qtyreturjual[]"]`).val().replace(/,/g, ''))
          })
          data.push({
            name: `qtyreturbeli[${row_index}]`,
            value: parseFloat($(this).find(`[name="qtyreturbeli[]"]`).val().replace(/,/g, ''))
          })
          data.push({
            name: `harga[${row_index}]`,
            value: parseFloat($(this).find(`[name="harga[]"]`).val().replace(/,/g, ''))
          })
        }
      })



      $('#crudForm').find(`.filled-row[name="qty[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="qty[]"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="harga[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="harga[]"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="discount"]`).each((index, element) => {
        data.filter((row) => row.name === 'discount')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="discount"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="taxamount"]`).each((index, element) => {
        data.filter((row) => row.name === 'taxamount')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="taxamount"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="total"]`).each((index, element) => {
        data.filter((row) => row.name === 'total')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="total"]`)[index])
      })

      $('#crudForm').find(`.filled-row[name="subtotal"]`).each((index, element) => {
        data.filter((row) => row.name === 'subtotal')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="subtotal"]`)[index])
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
          url = `${apiUrl}pesananfinalheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pesananfinalheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pesananfinalheader/${Id}?periode=${periode}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pesananfinalheader`
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


    importForm.on('input', function() {
      importForm.data('hasChanged', true)
    })

    importForm.on('submit', function(event) {
      event.preventDefault()
      importItem(importForm)
    })

  })

  function setTotalHarga(element, id = 0) {

    let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
    let hargasatuan = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
    // Menghitung total amount
    let amount = qty * hargasatuan;

    // Menginisialisasi AutoNumeric untuk input totalharga dengan nilai amount
    initAutoNumericNoDoubleZero(element.parents('tr').find(`[name="totalharga[]"]`).val(amount))
  }

  function generateTotalHarga(element) {

    let hargasatuan = parseFloat(element.parents('tr').find(`td [name="harga[]"]`).val().replace(/,/g, ''))
    initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(hargasatuan))

  }

  function setSubTotal() {
    let nominalDetails = $(`#detailList [name="totalharga[]"]`)
    let total = 0
    $.each(nominalDetails, (index, nominalDetail) => {

      total += AutoNumeric.getNumber(nominalDetail)
    });

    initAutoNumericNoDoubleZero($(`#detailList [name="subtotal"]`).val(total))


    // new AutoNumeric('#total').set(total)
    // new AutoNumeric('#subtotal').set(total)
  }

  function setTotal() {
    let grandtotal;

    let total = AutoNumeric.getNumber($(`#crudForm .filled-row[name="subtotal"]`)[0])
    let disc = AutoNumeric.getNumber($(`#crudForm .filled-row[name="discount"]`)[0])
    let taxamount = AutoNumeric.getNumber($(`#crudForm .filled-row[name="taxamount"]`)[0])

    grandtotal = total + taxamount - disc
    initAutoNumericNoDoubleZero($(`#total`).val(grandtotal))
  }

  function setTax() {
    let result;
    let total = AutoNumeric.getNumber($(`#crudForm .filled-row[name="subtotal"]`)[0])
    let taxlabel = $(`#crudForm .filled-row[name="tax"]`).val()
    result = (taxlabel / 100) * total;
    initAutoNumericNoDoubleZero($(`#taxamount`).val(result))
  }

  function setHarga(element) {
    let setharga;

    let totalharga = AutoNumeric.getNumber(element.parents('tr').find(`td [name="totalharga[]"]`)[0])
    let qty = AutoNumeric.getNumber(element.parents('tr').find(`td [name="qty[]"]`)[0])
  }

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
    initLookup()
    getMaxLength(form)
    initDatepicker()

  });

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    initDatepicker('datepickerIndex')
  })

  function createPesananFinalHeader() {
    let form = $('#crudForm')
    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
    form.data('action', 'add')
    $('#crudModalTitle').text('create pesanan final')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#table_body').html('')
    $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    var besok = new Date();
    besok.setDate(besok.getDate() + 1);
    $('#crudForm').find('[name=tglpengiriman]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

    Promise
      .all([
        showDefault(form),
        setStatusOptions(form),
      ])
      .then(() => {
        $('#crudModal').modal('show')
        addRow()
        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
        form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
        // form.find(`[name="harga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="nobukti"]`).prop('disable', true)
        setDefault(form)
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

    initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="total"]`))
  }

  function enableLookup() {

    let customernama = $('#crudForm').find(`[name="customernama"]`).parents('.input-group').children()
    customernama.find(`.lookup-toggler`).attr("disabled", true);
    customernama.find(`.button-clear`).attr("disabled", true);
    customernama.prop('readonly', true)

  }

  function editingAt(id, btn) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `{{ config('app.api_url') }}pesananfinalheader/editingat`,
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

  function editPesananFinalHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'edit')
    form.trigger('reset')
    $('#crudModalTitle').text('edit pesanan final')
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
        showPesananFinalHeader(form, id)
          .then((response) => {
            $('#crudModal').modal('show')


            if (!response.data.nobuktipesanan) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              enableLookup()
            }



            setSubTotal()
            setTax()
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

  function disabledDetail(detail) {
    detail.find(`[name="keterangandetail[]"]`).prop('readonly', true)
    detail.find(`[name="productid[]"]`).prop('readonly', true)
    detail.find(`[name="productnama[]"]`).prop('readonly', true)
    detail.find(`[name="satuanid[]"]`).prop('readonly', true)
    detail.find(`[name="satuannama[]"]`).prop('readonly', true)
    detail.find(`[name="qty[]"]`).prop('readonly', true)
    detail.find(`[name="qtyreturjual[]"]`).prop('readonly', true)
    detail.find(`[name="harga[]"]`).prop('readonly', true)
    detail.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')


    let productnama = $(`#crudForm [name="productnama[]"]`)
    productnama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
    productnama.parent('.input-group').find('.button-clear').prop('disabled', true);

    let satuannama = $(`#crudForm [name="satuannama[]"]`)
    satuannama.parent('.input-group').find('.lookup-toggler').prop('disabled', true);
    satuannama.parent('.input-group').find('.button-clear').prop('disabled', true);

    $('#crudForm').find(`.delete-row`).prop('disabled', true);
  }

  function deletePesananFinalHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('delete pesanan final')
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
        setStatusOptions(form)
      ])
      .then(() => {
        showPesananFinalHeader(form, id)
          .then((response) => {

            $('#crudModal').modal('show')


            if (!response.data.nobuktipesanan) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              enableLookup()
            }

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function viewPesananFinalHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('view pesanan final')
    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([

        setStatusOptions(form)
      ])
      .then(() => {
        showPesananFinalHeader(form, userId)
          .then((response) => {
            $('#crudModal').modal('show')
            if (!response.data.nobuktipesanan) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')

              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              enableLookup()
            }

            form.find(`.tbl_aksi`).hide()

          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `${apiUrl}pesananfinalheader/${Id}/cekValidasiAksi`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'EDIT') {
            editPesananFinalHeader(selectedId)
          }
          if (Aksi == 'DELETE') {
            deletePesananFinalHeader(selectedId)
          }
        }

      }
    })
  }

  function combainPesananFinalHeader() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}pesananfinalheader/combain`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        pesananfinalheaderid: selectedRows,
        periode: $('#formCrud').find('[name=periode]').val(),
        filters: JSON.stringify({
          groupOp: "AND",
          rules: [{
              field: "",
              op: "cn",
              data: "on"
            },
            {
              field: "statusmemo",
              op: "eq",
              data: "AKTIF"
            }
          ]
        })
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        id = response.data.id

        $('#jqGrid').jqGrid('setGridParam', {
          page: response.data.page,
          postData: {
            periode: dateFormat(response.data.tglpengiriman),
            filters: JSON.stringify({
              groupOp: "AND",
              rules: [{
                  field: "",
                  op: "cn",
                  data: "on"
                },
                {
                  field: "statusmemo",
                  op: "eq",
                  data: "AKTIF"
                }
              ]
            })
          }
        }).trigger('reloadGrid');

        selectedRows = []
        $('#gs_').prop('checked', false)
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
  }

  function generatePenjualan() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}penjualanheader/generatepenjualan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        pesananfinalheaderid: selectedRows
      },
      success: response => {

        if (response.status == true) {
          showDialog(response.message)
        } else {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
          }).trigger('reloadGrid');

          selectedRows = []
          $('#gs_').prop('checked', false)
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
  }

  function batalPenjualan() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}penjualanheader/batalpenjualan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        pesananfinalheaderid: selectedRows
      },
      success: response => {
        if (response.status == true) {
          showDialog(response.message)
        } else {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
          }).trigger('reloadGrid');

          selectedRows = []
          $('#gs_').prop('checked', false)
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
  }

  function filterPembelian() {
    $.ajax({
      url: `${apiUrl}pembelianheader/filtertglpengiriman`,
      method: 'GET',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: function(response) {
        if (response.status == false) {
          showDialog(response.message);
        } else {
          var filterpembelian = response.data
          generatePembelian(filterpembelian)
        }
      },
      error: function(error) {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON.message);
        }
      }
    })
  }

  function generatePembelian(filterpembelian) {
    $.ajax({
      url: `${apiUrl}pembelianheader/generatepembelian`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        pembelianheaderId: filterpembelian
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        id = response.data.id

        $('#jqGrid').jqGrid('setGridParam', {
          page: response.data.page,
        }).trigger('reloadGrid');

        filterpembelian = []
        $('#gs_').prop('checked', false)
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function hapusPembelian() {
    $.ajax({
      url: `${apiUrl}pembelianheader/hapuspembelian`,
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tglpengiriman: $('#rangeTglPengiriman').find('[name="tglpengiriman"]').val()
      },
      success: function(response) {
        $('#rangeTglPengiriman').modal('hide')
        $('#jqGrid').jqGrid('setGridParam', {
          page: response.data.page,
        }).trigger('reloadGrid');

        showSuccessDialog(response.message)

      },
      error: function(error) {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {}
      }
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
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
          })

          form.attr('has-maxlength', true)
        },
        error: error => {
          showDialog(error.statusText)
        }
      })
    }
  }

  function showPesananFinalHeader(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}pesananfinalheader/${userId}`,
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
            <th style="width: 50px; min-width: 50px;" >No.</th>
            <th style="width: 250px; min-width: 200px;">Produk</th>
            <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
            <th class="wider-qty" style="width: 170px; min-width: 130px;">Satuan</th>
            <th class="wider-keterangan" style="width: 300px; min-width: 225px;">Keterangan</th>
            <th class="wider-qty text-right"  style="width: 300px; min-width: 100px;">Qty Retur Jual</th>
            <th class="wider-qty text-right"  style="width: 300px; min-width: 100px;">Qty Retur Beli</th>
            <th class="wider-harga text-right" style="width: 120px; min-width: 150px;">Harga</th>
            <th class="wider-keterangant text-right" style="width: 120px; min-width: 200px;">Total</th>
            <th  style="width: 100px; min-width: 100px;" class="tbl_aksi">Aksi</th>

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
                    <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control filled-row lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                  </td>
                  <td class="table-bold">
                    <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="keterangandetail[]" class="form-control filled-row lg-form " autocomplete="off" >
                  </td>
                  <td class="table-bold">
                    <input type="text" name="qtyreturjual[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="qtyreturbeli[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                  </td>
                  <td id="harga${selectIndex}" class="table-bold"> 
                    <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="0" >
                  </td>
                  <td id="total${selectIndex}" class="table-bold">
                    <input type="text" name="totalharga[]" class="form-control filled-row lg-form autonumeric " autocomplete="off" value="0">
                  </td>
                  <td class="tbl_aksi table-bold">
                      <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                  </td>
                  
                
            </tr>`)

              detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              detailRow.find(`[name="productid[]"]`).val(detail.productid)
              detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
              detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)
              detailRow.find(`[name="qtyreturjual[]"]`).val(detail.qtyreturjual)
              detailRow.find(`[name="qtyreturbeli[]"]`).val(detail.qtyreturbeli)
              detailRow.find(`[name="harga[]"]`).val(detail.harga)
              detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)

              initAutoNumericNoDoubleZero(detailRow.find(`[name="harga[]"]`))
              initAutoNumeric(detailRow.find(`[name="qty[]"]`))
              initAutoNumeric(detailRow.find(`[name="qtyreturjual[]"]`))
              initAutoNumeric(detailRow.find(`[name="qtyreturbeli[]"]`))
              initAutoNumericNoDoubleZero(detailRow.find(`[name="totalharga[]"]`))

              // Jika baris diisi, tambahkan kelas 'filled-row'
              detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //produk nama
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //satuan nama
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //keterangan
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
                  TotalHargaCek !== 0;

                if (isRowFilled) {
                  currentRow.addClass('filled-row');
                } else {
                  currentRow.removeClass('filled-row');
                }
              });

              detailRow.on('input', 'input[name="qtyreturjual[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
                  TotalHargaCek !== 0;

                if (isRowFilled) {
                  currentRow.addClass('filled-row');
                } else {
                  currentRow.removeClass('filled-row');
                }
              });

              detailRow.on('input', 'input[name="qtyreturbeli[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = ($(this).val().val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

              // setSubTotal()
              setRowNumbers()

            })


            initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="total"]`))

            setTotal()
            addRow(response.detail.length)
            
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
                <td  class="table-bold">
                  <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">${index+1}. &ensp; produk</label>
                    <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">

                        <div class="d-flex align-items-center">
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

                  
                      <div class="d-flex align-items-center">
                          <div class="row">
                            <div class="col-6">
                              <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY RETUR JUAL</label>
                              <input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                            </div>

                            <div class="col-6">
                              <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY RETUR BELI</label>
                              <input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                            </div>
                          </div>
                      </div>
                      
                      
                      <div class="d-flex align-items-center mt-2 ">
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
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                </td>
               </tr> `)

              detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              detailRow.find(`[name="productid[]"]`).val(detail.productid)
              detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
              detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)
              detailRow.find(`[name="harga[]"]`).val(detail.harga)
              detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)

              // Jika baris diisi, tambahkan kelas 'filled-row'
              detailRow.on('input', 'input[name="productnama[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //produk nama
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //satuan nama
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  value.trim() !== "" || //keterangan
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
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

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
                  TotalHargaCek !== 0;

                if (isRowFilled) {
                  currentRow.addClass('filled-row');
                } else {
                  currentRow.removeClass('filled-row');
                }
              });

              detailRow.on('input', 'input[name="qtyreturjual[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
                  TotalHargaCek !== 0;

                if (isRowFilled) {
                  currentRow.addClass('filled-row');
                } else {
                  currentRow.removeClass('filled-row');
                }
              });

              detailRow.on('input', 'input[name="qtyreturbeli[]"]', function() {
                let value = $(this).val();

                let currentRow = $(this).closest('tr');
                let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

                let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

                let qtyReturBeliCek = ($(this).val().val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

                let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

                let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

                let isRowFilled =
                  currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
                  currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
                  qtycek !== 0 ||
                  qtyReturJualCek !== 0 ||
                  qtyReturBeliCek !== 0 ||
                  HargaCek !== 0 ||
                  TotalHargaCek !== 0;

                if (isRowFilled) {
                  currentRow.addClass('filled-row');
                } else {
                  currentRow.removeClass('filled-row');
                }
              });

              $('#detailList tbody').append(detailRow)
              rowIndex = index
              initAutoNumericNoDoubleZero(detailRow.find(`[name="totalharga[]"]`))
              initDatepicker()
              initLookupDetail(rowIndex);
              clearButton('detailList', `#detail_${index}`)
            })

            addRow(response.detail.length)
            form.find(`[name="subtotal"]`).val(response.data.subtotal)
            form.find(`[name="tax"]`).val(response.data.tax)
            form.find(`[name="taxamount"]`).val(response.data.taxamount)
            form.find(`[name="discount"]`).val(response.data.discount)
            form.find(`[name="total"]`).val(response.data.total)
            initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="total"]`))

            setSubTotal()
            setTotal()
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
            <th style="width: 50px; min-width: 50px;" >No.</th>
            <th style="width: 250px; min-width: 200px;">Produk</th>
            <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
            <th class="wider-qty" style="width: 170px; min-width: 130px;">Satuan</th>
            <th class="wider-keterangan" style="width: 300px; min-width: 225px;">Keterangan</th>
            <th class="wider-qty text-right"  style="width: 300px; min-width: 100px;">Qty Retur Jual</th>
            <th class="wider-qty text-right"  style="width: 300px; min-width: 100px;">Qty Retur Beli</th>
            <th class="wider-harga text-right" style="width: 120px; min-width: 150px;">Harga</th>
            <th class="wider-keterangan text-right" style="width: 120px; min-width: 200px;">Total</th>
            <th  style="width: 100px; min-width: 100px;" class="tbl_aksi">Aksi</th>
    `);

      // Sisipkan elemen <th> di awal baris
      if (!show) {
        $('#detailList thead tr').prepend(tableHeader);
      } else {
        selectIndex = show
      }

      for (let i = show; i < 50; i++) {

        let detailRow = $(`
            <tr data-trindex="${selectIndex}" >
              <td  >
            </td>
              <td >
                <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
              </td>
              <td  >
                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td  >
                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" data-current-value="KG" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
              </td>
              <td  >
                <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
              </td>
              <td  >
                <input type="text" name="qtyreturjual[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td  >
                <input type="text" name="qtyreturbeli[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
             
              <td id="harga${selectIndex}" >
                <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0">
              </td>
              <td id="total${selectIndex}" >
                <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0" >
              </td>
              <td class="tbl_aksi ">
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
              
            
        </tr>`)
        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

        // Jika baris diisi, tambahkan kelas 'filled-row'
        detailRow.on('input', 'input[name="productnama[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //produk nama
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //satuan nama
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //keterangan
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
            TotalHargaCek !== 0;

          if (isRowFilled) {
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }
        });

        detailRow.on('input', 'input[name="qtyreturjual[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
            TotalHargaCek !== 0;

          if (isRowFilled) {
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }
        });

        detailRow.on('input', 'input[name="qtyreturbeli[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = ($(this).val().val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
            TotalHargaCek !== 0;

          if (isRowFilled) {
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }
        });


        let newTd = $(`
              <td class="tbl_aksi">
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
          `);
        $('#detailList tbody').append(detailRow)
        initAutoNumeric(detailRow.find('.autonumeric'))
        initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
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
    `);

      $(".wider-qty").remove();
      $(".wider-keterangan").remove();

      let newTfoot = $(`
        <tfoot>
          <tr>
              <td colspan="9">
                  <div class="row form-group">
                      <div class="col-12 col-md-10 text-lg-right">
                          <label class="col-form-label">
                              Subtotal
                          </label>
                      </div>
                      <div class="col-md-2 text-right">
                          <input type="text" name="subtotal" id="subtotal" class="form-control text-right lg-form filled-row" value="0">
                      </div>
                  </div>

                  <div class="d-flex align-items-center mt-2 mb-2">
                      <div class="row">
                          <div class="col-6">
                              <label class="col-form-label">Tax</label>
                              <div class="input-group">
                                  <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row small-input" value="0">
                                  <div class="input-group-append">
                                      <span class="input-group-text">%</span>
                                  </div>
                              </div>
                          </div>

                          <div class="col-6">
                              <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form filled-row mt-4" value="0">
                          </div>
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col-12 col-md-10 text-lg-right">
                          <label class="col-form-label">
                              Discount
                          </label>
                      </div>
                      <div class="col-md-2 text-right">
                          <input type="text" name="discount" id="discount" class="form-control text-right lg-form filled-row" value="0">
                      </div>
                  </div>

                  <div class="row form-group">
                      <div class="col-12 col-md-10 text-lg-right">
                          <label class="col-form-label">
                              Total
                          </label>
                      </div>
                      <div class="col-md-2 text-right">
                          <input type="text" name="total" id="total" class="form-control autonumeric-nozero text-right lg-form filled-row" value="0">
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
              <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">${urut}. &ensp; produk</label>
                <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form numeric item-lookup${selectIndex}" autocomplete="off">
                <div class="d-flex align-items-center mt-2 mb-2">
                  <div class="row">
                    <div class="col-6">
                    <label class="col-form-label  label-mobile" style=" min-width: 25px;">QTY </label>
                    <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </div>
                    <div class="col-6">
                    <label class="col-form-label label-mobile" style=" min-width: 50px;">SATUAN </label>
                    <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}"  class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label mt-2 " style="font-size: 13px; min-width: 50px;">QTY RETUR JUAL</label>
                      <input type="text" name="qtyreturjual[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                    </div>
                    <div class="col-6">
                      <label class="col-form-label mt-2 " >QTY RETUR BELI</label>
                      <input type="text" name="qtyreturbeli[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
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
                    </div>
                  </div>
                </div>
                <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">
                <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
        </tr> `)

        tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');

        // Jika baris diisi, tambahkan kelas 'filled-row'
        detailRow.on('input', 'input[name="productnama[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //produk nama
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //satuan nama
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            value.trim() !== "" || //keterangan
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
            TotalHargaCek !== 0;

          if (isRowFilled) {
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }
        });

        detailRow.on('input', 'input[name="qtyreturjual[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
            TotalHargaCek !== 0;

          if (isRowFilled) {
            currentRow.addClass('filled-row');
          } else {
            currentRow.removeClass('filled-row');
          }
        });

        detailRow.on('input', 'input[name="qtyreturbeli[]"]', function() {
          let value = $(this).val();

          let currentRow = $(this).closest('tr');
          let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

          let qtyReturBeliCek = ($(this).val().val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

          let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

          let isRowFilled =
            currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
            currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
            qtycek !== 0 ||
            qtyReturJualCek !== 0 ||
            qtyReturBeliCek !== 0 ||
            HargaCek !== 0 ||
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
        initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="total"]`))


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
          searching: 1,
          valueName: `ItemId_${index}`,
          id: `ItemId_${rowLookup}`,
          searchText: `item-lookup${rowLookup}`,
          singleColumn: true,
          hideLabel: true,
          title: 'Produk',
          customerid: $('#crudForm').find('[name=customerid]').val(),
          // limit: 0
          // typeSearch: 'ALL',
        };
      },
      onSelectRow: (item, element) => {

        let item_id_input = element.parents('td').find(`[name="productid[]"]`);

        element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
        element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)

        // element.parents('tr').find('td [name="harga[]"]').val(item.hargajual)
        if (detectDeviceType() == "desktop") {

          element.parents('tr').find(`td [name="harga[]"]`).remove();
          element.parents('tr').find(`td [name="totalharga[]"]`).remove();

          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`
          let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric bg-white state-delete" value="0" readonly>`


          element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
          element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)

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

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          valueItem.trim() !== "" || //produk nama
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
          HargaCek !== 0 ||
          TotalHargaCek !== 0;

        if (isRowFilled) {
          currentRow.addClass('filled-row');
        } else {
          currentRow.removeClass('filled-row');
        }

        setTotalHarga(element)

        setSubTotal()
        // setTotal()

        element.data('currentValue', element.val());
        element.parents('tr').find('td [name="satuannama[]"]').data('currentValue', element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama))

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
        item_id_input.val('');
        element.val('');
        // element.parents('tr').find('td [name="harga[]"]').val(0)
        // element.parents('tr').find('td [name="harga[]"]').autoNumeric('wipe')

        if (detectDeviceType() == "desktop") {
          element.parents('tr').find(`td [name="harga[]"]`).remove();
          element.parents('tr').find(`td [name="totalharga[]"]`).remove();
          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`
          let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`

          element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
          element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)
        } else {
          // let elementharga = $('#detailList tbody tr td')

          element.parents('td').find(`[name="harga[]"]`).remove();
          element.parents('td').find(`[name="totalharga[]"]`).remove();
          $(`<input type="text" name="harga[]" class="form-control autonumeric" value="0">`).insertAfter(`#harga${rowLookup}`)
          $(`<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`).insertAfter(`#total${rowLookup}`)

        }

        initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))

        let valueItem = $(element).val();
        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          valueItem.trim() !== "" || //produk nama
          currentRow.find(`input[name="satuannama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

    $(`.satuan-lookup${rowLookup}`).lookup({
      title: 'Satuan Lookup',
      fileName: 'satuan',
      detail: true,
      miniSize: true,
      rowIndex: rowLookup,
      totalRow: 49,
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
          limit: 0
        };
      },
      onSelectRow: (satuan, element) => {

        let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`);


        satuan_id_input.val(satuan.id);

        element.val(satuan.nama);

        let valueSatuan = $(element).val()
        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          valueSatuan.trim() !== "" || //satuan nama
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

        let valueSatuan = $(element).val()
        let currentRow = $(element).closest('tr');
        let qtycek = (currentRow.find('input[name="qty[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qty[]"]').val().replace(/,/g, ''));

        let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

        let qtyReturBeliCek = (currentRow.find('input[name="qtyreturbeli[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

        let HargaCek = (currentRow.find('input[name="harga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="harga[]"]').val().replace(/,/g, ''));

        let TotalHargaCek = (currentRow.find('input[name="totalharga[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="totalharga[]"]').val().replace(/,/g, ''));

        let isRowFilled =
          valueSatuan.trim() !== "" || //satuan nama
          currentRow.find(`input[name="productnama[]"]`).val().trim() !== '' ||
          currentRow.find(`input[name="keterangandetail[]"]`).val().trim() !== '' ||
          qtycek !== 0 ||
          qtyReturJualCek !== 0 ||
          qtyReturBeliCek !== 0 ||
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

  var SetDefaultValue;

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pesananfinalheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          SetDefaultValue = response.data
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

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
      updateUrut()
      setSubTotal()
    }
  }

  function updateUrut() {
    let elements = $('#detailList tbody tr');

    elements.each((index, row) => {
      let labelTopElement = $(row).find('td.table-bold .label-top');
      labelTopElement.text(index + 1 + ". produk");
    });
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

  function unApprovalReportPembelian(dari) {
    $.ajax({
      url: `${apiUrl}pesananfinalheader/unapproval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tglpengiriman: dari
      },
      success: function(response) {
        showSuccessDialog(response.message)
        $('#confirmModal').modal('hide')
      },
      error: function(error) {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          // showDialog(error.responseJSON.message);
        }
      }
    })
  }
</script>
@endpush()