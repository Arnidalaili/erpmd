<div class="modal modal-fullscreen" id="editAllTransaksiArmadaModal" tabindex="-1"
    aria-labelledby="editAllTransaksiArmadaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="editAllTransaksiArmadaForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="editAllTransaksiArmadaModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card card-easyui bordered mb-4">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="tgldarieditall" id="tgldarieditall"
                                            class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="col-sm-1 mt-2 text-center">
                                    <label class="mt-2">s/d</label>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="tglsampaieditall" id="tglsampaieditall"
                                            class="form-control datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mt-4 mb-4">
                                    <a id="btnReloadEditAll" class="btn btn-primary mr-2 ">
                                        <i class="fas fa-sync-alt"></i>
                                        Reload
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table class="table table-bordered " id="editAllTransaksiArmada">
                        <thead>
                            <tr>

                            </tr>
                        </thead>
                        <tbody id="editAllTransaksiArmadaTableBody"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">

                                </td>
                                <td>
                                    <h5 id="total" class="text-right font-weight-bold"></h5>
                                </td>
                                <td class="tbl_aksi">
                                    <button type="button" class="btn btn-primary btn-sm my-2"
                                        id="addRow">Tambah</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class=" bg-white editAllTransaksiArmadaPager overflow-x-hidden mt-3">
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button id="btnSubmiteditAllTransaksiArmada" class="btn btn-primary">
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
        let hasFormBindKeyseditAllTransaksiArmada = false
        let modalBodyeditAllTransaksiArmada = $('#editAllTransaksiArmadaModal').find('.modal-body').html()
        let selectIndex = 0
        let rowIndex = 0
        let deletedId = []

        $(document).ready(function() {

            $("#editAllTransaksiArmadaForm [name]").attr("autocomplete", "off");

            $(document).on('click', '.delete-row', function(event) {
                storeDeletedId($(this).parents('tr'))
                deleteRow($(this).parents('tr'))

            })

            $(document).on('click', "#addRow", function() {
                event.preventDefault()
                let method = `POST`
                let url = `${apiUrl}transaksiarmada/addrow`
                let form = $('#editAllTransaksiArmadaForm')
                let Id = form.find('[name=id]').val()
                let action = form.data('action')
                let data = $('#editAllTransaksiArmadaForm').serializeArray()
                let details = []

                let tgldariheader = $('#tgldarieditall').val();
                let tglsampaiheader = $('#tglsampaieditall').val()

                $('#editAllTransaksiArmadaTableBody tr.filled-row').each((index, element) => {
                    let elForm = $("#editAllTransaksiArmadaForm")


                    if (!$(element).find(`input`).is(':disabled')) {
                        details[index] = {
                            id: $(element).find(`[name="id[]"]`).val(),
                            tglbukti: $(element).find(`[name="tglbukti[]"]`).val(),
                            perkiraanid: $(element).find(`[name="perkiraanid[]"]`).val(),
                            perkiraannama: $(element).find(`[name="perkiraannama[]"]`).val(),
                            karyawanid: $(element).find(`[name="karyawanid[]"]`).val(),
                            karyawannama: $(element).find(`[name="karyawannama[]"]`).val(),
                            armadaid: $(element).find(`[name="armadaid[]"]`).val(),
                            armadanama: $(element).find(`[name="armadanama[]"]`).val(),
                            nominal: parseFloat($(element).find(`[name="nominal[]"]`).val()
                                .replace(/,/g, '')),
                            keterangan: $(element).find(`[name="keterangan[]"]`).val(),
                        };

                    }
                });
                const detail = details.reduce((acc, item, index) => {
                    acc[index] = item;
                    return acc;
                }, {});
                // Stringify the object
                const jsonString = JSON.stringify(detail);


                $.ajax({
                    url: url,
                    method: method,
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        data: jsonString,
                    },
                    success: response => {
                        addRow()
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()
                            // console.log(error.responseJSON.errors);
                            setErrorMessagesNew(form, error.responseJSON.errors)
                        } else {
                            showDialog(error.responseJSON)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })

            });

            $(document).on('click', '#btnReloadEditAll', function(event) {
                showEditAllTransaksiArmada($('#editAllTransaksiArmadaForm'))
            })

            $('#btnSubmiteditAllTransaksiArmada').click(function(event) {
                console.log('submit');
                event.preventDefault()
                let method
                let url
                let form = $('#editAllTransaksiArmadaForm')
                let Id = form.find('[name=id]').val()
                let action = form.data('action')
                let data = $('#editAllTransaksiArmadaForm').serializeArray()
                let details = []

                let tgldariheader = $('#tgldarieditall').val();
                let tglsampaiheader = $('#tglsampaieditall').val()

                $('#editAllTransaksiArmadaTableBody tr.filled-row').each((index, element) => {
                    let elForm = $("#editAllTransaksiArmadaForm")

                    if (!$(element).find(`input`).is(':disabled')) {
                        details[index] = {
                            id: $(element).find(`[name="id[]"]`).val(),
                            tglbukti: $(element).find(`[name="tglbukti[]"]`).val(),
                            perkiraanid: $(element).find(`[name="perkiraanid[]"]`).val(),
                            perkiraannama: $(element).find(`[name="perkiraannama[]"]`).val(),
                            karyawanid: $(element).find(`[name="karyawanid[]"]`).val(),
                            karyawannama: $(element).find(`[name="karyawannama[]"]`).val(),
                            armadaid: $(element).find(`[name="armadaid[]"]`).val(),
                            armadanama: $(element).find(`[name="armadanama[]"]`).val(),
                            nominal: parseFloat($(element).find(`[name="nominal[]"]`).val()
                                .replace(/,/g, '')),
                            keterangan: $(element).find(`[name="keterangan[]"]`).val(),
                        };

                    }
                });
                const detail = details.reduce((acc, item, index) => {
                    acc[index] = item;
                    return acc;
                }, {});
                // Stringify the object
                const jsonString = JSON.stringify(detail);

                $(this).attr('disabled', '')
                $('#processingLoader').removeClass('d-none')

                $.ajax({
                    url: `${apiUrl}transaksiarmada/processeditall`,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        data: jsonString,
                        deletedId: deletedId
                    },
                    success: response => {
                        deletedId = []
                        id = response.data.id
                        $('#editAllTransaksiArmadaModal').find('#editAllTransaksiArmadaForm')
                            .trigger('reset')
                        $('#editAllTransaksiArmadaModal').modal('hide')

                        selectedRows = []

                        $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page,

                        }).trigger('reloadGrid');

                        if (id == 0) {
                            $('#detailGrid').jqGrid().trigger('reloadGrid')
                        }

                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessagesNew(form, error.responseJSON.errors);
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

        $('#editAllTransaksiArmadaModal').on('shown.bs.modal', () => {
            var editAllTransaksiArmadaModal = $('#editAllTransaksiArmadaModal')
            let form = $('#editAllTransaksiArmadaForm')
            setFormBindKeys(form)
            activeGrid = null

            getMaxLength(form)
            initDatepicker()
        });

        $('#editAllTransaksiArmadaModal').on('hidden.bs.modal', () => {
            selectedRows = []
            activeGrid = '#jqGrid'
            $('#editAllTransaksiArmadaModal').find('.modal-body').html(modalBodyeditAllTransaksiArmada)
            initDatepicker('datepickerIndex')
            $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
            $("#ui-datepicker-div").remove();
            deletedId = []
        })

        function editAllTransaksiArmada() {
            let form = $('#editAllTransaksiArmadaForm')
            $('.modal-loader').removeClass('d-none')

            form.data('action', 'edit')
            form.trigger('reset')
            form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Simpan
              `)
            form.find(`.sometimes`).hide()
            $('#editAllTransaksiArmadaModalTitle').text('input all transaksi armada')
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            var dari = new Date()
            dari.setDate(dari.getDate())
            form.find('[name=tgldarieditall]').val($.datepicker.formatDate('dd-mm-yy', dari)).trigger(
                'change');

            var sampai = new Date()
            sampai.setDate(sampai.getDate())
            form.find('[name=tglsampaieditall]').val($.datepicker.formatDate('dd-mm-yy', sampai)).trigger(
                'change');

            Promise
                .all([
                    showEditAllTransaksiArmada(form)
                ])
                .then(() => {
                    $('#editAllTransaksiArmadaModal').modal('show')
                    let countRow = $('.delete-row').parents('tr').length
                    if (countRow == 0) {
                         addRow()
                    }
                   
                })
                .catch((error) => {
                    showDialog(error.responseJSON)
                })
                .finally(() => {
                    $('.modal-loader').addClass('d-none')
                })
        }

        function showEditAllTransaksiArmada(form) {
            return new Promise((resolve, reject) => {
                $('#editAllTransaksiArmada tbody').html('')

                $.ajax({
                    url: `${apiUrl}transaksiarmada/editall`,
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        tgldariheader: form.find('[id=tgldarieditall]').val(),
                        tglsampaiheader: form.find('[id=tglsampaieditall]').val(),
                    },
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        $.each(response.data, (index, value) => {
                            let element = form.find(`[name="${index}"]`)

                        })
                        // $('#editAllTransaksiArmada tbody').html('')


                        if (detectDeviceType() == "desktop") {
                            $('#editAllTransaksiArmada thead tr').html('')
                            let tableHeader = $(`
                                <th scope="col" width="1%">No</th>
                                <th scope="col" style="width: 150px; min-width: 150px;">tgl bukti</th>
                                <th scope="col" style="width: 280px; min-width: 280px;">perkiraan</th>
                                <th scope="col" style="width: 280px; min-width: 280px;">karyawan</th>
                                <th scope="col" style="width: 250px; min-width: 250px;">armada</th>
                                <th scope="col" style="width: 150px; min-width: 150px;">nominal</th>
                                <th scope="col">keterangan</th>
                                <th scope="col" class="tbl_aksi" width="1%">Aksi</th>

                                `);

                            // Sisipkan elemen <th> di awal baris
                            $('#editAllTransaksiArmada thead tr').prepend(tableHeader);

                            $.each(response.data, (index, detail) => {
                                let detailRow = $(`
                            <tr class="filled-row">
                                <td> </td>
                                <td>
                                <div class="input-group">
                                    <input type="hidden" name="id[]" class="form-control">
                                    <input type="text" name="tglbukti[]" class="form-control datepicker">
                                </div>
                                </td>
                                <td>
                                    <input type="hidden" name="perkiraanid[]" class="form-control filled-row detail_stok_${index}">
                                    <input type="text" name="perkiraannama[]" id="perkiraanid${index}" class="form-control filled-row lg-form perkiraaneditall-lookup${index}" autocomplete="off">
                                </td>
                                <td>
                                    <input type="hidden" name="karyawanid[]" class="form-control filled-row detail_stok_${index}">
                                    <input type="text" name="karyawannama[]" id="perkiraanid${index}" class="form-control filled-row lg-form karyawaneditall-lookup${index}" autocomplete="off">
                                </td>
                                <td>
                                    <input type="hidden" name="armadaid[]" class="form-control filled-row detail_stok_${index}">
                                    <input type="text" name="armadanama[]" id="armadaid${index}" class="form-control filled-row lg-form armadaeditall-lookup${index}" autocomplete="off">
                                </td>
                                <td>
                                <input type="text" name="nominal[]"  class="form-control autonumeric">
                                </td>
                                <td>
                                    <input type="text" name="keterangan[]"  class="form-control" > 
                                </td>
                                <td class="tbl_aksi" >
                                <button class='btn btn-danger btn-sm delete-row '>Hapus</button>
                                </td>
                            </tr>
                            `)

                                detailRow.find(`[name="tglbukti[]"]`).val(dateFormat(detail
                                    .tglbukti))
                                detailRow.find(`[name="id[]"]`).val(detail.id)
                                detailRow.find(`[name="perkiraanid[]"]`).val(detail.perkiraanid)
                                detailRow.find(`[name="perkiraannama[]"]`).val(detail
                                    .perkiraannama)
                                detailRow.find(`[name="karyawanid[]"]`).val(detail.karyawanid)
                                detailRow.find(`[name="karyawannama[]"]`).val(detail
                                    .karyawannama)
                                detailRow.find(`[name="armadaid[]"]`).val(detail.armadaid)
                                detailRow.find(`[name="armadanama[]"]`).val(detail.armadanama)
                                detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
                                detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)

                                initAutoNumericNoDoubleZero(detailRow.find(
                                    `[name="nominal[]"]`))

                                bindkeyMovementEditAllTransaksi('editAllTransaksiArmada', 1, $(
                                    "#editAllTransaksiArmadaModal"))

                                $('#editAllTransaksiArmada>#editAllTransaksiArmadaTableBody')
                                    .append(detailRow)

                                rowIndex = index
                                initLookupDetail(rowIndex);
                                initDatepicker()

                                detailRow.find('.datepicker').prop('readonly', true).addClass(
                                    'bg-white state-delete')
                                detailRow.find('.ui-datepicker-trigger').prop('disabled', true)

                            })
                            setRowNumber()
                            if (form.data('action') === 'delete') {
                                form.find('[name]').addClass('disabled')
                                initDisabled()
                            }
                        } else if (detectDeviceType() == "mobile") {
                            $('#editAllTransaksiBelanja thead tr').html('')
                            let tableHeader = $(`
                                <th style="width: 500px; min-width: 250px;">No.</th>

                                `);

                            // Sisipkan elemen <th> di awal baris
                            $('#editAllTransaksiArmada thead tr').prepend(tableHeader);

                            let newTfoot = $(`
                                    <tfoot>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm my-2"
                                                id="addRow">Tambah</button>


                                        </td>
                                    </tr>
                                    </tfoot>
                                `);

                            $('#editAllTransaksiArmada tfoot').replaceWith(newTfoot);

                            $.each(response.data, (index, detail) => {
                                let detailRowMobile = $(`
                                <tr class="filled-row">
                                    
                                <td class="table-bold">
                                    <div class="d-flex align-items-center">
                                        <div class="row">
                                        <div class="col-6">
                                            <label class="col-form-label mt-2 label-mobile label-top">${index+1}. &ensp; TGL BUKTI</label>
                                            <div class="input-group">
                                            <input type="hidden" name="id[]" class="form-control">
                                            <input type="text" name="tglbukti[]" class="form-control datepicker">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-form-label mt-2 label-mobile" min-width: 50px;">PERKIRAAN</label>
                                            <input type="hidden" name="perkiraanid[]" class="form-control filled-row detail_stok_${index}">
                                    <input type="text" name="perkiraannama[]" id="perkiraanid${index}" class="form-control filled-row lg-form perkiraaneditall-lookup${index}" autocomplete="off">
                                        </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="row">
                                        <div class="col-6">
                                            <label class="col-form-label mt-2 mb-2">KARYAWAN</label>
                                            <div class="input-group">
                                                <input type="hidden" name="karyawanid[]" class="form-control filled-row detail_stok_${index}">
                                                <input type="text" name="karyawannama[]" id="perkiraanid${index}" class="form-control filled-row lg-form karyawaneditall-lookup${index}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label class="col-form-label mt-2 mb-2" min-width: 50px;">ARMADA</label>
                                            <input type="hidden" name="armadaid[]" class="form-control filled-row detail_stok_${index}">
                                            <input type="text" name="armadanama[]" id="armadaid${index}" class="form-control filled-row lg-form armadaeditall-lookup${index}" autocomplete="off">
                                        </div>
                                        </div>
                                    </div>

                                    
                                    <div class="d-flex align-items-center">
                                        <div class="row">
                                        <div class="col-6">
                                            <label class="col-form-label mt-2 mb-2">NOMINAL</label>
                                            <input type="text" name="nominal[]"  class="form-control autonumeric">
                                        </div>

                                        <div class="col-6">
                                            <label class="col-form-label mt-2 mb-2" min-width: 50px;">KETERANGAN</label>
                                            <input type="text" name="keterangan[]"  class="form-control" >
                                        </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-danger btn-sm delete-row mt-2">Hapus</button>
                                </td>
                
                                </tr> `)

                                detailRowMobile.find(`[name="tglbukti[]"]`).val(dateFormat(
                                    detail
                                    .tglbukti))
                                detailRowMobile.find(`[name="id[]"]`).val(detail.id)
                                detailRowMobile.find(`[name="perkiraanid[]"]`).val(detail
                                    .perkiraanid)
                                detailRowMobile.find(`[name="perkiraannama[]"]`).val(detail
                                    .perkiraannama)
                                detailRowMobile.find(`[name="karyawanid[]"]`).val(detail
                                    .karyawanid)
                                detailRowMobile.find(`[name="karyawannama[]"]`).val(detail
                                    .karyawannama)
                                detailRowMobile.find(`[name="armadaid[]"]`).val(detail.armadaid)
                                detailRowMobile.find(`[name="armadanama[]"]`).val(detail
                                    .armadanama)
                                detailRowMobile.find(`[name="nominal[]"]`).val(detail.nominal)
                                detailRowMobile.find(`[name="keterangan[]"]`).val(detail
                                    .keterangan)

                                initAutoNumericNoDoubleZero(detailRowMobile.find(
                                    `[name="nominal[]"]`))

                                bindkeyMovementEditAllTransaksi('editAllTransaksiArmada', 1, $(
                                    "#editAllTransaksiArmadaModal"))


                                $('#editAllTransaksiArmada tbody')
                                    .append(detailRowMobile)

                                rowIndex = index
                                initLookupDetail(rowIndex);
                                initDatepicker()

                                detailRowMobile.find('.datepicker').prop('readonly', true)
                                    .addClass(
                                        'bg-white state-delete')
                                detailRowMobile.find('.ui-datepicker-trigger').prop('disabled',
                                    true)

                                if (detail.pembelianid > 0) {
                                    detailRowMobile.each(function() {
                                        var hasFilledRowClass = $(this).find(
                                            `[name="id[]"]`).val();

                                        if (hasFilledRowClass > 0) {
                                            $(this).find('input').prop('disabled', true)
                                                .addClass('bg-white state-delete')
                                            $(this).find('.ui-datepicker-trigger').prop(
                                                'disabled', true)

                                            $(this).find('.tbl_aksi .delete-row').prop(
                                                'disabled',
                                                true)
                                            $(this).find('.lookup-toggler').prop(
                                                'disabled',
                                                true)
                                            $(this).find('.button-clear').prop(
                                                'disabled',
                                                true)

                                        }
                                    });
                                }
                                updateUrut()
                            })

                            if (form.data('action') === 'delete') {
                                form.find('[name]').addClass('disabled')
                                initDisabled()
                            }

                        }


                        resolve()
                    },
                    error: error => {
                        reject(error)
                    }
                })
            })
        }

        function setRowNumber() {
            let elements = $('#editAllTransaksiArmada tbody tr td:nth-child(1)')

            elements.each((index, element) => {
                $(element).text(index + 1)
            })
        }

        var SetDefaultValue;

        function initLookupDetail(index) {
            let rowLookup = index;

            $(`.perkiraaneditall-lookup${rowLookup}`).lookup({
                title: 'perkiraan Lookup',
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
                        customerid: $('#editAllTransaksiArmadaForm').find('[name=perkiraanid]').val(),
                        group: 'armada'
                        // limit: 0
                        // typeSearch: 'ALL',
                    };
                },
                onSelectRow: (perkiraan, element) => {
                    let perkiraan_id_input = element.parents('td').find(`[name="perkiraanid[]"]`);

                    element.parents('tr').find('td [name="perkiraanid[]"]').val(perkiraan.id)
                    element.parents('tr').find('td [name="perkiraannama[]"]').val(perkiraan.nama)
                    element.parents('tr').find('td [name="keterangan[]"]').val(perkiraan.keterangan)

                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let perkiraan_id_input = element.parents('td').find(`[name="perkiraanid[]"]`).first();
                    perkiraan_id_input.val('');
                    element.val('');
                    element.data('currentValue', element.val());
                },
            });

            $(`.karyawaneditall-lookup${rowLookup}`).lookup({
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
                        valueName: `karayawanid${index}`,
                        id: `karayawanid${rowLookup}`,
                        searchText: `karyawan-lookup${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'karyawan',
                        limit: 0
                    };
                },
                onSelectRow: (karyawan, element) => {
                    let karyawan_id_input = element.parents('td').find(`[name="karyawanid[]"]`);

                    element.parents('tr').find('td [name="karyawanid[]"]').val(karyawan.id)
                    element.parents('tr').find('td [name="karyawannama[]"]').val(karyawan.nama)
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let karyawan_id_input = element.parents('td').find(`[name="karyawanid[]"]`).first();
                    karyawan_id_input.val('');
                    element.val('');
                    // element.parents('tr').find('td [name="harga[]"]').val(0)
                    // element.parents('tr').find('td [name="harga[]"]').autoNumeric('wipe')

                    element.data('currentValue', element.val());
                },
            });

            $(`.armadaeditall-lookup${rowLookup}`).lookup({
                title: 'armada Lookup',
                fileName: 'armada',
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
                        valueName: `armadaid${index}`,
                        id: `armadaid${rowLookup}`,
                        searchText: `armadaeditall-lookup${rowLookup}`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'armada',
                        limit: 0
                    };
                },
                onSelectRow: (armada, element) => {
                    let armada_id_input = element.parents('td').find(`[name="armadaid[]"]`);

                    element.parents('tr').find('td [name="armadaid[]"]').val(armada.id)
                    element.parents('tr').find('td [name="armadanama[]"]').val(armada.nama)
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let armada_id_input = element.parents('td').find(`[name="armadaid[]"]`).first();
                    armada_id_input.val('');
                    element.val('');
                    // element.parents('tr').find('td [name="harga[]"]').val(0)
                    // element.parents('tr').find('td [name="harga[]"]').autoNumeric('wipe')

                    element.data('currentValue', element.val());
                },
            });




        }


        function addRow() {

            if (detectDeviceType() == "desktop") {
                rowIndex++
                let rowLookupIndex = rowIndex
                let detailRow = $(`
                    <tr class="filled-row">
                                <td> </td>
                                <td>
                                <div class="input-group">
                                    <input type="hidden" name="id[]" class="form-control">
                                    <input type="text" name="tglbukti[]" class="form-control datepicker">
                                </div>
                                </td>
                                <td>
                                    <input type="hidden" name="perkiraanid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                                    <input type="text" name="perkiraannama[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form perkiraaneditall-lookup${rowLookupIndex}" autocomplete="off">
                                </td>
                                <td>
                                    <input type="hidden" name="karyawanid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                                    <input type="text" name="karyawannama[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form karyawaneditall-lookup${rowLookupIndex}" autocomplete="off">
                                </td>
                                <td>
                                    <input type="hidden" name="armadaid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                                    <input type="text" name="armadanama[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form armadaeditall-lookup${rowLookupIndex}" autocomplete="off">
                                </td>
                                <td>
                                <input type="text" name="nominal[]"  class="form-control autonumeric">
                                </td>
                                <td>
                                    <input type="text" name="keterangan[]"  class="form-control" > 
                                </td>
                                <td class="tbl_aksi" >
                                <button class='btn btn-danger btn-sm delete-row '>Hapus</button>
                                </td>
                            </tr>`)


                tglbukti = $('#editAllTransaksiArmadaForm').find(`[name="tglbukti"]`).val()
                detailRow.find(`[name="tglbukti[]"]`).val(tglbukti).trigger('change');

                var tglbuktiAdd = new Date()
                tglbuktiAdd.setDate(tglbuktiAdd.getDate())
                detailRow.find(`[name="tglbukti[]"]`).val($.datepicker.formatDate('dd-mm-yy', tglbuktiAdd)).trigger(
                    'change');




                $('#editAllTransaksiArmada>#editAllTransaksiArmadaTableBody').append(detailRow)
                initDatepicker()

                detailRow.find('.datepicker').prop('readonly', true).addClass('bg-white state-delete')
                detailRow.find('.ui-datepicker-trigger').prop('disabled', true)

                initLookupDetail(rowLookupIndex)

                initAutoNumericNoDoubleZero(detailRow.find('.autonumeric'))

                setRowNumber()
            } else if (detectDeviceType() == "mobile") {
                rowIndex++
                let rowLookupIndex = rowIndex
                let newTfoot = $(`
                    <tfoot>
                    <tr>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm my-2"
                                id="addRow">Tambah</button>


                        </td>
                    </tr>
                    </tfoot>
                `);

                $('#editAllTransaksiArmada tfoot').replaceWith(newTfoot);


                let detailRow = $(`
                <tr class="filled-row">
                                    
                    <td class="table-bold">
                        <div class="d-flex align-items-center">
                            <div class="row">
                            <div class="col-6">
                                <label class="col-form-label mt-2 label-mobile label-top">${rowLookupIndex}. &ensp; TGL BUKTI</label>
                                <div class="input-group">
                                <input type="hidden" name="id[]" class="form-control">
                                <input type="text" name="tglbukti[]" class="form-control datepicker">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="col-form-label mt-2 label-mobile" min-width: 50px;">PERKIRAAN</label>
                                <input type="hidden" name="perkiraanid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                        <input type="text" name="perkiraannama[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form perkiraaneditall-lookup${rowLookupIndex}" autocomplete="off">
                            </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="row">
                            <div class="col-6">
                                <label class="col-form-label mt-2 mb-2">KARYAWAN</label>
                                <div class="input-group">
                                    <input type="hidden" name="karyawanid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                                    <input type="text" name="karyawannama[]" id="perkiraanid${rowLookupIndex}" class="form-control filled-row lg-form karyawaneditall-lookup${rowLookupIndex}" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="col-form-label mt-2 mb-2" min-width: 50px;">ARMADA</label>
                                <input type="hidden" name="armadaid[]" class="form-control filled-row detail_stok_${rowLookupIndex}">
                                <input type="text" name="armadanama[]" id="armadaid${rowLookupIndex}" class="form-control filled-row lg-form armadaeditall-lookup${rowLookupIndex}" autocomplete="off">
                            </div>
                            </div>
                        </div>

                        
                        <div class="d-flex align-items-center">
                            <div class="row">
                            <div class="col-6">
                                <label class="col-form-label mt-2 mb-2">NOMINAL</label>
                                <input type="text" name="nominal[]"  class="form-control autonumeric">
                            </div>

                            <div class="col-6">
                                <label class="col-form-label mt-2 mb-2" min-width: 50px;">KETERANGAN</label>
                                <input type="text" name="keterangan[]"  class="form-control" >
                            </div>
                            </div>
                        </div>

                        <label class="col-form-label mt-2" min-width: 50px;">KETERANGAN</label>
                        <input type="text" name="keterangan[]" class="form-control" > 
                        
                        <button type="button" class="btn btn-danger btn-sm delete-row mt-2">Hapus</button>
                    </td>
                    
                    </tr>`)


                tglbukti = $('#editAllTransaksiArmadaForm').find(`[name="tglbukti"]`).val()
                detailRow.find(`[name="tglbukti[]"]`).val(tglbukti).trigger('change');

                var tglbuktiAdd = new Date()
                tglbuktiAdd.setDate(tglbuktiAdd.getDate())
                detailRow.find(`[name="tglbukti[]"]`).val($.datepicker.formatDate('dd-mm-yy', tglbuktiAdd)).trigger(
                    'change');


                $('#editAllTransaksiArmada tbody').append(detailRow)
                initDatepicker()

                detailRow.find('.datepicker').prop('readonly', true).addClass('bg-white state-delete')
                detailRow.find('.ui-datepicker-trigger').prop('disabled', true)

                initLookupDetail(rowLookupIndex)

                initAutoNumericNoDoubleZero(detailRow.find('.autonumeric'))

                // updateUrut()



            }



        }

        function deleteRow(row) {
            let countRow = $('.delete-row').parents('tr').length
            let rowId = row.find(`[name="id[]"]`).val();

            if (row.siblings().length == 0) {
                noUrut = 1
                row.remove()
                addRow()
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

        function storeDeletedId(row) {
            let rowId = row.find(`[name="id[]"]`).val();
            deletedId.push(rowId)

        }

        function updateUrut() {
            let elements = $('#editAllTransaksiArmada tbody tr td.table-bold .label-top');

            elements.each((index, element) => {
                $(element).text(index + 1 + ". produk");
            });
        }
    </script>
@endpush()
