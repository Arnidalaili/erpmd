<div class="modal modal-fullscreen" id="editAllModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-12 col-sm-3 col-md-2">
                            <label class="col-form-label">
                                tgl pengiriman<span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-9 col-md-10">
                            <div class="input-group">
                                <input type="text" name="tglpengirimanbeli" id="tglpengirimanbeli" class="form-control lg-form datepicker filled-row">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-sm-3 col-md-2">
                            <label class="col-form-label">
                                karyawan<span class="text-danger">*</span>
                            </label>
                        </div>
                        <div class="col-12 col-sm-9 col-md-10">
                            <div class="input-group">
                                <input type="hidden" name="karyawanid" class="form-control filled-row">
                                <input type="text" name="karyawannama" id="karyawannama" class="form-control karyawanrequest-lookup" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered" id="editAllPembelian">
                        <thead>
                            <!-- Add your table header here if needed -->
                        </thead>
                        <tbody id="editAllTableBody"></tbody>
                    </table>

                    <div class=" bg-white transaksi-belanja overflow-x-hidden mt-3">
                        {{-- <label class="col-form-label">
                            transaksi belanja details
                        </label> --}}
                        <table class="table table-bordered " id="editAllTransaksiBelanja">
                            <thead>
                                <tr>
    
                                </tr>
                            </thead>
                            <tbody id="editAllTransaksiBelanjaTableBody"></tbody>
                         
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmitEditAll" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>
                    <button class="btn btn-warning" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let modalBodyEditAll = $('#editAllModal').find('.modal-body').html()
    let dataEditAll = {}
    let jumlahMaster = 0;
    let karyawanidrequest = 0;
    let rowIndex = 0
    let i = 0

    $(document).ready(function() {

        $(document).on('change', `#editAllForm [id="tglpengirimanbeli"]`, function() {
            getAll(1, 10)
        });

        $(document).on('click', "#addRowTransaksiBelanja", function() {
                addRowTransaksiBelanja()
            });

        $(document).on('click', '.delete-rowtransaksibelanja', function(event) {
            // storeDeletedId($(this).parents('tr'))
            deleteRowTransaksiBelanja($(this).parents('tr'))
            hitungPanjar()

        })

        $(document).on('input', `#editAllTransaksiBelanja [name="nominaltransaksibelanja[]"]`, function(event) {
            hitungPanjar()
           
            // setQtys($(this))
            // setSubTotal()
            // setGrandTotal()
        })

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#editAllForm').data('action') == 'edit') {


                $.ajax({
                    url: `{{ config('app.api_url') }}pembelianheader/editingat`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        id: $('#editAllForm').find('[name=id]').val(),
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




        $('#btnSubmitEditAll').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#editAllForm')
            let action = form.data('action')

            let detailsDataAll = [];

            for (let i = 0; i < jumlahMaster; i++) {
                if (!$(`.header${i}`).find(`tr.totalan input`).is(':disabled')) {

                    let dataheader = $(`.header${i}`).find(`.data-header td.row-data${i}`);
                    let totalan = $(`.header${i}`).find(`tr.totalan `);
                    let total = $(`.header${i}`).find(`tr.total `);
                    let potongan = $(`.header${i}`).find(`tr.potongan `);


                    detailsDataAll[i] = {};

                    $.each(dataheader, (index, row) => {
                        var classHeader = $(row).find('.input-group');
                        var inputHeader = $(row).find('input');

                        if (classHeader.hasClass('input-group')) {
                            let namas = $(row).find('.input-group input').prop('name').replace(
                                /\[\]/g, '');
                            let values = $(row).find('.input-group input').val();
                            detailsDataAll[i][namas] = values;
                        }
                        if (inputHeader.hasClass('pesananfinalid')) {
                            let pesananfinalidInput = $(row).find('input.pesananfinalid').prop(
                                'name').replace(/\[\]/g, '');
                            let valuePesananfinal = $(row).find('input.pesananfinalid').val();
                            detailsDataAll[i][pesananfinalidInput] = valuePesananfinal;
                        }

                        let nama = $(row).find('input').prop('name').replace(/\[\]/g, '');
                        let value = $(row).find('input').val();


                        detailsDataAll[i][nama] = value;
                    });

                    $.each(totalan, (index, row) => {
                        var classHeader = $(row).find('.input-group');
                        var inputHeader = $(row).find('input');
                        let nama = $(row).find('input').prop('name').replace(/\[\]/g, '');
                        let value = parseFloat($(row).find('input').val().replace(/,/g, ''));

                        detailsDataAll[i][nama] = value;
                    });

                    $.each(potongan, (index, row) => {
                        var classHeader = $(row).find('.input-group');
                        var inputHeader = $(row).find('input');
                        let nama = $(row).find('input').prop('name').replace(/\[\]/g, '');
                        let value = parseFloat($(row).find('input').val().replace(/,/g, ''));

                        detailsDataAll[i][nama] = value;
                    });

                    $.each(total, (index, row) => {
                        var classHeader = $(row).find('.input-group');
                        var inputHeader = $(row).find('input');
                        let nama = $(row).find('input').prop('name').replace(/\[\]/g, '');
                        let value = parseFloat($(row).find('input').val().replace(/,/g, ''));

                        detailsDataAll[i][nama] = value;
                    });

                    detailsDataAll['details'] = {};

                    let datadetail = $(`.header${i}`).find(`.data-detail td`);

                    $.each(datadetail, (indexDetail, rowDetail) => {
                        var classDetail = $(rowDetail).find('.input-group');
                        var inputDetail = $(rowDetail).find('input');

                        if (classDetail.hasClass('input-group')) {
                            let namaDetails = $(rowDetail).find('.input-group input').prop(
                                'name');
                            let valueDetails = $(rowDetail).find('.input-group input').val();

                            if (!detailsDataAll[i]['details'][namaDetails]) {
                                detailsDataAll[i]['details'][namaDetails] = [];
                            }

                            detailsDataAll[i]['details'][namaDetails].push(valueDetails);
                        }

                        if (inputDetail.hasClass('iddetail')) {
                            let iddetailInput = $(rowDetail).find('input.iddetail').prop('name')
                            let valueIdDetail = $(rowDetail).find('input.iddetail').val();

                            if (!detailsDataAll[i]['details'][iddetailInput]) {
                                detailsDataAll[i]['details'][iddetailInput] = [];
                            }

                            detailsDataAll[i]['details'][iddetailInput].push(valueIdDetail);
                        }
                     

                        if (inputDetail.hasClass('idheader')) {
                            let idHeaderName = $(rowDetail).find('input.idheader').prop('name')
                            let valueIdHeader = $(rowDetail).find('input.idheader').val();

                            if (!detailsDataAll[i]['details'][idHeaderName]) {
                                detailsDataAll[i]['details'][idHeaderName] = [];
                            }

                            detailsDataAll[i]['details'][idHeaderName].push(valueIdHeader);
                        }

                        if (inputDetail.hasClass('pesananfinaldetailid')) {
                            let idPesananFinalDetailIdName = $(rowDetail).find(
                                'input.pesananfinaldetailid').prop('name')
                            let valueIdPesananFinalDetail = $(rowDetail).find(
                                'input.pesananfinaldetailid').val();

                            if (!detailsDataAll[i]['details'][idPesananFinalDetailIdName]) {
                                detailsDataAll[i]['details'][idPesananFinalDetailIdName] = [];
                            }

                            detailsDataAll[i]['details'][idPesananFinalDetailIdName].push(
                                valueIdPesananFinalDetail);
                        }

                        if (inputDetail.hasClass('productid')) {
                            let productIdName = $(rowDetail).find('input.productid').prop(
                                'name')
                            let valueProductId = $(rowDetail).find('input.productid').val();

                            if (!detailsDataAll[i]['details'][productIdName]) {
                                detailsDataAll[i]['details'][productIdName] = [];
                            }

                            detailsDataAll[i]['details'][productIdName].push(valueProductId);
                        }

                        if (inputDetail.hasClass('qty')) {
                            let qtyInput = $(rowDetail).find('input.qty').prop('name')
                            let valueQty = parseFloat($(rowDetail).find('input.qty').val()
                                .replace(/,/g, ''));

                            if (!detailsDataAll[i]['details'][qtyInput]) {
                                detailsDataAll[i]['details'][qtyInput] = [];
                            }

                            detailsDataAll[i]['details'][qtyInput].push(valueQty);
                        }



                        if (inputDetail.hasClass('autonumeric')) {
                            let autoNumericZeroInput = $(rowDetail).find('input.autonumeric')
                                .prop('name')
                            let valueautoNumericZero = parseFloat($(rowDetail).find(
                                'input.autonumeric').val().replace(/,/g, ''));


                            if (!detailsDataAll[i]['details'][autoNumericZeroInput]) {
                                detailsDataAll[i]['details'][autoNumericZeroInput] = [];
                            }

                            detailsDataAll[i]['details'][autoNumericZeroInput].push(
                                valueautoNumericZero);
                        } else {
                            let namaDetail = $(rowDetail).find('input').prop('name');
                            let valueDetail = $(rowDetail).find('input').val();

                            if (!detailsDataAll[i]['details']) {
                                detailsDataAll[i]['details'] = {};
                            }

                            if (!detailsDataAll[i]['details'][namaDetail]) {
                                detailsDataAll[i]['details'][namaDetail] = [];
                            }

                            detailsDataAll[i]['details'][namaDetail].push(valueDetail);

                        }
                    });
                }


            }  
            let pembelian = {}
            let transaksibelanja = {}
            let detailTransaksiBelanjas = []
            
            pembelian['pembelian'] = detailsDataAll

             $('#editAllTransaksiBelanjaTableBody tr.filled-row').each((index, element) => {
                valueElement = $(element).find(`[name="perkiraannamatransaksibelanja[]"]`).val()
                if (!$(element).find(`input`).is(':disabled')) {
                    // console.log('berhasil mausk sini');
                    if (valueElement != '') {
                       
                        detailTransaksiBelanjas[index] = {
                                id: $(element).find(`[name="id[]"]`).val(),
                                tglbukti: $(element).find(`[name="tglbuktitransaksibelanja[]"]`).val(),
                                perkiraanid: $(element).find(`[name="perkiraanidtransaksibelanja[]"]`).val(),
                                perkiraannama: $(element).find(`[name="perkiraannamatransaksibelanja[]"]`).val(),
                                pembelianid: 0,
                                karyawanid: $(element).find(`[name="karyawanidtransaksibelanja[]"]`).val(),
                                nominal: parseFloat($(element).find(`[name="nominaltransaksibelanja[]"]`).val()
                                    .replace(/,/g, '')),
                                keterangan: $(element).find(`[name="keterangantransaksibelanja[]"]`).val(),
                            };

                    }
                }
            })

            const detail = detailTransaksiBelanjas.reduce((acc, item, index) => {
                    acc[index] = item;
                    return acc;
                }, {});
                // Stringify the object
            const jsonString = JSON.stringify(detail);
           
            transaksibelanja['transaksibelanja'] = jsonString

            const arrayGabungan = Object.assign({}, pembelian, transaksibelanja);

            $.ajax({
                url: `${apiUrl}pembelianheader/processeditall`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(arrayGabungan),
                    karyawanid: $('#editAllModal [name="karyawanid').val()
                },
                success: response => {
                    $('#editHargaBeliForm').trigger('reset')
                    $('#editAllModal').modal('hide')
                    dataEditAll = {}

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

    function setTotalHargaEditAll(element, id = 0) {
        let hargasatuan = parseFloat(element.find(`[name="harga[]"]`).val().replace(/,/g, ''));
        let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
        let amount = qty * hargasatuan;

        initAutoNumericNoDoubleZero(element.find(`[name="totalharga[]"]`).val(amount))
    }

    function setQty(element, id = 0) {
        let qtyretur = parseFloat(element.find(`[name="qtyretur[]"]`).val().replace(/,/g, ''));
        let originalqty = parseFloat(element.find(`[name="originalqty[]"]`).val().replace(/,/g, ''));
        let amountqty = originalqty - qtyretur

        if (isNaN(qtyretur) || qtyretur === 0) {
            amountqty = originalqty;
        }

        let qtyTd = element.find(`.qtyretur`);
        if (amountqty < 0) {
            element.find(`[name="qtyretur[]"]`).remove();

            let newQtyEl =
                `<input type="text" name="qtyretur[]" class="form-control autonumeric" value='0'>`

            qtyTd.append(newQtyEl)

            elementParentQtyRetur = element.find(`[name="qtyretur[]"]`)


            initAutoNumeric(element.find(`[name="qtyretur[]"]`))
            initAutoNumeric(element.find(`[name="qty[]"]`).val(originalqty))
            showDialog('Qty retur tidak boleh melebihi qty jual');
        } else {
            initAutoNumeric(element.find(`[name="qty[]"]`).val(amountqty))
        }

    }

    function setQtyPesanan(element, id = 0) {
        let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
        initAutoNumeric(element.find(`[name="qtypesanan[]"]`).val(qty))
    }

    function setSubTotalEditAll(element) {
        let nominalDetails = element.find(`[name="totalharga[]"]`);
        let total = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });

        console.log(total)
        initAutoNumericNoDoubleZero(element.find(`[name="subtotal[]"]`).val(total))
    }

    function setTaxEditAll(element) {
        let result;
        let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''))


        let taxlabel = parseFloat(element.find(`[name="tax[]"]`).val().replace(/,/g, ''))

        result = (taxlabel / 100) * total;


        initAutoNumericNoDoubleZero(element.find(`[name="taxamount[]"]`).val(result))
    }


    function setTotalEditAll(element) {
        let grandtotal;

        let subtotal = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''));
        let potongan = parseFloat(element.find(`[name="potongan[]"]`).val().replace(/,/g, ''));
        grandtotal = subtotal - potongan

        initAutoNumericNoDoubleZero(element.find(`[name="total[]"]`).val(grandtotal))
    }

    $('#editAllModal').on('shown.bs.modal', () => {
        var editAllModal = $('#editAllModal')
        let form = $('#editAll')
        setFormBindKeys(form)
        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        getMaxLength(form)
        initDatepicker()
        initLookupRequest()

    });
    $('#editAllModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModal').find('.modal-body').html(modalBodyEditAll)
        dataEditAll = {}
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        jumlahMaster = 0;
    })

    function editAllPembelian() {
        let totalRows
        let lastPage
        let form = $('#editAllModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditAll').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'editall')
        form.find(`.sometimes`).hide()
        $('#editAllModalTitle').text('Edit All pembelian')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate());
        $('#editAllForm').find('[name=tglpengirimanbeli]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
            'change');

       
        Promise
            .all([
                getAll(1, 10),
               
            ])
            .then((response) => {
                data = response[0].data;
                databelanja = response[0].databelanja;

               
                $('#editAllModal').modal('show')


                // showTransaksiBelanja(data,databelanja)

                
                
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

    function showTransaksiBelanja(data,databelanja,karyawanid)
    {
        console.log(karyawanid);
        if (karyawanid != '') {
            $('#editAllTransaksiBelanja').show()
            if ($('#editAllTransaksiBelanja').prev('label').length === 0) {
                // Create the label element
                let labelElement = $('<label class="col-form-label label-transaksibelanja">transaksi belanja details</label>');

                // Insert the label before the table with id editAllTransaksiBelanja
                $('#editAllTransaksiBelanja').before(labelElement);
            }

            $('#editAllTransaksiBelanja tbody').html('')
            $('#editAllTransaksiBelanja thead tr').html('')

            let tableHeader = $(`
                    <th scope="col" width="1%">No</th>
                    <th scope="col" style="width: 280px; min-width: 280px;">perkiraan</th>
                    <th scope="col" style="width: 150px; min-width: 150px;">nominal</th>
                    <th scope="col">keterangan</th>
                    <th scope="col" class="tbl_aksi" width="1%">Aksi</th>

                    `);
                        // Sisipkan elemen <th> di awal baris
            $('#editAllTransaksiBelanja thead tr').prepend(tableHeader);
                        
            $.each(databelanja == '' ? data : databelanja, (index, detail) => {
                    selectIndex = 0;             
                    console.log(detail);
                    let detailRow = $(`
                        <tr class="filled-row">
                            <td> </td>
                        
                            <td>
                                <input type="hidden" name="id[]" class="form-control">
                                <input type="hidden" name="tglbuktitransaksibelanja[]" class="form-control">
                                <input type="hidden" name="perkiraanidtransaksibelanja[]" class="form-control filled-row detail_stok_${index}">
                                <input type="text" name="perkiraannamatransaksibelanja[]" id="perkiraanid${index}" class="form-control filled-row lg-form perkiraaneditall-lookup${index}" autocomplete="off">
                            </td>
                            <td>
                                <input type="hidden" name="karyawanidtransaksibelanja[]" class="form-control filled-row detail_stok_${index}">
                                <input type="text" name="nominaltransaksibelanja[]"  class="form-control autonumeric">
                            </td>
                            <td>
                                <input type="text" name="keterangantransaksibelanja[]" class="form-control" > 
                            </td>
                            <td class="tbl_aksi" >
                                <button class='btn btn-danger btn-sm delete-rowtransaksibelanja '>Hapus</button>
                            </td>
                        </tr>
                    `);

                    
                    detailRow.find(`[name="id[]"]`).val(databelanja == '' ? '0' : detail.id);
                    detailRow.find(`[name="perkiraanidtransaksibelanja[]"]`).val(detail.perkiraanid);
                    detailRow.find(`[name="perkiraannamatransaksibelanja[]"]`).val(detail.perkiraannama);
                    detailRow.find(`[name="pembelianidtransaksibelanja[]"]`).val(detail.pembelianid);
                    detailRow.find(`[name="pembeliannamatransaksibelanja[]"]`).val(detail.pembeliannobukti);
                    detailRow.find(`[name="karyawanidtransaksibelanja[]"]`).val(detail.karyawanid);
                    detailRow.find(`[name="karyawannamatransaksibelanja[]"]`).val(detail.karyawannama);
                    detailRow.find(`[name="keterangantransaksibelanja[]"]`).val(detail.keterangan);
                    detailRow.find(`[name="nominaltransaksibelanja[]"]`).val(databelanja == '' ? '0' : detail.nominal);
                    
                
                    $('#editAllTransaksiBelanja>#editAllTransaksiBelanjaTableBody').prepend(detailRow);

                        
                    initDatepicker();
                    var tglbuktiAdd = new Date();
                    tglbuktiAdd.setDate(tglbuktiAdd.getDate());
                    detailRow.find(`[name="tglbuktitransaksibelanja[]"]`).val($.datepicker.formatDate('dd-mm-yy', tglbuktiAdd)).trigger('change');

                    detailRow.find('.datepicker').prop('readonly', true).addClass('bg-white state-delete');
                                
                    initAutoNumericNoDoubleZero(detailRow.find('.autonumeric'));
                    initLookupTransaksiBelanja(index);

                
                                    
                    rowIndex = index;
                                
                    setRowNumber();

                    // if (detail.pembelianid > 0) {
                    //     // console.log(detailRow.find(`[name="pembeliannamatransaksibelanja[]"]`).prop('readonly',false));
                    //     detailRow.find(`[name="pembeliannamatransaksibelanja[]"]`).removeAttr('readonly')
                    //     detailRow.find(`[name="pembeliannamatransaksibelanja[]"]`).parent('.input-group').find('.lookup-toggler').prop('disabled', false);
                    //     detailRow.find(`[name="pembeliannamatransaksibelanja[]"]`).parent('.input-group').find('.button-clear').prop('disabled', false);
                    // }
                });
                rowSisa(databelanja == '' ? data.length : databelanja.length);

                // Add <tfoot> section if it doesn't already exist
                if ($('#editAllTransaksiBelanja tfoot').length === 0) {
                    let tfootSection = $(`
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <div id="footer-grid">
                                        <div class="row">
                                            <div class="col-8 ">
                                                <p><strong class="kredit">TOTAL KREDIT</strong></p>
                                                <p><strong class="cash">TOTAL CASH</strong></p>
                                                <p><strong class="panjar">TOTAL PANJAR</strong></p>
                                                <p><strong class="biayalain">TOTAL BIAYA</strong></p>
                                                <p><strong class="sisa">SISA</strong></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-1">
                                                    <b>
                                                        <p class="kredit">:</p>
                                                        <p class="cash">:</p>
                                                        <p class="panjar">:</p>
                                                        <p class="biayalain">:</p>
                                                        <p class="sisa">:</p>
                                                    </b>
                                                </div>
                                            </div>
                                            <div class="col-3 text-right">
                                                <strong><p><span id="totalCredit" class="kredit autonumeric-nozero2"></span></p></strong>
                                                <strong><p><span id="totalCash"  class="cash autonumeric-nozero2"></span></p></strong>
                                                <strong><p><span id="saldo" class="panjar autonumeric-nozero2"></span></p></strong>
                                                <strong><p><span id="totalBiayaLain" class="biayalain autonumeric-nozero2"></span></p></strong>
                                                <strong><p><span id="sisa" class="sisa autonumeric-nozero2"></span></p></strong>
                                            </div>
                                        </div>
                                    </div>  
                                </td>
                                <td></td>
                               
                                <td class="tbl_aksi">
                                    <button type="button" class="btn btn-primary btn-sm my-2" id="addRowTransaksiBelanja">Tambah</button>
                                </td>
                            </tr>
                        </tfoot>
                    `);

                    $('#editAllTransaksiBelanja').append(tfootSection);
                }
   
        }else{
            $('#editAllTransaksiBelanja').hide()
            $('.label-transaksibelanja').hide()
        }
    }
    let selectRowIndex = 0
   
    function rowSisa(show = 0)
    {
      
        // $('#editAllTransaksiBelanja tbody').html('')
        let tableHeader = $(`
                <th scope="col" width="1%">No</th>
                <th scope="col" style="width: 280px; min-width: 280px;">perkiraan</th>
                <th scope="col" style="width: 150px; min-width: 150px;">nominal</th>
                <th scope="col">keterangan</th>
                <th scope="col" class="tbl_aksi" width="1%">Aksi</th>

      `);
            
            // Sisipkan elemen <th> di awal baris
            if (!show) {
                $('#editAllTransaksiBelanja thead tr').html('')
                $('#editAllTransaksiBelanja thead tr').prepend(tableHeader);
            } else {
                
                selectRowIndex = show
            }

        for (i = show; i < 10; i++) {
            let detailRow = $(`
                <tr class="filled-row">
                            <td> </td>
                            <td>
                                <input type="hidden" name="id[]" class="form-control" value="0">
                                <input type="hidden" name="tglbuktitransaksibelanja[]" class="form-control">
                                <input type="hidden" name="perkiraanidtransaksibelanja[]" class="form-control filled-row detail_stok_${selectRowIndex}">
                                <input type="text" name="perkiraannamatransaksibelanja[]" id="perkiraanid${selectRowIndex}" class="form-control filled-row lg-form perkiraaneditall-lookup${selectRowIndex}" autocomplete="off">
                            </td>
                            <td>
                            <input type="hidden" name="karyawanidtransaksibelanja[]" class="form-control filled-row detail_stok_${selectRowIndex}">
                            <input type="text" name="nominaltransaksibelanja[]"  class="form-control autonumeric">
                            </td>
                            <td>
                                <input type="text" name="keterangantransaksibelanja[]" class="form-control" > 
                            </td>
                            <td class="tbl_aksi" >
                            <button class='btn btn-danger btn-sm delete-rowtransaksibelanja '>Hapus</button>
                            </td>
                </tr>`)


        tglbukti = $('#editAllTransaksiBelanjaForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tglbuktitransaksibelanja[]"]`).val(tglbukti).trigger('change');

        var tglbuktiAdd = new Date()
        tglbuktiAdd.setDate(tglbuktiAdd.getDate())
        detailRow.find(`[name="tglbuktitransaksibelanja[]"]`).val($.datepicker.formatDate('dd-mm-yy', tglbuktiAdd)).trigger(
            'change');


        $('#editAllTransaksiBelanja>#editAllTransaksiBelanjaTableBody').append(detailRow)
        initDatepicker()
        detailRow.find('.datepicker').prop('readonly', true).addClass('bg-white state-delete')
        initAutoNumericNoDoubleZero(detailRow.find('.autonumeric'))
        initLookupTransaksiBelanja(selectRowIndex)
        setRowNumber()
        selectRowIndex++
        }
      
    }
   
    function addRowTransaksiBelanja(){
        console.log(i);
        i++

        // console.log(rowLookupIndex);
        let rowLookupIndex = i
        let detailRow = $(`
            <tr class="filled-row">
                    <td> </td>
                    <td>
                        <input type="hidden" name="id[]" class="form-control" value="0">
                        <input type="hidden" name="tglbuktitransaksibelanja[]" class="form-control">
                        <input type="hidden" name="perkiraanidtransaksibelanja[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                        <input type="text" name="perkiraannamatransaksibelanja[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form perkiraaneditall-lookup${rowLookupIndex}" autocomplete="off">
                    </td>
                    <td>
                    <input type="hidden" name="karyawanidtransaksibelanja[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                    <input type="text" name="nominaltransaksibelanja[]"  class="form-control autonumeric">
                    </td>
                    <td>
                        <input type="text" name="keterangantransaksibelanja[]" class="form-control" > 
                    </td>
                    <td class="tbl_aksi" >
                    <button class='btn btn-danger btn-sm delete-rowtransaksibelanja '>Hapus</button>
                    </td>
            </tr>`)


        tglbukti = $('#editAllTransaksiBelanjaForm').find(`[name="tglbukti"]`).val()
        detailRow.find(`[name="tglbuktitransaksibelanja[]"]`).val(tglbukti).trigger('change');

        var tglbuktiAdd = new Date()
        tglbuktiAdd.setDate(tglbuktiAdd.getDate())
        detailRow.find(`[name="tglbuktitransaksibelanja[]"]`).val($.datepicker.formatDate('dd-mm-yy', tglbuktiAdd)).trigger(
            'change');


        $('#editAllTransaksiBelanja>#editAllTransaksiBelanjaTableBody').append(detailRow)
        initDatepicker()

        detailRow.find('.datepicker').prop('readonly', true).addClass('bg-white state-delete')
        detailRow.find('.ui-datepicker-trigger').prop('disabled', true)

        initLookupTransaksiBelanja(rowLookupIndex)

        initAutoNumericNoDoubleZero(detailRow.find('.autonumeric'))
        setRowNumber()
    }

    function deleteRowTransaksiBelanja(row) {
        let countRow = $('.delete-rowtransaksibelanja').parents('tr').length
        let rowId = row.find(`[name="id[]"]`).val();

        if (row.siblings().length == 0) {
            noUrut = 1
            row.remove()
            addRowTransaksiBelanja()
        } else {
            row.remove()

        }

        row.remove()

        if (detectDeviceType() == "desktop") {
            setRowNumber()
            // setSubTotal()
        } else {
            updateUrut()
            // setSubTotal()
        }
    }

    function setRowNumber() {
        let elements = $('#editAllTransaksiBelanja tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

  

    function getAll(page, limit = 10, karyawanid = '') {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pembelianheader/editall`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    page: page,
                    limit: 1,
                    sortIndex: 'nobukti',
                    sortOrder: 'desc',
                    tglpengirimanbeli: $('#editAllForm').find('[id=tglpengirimanbeli]').val(),
                    karyawanid: karyawanid
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAll tbody').html('')
                    data = response.data
                    detailHeader = ["No", "Supplier","Top", "No Bukti", "tgl bukti", "Karyawan",
                        "tgl terima", "keterangan"
                    ]
                    subHeader = ["No", "product", "satuan", "Qty", "Qty Stok", "Qty Retur",
                        "Qty Pesanan", "keterangan", "Harga", "total Harga","Aksi"
                    ]

                    // initValue(data)
                    createTable(data, detailHeader, subHeader);

                    
                    showTransaksiBelanja(data,response.databelanja,karyawanid)

                    transaksibelanja = $('#editAllTransaksiBelanja tbody');
                    transaksibelanja.find(`[name="tglbuktitransaksibelanja[]"]`).parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                    transaksibelanja.find(`[name="pembeliannamatransaksibelanja[]"]`).prop('disabled',true).addClass('bg-white state-delete');
                    transaksibelanja.find(`[name="pembeliannamatransaksibelanja[]"]`).parent('.input-group').find('.lookup-toggler').prop('disabled', true);
                    transaksibelanja.find(`[name="pembeliannamatransaksibelanja[]"]`).parent('.input-group').find('.button-clear').prop('disabled', true);

                    if (karyawanid == '' || data.length == 0) {
                        const disabledSelectors = [
                            '[name="perkiraannamatransaksibelanja[]"]',
                            '[name="karyawannamatransaksibelanja[]"]',
                            '[name="nominaltransaksibelanja[]"]',
                            '[name="keterangantransaksibelanja[]"]'
                        ];

                        disabledSelectors.forEach(selector => {
                            transaksibelanja.find(selector).prop('disabled', true).addClass('bg-white state-delete');
                            transaksibelanja.find(selector).parent('.input-group').find('.lookup-toggler').prop('disabled', true);
                            transaksibelanja.find(selector).parent('.input-group').find('.button-clear').prop('disabled', true);
                        });

                        transaksibelanja.find('.delete-rowtransaksibelanja').prop('disabled', true);
                        $('#editAllTransaksiBelanja').find('#addRowTransaksiBelanja').prop('disabled',true)

                    }

                     let karyawanidhidden = $('#editAllModal').find(`[name="karyawanid[]"]`).val()

                     if (karyawanid != '') {
                        $('#editAllModal [name="karyawanidtransaksibelanja[]"]').val(karyawanid)
                     }

                     let totalSisa = response.totalCash + response.totalBiaya

                     console.log(response);
                
                     $('#totalCash').text(`${response.totalCash}`)
                     $('#totalCredit').text(`${response.totalCredit}`)
                     $('#totalBiayaLain').text(`${response.totalBiaya}`)
                     $('#sisa').text(totalSisa)
                     $('#saldo').text(`${response.totalPanjar}`)

                   
                     hitungPanjar()
                     hitungSisa()

                     initAutoNumericNoDoubleZero($('#totalCash'))
                     initAutoNumericNoDoubleZero($('#totalCredit'))
                    
                    
                    // showTransaksiBelanja(response)

                    disabledButtonDelete($('#editAllModal'),data)
                    currentPage = page
                    totalPages = response.attributes.totalPages
                    totalRowsEditAll = response.attributes.totalRows

                    initDatepicker()
                    resolve(response)
                },
                error: error => {

                    reject(error)
                },
            })
        })
    }

    function hitungPanjar(){
        let tableTransaksiBelanja = $('#editAllTransaksiBelanja tbody')
        let rowPanjar = $('[name="perkiraannamatransaksibelanja[]"]').filter(function() {
            return $(this).val() === 'PANJAR';
        });

        let total = 0
        let totalBiaya = 0
        if (rowPanjar.length > 0) {
            let nominal = rowPanjar.parents('tr').find(`[name="nominaltransaksibelanja[]"]`)

            $.each(nominal, (index, nominalDetail) => {
                total += AutoNumeric.getNumber(nominalDetail)
            });  

        }
        // Mengambil elemen dengan nilai selain 'PANJAR'
        let rowNonPanjar = $('[name="perkiraannamatransaksibelanja[]"]').not(rowPanjar);
        let totalNonPanjar = 0;
        // Menghitung total biaya dari elemen dengan nilai selain 'PANJAR'
        let nominalNonPanjar = rowNonPanjar.parents('tr').find(`[name="nominaltransaksibelanja[]"]`);

        $.each(nominalNonPanjar, (index, nominalDetail) => {
            totalNonPanjar += AutoNumeric.getNumber(nominalDetail);
        });

        $('#totalBiayaLain').text(totalNonPanjar);
        $('#saldo').text(total)
        initAutoNumericTransakiBelanjaArmada($('#totalBiayaLain'))
        initAutoNumericTransakiBelanjaArmada($('#saldo'))

        hitungSisa()
    }

    function hitungSisa(){
        let tableTransaksiBelanja = $('#editAllTransaksiBelanja tbody')
        let totalcash = parseFloat($('#totalCash').text().replace(/,/g, ''));
        let totalbiaya = parseFloat($('#totalBiayaLain').text().replace(/,/g, ''))
        let totalpanjar = parseFloat($('#saldo').text().replace(/,/g, ''))

        let jumlah = totalcash + totalbiaya
        let sisa = totalpanjar - jumlah

        $('#sisa').text(sisa)
        initAutoNumericTransakiBelanjaArmada($('#sisa'))

    }



    function disabledButtonDelete(form,datapembelian){
        $.ajax({
                url: `${apiUrl}pembelianheader/disableddeleteeditall`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                'Authorization': `Bearer ${accessToken}`
                },
                data:{
                    data : JSON.stringify(datapembelian),
                    date: $('#editAllForm').find('[name=tglpengirimanbeli]').val()
                },
                success: response => {
                console.log(response);

                $.each(response.check, (index, value) => {
                    // console.log(value,index);
                    if(value != ''){
                        trRow = $('#editAllPembelian').find(`.valueId_${value.pembeliandetailid}`)
                      
                        trRow.find('.delete-roweditall').prop('disabled',true)

                    }
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
                }
            })
    }



    // Create a container div for each table
    let tableContainer = $('<div class="table-container mb-4">');
    let table = $("<table>");

    function createTable(data, detailHeader, subHeader) {
        $("#editAllTableBody").empty();
        tbody = $('#editAllTableBody')
        if (data.length === 0) {
            // If there is no data, display a styled message
            const noDataRow = $('<tr><td colspan="8" class="text-center">No data available</td></tr>');
            tbody.append(noDataRow);
        } else {

            // master
            jumlahMaster = data.length
            $.each(data, function(indexHeader, entry) {
                // Create a container div for each table
                tableContainer = $('<div class="table-container mb-5">');

                table = $(`<table class="header${indexHeader}" id=${entry.id}edit>`);

                // Detail Header
                const detailHeaderRow = $('<tr class="header-row">');
                const detailHeaderCells = detailHeader
                detailHeaderCells.forEach((cellText) => {
                    detailHeaderRow.append($("<th>").text(cellText));
                });
                table.append(detailHeaderRow);
                // Detail Row
                const detailRow = $("<tr class='data-header'>");
                detailRow.append($("<td>").text(indexHeader + 1));

                const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                const tglterima = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglterima));
                const detailCells = [
                    createInputLookup("suppliernama", entry.suppliernama, 'supplierid', indexHeader,
                        'suppliereditall', entry.supplierid),
                    createInputLookup("topnama", entry.topnama, 'top', indexHeader,
                        'topeditall', entry.topid),
                    `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}"/>`,
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}"></div>`,
                    createInputLookup("karyawannama", entry.karyawannama, 'karyawanid', indexHeader,
                        'karyawaneditall', entry.karyawanid),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglterima[]" id="tglterima${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglterima}"></div>`,
                    createInput("keterangan", entry.keterangan),
                    
                ];

                table.append(detailRow);

                detailCells.forEach((cell, index) => {

                    let widthStyle = '';
                    let minWidthStyle = '';
                    if (index === 0) {
                        widthStyle = 'width: 100px;';
                        minWidthStyle = 'min-width: 170px;';
                    } else if (index === 1) {
                        widthStyle = 'width: 60px;';
                        minWidthStyle = 'min-width: 150px;';
                    } else if (index === 2) {
                        widthStyle = 'width: 50px;';
                        minWidthStyle = 'min-width: 130px;';
                    } else if (index === 3) {
                        widthStyle = 'width: 100px;';
                        minWidthStyle = 'min-width: 150px;';
                    } else if (index === 4) {
                        widthStyle = 'width: 50px;';
                        minWidthStyle = 'min-width: 150px;';
                    } else if (index === 5) {
                        widthStyle = 'width: 45px;';
                        minWidthStyle = 'min-width: 200px;';
                    }
                    detailRow.append(
                        $(
                            `<td class='row-data${indexHeader}' style="${widthStyle} ${minWidthStyle}">`)
                        .append(cell)
                    );
                });

                table.append(detailRow);

                // Sub Header
                const subHeaderRow = $('<tr class="sub-header-row">');
                const subHeaderCells = subHeader
                subHeaderCells.forEach((cellText) => {
                    subHeaderRow.append($("<th>").text(cellText));
                });
                table.append(subHeaderRow);

                let totalPrice = 0;
                // console.log(entry.details);
                $.each(entry.details, function(index, details) {
                    idDetailsLookup = `${indexHeader}-${index}`
                    const productRow = $(`<tr class="detail-row data-detail valueId_${details.id}" id="${idDetailsLookup}">`);
                    productRow.append($("<td>").text(index + 1));
                    const productCells = [
                        createInputLookup("productnama", details.productnama, 'productid',
                            idDetailsLookup, 'producteditall', details.productid, details
                            .pesananfinaldetailid,
                            details.pesananfinalid, details.id, details.pembelianid, 'id'),
                        createInputLookup("satuannama", details.satuannama, 'satuanid',
                            idDetailsLookup,
                            'satuaneditall', details.satuanid),
                        ` <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >
                         <input type="hidden" name="originalqty[]" class="form-control originalqty lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                        ` <input type="text" name="qtystok[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtystok}" >`,
                        ` <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" >`,
                        ` <input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtypesanan}" >`,
                        createInputDetail("keterangandetail", details.keterangandetail),
                        ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                        ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${details.totalharga}" readonly>`,
                        `<button type="button" class="btn btn-danger btn-sm delete-roweditall">Delete</button>`,
                    ];  

                    productCells.forEach((cell, index) => {
                        let widthStyle = '';
                        let minWidthStyle = '';
                        if (index === 0) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 170px;';
                        } else if (index === 1) {
                            widthStyle = 'width: 50px;';
                            minWidthStyle = 'min-width: 130px;';
                        } else if (index === 2) {
                            widthStyle = 'width: 60px;';
                            minWidthStyle = 'min-width: 150px;';
                        } else if (index === 3) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 170px;';
                        } else if (index === 4) {
                            widthStyle = 'width: 50px;';
                            minWidthStyle = 'min-width: 150px;';
                        } else if (index === 5) {
                            widthStyle = 'width: 45px;';
                            minWidthStyle = 'min-width: 200px;';
                        } else if (index === 5) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 150px;';
                        } else if (index === 6) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 200px;';
                        } else if (index === 7) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 170px;';
                        } else if (index === 8) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 170px;';
                        }

                        const $cell = $(`<td style='${widthStyle} ${minWidthStyle}'>`).append(
                            cell);

                        // Cek apakah elemen input memiliki atribut 'name' yang sama dengan 'harga[]' atau 'totalharga[]'
                        if ($cell.find('[name="harga[]"]').length > 0) {
                            const hargaTdId = `harga${idDetailsLookup}`;
                            $cell.attr('id', hargaTdId);
                            $cell.addClass('harga');
                        } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                            const totalhargaTdId = `totalharga${idDetailsLookup}`;
                            $cell.attr('id', totalhargaTdId);
                            $cell.addClass('totalharga');
                        } else if ($cell.find('[name="qty[]"]').length > 0) {
                            const qty = `qty${idDetailsLookup}`;
                            $cell.addClass('qty');
                        } else if ($cell.find('[name="qtystok[]"]').length > 0) {
                            const qtystok = `qtystok${idDetailsLookup}`;
                            $cell.addClass('qtystok');
                        } else if ($cell.find('[name="qtypesanan[]"]').length > 0) {
                            const qtypesanan = `qtypesanan${idDetailsLookup}`;
                            $cell.addClass('qtypesanan');
                        } else if ($cell.find('[name="qtyretur[]"]').length > 0) {
                            const qtypesanan = `qtyretur${idDetailsLookup}`;
                            $cell.addClass('qtyretur');
                            $cell.attr('id', qtypesanan);
                        }

                        productRow.append($cell);

                    });
                    table.append(productRow);

                    // 
                    totalPrice += details.harga; // Accumulate the total price

                });

                // Display total price row
                const addRow = $("<tr class='addRow'>");
                    addRow.append($('<td colspan="10">'));
                    // addRow.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                    addRow.append(
                        $(
                            `<td class="subtotal"><button type="button" class="btn btn-primary btn-sm my-2 add-detail-row" id="addRow" idheader="${entry.id}" data-index="${indexHeader}">TAMBAH</button></td>`
                        )
                    );

                    table.append(addRow);

                // Display total price row
                const totalRow = $("<tr class='totalan'>");
                totalRow.append($('<td colspan="8">'));
                totalRow.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                totalRow.append($(
                    `<td class="subtotal"><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                ));

                table.append(totalRow);

                // Add additional row below the total row
                const potRow = $("<tr class='potongan'>");
                potRow.append($('<td colspan="8">'));
                potRow.append($('<td colspan="1" class="totalan">potongan:</td>'));

                potRow.append($(
                    `<td class="potongan"><input type="text" name="potongan[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.potongan}"></td>`
                ));

                table.append(potRow);

                const totalFinalRow = $("<tr class='total'>");
                totalFinalRow.append($('<td colspan="8">'));
                totalFinalRow.append($('<td colspan="1" class="totalan">Total:</td>'));

                totalFinalRow.append($(
                    `<td class="total"><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.total}" readonly></td>`
                ));
                table.append(totalFinalRow);
                tableContainer.append(table);

                $("#editAllTableBody").append(tableContainer);

                $.each(entry.details, function(index, details) {
                    if (details.pesananfinaldetailid !== "0") {
                        addRow.find(`#addRow`).attr('disabled', true)
                        addRow.find(`.delete-roweditall`).attr('disabled', true)
                        detailRow.find('input').prop('disabled', true)
                        detailRow.find('input').removeClass('bg-white state-delete')
                        table.find(`[name="productnama[]"]`).prop('readonly', true)
                        table.find(`[name="satuannama[]"]`).prop('readonly', true)
                        table.find(`[name="qtypesanan[]"]`).prop('readonly', true)
                        table.find(`[name="qtystok[]"]`).prop('readonly', true)
                        // table.find(`[name="keterangandetail[]"]`).prop('readonly', true) 
                        // table.find(`[name="harga[]"]`).prop('readonly', true)
                        table.find(`[name="totalharga[]"]`).prop('readonly', true)
                        table.find(`[name="totalharga[]"]`).removeClass('bg-white state-delete')

                        totalRow.find('input').prop('readonly', true)
                        totalRow.find('input').addClass('bg-white state-delete')

                        // potRow.find('input').prop('disabled', true)
                        // potRow.find('input').removeClass('bg-white state-delete')

                        totalFinalRow.find('input').prop('readonly', true)
                        // totalFinalRow.find('input').removeClass('bg-white state-delete')
                    }else if (details.pesananfinaldetailid === "0") {
                        table.find(`[name="qtypesanan[]"]`).prop('readonly', true)
                        table.find(`[name="qtystok[]"]`).prop('readonly', true)
                        table.find(`[name="qtypesanan[]"]`).addClass('bg-white state-delete')
                        table.find(`[name="qtystok[]"]`).addClass('bg-white state-delete')

                        totalRow.find('input').prop('readonly', true)
                        totalRow.find('input').addClass('bg-white state-delete')
                        detailRow.find(`[name="nobukti[]"]`).prop('readonly', true);
                        detailRow.find(`[name="tglbuktieditall[]"]`).prop('readonly', true);
                        detailRow.find(`[name="suppliernama[]"]`).prop('readonly', true);
                        detailRow.find(`[name="suppliernama[]"]`).addClass('bg-white state-delete')
                    }

                  
                  
                    idDetailsLookup = `${indexHeader}-${index}`
                    initLookupDetailEditAll(idDetailsLookup, table, details)
                    // console.log(table.find(`[name="qtystok[]"]`));
                    setQtyStok(details.productid, table.find(`[name="qtystok[]"]`))

                });

                table.find(`[name="qty[]"]`).prop('readonly', true)

                if (entry.nominalbayar > 0) {
                        table.find(`[name="productnama[]"]`).prop('disabled', true)
                        table.find(`[name="satuannama[]"]`).prop('disabled', true)
                        table.find(`[name="qty[]"]`).prop('disabled', true)
                        table.find(`[name="qtystok[]"]`).prop('disabled', true)
                        table.find(`[name="qtyretur[]"]`).prop('disabled', true)
                        table.find(`[name="qtypesanan[]"]`).prop('disabled', true)
                        table.find(`[name="keterangandetail[]"]`).prop('disabled', true)
                        table.find(`[name="harga[]"]`).prop('disabled', true)
                        table.find(`[name="totalharga[]"]`).prop('disabled', true)

                        addRow.find(`#addRow`).attr('disabled', true)
                }


                trLength = table.find('.detail-row');

                if (trLength.length == 1) {
                    trLength.find('.delete-roweditall').prop('disabled',true)
                }

                table.on('input', 'input[name="potongan[]"]', function() {

                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAll(parentEl)
                    // pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="qty[]"]', function() {
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    parentEl = $(this).closest(`table`)

                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = $(data).attr('id');
                        elementQty = parentEl.find(`tr#${childEl}`)
                        setTotalHargaEditAll(elementQty)
                        setQtyPesanan(elementQty)
                    })
                    setSubTotalEditAll(parentEl)
                    setTotalEditAll(parentEl)
                    // pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="qtyretur[]"]', function() {
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    parentEl = $(this).closest(`table`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = $(data).attr('id');
                        elementQtyRetur = parentEl.find(`tr#${childEl}`)
                        
                        
                        checkJumlahQtyreturEditAll(elementQtyRetur)
                        cekStokEditAll(elementQtyRetur)
                        
                    })
                    zeroQtyReturEditAll($(this))
                })


                table.on('input', 'input[name="harga[]"]', function() {
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    parentEl = $(this).closest(`table`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = $(data).attr('id');
                        elementHarga = parentEl.find(`tr#${childEl}`)
                        setTotalHargaEditAll(elementHarga)
                    })

                    setSubTotalEditAll(parentEl)
                    setTotalEditAll(parentEl)
                    // pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="tax[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTaxEditAll(parentEl)
                    setTotalEditAll(parentEl)
                })

                table.on('input', 'input[name="discount[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAll(parentEl)
                })



                if (entry.nominalbayar > 0) {
                    
                    // Disable all input elements in detailRow
                    detailRow.find('input').prop('disabled', true)
                    table.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRow.find('input').prop('disabled', true)
                    potRow.find('input').prop('disabled', true)
                    totalFinalRow.find('input').prop('disabled', true)
                    table.find('input').removeClass('bg-white state-delete')

                    
                    detailRow.find('[name="productnama[]"]').prop('disabled', true)
                }
                initLookupHeader(indexHeader, table, entry)
                initAutoNumericNoDoubleZero(table.find(`[name="harga[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="totalharga[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="subtotal[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="potongan[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="total[]"]`))
                initAutoNumeric(table.find(`[name="qty[]"]`))
                initAutoNumeric(table.find(`[name="qtystok[]"]`))
                initAutoNumeric(table.find(`[name="qtyretur[]"]`))
                initAutoNumeric(table.find(`[name="qtypesanan[]"]`))
            });
        }
    }

    function zeroQtyReturEditAll(element){
        let qtyVal = parseFloat($(element.closest('tr').find(`input[name="qtyretur[]"]`)).val().replace(/,/g, ''));

        // Check if qtyVal is NaN and replace it with ' ' if true
        if (isNaN(qtyVal)) {
            qtyVal = '';
        }
       
        let trIndex = $(element).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

        console.log(element.val());

        if (element.val() == '') {
            let ids = $(element.closest('tr')).attr('id')

            let trIndex = $(element).data('trindex')

            elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

          
            $(element.closest('tr').find(`input[name="qtyretur[]"]`)).remove()

            let newQtyReturEl = `<input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

            console.log('element new',elementSecond.parents('tr').find(`#qtyretur${ids}`));
            elementSecond.parents('tr').find(`#qtyretur${ids}`).append(newQtyReturEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))
        }
       
    }

    function cekStokEditAll(element) {
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
       
        },
        success: response => {
            // console.log(response);
            // initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))

            console.log(element.find(` [name="qtystok[]"]`));
            let qtyStokVal = parseFloat(element.find(` [name="qtystok[]"]`).val().replace(/,/g, ''))
            let qtyVal = parseFloat(element.find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))
            let originalqty = parseFloat(element.find(` [name="originalqty[]"]`).val().replace(/,/g, ''))


            if (qtyVal > qtyStokVal) {
            let ids = $(element.closest('tr')).attr('id')
            console.log(ids);
            showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtyStokVal}.`);

            let trIndex = $(element).data('trindex')

            elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

          
            $(element.closest('tr').find(`input[name="qtyretur[]"]`)).remove()

            let newQtyReturEl = `<input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

            console.log('element new',elementSecond.parents('tr').find(`#qtyretur${ids}`));
            elementSecond.parents('tr').find(`#qtyretur${ids}`).append(newQtyReturEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))

            // setTotalHarga($(elementSecond.closest('tr').find(`input[name="qtyretur[]"]`)))
            // setSubTotal()
            // setTotal()
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

    function checkJumlahQtyreturEditAll(element){
        iddetail = $(element.closest('tr').find(`input[name="iddetail[]"]`)).val()

        $.ajax({
            url: `${apiUrl}pembelianheader/cekjumlahqtyretur`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                iddetail: iddetail,
                id: $('#crudForm').find('[name=id]').val()
            },
            success: response => {
                modalCheckQtyEditAll(response, element);
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

    function modalCheckQtyEditAll(response, element) {
        let qtyPembelian = response.qtypembelian
        let qtyretur = response.qtyretur

        let jumlahKeseluruhan = qtyPembelian + qtyretur

        let qtyreturCheck = parseFloat(element.find(` [name="qtyretur[]"]`).val().replace(/,/g, ''))
        let originalqtyCheck = parseFloat(element.find(` [name="originalqty[]"]`).val().replace(/,/g, ''))
        let amountqtyCheck = originalqtyCheck - qtyreturCheck

        let qtyreturValue = qtyreturCheck

        console.log(qtyreturValue, jumlahKeseluruhan);
        let parentQtyRetur = element.find(`.qtyretur`)
        if (qtyreturValue > jumlahKeseluruhan && jumlahKeseluruhan != '') {
            element.find(` [name="qtyretur[]"]`).remove()

            let newQtyretur = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            parentQtyRetur.append(newQtyretur)

            elementParentQtyRetur = parentQtyRetur.find(`[name="qtyretur[]"]`)

            initAutoNumeric(parentQtyRetur.find(`[name="qtyretur[]"]`))
            initAutoNumeric(elementParentQtyRetur.find(`td [name="qty[]"]`).val(originalqtyCheck))

            showDialog(`Maksimal input qty retur = ${originalqtyCheck} !`);
        } else if (amountqtyCheck < 0) {
            element.find(` [name="qtyretur[]"]`).remove()

            let newQtyretur = `<input type="text" name="qtyretur[]" class="form-control autonumeric" value="0">`

            parentQtyRetur.append(newQtyretur)

            elementParentQtyRetur = parentQtyRetur.find(`[name="qtyretur[]"]`)

            initAutoNumeric(parentQtyRetur.find(`[name="qtyretur[]"]`))
            initAutoNumeric(elementParentQtyRetur.find(`td [name="qty[]"]`).val(originalqtyCheck))

            // showDialog('Qty retur tidak boleh melebihi qty beli');
            showDialog(`Maksimal input qty retur = ${originalqtyCheck} !`);
        }
    }

    
    $(document).on("click", ".add-detail-row", function() {
        let idheader = $(this).attr('idheader')
        addRowDetail($(this), $(this).data('index'), idheader)
    });

    // Add event listener for deleting rows
    $(document).on("click", ".delete-roweditall", function() {
        deleteRowEditAll($(this))
    });

    
    function deleteRowEditAll(element) {
        rowTable = element.closest("table").find('.detail-row');
        rowTableAddRow = element.closest("table").find('.tr-addrow');

        indexHeader = element.closest("table").find('button.add-detail-row').data('index');

        element.closest("tr").remove();

        rowTable.each((index, element) => {
            indexAddRow = `${indexHeader}-${index-1}`
            lookupIndex = `${indexHeader}-${index}`
            
            $(element).find('[name="productnama[]"]').removeClass(`producteditall-lookup${lookupIndex}`);
            $(element).find('[name="productnama[]"]').addClass(`producteditall-lookup${indexAddRow}`);

            $(element).find('[name="satuannama[]"]').removeClass(`satuaneditall-lookup${lookupIndex}`);
            $(element).find('[name="satuannama[]"]').addClass(`satuaneditall-lookup${indexAddRow}`);

            $(element).attr('id', indexAddRow)
            

        })
        parentTable = rowTable.closest(`table`);

        trRow = parentTable.find('.detail-row');

        if (trRow.length == 1) {
            trRow.find('.delete-roweditall').prop('disabled', true)

        }
        // console.log();

        trRow.each((index, element) => {
            $(element).find('td.row-number').text(index + 1);

        })


        // console.log(rowTable.length);

        setSubTotalEditAll(parentTable)
        setTotalEditAll(parentTable)
    }


    function addRowDetail(element, currentIndexHeader, idheader) {
        const addRow = element.closest(".addRow");
        let indexAddRow = addRow.index()
        let indexDetailAddRow = element.closest("table").find('.detail-row').length;
        let indexAddRowCurrent = `${currentIndexHeader}-${indexDetailAddRow}`

        const newRow = $(`<tr class="detail-row data-detail tr-addrow" id="${indexAddRowCurrent}">`);

        // Menambahkan nomor baris sebagai sel pertama
        newRow.append($("<td class='row-number'>").text(indexDetailAddRow + 1));

        // Array sel-sel yang akan ditambahkan ke dalam baris baru
        const cells = [
            `
            <input type="hidden" name="pesananfinalid[]" class="form-control filled-row pesananfinalid" value="0" >
                <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row pesananfinaldetailid" value="0">
                <input type="hidden" name="iddetail[]" class="form-control iddetail-addrow iddetail filled-row" value="0">
                <input type="hidden" name="idheader[]" class="form-control idheader filled-row" value="${idheader}">
                <input type="hidden" name="productid[]" class="form-control hidden-2 productid filled-row">
                <input type="text" name="productnama[]" id="productnama" class="form-control filled-row lg-form producteditall-lookup${indexAddRowCurrent}" autocomplete="off">`,
            `<input type="hidden" name="satuanid[]" class="form-control filled-row">
                <input type="text" name="satuannama[]" id="satuannama" class="form-control filled-row lg-form satuaneditall-lookup${indexAddRowCurrent}" autocomplete="off">`,
            `<input type="hidden" name="pesananfinaldetailid[]" class="form-control lg-form filled-row autonumeric autonumeric-zero pesananfinaldetailid " autocomplete="off" value="0"> 
                <input type="text" name="qty[]" class="form-control lg-form addrow-qty filled-row autonumeric qty autonumeric-zero " autocomplete="off" > 
                <input type="hidden" name="originalqty[]" class="form-control addrow-qtyoriginal lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" >`,
            `<input type="text" name="qtystok[]" class="form-control addrow-qtystok lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            `<input type="text" name="qtyretur[]" class="form-control addrow-qtyretur lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            `<input type="text" name="qtypesanan[]" class="form-control addrow-qtypesanan lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            createInputDetail("keterangandetail", ""),
            `<input type="text" name="harga[]" class="form-control addrow-harga lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" >`,
            `<input type="text" name="totalharga[]" class="form-control addrow-totalharga lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`,
            `<button type="button" class="btn btn-danger btn-sm delete-roweditall">Delete</button>`,
        ];

        cells.forEach((cell, index) => {
            let widthStyle = '';
            let minWidthStyle = '';
            if (index === 0) {
                widthStyle = 'width: 100px;';
                minWidthStyle = 'min-width: 170px;';
            } else if (index === 1) {
                widthStyle = 'width: 50px;';
                minWidthStyle = 'min-width: 130px;';
            } else if (index === 2) {
                widthStyle = 'width: 60px;';
                minWidthStyle = 'min-width: 150px;';
            } else if (index === 3) {
                widthStyle = 'width: 100px;';
                minWidthStyle = 'min-width: 170px;';
            } else if (index === 4) {
                widthStyle = 'width: 45px;';
                minWidthStyle = 'min-width: 200px;';
            } else if (index === 5) {
                widthStyle = 'width: 45px;';
                minWidthStyle = 'min-width: 200px;';
            } else if (index === 5) {
                widthStyle = 'width: 100px;';
                minWidthStyle = 'min-width: 150px;';
            } else if (index === 6) {
                widthStyle = 'width: 100px;';
                minWidthStyle = 'min-width: 200px;';
            }

            const $cell = $(`<td style='${widthStyle} ${minWidthStyle}'>`).append(cell);


            // Menambahkan ID dan kelas sesuai dengan kondisi yang diberikan
            if ($cell.find('[name="harga[]"]').length > 0) {
                const hargaTdId = `harga${indexAddRowCurrent}`;
                $cell.attr('id', hargaTdId);
                $cell.addClass('harga');
            } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                const totalhargaTdId = `totalharga${indexAddRowCurrent}`;
                $cell.attr('id', totalhargaTdId);
                $cell.addClass('totalharga');
            } else if ($cell.find('[name="qty[]"]').length > 0) {
                const qty = `qty${indexAddRowCurrent}`;
                $cell.attr('id', qty);
                $cell.addClass('qty');
            } else if ($cell.find('[name="qtyretur[]"]').length > 0) {
                const qtyretur = `qtyretur${indexAddRowCurrent}`;
                $cell.attr('id', qtyretur);
                $cell.addClass('qtyretur');
            } else if ($cell.find('[name="qtypesanan[]"]').length > 0) {
                const qtypesanan = `qtypesanan${indexAddRowCurrent}`;
                $cell.attr('id', qtypesanan);
                $cell.addClass('qtypesanan');
            } else if ($cell.find('[name="qtystok[]"]').length > 0) {
                const qtystok = `qtystok${indexAddRowCurrent}`;
                $cell.attr('id', qtystok);
                $cell.addClass('qtystok');
            }


            newRow.append($cell);
        });

        addRow.before(newRow);

        newRow.find(`.addrow-qty`).remove();
        newRow.find(`.addrow-harga`).remove();
        newRow.find(`.addrow-qtyoriginal`).remove();
        newRow.find(`.addrow-qtyretur`).remove();
        newRow.find(`.addrow-qtypesanan`).remove();
        newRow.find(`.addrow-qtystok`).remove();
        newRow.find(`.addrow-totalharga`).remove();

        let newqty =
            `<input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"><input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"> `

        let newharga =
            `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" value="0" >`

        let newqtyretur =
            `<input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtypesanan =
            `<input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtystok =
            `<input type="text" name="qtystok[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtytotalharga =
            `<input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`


        newRow.find(`#qty${indexAddRowCurrent}`).append(newqty);
        newRow.find(`#harga${indexAddRowCurrent}`).append(newharga);
        newRow.find(`#qtyretur${indexAddRowCurrent}`).append(newqtyretur);
        newRow.find(`#qtystok${indexAddRowCurrent}`).append(newqtystok);
        newRow.find(`#qtypesanan${indexAddRowCurrent}`).append(newqtypesanan);
        newRow.find(`#totalharga${indexAddRowCurrent}`).append(newqtytotalharga);

        initAutoNumeric(newRow.find(`[name="qty[]"]`))
        initAutoNumeric(newRow.find(`[name="qtyretur[]"]`))
        initAutoNumeric(newRow.find(`[name="qtystok[]"]`))
        initAutoNumeric(newRow.find(`[name="qtypesanan[]"]`))
        initAutoNumericNoDoubleZero(newRow.find(`[name="harga[]"]`))
        initLookupDetailEditAll(indexAddRowCurrent, element.closest('table'))

        buttonCLearAll = element.closest('table').find('tr.detail-row .delete-roweditall')

        if (buttonCLearAll.is(':disabled')) {
            buttonCLearAll.prop('disabled',false)
        }
    }





    function createInput(name, value, valueid, id = '') {

        if (id != '') {
            return $(
                `<input type="hidden" name="id[]" class="form-control filled-row" value="${valueid}" >
                <input type="text" name="${name}[]" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
            );
        } else {
            return $(
                `<input type="text" name="${name}[]" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
            );
        }

    }

    function createInputDetail(name, value) {
        return $(
            `<input type="text" name="${name}[]" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
        );
    }

    function createInputLookup(name, value, id, selectIndex, initLookup, statusid, pesananfinaldetailid, pesananfinalid,
        valueid2, idheader, id2 = '') {
        if (id2 != '') {

            return $(
                ` <input type="hidden" name="pesananfinalid[]" class="form-control filled-row pesananfinalid" value="${pesananfinalid}" >
                <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row pesananfinaldetailid" value="${pesananfinaldetailid}" >
                <input type="hidden" name="idheader[]" class="form-control idheader filled-row" value="${idheader}" >
                <input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="${valueid2}" >
                <input type="hidden" name="${id}[]" class="form-control productid filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        } else {
            return $(
                `<input type="hidden" name="${id}[]" class="form-control filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        }

    }

    function initLookupHeader(index, detailRowEditAll, detail, tableEL) {
        let rowLookup = index;

        $(`.karyawaneditall-lookup${rowLookup}`).lookup({
            title: 'karyawan Lookup',
            fileName: 'karyawan',
            detail: true,
            miniSize: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    searching: 1,
                    valueName: `karyawan_${index}`,
                    id: `karyawan_${rowLookup}`,
                    searchText: `karyawaneditall-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'karyawan',
                    karyawanid: $('#editAll').find('[name=karyawan]').val()
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (karyawan, element) => {
                let karyawan_id_input = element.parents('td').find(`[name="karyawan[]"]`);
                element.parents('tr').find('td [name="karyawanid[]"]').val(karyawan.id)
                element.parents('tr').find('td [name="karyawannama[]"]').val(karyawan.nama)



                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let item_id_input = element.parents('td').find(`[name="karyawanid[]"]`).first();
                item_id_input.val('');
                element.val('');

                element.data('currentValue', element.val());
            },
        });

        $(`.suppliereditall-lookup${rowLookup}`).lookup({
                title: 'supplier Lookup',
                fileName: 'supplier',
                detail: true,
                miniSize: true,
                searching: 1,
                beforeProcess: function() {
                    this.postData = {
                        searching: 1,
                        valueName: `supplier_${index}`,
                        id: `supplier_${rowLookup}`,
                        searchText: `suppliereditall-lookup${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'supplier',
                        supplierid: $('#editAll').find('[name=supplier]').val()
                        // typeSearch: 'ALL',
                    };
                },
                onSelectRow: (supplier, element) => {

                    let supplier_id_input = element.parents('td').find(`[name="supplier[]"]`);
                    element.parents('tr').find('td [name="supplierid[]"]').val(supplier.id)
                    element.parents('tr').find('td [name="suppliernama[]"]').val(supplier.nama)

                    element.parents('tr').find('td [name="alamatpengiriman[]"]').val(supplier.alamat)



                    element.data('currentValue', element.val());
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let item_id_input = element.parents('td').find(`[name="supplierid[]"]`).first();
                    item_id_input.val('');
                    element.val('');

                    element.data('currentValue', element.val());
                },
            });

            $(`.topeditall-lookup${rowLookup}`).lookup({
                title: 'top Lookup',
                fileName: 'parameter',
                detail: true,
                miniSize: true,
                searching: 1,
                beforeProcess: function() {
                    this.postData = {
                        url: `${apiUrl}parameter/combo`,
                        grp: 'TOP',
                        subgrp: 'TOP',
                        searching: 1,
                        valueName: `top_${index}`,
                        id: `top_${rowLookup}`,
                        searchText: `topeditall-lookup${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'top',
                        topid: $('#editAll').find('[name=top]').val()
                        // typeSearch: 'ALL',
                    };
                },
                onSelectRow: (top, element) => {

                    let top_id_input = element.parents('td').find(`[name="top[]"]`);
                    element.parents('tr').find('td [name="top[]"]').val(top.id)
                    element.parents('tr').find('td [name="topnama[]"]').val(top.text)

                    element.data('currentValue', element.val());
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let item_id_input = element.parents('td').find(`[name="top[]"]`).first();
                    item_id_input.val('');
                    element.val('');

                    element.data('currentValue', element.val());
                },
            });
    }

    function initLookupDetailEditAll(indexDetail, detailRowEditAll, detail) {
        let rowLookupDetail = indexDetail;
        let detailRowElement = detailRowEditAll.find('.detail-row');

        $(`.producteditall-lookup${rowLookupDetail}`).lookup({
            title: 'product Lookup',
            fileName: 'product',
            detail: true,
            miniSize: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    searching: 1,
                    valueName: `product_${indexDetail}`,
                    id: `product_${rowLookupDetail}`,
                    searchText: `producteditall-lookup${rowLookupDetail}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'product',
                    productid: $('#editAll').find('[name=product]').val()
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (product, element) => {
                parentTable = element.closest('table')


                let product_id_input = element.parents('td').find(`[name="product[]"]`);
                element.parents('tr').find('td [name="productid[]"]').val(product.id)
                element.parents('tr').find('td [name="productnama[]"]').val(product.nama)


                element.data('currentValue', element.val());

                element.parents('tr').find(`td [name="harga[]"]`).remove();
                element.parents('tr').find(`td [name="totalharga[]"]`).remove();


                let newHargaEl =
                    `<input type="text" name="harga[]" class="form-control autonumeric" value="${product.hargajual}">`


                let newTotalHargaEl =
                    `<input type="text" name="totalharga[]" class="form-control autonumeric bg-white state-delete" value="0" readonly>`

                element.parents('tr').find(`#harga${rowLookupDetail}`).append(newHargaEl)
                element.parents('tr').find(`#totalharga${rowLookupDetail}`).append(newTotalHargaEl)

                $.each(detailRowElement, function(index, data) {
                    childEl = $(data).attr('id');
                    detailPerRow = detailRowEditAll.find(`tr#${childEl}`)

                    setTotalHargaEditAll(detailPerRow)
                })

                initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
                setSubTotalEditAll(parentTable)
                setTotalEditAll(parentTable)

            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let item_id_input = element.parents('td').find(`[name="customerid[]"]`).first();
                item_id_input.val('');
                element.val('');

                element.data('currentValue', element.val());
            },
        });

        $(`.satuaneditall-lookup${rowLookupDetail}`).lookup({
            title: 'Satuan Lookup',
            fileName: 'satuan',
            detail: true,
            miniSize: true,
            rowIndex: rowLookupDetail,
            totalRow: 49,
            alignRightMobile: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `satuanId_${indexDetail}`,
                    id: `SatuanId_${rowLookupDetail}`,
                    searchText: `satuaneditall-lookup${rowLookupDetail}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Satuan',
                };
            },
            onSelectRow: (satuan, element) => {
                let satuan_id_input = element.parents('td').find(`[name="satuan[]"]`);
                element.parents('tr').find('td [name="satuanid[]"]').val(satuan.id)
                element.parents('tr').find('td [name="satuannama[]"]').val(satuan.nama)



                element.data('currentValue', element.val());
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let satuan_id_input = element.parents('td').find(`[name="satuanid[]"]`).first();
                satuan_id_input.val('');
                element.val('');

                element.data('currentValue', element.val());
                element.data('currentValue', element.val());
            },
        });
    }

    function initLookupRequest(){
        $('.karyawanrequest-lookup').lookup({
            title: 'karyawan Lookup',
            fileName: 'karyawan',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'karyawan_id',
                    searchText: 'karyawanrequest-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'karyawan',
                }
            },
            onSelectRow: (karyawan, element) => {
                console.log('select');
                $('#editAllModal [name=karyawanid]').first().val(karyawan.id)
                element.val(karyawan.nama)
                element.data('currentValue', element.val())

                // let karyawanid = $('#editAllModal').find(`[name="karyawanid[]"]`).val()
                
                $('#editAllModal [name="karyawanidtransaksibelanja[]"]').first().val(karyawan.id)
                // $('#editAllModal').find(`[name="karyawanidtransaksibelanja[]"]`).val(karyawan.id)


                getAll(1, 10,karyawan.id)
                karyawanidrequest = karyawan.id
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#editAllModal [name=karyawanid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
               
                getAll(1, 10)
            }
        })
    }

    function initLookupTransaksiBelanja(index){
        let rowLookup = index;

        $(`.perkiraaneditall-lookup${rowLookup}`).lookup({
            title: 'Item Lookup',
            fileName: 'perkiraan',
            detail: true,
            miniSize: true,
            searching: 1,
            alignRightMobile: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `perkiraanid${index}`,
                    id: `perkiraanid${rowLookup}`,
                    searchText: `perkiraaneditall-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Perkiraan',
                    customerid: $('#editAllTransaksiBelanjaForm').find('[name=perkiraanid]').val(),
                    group:'belanja'
                    // limit: 0
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (perkiraan, element) => {
                let perkiraan_id_input = element.parents('td').find(`[name="perkiraanidtransaksibelanja[]"]`);

                element.parents('tr').find('td [name="perkiraanidtransaksibelanja[]"]').val(perkiraan.id)
                element.parents('tr').find('td [name="perkiraannamatransaksibelanja[]"]').val(perkiraan.nama)
                element.parents('tr').find('td [name="keterangantransaksibelanja[]"]').val(perkiraan.keterangan)

                if (perkiraan.nama == 'PEMBELIAN KEPADA SUPPLIER') {
                    // $('.is-invalid').removeClass('is-invalid')
                    
                    element.parents('tr').find('td [name="pembeliannamatransaksibelanja[]"]').removeAttr('readonly');
                    element.parents('tr').find('td [name="pembeliannamatransaksibelanja[]"]').parent('.input-group').find('.lookup-toggler').prop('disabled', false);
                    element.parents('tr').find('td [name="pembeliannamatransaksibelanja[]"]').parent('.input-group').find('.button-clear').prop('disabled', false);
                }

                hitungPanjar()
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let perkiraan_id_input = element.parents('td').find(`[name="perkiraanidtransaksibelanja[]"]`).first();
                perkiraan_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $(`.pembelianeditall-lookup${rowLookup}`).lookup({
            title: 'Item Lookup',
            fileName: 'pembelian',
            detail: true,
            miniSize: true,
            searching: 1,
            alignRightMobile: true,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `pembelianid${index}`,
                    id: `pembelianid${rowLookup}`,
                    searchText: `pembelianeditall-lookup${rowLookup}`,
                    singleColumn: true,
                    title: 'pembelian',
                    customerid: $('#editAllTransaksiBelanjaForm').find('[name=pembelianidtransaksibelanja]').val(),
                    karyawanid : $('#editAllModal [name="karyawanid').val()
                    // limit: 0
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (pembelian, element) => {
                let pembelian_id_input = element.parents('td').find(`[name="pembelianidtransaksibelanja[]"]`);

                element.parents('tr').find('td [name="pembelianidtransaksibelanja[]"]').val(pembelian.id)
                element.parents('tr').find('td [name="pembeliannamatransaksibelanja[]"]').val(pembelian.nobukti)

                keteranganGenerate = `nobukti: ${pembelian.nobukti},supplier: ${pembelian.suppliernama}`;
                element.parents('tr').find('td [name="keterangantransaksibelanja[]"]').val(keteranganGenerate)
                
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let perkiraan_id_input = element.parents('td').find(`[name="pembelianidtransaksibelanja[]"]`).first();
                perkiraan_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $(`.karyawaneditalltransaksibelanja-lookup${rowLookup}`).lookup({
            title: 'karayawan Lookup',
            fileName: 'karyawan',
            detail: true,
            miniSize: true,
            rowIndex: rowLookup,
            totalRow: 49,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: `karayawanidtransaksibelanja${index}`,
                    id: `karayawanidtransaksibelanja${rowLookup}`,
                    searchText: `karyawaneditalltransaksibelanja-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'karyawan',
                    limit: 0,
                    karyawanid : $('#editAllModal [name="karyawanid').val()
                };
            },
            onSelectRow: (karyawan, element) => {
                let karyawan_id_input = element.parents('td').find(`[name="karyawanidtransaksibelanja[]"]`);

                element.parents('tr').find('td [name="karyawanidtransaksibelanja[]"]').val(karyawan.id)
                element.parents('tr').find('td [name="karyawannamatransaksibelanja[]"]').val(karyawan.nama)

               
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let karyawan_id_input = element.parents('td').find(`[name="karyawanidtransaksibelanja[]"]`).first();
                karyawan_id_input.val('');
                element.val('');
                // element.parents('tr').find('td [name="harga[]"]').val(0)
                // element.parents('tr').find('td [name="harga[]"]').autoNumeric('wipe')

                element.data('currentValue', element.val());
            },
        });
    }
</script>
@endpush()