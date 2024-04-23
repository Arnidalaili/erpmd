<div class="modal modal-fullscreen" id="editAllModalPembelian" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
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


            $.ajax({
                url: `${apiUrl}pesananfinalheader/processeditallpembelian`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(dataEditAllPembelian)
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
        initLookup()
        getMaxLength(form)
        initDatepicker()

    });
    $('#editAllModalPembelian').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#editAllModalPembelian').find('.modal-body').html(modalBodyEditAllPembelian)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        
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
        $('#editAllModalPembelianTitle').text('Edit All Pembelian')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate() + 1);
        $('#editAllFormPembelian').find('[name=tglpengirimanbeli]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
            'change');

        Promise
            .all([
                getAllPembelian(1, 10),
            ])
            .then((attributes) => {
                totalRowsEditAll = attributes[0].totalRows
                totalPages = attributes[0].totalPages

                $('#editAllModalPembelian').modal('show')
                elementPager()
                viewPageEdit()
                bindKeyPagerEditAll()
                totalInfoPage()
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
                    sortOrder: 'asc',
                    tglpengirimanbeli: $('#editAllFormPembelian').find('[id=tglpengirimanbeli]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAllPembelian tbody').html('')
                    data = response.data
                    detailHeader = ["No", "tgl bukti", "No Bukti", "Supplier", "Karyawan", "tgl terima", "keterangan"]
                    subHeader = ["No", "product", "satuan", "Qty", "Qty Stok", "Qty Retur", "Qty Pesanan", "keterangan", "Harga", "total Harga"]

                    // initValue(data)
                    createTablePembelian(data, detailHeader, subHeader);

                    currentPage = page
                    totalPages = response.attributes.totalPages
                    totalRowsEditAll = response.attributes.totalRows

                    if (Object.keys(dataEditAllPembelian).length != 0) {
                        Object.keys(dataEditAllPembelian).forEach(function(key) {

                            var innerObject = dataEditAllPembelian[key];

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
                const detailRow = $("<tr>");
                detailRow.append($("<td>").text(indexHeader + 1));

                const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                const tglterima = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglterima));
                const detailCellsPembelian = [
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}" readonly>`,
                    `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}" readonly />`,
                    createInputLookupPembelian("suppliernama", entry.suppliernama, 'supplierid', indexHeader, 'suppliereditall', entry.supplierid),
                    createInputLookupPembelian("karyawannama", entry.karyawannama, 'karyawanid', indexHeader, 'karyawaneditall', entry.karyawanid),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <input type="text" name="tglterima[]" id="tglterima${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglterima}">`,
                    createInputPembelian("keterangan", entry.keterangan),
                ];

                tablePembelian.append(detailRow);
                detailCellsPembelian.forEach((cell) => detailRow.append($(`<td class='row-data${indexHeader}'>`).append(
                    cell)));
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
                    const productRowPembelian = $(`<tr class="detail-row" id="${index}">`);
                    productRowPembelian.append($("<td>").text(index + 1));
                    const productCellsPembelian = [
                        createInputLookupPembelian("productnama", details.productnama, 'productid',
                            idDetailsLookupPembelian, 'producteditall', details.productid, details.pesananfinaldetailid,
                            details.pesananfinalid, details.id, 'id'),
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

                    productCellsPembelian.forEach((cell) => {
                        const $cell = $("<td>").append(cell);

                        // Cek apakah elemen input memiliki atribut 'name' yang sama dengan 'harga[]' atau 'totalharga[]'
                        if ($cell.find('[name="harga[]"]').length > 0) {
                            const hargaTdId = `harga${idDetailsLookupPembelian}`;
                            $cell.attr('id', hargaTdId);
                        } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                            const totalhargaTdId = `totalharga${idDetailsLookupPembelian}`;
                            $cell.attr('id', totalhargaTdId);
                        }

                        productRowPembelian.append($cell);

                        if (details.pesananfinalid === 0 || details.pesananfinalid === null || details.pesananfinalid === undefined)
                        {
                            productRowPembelian.find('[name="qtystok[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="qtypesanan[]"]').prop('disabled', true).addClass('bg-white state-delete');
                        }

                        if (entry.nominalbayar > 0) {
                            detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        }

                        if (details.pesananfinalid > 0) {
                            productRowPembelian.find('[name="qty[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="qtystok[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="qtypesanan[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="keterangandetail[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="satuannama[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRowPembelian.find('[name="productnama[]"]').prop('disabled', true).addClass('bg-white state-delete');
                        }
                    });
                    tablePembelian.append(productRowPembelian);

                    totalPricePembelian += details.harga; // Accumulate the total price

                });


                // Display total price row
                const totalRowPembelian = $("<tr>");
                totalRowPembelian.append($('<td colspan="7">'));
                totalRowPembelian.append($('<td colspan="2" class="totalan">Subtotal:</td>'));

                totalRowPembelian.append($(
                    `<td><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                ));

                tablePembelian.append(totalRowPembelian);

                // Add additional row below the total row

                const potRowPembelian = $("<tr>");
                potRowPembelian.append($('<td colspan="7">'));
                potRowPembelian.append($('<td colspan="2" class="totalan">potongan:</td>'));

                potRowPembelian.append($(
                    `<td><input type="text" name="potongan[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.potongan}"></td>`
                ));

                tablePembelian.append(potRowPembelian);

                const totalFinalRowPembelian = $("<tr>");
                totalFinalRowPembelian.append($('<td colspan="7">'));
                totalFinalRowPembelian.append($('<td colspan="2" class="totalan">Total:</td>'));

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

                tablePembelian.on('input', 'input[name="productnama[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="keterangan[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="satuannama[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="qtypesanan[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="qtystok[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="pesananfinalid[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="pesananfinaldetailid[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="potongan[]"]', function() {

                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAllPembelian(parentEl)
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="qty[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setTotalHargaEditAllPembelian(childEl)
                        setQtyPesanan(childEl)
                    })
                    setSubTotalEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
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
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="keterangandetail[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
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
                        childEl = parentEl.find(`tr#${index}`)
                        setTotalHargaEditAllPembelian(childEl)
                    })

                    setSubTotalEditAllPembelian(parentEl)
                    setTotalEditAllPembelian(parentEl)
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="nobukti[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="karyawannama[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="tglterima[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                tablePembelian.on('input', 'input[name="keterangan[]"]', function() {
                    pushEditedDataToObjectPembelian($(this).parents(`table#${entry.id}edit`), entry)
                })

                if (entry.nominalbayar > 0) {
                    // Disable all input elements in detailRow
                    detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    tablePembelian.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    potRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    totalFinalRowPembelian.find('input').prop('disabled', true).addClass('bg-white state-delete');
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
                    'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
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
                    'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
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

    function createInputLookupPembelian(name, value, id, selectIndex, initLookup, statusid, pesananfinaldetailid, pesananfinalid, valueid2, id2 = '') {
        if (id2 != '') {

            return $(
                ` <input type="hidden" name="pesananfinalid[]" class="form-control filled-row" value="${pesananfinalid}" >
                <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row" value="${pesananfinaldetailid}" >
                <input type="hidden" name="iddetail[]" class="form-control filled-row" value="${valueid2}" >
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

                pushEditedDataToObjectPembelian(detailRowEditAll, detail)
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


                pushEditedDataToObjectPembelian(detailRowEditAll, detail)
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