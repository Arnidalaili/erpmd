@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
         <div class="row form-group">
            <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                    SHIP DATE<span class="text-danger">*</span>
                </label>
            </div>
            <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                    <input type="text" name="date" id="date" class="form-control lg-form datepickerIndex">
                </div>
            </div>
        </div>
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body border-bottom-0">


                    <div id="detail-tab">
                        <table id="detailGrid"></table>
                    </div>
                    <div id="pager" style="overflow: auto!important"></div>


                </div>
            </div>
        </div>
    </div>



    <!-- Detail -->

    @include('fakturpenjualanheader._details')


    @include('fakturpenjualanheader._modal')
    @push('scripts')
    <script>
        let indexRow = 0;
        let page = 0;
        let pager = '#jqGridPager'
        let popup = "";
        let id = "";
        let triggerClick = true;
        let highlightSearch;
        let totalRecord
        let limit
        let postData
        let sortname = 'noinvoice'
        let sortorder = 'asc'
        let autoNumericElements = []
        let currentTab = 'detail'
        let selectedRows = [];

        function checkboxHandler(element) {
            let value = $(element).val();
            if (element.checked) {
                selectedRows.push($(element).val())
                $(element).parents('tr').addClass('bg-light-blue')
            } else {
                $(element).parents('tr').removeClass('bg-light-blue')
                for (var i = 0; i < selectedRows.length; i++) {
                    if (selectedRows[i] == value) {
                        selectedRows.splice(i, 1);
                    }
                }
            }

        }

        $(document).ready(function() {
            $("#tabs").tabs()

            let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
            loadDetailGrid()

            setRange()
            initDatepicker('datepickerIndex')



            $(document).on('click', '#btnReload', function(event) {
                loadDataHeader('fakturpenjualanheader')
            })

            $("#jqGrid").jqGrid({
                    url: `${apiUrl}fakturpenjualanheader`,
                    mtype: "GET",
                    styleUI: 'Bootstrap4',
                    iconSet: 'fontAwesome',
                    datatype: "json",
                    colModel: [{

                            label: 'ID',
                            name: 'id',
                            align: 'right',
                            width: '80px',
                            search: false,
                            hidden: true
                        },

                        {
                            label: 'INVOICE DATE',
                            name: 'invoicedate',
                            align: 'left',
                            formatter: "date",
                            formatoptions: {
                                srcformat: "ISO8601Long",
                                newformat: "d-m-Y"
                            }
                        },
                        {
                            label: 'NO INVOICE',
                            name: 'noinvoice',
                            align: 'left',
                            width: '170px'
                        },
                        {
                            label: 'CUSTOMER',
                            name: 'customer_name',
                            align: 'left',
                            width: '180px'
                        },
                        {
                            label: 'SHIP TO',
                            name: 'shipto',
                            align: 'left'
                        },
                        {
                            label: 'RATE',
                            name: 'rate',
                            align: 'left'
                        },
                        {
                            label: 'FOB',
                            name: 'fob',
                            align: 'left'
                        },
                        {
                            label: 'TERMS',
                            name: 'terms',
                            align: 'left',

                        },
                        {
                            label: 'FISCAL RATE',
                            name: 'fiscalrate',
                            align: 'left',

                        },
                        {
                            label: 'SHIP DATE',
                            name: 'shipdate',
                            align: 'left',
                            formatter: "date",
                            formatoptions: {
                                srcformat: "ISO8601Long",
                                newformat: "d-m-Y"
                            }
                        },
                        {
                            label: 'SHIP VIA',
                            name: 'shipvia',
                            align: 'left'
                        },
                        {
                            label: 'RECEIVABLE ACCOUNT',
                            name: 'receivableacoount',
                            align: 'left'
                        },
                        {
                            label: 'SALES NAME',
                            name: 'sales_name',
                            align: 'left'
                        },
                        {
                            label: 'MODIFIEDBY',
                            name: 'modifiedby_name',
                            align: 'left'
                        },
                        {
                            label: 'CREATEDAT',
                            name: 'created_at',
                            align: 'right',
                            formatter: "date",
                            formatoptions: {
                                srcformat: "ISO8601Long",
                                newformat: "d-m-Y H:i:s"
                            }
                        },
                        {
                            label: 'UPDATEDAT',
                            name: 'updated_at',
                            align: 'right',
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
                    // pager : '#pager',
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
                        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'noinvoice')

                        activeGrid = $(this)
                        indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                        page = $(this).jqGrid('getGridParam', 'page')
                        let limit = $(this).jqGrid('getGridParam', 'postData').limit
                        if (indexRow >= limit) {
                            indexRow = (indexRow - limit * (page - 1))
                        }
                        loadDetailData(id)


                    },
                    loadComplete: function(data) {
                        changeJqGridRowListText()

                        if (data.data.length === 0) {
                            $('#detailGrid, #historyGrid, #jurnalGrid').each((index, element) => {
                                abortGridLastRequest($(element))
                                clearGridData($(element))
                            })
                            $('#jqGrid').each((index, element) => {
                                abortGridLastRequest($(element))
                                clearGridHeader($(element))
                            })
                        }

                        $(document).unbind('keydown')
                        setCustomBindKeys($(this))
                        initResize($(this))

                        $.each(selectedRows, function(key, value) {

                            $('#jqGrid tbody tr').each(function(row, tr) {
                                if ($(this).find(`td input:checkbox`).val() == value) {
                                    $(this).find(`td input:checkbox`).prop('checked', true)
                                    $(this).addClass('bg-light-blue')
                                }
                            })

                        });

                        /* Set global variables */
                        sortname = $(this).jqGrid("getGridParam", "sortname")
                        sortorder = $(this).jqGrid("getGridParam", "sortorder")
                        totalRecord = $(this).getGridParam("records")
                        limit = $(this).jqGrid('getGridParam', 'postData').limit
                        postData = $(this).jqGrid('getGridParam', 'postData')
                        triggerClick = true

                        $('.clearsearchclass').click(function() {
                            clearColumnSearch($(this))
                        })

                        if (indexRow > $(this).getDataIDs().length - 1) {
                            indexRow = $(this).getDataIDs().length - 1;
                        }

                        setTimeout(function() {

                            if (triggerClick) {
                                if (id != '') {
                                    indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                                    $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                        .click()
                                    id = ''
                                } else if (indexRow != undefined) {
                                    $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`)
                                        .click()
                                }

                                if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                    $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                                }

                                triggerClick = false
                            } else {
                                $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                            }
                        }, 100)

                        $('#left-nav').find('button').attr('disabled', false)
                        permission()
                        setHighlight($(this))
                        $('#gs_').prop('disabled', false)
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
                .jqGrid('navGrid', '#pager', {
                    search: false,
                    refresh: false,
                    add: false,
                    edit: false,
                    del: false,
                })
                .navButtonAdd('#pager', {
                    caption: "Tambah",
                    title: "Tambah Data",
                    id: "addCustomer",
                    buttonicon: "ui-icon-plus",
                    onClickButton: function() {

                        createFakturPenjualanHeader()


                    },
                })
                .navButtonAdd('#pager', {
                    caption: "Edit",
                    title: "Edit",
                    id: "editData",
                    buttonicon: "ui-icon-pencil",
                    onClickButton: function() {
                        selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                        editFakturPenjualanHeader(selectedId)

                    }
                })
                .customPager({
                    buttons: [{
                            id: 'add',
                            innerHTML: '<i class="fa fa-plus"></i> ADD',
                            class: 'btn btn-primary btn-sm mr-1',
                            onClick: function(event) {
                                createFakturPenjualanHeader()
                            }
                        },
                        {
                            id: 'edit',
                            innerHTML: '<i class="fa fa-pen"></i> EDIT',
                            class: 'btn btn-success btn-sm mr-1',
                            onClick: function(event) {

                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                editFakturPenjualanHeader(selectedId)
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
                                    deleteFakturPenjualanHeader(selectedId)

                                }
                            }
                        },
                        {
                            id: 'view',
                            innerHTML: '<i class="fa fa-eye"></i> VIEW',
                            class: 'btn btn-orange btn-sm mr-1',
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                viewFakturPenjualanHeader(selectedId)
                            }
                        },
                        {
                            id: 'report',
                            innerHTML: '<i class="fa fa-print"></i> REPORT',
                            class: 'btn btn-info btn-sm mr-1',
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                    showDialog('Harap pilih salah satu record')
                                } else {
                                    window.open(`{{ route('fakturpenjualanheader.report') }}?id=${selectedId}`)
                                }
                            }
                        },
                        {
                            id: 'pdf',
                            innerHTML: '<i class="fa fa-print"></i> PDF',
                            class: 'btn btn-info btn-sm mr-1',
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                    showDialog('Harap pilih salah satu record')
                                } else {
                                    window.open(`{{ route('fakturpenjualanheader.pdf') }}?id=${selectedId}`)
                                }
                            }
                        },
                        {
                            id: 'export',
                            title: 'Export',
                            caption: 'Export',
                            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                            class: 'btn btn-warning btn-sm mr-1',
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                    showDialog('Harap pilih salah satu record')
                                } else {
                                    window.open(`{{ route('fakturpenjualanheader.export') }}?id=${selectedId}`)
                                }
                            }
                        },
                        {
                            id: 'import',
                            innerHTML: '<i class="fa fa-file-import"></i> IMPORT',
                            class: 'btn btn-info btn-sm mr-1',
                            onClick: () => {
                                $('#importModal').data('action', 'import')
                                $('#importModal').find('button:submit').html(`Import`)
                                $('#importModal').modal('show')
                            }
                        },

                    ]

                })
            /* Append clear filter button */
            loadClearFilter($('#jqGrid'))

            /* Append global search */
            loadGlobalSearch($('#jqGrid'))


            $('#add .ui-pg-div')
                .addClass(`btn btn-sm btn-primary`)
                .parent().addClass('px-1')

            $('#edit .ui-pg-div')
                .addClass('btn btn-sm btn-success')
                .parent().addClass('px-1')

            $('#delete .ui-pg-div')
                .addClass('btn btn-sm btn-danger')
                .parent().addClass('px-1')

            $('#report .ui-pg-div')
                .addClass('btn btn-sm btn-info')
                .parent().addClass('px-1')

            $('#pdf .ui-pg-div')
                .addClass('btn btn-sm btn-info')
                .parent().addClass('px-1')

            $('#export .ui-pg-div')
                .addClass('btn btn-sm btn-warning')
                .parent().addClass('px-1')

            function permission() {
                console.log(`{{ $myAuth->hasPermission('fakturpenjualanheader', 'store') }}`)
                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('piutangheader', 'show') }}`) {
                    $('#view').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'export') }}`) {
                    $('#export').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'report') }}`) {
                    $('#report').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'pdf') }}`) {
                    $('#pdf').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('fakturpenjualanheader', 'approval') }}`) {
                    $('#approval').addClass('ui-disabled')
                }
            }

            $('#btnImport').click(function(event) {
                event.preventDefault()

                let url = `${apiUrl}fakturpenjualanheader/import`
                let form_data = new FormData(document.getElementById('formImport'))
                let form = $('#formImport')

                $(this).attr('disabled', '')
                $('#processingLoader').removeClass('d-none')

                $.ajax({
                    url: url,
                    method: 'post',
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: form_data,
                    success: response => {

                        $('#formImport').trigger('reset')
                        $('#importModal').modal('hide')
                        $('#jqGrid').jqGrid().trigger('reloadGrid');

                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                    },
                    error: error => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.statusText)
                        }
                    },
                }).always(() => {
                    $('#processingLoader').addClass('d-none')
                    $(this).removeAttr('disabled')
                })
            })

            $('#rangeModal').on('shown.bs.modal', function() {
                if (autoNumericElements.length > 0) {
                    $.each(autoNumericElements, (index, autoNumericElement) => {
                        autoNumericElement.remove()
                    })
                }

                $('#formRange [name]:not(:hidden)').first().focus()

                $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
                $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
                $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                $('#formRange [name=sampai]').val(totalRecord)

                autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                    digitGroupSeparator: ',',
                    decimalCharacter: '.',
                    decimalPlaces: 0,
                    allowDecimalPadding: false,
                    minimumValue: 1,
                    maximumValue: totalRecord
                })
            })

            $('#formRange').submit(function(event) {
                event.preventDefault()

                let params
                let submitButton = $(this).find('button:submit')

                submitButton.attr('disabled', 'disabled')

                /* Set params value */
                for (var key in postData) {
                    if (params != "") {
                        params += "&";
                    }
                    params += key + "=" + encodeURIComponent(postData[key]);
                }

                let formRange = $('#formRange')
                let offset = parseInt(formRange.find('[name=dari]').val()) - 1
                let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
                params += `&offset=${offset}&limit=${limit}`

                if ($('#rangeModal').data('action') == 'export') {
                    let xhr = new XMLHttpRequest()
                    xhr.open('GET', `{{ config('app.api_url') }}fakturpenjualanheader/export?${params}`, true)
                    xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
                    xhr.responseType = 'arraybuffer'

                    xhr.onload = function(e) {
                        if (this.status === 200) {
                            if (this.response !== undefined) {
                                let blob = new Blob([this.response], {
                                    type: "application/vnd.ms-excel"
                                })
                                let link = document.createElement('a')

                                link.href = window.URL.createObjectURL(blob)
                                link.download = `laporanhutang${(new Date).getTime()}.xlsx`
                                link.click()

                                submitButton.removeAttr('disabled')
                            }
                        }
                    }

                    xhr.send()
                } else if ($('#rangeModal').data('action') == 'report') {
                    window.open(`{{ route('fakturpenjualanheader.report') }}?${params}`)
                    submitButton.removeAttr('disabled')
                } else if ($('#rangeModal').data('action') == 'pdf') {
                    window.open(`{{ route('fakturpenjualanheader.pdf') }}?${params}`)
                    submitButton.removeAttr('disabled')
                }
            })
        })

        function clearSelectedRows() {
            selectedRows = []

            $('#jqGrid').trigger('reloadGrid')
        }

        function selectAllRows() {
            $.ajax({
                url: `${apiUrl}fakturpenjualanheader`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val(),
                },
                success: (response) => {
                    selectedRows = response.data.map((hutang) => hutang.id)
                    console.log
                    $('#jqGrid').trigger('reloadGrid')
                }
            })
        }
    </script>
    @endpush()
    @endsection