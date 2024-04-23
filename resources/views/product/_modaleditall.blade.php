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
                            <div class="card card-easyui bordered mb-4">
                                <div class="card-header"></div>
                                <div class="card-body">
                                    <div class="row form-group">
                                        <div class="col-12 col-sm-3 col-md-2">
                                            <label class="col-form-label">
                                                tgl pengiriman
                                            </label>
                                        </div>
                                        <div class="col-sm-2 mb-2">
                                            <div class="input-group">
                                                <input type="text" name="tglpengiriman" id="tglpengiriman"
                                                    class="form-control lg-form datepicker filled-row">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col"> <!-- Menggunakan col tanpa spesifikasi ukuran -->
                                            <a id="btnReload" class="btn btn-primary mr-2">
                                                <i class="fas fa-sync-alt"></i>
                                                Reload
                                            </a>
                                            <a id="btnReset" class="btn btn-success">
                                                <i class="fas fa-sync-alt"></i>
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form class="form-inline">
                                <div class="form-group w-100 d-flex align-items-center px-2" id="titlesearch">
                                    <label for="searchText" class="mr-2 mt-2"
                                        style="font-weight: normal !important;">Search
                                        :</label>
                                    <input type="text" class="form-control form-control-sm global-search"
                                        id="searchText" placeholder="Search" autocomplete="off" style="width: 150px;">
                                </div>
                            </form>

                            <div class="table-container">
                                <table class="table table-lookup table-editall table-bindkeys " id="editAll">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%; min-width: 10px;">No.</th>
                                            <th style="width: 230px; min-width: 235px;">Nama</th>
                                            <th class="wider-qty text-right" style="width: 120px; min-width: 150px;">
                                                Harga Jual</th>
                                            <th class="wider-qty text-right" style="width: 120px; min-width: 150px;">
                                                Harga Beli</th>
                                            <th class="wider-qty" style="width: 170px; min-width: 235px;">Supplier</th>
                                            <th class="wider-keterangan" style="width: 20px; min-width: 135px;">Satuan
                                            </th>

                                        </tr>
                                        <tr class="filters">
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                </table>
                                <div class=" bg-white editAllPager overflow-x-hidden mt-3">

                                </div>
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
        var productId = []
        let dataEditAll = {}
        var currentPage = 0;
        var totalPages = 0;
        let itemsPerPage = 10;
        let selectedRowEditAll = null;
        let totalRowsEditAll = 0
        let lastPageEditAll
        let filterObject
        let firstPage = false;
        let tanggal
        let isReload = false
        let tglPengiriman = ''
        let currentRow 
       
        // let hargajualFilled = false;
        // let hargabeliFilled = false;



        $(document).ready(function() {
            let lengthValue = 0;
            
            $(document).on('click', '#btnReload', function(event) {
                let date = $('#editAllForm').find('[name=tglpengiriman]').val()
                tglPengiriman = date
                
                // getAll(1, 10, filterObject, date)
                // isReload = true

                Promise
                    .all([
                        getAll(1, 10, filterObject, date),

                    ])
                    .then((response) => {
                        
                        totalRowsEditAll = response[0].attributes.totalRows
                        totalPages = response[0].attributes.totalPages

                        lengthValue = response[0].detail.length;
                        // bindKeyPagerEditAll()
                        viewPageEdit(10,lengthValue)
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

            })


            $(document).on('click', '#btnReset', function(event) {
                date = $('#editAllForm').find('[name=tglpengiriman]').val()
                tglPengiriman = ''
                // getAll(1, 10, filterObject)
                Promise
                    .all([
                        getAll(1, 10, filterObject),
                    ])
                    .then((response) => {
                        $('#editAllForm').find('[name=tglpengiriman]').val('')

                        totalRowsEditAll = response[0].attributes.totalRows
                        totalPages = response[0].attributes.totalPages

                        viewPageEdit()
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
            })


            $('#btnSubmitEditAll').click(function(event) {
                event.preventDefault()
                console.log("submit", JSON.stringify(dataEditAll))
                let method
                let url
                let form = $('#editHargaJualForm')
                let action = form.data('action')


                $.ajax({
                    url: `${apiUrl}product/editall`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        data: JSON.stringify(dataEditAll)
                    },
                    success: response => {
                        dataEditAll = {}
                        hargajualFilled = false;
                        hargabeliFilled = false;
                        tglpengiriman = response.data;
                        $('#editHargaJualForm').trigger('reset')
                        $('#editAllModal').modal('hide')

                        if (tglpengiriman) {
                            showDialogEditAll(response.data, 'PRODUCT')
                        }


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
            isReload = false
            setFormBindKeys(form)
            activeGrid = null



            initDatepicker()
            getMaxLength(form)

        })

        $('#editAllModal').on('hidden.bs.modal', () => {
            activeGrid = '#jqGrid'
            $(".filter-input").val("");
            $('#editAllModal').find('.modal-body').html(editAllModal)
            $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
            initDatepicker('datepickerIndex')
            filterObject = {}
            dataEditAll = {}
            hargajualFilled = false;
            hargabeliFilled = false;
            tglPengiriman = ''
        })


        function editAll() {

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
            besok.setDate(besok.getDate());
            $('#editAllForm').find('[name=tglpengiriman]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger(
                'change');


            Promise
                .all([
                    getAll(1, 10, filterObject, ''),
                ])

                .then((response) => {
                    // console.log($("#editAll tbody tr").length);
                    
                    totalRowsEditAll = response[0].attributes.totalRows
                    totalPages = response[0].attributes.totalPages

                    $('#editAllModal').modal('show')
                    lastPageEditAll = Math.ceil(totalRowsEditAll / itemsPerPage);

                    var targetCell = $('#editAll tbody tr:first td:eq(1)');
                    var focusedElementFirst = $('#editAll tbody tr:first td:eq(1) input.form-control.first0');

                    targetCell.addClass('selected-cell');

                    focusedElementFirst.focus();

                    let dataColumn = ['nama', 'hargajual', 'hargabeli', 'suppliernama', 'satuannama']
                    tanggal = $('#editAllForm').find('[name=tglpengiriman]').val()

                    filtersEditAll(dataColumn)
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
            initAutoNumericNoDoubleZero(form.find(`[name="hargajual"]`))

        }

        function getAll(page, limit = 10, filters = [], date = '') {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}product/getproductall`,
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        page: page,
                        limit: limit,
                        sortIndex: 'nama',
                        sortOrder: 'asc',
                        filters: JSON.stringify(filters),
                        tglpengiriman: tglPengiriman
                    },
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        // console.log(response);
                        $('#editAll tbody').html('')

                        let selectIndex;
                        let previousRowIndex = 0;
                        let rowtr = 1;
                        let coltr = 1;

                        var inputStatus = {};

                        let totalData = response.attributes.totalRows;
                        let totalPages = Math.ceil(totalData / limit);

                        totalPageCount = totalPages;


                        lengthValue = response.detail.length

                        if (response.detail.length === 0) {
                            $('#editAll tbody').append(
                                '<tr><td colspan="6" style="text-align:center;" >No data available</td></tr>'
                            );
                        } else {

                            $.each(response.detail, (index, detail) => {

                                selectIndex = index;
                                let detailRow = $(`
                            <tr id="${detail.id}edit">
                               
                            <td  class="table-bold">
                            </td>
                            <td  class="table-bold" >
                                <input type="hidden" name="id[]" class="form-control filled-row" value="${detail.id}" >
                                <input type="text" name="nama[]" class="form-control first${selectIndex}" autocomplete="off">
                            </td>
                            <td  class="table-bold hargajual"> 
                                <input type="text" name="hargajual[]" class="form-control autonumerics text-right" value="0" autocomplete="off">
                            </td>
                            <td  class="table-bold hargabeli"> 
                                <input type="text" name="hargabeli[]" class="form-control  autonumerics text-right" value="0">
                            </td>
                            <td  class="table-bold "> 
                                <input type="hidden" name="supplierid[]" class="filled-row">
                                <input type="text" name="suppliernama[]" id="suppliernama${selectIndex}" class="form-control lg-form supplier-lookup-editall${selectIndex} filled-row" autocomplete="off">
                            </td>
                            <td  class="table-bold"> 
                                <input type="hidden" name="satuanid[]" class="filled-row">
                                <input type="text" name="satuannama[]" id="satuannama${selectIndex}" class="form-control lg-form satuan-lookup-editall${selectIndex} filled-row" autocomplete="off">
                            </td>
                            
                        </tr>`)

                                inputStatus[detail.id] = {
                                    'hargajualFilled': false,
                                    'hargabeliFilled': false
                                };

                                detailRow.find(`[name="nama[]"]`).val(detail.nama)
                                detailRow.find(`[name="supplierid[]"]`).val(detail.supplierid)
                                detailRow.find(`[name="suppliernama[]"]`).val(detail
                                    .suppliernama)
                                detailRow.find(`[name="hargajual[]"]`).val(detail.hargajual)
                                detailRow.find(`[name="satuanid[]"]`).val(detail.satuanid)
                                detailRow.find(`[name="satuannama[]"]`).val(detail.satuannama)
                                detailRow.find(`[name="hargabeli[]"]`).val(detail.hargabeli)
                                initAutoNumericNoDoubleZero(detailRow.find(
                                    `[name="hargajual[]"]`))
                                initAutoNumericNoDoubleZero(detailRow.find(
                                    `[name="hargabeli[]"]`))

                                if (detail.pesananfinaldetailid == 'ada' || detail
                                    .penjualandetailid == 'ada' || detail.pembeliandetailid ==
                                    'ada'
                                ) {
                                    detailRow.addClass('pesananfinaldetail-ada');

                                    detailRow.find(`[name="nama[]"]`).prop('disabled', true)
                                        .addClass('bg-white state-delete')
                                }

                                // EVENT ON INPUT
                                detailRow.on('input', 'input[name="nama[]"]', function() {

                                    pushEditedDataToObject(detailRow, detail)

                                    $(this).focus();

                                })

                                detailRow.on('input', 'input[name="groupnama[]"]', function() {
                                    pushEditedDataToObject(detailRow, detail)

                                })

                                detailRow.on('input', 'input[name="hargajual[]"]', function() {
                                    inputStatus[detail.id]['hargajualFilled'] = $(this)
                                        .val().trim() !== '';
                                    // pushEditedDataToObject(detailRow, detail,'hargajual',hargajualFilled)
                                    pushEditedDataToObject(detailRow, detail,
                                        inputStatus[
                                            detail.id]);


                                })

                                detailRow.on('input', 'input[name="hargabeli[]"]', function() {
                                    inputStatus[detail.id]['hargabeliFilled'] = $(this)
                                        .val().trim() !== '';
                                    // pushEditedDataToObject(detailRow, detail,'hargabeli',hargabeliFilled)
                                    pushEditedDataToObject(detailRow, detail,
                                        inputStatus[
                                            detail.id]);
                                })

                                detailRow.on('input', 'input[name="satuannama[]"]', function() {
                                    pushEditedDataToObject(detailRow, detail)
                                })



                                bindkeyMovementEditAll('editAll', page, $("#editAllModal"))

                                $('#editAll tbody').append(detailRow)


                                previousRowIndex = previousRowIndex + 1;

                                rowIndex = index

                                setRowNumbersEdit(page, $("#rowList").val());




                                initLookupDetail(rowIndex, detailRow, detail);
                                rowtr++;
                                coltr = 1;
                            })
                        }



                        currentPage = page
                        totalPages = response.attributes.totalPages
                        totalRowsEditAll = response.attributes.totalRows

                        if (Object.keys(dataEditAll).length != 0) {
                            Object.keys(dataEditAll).forEach(function(key) {

                                var innerObject = dataEditAll[key];
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

                        resolve(response)

                    },
                    error: error => {

                        reject(error)
                    },
                })
            })




        }




        function bindKeyPage(currentPageParams, totalPagesParams) {
            var currentPage = currentPageParams;
            var totalPages = totalPagesParams;

            getAll(currentPage);

        }


        function pushEditedDataToObject(detailRow, detail, status) {
            var rowId = detail.id; // ID baris
            var hargajualFilled = status && status.hargajualFilled;
            var hargabeliFilled = status && status.hargabeliFilled;

            var fullfilled = ''; // Inisialisasi fullfilled

            // Tentukan nilai fullfilled berdasarkan status input hargajual dan hargabeli
            if (hargajualFilled && hargabeliFilled) {
                fullfilled = 'hargajualbeli';
            } else if (hargajualFilled) {
                fullfilled = 'hargajual';
            } else if (hargabeliFilled) {
                fullfilled = 'hargabeli';
            }


            if (dataEditAll.hasOwnProperty(String(detail.id))) {
                delete dataEditAll[String(detail.id)];
                dataEditAll[detail.id] = {
                    'id': detailRow.find(`[name="id[]"]`).val(),
                    'nama': detailRow.find(`[name="nama[]"]`).val(),
                    'groupid': detailRow.find(`[name="groupid[]"]`).val(),
                    'groupnama': detailRow.find(`[name="groupnama[]"]`).val(),
                    'supplierid': detailRow.find(`[name="supplierid[]"]`).val(),
                    'suppliernama': detailRow.find(`[name="suppliernama[]"]`).val(),
                    'satuanid': detailRow.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailRow.find(`[name="satuannama[]"]`).val(),
                    'hargajual': parseFloat(detailRow.find(`[name="hargajual[]"]`).val().replace(/,/g, '')),
                    'hargabeli': parseFloat(detailRow.find(`[name="hargabeli[]"]`).val().replace(/,/g, '')),
                    'fullfilled': fullfilled
                };
            } else {

                dataEditAll[detail.id] = {
                    'id': detailRow.find(`[name="id[]"]`).val(),
                    'nama': detailRow.find(`[name="nama[]"]`).val(),
                    'groupid': detailRow.find(`[name="groupid[]"]`).val(),
                    'groupnama': detailRow.find(`[name="groupnama[]"]`).val(),
                    'supplierid': detailRow.find(`[name="supplierid[]"]`).val(),
                    'suppliernama': detailRow.find(`[name="suppliernama[]"]`).val(),
                    'satuanid': detailRow.find(`[name="satuanid[]"]`).val(),
                    'satuannama': detailRow.find(`[name="satuannama[]"]`).val(),
                    'hargajual': parseFloat(detailRow.find(`[name="hargajual[]"]`).val().replace(/,/g, '')),
                    'hargabeli': parseFloat(detailRow.find(`[name="hargabeli[]"]`).val().replace(/,/g, '')),
                    'fullfilled': fullfilled
                };
            }
        }


        function setRowNumbersEdit(page, itemsPerPage = 10) {
            let elements = $('#editAll tbody tr td:nth-child(1)')


            elements.each((index, element) => {
                let currentPage = page || 1;

                currentRow = index + 1 + (currentPage - 1) * itemsPerPage; // Nomor urut pada halaman saat ini
                $(element).text(currentRow);
            });
        }

        function initLookupDetail(index, detailRow, detail) {
            let rowLookup = index;

            $(`.group-lookup-editall${rowLookup}`).lookup({
                title: 'Group Lookup',
                fileName: 'groupProduct',
                detail: true,
                miniSize: true,
                searching: 1,
                beforeProcess: function() {
                    this.postData = {
                        Aktif: 'AKTIF',
                        searching: 1,
                        valueName: `ItemId_${index}`,
                        id: `ItemId_${rowLookup}`,
                        searchText: `group-lookup-editall${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'Group',
                        groupid: $('#editAll').find('[name=groupid]').val(),
                        // limit: 0
                        // typeSearch: 'ALL',
                    };
                },
                onSelectRow: (group, element) => {
                    let groupid = element.parents('td').find(`[name="groupid[]"]`);
                    groupid.val(group.id);

                    element.addClass('filled-row')
                    groupid.addClass('filled-row')
                    element.data('currentValue', element.val());

                    element.val(group.nama);
                    pushEditedDataToObject(detailRow, detail)

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

            $(`.satuan-lookup-editall${rowLookup}`).lookup({
                title: 'Satuan Lookup',
                fileName: 'satuan',
                detail: true,
                miniSize: true,
                rowIndex: rowLookup,
                totalRow: 49,
                alignRightMobile: true,
                alignRight: true,
                searching: 1,
                beforeProcess: function() {
                    this.postData = {
                        Aktif: 'AKTIF',
                        searching: 1,
                        valueName: `satuanId_${index}`,
                        id: `SatuanId_${rowLookup}`,
                        searchText: `satuan-lookup-editall${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'Satuan',
                        limit: 0
                    };
                },
                onSelectRow: (satuan, element) => {
                    let satuanid = element.parents('td').find(`[name="satuanid[]"]`);
                    satuanid.val(satuan.id);


                    element.val(satuan.nama);

                    element.addClass('filled-row')
                    satuanid.addClass('filled-row')
                    element.data('currentValue', element.val());

                    pushEditedDataToObject(detailRow, detail)
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let satuanid = element.parents('td').find(`[name="satuanid[]"]`).first();
                    satuanid.val('');
                    element.val('');
                    element.data('currentValue', element.val());
                },
            });

            $(`.supplier-lookup-editall${rowLookup}`).lookup({
                title: 'Supplier Lookup',
                fileName: 'supplier',
                detail: true,
                miniSize: true,
                rowIndex: rowLookup,
                totalRow: 49,
                alignRightMobile: true,
                searching: 1,
                beforeProcess: function() {
                    this.postData = {
                        Aktif: 'AKTIF',
                        searching: 1,
                        valueName: `supplierid${index}`,
                        id: `supplierid${rowLookup}`,
                        searchText: `supplier-lookup-editall${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'Supplier'
                    };
                },
                onSelectRow: (supplier, element) => {
                    let supplierid = element.parents('td').find(`[name="supplierid[]"]`);
                    supplierid.val(supplier.id);


                    element.val(supplier.nama);

                    element.addClass('filled-row')
                    supplierid.addClass('filled-row')
                    element.data('currentValue', element.val());

                    pushEditedDataToObject(detailRow, detail)
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let supplierid = element.parents('td').find(`[name="supplierid[]"]`).first();
                    supplierid.val('');
                    element.val('');
                    element.data('currentValue', element.val());
                },
            });
        }
    </script>
@endpush()
