@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- @include('layouts._rangeheader') --}}
            <div class="card card-easyui bordered mb-4">
                <div class="card-header"></div>
                <form id="rangeHeader">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tgldariheader" id="tgldariheader" class="form-control datepickerIndex">
                                </div>
                            </div>
                            <div class="col-sm-1 mt-2 text-center">
                                <label class="mt-2">s/d</label>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="tglsampaiheader" id="tglsampaiheader" class="form-control datepickerIndex">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Jenis<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="jenisid" class="form-control filled-row">
                                    <input type="text" name="jenisnama" id="jenisnama" class="form-control jenis-lookup" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Supplier<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="supplieridindex" id="supplieridindex" class="form-control filled-row">
                                    <input type="hidden" name="flag" id="flagindex" class="filled-row">
                                    <input type="text" name="suppliernamaindex" id="suppliernamaindex" class="form-control supplierindex-lookup" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        @stack('addtional-field')
                        <div class="row">
                            <div class="col-sm-6 mt-4">
                                <a id="btnReload" class="btn btn-primary mr-2 ">
                                    <i class="fas fa-sync-alt"></i>
                                    Reload
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@include('hutang._modal')

@push('scripts')
<script>
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'nobukti'
    let sortorder = 'desc'
    let autoNumericElements = []
    let indexRow = 0;
    let tgldariheader
    let tglsampaiheader

    $(document).ready(function() {
        @isset($request['tgldari'])
        tgldariheader = `{{ $request['tgldari'] }}`;
        @endisset
        @isset($request['tglsampai'])
        tglsampaiheader = `{{ $request['tglsampai'] }}`;
        @endisset
        setRange(true, $.datepicker.formatDate('yy-mm-dd', new Date()))

        initDatepicker('datepickerIndex')
        initLookupIndex()

        $('#jenisnama').val(`<?php echo $data['jenis'][1]['param']; ?>`)

        $(document).on('click', '#btnReload', function(event) {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val(),
                    jenis: $('#jenisnama').val(),
                    supplier: $('#supplieridindex').val(),
                    flag: $('#flagindex').val()
                },
            }).trigger('reloadGrid');
            selectedRows = []
            $('#gs_').prop('checked', false)
        })

        $("#jqGrid").jqGrid({
                url: `${apiUrl}hutang`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val(),
                    jenis: $('#jenisnama').val(),
                    supplier: $('#supplieridindex').val(),
                    flag: $('#flagindex').val()
                },
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '70px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'tgl bukti',
                        name: 'tglbukti',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        align: 'left',
                        width: '170px'
                    },
                    {
                        label: 'SUPPLIER',
                        name: 'suppliernama',
                        align: 'left',
                        width: '180px'
                    },
                    {
                        label: 'tgl jatuh tempo',
                        name: 'tgljatuhtempo',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'nominalhutang',
                        name: 'nominalhutang',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'nominalbayar',
                        name: 'nominalbayar',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'nominalsisa',
                        name: 'nominalsisa',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'No Bukti Pembelian',
                        name: 'pembeliannobukti',
                        align: 'left',
                        width: '180px'
                    },
                    {
                        label: 'tgl bukti pembelian',
                        name: 'tglbuktipembelian',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangan',
                        align: 'left'
                    },
                    {
                        label: 'Status',
                        name: 'statusmemo',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusmemo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusmemo'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
                                    ?>`,
                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let status = JSON.parse(value)

                            let formattedValue = $(`
                                <div class="badge" style="background-color: ${status.WARNA}; color: #fff;">
                                <span>${status.SINGKATAN}</span>
                                </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {

                            let status = JSON.parse(rowObject.statusmemo)

                            return ` title="${status.MEMO}"`
                        }
                    },
                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby_name',
                        align: 'left'
                    }, {
                        label: 'CREATEDAT',
                        name: 'created_at',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATEDAT',
                        name: 'updated_at',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
                viewrecords: true,
                prmNames: {
                    sort: 'sortIndex',
                    order: 'sortOrder',
                    rows: 'limit'
                },
                jsonReader: {
                    root: 'data',
                    total: 'attributes.totalPages',
                    records: 'attributes.totalRows',
                },
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                    id = $(this).jqGrid('getCell', id, 'rn') - 1
                    indexRow = id
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#jqGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridHeader($(element))
                        })
                    }
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        highlightSearch = ''
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    if (triggerClick) {
                        if (id != '') {
                            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                            $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            id = ''
                        } else if (indexRow != undefined) {
                            $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                        }

                        if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                            $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                        }

                        triggerClick = false
                    } else {
                        $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                    }

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
                }
            })

            .jqGrid("setLabel", "rn", "No.")
            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    abortGridLastRequest($(this))
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: () => {
                            createHutang()
                        }
                    },
                    {
                        id: 'edit',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: function(event) {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                editHutang(selectedId)
                            }
                        }
                    },
                    {
                        id: 'delete',
                        innerHTML: '<i class="fa fa-trash"></i> DELETE',
                        class: 'btn btn-danger btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasiAksi(selectedId, 'DELETE')
                            }
                        }
                    },
                    {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> LAPORAN',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            $('#formRangeTgl').data('action', 'report')
                            $('#rangeTglModal').find('button:submit').html(`Report`)
                            $('#rangeTglModal').modal('show')
                        }
                    },
                ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#add .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn-sm btn-danger')
            .parent().addClass('px-1')

        function permission() {
            if (!`{{ $myAuth->hasPermission('karyawan', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('karyawan', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('karyawan', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }
        }

        $('#rangeModal').on('shown.bs.modal', function() {
            if (autoNumericElements.length > 0) {
                $.each(autoNumericElements, (index, autoNumericElement) => {
                    autoNumericElement.remove()
                })
            }

            $('#formRange [name]:not(:hidden)').first().focus()

            $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
            $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
            if (page == 0) {
                $('#formRange [name=dari]').val(page)
                $('#formRange [name=sampai]').val(totalRecord)
            } else {
                $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                $('#formRange [name=sampai]').val(totalRecord)
            }

            autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 0,
                allowDecimalPadding: false,
                minimumValue: 1,
                maximumValue: totalRecord
            })
        })

        // MODAL HIDDEN, REMOVE KOTAK MERAH
        $('#rangeModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        function initLookupIndex() {
            $('.supplierindex-lookup').lookup({
                title: 'supplier Lookup',
                fileName: 'supplier',
                typeSearch: 'ALL',
                searching: 1,
                beforeProcess: function(test) {
                    this.postData = {
                        Aktif: 'AKTIF',
                        searching: 1,
                        valueName: 'supplier_id',
                        searchText: 'supplierindex-lookup',
                        singleColumn: true,
                        hideLabel: true,
                        title: 'Supplier',
                        ownerid: true,
                    }
                },
                onSelectRow: (supplier, element) => {
                    console.log('masuk kemari');
                    if (supplier.flag == 'owner') {
                        // console.log('owner');
                        $('#rangeHeader [name=supplieridindex]').first().val(supplier.ownerid)
                        $('#rangeHeader [name=flag]').first().val(supplier.flag)
                    } else if (supplier.flag == 'supplier') {
                        console.log('owner');
                        $('#rangeHeader [name=supplieridindex]').first().val(supplier.supplierid)
                        $('#rangeHeader [name=flag]').first().val(supplier.flag)
                    }

                    element.val(supplier.nama)
                    element.data('currentValue', element.val())
                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                    $('#rangeHeader [name=supplieridindex]').first().val('')
                    $('#rangeHeader [name=flag]').first().val('')
                    element.val('')
                    element.data('currentValue', element.val())
                }
            })


            $(`.jenis-lookup`).lookup({
                title: 'jenis Lookup',
                fileName: 'parameter',
                beforeProcess: function() {
                    this.postData = {
                        url: `${apiUrl}parameter/combo`,
                        grp: 'JENIS HUTANG PIUTANG',
                        subgrp: 'JENIS HUTANG PIUTANG',
                        searching: 1,
                        valueName: `jenisid`,
                        searchText: `jenisindex-lookup`,
                        singleColumn: true,
                        hideLabel: true,
                        title: 'jenis'
                    };
                },
                onSelectRow: (jenis, element) => {

                    $('#crudForm [name=jenisnama]').first().val(jenis.id)
                    element.val(jenis.text)
                    element.data('currentValue', element.val())


                },
                onCancel: (element) => {
                    element.val(element.data('currentValue'));
                },
                onClear: (element) => {
                    let jenis_id_input = element.parents('td').find(`[name="jenisid"]`).first();
                    jenis_id_input.val('');
                    element.val('');
                    element.data('currentValue', element.val());
                },
            });
        }
    })
</script>
@endpush()
@endsection