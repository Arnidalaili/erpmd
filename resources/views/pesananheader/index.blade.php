@extends('layouts.master')

@section('content')
    <!-- Grid -->
    <div class="container-fluid">
        <div class="row">
            {{-- <a onclick="bacascript()" class="btn btn-outline-primary btn-block">Make a Push Notification!</a> --}}

            <div class="col-12">
                <table id="jqGrid"></table>
            </div>
        </div>
    </div>

    <!-- Detail -->
    @include('pesananheader._details')
    @include('pesananheader._modal')
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
            let sortname = 'nobukti'
            let sortorder = 'desc'
            let autoNumericElements = []
            let currentTab = 'detail'
            let selectedRows = [];

            function bacascript() {
                    $.ajax({
                        url: "{{ route('pushdapatnotif') }}",
                        type: 'POST',
                        success: function(data) {
                            // var audio = new Audio(`${appUrl}/public/libraries/tas-lib/audio/suara.wav`);
                            // audio.play();
                            console.log(data);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                }
                
            $(document).ready(function() {
                $("#tabs").tabs()
                let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
                loadDetailGrid()
                setRange()
                initDatepicker()

                

                $("#jqGrid").jqGrid({
                        url: `${apiUrl}pesananheader`,
                        mtype: "GET",
                        styleUI: 'Bootstrap4',
                        iconSet: 'fontAwesome',
                        postData: {
                            periode: $('#formCrud').find('[name=periode]').val(),
                        },
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
                                label: 'CUSTOMER',
                                name: 'customernama',
                                align: 'left',
                                width: '180px'
                            },
                            {
                                label: 'NO BUKTI',
                                name: 'nobukti',
                                align: 'left',
                                width: '170px'
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
                                label: 'alamat pengiriman',
                                name: 'alamatpengiriman',
                                align: 'left',
                                width: 300
                            },
                            {
                                label: 'tgl pengiriman',
                                name: 'tglpengiriman',
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
                                    foreach ($data['statusmemo'] as $status):
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusmemo'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
                                    
                                    ?>
                                    `,
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
                                label: 'status 2',
                                name: 'status2memo',
                                width: 100,
                                stype: 'select',
                                searchoptions: {
                                    value: `<?php
                                    $i = 1;
                                    foreach ($data['status2memo'] as $status):
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['status2memo'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
                                    
                                    ?>
                                    `,
                                    dataInit: function(element) {
                                        $(element).select2({
                                            width: 'resolve',
                                            theme: "bootstrap4"
                                        });
                                    }
                                },
                                formatter: (value, options, rowData) => {
                                   
                                    let status2 = JSON.parse(value)

                                    if (!status2) {
                                        
                                        return ''
                                    }

                                    let formattedValue = $(`
                                        <div class="badge" style="background-color: ${status2.WARNA}; color: #fff;">
                                        <span>${status2.SINGKATAN}</span>
                                        </div>
                                    `)

                                    return formattedValue[0].outerHTML
                                },
                                cellattr: (rowId, value, rowObject) => {

                                    let status2 = JSON.parse(rowObject.status2memo)
                                    if (!status2) {
                                        return ` title=""`
                                    }
                                    return ` title="${status2.MEMO}"`
                                }
                            },
                           
                            {
                                label: 'MODIFIEDBY',
                                name: 'modifiedby_name',
                                align: 'left'
                            },
                            {
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
                            // let nobukti = $('#jqGrid').jqGrid('getCell', id, 'noinvoice')

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
                                $('#detailGrid').each((index, element) => {
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
                    .customPager({
                        buttons: [{
                                id: 'add',
                                innerHTML: '<i class="fa fa-plus"></i> ADD',
                                class: 'btn btn-primary btn-sm mr-1',
                                onClick: function(event) {
                                    createPesananHeader()
                                }
                            },
                            {
                                id: 'view',
                                innerHTML: '<i class="fa fa-eye"></i> VIEW',
                                class: 'btn btn-orange btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                        showDialog('Harap pilih salah satu record')
                                    } else {
                                        viewPesananHeader(selectedId)
                                    }
                                    
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
                                        window.open(`{{ route('pesananheader.report') }}?id=${selectedId}`)
                                    }
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

                $('#export .ui-pg-div')
                    .addClass('btn btn-sm btn-warning')
                    .parent().addClass('px-1')

                function permission() {

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'store') }}`) {
                        $('#add').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'show') }}`) {
                        $('#view').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'update') }}`) {
                        $('#edit').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'destroy') }}`) {
                        $('#delete').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'export') }}`) {
                        $('#export').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('pesananheader', 'report') }}`) {
                        $('#report').attr('disabled', 'disabled')
                    }
                    if (!`{{ $myAuth->hasPermission('pesananheader', 'approval') }}`) {
                        $('#approval').addClass('ui-disabled')
                    }
                }

                $('#rangeModal').on('shown.bs.modal', function() {
                    if (autoNumericElements.length > 0) {
                        $.each(autoNumericElements, (index, autoNumericElement) => {
                            autoNumericElement.remove()
                        })
                    }

                    $('#formRange [name]:not(:hidden)').first().focus()

                    autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                        digitGroupSeparator: ',',
                        decimalCharacter: '.',
                        decimalPlaces: 0,
                        allowDecimalPadding: false,
                        minimumValue: 1,
                        maximumValue: totalRecord
                    })
                })
            })
        </script>
    @endpush()
@endsection
