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
        let productRowElement;

        let jumlahMasterPenjualan = 0;
        let karyawanid = `{{ auth()->user()->karyawanid }}`


        $(document).ready(function() {
            $('#editAllModalPenjualan').on('change', `[id="tglpengirimanjual"]`, function() {
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
                let details = []

                $.each(selectedRows, (index, row) => {
                    console.log(row);
                    // $('.detail-row').each((index, row2) => {
                    selectedId = $('.detail-row').data('selectedrow');
                    const selectedElement = $('.detail-row').filter(function() {
                        return $(this).data('selectedrow') == row;
                    });

                    details[row] = {
                        id: selectedElement.find(`[name="check[]"]`).val(),
                        pesananfinalid: selectedElement.find(`[name="idheader[]"]`).val(),
                        pesananfinaldetailid: selectedElement.find(`[name="iddetail[]"]`).val(),
                        productid: selectedElement.find(`[name="productid[]"]`).val(),
                        customerid: selectedElement.find(`[name="customeridheader[]"]`).val(),
                        qty: AutoNumeric.getNumber(selectedElement.find(`[name="qty[]"]`)[0]),
                        satuanid: selectedElement.find(`[name="satuanid[]"]`).val(),
                        keterangan: selectedElement.find(`[name="keterangan[]"]`).val(),
                        cekpesanandetail: selectedElement.find(`[name="cekpesanandetail[]"]`)
                            .val(),
                    };

                    // details.push(detail);
                    // });
                });

                const detail = details.reduce((acc, item, index) => {
                    acc[index] = item;
                    return acc;
                }, {});

                // Stringify the array
                const jsonString = JSON.stringify(details);

                detailsDataAll.push({
                    name: 'detail',
                    value: jsonString
                });

                detailsDataAll.push({
                    name: 'periode',
                    value: $('#editAllFormPenjualan').find(
                            '[name=tglpengirimanjual]').val()
                });

                

                $.ajax({
                    url: `${apiUrl}cekpesanan`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: detailsDataAll,
                    success: response => {
                        $('#editAllModalPenjualan').modal('hide')
                        // $('#editAllTableBodyPenjualanIndex').empty();

                        //  $('#editAllTableBodyPenjualanIndex').remove()
                        //  editAllPenjualanIndex()
                        //  window.location.reload();
                      
                        // $('#editAllPenjualanIndex tbody').html('')
                        // getAllPenjualanIndex(1, 10)


                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,
                        }).trigger('reloadGrid');

                        selectedRows = []
                        dataEditAllPenjualan = {}
                    },
                    error: error => {
                        console.log(error);
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            $.each(error.responseJSON.errors, (index, error) => {
                                let indexes = index.split(".");
                                let element;

                                if (indexes.length > 1) {
                                    element = $('#editAllFormPenjualan').find(
                                        `.header${indexes[0]} [name="${indexes[2]}"]`
                                    )[indexes[3]];

                                } else {
                                    element = $('#editAllFormPenjualan').find(
                                        `.header${indexes[0]} [name="${indexes[2]}"]`
                                    )[0];
                                }

                                if ($(element).length > 0 && !$(element).is(
                                        ":hidden")) {
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

            // getMaxLength(form)
            initDatepicker()

        });
        $('#editAllModalPenjualan').on('hidden.bs.modal', () => {
            activeGrid = '#jqGrid'

            $('#editAllModalPenjualan').find('.modal-body').html(modalBodyEditAllPenjualan)
            $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
            jumlahMasterPenjualan = 0
            selectedRows = []
            selectedRowDetail = []
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
                // .trigger(
                //     'change');

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
                    url: `${apiUrl}cekpesanan/findallpenjualan`,
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        page: page,
                        limit: limit,
                        sortIndex: 'nobukti',
                        sortOrder: 'desc',
                        tglpengirimanjual: $('#editAllFormPenjualan').find('[id=tglpengirimanjual]').val(),
                        karyawanid: karyawanid
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

                        subHeader = ['', "product", "satuan", "Qty", "keterangan"]

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

                    subHeaderCellsPenjualan.forEach((cellText, index) => {
                        let thElement;
                        if (index === 0) {
                            let checkInput = $('<input>', {
                                type: 'checkbox',
                                class: 'checkbox-table check-all',
                                pesananfinalid: entry.pesananfinalid,
                                id: 'selectAllCheckbox',
                                onchange: 'handlerSelectAll(this)'
                            });
                            thElement = $("<th>").addClass("check").append(checkInput);
                        } else if (index === 4) {
                            thElement = $("<th>").attr('colspan', 3).text(cellText);
                        } else {
                            thElement = $("<th>").text(cellText);
                        }
                        subHeaderRowPenjualan.append(thElement);
                    });

                    tablePenjualan.append(subHeaderRowPenjualan);

                    let totalPricePenjualan = 0;
                    // detail
                    $.each(entry.details, function(index, details) {
                        idDetailsLookupPenjualan = `${indexHeader}-${index}`
                        const productRowPenjualan = $(
                            `<tr class="detail-row data-detail" data-selectedrow="${details.pesananfinaldetailid}" id="${idDetailsLookupPenjualan}">`
                        );

                        let check =
                            `<input type="checkbox" id="check[]" name="check[]" value="${details.pesananfinaldetailid}" pesananfinalid="${entry.pesananfinalid}" class="checkbox-table" onchange="checkboxHandler(this)">`;
                        productRowPenjualan.append('<td class="row-number">' + check + '</td>');

                        const productCellsPenjualan = [

                            createInputLookupPenjualan("productnama", details.productnama, 'productid',
                                idDetailsLookupPenjualan, 'producteditall', details.productid, details
                                .pesananfinaldetailid || 0, details.id, 'id'),
                            createInputLookupPenjualan("satuannama", details.satuannama, 'satuanid',
                                idDetailsLookupPenjualan,
                                'satuaneditall', details.satuanid),
                            `  <input type="hidden" name="iddetail[]" class="form-control iddetail filled-row" value="${details.pesananfinaldetailid}" >
                            <input type="hidden" name="idheader[]" class="form-control idheader filled-row" value="${entry.pesananfinalid}" >
                            <input type="hidden" name="customeridheader[]" class="form-control idheader filled-row" value="${entry.customerid}" >
                            <input type="text" name="qty[]" class="form-control lg-form filled-row autonumeric " autocomplete="off" value="${details.qty}" >`,
                            `<input type="hidden" name="cekpesanandetail[]" class="form-control lg-form filled-row " autocomplete="off"  value="${details.cekpesanandetail}">
                             <input type="text" name="keterangan[]" class="form-control lg-form filled-row " autocomplete="off" value="${details.keterangandetail}">`,
                        ];

                        productCellsPenjualan.forEach((cell, index) => {
                            let widthStyle = '';
                            let minWidthStyle = '';
                            let colspan = '';
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
                                colspan = 3;
                            } else if (index === 4) {
                                widthStyle = 'width: 45px;';
                                minWidthStyle = 'min-width: 600px;';
                                // colspan = 3;
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

                            const $cell = $(
                                `<td style='${widthStyle} ${minWidthStyle}' colspan='${colspan}'>`
                            ).append(cell);
                            if ($cell.find('[name="harga[]"]').length > 0) {
                                const hargaTdId = `harga${idDetailsLookupPenjualan}`;
                                $cell.attr('id', hargaTdId);
                                $cell.addClass('harga');
                            } else if ($cell.find('[name="totalharga[]"]').length > 0) {
                                const totalhargaTdId = `totalharga${idDetailsLookupPenjualan}`;
                                $cell.attr('id', totalhargaTdId);
                            }

                            productRowPenjualan.append($cell);

                            detailRow.find('[name="customernama[]"]').prop('readonly', true)
                                .addClass(
                                    'bg-white state-delete')
                            detailRow.find('[name="nobukti[]"]').prop('readonly', true)
                                .addClass(
                                    'bg-white state-delete')
                            detailRow.find('[name="keterangan[]"]').prop('readonly', true)
                                .addClass(
                                    'bg-white state-delete')
                            detailRow.find('[name="alamatpengiriman[]"]').prop('readonly', true)
                                .addClass(
                                    'bg-white state-delete')
                            detailRow.find('[name="tglpengirimaneditall[]"]').prop('readonly',
                                true).addClass(
                                'bg-white state-delete')
                            productRowPenjualan.find('[name="productnama[]"]').prop('readonly',
                                true).addClass(
                                'bg-white state-delete')
                            productRowPenjualan.find('[name="satuannama[]"]').prop('readonly',
                                true).addClass(
                                'bg-white state-delete')
                            productRowPenjualan.find('[name="qty[]"]').prop('readonly',
                                true).addClass(
                                'bg-white state-delete')


                            if (details.cekpesanandetail > 0) {
                                // console.log(details.cekpesananid);

                                productRowPenjualan.find('[name="check[]"]').attr('checked', true)
                                    .parents('tr').addClass('bg-light-blue');
                            }




                        });
                        tablePenjualan.append(productRowPenjualan);



                        totalPricePenjualan += details.harga;
                    });

                    tableContainerPenjualan.append(tablePenjualan);
                    $("#editAllTableBodyPenjualan").append(tableContainerPenjualan);


                    let jlhCeklist = 0
                    $.each(entry.details, function(index, details) {

                        idDetailsLookupPenjualan = `${indexHeader}-${index}`
                        initLookupDetailEditAllPenjualan(idDetailsLookupPenjualan, tablePenjualan, details)

                        if (details.cekpesanandetail > 0) {
                            // Pastikan detail ini belum ditambahkan sebelumnya ke dalam selectedRows
                            if (!selectedRows.includes(details.pesananfinaldetailid)) {
                                // Tambahkan cekpesananid ke dalam selectedRows
                                selectedRows.push(details.pesananfinaldetailid);

                                jlhCeklist++;
                            }
                        }

                    });


                    // let pesananFinalId = entry.pesananfinalid

                    if (entry.details.length == jlhCeklist) {
                        // console.log($('.check-all'));
                        //     selectAllRows($('.check-all'),pesananFinalId)

                        $(`.header${indexHeader} .sub-header-row`).find('.check-all').prop('checked', true)
                        // $('.check-all').prop('checked', true);
                        // console.log('ceklist semua');
                    }

                    // console.log("pesanan final id",pesananFinalId);
                    // console.log($(`[name="check[]"][pesananfinalid="${pesananFinalId}"]`));

                    console.log(entry.details.length, jlhCeklist)
                    // console.log(entry.details)
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


                    // $.each(parentTable.find('.detail-row'), function(index, data) {
                    //     childEl = $(data).attr('id');
                    //     detailPerRow = detailRowEditAll.find(`tr#${childEl}`)

                    //     setTotalHargaEditAllPenjualan(detailPerRow)
                    // })
                    // // console.log(parentTable);
                    // initAutoNumericNoDoubleZero(element.parents('tr').find('td [name="harga[]"]'))
                    // setSubTotalEditAllPenjualan(parentTable)
                    // setTaxEditAllPenjualan(parentTable)
                    // setTotalEditAllPenjualan(parentTable)

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
