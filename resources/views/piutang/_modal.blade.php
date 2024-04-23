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
                    <div class="modal-body">
                        <input type="text" name="id" class="form-control" hidden>
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
                                    no bukti <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="nobukti" class="form-control lg-form filled-row " readonly>
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
                                <input type="text" name="customernama" id="customernama" class="form-control lg-form customer-lookup filled-row" autocomplete="off" autofocus>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    tgl jatuh tempo<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <div class="input-group">
                                    <input type="text" name="tgljatuhtempo" id="tgljatuhtempo" class="form-control lg-form datepicker filled-row">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group nominalpiutang">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label ">
                                    nominal piutang<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="originalnominalpiutang" class="form-control" hidden>
                                <input type="text" name="nominalpiutang" id="nominalpiutang" class="form-control  text-right lg-form filled-row" value="0">
                            </div>
                        </div>
                        <div class="row form-group nominalbayar">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label ">
                                    nominal bayar<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="orinominalbayarpiutang" class="form-control" hidden>
                                <input type="text" name="nominalbayar" id="nominalbayar" class="form-control  text-right lg-form filled-row" value="0">
                            </div>
                        </div>
                        <div class="row form-group nominalsisa">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label ">
                                    nominal sisa<span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-12 col-md-10">
                                <input type="text" name="orinominalsisapiutang" class="form-control" hidden>
                                <input type="text" name="nominalsisa" id="nominalsisa" class="form-control  text-right lg-form filled-row" value="0">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Keterangan
                                </label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <input type="text" name="keterangan" class="form-control">
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

    $(document).on('input', '#crudForm [name="nominalbayar"]', function(event) {
        setNominalSisa($(this));
    });

    $(document).on('input', '#crudForm [name="nominalpiutang"]', function(event) {
        setNominalBayar($(this));
        setNominalSisa($(this))
    });

    $(document).ready(function() {
        $('#btnSubmit').click(function(event) {
            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let piutangId = form.find('[name=id]').val()
            let action = form.data('action')
            let data = $('#crudForm').serializeArray()

            $('#crudForm').find(`.filled-row[name="nominalpiutang"]`).each((index, element) => {
                data.filter((row) => row.name === 'nominalpiutang')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="nominalpiutang"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="nominalbayar"]`).each((index, element) => {
                data.filter((row) => row.name === 'nominalbayar')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="nominalbayar"]`)[index])
            })

            $('#crudForm').find(`.filled-row[name="nominalsisa"]`).each((index, element) => {
                data.filter((row) => row.name === 'nominalsisa')[index].value = AutoNumeric.getNumber($(`#crudForm  .filled-row[name="nominalsisa"]`)[index])
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

            switch (action) {
                case 'add':
                    method = 'POST'
                    url = `${apiUrl}piutang`
                    break;
                case 'edit':
                    method = 'PATCH'
                    url = `${apiUrl}piutang/${piutangId}`
                    break;
                case 'delete':
                    method = 'DELETE'
                    url = `${apiUrl}piutang/${piutangId}`
                    break;
                default:
                    method = 'POST'
                    url = `${apiUrl}piutang`
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
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    id = response.data.id
                    $('#jqGrid').jqGrid('setGridParam', {
                            page: response.data.page
                        })
                        .trigger('reloadGrid');

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
        let form = $('#crudForm')

        setFormBindKeys(form)

        activeGrid = null


        initLookup()
        initDatepicker()
    })

    $('#crudModal').on('hidden.bs.modal', () => {
        activeGrid = '#jqGrid'
        $('#crudModal').find('.modal-body').html(modalBody)
        $(".ui-jqgrid-bdiv").removeClass("bdiv-lookup");
    })

    function createPiutang() {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('create piutang')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.data('action', 'add')
        form.find(`.sometimes`).show()
        $('#crudModalTitle').text('Create Piutang')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children().val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgljatuhtempo]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showDefault(form)
                    .then(() => {
                        $('#crudModal').modal('show')
                        form.find(`[name="nobukti"]`).prop('readonly', true)
                        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        // form.find('[name=tgljatuhtempo]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        form.find(`[name="nominalsisa"]`).prop('readonly', true).addClass('bg-white state-delete')
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
        initAutoNumericNoDoubleZero(form.find(`[name="nominalpiutang"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="nominalbayar"]`))
        initAutoNumericNoDoubleZero(form.find(`[name="nominalsisa"]`))
    }

    // function setNominalSisa(element, id = 0) {
    //     let orinominalsisapiutang = parseFloat($(`#crudForm [name="orinominalsisapiutang"]`).val().replace(/,/g, ''))
    //     let orinominalbayarpiutang = parseFloat($(`#crudForm [name="orinominalbayarpiutang"]`).val().replace(/,/g, ''))

    //     let nominalbayar = parseFloat($(`#crudForm [name="nominalbayar"]`).val().replace(/,/g, ''))

    //     let nominalsisa = 0;

    //     if (isNaN(nominalbayar) || nominalbayar === 0) {
    //         nominalsisa = orinominalsisapiutang
    //     } else {
    //         nominalsisa = orinominalsisapiutang - nominalbayar;
    //     }

    //     if (nominalsisa < 0) {
    //         showDialog('sisa tidak boleh minus')
    //         nominalsisa = orinominalsisapiutang;
    //     }
    //     initAutoNumericNoDoubleZero($(`#crudForm [name="nominalsisa"]`).val(nominalsisa))
    // }


    function setNominalBayar(element, id = 0) {
        $(`.nominalbayar`).remove()

        var newNominalBayarFormGroup = $('<div class="row form-group nominalbayar">' +
            '<div class="col-12 col-sm-3 col-md-2">' +
            '<label class="col-form-label">nominal bayar<span class="text-danger">*</span></label>' +
            '</div>' +
            '<div class="col-12 col-md-10">' +
            '<input type="text" name="orinominalbayarpiutang" class="form-control" hidden>' +
            '<input type="text" name="nominalbayar" id="nominalbayar" class="form-control text-right lg-form filled-row" value="0">' +
            '</div>' +
            '</div>');

        newNominalBayarFormGroup.insertAfter('.nominalpiutang');

        let nominalpiutang = parseFloat($(`#crudForm [name="nominalpiutang"]`).val().replace(/,/g, ''))
        let nominalbayar = nominalpiutang

        initAutoNumericNoDoubleZero($(`#crudForm [name="nominalbayar"]`).val(nominalbayar))
    }

    function setNominalSisa(element) {
        // $(`.nominalsisa`).remove()
        let nominalpiutang = parseFloat($(`#crudForm [name="nominalpiutang"]`).val().replace(/,/g, ''))
        let nominalbayar = parseFloat($(`#crudForm [name="nominalbayar"]`).val().replace(/,/g, ''))

        let nominalsisa = nominalpiutang - nominalbayar

        if (nominalsisa < 0) {
            showDialog('sisa tidak boleh minus')
            nominalsisa = nominalpiutang;
        }

        if (element.val().length == 0) {
            $('.nominalsisa').remove();

            // Membuat elemen baru untuk 'nominalsisa'
            var newNominalSisaFormGroup = $('<div class="row form-group nominalsisa">' +
                '<div class="col-12 col-sm-3 col-md-2">' +
                '<label class="col-form-label">' +
                'nominal sisa<span class="text-danger">*</span>' +
                '</label>' +
                '</div>' +
                '<div class="col-12 col-md-10">' +
                '<input type="text" name="originalnominalsisa" class="form-control" hidden>' +
                '<input type="text" name="nominalsisa" id="nominalsisa" class="form-control bg-white state-delete text-right lg-form filled-row" value="0" readonly>' +
                '</div>' +
                '</div>');

            // Menyisipkan elemen baru setelah elemen dengan kelas 'nominalbayar'
            newNominalSisaFormGroup.insertAfter('.nominalbayar');

            initAutoNumericNoDoubleZero($(`#crudForm [name="nominalsisa"]`).val(nominalpiutang))
        }else{
            initAutoNumericNoDoubleZero($(`#crudForm [name="nominalsisa"]`).val(nominalsisa))
        }

        
    }

    function editPiutang(piutangId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('edit piutang')
        form.data('action', 'edit')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Edit piutang')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showPiutang(form, piutangId)
                    .then(() => {
                        $('#crudModal').modal('show')
                        form.find(`[name="nobukti"]`).prop('readonly', true)
                        form.find(`[name="customernama"]`).prop('readonly', true).addClass('bg-white state-delete')
                        form.find('[name=tglbukti]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        // form.find('[name=tgljatuhtempo]').parents('.input-group').find('.ui-datepicker-trigger').attr('disabled', true)
                        form.find(`[name="customernama"]`).parents('.input-group').find('.lookup-toggler').attr('disabled', true)
                        form.find(`[name="nominalsisa"]`).prop('readonly', true).addClass('bg-white state-delete')

                        initAutoNumericNoDoubleZero(form.find(`[name="nominalpiutang"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="nominalbayar"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="nominalsisa"]`))

                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function deletePiutang(piutangId) {
        let form = $('#crudForm')

        $('.modal-loader').removeClass('d-none')
        $('#crudModalTitle').text('delete piutan g')
        form.data('action', 'delete')
        form.trigger('reset')
        form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
        form.find(`.sometimes`).hide()
        $('#crudModalTitle').text('Delete piutang')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        Promise
            .all([
                getMaxLength(form)
            ])
            .then(() => {
                showPiutang(form, piutangId)
                    .then(() => {
                        $('#crudModal').modal('show')

                        form.find(`[name="tglbukti"]`).prop('readonly', true)
                        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
                        initAutoNumericNoDoubleZero(form.find(`[name="nominalpiutang"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="nominalbayar"]`))
                        initAutoNumericNoDoubleZero(form.find(`[name="nominalsisa"]`))
                    })
                    .catch((error) => {
                        showDialog(error.statusText)
                    })
                    .finally(() => {
                        $('.modal-loader').addClass('d-none')
                    })
            })
    }

    function getMaxLength(form) {
        if (!form.attr('has-maxlength')) {
        return new Promise((resolve, reject) => {
            $.ajax({
            url: `${apiUrl}piutang/field_length`,
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

                form.find(`[name=suppliernama]`).attr('maxlength', 100)
                form.find(`[name=nominalhutang]`).attr('maxlength', 18)
                form.find(`[name=nominalbayar]`).attr('maxlength', 18)
                form.find(`[name=nominalsisa]`).attr('maxlength', 18)
                
                })
                dataMaxLength = response.data
                form.attr('has-maxlength', true)
                resolve()
            },
            error: error => {
                showDialog(error.statusText)
                reject()
            }
            })
        })
        } else {

        return new Promise((resolve, reject) => {
            $.each(dataMaxLength, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
                form.find(`[name=${index}]`).attr('maxlength', value)
            }
            })
            resolve()
        })
        }
    }

    function showPiutang(form, piutangId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}piutang/${piutangId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)

                        let penjualannobukti = response.data.penjualannobukti 

                        if (penjualannobukti != null) {
                            form.find(`[name="nominalpiutang"]`).prop('readonly',true).addClass('bg-white state-delete')
                            
                        }

                        if (element.is('select')) {
                            if (response.data.suppliernama !== null) {
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

                        if (index == 'suppliernama') {
                            element.data('current-value', value)
                        }
                    })

                    form.find(`[name="orinominalsisapiutang"]`).val(response.data.nominalpiutang)
                    form.find(`[name="orinominalbayarpiutang"]`).val(response.data.nominalbayar)
                    form.find(`[name="originalnominalpiutang"]`).val(response.data.nominalpiutang)


                    if (form.data('action') === 'delete') {
                        form.find('[name]').addClass('disabled')
                        initDisabled()
                    }
                    resolve()
                },
                error: error => {
                    reject(error)
                }
            })
        })
    }

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}piutang/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    console.log(response);
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        
                        // let elementIndex = $('#formRange').find(`[name="${index}"]`)

                        console.log($('#formRange'));
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

    function cekValidasiAksi(Id, Aksi) {
        $.ajax({
            url: `{{ config('app.api_url') }}piutang/${Id}/cekValidasiAksi`,
            method: 'POST',
            dataType: 'JSON',
            beforeSend: request => {
                request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
            },
            success: response => {
                var error = response.error
                if (error) {
                    showDialog(response)
                } else {
                    if (Aksi == 'EDIT') {
                        editPiutang(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePiutang(Id)
                    }
                }

            }
        })
    }

    function setTglJatuhTempo(top) {
        var tglbukti = $('#crudForm').find('[name="tglbukti"]').val();
        var tgljatuhtempo = new Date();
        tglbukti = new Date();

        if (top == 11) {
            tgljatuhtempo = tglbukti
        } else {
            var month = tglbukti.getMonth();
            tgljatuhtempo.setMonth(month + 1)
        }

        var tahun = tgljatuhtempo.getFullYear();
        var bulan = tgljatuhtempo.getMonth() + 1;
        var tanggal = tgljatuhtempo.getDate();

        $('#crudForm').find("[name=tgljatuhtempo]").val(tanggal + "-" + bulan + "-" + tahun);
        // $('#crudForm').find("[name=tgljatuhtempo]").prop('readonly', true);
        // $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
    }

    function initLookup() {
        $('.customer-lookup').lookup({
            title: 'customer Lookup',
            fileName: 'customer',
            typeSearch: 'ALL',
            searching: 2,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 2,
                    valueName: 'customer_id',
                    searchText: 'customer-lookup',
                    singleColumn: true,
                    hideLabel: true,
                    title: 'customer',
                }
            },
            onSelectRow: (customer, element) => {
                $('#crudForm [name=customerid]').first().val(customer.id)
                setTglJatuhTempo(customer.top)
                element.val(customer.nama)
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
    }
</script>
@endpush()