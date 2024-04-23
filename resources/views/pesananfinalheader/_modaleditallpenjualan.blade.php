<div class="modal modal-fullscreen" id="editAllModalPenjualan" tabindex="-1" aria-labelledby="crudModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllFormPenjualan">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllModalPenjualanTitle"></p>
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
                                <input type="text" name="tglpengirimanjual" id="tglpengirimanjual"
                                    class="form-control lg-form datepicker filled-row">
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="editAllPenjualan">
                        <thead>
                            <!-- Add your table header here if needed -->
                        </thead>
                        <tbody id="editAllTableBodyPenjualan"></tbody>
                    </table>
                    <div class=" bg-white editAllPager overflow-x-hidden mt-3">
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmitEditAllPenjualan" class="btn btn-primary">
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
        let modalBodyEditAllPenjualan = $('#editAllModalPenjualan').find('.modal-body').html()
        let dataEditAllPenjualan = {}

        let jumlahMasterPenjualan = 0;



        $(document).ready(function() {
            $(document).on('change', `#editAllFormPenjualan [id="tglpengirimanjual"]`, function() {
                getAllPenjualan(1, 10)
            });

            $(document).on('click', '.btn-batal', function(event) {
                event.preventDefault()
                if ($('#editAllForm').data('action') == 'edit') {
                    $.ajax({
                        url: `{{ config('app.api_url') }}pesananfinalheader/editingat`,
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
                            $("#editAllModalPenjualan").modal("hide")
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
                    $("#editAllModalPenjualan").modal("hide")
                }
            })

            $('#btnSubmitEditAllPenjualan').click(function(event) {
                event.preventDefault()


                let method
                let url
                let form = $('#editAllFormPenjualan')
                let action = form.data('action')
                let detailsDataAll = [];


                for (let i = 0; i < jumlahMasterPenjualan; i++) {
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

                            if (inputDetail.hasClass('idheader')) {
                                let idHeaderInput = $(rowDetail).find('input.idheader').prop('name')
                                let valueIdDetail = $(rowDetail).find('input.idheader').val();

                                if (!detailsDataAll[i]['details'][idHeaderInput]) {
                                    detailsDataAll[i]['details'][idHeaderInput] = [];
                                }

                                detailsDataAll[i]['details'][idHeaderInput].push(valueIdDetail);
                            }

                            // console.log(inputDetail);
                            if (inputDetail.hasClass('id-detail')) {
                                let idInput = $(rowDetail).find('input.id-detail').prop('name')
                                let valueId = $(rowDetail).find('input.id-detail').val();

                                if (!detailsDataAll[i]['details'][idInput]) {
                                    detailsDataAll[i]['details'][idInput] = [];
                                }

                                detailsDataAll[i]['details'][idInput].push(valueId);
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
                    url: `${apiUrl}pesananfinalheader/processeditallpenjualan`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        data: JSON.stringify(detailsDataAll)
                    },
                    success: response => {
                        var tglPengiriman = $('#editAllFormPenjualan').find(
                            '[name=tglpengirimanjual]').val()
                        $('#editAllFormPenjualan').trigger('reset')
                        $('#editAllModalPenjualan').modal('hide')




                        // showDialogEditAll(tglPengiriman)

                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,
                        }).trigger('reloadGrid');

                        dataEditAllPenjualan = {}
                    },
                    error: error => {
                        
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            $.each(error.responseJSON.errors, (index, error) => {
                            let indexes = index.split("."); 
                            let element;

                            if (indexes.length > 1) {
                                element = $('#editAllFormPenjualan').find(`.header${indexes[0]} [name="${indexes[2]}"]`)[indexes[3]];
                                
                            } else {
                                element = $('#editAllFormPenjualan').find(`.header${indexes[0]} [name="${indexes[2]}"]`)[0];
                            }

                            if ($(element).length > 0 && !$(element).is(":hidden")) {
                                $(element).addClass("is-invalid");
                                $(`
                            <div class="invalid-feedback">
                            ${error[0].toLowerCase()}
                            </div>
                        `).appendTo($(element).parent());
                            } else {
                                return showDialog(error);
                            }
                        });

                        $(".is-invalid").first().focus();
                            // setErrorMessagesEditAll(form, error.responseJSON.errors);
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

        function setTotalHargaEditAllPenjualan(element, id = 0) {
            let hargasatuan = parseFloat(element.find(`[name="harga[]"]`).val().replace(/,/g, ''));
            let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
            let amount = qty * hargasatuan;
            initAutoNumericNoDoubleZero(element.find(`[name="totalharga[]"]`).val(amount))
        }

        function setSubTotalEditAllPenjualan(element) {
            let nominalDetails = element.find(`[name="totalharga[]"]`);
            // console.log(nominalDetails);
            let total = 0
            $.each(nominalDetails, (index, nominalDetail) => {

                total += AutoNumeric.getNumber(nominalDetail)
                // total += parseFloat(nominalDetails.val().replace(/,/g, ''));
            });
            initAutoNumericNoDoubleZero(element.find(`[name="subtotal[]"]`).val(total))
        }


        function setTotalEditAllPenjualan(element) {
            let grandtotal;


            let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''));
            let disc = parseFloat(element.find(`[name="discount[]"]`).val().replace(/,/g, ''));
            let taxamount = parseFloat(element.find(`[name="taxamount[]"]`).val().replace(/,/g, ''));



            grandtotal = (total + taxamount) - disc


            initAutoNumericNoDoubleZero(element.find(`[name="total[]"]`).val(grandtotal))
        }

        function setTaxEditAllPenjualan(element) {
            let result;
            let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''))


            let taxlabel = parseFloat(element.find(`[name="tax[]"]`).val().replace(/,/g, ''))

            result = (taxlabel / 100) * total;


            initAutoNumericNoDoubleZero(element.find(`[name="taxamount[]"]`).val(result))
        }

        $('#editAllModalPenjualan').on('shown.bs.modal', () => {
            var editAllModalPenjualan = $('#editAllModalPenjualan')
            let form = $('#editAllPenjualan')
            setFormBindKeys(form)
            activeGrid = null

            initSelect2($(`[name="statusaktif"]`), true)

            form.find('#btnSubmit').prop('disabled', false)
            if (form.data('action') == "view") {
                form.find('#btnSubmit').prop('disabled', true)
            }

            getMaxLength(form)
            initDatepicker()

        });
        $('#editAllModalPenjualan').on('hidden.bs.modal', () => {
            activeGrid = '#jqGrid'
            $('#editAllModalPenjualan').find('.modal-body').html(modalBodyEditAllPenjualan)
            $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
            jumlahMasterPenjualan = 0
            initDatepicker('datepickerIndex')
        })

        function editAllPenjualan() {
            let totalRows
            let lastPage
            let form = $('#editAllModalPenjualan')
            $('.modal-loader').removeClass('d-none')
            form.trigger('reset')
            form.find('#btnSubmitEditAllPenjualan').html(`<i class="fa fa-save"></i>Simpan`)
            form.data('action', 'editall')
            form.find(`.sometimes`).hide()
            $('#editAllModalPenjualanTitle').text('Edit All pesanan customer')
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            var besok = new Date();
            besok.setDate(besok.getDate());
            $('#editAllFormPenjualan').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok))
                .trigger(
                    'change');

            Promise
                .all([
                    getAllPenjualan(1, 10),
                ])
                .then((attributes) => {
                    totalRowsEditAll = attributes[0].totalRows
                    totalPages = attributes[0].totalPages
                    itemsPerPage = 10

                    $('#editAllModalPenjualan').modal('show')
                    lastPageEditAll = Math.ceil(totalRowsEditAll / itemsPerPage);

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

        function getAllPenjualan(page, limit = 10, filters = []) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}pesananfinalheader/getallpenjualan`,
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        page: page,
                        limit: limit,
                        sortIndex: 'nobukti',
                        sortOrder: 'desc',
                        tglpengirimanjual: $('#editAllFormPenjualan').find('[id=tglpengirimanjual]').val()
                    },
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        $('#editAllPenjualan tbody').html('')
                        // console.log(response)

                        data = response.data

                        detailHeader = ["No", "Customer", "No Bukti", "tgl bukti",
                            "alamat pengiriman", "tgl pengiriman", "keterangan"
                        ]

                        subHeader = ["No", "product", "satuan", "Qty", "Qty Retur", "keterangan",
                            "Harga", "total Harga", "Aksi"
                        ]

                        // initValue(data)
                        createTablePenjualan(data, detailHeader, subHeader);

                        currentPage = page
                        totalPages = response.attributes.totalPages
                        totalRowsEditAll = response.attributes.totalRows

                        initDatepicker()
                        resolve(response.attributes)
                    },
                    error: error => {

                        reject(error)
                    },
                })
            })




        }

        let tableContainerPenjualan = $('<div class="table-container mb-4">');
        let tablePenjualan = $("<table>");

        function createTablePenjualan(data, detailHeader, subHeader) {
            $("#editAllTableBodyPenjualan").empty();
            tbody = $('#editAllTableBodyPenjualan')
            if (data.length === 0) {
                // If there is no data, display a styled message
                const noDataRow = $('<tr><td colspan="8" class="text-center">No data available</td></tr>');
                tbody.append(noDataRow);
            } else {

                // master
                jumlahMasterPenjualan = data.length
                $.each(data, function(indexHeader, entry) {


                    // Create a container div for each table
                    tableContainerPenjualan = $('<div class="table-container mb-5">');
                    tablePenjualan = $(`<table class="header${indexHeader}" id=${entry.id}edit>`);

                    // Detail Header
                    const detailHeaderRow = $('<tr class="header-row">');
                    const detailHeaderCells = detailHeader
                    detailHeaderCells.forEach((cellText) => {
                        detailHeaderRow.append($("<th>").text(cellText));
                    });
                    tablePenjualan.append(detailHeaderRow);

                    // Detail Row
                    const detailRow = $("<tr class='data-header'>");
                    detailRow.append($("<td>").text(indexHeader + 1));

                    const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                    const tglpengiriman = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglpengiriman));


                    const detailCellsPenjualan = [
                        createInputLookupPenjualan("customernama", entry.customernama, 'customerid',
                            indexHeader,
                            'customereditall', entry.customerid),
                        `<input type="text" name="nobukti[]" class="form-control lg-form filled-row " autocomplete="off" value="${entry.nobukti}" />`,
                        `<input type="hidden" name="id[]" class="form-control id-detail filled-row" value="${entry.id}" >
                        <input type="hidden" name="pesananfinalid[]" class="form-control pesananfinalid filled-row" value="${entry.pesananfinalid}" >
                        <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglbukti}" ></div>`,
                        createInputPenjualan("alamatpengiriman", entry.alamatpengiriman),
                        `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglpengirimaneditall[]" id="tglpengiriman${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglpengiriman}"></div>`,
                        createInputPenjualan("keterangan", entry.keterangan),

                    ];

                    tablePenjualan.append(detailRow);
                    // detailCellsPenjualan.forEach((cell) => detailRow.append($(
                    //         `<td class='row-data${indexHeader}' style="width: 250px; min-width: 200px;">`)
                    //     .append(
                    //         cell)));
                    detailCellsPenjualan.forEach((cell, index) => {

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

                    tablePenjualan.append(detailRow);

                    // Sub Header
                    const subHeaderRowPenjualan = $('<tr class="sub-header-row">');
                    const subHeaderCellsPenjualan = subHeader
                    subHeaderCellsPenjualan.forEach((cellText) => {
                        subHeaderRowPenjualan.append($("<th>").text(cellText));
                    });
                    tablePenjualan.append(subHeaderRowPenjualan);

                    let totalPricePenjualan = 0;
                    // detail
                    $.each(entry.details, function(index, details) {
                        idDetailsLookupPenjualan = `${indexHeader}-${index}`
                        const productRowPenjualan = $(
                            `<tr class="detail-row data-detail" id="${idDetailsLookupPenjualan}">`);
                        productRowPenjualan.append($("<td class='row-number'>").text(index + 1));
                        const productCellsPenjualan = [

                            createInputLookupPenjualan("productnama", details.productnama, 'productid',
                                idDetailsLookupPenjualan, 'producteditall', details.productid, details
                                .pesananfinaldetailid || 0, details.id, 'id'),
                            createInputLookupPenjualan("satuannama", details.satuannama, 'satuanid',
                                idDetailsLookupPenjualan,
                                'satuaneditall', details.satuanid),
                            ` <input type="hidden" name="idheader[]" class="form-control idheader filled-row" value="${entry.pesananfinalid}" >
                            <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                            ` <input type="text" name="qtyretur[]" class="form-control bg-white state-delete lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" readonly>`,
                            createInputDetailPenjualan("keterangandetail", details.keterangandetail),
                            ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                            ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.totalharga ? details.totalharga : details.totalhargajual}" >`,
                            `<button type="button" class="btn btn-danger btn-sm delete-roweditall">Delete</button>`,
                        ];

                        productCellsPenjualan.forEach((cell, index) => {
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

                            const $cell = $(`<td style='${widthStyle} ${minWidthStyle}'>`).append(
                                cell);
                            if ($cell.find('[name="harga[]"]').length > 0) {
                                const hargaTdId = `harga${idDetailsLookupPenjualan}`;
                                $cell.attr('id', hargaTdId);
                                $cell.addClass('harga');
                            } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                                const totalhargaTdId = `totalharga${idDetailsLookupPenjualan}`;
                                $cell.attr('id', totalhargaTdId);
                            }

                            productRowPenjualan.append($cell);

                            if (entry.nominalbayar > 0) {
                                productRowPenjualan.find('input').prop('disabled', true)
                            }

                            if (details.nobuktipembelian !== null && details.nobuktipembelian !==
                                undefined && details.nobuktipembelian !== "") {
                                detailRow.find('input').prop('disabled', true)
                                productRowPenjualan.find('input').prop('disabled', true)
                                detailRow.find('input').prop('disabled', true)
                                tablePenjualan.find('.ui-datepicker-trigger').attr('disabled',
                                    true);
                                tablePenjualan.find('[name="totalharga[]"]').prop('disabled', true)
                                // taxRowPenjualan.find('input').prop('disabled', true)
                                // discRowPenjualan.find('input').prop('disabled', true)
                                // totalFinalRowPenjualan.find('input').prop('disabled', true)
                            }

                            if (entry.nobuktipesananheader) {
                                detailRow.find('[name="customernama[]"]').prop('readonly', true)
                                    .addClass(
                                        'bg-white state-delete')
                                detailRow.find('[name="alamatpengiriman[]"]').prop('readonly', true)
                                    .addClass(
                                        'bg-white state-delete')
                                detailRow.find('[name="tglpengirimaneditall[]"]').prop('readonly',
                                    true).addClass(
                                    'bg-white state-delete')
                            }



                        });
                        tablePenjualan.append(productRowPenjualan);



                        totalPricePenjualan += details.harga;
                    });

                    const addRowPenjualan = $("<tr class='addRowPenjualan'>");
                    addRowPenjualan.append($('<td colspan="8">'));


                    addRowPenjualan.append(
                        $(
                            `<td class="subtotal"><button type="button" class="btn btn-primary btn-sm my-2 add-detailpenjualan-row" id="addRowPenjualan" idheader="${entry.pesananfinalid}" data-index="${indexHeader}">TAMBAH</button></td>`
                        )
                    );

                    tablePenjualan.append(addRowPenjualan);


                    // Display total price row
                    const totalRowPenjualan = $("<tr class='totalan'>");
                    totalRowPenjualan.append($('<td colspan="6">'));
                    totalRowPenjualan.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                    totalRowPenjualan.append($(
                        `<td><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${entry.subtotal}"></td>`
                    ));

                    tablePenjualan.append(totalRowPenjualan);

                    // Add additional row below the total row
                    const taxRowPenjualan = $("<tr class='tax'>");
                    taxRowPenjualan.append($('<td colspan="6">'));
                    taxRowPenjualan.append($('<td colspan="1" class="totalan">tax:</td>'));
                    taxRowPenjualan.append(`
                    <td>
                        <div class="row">
                            <div class="col-md-5">
                              <div class="input-group">
                                <input type="text" name="tax[]" class="form-control lg-form filled-row autonumeric e" style="width:50%; float:right;" autocomplete="off" value="${entry.tax}">
                                <div class="input-group-append">
                                  <span class="input-group-text">% </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-7 mt-3 mt-md-0 taxamount">
                                <input type="text" name="taxamount[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.taxamount}" >
                            </div>
                          </div>
                       
                    </td>
                `);

                    tablePenjualan.append(taxRowPenjualan);

                    const discRowPenjualan = $("<tr class='discount'>");
                    discRowPenjualan.append($('<td colspan="6">'));
                    discRowPenjualan.append($('<td colspan="1" class="totalan">Discount:</td>'));

                    discRowPenjualan.append($(
                        `<td><input type="text" name="discount[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.discount}"></td>`
                    ));

                    tablePenjualan.append(discRowPenjualan);

                    const totalFinalRowPenjualan = $("<tr class='total'>");
                    totalFinalRowPenjualan.append($('<td colspan="6">'));
                    totalFinalRowPenjualan.append($('<td colspan="1" class="totalan">Total:</td>'));

                    totalFinalRowPenjualan.append($(
                        `<td><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric  " autocomplete="off" value="${entry.total}"></td>`
                    ));

                    tablePenjualan.append(totalFinalRowPenjualan);

                    tableContainerPenjualan.append(tablePenjualan);
                    $("#editAllTableBodyPenjualan").append(tableContainerPenjualan);

                    $.each(entry.details, function(index, details) {
                        idDetailsLookupPenjualan = `${indexHeader}-${index}`
                        initLookupDetailEditAllPenjualan(idDetailsLookupPenjualan, tablePenjualan, details)
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
                    //                 setTotalHargaEditAllPenjualan(trHarga)
                    //                 setSubTotalEditAllPenjualan(tablePenjualan)
                    //                 setTaxEditAllPenjualan(tablePenjualan)
                    //                 setTotalEditAllPenjualan(tablePenjualan)
                    //                 initAutoNumericNoDoubleZero(trHarga.find('td [name="harga[]"]'))

                    //             }
                    //         }


                    //     });



                    // });

                    trLength = tablePenjualan.find('.detail-row');

                    if (trLength.length == 1) {
                        trLength.find('.delete-roweditall').prop('disabled',true)
                    }

                    tablePenjualan.on('input', 'input[name="qty[]"]', function() {
                        // parentEl = $(this).parents(`table#${entry.id}edit`)
                        parentEl = $(this).closest(`table`)

                        $.each(parentEl.find('.detail-row'), function(index, data) {
                            let idDetailsLookup = `${indexHeader}-${index}`

                            childEl = $(data).attr('id');
                            elementQty = parentEl.find(`tr#${childEl}`)

                            
                            setTotalHargaEditAllPenjualan(elementQty)
                        })
                        setSubTotalEditAllPenjualan(parentEl)
                        setTaxEditAllPenjualan(parentEl)
                        setTotalEditAllPenjualan(parentEl)


                    })

                    tablePenjualan.on('input', 'input[name="tax[]"]', function() {
                        parentEl = $(this).parents(`table#${entry.id}edit`)
                        setTaxEditAllPenjualan(parentEl)
                        setTotalEditAllPenjualan(parentEl)
                    })

                    tablePenjualan.on('input', 'input[name="discount[]"]', function() {
                        parentEl = $(this).parents(`table#${entry.id}edit`)
                        setTotalEditAllPenjualan(parentEl)
                    })

                    tablePenjualan.on('input', 'input[name="harga[]"]', function() {
                        parentEl = $(this).parents(`table#${entry.id}edit`)
                        $.each(parentEl.find('.detail-row'), function(index, data) {
                            // let idDetailsLookup = `${indexHeader}-${index}`
                            // childEl = parentEl.find(`tr#${idDetailsLookup}`)

                            // setTotalHargaEditAllPenjualan(childEl)

                            childEl = $(data).attr('id');
                            elementHarga = parentEl.find(`tr#${childEl}`)

                            setTotalHargaEditAllPenjualan(elementHarga)
                        })
                        setSubTotalEditAllPenjualan(parentEl)
                        setTaxEditAllPenjualan(parentEl)
                        setTotalEditAllPenjualan(parentEl)

                    })

                    if (entry.nominalbayar > 0) {
                        // Disable all input elements in detailRow
                        detailRow.find('input').prop('disabled', true)
                        tablePenjualan.find('.ui-datepicker-trigger').attr('disabled', true);
                        totalRowPenjualan.find('input').prop('disabled', true)
                        taxRowPenjualan.find('input').prop('disabled', true)
                        discRowPenjualan.find('input').prop('disabled', true)
                        totalFinalRowPenjualan.find('input').prop('disabled', true)
                    }

                    $.each(entry.details, function(index, details) {

                        if (details.nobuktipembelian !== null && details.nobuktipembelian !==
                            undefined && details.nobuktipembelian !== "") {

                            tablePenjualan.find('[name="subtotal[]"]').prop('disabled', true)
                            tablePenjualan.find('[name="tax[]"]').prop('disabled', true)
                            tablePenjualan.find('[name="taxamount[]"]').prop('disabled', true)
                            tablePenjualan.find('[name="discount[]"]').prop('disabled', true)
                            tablePenjualan.find('[name="total[]"]').prop('disabled', true)
                            tablePenjualan.find('input').prop('disabled', true)
                            // taxRowPenjualan.find('input').prop('disabled', true)
                            // discRowPenjualan.find('input').prop('disabled', true)
                            // totalFinalRowPenjualan.find('input').prop('disabled', true)
                        }

                        if (details.nobuktipembelian == "") {
                            tablePenjualan.find('[name="nobukti[]"]').prop('readonly', true).addClass(
                                'bg-white state-delete')
                            tablePenjualan.find('[name="tglbuktieditall[]"]').prop('readonly', true)
                                .addClass('bg-white state-delete')
                            tablePenjualan.find('[name="subtotal[]"]').prop('readonly', true).addClass(
                                'bg-white state-delete')
                            tablePenjualan.find('[name="taxamount[]"]').prop('readonly', true).addClass(
                                'bg-white state-delete')
                            tablePenjualan.find('[name="total[]"]').prop('readonly', true).addClass(
                                'bg-white state-delete')
                            tablePenjualan.find('[name="totalharga[]"]').prop('readonly', true).addClass(
                                'bg-white state-delete')
                            // taxRowPenjualan.find('input').prop('disabled', true)
                            // discRowPenjualan.find('input').prop('disabled', true)
                            // totalFinalRowPenjualan.find('input').prop('disabled', true)
                        }

                    });



                    initLookupHeaderPenjualan(indexHeader, tablePenjualan, entry)
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="harga[]"]`))
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="totalharga[]"]`))
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="subtotal[]"]`))
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="discount[]"]`))
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="total[]"]`))
                    initAutoNumericNoDoubleZero(tablePenjualan.find(`[name="taxamount[]"]`))
                    initAutoNumeric(tablePenjualan.find(`[name="qty[]"]`))
                    initAutoNumeric(tablePenjualan.find(`[name="qtyretur[]"]`))

                    setRowNumbersEdit(page, 10, tablePenjualan)
                });
            }
        }



        function setRowNumbersEdit(page, itemsPerPage = 10, elements) {
            elements.each((index, element) => {
                let currentPage = page || 1;
                let currentRow = index + 1 + (currentPage - 1) * itemsPerPage;
            });
        }

        function createInputPenjualan(name, value, valueid, id = '') {

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

        function createInputDetailPenjualan(name, value) {
            return $(
                `<input type="text" name="${name}[]" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
            );
        }

        function createInputLookupPenjualan(name, value, id, selectIndex, initLookup, statusid, pesananfinaldetailid,
            iddetail, id2 = '') {
            if (id2 != '') {

                return $(
                    `<input type="hidden" name="pesananfinaldetailid[]" class="form-control pesananfinaldetailid filled-row" value="${pesananfinaldetailid || 0}" >
                <input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="${iddetail}" >
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

        $(document).on("click", ".add-detailpenjualan-row", function() {

            let idheader = $(this).attr('idheader')
            addRowDetailPenjualan($(this), $(this).data('index'), idheader)
        });

        // Add event listener for deleting rows
        $(document).on("click", ".delete-roweditall", function() {
            deleteRowEditAllPenjualan($(this))
        });

        function deleteRowEditAllPenjualan(element) {
            rowTable = element.closest("table").find('.detail-row');
            rowTableAddRow = element.closest("table").find('.tr-addrow');

            indexHeader = element.closest("table").find('button.add-detailpenjualan-row').data('index');


            element.closest("tr").remove();

            // let newRowNumber = 1; // Dimulai dari 1
            rowTable.each((index, element) => {
                indexAddRow = `${indexHeader}-${index-1}`
                lookupIndex = `${indexHeader}-${index}`
                // if ($(element).hasClass('tr-addrow')) {
                $(element).find('[name="productnama[]"]').removeClass(`producteditall-lookup${lookupIndex}`);
                $(element).find('[name="productnama[]"]').addClass(`producteditall-lookup${indexAddRow}`);

                $(element).find('[name="satuannama[]"]').removeClass(`satuaneditall-lookup${lookupIndex}`);
                $(element).find('[name="satuannama[]"]').addClass(`satuaneditall-lookup${indexAddRow}`);

                $(element).attr('id', indexAddRow)
                // }
                // Perbarui nomor urutan
              

                // newRowNumber++; // Tambahkan 1 untuk nomor urutan berikutnya

            })
            parentTable = rowTable.closest(`table`);

            trRow = parentTable.find('.detail-row');

            if (trRow.length == 1) {
                trRow.find('.delete-roweditall').prop('disabled',true)
              
            }
            // console.log();

            trRow.each((index, element) => {
                $(element).find('td.row-number').text(index+1);
              
            })


            // console.log(rowTable.length);

            setSubTotalEditAllPenjualan(parentTable)
            setTaxEditAllPenjualan(parentTable)
            setTotalEditAllPenjualan(parentTable)
        }

        function addRowDetailPenjualan(element, currentIndexHeader, idheader) {
            const addRow = element.closest(".addRowPenjualan");
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
                    <input type="hidden" name="originalqty[]" class="form-control addrow-qtyoriginal lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" >`,
                `<input type="text" name="qtyretur[]" class="form-control addrow-qtyretur lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
                createInputDetailPenjualan("keterangandetail", ""),
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
                }

                newRow.append($cell);
            });

            addRow.before(newRow);

            newRow.find(`.addrow-qty`).remove();
            newRow.find(`.addrow-harga`).remove();
            newRow.find(`.addrow-qtyoriginal`).remove();
            newRow.find(`.addrow-qtyretur`).remove();
            newRow.find(`.addrow-totalharga`).remove();

            let newqty =
                `<input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"><input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"> `

            let newharga =
                `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" value="0" >`

            let newqtyretur =
                `<input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric autonumeric-zero bg-white state-delete" autocomplete="off" value="0" readonly>`

            let newqtytotalharga =
                `<input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`


            newRow.find(`#qty${indexAddRowCurrent}`).append(newqty);
            newRow.find(`#harga${indexAddRowCurrent}`).append(newharga);
            newRow.find(`#qtyretur${indexAddRowCurrent}`).append(newqtyretur);
            newRow.find(`#totalharga${indexAddRowCurrent}`).append(newqtytotalharga);

            initAutoNumeric(newRow.find(`[name="qty[]"]`))
            initAutoNumeric(newRow.find(`[name="qtyretur[]"]`))
            initAutoNumericNoDoubleZero(newRow.find(`[name="harga[]"]`))
            initAutoNumericNoDoubleZero(newRow.find(`[name="totalharga[]"]`))

            buttonCLearAll = element.closest('table').find('tr.detail-row .delete-roweditall')

            if (buttonCLearAll.is(':disabled')) {
                buttonCLearAll.prop('disabled',false)
            }
            // let btnClear = $(`.producteditall-lookup${indexAddRowCurrent}`).closest('table').find('[name="productnama[]"]').parents('.input-group').find('.lookup-toggler')

            //     console.log(btnClear);

            //  if(btnClear.hasClass('lookup-toggler')){
            // return ''
            // };



            initLookupDetailEditAllPenjualan(indexAddRowCurrent, element.closest('table'))
        }




        function initLookupHeaderPenjualan(index, detailRowEditAll, detail, tableEL) {
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


                    // setTotal()

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
        }

        function initLookupDetailEditAllPenjualan(indexDetail, detailRowEditAll, detail) {
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

                        setTotalHargaEditAllPenjualan(detailPerRow)
                    })
                    // console.log(parentTable);
                    initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
                    setSubTotalEditAllPenjualan(parentTable)
                    setTaxEditAllPenjualan(parentTable)
                    setTotalEditAllPenjualan(parentTable)

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
    </script>
@endpush()
