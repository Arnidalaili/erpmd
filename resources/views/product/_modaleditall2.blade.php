<div class="modal modal-fullscreen" id="editAllModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-master modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <div class="overflow  scroll-container mb-2">
                            <div class="table-container">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                 
                                </table>
                              
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmitEditAll" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-warning" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT EDIT ALL PRODUCT -->
@push('scripts')
<script>
    hasFormBindKeys = false
    let editAllModal = $('#editAllModal').find('.modal-body').html()

    $(document).ready(function() {
       	
      

        $(document).on('click', "#addRowEditHargaJual", function() {
            addRowEditHargaJual()
        });

        // $(document).on('change', `#editHargaJualForm [id="tglpengirimanjual"]`, function() {
        //     // console.log(selectedRows);
        //     getAllProduct()
        // });


        $('#btnSubmitEditAll').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#editHargaJualForm')
            let action = form.data('action')
            let dataEdit = $('#editHargaJualForm .filled-row').serializeArray()

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $('#editHargaJualForm tbody tr.filled-row').each(function(index, element) {

                if ($(this).hasClass('filled-row')) {

                    let row_index = $(this).index();
                    dataEdit.push({
                        name: `productid[${row_index}]`,
                        value: $(this).find(`[name="productid[]"]`).val()
                    })
                    dataEdit.push({
                        name: `productnama[${row_index}]`,
                        value: $(this).find(`[name="productnama[]"]`).val()
                    })
                    dataEdit.push({
                        name: `hargajual[${row_index}]`,
                        value: parseFloat($(this).find(`[name="hargajual[]"]`).val().replace(/,/g, ''))
                    })
                }
            })

            $('#editHargaJualForm').find(`.filled-row[name="hargajual[]"]`).each((index, element) => {
                dataEdit.filter((row) => row.name === 'hargajual[]')[index].value = AutoNumeric.getNumber($(`#editHargaJualForm  .filled-row[name="hargajual[]"]`)[index])
            })
            console.log(dataEdit)

            $.ajax({
                url: `${apiUrl}pesananfinalheader/edithargajual`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: dataEdit,
                success: response => {
                    $('#editHargaJualForm').trigger('reset')
                    $('#editAllModal').modal('hide')

                    showSuccessDialog(response.message)
                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                    }).trigger('reloadGrid');
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

    $('#editAllModal').on('shown.bs.modal', () => {
        let form = $('#editHargaJualForm')
        setFormBindKeys(form)
        activeGrid = null

        initDatepicker()
        getMaxLength(form)
    })

    $('#editAllModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModal').find('.modal-body').html(editAllModal)
        initDatepicker('datepickerIndex')
    })

    function editAll() {

        let form = $('#editAllModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditAll').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'editall')
        form.find(`.sometimes`).hide()
        $('#editAllModalTitle').text('Edit All Product')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        // var besok = new Date();
        // besok.setDate(besok.getDate() + 1);
        // $('#editHargaJualForm').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

        Promise
            .all([
                // showProductAll()
            ])
            .then((data) => {
                // $('#editAllModal').modal('show')
                
                // console.log(data[0])
                // let dataProduct = data[0];

                // $('#example').DataTable({
                //     "data" : dataProduct,
                //     "columns" : [
                //         {"data": "nama"},
                       
                //     ]
                // });
                getAllProduct()
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
        initAutoNumericNoDoubleZero(form.find(`[name="hargajual"]`))
    }

    function showProductAll() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}product/getproductall`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    
                    resolve(response.detail)
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function addRowEditHargaJual(show = 0) {
        form = $('#detailEdit')
        if (detectDeviceType() == "desktop") {
            let tableHeader = $(`
                <th style="width: 50px; min-width: 50px;" >No.</th>
                <th style="width: 250px; min-width: 200px;">Produk</th>
                <th class="wider-hargajual" style="width: 120px; min-width: 150px;">Harga Jual</th>
            `);

            if (!show) {
                $('#detailEdit thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }

            let detailRow = $(`
                <tr data-trindex="${selectIndex}" >
                    <td  class="table-bold">
                    </td>
                    <td class="table-bold">
                    <input type="hidden" name="productid[]" class="form-control">
                        <input type="text" name="productnama[]" id="ItemEdit_Id${selectIndex}" class="form-control lg-form productedit-lookup${selectIndex}" autocomplete="off">
                    </td>
                    <td id="hargajual${selectIndex}" class="table-bold">
                        <input type="text" name="hargajual[]" class="form-control lg-form autonumeric-nozero text-right " autocomplete="off" value="0">
                    </td>
                </tr>
            `)

            $('#detailEdit tbody').append(detailRow)
            initAutoNumeric(detailRow.find('.autonumeric'))
            initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
            clearButton(form, `#addRowEditHargaJual_${selectIndex}`)
            rowLookup = selectIndex
            setRowNumbersEdit()
            selectIndex++

        } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
                <th style="width: 500px; min-width: 250px;">No.</th>
                <th style="width: 250px; min-width: 200px;">Customer</th>
                <th class="wider-qty text-right" style="width: 120px; min-width: 100px;">Qty</th>
                <th class="wider-hargajual text-right" style="width: 120px; min-width: 150px;">Harga Jual</th>
                <th class="wider-hargabeli text-right" style="width: 120px; min-width: 150px;">Harga Beli</th>
            `);

            $(".wider-qty").remove();
            if (!show) {
                $('#detailEdit thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }
            for (let i = show; i < 50; i++) {
                let urut = i + 1;
                let detailRow = $(`
                    <tr>
                        <td class="table-bold" >
                            <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">${urut}. &ensp; customer</label>
                            <input type="hidden" name="customerid[]" class="form-control  detail_stok_${selectIndex}">
                            <input type="text" name="customer_name[]" id="CustomerEdit_Id${selectIndex}" class="form-control lg-form numeric customeredit-lookup${selectIndex}" autocomplete="off">

                            
                    
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                <div class="col-6">
                                <label class="col-form-label label-top label-mobile" style=" min-width: 25px;">QTY </label>
                                <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                </div>
                            </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                <div class="col-6">
                                <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA JUAL</label>
                                <input type="text" name="hargajual[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>

                                <div class="col-6">
                                <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">HARGA BELI</label>
                                <input type="text" name="hargabeli[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                                </div>
                            </div>
                            </div>
                        </td>
                    </tr> `)

                detailRow.on('input', 'input[name="hargajual[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });

                detailRow.on('input', 'input[name="hargabeli[]"]', function() {
                    let value = $(this).val();
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

                $('#detailEdit tbody').append(detailRow)
                clearButton(form, `#addRowEditHargaJual_${selectIndex}`)
                initDatepicker()
                rowLookup = selectIndex
                selectIndex++
            }
            initAutoNumeric($('#detailEdit').find('.autonumeric'))
            initAutoNumericNoDoubleZero($('#detailEdit').find('.autonumeric-nozero'))
        }
    }

    function getAllProduct() {
        $.ajax({
            url: `${apiUrl}product/getproductall`,
            method: 'GET',
            dataType: 'JSON',
            data:{
                limit : 20
            },
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {
                $('#detailEdit tbody').html('')
                $.each(response.detail, (index, detail) => {
                    selectIndex = index;
                    let detailRow = $(`
                        <tr>
                        <td class="table-bold">
                        </td>
                        <td class="table-bold">
                            <input type="text" name="nama[]" class="form-control">
                        </td>
                        <td class="table-bold"> 
                            <input type="hidden" name="groupid[]" class="filled-row">
                                <input type="text" name="groupnama[]" id="groupnama" class="form-control lg-form group-lookup${selectIndex} filled-row" autocomplete="off">
                        </td>
                        <td class="table-bold"> 
                            <input type="text" name="hargajual[]" class="form-control autonumerics text-right" value="0">
                        </td>
                        <td class="table-bold"> 
                            <input type="hidden" name="supplierid[]" class="filled-row">
                            <input type="text" name="suppliernama[]" id="suppliernama" class="form-control lg-form supplier-lookup${selectIndex} filled-row" autocomplete="off">
                        </td>
                        <td class="table-bold"> 
                            <input type="hidden" name="satuanid[]" class="filled-row">
                            <input type="text" name="satuannama[]" id="satuannama" class="form-control lg-form satuan-lookup${selectIndex} filled-row" autocomplete="off">
                        </td>
                        <td class="table-bold"> 
                            <input type="text" name="hargabeli[]" class="form-control  autonumerics text-right" value="0">
                        </td>
                    </tr>`)
                    
                    $(document).on("keydown", '#editHargaJualForm input[type="text"]', function (event) {
                            let currentRowIndex = $(this).closest('tr').index();

                            switch (event.keyCode) {
                                case 9: // Tab key
                                    event.preventDefault();

                                    if (event.shiftKey) {
                                        // Shift + Tab: Move to the previous row
                                        moveFocusToRow(currentRowIndex - 1);
                                    } else {
                                        // Tab: Move to the next row
                                        moveFocusToRow(currentRowIndex + 1);
                                    }
                                    break;

                                case 38: // Up arrow key
                                    event.preventDefault();
                                    moveFocusToRow(currentRowIndex - 1);
                                    break;

                                case 40: // Down arrow key
                                    event.preventDefault();
                                    moveFocusToRow(currentRowIndex + 1);
                                    break;
                            }
                        });

                        function moveFocusToRow(rowIndex) {
                            let targetRowInput = $('#detailEdit tbody tr:eq(' + rowIndex + ')').find('input[name="hargajual[]"]');

                            if (targetRowInput.length > 0) {
                                targetRowInput.focus();
                            }
                        }


                    detailRow.find(`[name="nama[]"]`).val(detail.nama)
                    detailRow.find(`[name="groupid[]"]`).val(detail.groupid)
                    detailRow.find(`[name="supplierid[]"]`).val(detail.supplierid)
                    detailRow.find(`[name="groupnama[]"]`).val(detail.groupnama)
                    detailRow.find(`[name="hargajual[]"]`).val(detail.hargajual)
                    detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                    detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                    detailRow.find(`[name="hargabeli[]"]`).val(detail.hargabeli)
                    initAutoNumericNoDoubleZero(detailRow.find(`[name="hargajual[]"]`))
                    initAutoNumericNoDoubleZero(detailRow.find(`[name="hargabeli[]"]`))
                    
                    $('#detailEdit tbody').append(detailRow)
                    rowIndex = index
                    clearButton('detailEdit', `#detail_${index}`)
                    setRowNumbersEdit()

                    initLookupDetail(rowIndex);
                })
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

    function setRowNumbersEdit() {
        let elements = $('#detailEdit tbody tr td:nth-child(1)')


        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function initLookupDetail(index) {
    let rowLookup = index;

    $(`.group-lookup${rowLookup}`).lookup({
      title: 'Group Lookup',
      fileName: 'groupProduct',
      detail: true,
      miniSize: true,
      beforeProcess: function() {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: `ItemId_${index}`,
          id: `ItemId_${rowLookup}`,
          searchText: `group-lookup${rowLookup}`,
          singleColumn: true,
          hideLabel: true,
          title: 'Group',
          groupid: $('#crudForm').find('[name=groupid]').val(),
          // limit: 0
          // typeSearch: 'ALL',
        };
      },
      onSelectRow: (group, element) => {
        let groupid = element.parents('td').find(`[name="groupid[]"]`);
        groupid.val(group.id);

    
        element.val(group.name);

        element.addClass('filled-row')
        groupid.addClass('filled-row')
        element.data('currentValue', element.val());

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let groupid = element.parents('td').find(`[name="groupid[]"]`).first();
        groupid.val('');
        element.val('');
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
</script>
@endpush()