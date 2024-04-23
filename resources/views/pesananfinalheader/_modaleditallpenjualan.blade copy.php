<div class="modal modal-fullscreen" id="editAllModalPenjualan" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
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
                                <input type="text" name="tglpengirimanjual" id="tglpengirimanjual" class="form-control lg-form datepicker filled-row">
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

    let jumlahMaster = 0;



    $(document).ready(function() {
        $(document).on('change', `#editAllForm [id="tglpengirimanjual"]`, function() {
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


            $.ajax({
                url: `${apiUrl}pesananfinalheader/processeditallpenjualan`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(dataEditAllPenjualan)
                },
                success: response => {
                    $('#editAllFormPenjualan').trigger('reset')
                    $('#editAllModalPenjualan').modal('hide')

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                    }).trigger('reloadGrid');

                    dataEditAllPenjualan = {}
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

    function setTotalHargaEditAllPenjualan(element, id = 0) {
        let hargasatuan = parseFloat(element.find(`[name="harga[]"]`).val().replace(/,/g, ''));
        let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));
        let amount = qty * hargasatuan;
        initAutoNumericNoDoubleZero(element.find(`[name="totalharga[]"]`).val(amount))
    }

    function setSubTotalEditAllPenjualan(element) {
        let nominalDetails = element.find(`[name="totalharga[]"]`);
        let total = 0
        $.each(nominalDetails, (index, nominalDetail) => {

            total += AutoNumeric.getNumber(nominalDetail)
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
        initLookup()
        getMaxLength(form)
        initDatepicker()

    });
    $('#editAllModalPenjualan').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModalPenjualan').find('.modal-body').html(modalBodyEditAllPenjualan)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
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
        $('#editAllModalPenjualanTitle').text('Edit All Penjualan')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate() + 1);
        $('#editAllFormPenjualan').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
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

                // filtersEditAll(dataColumn)
                // elementPager()
                // viewPageEdit(itemsPerPage,10)
                // bindKeyPagerEditAll()
                // totalInfoPage()
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
                    sortOrder: 'asc',
                    tglpengirimanjual: $('#editAllFormPenjualan').find('[id=tglpengirimanjual]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAllPenjualan tbody').html('')
                    // console.log(response)

                    data = response.data

                    detailHeader = ["No", "tgl bukti", "No Bukti",
                        "Customer",
                        "alamat pengiriman", "tgl pengiriman", "keterangan"
                    ]

                    subHeader = ["No", "product", "satuan", "Qty", "Qty Retur", "keterangan",
                        "Harga", "total Harga"
                    ]

                    // initValue(data)
                    createTablePenjualan(data, detailHeader, subHeader);

                    currentPage = page
                    totalPages = response.attributes.totalPages
                    totalRowsEditAll = response.attributes.totalRows

                    if (Object.keys(dataEditAllPenjualan).length != 0) {
                        Object.keys(dataEditAllPenjualan).forEach(function(key) {

                            var innerObject = dataEditAllPenjualan[key];

                            Object.keys(innerObject).forEach(function(innerKey) {
                                if (innerKey == 'hargajual' || innerKey ==
                                    'hargabeli') {
                                    let hargaJualEl = $(
                                        `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                                    )
                                    $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                        .remove()
                                    $(`#${key}edit`).find(`.${innerKey}`).append(
                                        hargaJualEl)
                                    initAutoNumericNoDoubleZero(hargaJualEl)
                                } else {
                                    $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                        .val(
                                            innerObject[innerKey])
                                }
                            });
                        });
                    }
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
            $.each(data, function(indexHeader, entry) {
                jumlahMaster++

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
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                        <input type="hidden" name="pesananfinalid[]" class="form-control pesananfinalid filled-row" value="${entry.pesananfinalid}" >
                        <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}" readonly></div>`,
                    `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}" readonly />`,
                    createInputLookupPenjualan("customernama", entry.customernama, 'customerid', indexHeader,
                        'customereditall', entry.customerid),
                    createInputPenjualan("alamatpengiriman", entry.alamatpengiriman),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglpengirimaneditall[]" id="tglpengiriman${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglpengiriman}"></div>`,
                    createInputPenjualan("keterangan", entry.keterangan),

                ];

                tablePenjualan.append(detailRow);
                detailCellsPenjualan.forEach((cell) => detailRow.append($(`<td class='row-data${indexHeader}'>`).append(
                    cell)));
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
                    const productRowPenjualan = $(`<tr class="detail-row" id="${index}">`);
                    productRowPenjualan.append($("<td>").text(index + 1));
                    const productCellsPenjualan = [
                        createInputLookupPenjualan("productnama", details.productnama, 'productid',
                            idDetailsLookupPenjualan, 'producteditall', details.productid, details.pesananfinaldetailid, details.id,'id'),
                        createInputLookupPenjualan("satuannama", details.satuannama, 'satuanid',
                            idDetailsLookupPenjualan,
                            'satuaneditall', details.satuanid),
                        ` <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                        ` <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" >`,
                        createInputDetailPenjualan("keterangandetail", details.keterangandetail),
                        ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                        ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${details.totalharga}" readonly>`,
                    ];

                    productCellsPenjualan.forEach((cell) => {
                        const $cell = $("<td>").append(cell);
                        if ($cell.find('[name="harga[]"]').length > 0) {
                            const hargaTdId = `harga${idDetailsLookupPenjualan}`;
                            $cell.attr('id', hargaTdId);
                        } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                            const totalhargaTdId = `totalharga${idDetailsLookupPenjualan}`;
                            $cell.attr('id', totalhargaTdId);
                        }

                        productRowPenjualan.append($cell);

                        if (entry.nominalbayar > 0) {
                            productRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        }
                        

                        if (details.nobuktipembelian !== null && details.nobuktipembelian !== undefined && details.nobuktipembelian !== "")
                        {
                            detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        }

                    });
                    tablePenjualan.append(productRowPenjualan);

                    totalPricePenjualan += details.harga;
                });


                // Display total price row
                const totalRowPenjualan = $("<tr class='totalan'>");
                totalRowPenjualan.append($('<td colspan="5">'));
                totalRowPenjualan.append($('<td colspan="2" class="totalan">Subtotal:</td>'));

                totalRowPenjualan.append($(
                    `<td><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                ));

                tablePenjualan.append(totalRowPenjualan);

                // Add additional row below the total row
                const taxRowPenjualan = $("<tr class='tax'>");
                taxRowPenjualan.append($('<td colspan="5">'));
                taxRowPenjualan.append($('<td colspan="2" class="totalan">tax:</td>'));
                taxRowPenjualan.append(`
                    <td>
                        <div class="row">
                            <div class="col-md-5">
                              <div class="input-group">
                                <input type="text" name="tax[]" class="form-control lg-form filled-row autonumeric" style="width:50%; float:right;" autocomplete="off" value="${entry.tax}">
                                <div class="input-group-append">
                                  <span class="input-group-text">% </span>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-7 mt-3 mt-md-0">
                                <input type="text" name="taxamount[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.taxamount}" readonly>
                            </div>
                          </div>
                       
                    </td>
                `);

                tablePenjualan.append(taxRowPenjualan);

                const discRowPenjualan = $("<tr class='discount'>");
                discRowPenjualan.append($('<td colspan="5">'));
                discRowPenjualan.append($('<td colspan="2" class="totalan">Discount:</td>'));

                discRowPenjualan.append($(
                    `<td><input type="text" name="discount[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.discount}"></td>`
                ));

                tablePenjualan.append(discRowPenjualan);

                const totalFinalRowPenjualan = $("<tr class='total'>");
                totalFinalRowPenjualan.append($('<td colspan="5">'));
                totalFinalRowPenjualan.append($('<td colspan="2" class="totalan">Total:</td>'));

                totalFinalRowPenjualan.append($(
                    `<td><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.total}" readonly></td>`
                ));

                tablePenjualan.append(totalFinalRowPenjualan);

                tableContainerPenjualan.append(tablePenjualan);
                $("#editAllTableBodyPenjualan").append(tableContainerPenjualan);

                $.each(entry.details, function(index, details) {
                    idDetailsLookupPenjualan = `${indexHeader}-${index}`
                    initLookupDetailEditAllPenjualan(idDetailsLookupPenjualan, tablePenjualan, details)
                });

                tablePenjualan.on('input', 'input[name="productnama[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="keterangan[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="satuannama[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="pesananfinalid[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="pesananfinaldetailid[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="qty[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setTotalHargaEditAllPenjualan(childEl)
                    })
                    setSubTotalEditAllPenjualan(parentEl)
                    setTaxEditAllPenjualan(parentEl)
                    setTotalEditAllPenjualan(parentEl)

                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="qtyretur[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="keterangandetail[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="harga[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)

                        setTotalHargaEditAllPenjualan(childEl)
                    })
                    setSubTotalEditAllPenjualan(parentEl)
                    setTaxEditAllPenjualan(parentEl)
                    setTotalEditAllPenjualan(parentEl)
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="nobukti[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="customernama[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="alamatpengiriman[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="tglpengirimaneditall[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="keterangan[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePenjualan.on('input', 'input[name="statusnama[]"]', function() {
                    pushEditedDataToObjectPenjualan($(this).parents(`table#${entry.id}edit`), entry)
                })

                if (entry.nominalbayar > 0) {
                    // Disable all input elements in detailRow
                    detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    tablePenjualan.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    taxRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    discRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    totalFinalRowPenjualan.find('input').prop('disabled', true).addClass('bg-white state-delete');
                }

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

    function pushEditedDataToObjectPenjualan(detailRow, detail) {
        if (dataEditAllPenjualan.hasOwnProperty(String(detail.id))) {
            delete dataEditAllPenjualan[String(detail.id)];
            let detailsDataAllPenjualan = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)
                detailsDataAllPenjualan[index] = {
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'productid': detailEl.find(`[name="productid[]"]`).val(),
                    'productnama': detailEl.find(`[name="productnama[]"]`).val(),
                    'qty': detailEl.find(`[name="qty[]"]`).val(),
                    'qtyretur': detailEl.find(`[name="qtyretur[]"]`).val(),
                    'satuanid': detailEl.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailEl.find(`[name="satuannama[]"]`).val(),
                    'nobuktipesananfinal': detailEl.find(`[name="nobuktipesananfinal[]"]`).val(),
                    'keterangan': detailEl.find(`[name="keterangan[]"]`).val(),
                    'keterangandetail': detailEl.find(`[name="keterangandetail[]"]`).val(),
                    'harga': parseFloat(detailEl.find(`[name="harga[]"]`).val().replace(/,/g, '')),
                    'totalharga': parseFloat(detailEl.find(`[name="totalharga[]"]`).val().replace(/,/g, ''))
                };

            })


            dataEditAllPenjualan[detail.id] = {
                'id': detailRow.find(`[name="id[]"]`).val(),
                'nobukti': detailRow.find(`[name="nobukti[]"]`).val(),
                'pesananfinalid': detailRow.find(`[name="pesananfinalid[]"]`).val(),
                'tglbukti': detailRow.find(`[name="tglbuktieditall[]"]`).val(),
                'customerid': detailRow.find(`[name="customerid[]"]`).val(),
                'customernama': detailRow.find(`[name="customernama[]"]`).val(),
                'alamatpengiriman': detailRow.find(`[name="alamatpengiriman[]"]`).val(),
                'tglpengiriman': detailRow.find(`[name="tglpengirimaneditall[]"]`).val(),
                'keterangan': detailRow.find(`[name="keterangan[]"]`).val(),
                'status': detailRow.find(`[name="status[]"]`).val(),
                'statusnama': detailRow.find(`[name="statusnama[]"]`).val(),
                'subtotal': parseFloat(detailRow.find(`[name="subtotal[]"]`).val().replace(/,/g, '')),
                'tax': parseFloat(detailRow.find(`[name="tax[]"]`).val().replace(/,/g, '')),
                'taxamount': parseFloat(detailRow.find(`[name="taxamount[]"]`).val().replace(/,/g, '')),
                'discount': parseFloat(detailRow.find(`[name="discount[]"]`).val().replace(/,/g, '')),
                'total': parseFloat(detailRow.find(`[name="total[]"]`).val().replace(/,/g, '')),
                'details': detailsDataAllPenjualan,

            };


        } else {
            let detailsDataAllPenjualan = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)
                detailsDataAllPenjualan[index] = {
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'productid': detailEl.find(`[name="productid[]"]`).val(),
                    'productnama': detailEl.find(`[name="productnama[]"]`).val(),
                    'qty': detailEl.find(`[name="qty[]"]`).val(),
                    'qtyretur': detailEl.find(`[name="qtyretur[]"]`).val(),
                    'satuanid': detailEl.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailEl.find(`[name="satuannama[]"]`).val(),
                    'nobuktipesananfinal': detailEl.find(`[name="nobuktipesananfinal[]"]`).val(),
                    'keterangan': detailEl.find(`[name="keterangan[]"]`).val(),
                    'keterangandetail': detailEl.find(`[name="keterangandetail[]"]`).val(),
                    'harga': parseFloat(detailEl.find(`[name="harga[]"]`).val().replace(/,/g, '')),
                    'totalharga': parseFloat(detailEl.find(`[name="totalharga[]"]`).val().replace(/,/g, ''))
                };

            })


            dataEditAllPenjualan[detail.id] = {
                'id': detailRow.find(`[name="id[]"]`).val(),
                'nobukti': detailRow.find(`[name="nobukti[]"]`).val(),
                'pesananfinalid': detailRow.find(`[name="pesananfinalid[]"]`).val(),
                'tglbukti': detailRow.find(`[name="tglbuktieditall[]"]`).val(),
                'customerid': detailRow.find(`[name="customerid[]"]`).val(),
                'customernama': detailRow.find(`[name="customernama[]"]`).val(),
                'alamatpengiriman': detailRow.find(`[name="alamatpengiriman[]"]`).val(),
                'tglpengiriman': detailRow.find(`[name="tglpengirimaneditall[]"]`).val(),
                'keterangan': detailRow.find(`[name="keterangan[]"]`).val(),
                'status': detailRow.find(`[name="status[]"]`).val(),
                'statusnama': detailRow.find(`[name="statusnama[]"]`).val(),
                'subtotal': parseFloat(detailRow.find(`[name="subtotal[]"]`).val().replace(/,/g, '')),
                'tax': parseFloat(detailRow.find(`[name="tax[]"]`).val().replace(/,/g, '')),
                'taxamount': parseFloat(detailRow.find(`[name="taxamount[]"]`).val().replace(/,/g, '')),
                'discount': parseFloat(detailRow.find(`[name="discount[]"]`).val().replace(/,/g, '')),
                'total': parseFloat(detailRow.find(`[name="total[]"]`).val().replace(/,/g, '')),
                'details': detailsDataAllPenjualan,
            };
        }
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

    function createInputLookupPenjualan(name, value, id, selectIndex, initLookup, statusid, pesananfinaldetailid, iddetail, id2 = '') {
        if (id2 != '') {

            return $(
                `<input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row" value="${pesananfinaldetailid}" >
                <input type="hidden" name="iddetail[]" class="form-control filled-row" value="${iddetail}" >
                <input type="hidden" name="${id}[]" class="form-control filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        } else {
            return $(
                `<input type="hidden" name="${id}[]" class="form-control filled-row" value="${statusid}">
                <input type="text" name="${name}[]" id="${id}${selectIndex}" class="form-control filled-row lg-form ${initLookup}-lookup${selectIndex}" autocomplete="off" value="${value}">`
            );
        }

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
                pushEditedDataToObjectPenjualan(detailRowEditAll, detail)
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
                pushEditedDataToObjectPenjualan(detailRowEditAll, detail)
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

                pushEditedDataToObjectPenjualan(detailRowEditAll, detail)
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
                    detailPerRow = detailRowEditAll.find(`tr#${index}`)

                    setTotalHargaEditAllPenjualan(detailPerRow)
                })

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


                pushEditedDataToObjectPenjualan(detailRowEditAll, detail)
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