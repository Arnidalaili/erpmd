\<div class="modal modal-fullscreen" id="editAllModalPembelian" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllFormPembelian">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllModalPembelianTitle"></p>
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
                    <table class="table table-bordered" id="editAllPembelian">
                        <thead>
                            <!-- Add your table header here if needed -->
                        </thead>
                        <tbody id="editAllTableBodyPembelian"></tbody>
                    </table>
                    <div class=" bg-white editAllPager overflow-x-hidden mt-3">
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmitEditAllPembelian" class="btn btn-primary">
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
    let modalBodyEditAllPembelian = $('#editAllModalPembelian').find('.modal-body').html()
    let dataEditAllPembelian = {}
    let jumlahMaster = 0;

    $(document).ready(function() {

        $(document).on('change', `#editAllFormPembelian [id="tglpengirimanbeli"]`, function() {
            getAllPembelian(1, 10)
        });

        $(document).on('click', '.btn-batal', function(event) {
            event.preventDefault()
            if ($('#editAllFormPembelian').data('action') == 'edit') {


                $.ajax({
                    url: `{{ config('app.api_url') }}pesananfinalheader/editingat`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        id: $('#editAllFormPembelian').find('[name=id]').val(),
                        btn: 'batal'
                    },
                    success: response => {
                        $("#editAllModalPembelian").modal("hide")
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
                $("#editAllModalPembelian").modal("hide")
            }
        })




        $('#btnSubmitEditAllPembelian').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#editAllFormPembelian')
            let action = form.data('action')

            let detailsDataAll = [];

            for (let i = 0; i < jumlahMaster; i++) {
                if (!$(`.header${i}`).find(`tr.totalan input`).is(':disabled')) {

                    let dataheader = $(`.header${i}`).find(`.data-header td.row-data${i}`);
                    let totalan = $(`.header${i}`).find(`tr.totalan `);
                    let total = $(`.header${i}`).find(`tr.total `);
                    let potongan = $(`.header${i}`).find(`tr.potongan `);
                    let tglpengiriman = $('#editAllFormPembelian').find('[name=tglpengirimanbeli]').val();
                    let tanggal = "tglpengiriman";

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
                        // if (inputHeader.hasClass('pesananfinalid')) {
                        //     let pesananfinalidInput = $(row).find('input.pesananfinalid').prop(
                        //         'name').replace(/\[\]/g, '');
                        //     let valuePesananfinal = $(row).find('input.pesananfinalid').val();
                        //     detailsDataAll[i][pesananfinalidInput] = valuePesananfinal;
                        // }

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

                    detailsDataAll[i][tanggal] = tglpengiriman;
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

                        if (inputDetail.hasClass('idheader')) {
                            let idHeaderName = $(rowDetail).find('input.idheader').prop('name')
                            let valueIdHeader = $(rowDetail).find('input.idheader').val();

                            if (!detailsDataAll[i]['details'][idHeaderName]) {
                                detailsDataAll[i]['details'][idHeaderName] = [];
                            }

                            detailsDataAll[i]['details'][idHeaderName].push(valueIdHeader);
                        }

                        // if (inputDetail.hasClass('pesananfinaldetailid')) {
                        //     let idPesananFinalDetailIdName = $(rowDetail).find(
                        //         'input.pesananfinaldetailid').prop('name')
                        //     let valueIdPesananFinalDetail = $(rowDetail).find(
                        //         'input.pesananfinaldetailid').val();

                        //     if (!detailsDataAll[i]['details'][idPesananFinalDetailIdName]) {
                        //         detailsDataAll[i]['details'][idPesananFinalDetailIdName] = [];
                        //     }

                        //     detailsDataAll[i]['details'][idPesananFinalDetailIdName].push(
                        //         valueIdPesananFinalDetail);
                        // }

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


            $.ajax({
                url: `${apiUrl}pesananfinalheader/processeditallpembelian`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(detailsDataAll)
                },
                success: response => {
                    $('#editAllFormPembelian').trigger('reset')
                    $('#editAllModalPembelian').modal('hide')

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                    }).trigger('reloadGrid');

                    dataEditAllPembelian = {}
                },
                error: error => {
                    
                    if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            $.each(error.responseJSON.errors, (index, error) => {
                            let indexes = index.split("."); 
                            let element;

                            if (indexes.length > 1) {
                                element = $('#editAllFormPembelian').find(`.header${indexes[0]} [name="${indexes[2]}"]`)[indexes[3]];
                                
                            } else {
                                element = $('#editAllFormPembelian').find(`.header${indexes[0]} [name="${indexes[2]}"]`)[0];
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

    function setTotalHargaEditAllPembelian(element, id = 0) {

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
        initAutoNumeric(element.find(`[name="qty[]"]`).val(amountqty))
    }

    function setQtyPesanan(element, id = 0) {
        let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
        initAutoNumeric(element.find(`[name="qtypesanan[]"]`).val(qty))
    }

    function setSubTotalEditAllPembelian(element) {
        let nominalDetails = element.find(`[name="totalharga[]"]`);
        let total = 0
        $.each(nominalDetails, (index, nominalDetail) => {
            total += AutoNumeric.getNumber(nominalDetail)
        });
        initAutoNumericNoDoubleZero(element.find(`[name="subtotal[]"]`).val(total))
    }

    function setTaxEditAllPembelian(element) {
        let result;
        let total = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''))


        let taxlabel = parseFloat(element.find(`[name="tax[]"]`).val().replace(/,/g, ''))

        result = (taxlabel / 100) * total;


        initAutoNumericNoDoubleZero(element.find(`[name="taxamount[]"]`).val(result))
    }


    function setTotalEditAllPembelian(element) {
        let grandtotal;

        let subtotal = parseFloat(element.find(`[name="subtotal[]"]`).val().replace(/,/g, ''));
        let potongan = parseFloat(element.find(`[name="potongan[]"]`).val().replace(/,/g, ''));
        grandtotal = subtotal - potongan

        initAutoNumericNoDoubleZero(element.find(`[name="total[]"]`).val(grandtotal))
    }

    $('#editAllModalPembelian').on('shown.bs.modal', () => {

        var editAllModal = $('#editAllModalPembelian')
        let form = $('#editAllPembelian')
        setFormBindKeys(form)
        activeGrid = null

        form.find('#btnSubmit').prop('disabled', false)
        if (form.data('action') == "view") {
            form.find('#btnSubmit').prop('disabled', true)
        }
        getMaxLength(form)
        initDatepicker()

    });
    $('#editAllModalPembelian').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModalPembelian').find('.modal-body').html(modalBodyEditAllPembelian)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        initDatepicker('datepickerIndex')

    })

    function editAllPembelian() {
        let totalRows
        let lastPage
        let form = $('#editAllModalPembelian')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditAllPembelian').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'editall')
        form.find(`.sometimes`).hide()
        $('#editAllModalPembelianTitle').text('Edit All Pesanan Supplier')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate());
        $('#editAllFormPembelian').find('[name=tglpengirimanbeli]').val($.datepicker.formatDate('dd-mm-yy', besok))
            .trigger(
                'change');

        Promise
            .all([
                getAllPembelian(1, 10),
            ])
            .then((attributes) => {
                totalRowsEditAll = attributes[0].totalRows
                totalPages = attributes[0].totalPages

                $('#editAllModalPembelian').modal('show')

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

    function getAllPembelian(page, limit = 10, filters = []) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pesananfinalheader/getallpembelian`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    page: page,
                    limit: limit,
                    sortIndex: 'nobukti',
                    sortOrder: 'desc',
                    tglpengirimanbeli: $('#editAllFormPembelian').find('[id=tglpengirimanbeli]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAllPembelian tbody').html('')
                    data = response.data
                    detailHeader = ["No", "Supplier", "No Bukti", "tgl bukti", "Karyawan",
                        "tgl terima", "keterangan"
                    ]
                    subHeader = ["No", "product", "satuan", "Qty", "Qty Stok", "Qty Retur",
                        "Qty Pesanan", "keterangan", "Harga", "total Harga"]
                    console.log(response.data)

                    // initValue(data)
                    createTablePembelian(data, detailHeader, subHeader);

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

    // Create a container div for each table
    let tableContainerPembelian = $('<div class="table-container mb-4">');
    let tablePembelian = $("<table>");

    function createTablePembelian(data, detailHeader, subHeader) {
        $("#editAllTableBodyPembelian").empty();
        tbody = $('#editAllTableBodyPembelian')
        if (data.length === 0) {
            // If there is no data, display a styled message
            const noDataRow = $('<tr><td colspan="8" class="text-center">No data available</td></tr>');
            tbody.append(noDataRow);
        } else {
            jumlahMaster = data.length
            $.each(data, function(indexHeader, entry) {

                // Create a container div for each table
                tableContainerPembelian = $('<div class="table-container mb-5">');

                tablePembelian = $(`<table class="header${indexHeader}" id=${entry.id}edit>`);

                // Detail Header
                const detailHeaderRow = $('<tr class="header-row">');
                const detailHeaderCells = detailHeader
                detailHeaderCells.forEach((cellText) => {
                    detailHeaderRow.append($("<th>").text(cellText));
                });
                tablePembelian.append(detailHeaderRow);
                // Detail Row
                const detailRow = $("<tr class='data-header'>");
                detailRow.append($("<td>").text(indexHeader + 1));

                const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                const tglterima = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglterima));
                const detailCellsPembelian = [
                    createInputLookupPembelian("suppliernama", entry.suppliernama, 'supplierid',
                        indexHeader, 'suppliereditall', entry.supplierid),
                    `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}" readonly />`,
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}" readonly></div>`,


                    createInputLookupPembelian("karyawannama", entry.karyawannama, 'karyawanid',
                        indexHeader, 'karyawaneditall', entry.karyawanid),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglterima[]" id="tglterima${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglterima}"></div>`,
                    createInputPembelian("keterangan", entry.keterangan),
                ];

                tablePembelian.append(detailRow);
                // detailCellsPembelian.forEach((cell) => detailRow.append($(`<td class='row-data${indexHeader}' style="width: 250px; min-width: 200px;">`).append(
                //     cell)));
                detailCellsPembelian.forEach((cell, index) => {

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
                            `<td class='row-data${indexHeader}' style="${widthStyle} ${minWidthStyle}">`
                        )
                        .append(cell)
                    );
                });

                tablePembelian.append(detailRow);

                // Sub Header
                const subHeaderRowPembelian = $('<tr class="sub-header-row">');
                const subHeaderCellsPembelian = subHeader
                subHeaderCellsPembelian.forEach((cellText) => {
                    subHeaderRowPembelian.append($("<th>").text(cellText));
                });
                tablePembelian.append(subHeaderRowPembelian);

                let totalPricePembelian = 0;

                $.each(entry.details, function(index, details) {
                    idDetailsLookupPembelian = `${indexHeader}-${index}`
                    const productRowPembelian = $(`<tr class="detail-row data-detail" id="${index}">`);
                    productRowPembelian.append($("<td class='row-number'>").text(index + 1));
                    const productCellsPembelian = [
                        createInputLookupPembelian("productnama", details.productnama, 'productid',
                            idDetailsLookupPembelian, 'producteditall', details.productid, details.id, 'id'),
                        createInputLookupPembelian("satuannama", details.satuannama, 'satuanid',
                            idDetailsLookupPembelian,
                            'satuaneditall', details.satuanid),
                        ` <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >
                         <input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                        ` <input type="text" name="qtystok[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtystok}" >`,
                        ` <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" >`,
                        ` <input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtypesanan}" >`,
                        createInputDetailPembelian("keterangandetail", details.keterangandetail),
                        ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                        ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${details.totalharga}" readonly>`,
                        
                    ];

                    productCellsPembelian.forEach((cell, index) => {

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
                            const hargaTdId = `harga${idDetailsLookupPembelian}`;
                            $cell.attr('id', hargaTdId);
                            $cell.addClass('harga');
                        } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                            const totalhargaTdId = `totalharga${idDetailsLookupPembelian}`;
                            $cell.attr('id', totalhargaTdId);
                        }

                        productRowPembelian.append($cell);

                        productRowPembelian.find('[name="qty[]"]').prop('disabled', true)
                            .addClass('bg-white state-delete');
                        productRowPembelian.find('[name="qtystok[]"]').prop('disabled',
                            true).addClass('bg-white state-delete');
                        productRowPembelian.find('[name="qtypesanan[]"]').prop('disabled',
                            true).addClass('bg-white state-delete');
                        productRowPembelian.find('[name="keterangandetail[]"]').prop(
                            'disabled', true).addClass('bg-white state-delete');
                        productRowPembelian.find('[name="satuannama[]"]').prop('disabled',
                            true).addClass('bg-white state-delete');
                        productRowPembelian.find('[name="productnama[]"]').prop('disabled',
                            true).addClass('bg-white state-delete');
                        productRowPembelian.find(`[name="qtyretur[]"]`).prop('disabled',
                            true).addClass('bg-white state-delete');
                    });
                    tablePembelian.append(productRowPembelian);

                    totalPricePembelian += details.harga; // Accumulate the total price

                });


                // Display total price row
                const totalRowPembelian = $("<tr class='totalan'>");
                totalRowPembelian.append($('<td colspan="8">'));
                totalRowPembelian.append($('<td colspan="1" class="totalan">Subtotal:</td>'));

                totalRowPembelian.append($(
                    `<td><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                ));

                tablePembelian.append(totalRowPembelian);

                // Add additional row below the total row

                const potRowPembelian = $("<tr class='potongan'>");
                potRowPembelian.append($('<td colspan="8">'));
                potRowPembelian.append($('<td colspan="1" class="totalan">potongan:</td>'));

                potRowPembelian.append($(
                    `<td><input type="text" name="potongan[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.potongan}"></td>`
                ));

                tablePembelian.append(potRowPembelian);

                const totalFinalRowPembelian = $("<tr class='total'>");
                totalFinalRowPembelian.append($('<td colspan="8">'));
                totalFinalRowPembelian.append($('<td colspan="1" class="totalan">Total:</td>'));

                totalFinalRowPembelian.append($(
                    `<td><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.total}" readonly></td>`
                ));
                tablePembelian.append(totalFinalRowPembelian);
                tableContainerPembelian.append(tablePembelian);

                $("#editAllTableBodyPembelian").append(tableContainerPembelian);

                $.each(entry.details, function(index, details) {
                    idDetailsLookupPembelian = `${indexHeader}-${index}`
                    initLookupDetailEditAllPembelian(idDetailsLookupPembelian, tablePembelian, details)

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
                //                 setSubTotalEditAllPembelian(trHarga)
                //                 setSubTotalEditAllPembelian(tablePembelian)
                //                 setTotalEditAllPembelian(tablePembelian)
                //                 initAutoNumericNoDoubleZero(trHarga.find('td [name="harga[]"]'))

                //             }
                //         }


                //     });

                // });

                tablePembelian.on('input', 'input[name="potongan[]"]', function() {

                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAllPembelian(parentEl)
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="tax[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTaxEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                })

                tablePembelian.on('input', 'input[name="discount[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAllPembelian(parentEl)
                })

                tablePembelian.on('input', 'input[name="qty[]"]', function() {
                    // parentEl = $(this).parents(`table#${entry.id}edit`)
                    parentEl = $(this).closest(`table`)

                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = $(data).attr('id');
                        elementQty = parentEl.find(`tr#${childEl}`)

                        setTotalHargaEditAllPembelian(elementQty)
                        setQtyPesanan(elementQty)
                    })
                    setSubTotalEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                   
                })

                tablePembelian.on('input', 'input[name="qtyretur[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setQty(childEl)
                        setTotalHargaEditAllPembelian(childEl)
                    })
                    setSubTotalEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                 
                })


                // tablePembelian.on('input', 'input[name="pesananfinalid[]"]', function() {
                //     pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                // })

                // tablePembelian.on('input', 'input[name="pesananfinaldetailid[]"]', function() {
                //     pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                // })

                tablePembelian.on('input', 'input[name="harga[]"]', function() {

                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = $(data).attr('id');
                        elementHarga = parentEl.find(`tr#${childEl}`)

                        setTotalHargaEditAllPembelian(elementHarga)
                    })

                    setSubTotalEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                })


                if (entry.nominalbayar > 0) {
                    // Disable all input elements in detailRow
                    detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    tablePembelian.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    potRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    totalFinalRowPembelian.find('input').prop('disabled', true).addClass(
                        'bg-white state-delete');

                    tablePembelian.find('input').removeClass('bg-white state-delete')
                }

                initLookupHeaderPembelian(indexHeader, tablePembelian, entry)
                initAutoNumericNoDoubleZero(tablePembelian.find(`[name="harga[]"]`))
                initAutoNumericNoDoubleZero(tablePembelian.find(`[name="totalharga[]"]`))
                initAutoNumericNoDoubleZero(tablePembelian.find(`[name="subtotal[]"]`))
                initAutoNumericNoDoubleZero(tablePembelian.find(`[name="potongan[]"]`))
                initAutoNumericNoDoubleZero(tablePembelian.find(`[name="total[]"]`))
                initAutoNumeric(tablePembelian.find(`[name="qty[]"]`))
                initAutoNumeric(tablePembelian.find(`[name="qtystok[]"]`))
                initAutoNumeric(tablePembelian.find(`[name="qtyretur[]"]`))
                initAutoNumeric(tablePembelian.find(`[name="qtypesanan[]"]`))

            });
        }
    }


    function pushEditedDataToObjectPembelian(detailRow, detail) {

        if (dataEditAllPembelian.hasOwnProperty(String(detail.id))) {
            delete dataEditAllPembelian[String(detail.id)];
            let detailsDataAllPembelian = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)
                detailsDataAllPembelian[index] = {
                    // 'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    // 'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'productid': detailEl.find(`[name="productid[]"]`).val(),
                    'productnama': detailEl.find(`[name="productnama[]"]`).val(),
                    'qty': detailEl.find(`[name="qty[]"]`).val(),
                    'qtystok': detailEl.find(`[name="qtystok[]"]`).val(),
                    'qtyretur': detailEl.find(`[name="qtyretur[]"]`).val(),
                    'qtypesanan': detailEl.find(`[name="qtypesanan[]"]`).val(),
                    'satuanid': detailEl.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailEl.find(`[name="satuannama[]"]`).val(),
                    'keterangan': detailEl.find(`[name="keterangan[]"]`).val(),
                    'keterangandetail': detailEl.find(`[name="keterangandetail[]"]`).val(),
                    'harga': parseFloat(detailEl.find(`[name="harga[]"]`).val().replace(/,/g, '')),
                    'totalharga': parseFloat(detailEl.find(`[name="totalharga[]"]`).val().replace(/,/g, ''))
                };

            })


            dataEditAllPembelian[detail.id] = {
                'id': detailRow.find(`[name="id[]"]`).val(),
                'nobukti': detailRow.find(`[name="nobukti[]"]`).val(),
                'tglbukti': detailRow.find(`[name="tglbuktieditall[]"]`).val(),
                'supplierid': detailRow.find(`[name="supplierid[]"]`).val(),
                'suppliernama': detailRow.find(`[name="suppliernama[]"]`).val(),
                'karyawanid': detailRow.find(`[name="karyawanid[]"]`).val(),
                'karyawannama': detailRow.find(`[name="karyawannama[]"]`).val(),
                'tglterima': detailRow.find(`[name="tglterima[]"]`).val(),
                'keterangan': detailRow.find(`[name="keterangan[]"]`).val(),
                'subtotal': parseFloat(detailRow.find(`[name="subtotal[]"]`).val().replace(/,/g, '')),
                'potongan': parseFloat(detailRow.find(`[name="potongan[]"]`).val().replace(/,/g, '')),
                'total': parseFloat(detailRow.find(`[name="total[]"]`).val().replace(/,/g, '')),
                'details': detailsDataAllPembelian,

            };


        } else {
            let detailsDataAllPembelian = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)

                detailsDataAllPembelian[index] = {
                    // 'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    // 'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'productid': detailEl.find(`[name="productid[]"]`).val(),
                    'productnama': detailEl.find(`[name="productnama[]"]`).val(),
                    'qty': detailEl.find(`[name="qty[]"]`).val(),
                    'qtystok': detailEl.find(`[name="qtystok[]"]`).val(),
                    'qtyretur': detailEl.find(`[name="qtyretur[]"]`).val(),
                    'qtypesanan': detailEl.find(`[name="qtypesanan[]"]`).val(),
                    'satuanid': detailEl.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailEl.find(`[name="satuannama[]"]`).val(),
                    'keterangan': detailEl.find(`[name="keterangan[]"]`).val(),
                    'keterangandetail': detailEl.find(`[name="keterangandetail[]"]`).val(),
                    'harga': parseFloat(detailEl.find(`[name="harga[]"]`).val().replace(/,/g, '')),
                    'totalharga': parseFloat(detailEl.find(`[name="totalharga[]"]`).val().replace(/,/g, ''))
                };
            })

            dataEditAllPembelian[detail.id] = {
                'id': detailRow.find(`[name="id[]"]`).val(),
                'nobukti': detailRow.find(`[name="nobukti[]"]`).val(),
                'tglbukti': detailRow.find(`[name="tglbuktieditall[]"]`).val(),
                'supplierid': detailRow.find(`[name="supplierid[]"]`).val(),
                'suppliernama': detailRow.find(`[name="suppliernama[]"]`).val(),
                'karyawanid': detailRow.find(`[name="karyawanid[]"]`).val(),
                'karyawannama': detailRow.find(`[name="karyawannama[]"]`).val(),
                'tglterima': detailRow.find(`[name="tglterima[]"]`).val(),
                'keterangan': detailRow.find(`[name="keterangan[]"]`).val(),
                'subtotal': parseFloat(detailRow.find(`[name="subtotal[]"]`).val().replace(/,/g, '')),
                'potongan': parseFloat(detailRow.find(`[name="potongan[]"]`).val().replace(/,/g, '')),
                'total': parseFloat(detailRow.find(`[name="total[]"]`).val().replace(/,/g, '')),
                'details': detailsDataAllPembelian,
            };
        }
    }

    function createInputPembelian(name, value, valueid, id = '') {

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

    function createInputDetailPembelian(name, value) {
        return $(
            `<input type="text" name="${name}[]" class="form-control lg-form filled-row" autocomplete="off" value="${value}" />`
        );
    }

    function createInputLookupPembelian(name, value, id, selectIndex, initLookup, statusid, valueid2, id2 = '') {
        if (id2 != '') {

            return $(
                `<input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="${valueid2}" >
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

    $(document).on("click", ".add-detailpembelian-row", function() {

    let idheader = $(this).attr('idheader')
    addRowDetailPembelian($(this), $(this).data('index'), idheader)
    });

    // Add event listener for deleting rows
    $(document).on("click", ".delete-roweditallpembelian", function() {
        deleteRowEditAllPembelian($(this))
    });

    function deleteRowEditAllPembelian(element) {
        rowTable = element.closest("table").find('.detail-row');
        rowTableAddRow = element.closest("table").find('.tr-addrow');

        indexHeader = element.closest("table").find('button.add-detailpembelian-row').data('index');


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
            trRow.find('.delete-roweditallpembelian').prop('disabled',true)
            
        }
        // console.log();

        trRow.each((index, element) => {
            $(element).find('td.row-number').text(index+1);
            
        })


        // console.log(rowTable.length);

        setSubTotalEditAllPembelian(parentTable)
        setTotalEditAllPembelian(parentTable)
    }
    

    function addRowDetailPembelian(element, currentIndexHeader, idheader) {
        const addRow = element.closest(".addRowPembelian");
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
            `<input type="text" name="qtystok[]" class="form-control addrow-qtystok lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            `<input type="text" name="qtyretur[]" class="form-control addrow-qtyretur lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            `<input type="text" name="qtypesanan[]" class="form-control addrow-qtypesanan lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`,
            createInputDetailPenjualan("keterangandetail", ""),
            `<input type="text" name="harga[]" class="form-control addrow-harga lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" >`,
            `<input type="text" name="totalharga[]" class="form-control addrow-totalharga lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`,
            `<button type="button" class="btn btn-danger btn-sm delete-roweditallpembelian">Delete</button>`,
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
            } else if ($cell.find('[name="qtystok[]"]').length > 0) {
                const qtystok = `qtystok${indexAddRowCurrent}`;
                $cell.attr('id', qtystok);
                $cell.addClass('qtystok');
            } else if ($cell.find('[name="qtypesanan[]"]').length > 0) {
                const qtypesanan = `qtypesanan${indexAddRowCurrent}`;
                $cell.attr('id', qtypesanan);
                $cell.addClass('qtypesanan');
            }

            newRow.append($cell);
        });

        addRow.before(newRow);

        newRow.find(`.addrow-qty`).remove();
        newRow.find(`.addrow-harga`).remove();
        newRow.find(`.addrow-qtyoriginal`).remove();
        newRow.find(`.addrow-qtyretur`).remove();
        newRow.find(`.addrow-totalharga`).remove();
        newRow.find(`.addrow-qtystok`).remove();
        newRow.find(`.addrow-qtypesanan`).remove();

        let newqty =
            `<input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"><input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric qty autonumeric-zero " autocomplete="off" value="0"> `

        let newharga =
            `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero" autocomplete="off" value="0" >`

        let newqtyretur =
            `<input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0" >`

        let newqtystok =
            `<input type="text" name="qtystok[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`

        let newqtypesanan =
            `<input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric autonumeric-zero" autocomplete="off" value="0">`

        let newqtytotalharga =
            `<input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric autonumeric-nozero " autocomplete="off" value="0">`


        newRow.find(`#qty${indexAddRowCurrent}`).append(newqty);
        newRow.find(`#harga${indexAddRowCurrent}`).append(newharga);
        newRow.find(`#qtyretur${indexAddRowCurrent}`).append(newqtyretur);
        newRow.find(`#totalharga${indexAddRowCurrent}`).append(newqtytotalharga);
        newRow.find(`#qtystok${indexAddRowCurrent}`).append(newqtystok);
        newRow.find(`#qtypesanan${indexAddRowCurrent}`).append(newqtypesanan);

        initAutoNumeric(newRow.find(`[name="qty[]"]`))
        initAutoNumeric(newRow.find(`[name="qtyretur[]"]`))
        initAutoNumeric(newRow.find(`[name="qtystok[]"]`))
        initAutoNumeric(newRow.find(`[name="qtypesanan[]"]`))
        initAutoNumericNoDoubleZero(newRow.find(`[name="harga[]"]`))
        initAutoNumericNoDoubleZero(newRow.find(`[name="totalharga[]"]`))

        buttonCLearAll = element.closest('table').find('tr.detail-row .delete-roweditallpembelian')

        if (buttonCLearAll.is(':disabled')) {
            buttonCLearAll.prop('disabled',false)
        }
        // let btnClear = $(`.producteditall-lookup${indexAddRowCurrent}`).closest('table').find('[name="productnama[]"]').parents('.input-group').find('.lookup-toggler')

        //     console.log(btnClear);

        //  if(btnClear.hasClass('lookup-toggler')){
        // return ''
        // };



        initLookupDetailEditAllPembelian(indexAddRowCurrent, element.closest('table'))
    }

    function initLookupHeaderPembelian(index, detailRowEditAll, detail, tableEL) {
        let rowLookup = index;

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


                // setTotal()
                pushEditedDataToObjectPembelian(detailRowEditAll, detail)
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


                // setTotal()
                pushEditedDataToObjectPembelian(detailRowEditAll, detail)
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
    }

    function initLookupDetailEditAllPembelian(indexDetail, detailRowEditAll, detail) {
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

                $.each(detailRowElement, function(index, data) {
                    childEl = $(data).attr('id');
                    detailPerRow = detailRowEditAll.find(`tr#${childEl}`)

                    setTotalHargaEditAllPembelian(detailPerRow)
                })

                initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
                setSubTotalEditAllPembelian(parentTable)
                setTotalEditAllPembelian(parentTable)

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


                // pushEditedDataToObjectPembelian(detailRowEditAll, detail)
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