<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="#" id="crudForm">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="crudModalTitle"></p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-body modal-overflow" style="overflow-y: auto; overflow-x: auto;">
                        <input type="hidden" name="id" class="filled-row">
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    no bukti <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="nobukti" class="form-control lg-form filled-row" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl bukti<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tglbukti" id="tglbukti" class="form-control lg-form datepicker filled-row" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    supplier <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="supplierid" class="filled-row">
                                <input type="text" name="suppliernama" id="suppliernama" class="form-control lg-form supplier-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    jenis pelunasan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="jenispelunasanhutang" class="filled-row">
                                <input type="text" name="jenispelunasanhutangnama" id="jenispelunasanhutangnama" class="form-control lg-form jenispelunasanhutang-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label class="col-form-label">
                                    alat bayar <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="alatbayarid" class="filled-row">
                                <input type="text" name="alatbayarnama" id="alatbayarnama" class="form-control lg-form alatbayar-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    STATUS <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="status" class="filled-row">
                                <input type="text" name="statusnama" id="statusnama" class="form-control lg-form status-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="scroll-container overflow">
                            <div class="table-container">
                                <table class="table table-lookup table-bold table-bindkeys " id="detailList">
                                    <thead>
                                        <tr class="table-bold">
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button id="btnSubmit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-warning btn-cancel" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup </button>
                    </div>
                </form>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let hasFormBindKeys = false
    let modalBody = $('#crudModal').find('.modal-body').html()

    $(document).ready(function() {

        $("#crudForm [name]").attr("autocomplete", "off");
        $('#nopo').focus();

        $(document).on('click', '.delete-row', function(event) {
            deleteRow($(this).parents('tr'))
        })

        $(document).on('input', `#table_body [name="nominalbayar[]"]`, function(event) {
            setNominalSisa($(this))
        })

        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            let method
            let url
            let form = $('#crudForm')
            let Id = form.find('[name=id]').val()
            let action = form.data('action')
            let data = []
            let details = []

            data.push({
                name: `tglbukti`,
                value: form.find(`[name="tglbukti"]`).val()
            })

            data.push({
                name: `supplierid`,
                value: form.find(`[name="supplierid"]`).val()
            })

            data.push({
                name: `suppliernama`,
                value: form.find(`[name="suppliernama"]`).val()
            })

            data.push({
                name: `jenispelunasanhutang`,
                value: form.find(`[name="jenispelunasanhutang"]`).val()
            })

            data.push({
                name: `jenispelunasanhutangnama`,
                value: form.find(`[name="jenispelunasanhutangnama"]`).val()
            })

            data.push({
                name: `alatbayarid`,
                value: form.find(`[name="alatbayarid"]`).val()
            })

            data.push({
                name: `alatbayarnama`,
                value: form.find(`[name="alatbayarnama"]`).val()
            })

            data.push({
                name: `status`,
                value: form.find(`[name="status"]`).val()
            })

            data.push({
                name: `statusnama`,
                value: form.find(`[name="statusnama"]`).val()
            })

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })

            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })

            $.each(selectedRows, function(index, value) {
                data.push({
                    name: 'hutangid[]',
                    value: value
                })
            })

            $.each(selectedRows, function(index, value) {
                element = `#crudForm tbody tr.${value}`;
                details[value] = {
                    nobuktihutang: $(element).find(`[name="nobuktihutang[]"]`).val(),
                    tglbuktihutang: $(element).find(`[name="tglbuktihutang[]"]`).val(),
                    nominalhutang: AutoNumeric.getNumber($(element).find(`[name="nominalhutang[]"]`)[0]),
                    nominalbayar: AutoNumeric.getNumber($(element).find(`[name="nominalbayar[]"]`)[0]),
                    sisahutang: AutoNumeric.getNumber($(element).find(`[name="sisahutang[]"]`)[0]),
                    keterangandetail: $(element).find(`[name="keterangandetail[]"]`).val(),
                    potongan: AutoNumeric.getNumber($(element).find(`[name="potongan[]"]`)[0]),
                    keteranganpotongan: $(element).find(`[name="keteranganpotongan[]"]`).val(),
                    nominalnotadebet: AutoNumeric.getNumber($(element).find(`[name="nominalnotadebet[]"]`)[0]),
                };
            })

            // Convert the array to an object with indices as keys
            const detail = details.reduce((acc, item, index) => {
                acc[index] = item;
                return acc;
            }, {});
            // Stringify the object
            const jsonString = JSON.stringify(detail);

            data.push({
                name: 'detail',
                value: jsonString
            })

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pelunasanhutangheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pelunasanhutangheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pelunasanhutangheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pelunasanhutangheader`
                    break;
            }
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: url,
                method: method,
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    id = response.data.id
                    $('#crudModal').find('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    selectedRows = []

                    $('#jqGrid').jqGrid('setGridParam', {
                        page: response.data.page,
                        postData: {
                            tgldari: dateFormat(response.data.tgldariheader),
                            tglsampai: dateFormat(response.data.tglsampaiheader)
                        }
                    }).trigger('reloadGrid');

                    if (id == 0) {
                        $('#detailGrid').jqGrid().trigger('reloadGrid')
                    }

                    if (response.data.grp == 'FORMAT') {
                        updateFormat(response.data)
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
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

        })
    })

    $('#crudModal').on('shown.bs.modal', () => {
        var crudModal = $('#crudModal')
        let form = $('#crudForm')
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

    $('#crudModal').on('hidden.bs.modal', () => {
        selectedRows = []
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
        initDatepicker('datepickerIndex')
    })

    function createPelunasanHutangHeader() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        form.find('#btnSubmit').html(`
        <i class="fa fa-save"></i>
        Simpan
      `)
        form.data('action', 'add')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#table_body').html('')
        $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                showDefault(form),
                setStatusOptions(form),
                setJenisPelunasanOptions(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                addRow()
                form.find(`[name="nobuktihutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="tglbuktihutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="nominalhutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="nominalbayar[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="sisahutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="keterangandetail[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="potongan[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="keteranganpotongan[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="nominalnotadebet[]"]`).prop('readonly', true).addClass('bg-white state-delete')

                setDefault(form)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    var SetDefaultValue;

    function setDefault(form) {
        $.each(SetDefaultValue, (index, value) => {

            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
                element.val(value).trigger('change')
            } else {
                element.val(value)
            }

            if (index == 'statusnama') {
                element.val(value)
            }

            if (index == 'statusnama') {
                element.data('current-value', value)
            }
        })
    }

    function enableLookup() {
        let suppliernama = $('#crudForm').find(`[name="suppliernama"]`).parents('.input-group').children()
        suppliernama.find(`.lookup-toggler`).attr("disabled", true);
        suppliernama.find(`.button-clear`).attr("disabled", true);
        suppliernama.prop('readonly', true)
    }

    function editPelunasanHutangHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`<i class="fa fa-save"></i>Simpan`)
        form.find(`.sometimes`).hide()
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                setStatusOptions(form),
                setJenisPelunasanOptions(form)
            ])
            .then(() => {
                showPelunasanHutangHeader(form, id)
                    .then((response) => {
                        $('#crudModal').modal('show')
                    })
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function deletePelunasanHutangHeader(id) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
                  <i class="fa fa-save"></i>
                  Hapus
                `)
        form.find(`.sometimes`).hide()

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPelunasanHutangHeader(form, id),
                setStatusOptions(form),
                setJenisPelunasanOptions(form)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`[name="tglbukti"]`).prop('readonly', true)
                form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })


    }

    function getEditPelunasanHutangHeader(supplierid, id) {
        $.ajax({
            url: `${apiUrl}pelunasanhutangheader/geteditpelunasanhutangheader`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id: id,
                supplierid: supplierid,
            },
            success: response => {

                $('#detailList tbody').html('')

                if (detectDeviceType() == "desktop") {
                    let tableHeader = $(`
                            <th style="width: 50px; min-width: 50px;">No.</th>
                            <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                            <th style="width: 250px; min-width: 250px;">No Bukti Hutang</th>
                            <th style="width: 250px; min-width: 250px;">Tgl Bukti Hutang</th>
                            <th class="wider-nominalhutang" style="width: 265px; min-width: 150px;">Nominal Hutang</th>
                            <th class="wider-nominalbayar" style="width: 265px; min-width: 150px;">Nominal Bayar</th>
                            <th class="wider-sisahutang" style="width: 265px; min-width: 150px;">Nominal Sisa</th>
                            <th class="wider-keterangandetail" style="width: 265px; min-width: 250px;">Keterangan</th>
                            <th class="wider-potongan" style="width: 265px; min-width: 150px;">Nominal Potongan</th>
                            <th class="wider-keterangan" style="width: 265px; min-width: 250px;">Keterangan Potongan</th>
                            <th class="wider-nominalnotadebet" style="width: 265px; min-width: 150px;">Nominal Nota Debet</th>
                        `);
                    // Sisipkan elemen <th> di awal baris
                    $('#detailList thead tr').prepend(tableHeader);

                    $.each(response.data, (index, data) => {
                        console.log(data)
                        selectIndex = index;
                        let detailRow = $(`
                            <tr class='${data.id}'>
                                    <td class="table-bold">
                                    </td>
                                    <td class="table-bold">
                                        <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                                    </td>
                                    <td class="table-bold">
                                        <input type="hidden" name="hutangid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="text" name="nobuktihutang[]" id="nobuktihutangId_${selectIndex}" class="form-control filled-row lg-form" data-current-value="${data.nobuktihutang}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="tglbuktihutang[]" class="form-control filled-row lg-form" autocomplete="off" ">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="nominalhutang[]" class="form-control lg-form filled-row autonumeric-nozero " autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="nominalbayar[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                        <input type="hidden" name="originalnominalbayar[]">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="sisahutang[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                        <input type="hidden" name="originalsisahutang[]">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="keterangandetail[]" class="form-control filled-row lg-form " autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="potongan[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="keteranganpotongan[]" class="form-control filled-row lg-form " autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="nominalnotadebet[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                    </td>
                                </tr>`)

                                
                        detailRow.find(`[name="check[]"]`).val(data.id)
                        detailRow.find(`[name="keterangandetail[]"]`).val(data.keterangandetail)
                        detailRow.find(`[name="hutangid[]"]`).val(data.id)
                        detailRow.find(`[name="nobuktihutang[]"]`).val(data.nobuktihutang)
                        detailRow.find(`[name="nominalhutang[]"]`).val(data.nominalhutang)
                        detailRow.find(`[name="nominalbayar[]"]`).val(data.nominalbayar)
                        detailRow.find(`[name="originalnominalbayar[]"]`).val(data.nominalbayar)
                        detailRow.find(`[name="sisahutang[]"]`).val(data.sisa)
                        detailRow.find(`[name="originalsisahutang[]"]`).val(data.sisa)
                        detailRow.find(`[name="potongan[]"]`).val(data.nominalpotongan)
                        detailRow.find(`[name="keteranganpotongan[]"]`).val(data.keteranganpotongan)
                        detailRow.find(`[name="nominalnotadebet[]"]`).val(data.nominalnotadebet)

                        const tglbuktihutang = $.datepicker.formatDate('dd-mm-yy', new Date(data.tglbuktihutang));
                        detailRow.find(`[name="tglbuktihutang[]"]`).val(tglbuktihutang);

                        if (data.pelunasanhutangid != null) {
                            selectedRows.push(data.id)
                            detailRow.find(`[name="check[]"]`).attr('checked',true)
                        }

                        initAutoNumeric(detailRow.find('.autonumeric'))
                        initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))

                        $('#detailList tbody').append(detailRow)

                        rowIndex = index

                        initDatepicker()
                        clearButton('detailList', `#detail_${index}`)
                        setRowNumbers()

                    })
                } else if (detectDeviceType() == "mobile") {
                    let tableHeader = $(`
                            <th style="width: 250px; min-width: 250px;">No. Produk</th>
                        `);
                    // Sisipkan elemen <th> di awal baris
                    $('#detailList thead tr').prepend(tableHeader);
                    $.each(response.detail, (index, detail) => {
                        selectIndex = index;

                        let detailRow = $(`
                            <tr class="filled-row">
                                    <td class="table-bold">
                                        <label class="col-form-label mt-2 label-mobile" style="font-size:13px">${index+1}. &ensp; customer</label>
                                        <input type="hidden" name="customerid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form customer-lookup${selectIndex}" data-current-value="${detail.customernama}" autocomplete="off">

                                        <label class="col-form-label mt-2 label-mobile" style="font-size:13px">product</label>
                                        <input type="hidden" name="productid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                        <input type="text" name="productnama[]" id="ItemId_${selectIndex}" class="form-control lg-form item-lookup${selectIndex}" data-current-value="${detail.productnama}" autocomplete="off">

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2 label-mobile" style="font-size: 13px; min-width: 50px;">QTY</label>
                                                    <input type="text" name="qty[]" class="form-control filled-row lg-form autonumeric" autocomplete="off">
                                                </div>
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2 label-mobile" style="font-size: 13px; min-width: 50px;">Satuan</label>
                                                    <input type="hidden" name="satuanid[]" class="form-control filled-row detail_stok_${selectIndex}">
                                                    <input type="text" name="satuannama[]" id="satuanId_${selectIndex}" class="form-control filled-row lg-form satuan-lookup${selectIndex}" data-current-value="${detail.satuannama}" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">QTY RETUR</label>
                                                    <input type="text" name="qtyretur[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                                                </div>

                                                <div class="col-6">
                                                    <label class="col-form-label mt-2" style="font-size: 13px; min-width: 50px;">stok</label>
                                                    <input type="text" name="stok[]" class="form-control lg-form filled-row autonumeric" autocomplete="off" ">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-2 mb-2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="col-form-label" id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                                                    <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero filled-row text-right" autocomplete="off" >
                                                </div>

                                                <div class="col-6">
                                                    <label class="col-form-label" id="total${selectIndex}" style="font-size:13px">Total</label>
                                                    <input type="text" name="totalharga[]" class="form-control mb-2 lg-form autonumeric-nozero text-right filled-row " autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>

                                        <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                                        <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">

                                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                                    </td>
                                </tr> `)

                        detailRow.find(`[name="keterangandetail[]"]`).val(detail.keterangandetail)
                        detailRow.find(`[name="productid[]"]`).val(detail.productid)
                        detailRow.find(`[name="productnama[]"]`).val(detail.productnama)
                        detailRow.find(`[name="qty[]"]`).val(detail.qty)
                        detailRow.find(`[name="qtyretur[]"]`).val(detail.qtyretur)
                        detailRow.find(`[name="stok[]"]`).val(detail.stok)
                        detailRow.find(`[name="harga[]"]`).val(detail.harga)
                        detailRow.find(`[name="totalharga[]"]`).val(detail.totalharga)
                        detailRow.find(`[name="customerid[]"]`).val(detail.customerid)
                        detailRow.find(`[name="customernama[]"]`).val(detail.customernama)

                        $('#detailList tbody').append(detailRow)
                        rowIndex = index
                        initDatepicker()
                        form.find('[name=invoicedate]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        initLookupDetail(rowIndex);
                        clearButton('detailList', `#detail_${index}`)
                    })
                    addRow(response.detail.length)
                    form.find(`[name="subtotal"]`).val(response.data.subtotal)
                    form.find(`[name="potongan"]`).val(response.data.potongan)
                    form.find(`[name="grandtotal"]`).val(response.data.grandtotal)
                    initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                    initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                    initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))

                    // setTotalDetail()
                    setSubTotal()
                    setGrandTotal()
                }
                selectIndex += 1;
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

    const setStatusOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=status]').empty()
            relatedForm.find('[name=status]').append(
                new Option('-- PILIH STATUS --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: "STATUS",
                    subgrp: "STATUS"
                },
                success: response => {
                    response.data.forEach(status => {
                        let option = new Option(status.text, status.id)

                        relatedForm.find('[name=status]').append(option).trigger('change')
                    });

                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    const setJenisPelunasanOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=jenispelunasanhutang]').empty()
            relatedForm.find('[name=jenispelunasanhutang]').append(
                new Option('-- PILIH JENIS PELUNASAN --', '', false, true)
            ).trigger('change')

            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    grp: "JENIS PELUNASAN",
                    subgrp: "JENIS PELUNASAN"
                },
                success: response => {
                    response.data.forEach(status => {
                        let option = new Option(status.text, status.id)

                        relatedForm.find('[name=jenispelunasan]').append(option).trigger('change')
                    });
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function viewPelunasanHutangHeader(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('View Pelunasan Hutang Header')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                showPembelianHeader(form, userId)
            ])
            .then(() => {
                $('#crudModal').modal('show')
                form.find(`.hasDatepicker`).prop('readonly', true)
                form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
                form.find(`.tbl_aksi`).hide()
            })
            .catch((error) => {
                showDialog(error.responseJSON)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
            $.ajax({
                url: `${apiUrl}pelunasanhutangheader/field_length`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        if (value !== null && value !== 0 && value !== undefined) {
                            form.find(`[name=${index}]`).attr('maxlength', value)
                        }
                    })
                    form.attr('has-maxlength', true)
                },
                error: error => {
                    showDialog(error.statusText)
                }
            })
        }
    }

    function setNominalSisa(element, id = 0) {
        let originalsisahutang = parseFloat(element.parents('tr').find(` [name="originalsisahutang[]"]`).val().replace(/,/g, ''))
        let originalnominalbayar = parseFloat(element.parents('tr').find(` [name="originalnominalbayar[]"]`).val().replace(/,/g, ''))

        let nominalbayar = parseFloat(element.parents('tr').find(` [name="nominalbayar[]"]`).val().replace(/,/g, ''))
        let sisahutang = 0;
        if($('#crudForm').data('action') == 'edit') {
            sisahutang = (originalsisahutang + originalnominalbayar) - nominalbayar;
            console.log(sisahutang)
        } else {
            sisahutang = originalsisahutang - nominalbayar;
        }

        if (sisahutang < 0) {
            showDialog('sisa tidak boleh minus')
            sisahutang = originalsisahutang;
        }
        initAutoNumericNoDoubleZero(element.parents('tr').find(`[name="sisahutang[]"]`).val(sisahutang))
    }

    function showPelunasanHutangHeader(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}pelunasanhutangheader/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            if (response.data.suppliernama !== null) {
                                let newOption = new Option(response.data.suppliernama, value);
                                element.append(newOption);
                                element.val(value);
                                element.trigger('change');
                                element.on('select2:open', function() {

                                    setTimeout(function() {
                                        $(".select2-search__field").focus();
                                    }, 50);
                                })

                                element.on('select2:opening', function() {
                                    setTimeout(function() {
                                        $('.select2-search__field').val(response.data.suppliernama).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'suppliernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'alatbayarnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'jenispelunasanhutangnama') {
                            element.data('current-value', value)
                        }
                    })

                    getEditPelunasanHutangHeader(response.data.supplierid, response.data.id)

                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve(response)
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    let selectIndex = 0

    function addRow(show = 0) {
        form = $('#detailList')
        if (detectDeviceType() == "desktop") {
            let tableHeader = $(`
                <th style="width: 50px; min-width: 50px;">No.</th>
                <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                <th style="width: 250px; min-width: 250px;">No Bukti Hutang</th>
                <th style="width: 250px; min-width: 250px;">Tgl Bukti Hutang</th>
                <th class="wider-nominalhutang" style="width: 265px; min-width: 150px;">Nominal Hutang</th>
                <th class="wider-nominalbayar" style="width: 265px; min-width: 150px;">Nominal Bayar</th>
                <th class="wider-sisahutang" style="width: 265px; min-width: 150px;">Nominal Sisa</th>
                <th class="wider-keterangandetail" style="width: 265px; min-width: 250px;">Keterangan</th>
                <th class="wider-potongan" style="width: 265px; min-width: 150px;">Nominal Potongan</th>
                <th class="wider-keterangan" style="width: 265px; min-width: 250px;">Keterangan Potongan</th>
                <th class="wider-nominalnotadebet" style="width: 265px; min-width: 150px;">Nominal Nota Debet</th>
            `);
            // Sisipkan elemen <th> di awal baris

            if (!show) {
                $('#detailList thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }

            let detailRow = $(`
                <tr>
                    <td class="table-bold">
                    </td>
                    <td class="table-bold">
                        <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                    </td>
                    <td class="table-bold">
                        <input type="hidden" name="hutangid[]" class="form-control detail_stok_${selectIndex}">
                        <input type="text" name="nobuktihutang[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="tglbuktihutang[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="nominalhutang[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="nominalbayar[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="sisahutang[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="potongan[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="keteranganpotongan[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="nominalnotadebet[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                </tr>
            `)

            $('#detailList tbody').append(detailRow)
            initAutoNumeric(detailRow.find('.autonumeric'))
            initAutoNumericNoDoubleZero(detailRow.find('.autonumeric-nozero'))
            clearButton(form, `#addRow_${selectIndex}`)
            rowLookup = selectIndex
            setRowNumbers()
            selectIndex++

        } else if (detectDeviceType() == "mobile") {
            let tableHeader = $(`
                <th style="width: 500px; min-width: 250px;">No. Produk</th>
            `);

            $(".wider-qty").remove();
            $(".wider-keterangandetail").remove();

            let newTfoot = $(`
                <tfoot>
                <tr>
                    <td colspan="9">
                    <div class="row form-group">
                        <div class="col-12 col-md-10 text-lg-right">
                            <label class="col-form-label ">
                                subtotal
                            </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="subtotal" id="subtotal" class="form-control  text-right lg-form filled-row" value="0">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-10 text-lg-right">
                                <label class="col-form-label">
                                    potongan
                                </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="potongan" id="potongan" class="form-control text-right lg-form filled-row" value="0">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-md-10 text-lg-right">
                                <label class="col-form-label">
                                    Total
                                </label>
                            </div>
                            <div class="col-md-2 text-right">
                                <input type="text" name="grandtotal" id="grandtotal" class="form-control autonumeric-nozero text-right lg-form filled-row" value="0">
                            </div>
                        </div>
                    </td>
                </tr>
                </tfoot>
            `);

            $('#detailList tfoot').replaceWith(newTfoot);
            if (!show) {
                $('#detailList thead tr').prepend(tableHeader);
            } else {
                selectIndex = show
            }

            for (let i = show; i < 50; i++) {
                let urut = i + 1;
                let detailRow = $(`
                    <tr>
                        <td class="table-bold" >
                            <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">${urut}. &ensp; customer</label>
                            <input type="hidden" name="customerid[]" class="form-control  detail_stok_${selectIndex}">
                            <input type="text" name="customernama[]" id="customerId_${selectIndex}" class="form-control lg-form numeric customer-lookup${selectIndex}" autocomplete="off">

                            <label class="col-form-label mt-2 label-top label-mobile" style="font-size:13px">produk</label>
                            <input type="hidden" name="productid[]" class="form-control  detail_stok_${selectIndex}">
                            <input type="text" name="product_name[]" id="ItemId_${selectIndex}" class="form-control lg-form numeric item-lookup${selectIndex}" autocomplete="off">
                            
                            <div class="d-flex align-items-center mt-2 mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label label-top label-mobile" style=" min-width: 25px;">QTY </label>
                                        <input type="text" name="qty[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="col-form-label label-mobile" style=" min-width: 50px;">SATUAN </label>
                                        <input type="hidden" name="satuanid[]" class="form-control detail_stok_${selectIndex}">
                                        <input type="text" name="satuannama[]" id="satuanId_${selectIndex}"  class="form-control lg-form satuan-lookup${selectIndex}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                            <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label mt-2 " style="font-size: 13px; min-width: 50px;">qty retur</label>
                                        <input type="text" name="qtyretur[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                        <div class="col-6">
                                        <label class="col-form-label mt-2 " >stok</label>
                                        <input type="text" name="stok[]" class="form-control lg-form autonumeric" autocomplete="off" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-2 mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="col-form-label "  id="harga${selectIndex}" style="font-size:13px">HARGA</label>
                                        <input type="text" name="harga[]" class="form-control lg-form autonumeric-nozero text-right" autocomplete="off" value="0">
                                    </div>
                                    <div class="col-6">
                                        <label class="col-form-label " id="total${selectIndex}" style="font-size:13px">Total</label>
                                        <input type="text" name="totalharga[]" class="form-control lg-form  autonumeric-nozero text-right" autocomplete="off" value="0">
                                    </div>
                                </div>
                            </div>
                            <label class="col-form-label " style="font-size:13px">KETERANGAN</label>
                            <input type="text" name="keterangandetail[]" class="form-control mb-2  lg-form" autocomplete="off" ">
                            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                        </td>
                    </tr> `)


                tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()

                detailRow.on('input', 'input[name="keterangandetail[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });
                detailRow.on('input', 'input[name="harga[]"]', function() {
                    setTotalDetail($(this))
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });
                detailRow.on('input', 'input[name="qty[]"]', function() {
                    let value = $(this).val();
                    if (value.trim() !== "") {
                        $(this).addClass('filled-row');
                    } else {
                        $(this).removeClass('filled-row');
                    }
                });
                $('#detailList tbody').append(detailRow)
                initDatepicker()
                clearButton(form, `#addRow_${selectIndex}`)
                rowLookup = selectIndex
                initLookupDetail(selectIndex);
                selectIndex++
            }
            initAutoNumeric($('#detailList').find('.autonumeric'))
            initAutoNumericNoDoubleZero($('#detailList').find('.autonumeric-nozero'))

            if ($('#crudForm').data('action') != "edit") {
                initAutoNumericNoDoubleZero(form.find(`[name="subtotal"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="potongan"]`))
                initAutoNumericNoDoubleZero(form.find(`[name="grandtotal"]`))
            }
        }
    }

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}pelunasanhutangheader/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function deleteRow(row) {
        if (row.siblings().length == 0) {
            noUrut = 1
            row.remove()
            addRow()
        } else {
            row.remove()

        }
        row.remove()

        if (detectDeviceType() == "desktop") {
            setRowNumbers()
            setSubTotal()
        } else {
            setSubTotal()
        }
    }

    function setRowNumbers() {
        let elements = $('#detailList tbody tr td:nth-child(1)')

        elements.each((index, element) => {
            $(element).text(index + 1)
        })
    }

    function getHutang() {
        $.ajax({
            url: `${apiUrl}pelunasanhutangheader/gethutang`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                supplierid: $('#crudForm').find('[name=supplierid]').val(),
            },
            success: response => {
                if (response.data.length > 0) {
                    $('#detailList tbody').html('')
                    $.each(response.data, (index, detail) => {
                        selectIndex = index;
                        let detailRow = $(`
                        <tr class='${detail.id}'>
                            <td class="table-bold">
                            </td>
                            <td class="table-bold">
                                <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="nobuktihutang[]" class="form-control lg-form bg-white state-delete" autocomplete="off" readonly >
                            </td>
                            <td class="table-bold">
                                <input type="text" name="tglbuktihutang[]" class="form-control lg-form bg-white state-delete" autocomplete="off" readonly>
                            </td>
                            <td class="table-bold">
                                <input type="text" name="nominalhutang[]" class="form-control lg-form autonumeric bg-white state-delete" autocomplete="off" readonly>
                            </td>
                            <td class="table-bold nom">
                                <input type="text" name="nominalbayar[]" class="form-control lg-form autonumeric bg-white state-delete" autocomplete="off" readonly>
                                <input type="hidden" name="originalnominalbayar[]">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="sisahutang[]" class="form-control lg-form autonumeric bg-white state-delete" autocomplete="off" readonly>
                                <input type="hidden" name="originalsisahutang[]">
                            </td>
                            <td class="table-bold">
                                <input type="text" name="keterangandetail[]" class="form-control lg-form bg-white state-delete" autocomplete="off" readonly>
                            </td>
                            <td class="table-bold">
                                <input type="text" name="potongan[]" class="form-control lg-form autonumeric bg-white state-delete" autocomplete="off" readonly>
                            </td>
                            <td class="table-bold">
                                <input type="text" name="keteranganpotongan[]" class="form-control lg-form bg-white state-delete" autocomplete="off" readonly>
                            </td>
                            <td class="table-bold">
                                <input type="text" name="nominalnotadebet[]" class="form-control lg-form autonumeric bg-white state-delete" autocomplete="off" readonly>
                            </td>
                        </tr>`)

                        detailRow.find(`[name="check[]"]`).val(detail.id)
                        detailRow.find(`[name="nobuktihutang[]"]`).val(detail.nobuktihutang)
                        detailRow.find(`[name="nominalhutang[]"]`).val(detail.nominalhutang)
                        detailRow.find(`[name="sisahutang[]"]`).val(detail.nominalsisa)
                        detailRow.find(`[name="originalsisahutang[]"]`).val(detail.nominalsisa)
                        detailRow.find(`[name="originalnominalbayar[]"]`).val(detail.nominalbayar)

                        const tglbuktihutang = $.datepicker.formatDate('dd-mm-yy', new Date(detail.tglbuktihutang));
                        detailRow.find(`[name="tglbuktihutang[]"]`).val(tglbuktihutang);

                        initAutoNumericNoDoubleZero(detailRow.find(`[name="nominalhutang[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="sisahutang[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="nominalbayar[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="potongan[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="nominalnotadebet[]"]`))

                        $('#detailList tbody').append(detailRow)
                        rowIndex = index
                        clearButton('detailList', `#detail_${index}`)
                        setRowNumbers()
                    })
                } else {
                    addRow()
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

    function initLookup() {
        $(`.status-lookup`).lookup({
            title: 'Status Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS',
                    subgrp: 'STATUS',
                    searching: 1,
                    valueName: `status`,
                    searchText: `status-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'status'
                };
            },
            onSelectRow: (status, element) => {

                $('#crudForm [name=status]').first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let status_id_input = element.parents('td').find(`[name="status"]`).first();
                status_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $(`.jenispelunasanhutang-lookup`).lookup({
            title: 'jenispelunasanhutang Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'JENIS PELUNASAN',
                    subgrp: 'JENIS PELUNASAN',
                    searching: 1,
                    valueName: `jenispelunasanhutang`,
                    searchText: `jenispelunasanhutang-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'jenis pelunasan'
                };
            },
            onSelectRow: (jenispelunasanhutang, element) => {

                $('#crudForm [name=jenispelunasanhutang]').first().val(jenispelunasanhutang.id)
                element.val(jenispelunasanhutang.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let jenispelunasanhutang_id_input = element.parents('td').find(`[name="jenispelunasanhutang"]`).first();
                jenispelunasanhutang_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $('.supplier-lookup').lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supplier_id',
                    searchText: 'supplier-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Supplier'
                }
            },
            onSelectRow: (supplier, element) => {
                $('#crudForm [name=supplierid]').first().val(supplier.id)
                element.val(supplier.nama)

                getHutang()

                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=supplierid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.alatbayar-lookup').lookup({
            title: 'alatbayar Lookup',
            fileName: 'alatbayar',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'alatbayar_id',
                    searchText: 'alatbayar-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'alatbayar',
                }
            },
            onSelectRow: (alatbayar, element) => {
                $('#crudForm [name=alatbayarid]').first().val(alatbayar.id)
                element.val(alatbayar.nama)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=alatbayarid]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()