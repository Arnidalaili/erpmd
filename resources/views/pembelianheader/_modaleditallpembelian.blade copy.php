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
                    
                    <table class="table table-bordered" id="editAllPembelian">
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

    $(document).ready(function() {

        $(document).on('change', `#editAllForm [id="tglpengirimanbeli"]`, function() {
            getAll(1, 10)
        });

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


            $.ajax({
                url: `${apiUrl}pembelianheader/processeditall`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    data: JSON.stringify(dataEditAll)
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
        initAutoNumeric(element.find(`[name="qty[]"]`).val(amountqty))
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

    function editAllPembelian() {
        let totalRows
        let lastPage
        let form = $('#editAllModal')
        $('.modal-loader').removeClass('d-none')
        form.trigger('reset')
        form.find('#btnSubmitEditAll').html(`<i class="fa fa-save"></i>Simpan`)
        form.data('action', 'editall')
        form.find(`.sometimes`).hide()
        $('#editAllModalTitle').text('Edit All Product')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        var besok = new Date();
        besok.setDate(besok.getDate() + 1);
        $('#editAllForm').find('[name=tglpengirimanbeli]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
            'change');

        Promise
            .all([
                getAll(1, 10),
            ])
            .then((attributes) => {
                totalRowsEditAll = attributes[0].totalRows
                totalPages = attributes[0].totalPages

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
                url: `${apiUrl}pembelianheader/editall`,
                method: 'GET',
                dataType: 'JSON',
                data: {
                    page: page,
                    limit: 1,
                    sortIndex: 'nobukti',
                    sortOrder: 'asc',
                    tglpengirimanbeli: $('#editAllForm').find('[id=tglpengirimanbeli]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#editAll tbody').html('')
                    data = response.data
                    detailHeader = ["No", "tgl bukti", "No Bukti", "Supplier", "Karyawan", "tgl terima", "keterangan"]
                    subHeader = ["No", "product", "satuan", "Qty", "Qty Stok", "Qty Retur", "Qty Pesanan", "keterangan", "Harga", "total Harga"]

                    // initValue(data)
                    createTable(data, detailHeader, subHeader);

                    currentPage = page
                    totalPages = response.attributes.totalPages
                    totalRowsEditAll = response.attributes.totalRows

                    if (Object.keys(dataEditAll).length != 0) {
                            Object.keys(dataEditAll).forEach(function(key) {

                                var innerObject = dataEditAll[key];
                              
                                Object.keys(innerObject).forEach(function(innerKey) {
                                    if (innerKey == 'subtotal'  || innerKey ==
                                        'potongan' || innerKey ==
                                        'total' ) {
                                        let hargaJualEl = $(
                                            `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                                        )
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .remove()
                                        $(`#${key}edit`).find(`.${innerKey}`).append(
                                            hargaJualEl)
                                        initAutoNumericNoDoubleZero(hargaJualEl)
                                    } else if(innerKey == 'taxamount'){
                                        let hargaJualEls = $(
                                            `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                                        )
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .remove()

                                            $(`#${key}edit .tax`).find('.row .taxamount').append(
                                            hargaJualEls)
                                        initAutoNumericNoDoubleZero(hargaJualEls)
                                    }else {
                                        // console.log()
                                        $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                                            .val(innerObject[innerKey])

                                      
                                        if (innerObject.details) {
                                        Object.keys(innerObject.details).forEach(function(key2) {
                                            var innerDetail = innerObject.details[key2];

                                           
                                            Object.keys(innerDetail).forEach(function(innerKeyDetail) {

                                                if (innerKeyDetail == 'harga' || innerKeyDetail == 'totalharga'  ) {
                                                    let hargaJualEl = $(
                                                            `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                                                        )
                                                        $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`)
                                                            .remove()

                                                            $(`#${key}edit tr.detail-row`).find(`.${innerKeyDetail}`).append(
                                                            hargaJualEl)
                                                        initAutoNumericNoDoubleZero(hargaJualEl)
                                                    }else if (innerKeyDetail == 'qty' || innerKeyDetail == 'qtyretur' || innerKeyDetail == 'qty' || innerKeyDetail == 'qtystok' || innerKeyDetail == 'qtyretur' || innerKeyDetail == 'qtypesanan' ) {
                                                        let hargaJualEl = $(
                                                                `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                                                            )
                                                            $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`)
                                                                .remove()

                                                                $(`#${key}edit tr.detail-row`).find(`.${innerKeyDetail}`).append(
                                                                hargaJualEl)
                                                            initAutoNumeric(hargaJualEl)
                                                    }else{
                                                        $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`).val(innerDetail[innerKeyDetail])
                                                    }
                                            
                                            })
                                    })
                                }
                            }

                                });
                            });
                        }
                    // if (Object.keys(dataEditAll).length != 0) {
                    //         Object.keys(dataEditAll).forEach(function(key) {

                    //             var innerObject = dataEditAll[key];
                              
                    //             Object.keys(innerObject).forEach(function(innerKey) {
                    //                 if (innerKey == 'subtotal'  || innerKey ==
                    //                     'potongan' || innerKey ==
                    //                     'total' ) {
                    //                     let hargaJualEl = $(
                    //                         `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                    //                     )
                    //                     $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                    //                         .remove()
                    //                     $(`#${key}edit`).find(`.${innerKey}`).append(
                    //                         hargaJualEl)
                    //                     initAutoNumericNoDoubleZero(hargaJualEl)
                    //                 } else if(innerKey == 'taxamount'){
                    //                     let hargaJualEls = $(
                    //                         `<input type="text" name="${innerKey}[]" class="form-control autonumerics text-right" value="${innerObject[innerKey]}" autocomplete="off">`
                    //                     )
                    //                     $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                    //                         .remove()

                    //                         $(`#${key}edit .tax`).find('.row .taxamount').append(
                    //                         hargaJualEls)
                    //                     initAutoNumericNoDoubleZero(hargaJualEls)
                    //                 }else {
                    //                     // console.log()
                    //                     $(`#${key}edit`).find(`[name="${innerKey}[]"]`)
                    //                         .val(innerObject[innerKey])

                                      
                    //                     if (innerObject.details) {
                    //                     Object.keys(innerObject.details).forEach(function(key2) {
                    //                         var innerDetail = innerObject.details[key2];

                                           
                    //                         Object.keys(innerDetail).forEach(function(innerKeyDetail) {

                    //                             if (innerKeyDetail == 'harga' || innerKeyDetail == 'totalharga'  ) {
                    //                                 let hargaJualEl = $(
                    //                                         `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                    //                                     )
                    //                                     $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`)
                    //                                         .remove()

                    //                                         $(`#${key}edit tr.detail-row`).find(`.${innerKeyDetail}`).append(
                    //                                         hargaJualEl)
                    //                                     initAutoNumericNoDoubleZero(hargaJualEl)
                    //                                 }else if (innerKeyDetail == 'qty' || innerKeyDetail == 'qtyretur' || innerKeyDetail == 'qty' || innerKeyDetail == 'qtystok' || innerKeyDetail == 'qtyretur' || innerKeyDetail == 'qtypesanan' ) {
                    //                                     let hargaJualEl = $(
                    //                                             `<input type="text" name="${innerKeyDetail}[]" class="form-control autonumerics text-right" value="${innerDetail[innerKeyDetail]}" autocomplete="off">`
                    //                                         )
                    //                                         $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`)
                    //                                             .remove()

                    //                                             $(`#${key}edit tr.detail-row`).find(`.${innerKeyDetail}`).append(
                    //                                             hargaJualEl)
                    //                                         initAutoNumeric(hargaJualEl)
                    //                                 }else{
                    //                                     $(`#${key}edit`).find(`[name="${innerKeyDetail}[]"]`).val(innerDetail[innerKeyDetail])
                    //                                 }
                                            
                    //                         })
                    //                 })
                    //             }
                    //         }

                    //             });
                    //         });
                    //     }
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
                const tglterima = $.datepicker.formatDate('dd-mm-yy', new Date(entry.tglterima));
                const detailCells = [
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >

                    <div class="input-group"><input type="text" name="tglbuktieditall[]" id="tglbuktieditall${indexHeader}" class="form-control bg-white state-delete lg-form datepicker filled-row" value="${tglbukti}" readonly></div>`,
                    `<input type="text" name="nobukti[]" class="form-control bg-white state-delete lg-form filled-row" autocomplete="off" value="${entry.nobukti}" readonly />`,
                    createInputLookup("suppliernama", entry.suppliernama, 'supplierid', indexHeader, 'suppliereditall', entry.supplierid),
                    createInputLookup("karyawannama", entry.karyawannama, 'karyawanid', indexHeader, 'karyawaneditall', entry.karyawanid),
                    `<input type="hidden" name="id[]" class="form-control filled-row" value="${entry.id}" >
                    <div class="input-group"><input type="text" name="tglterima[]" id="tglterima${indexHeader}" class="form-control lg-form datepicker filled-row" value="${tglterima}"></div>`,
                    createInput("keterangan", entry.keterangan),
                ];

                table.append(detailRow);
                detailCells.forEach((cell) => detailRow.append($(`<td class='row-data${indexHeader}' style='width: 250px; min-width: 200px;'>`).append(
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

                $.each(entry.details, function(index, details) {
                    idDetailsLookup = `${indexHeader}-${index}`
                    const productRow = $(`<tr class="detail-row" id="${index}">`);
                    productRow.append($("<td>").text(index + 1));
                    const productCells = [
                        createInputLookup("productnama", details.productnama, 'productid',
                            idDetailsLookup, 'producteditall', details.productid, details.pesananfinaldetailid,
                            details.pesananfinalid, details.id, details.pembelianid, 'id'),
                        createInputLookup("satuannama", details.satuannama, 'satuanid',
                            idDetailsLookup,
                            'satuaneditall', details.satuanid),
                        ` <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >
                         <input type="hidden" name="originalqty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                        ` <input type="text" name="qtystok[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtystok}" >`,
                        ` <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtyretur}" >`,
                        ` <input type="text" name="qtypesanan[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qtypesanan}" >`,
                        createInputDetail("keterangandetail", details.keterangandetail),
                        ` <input type="text" name="harga[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.harga}" >`,
                        ` <input type="text" name="totalharga[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${details.totalharga}" readonly>`,
                    ];

                    productCells.forEach((cell) => {
                        const $cell = $("<td style='width: 250px; min-width: 200px;'>").append(cell);

                        // Cek apakah elemen input memiliki atribut 'name' yang sama dengan 'harga[]' atau 'totalharga[]'
                        if ($cell.find('[name="harga[]"]').length > 0) {
                            const hargaTdId = `harga${idDetailsLookup}`;
                            $cell.attr('id', hargaTdId);
                            $cell.addClass('harga');
                        } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                            const totalhargaTdId = `totalharga${idDetailsLookup}`;
                            $cell.attr('id', totalhargaTdId);
                            $cell.addClass('totalharga');
                        }else if($cell.find('[name="qty[]"]').length > 0){
                            const qty = `qty${idDetailsLookup}`;
                            $cell.addClass('qty');
                        }else if($cell.find('[name="qtystok[]"]').length > 0){
                            const qtystok = `qtystok${idDetailsLookup}`;
                            $cell.addClass('qtystok');
                        }else if($cell.find('[name="qtypesanan[]"]').length > 0){
                            const qtypesanan = `qtypesanan${idDetailsLookup}`;
                            $cell.addClass('qtypesanan');
                        }else if($cell.find('[name="qtyretur[]"]').length > 0){
                            const qtypesanan = `qtyretur${idDetailsLookup}`;
                            $cell.addClass('qtyretur');
                        }

                        productRow.append($cell);

                        if (details.pesananfinalid === 0 || details.pesananfinalid === null || details.pesananfinalid === undefined)
                        {
                            productRow.find('[name="qtystok[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="qtypesanan[]"]').prop('disabled', true).addClass('bg-white state-delete');
                        }

                        if (entry.nominalbayar > 0) {
                            detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                        }

                        if (details.pesananfinalid > 0) {
                            productRow.find('[name="qty[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="qtystok[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="qtypesanan[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="keterangandetail[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="satuannama[]"]').prop('disabled', true).addClass('bg-white state-delete');
                            productRow.find('[name="productnama[]"]').prop('disabled', true).addClass('bg-white state-delete');
                        }
                    });
                    table.append(productRow);

                    totalPrice += details.harga; // Accumulate the total price

                });


                // Display total price row
                const totalRow = $("<tr>");
                totalRow.append($('<td colspan="7">'));
                totalRow.append($('<td colspan="2" class="totalan">Subtotal:</td>'));

                totalRow.append($(
                    `<td class="subtotal"><input type="text" name="subtotal[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.subtotal}"></td>`
                ));

                table.append(totalRow);

                // Add additional row below the total row

                const potRow = $("<tr>");
                potRow.append($('<td colspan="7">'));
                potRow.append($('<td colspan="2" class="totalan">potongan:</td>'));

                potRow.append($(
                    `<td class="potongan"><input type="text" name="potongan[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" value="${entry.potongan}"></td>`
                ));

                table.append(potRow);

                const totalFinalRow = $("<tr>");
                totalFinalRow.append($('<td colspan="7">'));
                totalFinalRow.append($('<td colspan="2" class="totalan">Total:</td>'));

                totalFinalRow.append($(
                    `<td class="total"><input type="text" name="total[]" class="form-control lg-form filled-row autonumeric bg-white state-delete" autocomplete="off" value="${entry.total}" readonly></td>`
                ));
                table.append(totalFinalRow);
                tableContainer.append(table);

                $("#editAllTableBody").append(tableContainer);

                $.each(entry.details, function(index, details) {
                    idDetailsLookup = `${indexHeader}-${index}`
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
                        }
                    });


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

                table.on('input', 'input[name="qtypesanan[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="qtystok[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="potongan[]"]', function() {

                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    setTotalEditAll(parentEl)
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="qty[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setTotalHargaEditAll(childEl)
                        setQtyPesanan(childEl)
                    })
                    setSubTotalEditAll(parentEl)
                    setTotalEditAll(parentEl)
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="qtyretur[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setQty(childEl)
                        setTotalHargaEditAll(childEl)
                    })
                    setSubTotalEditAll(parentEl)
                    setTotalEditAll(parentEl)
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="keterangandetail[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="pesananfinalid[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="pesananfinaldetailid[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="harga[]"]', function() {
                    parentEl = $(this).parents(`table#${entry.id}edit`)
                    $.each(parentEl.find('.detail-row'), function(index, data) {
                        childEl = parentEl.find(`tr#${index}`)
                        setTotalHargaEditAll(childEl)
                    })

                    setSubTotalEditAll(parentEl)
                    setTotalEditAll(parentEl)
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="nobukti[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="karyawannama[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="tglterima[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                table.on('input', 'input[name="keterangan[]"]', function() {
                    pushEditedDataToObject($(this).parents(`table#${entry.id}edit`), entry)
                })

                if (entry.nominalbayar > 0) {
                    // Disable all input elements in detailRow
                    detailRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    table.find('.ui-datepicker-trigger').attr('disabled', true);
                    totalRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    potRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
                    totalFinalRow.find('input').prop('disabled', true).addClass('bg-white state-delete');
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


    function pushEditedDataToObject(detailRow, detail) {

        if (dataEditAll.hasOwnProperty(String(detail.id))) {
            delete dataEditAll[String(detail.id)];
            let detailsDataAll = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)
                detailsDataAll[index] = {
                    'idheader': detailEl.find(`[name="idheader[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
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


            dataEditAll[detail.id] = {
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
                'details': detailsDataAll,

            };


        } else {
            let detailsDataAll = {};
            $.each(detailRow.find('.detail-row'), function(index, data) {
                detailEl = detailRow.find(`tr#${index}`)
                detailsDataAll[index] = {
                    'idheader': detailEl.find(`[name="idheader[]"]`).val(),
                    'iddetail': detailEl.find(`[name="iddetail[]"]`).val(),
                    'pesananfinalid': detailEl.find(`[name="pesananfinalid[]"]`).val(),
                    'pesananfinaldetailid': detailEl.find(`[name="pesananfinaldetailid[]"]`).val(),
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



            dataEditAll[detail.id] = {
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
                'details': detailsDataAll,
            };
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

    function createInputLookup(name, value, id, selectIndex, initLookup, statusid, pesananfinaldetailid, pesananfinalid, valueid2, idheader, id2 = '') {
        if (id2 != '') {

            return $(
                ` <input type="hidden" name="pesananfinalid[]" class="form-control filled-row" value="${pesananfinalid}" >
                <input type="hidden" name="pesananfinaldetailid[]" class="form-control filled-row" value="${pesananfinaldetailid}" >
                <input type="hidden" name="idheader[]" class="form-control filled-row" value="${idheader}" >
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
                pushEditedDataToObject(detailRowEditAll, detail)
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