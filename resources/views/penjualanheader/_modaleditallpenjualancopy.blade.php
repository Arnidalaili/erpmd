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
                                <input type="text" name="tglpengirimanjual" id="tglpengirimanjual"
                                    class="form-control lg-form datepicker filled-row">
                            </div>
                        </div>
                    </div>
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
        let detailEl = {}



        $(document).ready(function() {

            $(document).on('change', `#editAllForm [id="tglpengirimanjual"]`, function() {

                getAll(1, 10)

            });

            $(document).on('click', '.btn-batal', function(event) {
                event.preventDefault()
                if ($('#editAllForm').data('action') == 'edit') {


                    $.ajax({
                        url: `{{ config('app.api_url') }}penjualanheader/editingat`,
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


                $.ajax({
                    url: `${apiUrl}penjualanheader/processeditall`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        data: JSON.stringify(dataEditAll)
                    },
                    success: response => {
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

            let hargasatuan = parseFloat(element.find(`[name="harga[]"]`).val().replace(/,/g, ''));

            let qty = parseFloat(element.find(`[name="qty[]"]`).val().replace(/,/g, ''));

            let amount = qty * hargasatuan;



            initAutoNumericNoDoubleZero(element.find(`[name="totalharga[]"]`).val(amount))


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

            initSelect2($(`[name="statusaktif"]`), true)

            form.find('#btnSubmit').prop('disabled', false)
            if (form.data('action') == "view") {
                form.find('#btnSubmit').prop('disabled', true)
            }
            initLookup()
            getMaxLength(form)
            initDatepicker()

        });
        $('#editAllModal').on('hidden.bs.modal', () => {
            activeGrid = '#jqGrid'
            $('#editAllModal').find('.modal-body').html(modalBodyEditAll)
            dataEditAll = {}
            $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        })

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
            besok.setDate(besok.getDate() + 1);
            $('#editAllForm').find('[name=tglpengirimanjual]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
                'change');

            Promise
                .all([
                    getAll(1, 10),
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
                        sortOrder: 'asc',
                        tglpengirimanjual: $('#editAllForm').find('[id=tglpengirimanjual]').val()
                        // filters: JSON.stringify(filters)
                    },
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        $('#editAll tbody').html('')

                        data = response.data

                        detailHeader = ["No", "tgl bukti", "No Bukti",
                            "Customer",
                            "alamat pengiriman", "tgl pengiriman", "keterangan"
                        ]

                        subHeader = ["No", "product", "satuan", "Qty", "Qty Retur", "keterangan",
                            "Harga", "total Harga"
                        ]

                        // initValue(data)
                        createTable(data, detailHeader, subHeader);

                        currentPage = page
                        totalPages = response.attributes.totalPages
                        totalRowsEditAll = response.attributes.totalRows

                        if (Object.keys(dataEditAll).length != 0) {
                            Object.keys(dataEditAll).forEach(function(key) {

                                var innerObject = dataEditAll[key];

                                Object.keys(innerObject).forEach(function(innerKey) {
                                    if (innerKey == 'subtotal' || innerKey ==
                                        'discount' || innerKey ==
                                        'total') {
                                        let hargaJualEl = $(
                                            `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                                        )
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .remove()
                                        $(`#${key}edit`).find(`.${innerKey}`).append(
                                            hargaJualEl)
                                        initAutoNumericNoDoubleZero(hargaJualEl)
                                    } else if (innerKey == 'taxamount') {
                                        let hargaJualEls = $(
                                            `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                                        )
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .remove()

                                        $(`#${key}edit .tax`).find('.row .taxamount')
                                            .append(
                                                hargaJualEls)
                                        initAutoNumericNoDoubleZero(hargaJualEls)
                                    } else {
                                        // console.log()
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .val(innerObject[innerKey])


                                        if (innerObject.details) {
                                            Object.keys(innerObject.details).forEach(
                                                function(key2) {
                                                    var innerDetail = innerObject
                                                        .details[key2];


                                                    Object.keys(innerDetail)
                                                        .forEach(function(
                                                            innerKeyDetail) {

                                                            if (innerKeyDetail ==
                                                                'harga' ||
                                                                innerKeyDetail ==
                                                                'totalharga') {
                                                                let hargaJualEl =
                                                                    $(
                                                                        `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                                                                    )
                                                                $(`#${key}edit`)
                                                                    .find(
                                                                        `[name="${innerKeyDetail}[]"]`
                                                                    )
                                                                    .remove()

                                                                $(`#${key}edit tr.detail-row`)
                                                                    .find(
                                                                        `.${innerKeyDetail}`
                                                                    )
                                                                    .append(
                                                                        hargaJualEl
                                                                    )
                                                                initAutoNumericNoDoubleZero
                                                                    (
                                                                        hargaJualEl
                                                                        )
                                                            } else if (
                                                                innerKeyDetail ==
                                                                'qty' ||
                                                                innerKeyDetail ==
                                                                'qtyretur') {
                                                                let hargaJualEl =
                                                                    $(
                                                                        `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                                                                    )
                                                                $(`#${key}edit`)
                                                                    .find(
                                                                        `[name="${innerKeyDetail}[]"]`
                                                                    )
                                                                    .remove()

                                                                $(`#${key}edit tr.detail-row`)
                                                                    .find(
                                                                        `.${innerKeyDetail}`
                                                                    )
                                                                    .append(
                                                                        hargaJualEl
                                                                    )
                                                                initAutoNumeric(
                                                                    hargaJualEl
                                                                )
                                                            } else {
                                                                $(`#${key}edit`)
                                                                    .find(
                                                                        `[name="${innerKeyDetail}[]"]`
                                                                    ).val(
                                                                        innerDetail[
                                                                            innerKeyDetail
                                                                        ])
                                                            }

                                                        })
                                                })
                                        }
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
                    const detailRow = $("<tr>");
                    detailRow.append($("<td>").text(indexHeader + 1));

                    const tglbukti = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglbukti));
                    const tglpengiriman = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglpengiriman));


                    const detailCells = [
                        `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                        <input type="hidden" name="pesananfinalid[]" class="form-control filled-row" value="${entry.pesananfinalid}" >
                    <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}" readonly></div>`,
                        `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}" readonly />`,
                        createInputLookup("customernama", entry.customernama, 'customerid', indexHeader,
                            'customereditall', entry.customerid),
                        createInput("alamatpengiriman", entry.alamatpengiriman),
                        `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglpengirimaneditall[]" id="tglpengiriman${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglpengiriman}"></div>`,
                        createInput("keterangan", entry.keterangan),

                    ];

                    table.append(detailRow);
                    detailCells.forEach((cell) => detailRow.append($(
                            `<td class='row-data${indexHeader}' style="width: 250px; min-width: 200px;">`)
                        .append(
                            cell)));
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
                        const productRow = $(`<tr class="detail-row" id="${index}">`);
                        productRow.append($("<td>").text(index + 1));
                        const productCells = [
                            createInputLookup("productnama", details.productnama, 'productid',
                                idDetailsLookup, 'producteditall', details.productid, details.id,
                                details
                                .penjualanid, 'id'),
                            createInputLookup("satuannama", details.satuannama, 'satuanid',
                                idDetailsLookup,
                                'satuaneditall', details.satuanid),
                            ` <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                            ` <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" >`,
                            createInputDetail("keterangandetail", details.keterangandetail),
                            ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                            ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${details.totalharga}" readonly>`,
                        ];

                        productCells.forEach((cell) => {
                            const $cell = $("<td style='width: 250px; min-width: 200px;'>").append(
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
                            } else if ($cell.find('[name="qtyretur[]"]').length > 0) {
                                const qtyretur = `qtyretur${idDetailsLookup}`;
                                $cell.addClass('qtyretur');
                            }


                            productRow.append($cell);

                            if (entry.nominalbayar > 0) {
                                // Disable all input elements in detailRow

                                productRow.find('input').prop('disabled', true).addClass(
                                    'bg-white state-delete');

                            }



                        });
                        table.append(productRow);

                        totalPrice += details.harga; 

                    });


                    // Display total price row
                    const totalRow = $("<tr>");
                    totalRow.append($('<td colspan="5">'));
                    totalRow.append($('<td colspan="2" class="totalan">Subtotal:</td>'));

                    totalRow.append($(
                        `<td class="subtotal"><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                    ));

                    table.append(totalRow);

                    // Add additional row below the total row
                    const taxRow = $("<tr>");

                    taxRow.append($('<td colspan="5">'));
                    taxRow.append($('<td colspan="2" class="totalan">tax:</td>'));
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
                                <input type="text" name="taxamount[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.taxamount}" readonly>
                            </div>
                          </div>
                       
                    </td>
                    `);

                    table.append(taxRow);

                    const discRow = $("<tr>");
                    discRow.append($('<td colspan="5">'));
                    discRow.append($('<td colspan="2" class="totalan">Discount:</td>'));

                    discRow.append($(
                        `<td class="discount"><input type="text" name="discount[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.discount}"></td>`
                    ));

                    table.append(discRow);

                    const totalFinalRow = $("<tr>");
                    totalFinalRow.append($('<td colspan="5">'));
                    totalFinalRow.append($('<td colspan="2" class="totalan">Total:</td>'));

                    totalFinalRow.append($(
                        `<td class="total"><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.total}" readonly></td>`
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

                    $('table').on('input', 'input[name="harga[]"]', function() {
                        let value = $(this).val();

                        let currentProductName = $(this).parents('tr').find(
                            'td [name="productnama[]"]').val();
                        let currentHarga = $(this).parents('tr').find('td [name="harga[]"]');
                        let currentIdProduct = $(this).parents('tr').find('td [name="productid[]"]').val();

                    
                        // Iterate over each input field with name "harga[]"
                        $('table').find('input[name="harga[]"]').each(function() {
                            let trHarga = $(this).parents('tr');
                            let productNameInRow = $(this).parents('tr').find('td [name="productnama[]"]').val();
                            
                            if (productNameInRow == currentProductName && this !== currentHarga[0]) {
                                $(this).remove();
                            
                                let newHargaEl = `<input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${value}">`;
                            
                                trHarga.find('td.harga').append(newHargaEl);

                                initAutoNumericNoDoubleZero(trHarga.find('td [name="harga[]"]'))

                               
                                // pushEditedDataToObject(table, entry)
                            }
                           
                           
                        });
                        console.log($(this).attr('id'));
                        
                       

                    });



                    table.on('input', 'input[name="productnama[]"]', function() {

                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })


                    table.on('input', 'input[name="keterangan[]"]', function() {

                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="satuannama[]"]', function() {

                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="qty[]"]', function() {
                        parentEl = $(this).parents(`table#${entry.id}edit`)

                        $.each(parentEl.find('.detail-row'), function(index, data) {
                            childEl = parentEl.find(`tr#${index}`)
                            setTotalHargaEditAll(childEl)
                        })


                        setSubTotalEditAll(parentEl)
                        setTaxEditAll(parentEl)
                        setTotalEditAll(parentEl)


                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="qtyretur[]"]', function() {

                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="keterangandetail[]"]', function() {

                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="harga[]"]', function() {

                        parentEl = $(this).parents(`table#${entry.id}edit`)

                        $.each(parentEl.find('.detail-row'), function(index, data) {
                            childEl = parentEl.find(`tr#${index}`)

                            setTotalHargaEditAll(childEl)
                        })


                        setSubTotalEditAll(parentEl)
                        setTaxEditAll(parentEl)
                        setTotalEditAll(parentEl)
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="nobukti[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="customernama[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="alamatpengiriman[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="tglpengirimaneditall[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="keterangan[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })

                    table.on('input', 'input[name="statusnama[]"]', function() {
                        pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                    })



                    if (entry.nominalbayar > 0) {
                        // Disable all input elements in detailRow
                        detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        table.find('.ui-datepicker-trigger').attr('disabled', true);
                        totalRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        taxRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        discRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        totalFinalRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    }

                    initLookupHeader(indexHeader, table, entry)
                    initAutoNumericNoDoubleZero(table.find(`[name="harga[]"]`))
                    initAutoNumericNoDoubleZero(table.find(`[name="totalharga[]"]`))
                    initAutoNumericNoDoubleZero(table.find(`[name="subtotal[]"]`))
                    initAutoNumericNoDoubleZero(table.find(`[name="discount[]"]`))
                    initAutoNumericNoDoubleZero(table.find(`[name="total[]"]`))
                    initAutoNumericNoDoubleZero(table.find(`[name="taxamount[]"]`))
                    initAutoNumeric(table.find(`[name="qty[]"]`))
                    initAutoNumeric(table.find(`[name="qtyretur[]"]`))


                  


                });

            }


        }


        function pushEditedDataToObject(detailRow, detail) {
           
            if (dataEditAll.hasOwnProperty(String(detail.id))) {
                console.log('detail.id ', detail.id)
                delete dataEditAll[String(detail.id)];
                let detailsDataAll = {};
                $.each(detailRow.find('.detail-row'), function(index, data) {
                    detailEl = detailRow.find(`tr#${index}`)
                    detailsDataAll[index] = {
                        'idheader': detailEl.find(`[name="idheader[]"]`).val(),
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

             
                dataEditAll[detail.id] = {
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
                    'details': detailsDataAll,

                };

              

            } else {
                let detailsDataAll = {};
                $.each(detailRow.find('.detail-row'), function(index, data) {
                    detailEl = detailRow.find(`tr#${index}`)
                    console.log(detailEl);
           
                    detailsDataAll[index] = {
                        'idheader': detailEl.find(`[name="idheader[]"]`).val(),
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

               

                dataEditAll[detail.id] = {
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
                    'details': detailsDataAll,

                };

                // console.log(dataEditAll);


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
                    pushEditedDataToObject(detailRowEditAll, detail)
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


                    // setTotal()
                    pushEditedDataToObject(detailRowEditAll, detail)
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

                    pushEditedDataToObject(detailRowEditAll, detail)
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

                        setTotalHargaEditAll(detailPerRow)
                    })

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


                    pushEditedDataToObject(detailRowEditAll, detail)
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
