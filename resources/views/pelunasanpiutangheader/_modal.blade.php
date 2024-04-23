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
                                    customer <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="hidden" name="customerid" class="filled-row">
                                <input type="text" name="customernama" id="customernama" class="form-control lg-form customer-lookup filled-row" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    jenis pelunasan <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="hidden" name="jenispelunasanpiutang" class="filled-row">
                                <input type="text" name="jenispelunasanpiutangnama" id="jenispelunasanpiutangnama" class="form-control lg-form jenispelunasanpiutang-lookup filled-row" autocomplete="off">
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
                        <input type="hidden" name="id" class="filled-row">
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
            // let data = $('#crudForm .filled-row').serializeArray()
            let data = []
            let details = []

            data.push({
                name: `tglbukti`,
                value: form.find(`[name="tglbukti"]`).val()
            })

            data.push({
                name: `customerid`,
                value: form.find(`[name="customerid"]`).val()
            })

            data.push({
                name: `customernama`,
                value: form.find(`[name="customernama"]`).val()
            })

            data.push({
                name: `jenispelunasanpiutang`,
                value: form.find(`[name="jenispelunasanpiutang"]`).val()
            })

            data.push({
                name: `jenispelunasanpiutangnama`,
                value: form.find(`[name="jenispelunasanpiutangnama"]`).val()
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
                    name: 'piutangid[]',
                    value: value
                })
            })

            $.each(selectedRows, function(index, value) {
                element = `#crudForm tbody tr.${value}`;
                console.log(element, index)
                details[value] = {
                    nobuktipiutang: $(element).find(`[name="nobuktipiutang[]"]`).val(),
                    tglbuktipiutang: $(element).find(`[name="tglbuktipiutang[]"]`).val(),
                    nominalpiutang: AutoNumeric.getNumber($(element).find(`[name="nominalpiutang[]"]`)[0]),
                    nominalbayar: AutoNumeric.getNumber($(element).find(`[name="nominalbayar[]"]`)[0]),
                    sisapiutang: AutoNumeric.getNumber($(element).find(`[name="sisapiutang[]"]`)[0]),
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

            console.log(data)

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}pelunasanpiutangheader`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}pelunasanpiutangheader/${Id}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}pelunasanpiutangheader/${Id}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}pelunasanpiutangheader`
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

    function createPelunasanPiutangHeader() {
        let form = $('#crudForm')
        $('#crudModal').find('#crudForm').trigger('reset')
        $('#crudModalTitle').text('create pelunasan piutang')
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
                form.find(`[name="nobuktipiutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="tglbuktipiutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="nominalpiutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="nominalbayar[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                form.find(`[name="sisapiutang[]"]`).prop('readonly', true).addClass('bg-white state-delete')
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

    function editPelunasanPiutangHeader(id) {
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
                showPelunasanPiutangHeader(form, id)
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

    function deletePelunasanPiutangHeader(id) {
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
                showPelunasanPiutangHeader(form, id),
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

    function viewPelunasanPiutangHeader(userId) {
        let form = $('#crudForm')
        $('.modal-loader').removeClass('d-none')

        form.data('action', 'view')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
            <i class="fa fa-save"></i>
            Save
            `)
        form.find(`.sometimes`).hide()
        // $('#crudModalTitle').text('View Piutang Header')
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
        let originalsisapiutang = parseFloat(element.parents('tr').find(` [name="originalsisapiutang[]"]`).val().replace(/,/g, ''))
        let originalnominalbayar = parseFloat(element.parents('tr').find(` [name="originalnominalbayar[]"]`).val().replace(/,/g, ''))
        let nominalbayar = parseFloat(element.parents('tr').find(` [name="nominalbayar[]"]`).val().replace(/,/g, ''))
        let sisapiutang = 0;
        if($('#crudForm').data('action') == 'edit') {
            sisapiutang = (originalsisapiutang + originalnominalbayar) - nominalbayar;
            console.log(sisapiutang)
        } else {
            sisapiutang = originalsisapiutang - nominalbayar;
        }



        if (sisapiutang < 0) {
            showDialog('sisa tidak boleh minus')
            sisapiutang = originalsisapiutang;
        }
        initAutoNumericNoDoubleZero(element.parents('tr').find(`[name="sisapiutang[]"]`).val(sisapiutang))
    }

    function showPelunasanPiutangHeader(form, userId) {
        return new Promise((resolve, reject) => {
            $('#detailList tbody').html('')
            $.ajax({
                url: `${apiUrl}pelunasanpiutangheader/${userId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    console.log(response.data)
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        if (element.is('select')) {
                            if (response.data.customernama !== null) {
                                let newOption = new Option(response.data.customernama, value);
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
                                        $('.select2-search__field').val(response.data.customernama).trigger('input');
                                        $('.select2-search__field').focus();
                                    }, 50);
                                });
                            }
                        } else if (element.hasClass('datepicker')) {
                            element.val(dateFormat(value))
                        } else {
                            element.val(value)
                        }

                        if (index == 'customernama') {
                            element.data('current-value', value)
                        }

                        if (index == 'alatbayarnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'statusnama') {
                            element.data('current-value', value)
                        }

                        if (index == 'jenispelunasanpiutangnama') {
                            element.data('current-value', value)
                        }
                    })
                    getEditPelunasanPiutangHeader(response.data.customerid, response.data.id)

                    selectIndex += 1;

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
                <th style="width: 250px; min-width: 250px;">No Bukti Piutang</th>
                <th style="width: 250px; min-width: 250px;">Tgl Bukti Piutang</th>
                <th class="wider-harga" style="width: 265px; min-width: 150px;">Nominal Piutang</th>
                <th class="wider-harga" style="width: 265px; min-width: 150px;">Nominal Bayar</th>
                <th class="wider-harga" style="width: 265px; min-width: 150px;">Nominal Sisa</th>
                <th class="wider-keterangan" style="width: 265px; min-width: 250px;">Keterangan</th>
                <th class="wider-harga" style="width: 265px; min-width: 150px;">Nominal Potongan</th>
                <th class="wider-keterangan" style="width: 265px; min-width: 250px;">Keterangan Potongan</th>
                <th class="wider-harga" style="width: 265px; min-width: 150px;">Nominal Nota Debet</th>
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
                        <input type="hidden" name="piutangid[]" class="form-control detail_stok_${selectIndex}">
                        <input type="text" name="nobuktipiutang[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="tglbuktipiutang[]" class="form-control lg-form " autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="nominalpiutang[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="nominalbayar[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
                    </td>
                    <td class="table-bold">
                        <input type="text" name="sisapiutang[]" class="form-control lg-form autonumeric text-right" autocomplete="off" >
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
            $(".wider-keterangan").remove();

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
                url: `${apiUrl}pembelianheader/default`,
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

    function getEditPelunasanPiutangHeader(customerid, id) {
        console.log(customerid)
        $.ajax({
            url: `${apiUrl}pelunasanpiutangheader/geteditpelunasanpiutangheader`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                id: id,
                customerid: customerid,
            },
            success: response => {

                // console.log(response)

                $('#detailList tbody').html('')

                if (detectDeviceType() == "desktop") {
                    let tableHeader = $(`
                            <th style="width: 50px; min-width: 50px;">No.</th>
                            <th style="width: 10px; min-width: 10px;"><input type="checkbox" class="checkbox-table" id="selectAllCheckbox" onchange="handlerSelectAll(this)"></th>
                            <th style="width: 250px; min-width: 250px;">No Bukti Piutang</th>
                            <th style="width: 250px; min-width: 250px;">Tgl Bukti Piutang</th>
                            <th class="wider-nominalpiutang" style="width: 265px; min-width: 150px;">Nominal Piutang</th>
                            <th class="wider-nominalbayar" style="width: 265px; min-width: 150px;">Nominal Bayar</th>
                            <th class="wider-sisapiutang" style="width: 265px; min-width: 150px;">Nominal Sisa</th>
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
                                        <input type="hidden" name="piutangid[]" class="form-control filled-row data_stok_${selectIndex}">
                                        <input type="text" name="nobuktipiutang[]" id="nobuktipiutangId_${selectIndex}" class="form-control filled-row lg-form" data-current-value="${data.nobuktipiutang}" autocomplete="off">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="tglbuktipiutang[]" class="form-control filled-row lg-form" autocomplete="off" ">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="nominalpiutang[]" class="form-control lg-form filled-row autonumeric-nozero " autocomplete="off" >
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="nominalbayar[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                        <input type="hidden" name="originalnominalbayar[]">
                                    </td>
                                    <td class="table-bold">
                                        <input type="text" name="sisapiutang[]" class="form-control filled-row lg-form autonumeric-nozero " autocomplete="off" >
                                        <input type="hidden" name="originalsisapiutang[]">
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
                        detailRow.find(`[name="piutangid[]"]`).val(data.id)
                        detailRow.find(`[name="nobuktipiutang[]"]`).val(data.nobuktipiutang)
                        detailRow.find(`[name="nominalpiutang[]"]`).val(data.nominalpiutang)
                        detailRow.find(`[name="nominalbayar[]"]`).val(data.nominalbayar)
                        detailRow.find(`[name="originalnominalbayar[]"]`).val(data.nominalbayar)
                        detailRow.find(`[name="sisapiutang[]"]`).val(data.sisa)
                        detailRow.find(`[name="originalsisapiutang[]"]`).val(data.sisa)
                        detailRow.find(`[name="potongan[]"]`).val(data.nominalpotongan)
                        detailRow.find(`[name="keteranganpotongan[]"]`).val(data.keteranganpotongan)
                        detailRow.find(`[name="nominalnotadebet[]"]`).val(data.nominalnotadebet)

                        const tglbuktipiutang = $.datepicker.formatDate('dd-mm-yy', new Date(data.tglbuktipiutang));
                        detailRow.find(`[name="tglbuktipiutang[]"]`).val(tglbuktipiutang);

                        if (data.pelunasanpiutangid != null) {
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

    function getPiutang() {
        $.ajax({
            url: `${apiUrl}pelunasanpiutangheader/getpiutang`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                customerid: $('#crudForm').find('[name=customerid]').val(),
            },
            success: response => {
                if (response.data.length > 0) {
                    $('#detailList tbody').html('')
                    $.each(response.data, (index, detail) => {
                        console.log(detail)
                        selectIndex = index;
                        let detailRow = $(`
                            <tr class=${detail.id}>
                                <td class="table-bold">
                                </td>
                                <td class="table-bold">
                                    <input type="checkbox" id="check[]" name="check[]" class="checkbox-table" onchange="checkboxHandler(this)">
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="nobuktipiutang[]" class="form-control lg-form " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="tglbuktipiutang[]" class="form-control lg-form " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="nominalpiutang[]" class="form-control lg-form autonumeric " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="nominalbayar[]" class="form-control lg-form autonumeric " autocomplete="off" >
                                    <input type="hidden" name="originalnominalbayar[]">
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="sisapiutang[]" class="form-control lg-form autonumeric " autocomplete="off" >
                                    <input type="hidden" name="originalsisapiutang[]">
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="keterangandetail[]" class="form-control lg-form " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="potongan[]" class="form-control lg-form autonumeric " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="keteranganpotongan[]" class="form-control lg-form " autocomplete="off" >
                                </td>
                                <td class="table-bold">
                                    <input type="text" name="nominalnotadebet[]" class="form-control lg-form autonumeric " autocomplete="off" >
                                </td>
                            </tr>`)

                        detailRow.find(`[name="check[]"]`).val(detail.id)
                        detailRow.find(`[name="nobuktipiutang[]"]`).val(detail.nobuktipiutang)
                        const tglbuktipiutang = $.datepicker.formatDate('dd-mm-yy', new Date(detail.tglbuktipiutang));
                        detailRow.find(`[name="tglbuktipiutang[]"]`).val(tglbuktipiutang);
                        detailRow.find(`[name="nominalpiutang[]"]`).val(detail.nominalpiutang)
                        detailRow.find(`[name="sisapiutang[]"]`).val(detail.nominalsisa)
                        detailRow.find(`[name="originalsisapiutang[]"]`).val(detail.nominalsisa)
                        detailRow.find(`[name="originalnominalbayar[]"]`).val(detail.nominalbayar)

                        initAutoNumericNoDoubleZero(detailRow.find(`[name="nominalpiutang[]"]`))
                        initAutoNumericNoDoubleZero(detailRow.find(`[name="sisapiutang[]"]`))
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

        $(`.jenispelunasanpiutang-lookup`).lookup({
            title: 'jenispelunasanpiutang Lookup',
            fileName: 'parameter',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'JENIS PELUNASAN',
                    subgrp: 'JENIS PELUNASAN',
                    searching: 1,
                    valueName: `jenispelunasanpiutang`,
                    searchText: `jenispelunasanpiutang-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'jenis pelunasan'
                };
            },
            onSelectRow: (jenispelunasanpiutang, element) => {

                $('#crudForm [name=jenispelunasanpiutang]').first().val(jenispelunasanpiutang.id)
                element.val(jenispelunasanpiutang.text)
                element.data('currentValue', element.val())


            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let jenispelunasanpiutang_id_input = element.parents('td').find(`[name="jenispelunasanpiutang"]`).first();
                jenispelunasanpiutang_id_input.val('');
                element.val('');
                element.data('currentValue', element.val());
            },
        });

        $('.customer-lookup').lookup({
            title: 'customer Lookup',
            fileName: 'customer',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'customer_id',
                    searchText: 'customer-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Customer'
                }
            },
            onSelectRow: (customer, element) => {
                $('#crudForm [name=customerid]').first().val(customer.id)
                element.val(customer.nama)

                getPiutang()


                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=customerid]').first().val('')
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