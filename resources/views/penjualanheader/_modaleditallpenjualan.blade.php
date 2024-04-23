<div class="modal modal-fullscreen" id="editAllModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllModalTitle"></p>
                    <button type="button" class="close btn-batal" data-dismiss="modal" aria-label="Close"></button>
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
                                <input type="text" name="tglpengirimanjual" id="tglpengirimanjual" class="form-control lg-form datepicker filled-row">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date">
                    <table class="table table-bordered " id="editAllPenjualan">
                        <thead>
                            <!-- Add your table header here if needed -->
                        </thead>
                        <tbody id="editAllTableBody"></tbody>
                    </table>
                    <div class=" bg-white editAllPager overflow-x-hidden mt-3">
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmitEditAll" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>
                    <button class="btn btn-warning btn-cancel btn-bataleditall" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Tutup </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let modalBodyEditAll = $('#editAllModal').find('.modal-body').html()

    let dataEditAll = {}
    let dataPenjualanAll
    let detailEl = {}

    let jumlahMaster = 0;
    let jumlahDetail = 0


    $(document).ready(function() {

        $(document).on('change', `#editAllForm [id="tglpengirimanjual"]`, function() {

            $.ajax({
                url: `{{ config('app.api_url') }}penjualanheader/checkusereditall`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    date: $('#editAllForm').find('[name=tglpengirimanjual]').val(),
                    btn: 'batal'
                },
                success: response => {
                    getAll()


                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        errors = JSON.parse(error.responseText);
                        showDialogEditAllMessage(errors.errors.date)
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })



        });

        $(document).on('click', '.btn-bataleditall', function(event) {
            event.preventDefault()
            btnClick()

        })

        function btnClick() {
            $.ajax({
                url: `{{ config('app.api_url') }}penjualanheader/editalleditingat`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    date: $('#editAllForm').find('[name=tglpengirimanjual]').val(),
                    btn: 'batal'
                },
                success: response => {
                    $('#editAllModal').modal("hide")
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


        // function editingAtEditAll(date, btn) {
        //     $.ajax({
        //         url: `{{ config('app.api_url') }}penjualanheader/editalleditingat`,
        //         method: 'POST',
        //         dataType: 'JSON',
        //         headers: {
        //             Authorization: `Bearer ${accessToken}`
        //         },
        //         data: {
        //             date: date,
        //             btn: btn
        //         },
        //         success: response => {

        //             editAllPenjualan()

        //         },
        //         error: error => {
        //             errors = JSON.parse(error.responseText);


        //             showConfirmForceEditAll(errors.errors.date, date)
        //         }
        //     })
        // }


        function editingAtEditAll(date, btn) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `{{ config('app.api_url') }}penjualanheader/editalleditingat`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        date: date,
                        // id: id,
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

        function editAllPenjualan() {
            // console.log('edit all penjualan');
            let totalRows
            let lastPage
            let form = $('#editAllModal')
            $('.modal-loader').removeClass('d-none')
            form.trigger('reset')
            form.find(`#btnSubmitEditAll`).html(`<i class="fa fa-save"></i>Simpan`)
            form.data('action', 'editall')
            form.find(`.sometimes`).hide()
            $('#editAllModalTitle').text('Edit All Penjualan')
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            var besok = new Date();
            besok.setDate(besok.getDate());
            $('#editAllForm').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok))
                .trigger(
                    'change');
            $('#editAllForm').find('[name=date]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
                'change');

            var dari = new Date()
            dari.setDate(dari.getDate())
            var today = $.datepicker.formatDate('dd-mm-yy', dari)

            Promise
                .all([
                    getAll(1, 10),
                    editingAtEditAll(today, 'EDIT ALL'),
                ])
                .then((attributes) => {

                    $('#editAllModal').modal('show')

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


        $('#btnSubmitEditAll').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#editAllForm')
            let action = form.data('action')
            let detailsDataAll = [];

            for (let i = 0; i < jumlahMaster; i++) {
                if (!$(`.header${i}`).find(`tr.tax input`).is(':disabled')) {
                    let dataheader = $(`.header${i}`).find(`.data-header td.row-data${i}`);
                    let totalan = $(`.header${i}`).find(`tr.totalan `);
                    let tax = $(`.header${i}`).find(`tr.tax `);
                    let discount = $(`.header${i}`).find(`tr.discount `);
                    let total = $(`.header${i}`).find(`tr.total `);


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

                    $.each(tax, (index, row) => {
                        var taxAmountEl = $(row).find('.taxamount');

                        if (taxAmountEl.hasClass('taxamount')) {
                            let taxAmount = $(row).find('.taxamount input').prop('name')
                                .replace(/\[\]/g, '');
                            let valuetaxAmount = parseFloat($(row).find('.taxamount input')
                                .val().replace(/,/g, ''));

                            detailsDataAll[i][taxAmount] = valuetaxAmount;
                        }
                        let nama = $(row).find('input').prop('name').replace(/\[\]/g, '');
                        let value = parseFloat($(row).find('input').val().replace(/,/g, ''));

                        detailsDataAll[i][nama] = value;
                    });

                    $.each(discount, (index, row) => {
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

                        if (inputDetail.hasClass('hidden-2')) {
                            let hiddentwoInput = $(rowDetail).find('input.hidden-2').prop(
                                'name')
                            let valuehiddentwo = $(rowDetail).find('input.hidden-2').val();

                            if (!detailsDataAll[i]['details'][hiddentwoInput]) {
                                detailsDataAll[i]['details'][hiddentwoInput] = [];
                            }

                            detailsDataAll[i]['details'][hiddentwoInput].push(valuehiddentwo);
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


            $.ajax({
                url: `${apiUrl}penjualanheader/processeditall`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(detailsDataAll),
                    date: $('#editAllForm').find('[name=tglpengirimanjual]').val()
                },
                success: response => {
                    btnClick()
                    $('#editAllForm').trigger('reset')
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
        // console.log(parseFloat(element.find(`[name="harga[]"]`)));
        let hargasatuan = parseFloat(element.find(`[name="harga[]"]`).val().replace(/,/g, ''));
        let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
        let amount = qty * hargasatuan;
        initAutoNumericNoDoubleZero(element.find(`[name="totalharga[]"]`).val(amount))
    }

    function setQtysEditAll(element, childEl, id = 0) {
        let qtyreturjual = parseFloat(element.find(`[name="qtyreturjual[]"]`).val().replace(/,/g, ''));
        let originalqty = parseFloat(element.find(`[name="originalqty[]"]`).val().replace(/,/g, ''));
        let amountqty = originalqty - qtyreturjual

        if (isNaN(qtyreturjual) || qtyreturjual === 0) {
            amountqty = originalqty;
        }

        let qtyTd = element.find(`.qtyreturjual`);
        if (amountqty < 0) {
            element.find(`[name="qtyreturjual[]"]`).remove();

            let newQtyEl =
                `<input type="text" name="qtyreturjual[]" class="form-control autonumeric" value='0'>`

            qtyTd.append(newQtyEl)

            elementParentQtyRetur = element.find(`[name="qtyreturjual[]"]`)

            initAutoNumeric(element.find(`[name="qtyreturjual[]"]`))
            initAutoNumeric(element.find(`[name="qty[]"]`).val(originalqty))
            showDialog('Qty retur tidak boleh melebihi qty jual');
        } else {
            initAutoNumeric(element.find(`[name="qty[]"]`).val(amountqty))
        }

    }

    // function generateTotalHarga(element) {

    //     let hargasatuan = parseFloat(element.parents('tr').find(`td [name="harga[]"]`).val().replace(/,/g, ''))
    //     initAutoNumericNoDoubleZero(element.parents('tr').find(`td [name="totalharga[]"]`).val(hargasatuan))

    // }

    function setSubTotalEditAll(element) {
        // let nominalDetails = $(`#detailList [name="totalharga[]"]`)
        let nominalDetails = element.find(`[name="totalharga[]"]`);
        let total = 0
        $.each(nominalDetails, (index, nominalDetail) => {

            total += AutoNumeric.getNumber(nominalDetail)
        });
        initAutoNumericNoDoubleZero(element.find(`[name="subtotal[]"]`).val(total))
        // new AutoNumeric('#total').set(total)
        // new AutoNumeric('#subtotal').set(total)
    }


    function setTotalEditAll(element) {
        let grandtotal;
        let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''));
        let disc = parseFloat(element.find(`[name="discount[]"]`).val().replace(/,/g, ''));
        let taxamount = parseFloat(element.find(`[name="taxamount[]"]`).val().replace(/,/g, ''));
        grandtotal = (total + taxamount) - disc
        initAutoNumericNoDoubleZero(element.find(`[name="total[]"]`).val(grandtotal))
    }

    function setTaxEditAll(element) {
        let result;
        let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''))
        let taxlabel = parseFloat(element.find(`[name="tax[]"]`).val().replace(/,/g, ''))
        result = (taxlabel / 100) * total;
        initAutoNumericNoDoubleZero(element.find(`[name="taxamount[]"]`).val(result))
    }

    $('#editAllModal').on('shown.bs.modal', () => {

        var editAllModal = $('#editAllModal')
        let form = $('#editAll')
        setFormBindKeys(form)
        activeGrid = null

        getMaxLength(form)
        initDatepicker()

    });
    $('#editAllModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModal').find('.modal-body').html(modalBodyEditAll)
        dataEditAll = {}
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        jumlahMaster = 0
        initDatepicker('datepickerIndex')
    })


    function editingAtEditAll(date, btn) {
        $.ajax({
            url: `{{ config('app.api_url') }}penjualanheader/editalleditingat`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                date: date,
                btn: btn
            },
            success: response => {

                editAllPenjualan()

            },
            error: error => {
                errors = JSON.parse(error.responseText);


                showConfirmForceEditAll(errors.errors.date, date)
            }
        })
    }

    function editAllPenjualan() {

        let totalRows
        let lastPage
        let form = $('#editAllModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditAll').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'editall')
        form.find(`.sometimes`).hide()
        $('#editAllModalTitle').text('Edit All Penjualan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate());
        $('#editAllForm').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
            'change');
        $('#editAllForm').find('[name=date]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
            'change');

        Promise
            .all([
                getAll(1, 10),
            ])
            .then((response) => {
                dataPenjualanAll = response[0].data

                console.log(data);
                $('#editAllModal').modal('show')

                // disabledQtyReturEditAll(form,dataPenjualanAll)

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

    function setQtyReturBeli(element) {
        let qtyreturjual = parseFloat(element.parents('tr').find(` [name="qtyreturjual[]"]`).val().replace(/,/g, ''))
        initAutoNumeric(element.parents('tr').find(`td [name="qtyreturbeli[]"]`).val(qtyreturjual))
    }

    function zeroQtyReturEditAll(element) {
        let qtyVal = parseFloat($(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).val().replace(/,/g, ''));

        // Check if qtyVal is NaN and replace it with ' ' if true
        if (isNaN(qtyVal)) {
            qtyVal = '';
        }

        let trIndex = $(element).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))


        if (qtyVal == '') {
            let ids = $(element.closest('tr')).attr('id')

            let trIndex = $(element).data('trindex')

            elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))


            $(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).remove()

            let newqtyreturjualEl = `<input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`


            elementSecond.parents('tr').find(`#qtyreturjual${ids}`).append(newqtyreturjualEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturjual[]"]`)))
        }

    }

    function zeroQtyReturBeliEditAll(element) {
        let qtyVal = parseFloat($(element.closest('tr').find(`input[name="qtyreturbeli[]"]`)).val().replace(/,/g, ''));

        // Check if qtyVal is NaN and replace it with ' ' if true
        if (isNaN(qtyVal)) {
            qtyVal = '';
        }

        let trIndex = $(element).data('trindex')

        elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))


        if (qtyVal == '') {
            let ids = $(element.closest('tr')).attr('id')

            let trIndex = $(element).data('trindex')

            elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))


            $(element.closest('tr').find(`input[name="qtyreturbeli[]"]`)).remove()

            let newqtyEl = `<input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`


            elementSecond.parents('tr').find(`#qtyreturbeli${ids}`).append(newqtyEl)
            initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturbeli[]"]`)))
        }

    }

    function disabledQtyReturEditAll(form, datapenjualan) {
        $.ajax({
            url: `${apiUrl}penjualanheader/disabledqtyretureditall`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                'Authorization': `Bearer ${accessToken}`
            },
            data: {
                data: JSON.stringify(datapenjualan),
                date: $('#editAllForm').find('[name=tglpengirimanjual]').val()
            },
            success: response => {
                console.log(response);
                $.each(response.check, (index, value) => {
                    if (value.nobuktipembelian == '') {
                        $('#editAllModal').find(`[name="qtyreturjual[]"]`).prop('readonly', true)
                            .addClass('bg-white state-delete')
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

    function checkJumlahQtyreturEditAll(element, id, data) {
        iddetail = $(element.closest('tr').find(`input[name="iddetail[]"]`)).val()

        $.ajax({
            url: `${apiUrl}penjualanheader/cekjumlahqtyretur`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                iddetail: iddetail,
            },
            success: response => {
                let qty = parseFloat($(element.closest('tr').find(`input[name="qty[]"]`)).val().replace(/,/g, ''))

                let qtyreturjual = parseFloat($(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).val().replace(
                    /,/g, ''))

                let sisaqtyretur = qty - response.data.totalqtyretur
                let amountqtyretur = qtyreturjual + response.data.totalqtyretur

                console.log(element.find('td [name="qty[]"]'));

                let ids = $(element.closest('tr')).attr('id')
                if (amountqtyretur > qty) {
                    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
                    $(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).remove()

                    let newQtyReturEl = `<input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

                    elementSecond.parents('tr').find(`#qtyreturjual${ids}`).append(newQtyReturEl)

                    initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturjual[]"]`)))

                    showDialog(`Maksimal input qty retur = ${sisaqtyretur} !`)

                }

                if (qtyreturjual > qty) {
                    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))
                    $(element.closest('tr').find(`input[name="qtyreturjual[]"]`)).remove()

                    let newQtyReturEl = `<input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

                    elementSecond.parents('tr').find(`#qtyreturjual${ids}`).append(newQtyReturEl)

                    initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qtyreturjual[]"]`)))

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

    function cekValidasiAksiEditAll() {
        $.ajax({
            url: `{{ config('app.api_url') }}penjualanheader/cekvalidasieditall`,
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
                    editAllPenjualan()
                }
            }
        })
    }

    function getAll(page, limit = 10, filters = []) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}penjualanheader/editall`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    page: page,
                    limit: limit,
                    sortIndex: 'nobukti',
                    sortOrder: 'desc',
                    tglpengirimanjual: $('#editAllForm').find('[id=tglpengirimanjual]').val()
                    // filters: JSON.stringify(filters)
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAll tbody').html('')

                    data = response.data

                    detailHeader = ["No", "Customer", "Top", "No Bukti", "tgl bukti",
                        "alamat pengiriman", "tgl pengiriman", "keterangan",
                    ]

                    subHeader = ["No", "product", "satuan", "Qty", "Qty Retur Jual", "Qty Retur Beli", "keterangan",
                        "Harga", "total Harga", "aksi"
                    ]

                    // initValue(data)
                    createTable(data, detailHeader, subHeader);

                    currentPage = page
                    totalPages = response.attributes.totalPages
                    totalRowsEditAll = response.attributes.totalRows

                    disabledQtyReturEditAll($('#editAllModal'), data)

                    initDatepicker()
                    resolve(response)

                },
                error: error => {

                    reject(error)
                },
            })
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
                const detailRow = $(`<tr class="data-header">`);
                detailRow.append($("<td>").text(indexHeader + 1));

                const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                const tglpengiriman = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglpengiriman));


                const detailCells = [
                    createInputLookup("customernama", entry.customernama, 'customerid', indexHeader,
                        'customereditall', entry.customerid),
                    createInputLookup("topnama", entry.top, 'top', indexHeader,
                        'topeditall', entry.topid),
                    `<input type="text" name="nobukti[]" class="form-control  lg-form filled-row" autocomplete="off" value="${entry.nobukti}" />`,
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                        <input type="hidden" name="pesananfinalid[]" class="form-control filled-row pesananfinalid" value="${entry.pesananfinalid || 0}" >
                    <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglbukti}"></div>`,
                    createInput("alamatpengiriman", entry.alamatpengiriman),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglpengirimaneditall[]" id="tglpengiriman${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglpengiriman}"></div>`,
                    createInput("keterangan", entry.keterangan),

                ];

                table.append(detailRow);
                // detailCells.forEach((cell,index) => detailRow.append($(
                //         `<td class='row-data${indexHeader}' style="width: 250px; min-width: 200px;">`)
                //     .append(
                //         cell)));
                detailCells.forEach((cell, index) => {

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
                        minWidthStyle = 'min-width: 130px;';
                    } else if (index === 3) {
                        widthStyle = 'width: 100px;';
                        minWidthStyle = 'min-width: 150px;';
                    } else if (index === 4) {
                        widthStyle = 'width: 45px;';
                        minWidthStyle = 'min-width: 200px;';
                    } else if (index === 5) {
                        widthStyle = 'width: 45px;';
                        minWidthStyle = 'min-width: 200px;';
                    }



                    detailRow.append(
                        $(
                            `<td class='row-data${indexHeader}' style="${widthStyle} ${minWidthStyle}">`
                        )
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


                // detail
                $.each(entry.details, function(index, details) {


                    idDetailsLookup = `${indexHeader}-${index}`
                    const productRow = $(`<tr class="detail-row data-detail" id="${idDetailsLookup}">`);
                    productRow.append($("<td class='row-number'>").text(index + 1));
                    const productCells = [
                        createInputLookup("productnama", details.productnama, 'productid',
                            idDetailsLookup, 'producteditall', details.productid, details.id,
                            details
                            .penjualanid, 'id'),
                        createInputLookup("satuannama", details.satuannama, 'satuanid',
                            idDetailsLookup,
                            'satuaneditall', details.satuanid),
                        `<input type="hidden" name="pesananfinaldetailid[]" class="form-control lg-form filled-row autonumeric autonumeric-zero pesananfinaldetailid " autocomplete="off" value="${details.pesananfinaldetailid || 0}"> 
                            <input type="hidden" name="qtystok[]" class="form-control filled-row">
                            <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="${details.qty}" > 
                            <input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="${details.qty}" >`,
                        `<input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="${details.qtyreturjual}" >`,
                        `<input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="${details.qtyreturbeli}" >`,
                        createInputDetail("keterangandetail", details.keterangandetail),
                        ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" value="${details.harga}" >`,
                        ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="${details.totalharga}">`,
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
                        } else if (index === 7) {
                            widthStyle = 'width: 100px;';
                            minWidthStyle = 'min-width: 200px;';
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
                            $cell.attr('id', qty);
                            $cell.addClass('qty');
                        } else if ($cell.find('[name="qtyreturjual[]"]').length > 0) {
                            const qtyreturjual = `qtyreturjual${idDetailsLookup}`;
                            $cell.attr('id', qtyreturjual);
                            $cell.addClass('qtyreturjual');
                        } else if ($cell.find('[name="qtyreturbeli[]"]').length > 0) {
                            const qtyreturbeli = `qtyreturbeli${idDetailsLookup}`;
                            $cell.attr('id', qtyreturbeli);
                            $cell.addClass('qtyreturbeli');
                        }


                        productRow.append($cell);

                        if (entry.nominalbayar > 0) {
                            // Disable all input elements in detailRow
                            productRow.find('[name="harga[]"]').prop('disabled', true)
                            productRow.find('input').prop('disabled', true)


                        }

                        if (details.qtyreturjual !== 0) {
                            productRow.find(`.delete-roweditall`).attr('disabled', true)
                        }

                        if (details.qtyreturbeli !== 0) {
                            productRow.find(`.delete-roweditall`).attr('disabled', true)
                        }

                        if (entry.nobuktipesananfinal != null || entry.pesananfinalid > 0) {
                            // productRow.find(`.delete-roweditall`).attr('disabled', true)
                        }

                    });
                    table.append(productRow);


                    totalPrice += details.harga;



                });

                // Display total price row
                const addRow = $("<tr class='addRow'>");
                addRow.append($('<td colspan="9">'));
                // addRow.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                addRow.append(
                    $(
                        `<td class="subtotal"><button type="button" class="btn btn-primary btn-sm my-2 add-detail-row" id="addRow" idheader="${entry.id}" data-index="${indexHeader}">TAMBAH</button></td>`
                    )
                );

                table.append(addRow);

                // Display total price row
                const totalRow = $("<tr class='totalan'>");
                totalRow.append($('<td colspan="7">'));
                totalRow.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                totalRow.append($(
                    `<td class="subtotal"><input type="text" name="subtotal[]" class="form-control bg-white state-delete lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}" readonly></td>`
                ));

                table.append(totalRow);

                // Add additional row below the total row
                const taxRow = $("<tr class='tax'>");

                taxRow.append($('<td colspan="7">'));
                taxRow.append($('<td colspan="1" class="totalan">tax:</td>'));
                taxRow.append(`
                    <td class="tax">
                        <div class="row">
                            <div class="col-md-5">
                              <div class="input-group">
                                <input type="text" name="tax[]" class="form-control lg-form filled-row autonumeric" style="width:50%; float:right;" autocomplete="off" value="${entry.tax}">
                                <div class="input-group-append">
                                  <span class="input-group-text">% </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-7 mt-3 mt-md-0 taxamount">
                                <input type="text" name="taxamount[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${entry.taxamount}">
                            </div>
                          </div>
                       
                    </td>
                    `);

                table.append(taxRow);

                const discRow = $("<tr class='discount'>");
                discRow.append($('<td colspan="7">'));
                discRow.append($('<td colspan="1" class="totalan">Discount:</td>'));

                discRow.append($(
                    `<td class="discount"><input type="text" name="discount[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.discount}"></td>`
                ));

                table.append(discRow);

                const totalFinalRow = $("<tr class='total'>");
                totalFinalRow.append($('<td colspan="7">'));
                totalFinalRow.append($('<td colspan="1" class="totalan">Total:</td>'));

                totalFinalRow.append($(
                    `<td class="total"><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${entry.total}" ></td>`
                ));

                table.append(totalFinalRow);


                // Append the table to the container
                tableContainer.append(table);

                // Append the container to the body
                $("#editAllTableBody").append(tableContainer);

                $.each(entry.details, function(index, details) {

                    let idDetailsLookup = `${indexHeader}-${index}`

                    initLookupDetailEditAll(idDetailsLookup, table, details)

                });

                // $('table').on('input', 'input[name="harga[]"]', function() {
                //     let value = $(this).val();

                //     let currentProductName = $(this).parents('tr').find(
                //         'td [name="productnama[]"]').val();
                //     let currentHarga = $(this).parents('tr').find('td [name="harga[]"]');
                //     let currentIdProduct = $(this).parents('tr').find('td [name="productid[]"]').val();


                //     // Iterate over each input field with name "harga[]"
                //     $('table').find('input[name="harga[]"]').each(function() {
                //         if (!$(this).is(':disabled')) {
                //             let trHarga = $(this).parents('tr');
                //             let productNameInRow = $(this).parents('tr').find(
                //                 'td [name="productnama[]"]').val();

                //             if (productNameInRow == currentProductName && this !== currentHarga[
                //                     0]) {
                //                 $(this).remove();

                //                 let newHargaEl =
                //                     `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${value}">`;

                //                 trHarga.find('td.harga').append(newHargaEl);

                //                 // console.log(trHarga.find(`tr#0`));
                //                 setTotalHargaEditAll(trHarga)
                //                 setSubTotalEditAll(table)
                //                 setTaxEditAll(table)
                //                 setTotalEditAll(table)
                //                 initAutoNumericNoDoubleZero(trHarga.find('td [name="harga[]"]'))

                //             }
                //         }


                //     });



                // });


                table.on('input', 'input[name="qty[]"]', function() {
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    parentEl = $(this).closest(`table`)

                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        let idDetailsLookup = `${indexHeader}-${index}`
                        childEl = $(data).attr('id');
                        elementQty = parentEl.find(`tr#${childEl}`)

                        setTotalHargaEditAll(elementQty)
                        // checkQtyStokEdit(elementQty)
                    })
                    setSubTotalEditAll(parentEl)
                    setTaxEditAll(parentEl)
                    setTotalEditAll(parentEl)
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

                table.on('input', 'input[name="qtyreturjual[]"]', function() {
                    // console.log('qtyreturjual',);
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    // let detailRowEl = parentEl.find('.detail-row');
                    parentEl = $(this).closest(`table`)


                    $.each(parentEl.find('.detail-row'), function(index, value) {
                        childEl = $(value).attr('id');

                        elementQty = parentEl.find(`tr#${childEl}`)
                        // console.log(index);
                        checkJumlahQtyreturEditAll(elementQty, entry.id, data)

                        // setQtysEditAll(elementQty)
                        // setTotalHargaEditAll(elementQty)

                    })
                    zeroQtyReturEditAll($(this))
                    setQtyReturBeli($(this))
                    setSubTotalEditAll(parentEl)
                    setTaxEditAll(parentEl)
                    setTotalEditAll(parentEl)
                })

                table.on('input', 'input[name="qtyreturbeli[]"]', function() {

                    zeroQtyReturBeliEditAll($(this))

                })


                table.on('input', 'input[name="harga[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)

                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        let idDetailsLookup = `${indexHeader}-${index}`
                        childEl = parentEl.find(`tr#${idDetailsLookup}`)
                        setTotalHargaEditAll(childEl)
                    })
                    setSubTotalEditAll(parentEl)
                    setTaxEditAll(parentEl)
                    setTotalEditAll(parentEl)
                })

                if (entry.pesananfinalid > 0) {
                    detailRow.find(`[name="customernama[]"]`).prop('disabled', true).addClass(
                        'bg-white state-delete');
                }

                if (entry.nominalbayar > 0) {
                    detailRow.find(`[name="nobukti[]"]`).prop('disabled', true);
                    detailRow.find(`[name="tglbuktieditall[]"]`).prop('disabled', true);
                    detailRow.find('input').prop('disabled', true)
                    table.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRow.find('input').prop('disabled', true)
                    taxRow.find('input').prop('disabled', true)
                    discRow.find('input').prop('disabled', true)
                    totalFinalRow.find('input').prop('disabled', true)
                    table.find(`[name="taxamount[]"]`).prop('disabled', true);
                    detailRow.find('input').removeClass("bg-white state-delete")
                    totalRow.find('input').removeClass("bg-white state-delete")
                } else {
                    table.find(`[name="totalharga[]"]`).prop('readonly', true).addClass(
                        'bg-white state-delete');
                    detailRow.find(`[name="nobukti[]"]`).prop('readonly', true).addClass(
                        'bg-white state-delete');
                    detailRow.find(`[name="tglbuktieditall[]"]`).prop('readonly', true).addClass(
                        'bg-white state-delete');
                    table.find(`[name="taxamount[]"]`).prop('readonly', true).addClass('bg-white state-delete');
                    table.find(`[name="total[]"]`).prop('readonly', true).addClass('bg-white state-delete');
                    // detailRow.find(`[name="tglbuktieditall[]"]`).prop('readonly', true).addClass('bg-white state-delete');
                }

                if (entry.nobuktipesananfinal != null || entry.pesananfinalid > 0) {
                    addRow.find(`#addRow`).attr('disabled', true)

                    // addRow.find(`.delete-roweditall`).attr('disabled', true)
                }


                initLookupHeader(indexHeader, table, entry)
                initAutoNumericNoDoubleZero(table.find(`[name="harga[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="totalharga[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="subtotal[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="discount[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="total[]"]`))
                initAutoNumericNoDoubleZero(table.find(`[name="taxamount[]"]`))
                initAutoNumeric(table.find(`[name="qty[]"]`))
                initAutoNumeric(table.find(`[name="qtyreturjual[]"]`))
                initAutoNumeric(table.find(`[name="qtyreturbeli[]"]`))

                // console.log(indexHeader);


            });
            // console.log(addRow.find('.add-detail-row'));
        }



    }

    // function addRowDetail(idDetailsLookup){
    // console.log(idDetailsLookup);

    // }
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
        setTaxEditAll(parentTable)
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
            `<input type="hidden" name="idheader[]" class="form-control filled-row" value="${idheader}">
                    <input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="0">
                    <input type="hidden" name="productid[]" class="form-control hidden-2 filled-row">
                    <input type="text" name="productnama[]" id="productnama" class="form-control filled-row lg-form producteditall-lookup${indexAddRowCurrent}" autocomplete="off">`,
            `<input type="hidden" name="satuanid[]" class="form-control filled-row">
                    <input type="text" name="satuannama[]" id="satuannama" class="form-control filled-row lg-form satuaneditall-lookup${indexAddRowCurrent}" autocomplete="off">`,
            `<input type="hidden" name="pesananfinaldetailid[]" class="form-control lg-form filled-row autonumeric autonumeric-zero pesananfinaldetailid " autocomplete="off" value="0"> 
                    <input type="text" name="qty[]" class="form-control lg-form addrow-qty filled-row autonumeric qty autonumeric-zero " autocomplete="off" > 
                    <input type="hidden" name="qtystok[]" class="form-control addrow-qtystok filled-row" value="0">
                    <input type="hidden" name="originalqty[]" class="form-control addrow-qtyoriginal lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" >`,
            `<input type="text" name="qtyreturjual[]" class="form-control addrow-qtyreturjual lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            `<input type="text" name="qtyreturbeli[]" class="form-control addrow-qtyreturbeli lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
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
            } else if (index === 7) {
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
            } else if ($cell.find('[name="qtyreturjual[]"]').length > 0) {
                const qtyreturjual = `qtyreturjual${indexAddRowCurrent}`;
                $cell.attr('id', qtyreturjual);
                $cell.addClass('qtyreturjual');
            } else if ($cell.find('[name="qtyreturbeli[]"]').length > 0) {
                const qtyreturbeli = `qtyreturbeli${indexAddRowCurrent}`;
                $cell.attr('id', qtyreturbeli);
                $cell.addClass('qtyreturbeli');
            }

            newRow.append($cell);
        });

        addRow.before(newRow);

        newRow.find(`.addrow-qty`).remove();
        newRow.find(`.addrow-harga`).remove();
        newRow.find(`.addrow-qtyoriginal`).remove();
        newRow.find(`.addrow-qtyreturjual`).remove();
        newRow.find(`.addrow-qtyreturbeli`).remove();
        newRow.find(`.addrow-totalharga`).remove();
        newRow.find(`.addrow-qtystok`).remove();

        let newqty =
            `<input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"><input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"> `

        let newharga =
            `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" value="0" >`

        let newqtyreturjual =
            `<input type="text" name="qtyreturjual[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtyreturbeli =
            `<input type="text" name="qtyreturbeli[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtyoriginal =
            `<input type="text" name="qtyoriginal[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtytotalharga =
            `<input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`


        newRow.find(`#qty${indexAddRowCurrent}`).append(newqty);
        newRow.find(`#harga${indexAddRowCurrent}`).append(newharga);
        newRow.find(`#qtyreturjual${indexAddRowCurrent}`).append(newqtyreturjual);
        newRow.find(`#qtyreturbeli${indexAddRowCurrent}`).append(newqtyreturbeli);
        newRow.find(`#totalharga${indexAddRowCurrent}`).append(newqtytotalharga);

        initAutoNumeric(newRow.find(`[name="qty[]"]`))
        initAutoNumeric(newRow.find(`[name="qtyreturjual[]"]`))
        initAutoNumeric(newRow.find(`[name="qtyreturbeli[]"]`))
        initAutoNumericNoDoubleZero(newRow.find(`[name="harga[]"]`))
        initLookupDetailEditAll(indexAddRowCurrent, element.closest('table'))

        buttonCLearAll = element.closest('table').find('tr.detail-row .delete-roweditall')

        if (buttonCLearAll.is(':disabled')) {
            buttonCLearAll.prop('disabled', false)
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

    function createInputLookup(name, value, id, selectIndex, initLookup, statusid, valueid2, idheader, id2 = '') {
        if (id2 != '') {

            return $(
                ` <input type="hidden" name="idheader[]" class="form-control filled-row" value="${idheader}" >
                <input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="${valueid2}" >
                <input type="hidden" name="${id}[]" class="form-control hidden-2 filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        } else {
            return $(
                `<input type="hidden" name="${id}[]" class="form-control filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        }

    }

    function setQtyStokEditAll(productid, element) {
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
                initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))
                if (response.data == 0) {
                    showDialog('produk ini tidak bisa dijual karena tidak ada stok')

                    let idHarga = $(element.closest('tr')).attr('id')

                    // console.log(idHarga);
                    $(element.closest('tr').find(`input[name="harga[]"]`)).remove()
                    $(element.closest('tr').find(`input[name="totalharga[]"]`)).remove()

                    let newHargaEl =
                        `<input type="text" name="harga[]" class="form-control autonumeric" value="0">`

                    let newTotalHargaEl =
                        `<input type="text" name="totalharga[]" class="form-control autonumeric bg-white state-delete" value="0" readonly>`

                    element.parents('tr').find(`#harga${idHarga}`).append(newHargaEl);
                    element.parents('tr').find(`#totalharga${idHarga}`).append(newTotalHargaEl);

                    $(element.closest('tr').find(`input[name="productid[]"]`)).val("")
                    $(element.closest('tr').find(`input[name="productnama[]"]`)).val("")
                    $(element.closest('tr').find(`input[name="harga[]"]`)).val("")
                    $(element.closest('tr').find(`input[name="totalharga[]"]`)).val("")
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

    function checkQtyStokEdit(element) {

        let productId = $(element.closest('tr').find(`input[name="productid[]"]`)).val()

        $.ajax({
            url: `${apiUrl}pembelianheader/cekstokproduct`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                productid: productId,
                edit: true
            },
            success: response => {
                initAutoNumeric($(element.closest('tr').find(`input[name="qtystok[]"]`)).val(response.data))

                let qtyStokVal = parseFloat($(element.closest('tr').find(`input[name="qtystok[]"]`)).val()
                    .replace(/,/g, ''))
                let qtyVal = parseFloat($(element.closest('tr').find(`input[name="qty[]"]`)).val().replace(
                    /,/g, ''))
                let originalqty = parseFloat($(element.closest('tr').find(`input[name="originalqty[]"]`))
                    .val().replace(/,/g, ''))

                console.log(qtyVal);

                if (qtyVal > qtyStokVal) {
                    showDialog(`Stok tidak mencukupi. Stok saat ini adalah ${qtyStokVal}.`);

                    let ids = $(element.closest('tr')).attr('id')

                    elementSecond = $(element.closest('tr').find(`input[name="harga[]"]`))

                    $(element.closest('tr').find(`input[name="qty[]"]`)).remove()

                    let qtyStokInput = elementSecond.parents('tr').find('input[name="qtystok[]"]');


                    let newQtyEl =
                        `<input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " value="${originalqty}">`
                    // elementSecond.parents('tr').find(`#qty${ids}`).append(newQtyEl)
                    qtyStokInput.after(newQtyEl);

                    initAutoNumeric($(elementSecond.closest('tr').find(`input[name="qty[]"]`)))

                    tableEl = element.closest('table');

                    setTotalHargaEditAll(element)
                    setSubTotalEditAll(tableEl)
                    setTaxEditAll(tableEl)
                    setTotalEditAll(tableEl)
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





    function initLookupHeader(index, detailRowEditAll, detail, tableEL) {
        let rowLookup = index;

        $(`.statuseditall-lookup${rowLookup}`).lookup({
            title: 'status Lookup',
            fileName: 'parameter',
            detail: true,
            miniSize: true,
            searching: 1,
            alignRight: true,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS',
                    subgrp: 'STATUS',
                    searching: 1,
                    valueName: `status_${index}`,
                    id: `status_${rowLookup}`,
                    searchText: `statuseditall-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Status',
                    customerid: $('#editAll').find('[name=status]').val()
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (status, element) => {

                let status_id_input = element.parents('td').find(`[name="status[]"]`);


                element.parents('tr').find('td [name="status[]"]').val(status.id)
                element.parents('tr').find('td [name="statusnama[]"]').val(status.text)


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

                element.data('currentValue', element.val());
            },
        });

        $(`.customereditall-lookup${rowLookup}`).lookup({
            title: 'customer Lookup',
            fileName: 'customer',
            detail: true,
            miniSize: true,
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    searching: 1,
                    valueName: `customer_${index}`,
                    id: `customer_${rowLookup}`,
                    searchText: `customereditall-lookup${rowLookup}`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'customer',
                    customerid: $('#editAll').find('[name=customer]').val()
                    // typeSearch: 'ALL',
                };
            },
            onSelectRow: (customer, element) => {

                let customer_id_input = element.parents('td').find(`[name="customer[]"]`);
                element.parents('tr').find('td [name="customerid[]"]').val(customer.id)
                element.parents('tr').find('td [name="customernama[]"]').val(customer.nama)

                element.parents('tr').find('td [name="alamatpengiriman[]"]').val(customer.alamat)



                element.data('currentValue', element.val());
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
                element.parents('tr').find('td [name="satuanid[]"]').val(product.satuanid)
                element.parents('tr').find('td [name="satuannama[]"]').val(product.satuannama)


                element.data('currentValue', element.val());

                element.parents('tr').find(`td [name="harga[]"]`).remove();
                element.parents('tr').find(`td [name="totalharga[]"]`).remove();


                let newHargaEl =
                    `<input type="text" name="harga[]" class="form-control autonumeric" value="${product.hargajual}">`


                let newTotalHargaEl =
                    `<input type="text" name="totalharga[]" class="form-control autonumeric bg-white state-delete" value="0" readonly>`

                element.parents('tr').find(`#harga${rowLookupDetail}`).append(newHargaEl)
                element.parents('tr').find(`#totalharga${rowLookupDetail}`).append(newTotalHargaEl)

                $.each(parentTable.find('.detail-row'), function(index, data) {
                    childEl = $(data).attr('id');
                    detailPerRow = detailRowEditAll.find(`tr#${childEl}`)


                    setTotalHargaEditAll(detailPerRow)
                })
                setQtyStokEditAll(product.id, element)
                initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
                setSubTotalEditAll(parentTable)
                setTaxEditAll(parentTable)
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

    function approveKacabEditAll(date) {
        $('#approveKacabEditAll').modal('show')
        $('#formApproveKacabEditAll').find('[name=date]').val(date)
    }

    $(document).on('click', `#approvalKacabEditAll`, function(event) {
        event.preventDefault()

        let data = [];
        data.push({
            name: 'date',
            value: $('#formApproveKacabEditAll').find('[name=date]').val()
        })
        data.push({
            name: 'username',
            value: $('#formApproveKacabEditAll').find('[name=username]').val()
        })
        data.push({
            name: 'password',
            value: $('#formApproveKacabEditAll').find('[name=password]').val()
        })
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}penjualanheader/approvalkacabeditall`,
            method: 'POST',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {
                if (response.status) {
                    $('#formApproveKacabEditAll').trigger("reset");
                    $("#approveKacabEditAll").modal('hide');
                    // if (!isAllowedForceEdit) {
                    editAllPenjualan()
                    // }
                } else {
                    showDialog('TIDAK ADA HAK AKSES')
                }
            },
            error: error => {
                if (error.status === 422) {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()

                    setErrorMessages($('#formApproveKacabEditAll'), error.responseJSON.errors);
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