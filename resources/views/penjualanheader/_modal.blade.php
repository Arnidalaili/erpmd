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
            <input type="text" name="nobuktipesananfinal" class="form-control lg-form filled-row " hidden>
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
                  TOP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="top" class="filled-row">
                <input type="text" name="topnama" id="topnama" class="form-control lg-form top-lookup filled-row" autocomplete="off">
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
            </div>
            --}}
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
                      <td colspan="9">
                        <div class="row form-group">
                          <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label ">
                              sub total
                            </label>
                          </div>
                          <div class="col-md-2 text-right">
                            <input type="text" name="subtotal" id="subtotal" class="form-control  text-right lg-form filled-row" value="0">
                          </div>
                        </div>
                        <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row small-input" value="0" hidden>
                        <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form filled-row" value="0" hidden>
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
      // setStok($(this))
      // setStokEdit($(this))
      setTotalHarga($(this))
      setSubTotal()
      setTax()
      setTotal()
    })

    $(document).on('input', `#table_body [name="qtyreturjual[]"]`, function(event) {
      checkJumlahQtyretur($(this))
      zeroQtyReturJual($(this))
      setQtyReturBeli($(this))
      // setTotalHarga($(this))
      // setSubTotal()
      // setTax()
      // setTotal()
    })

    $(document).on('input', `#table_body [name="qtyreturbeli[]"]`, function(event) {
      zeroQtyReturBeli($(this))
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

    })

    $(document).on('click', '.btn-batal', function(event) {
      event.preventDefault()
      btnClickEdit()
    })

    function checkJumlahQtyretur(element) {
      let idDetail = element.parents('tr').find('td [name="id[]"]').val();
      let id = element.parents('tr').find('td [name="id[]"]').val();

      $.ajax({
        url: `${apiUrl}penjualanheader/cekjumlahqtyretur`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          iddetail: idDetail,
          id: $('#crudForm').find('[name=id]').val()
        },
        success: response => {
          let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
          let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

          let sisaqtyretur = qty - response.data.totalqtyretur
          let amountqtyretur = qtyreturjual + response.data.totalqtyretur

          if (amountqtyretur > qty) {
            elementSecond = $(element.closest('tr').find(`[name="harga[]"]`))

            element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()

            let newQtyReturEl = `<input type="text" name="qtyreturjual[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">`
            // console.log(sisaqtyretur, amountqtyretur)
            elementSecond.parents('tr').find(`.qtyreturjual`).append(newQtyReturEl)

            initAutoNumeric($(elementSecond.parents('tr').find(`input[name="qtyreturjual[]"]`)))

            showDialog(`Maksimal input qty retur = ${sisaqtyretur} !`)
          }

          if (qtyreturjual > qty) {
            showDialog(`Maksimal input qty retur = ${qty} !`)
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
      })
    }

    // function modalCheckQty(response, element) {
    //   let qtyPenjualan = response.qtypenjualan
    //   let qtyretur = response.qtyretur

    //   let jumlahKeseluruhan = qtyPenjualan + qtyretur

    //   let qtyreturCheck = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
    //   let originalqtyCheck = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    //   let amountqtyCheck = originalqtyCheck - qtyreturCheck

    //   let qtyreturValue = qtyreturCheck

    //   // console.log(qtyreturValue,jumlahKeseluruhan);
    //   let parentQtyRetur = element.parents('tr').find(`.qtyretur`)
    //   if (qtyreturValue > jumlahKeseluruhan && jumlahKeseluruhan != '') {
    //     element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()

    //     let newQtyretur = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`

    //     parentQtyRetur.append(newQtyretur)

    //     elementParentQtyRetur = parentQtyRetur.find(`[name="qtyreturjual[]"]`)

    //     initAutoNumeric(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
    //     initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

    //     showDialog('Qty retur tidak boleh melebihi qty jual');
    //   } else if (amountqtyCheck < 0) {
    //     element.parents('tr').find(` [name="qtyreturjual[]"]`).remove()

    //     let newQtyretur = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`

    //     parentQtyRetur.append(newQtyretur)

    //     elementParentQtyRetur = parentQtyRetur.find(`[name="qtyreturjual[]"]`)

    //     initAutoNumeric(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
    //     initAutoNumeric(elementParentQtyRetur.parents('tr').find(`td [name="qty[]"]`).val(originalqtyCheck))

    //     showDialog('Qty retur tidak boleh melebihi qty jual');
    //   }
    // }

    function btnClickEdit() {
      if ($('#crudForm').data('action') == 'edit') {
        $.ajax({
          url: `{{ config('app.api_url') }}penjualanheader/editingat`,
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
    }


    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      // let data = $('#crudForm .filled-row').serializeArray()
      let data = []
      let details = []


      data.push({
        name: `nobukti`,
        value: form.find(`[name="nobukti"]`).val()
      })

      data.push({
        name: `id`,
        value: Id
      })

      data.push({
        name: `nobuktipesananfinal`,
        value: form.find(`[name="nobuktipesananfinal"]`).val()
      })

      data.push({
        name: `tglbukti`,
        value: form.find(`[name="tglbukti"]`).val()
      })

      data.push({
        name: `customerid`,
        value: form.find(`[name="customerid"]`).val()
      })

      data.push({
        name: `customernama`,
        value: form.find(`[name="customernama"]`).val()
      })

      data.push({
        name: `top`,
        value: form.find(`[name="top"]`).val()
      })

      data.push({
        name: `topnama`,
        value: form.find(`[name="topnama"]`).val()
      })

      data.push({
        name: `alamatpengiriman`,
        value: form.find(`[name="alamatpengiriman"]`).val()
      })

      data.push({
        name: `tglpengiriman`,
        value: form.find(`[name="tglpengiriman"]`).val()
      })

      data.push({
        name: `keterangan`,
        value: form.find(`[name="keterangan"]`).val()
      })


      data.push({
        name: `subtotal`,
        value: AutoNumeric.getNumber(form.find(`[name="subtotal"]`)[0])
      })
      data.push({
        name: `discount`,
        value: AutoNumeric.getNumber(form.find(`[name="discount"]`)[0])
      })
      data.push({
        name: `total`,
        value: AutoNumeric.getNumber(form.find(`[name="total"]`)[0])
      })

      data.push({
        name: `tax`,
        value: form.find(`[name="tax"]`).val()
      })

      data.push({
        name: `taxamount`,
        value: AutoNumeric.getNumber(form.find(`[name="taxamount"]`)[0])
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

      $('#crudForm tbody tr.filled-row').each((index, element) => {
        const rowIndex = $(element).index();
        details[rowIndex] = {
          id: $(element).find(`[name="id[]"]`).val(),
          pesananfinaldetailid: $(element).find(`[name="pesananfinaldetailid[]"]`).val(),
          productid: $(element).find(`[name="productid[]"]`).val(),
          productnama: $(element).find(`[name="productnama[]"]`).val(),
          qty: AutoNumeric.getNumber($(form).find(`[name="qty[]"]`)[rowIndex]),
          satuanid: $(element).find(`[name="satuanid[]"]`).val(),
          satuannama: $(element).find(`[name="satuannama[]"]`).val(),
          keterangandetail: $(element).find(`[name="keterangandetail[]"]`).val(),
          qtyreturjual: AutoNumeric.getNumber($(form).find(`[name="qtyreturjual[]"]`)[rowIndex]),
          qtyreturbeli: AutoNumeric.getNumber($(form).find(`[name="qtyreturbeli[]"]`)[rowIndex]),
          harga: AutoNumeric.getNumber($(form).find(`[name="harga[]"]`)[rowIndex]),
          totalharga: AutoNumeric.getNumber($(form).find(`[name="totalharga[]"]`)[rowIndex]),
        };
      });

      // Convert the array to an object with indices as keys
      const detail = details.reduce((acc, item, index) => {
        acc[index] = item;
        return acc;
      }, {});



      // Stringify the object
      const jsonString = JSON.stringify(detail);

      data.push({
        name: 'detail',
        value: jsonString
      })


      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penjualanheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penjualanheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penjualanheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penjualanheader`
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
          btnClickEdit()
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

            setErrorMessagesNew(form, error.responseJSON.errors);
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

  function zeroQtyReturJual(element) {
    let qtyVal = element.val()
    let trIndex = $(element.parents('tr')).data('trindex')
    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
    if (element.val() == '') {
      $(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).remove()
      let newQtyEl = `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value="0">`
      elementSecond.parents('tr').find(`.qtyreturjual`).append(newQtyEl)
      initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturjual[]"]`)))
    }
  }

  function zeroQtyReturBeli(element) {
    let qtyVal = element.val()
    let trIndex = $(element.parents('tr')).data('trindex')
    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
    if (element.val() == '') {
      $(element.closest('tr').find(`input[name="qtyreturbeli[]"]`)).remove()
      let newQtyEl = `<input type="text" name="qtyreturbeli[]" class="form-control autonumeric" value="0">`
      elementSecond.parents('tr').find(`.qtyreturbeli`).append(newQtyEl)
      initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturbeli[]"]`)))
    }
  }

  function setQtys(element) {
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
    let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    let amountqty = originalqty - qtyreturjual
    if (isNaN(qtyreturjual) || qtyreturjual === 0) {
      amountqty = originalqty;
    }
    let parentQtyRetur = element.parents('tr').find(`.qtyreturjual`)
    initAutoNumeric(element.parents('tr').find(`td [name="qty[]"]`).val(amountqty))
    setTotalHarga(parentQtyRetur.find(`[name="qtyreturjual[]"]`))
  }

  function setTotalHarga(element, id = 0) {
    let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))

    let hargasatuan = parseFloat(element.parents('tr').find(`[name="harga[]"]`).val().replace(/,/g, ''))
    let amount = (qty - qtyreturjual) * hargasatuan;
    initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(amount))
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

  function setStok(element) {
    let qty = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
    let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
    let qtystok = parseFloat(element.parents('tr').find(` [name="qtystok[]"]`).val().replace(/,/g, ''))

    if (isNaN(originalqty)) {
      if (qtystok < qty) {
        showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtystok}.`);

        let trIndex = $(element.parents('tr')).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

        $(element.closest('tr').find(`input[name="qty[]"]`)).remove()

        let newQtyEl = `<input type="text" name="qty[]" class="form-control autonumeric" value="0">`

        elementSecond.parents('tr').find(`#qty${trIndex}`).append(newQtyEl)
        initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))

      }
    } else {
      let qtypesanan = qtystok + originalqty
      if (qtypesanan < qty) {
        showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtypesanan}.`);
      }
    }

  }

  function setStokEdit(element) {
    let productid = element.parents('tr').find(` [name="productid[]"]`).val()

    $.ajax({
      url: `${apiUrl}pembelianheader/cekstokproduct`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        productid: productid,
        edit: true
      },
      success: response => {
        initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))

        let qtyStokVal = parseFloat(element.parents('tr').find(` [name="qtystok[]"]`).val().replace(/,/g, ''))
        let qtyVal = parseFloat(element.parents('tr').find(` [name="qty[]"]`).val().replace(/,/g, ''))
        let originalqty = parseFloat(element.parents('tr').find(` [name="originalqty[]"]`).val().replace(/,/g, ''))


        if (qtyVal > qtyStokVal) {
          showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtyStokVal}.`);

          let trIndex = $(element.parents('tr')).data('trindex')

          elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

          $(element.closest('tr').find(`input[name="qty[]"]`)).remove()

          let newQtyEl = `<input type="text" name="qty[]" class="form-control autonumeric" value="${originalqty}">`

          elementSecond.parents('tr').find(`#qty${trIndex}`).append(newQtyEl)
          initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))

          setTotalHarga($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))
          setSubTotal()
          setTax()
          setTotal()
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
    })

  }

  function setQtyStok(productid, element) {

    $.ajax({
      url: `${apiUrl}pembelianheader/cekstokproduct`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        productid: productid
      },
      success: response => {
        console.log(response);
        initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))
        if (response.data == 0) {
          showDialog('produk ini tidak bisa dijual karena tidak ada stok')
          $(element.closest('tr').find(`input[name="productid[]"]`)).val("")
          $(element.closest('tr').find(`input[name="productnama[]"]`)).val("")
          $(element.closest('tr').find(`input[name="harga[]"]`)).val("")

          let trIndex = $(element.parents('tr')).data('trindex')
          $(element.closest('tr').find(`input[name="harga[]"]`)).remove()

          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`


          element.parents('tr').find(`#harga${trIndex}`).append(newHargaEl)

          $(element.closest('tr').find(`input[name="totalharga[]"]`)).prop('readonly', true).addClass('bg-white state-delete')
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
    })
  }

  function setQtyReturBeli(element) {
    let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
    initAutoNumeric(element.parents('tr').find(`td [name="qtyreturbeli[]"]`).val(qtyreturjual))
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
    initDatepicker()
  });

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    initDatepicker('datepickerIndex')
  })

  function createPenjualanHeader() {
    let form = $('#crudForm')
    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
    form.data('action', 'add')
    $('#crudModalTitle').text('create penjualan')
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
        getMaxLength(form)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        addRow()
        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
        form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
        form.find(`[name="nobukti"]`).prop('disable', true)
        form.find(`[name="qtyreturjual[]"]`).prop('readonly', true).addClass('bg-white state-delete')
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
    let topnama = $('#crudForm').find(`[name="topnama"]`).parents('.input-group').children()
    let statusnama = $('#crudForm').find(`[name="statusnama"]`).parents('.input-group').children()
    let productnama = $('#crudForm').find(`[name="productnama[]"]`).parents('.input-group').children()
    let satuannama = $('#crudForm').find(`[name="satuannama[]"]`).parents('.input-group').children()

    productnama.prop('readonly', true)
    productnama.find(`.lookup-toggler`).attr("disabled", true);
    productnama.find(`.button-clear`).attr("disabled", true);

    satuannama.prop('readonly', true)
    satuannama.find(`.lookup-toggler`).attr("disabled", true);
    satuannama.find(`.button-clear`).attr("disabled", true);

    customernama.find(`.lookup-toggler`).attr("disabled", true);
    customernama.find(`.button-clear`).attr("disabled", true);
    customernama.prop('readonly', true)

    topnama.find(`.lookup-toggler`).attr("disabled", true);
    topnama.find(`.button-clear`).attr("disabled", true);
    topnama.prop('readonly', true)

    statusnama.find(`.lookup-toggler`).attr("disabled", true);
    statusnama.find(`.button-clear`).attr("disabled", true);
    statusnama.prop('readonly', true)
  }

  // function editingAt(id, btn) {
  //   $.ajax({
  //     url: `{{ config('app.api_url') }}penjualanheader/editingat`,
  //     method: 'POST',
  //     dataType: 'JSON',
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     data: {
  //       id: id,
  //       btn: btn
  //     },
  //     success: response => {
  //       // isEdited = response.isEdited
  //       // if (isEdited) {
  //       //     approveKacab(id)
  //       // } else {
  //       editPenjualanHeader(id)
  //       // }
  //     },
  //     error: error => {
  //       errors = JSON.parse(error.responseText);
  //       if (errors.message) {
  //         showDialogEditAllMessage(errors.message)
  //       } else {
  //         showConfirmForce(errors.errors.id, id)
  //       }

  //     }
  //   })
  // }

  function editingAt(id, btn) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/editingat`,
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

  function editPenjualanHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('edit penjualan')
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
        getMaxLength(form)
      ])
      .then(() => {
        showPenjualanHeader(form, id)
          .then((response) => {
            $('#crudModal').modal('show')

            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')

              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
            }

            disabledQtyRetur(form, id)
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

  function deletePenjualanHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('delete penjualan')
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
        setStatusOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPenjualanHeader(form, id)
          .then((response) => {

            $('#crudModal').modal('show')

            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
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

  function viewPenjualanHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    $('#crudModalTitle').text('view penjualan')
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
        setStatusOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showPenjualanHeader(form, userId)
          .then((response) => {
            $('#crudModal').modal('show')
            if (!response.nobuktipesananfinal) {
              form.find(`[name="totalharga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="tglpengiriman"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              form.find(`[name="nobukti"]`).prop('disabled', true)
            } else {
              // form.find(`[name="subtotal"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="totalharga[]"]`).prop('readonly', true)
              // form.find(`[name="harga[]"]`).prop('readonly', true)
              // form.find(`[name="tglpengiriman"]`).prop('readonly', true)
              // form.find(`[name="taxamount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find('[name=tglpengiriman]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
              // form.find(`[name="total"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="alamatpengiriman"]`).prop('readonly', true)
              // form.find(`[name="qty[]"]`).prop('readonly', true)
              // form.find(`[name="keterangandetail[]"]`).prop('readonly', true)
              // form.find(`[name="discount"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="tax"]`).prop('readonly', true).addClass('bg-white state-delete')
              // form.find(`[name="keterangan"]`).prop('readonly', true)
              // enableLookup()
              // $('#crudForm').find(`.delete-row`).prop('disabled', true);  
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

    initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
    initAutoNumericNoDoubleZero(form.find(`[name="total"]`))
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
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}penjualanheader/field_length`,
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

  function disabledQtyRetur(form, id) {
    $.ajax({
      url: `${apiUrl}penjualanheader/disabledqtyretur/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        id: id
      },
      success: response => {
        console.log(response);
        $.each(response.check, (index, value) => {

          if (value.nobuktipembelian == '') {
            $('#crudForm').find(`[name="qtyreturjual[]"]`).prop('readonly', true).addClass('bg-white state-delete')
          }
        })
        // $.each(response.data, (index, value) => {
        //   if (value !== null && value !== 0 && value !== undefined) {
        //     form.find(`[name=${index}]`).attr('maxlength', value)
        //   }
        // })

        // form.attr('has-maxlength', true)
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      }
    })
  }

  function showPenjualanHeader(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}penjualanheader/${userId}`,
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

            if (index == 'topnama') {
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
            <th class="wider-keterangant text-right" style="width: 120px; min-width: 200px;">Total Harga</th>
            <th  style="width: 100px; min-width: 100px;" class="tbl_aksi">Aksi</th>

            `);

            if (response.detail.length == 0) {
              tableHeader = ''
            }
            $('#detailList thead tr').html('')
            // Sisipkan elemen <th> di awal baris
            $('#detailList thead tr').prepend(tableHeader);

            $.each(response.detail, (index, detail) => {
              selectIndex = index;
              let detailRow = $(`
                <tr class="filled-row" data-trindex="${selectIndex}">
                  <td class="table-bold">
                    
                </td>
                <td class="table-bold" >
                  <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row detail_stok_${selectIndex}">
                  <input type="hidden" name="id[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control filled-row lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">
                  </td>
                  <td class="table-bold" id="qty${selectIndex}">
                    <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
                    <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                    <input type="hidden" name="originalqty[]">
                  </td>
                  <td class="table-bold">
                    <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                  </td>
                  <td class="table-bold">
                    <input type="text" name="keterangandetail[]" class="form-control filled-row lg-form " autocomplete="off" >
                  </td>
                  <td class="table-bold qtyreturjual">
                    <input type="text" name="qtyreturjual[]" class="form-control filled-row lg-form autonumeric" autocomplete="off" value="0">
                  </td>
                  <td class="table-bold qtyreturbeli">
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

              detailRow.find(`[name="pesananfinaldetailid[]"]`).val(detail.pesananfinaldetailid)
              detailRow.find(`[name="id[]"]`).val(detail.id)
              detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangan)
              detailRow.find(`[name="productid[]"]`).val(detail.productid)
              detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
              detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
              detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
              detailRow.find(`[name="qty[]"]`).val(detail.qty)
              detailRow.find(`[name="originalqty[]"]`).val(detail.qty)
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

                let qtyReturBeliCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

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
              initLookupDetail(rowIndex);
              clearButton('detailList', `#detail_${index}`)
              setRowNumbers()

              if (detail.qtyreturjual !== 0) {
                detailRow.find('.delete-row').prop('disabled', true)
              }

              // setQtyStok(detail.productid, detailRow)
            })

            initAutoNumericNoDoubleZero(form.find(`[name="discount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="total"]`))

            setTotal()

            addRow(response.detail.length)



            if (response.data.pesananfinalid > 0) {
              var trElements = $('#detailList tbody tr');

              trElements.each(function() {
                var hasFilledRowClass = $(this).hasClass('filled-row');

                if (!hasFilledRowClass) {
                  $(this).find('input').prop('disabled', true).addClass('bg-white state-delete')
                  $(this).find(`.delete-row`)
                  $(this).find(`.lookup-toggler`).prop('disabled', true)
                  $(this).find(`.button-clear `).prop('disabled', true)
                }
              });
            }
          } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
      
              <th style="width: 500px; min-width: 250px;">No. Produk</th>
          
              `);

            if (response.detail.length == 0) {
              tableHeader = ''
            }
            // Sisipkan elemen <th> di awal baris
            $('#detailList thead tr').prepend(tableHeader);


            $.each(response.detail, (index, detail) => {
              selectIndex = index;

              let detailRow = $(`
              <tr class="filled-row">
              
              <td  class="table-bold">
                <label class="col-form-label mt-2 label-top label-mobile">${index+1}. &ensp; produk</label>
                  <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                  <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">

                      <div class="d-flex align-items-center">
                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label mt-2 label-mobile" min-width: 50px;">QTY</label>
                            <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
                            <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off">
                          </div>

                          <div class="col-6">
                            <label class="col-form-label mt-2 label-mobile" min-width: 50px;">Satuan</label>
                            <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                            <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                          </div>
                        </div>
                    </div> 
                    <div class="d-flex align-items-center mt-2">
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

                  <label class="col-form-label" min-width: 50px;">QTY RETUR JUAL</label>
                  <input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                  <label class="col-form-label" min-width: 50px;">QTY RETUR BELI</label>
                  <input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                  <label class="col-form-label mt-2 " style="font-size:13px">KETERANGAN</label>
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
              detailRow.find(`[name="qtyreturjual[]"]`).val(detail.qtyreturjual)
              detailRow.find(`[name="qtyreturbeli[]"]`).val(detail.qtyreturbeli)
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

                let qtyReturBeliCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

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
              initAutoNumericNoDoubleZero(detailRow.find(`[name="harga[]"]`))
              // initAutoNumeric(detailRow.find(`[name="qty[]"]`))
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
            initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="taxamount"]`))
            initAutoNumericNoDoubleZero(form.find(`[name="total"]`))

            setSubTotal()
            setTotal()
          }
          selectIndex += 1;
          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function disabledInput(detailRow) {

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
        $('#detailList thead tr').html('')
        $('#detailList thead tr').prepend(tableHeader);
      } else {

        selectIndex = show
      }

      for (let i = show; i < 50; i++) {

        let detailRow = $(`
            <tr data-trindex="${selectIndex}" >
              <td  class="table-bold">   
            </td>
            <td class="table-bold">
              <input type="hidden" name="id[]" class="form-control filled-row" value="0">
              <input type="hidden" name="productid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" autocomplete="off">
              </td>
                <td id="qty${selectIndex}" class="table-bold">
                <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                <input type="hidden" name="originalqty[]" class="form-control lg-form autonumeric">
              </td>
              <td  class="table-bold">
                <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
              </td>
              <td  class="table-bold">
                <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
              </td>
              <td  class="table-bold">
                <input type="text" name="qtyreturjual[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td  class="table-bold">
                <input type="text" name="qtyreturbeli[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
              </td>
              <td id="harga${selectIndex}" class="table-bold">
                <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
              </td>
              <td id="total${selectIndex}" class="table-bold">
                <input type="text" name="totalharga[]" class="form-control lg-form autonumeric-nozero  text-right" autocomplete="off" value="0" >
              </td>
              <td class="tbl_aksi table-bold">
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

          let qtyReturBeliCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

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
                    <td colspan="9" >
                      <div class="row form-group" >
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
                              <input type="text" name="tax" id="tax" class="form-control text-right lg-form filled-row small-input" value="0" hidden>
                              <input type="text" name="taxamount" id="taxamount" class="form-control text-right lg-form filled-row" value="0" hidden>
                      <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                          <label class="col-form-label">
                            discount
                          </label>
                        </div>
                        <div class="col-md-2 text-right">
                          <input type="text" name="discount" id="discount" class="form-control   text-right lg-form filled-row"  value="0">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                          <label class="col-form-label">
                           total
                          </label>
                        </div>
                        <div class="col-md-2 text-right">
                          <input type="text" name="total" id="total" class="form-control autonumeric-nozero text-right lg-form filled-row"  value="0">
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
                    <label class="col-form-label label-mobile" style=" min-width: 25px;">QTY </label>
                    <input type="hidden" name="qtystok[]" class="form-control lg-form autonumeric">
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
                      <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                      <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                    </div>

                    <div class="col-6">
                      <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">Total</label>
                      <input type="text" name="totalharga[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                    </div>
                  </div>
                </div>
                <label class="col-form-label" min-width: 50px;">QTY RETUR</label>
                <input type="text" name="qtyreturjual[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                <input type="text" name="qtyreturbeli[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
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

          let qtyReturBeliCek = ($(this).val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturbeli[]"]').val().replace(/,/g, ''));

          let qtyReturJualCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

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

  function cekValidasiAksi(Id, Aksi) {
    if (Aksi == 'EDIT') {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/${Id}/cekvalidasi`,
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
            // editingAt(Id, 'EDIT')
            if (Aksi == 'EDIT') {
              editPenjualanHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePenjualanHeader(Id)
            }
          }
        }
      })
    }
    if (Aksi == 'DELETE') {
      $.ajax({
        url: `{{ config('app.api_url') }}penjualanheader/${Id}/cekvalidasiaksi`,
        method: 'POST',
        dataType: 'JSON',
        data: {
          btn: 'DELETE'
        },
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        success: response => {
          var error = response.error
          if (error) {
            showDialog(response)
          } else {
            deletePenjualanHeader(Id)
          }
        }
      })
    }
  }


  function initLookupDetail(index) {
    let rowLookup = index;

    $(`.item-lookup${rowLookup}`).lookup({
      title: 'Item Lookup',
      fileName: 'product',
      detail: true,
      miniSize: true,
      searching: 1,
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
          customerid: $('#crudForm').find('[name=customerid]').val()
          // typeSearch: 'ALL',
        };
      },
      onSelectRow: (item, element) => {

        let item_id_input = element.parents('td').find(`[name="productid[]"]`);

        setQtyStok(item.id, element)

        element.parents('tr').find('td [name="satuanid[]"]').val(item.satuanid)
        element.parents('tr').find('td [name="satuannama[]"]').val(item.satuannama)

        // element.parents('tr').find('td [name="harga[]"]').val(item.hargajual)
        if (detectDeviceType() == "desktop") {

          element.parents('tr').find(`td [name="harga[]"]`).remove();
          element.parents('tr').find(`td [name="totalharga[]"]`).remove();

          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="${item.hargajual}">`
          let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`

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

        let qtyCek = (currentRow.find('input[name="qtyreturjual[]"]').val() == '') ? 0 : parseFloat(currentRow.find('input[name="qtyreturjual[]"]').val().replace(/,/g, ''));

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
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let item_id_input = element.parents('td').find(`[name="productid[]"]`).first();
        item_id_input.val('');
        element.val('');

        if (detectDeviceType() == "desktop") {
          element.parents('tr').find(`td [name="harga[]"]`).remove();
          element.parents('tr').find(`td [name="totalharga[]"]`).remove();
          let newHargaEl = `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`
          let newTotalHargaEl = `<input type="text" name="totalharga[]" class="form-control autonumeric" value="0">`

          element.parents('tr').find(`#harga${rowLookup}`).append(newHargaEl)
          element.parents('tr').find(`#total${rowLookup}`).append(newTotalHargaEl)
        } else {
          let elementharga = $('#detailList tbody tr td')

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
      searching: 1,
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
        url: `${apiUrl}penjualanheader/default`,
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
    let elements = $('#detailList tbody tr td.table-bold .label-top');

    elements.each((index, element) => {
      $(element).text(index + 1 + ". produk");
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

    $(`.top-lookup`).lookup({
      title: 'top Lookup',
      fileName: 'parameter',
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'TOP',
          subgrp: 'TOP',
          searching: 1,
          valueName: `top`,
          searchText: `top-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'top'
        };
      },
      onSelectRow: (top, element) => {
        $('#crudForm [name=top]').first().val(top.id)
        element.val(top.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let top_id_input = element.parents('td').find(`[name="top"]`).first();
        top_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

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

  function approveKacab(id) {
    $('#approveKacab').modal('show')
    $('#formApproveKacab').find('[name=id]').val(id)
  }

  $(document).on('click', `#approvalKacab`, function(event) {
    event.preventDefault()

    let data = [];
    data.push({
      name: 'id',
      value: $('#formApproveKacab').find('[name=id]').val()
    })
    data.push({
      name: 'username',
      value: $('#formApproveKacab').find('[name=username]').val()
    })
    data.push({
      name: 'password',
      value: $('#formApproveKacab').find('[name=password]').val()
    })
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}penjualanheader/approvalkacab`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: data,
      success: response => {
        if (response.status) {
          $('#formApproveKacab').trigger("reset");
          $("#approveKacab").modal('hide');
          // if (!isAllowedForceEdit) {
          editPenjualanHeader($('#formApproveKacab').find('[name=id]').val())
          // }
        } else {
          showDialog('TIDAK ADA HAK AKSES')
        }
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#formApproveKacab'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  })
</script>
@endpush()