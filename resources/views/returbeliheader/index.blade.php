@extends('layouts.master')

@section('content')
    <!-- Grid -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('layouts._rangeheader')
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
    </div>

    <!-- Detail -->

    @include('returbeliheader._details')
    @include('returbeliheader._modal')
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

            function checkboxHandler(element) {
                let value = $(element).val();
                if (element.checked) {
                    selectedRows.push($(element).val())
                    $(element).parents('tr').addClass('bg-light-blue')
                    $(element).parents('tr').find(`[name="qty[]"]`).prop('readonly', false)
                    $(element).parents('tr').find(`[name="harga[]"]`).prop('readonly', false)
                    $(element).parents('tr').find('input[type="text"]').prop('readonly',false)

                    console.log('gh', selectedRows, value, element)
                } else {
                    $(element).parents('tr').removeClass('bg-light-blue')
                    $(element).parents('tr').find(`[name="qty[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                    $(element).parents('tr').find(`[name="harga[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                    $(element).parents('tr').find('input[type="text"]').prop('readonly',true).addClass('bg-white state-delete')
                    
                    for (var i = 0; i < selectedRows.length; i++) {
                        if (selectedRows[i] == value) {
                            selectedRows.splice(i, 1);
                        }
                    }
                }
            }

            function handlerSelectAll(element) {
                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (element.checked) {
                    selectAllRows(element)
                } else {
                    clearSelectedRows(element)
                }
            }

            function getQueryStringValue(key) {
                // Mendapatkan query string dari URL
                const queryString = window.location.search;

                const urlParams = new URLSearchParams(queryString);

                return urlParams.get(key);
            }

            $(document).ready(function() {
                $("#tabs").tabs()

                let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
                loadDetailGrid()

                @isset($request['tgldari'])
                    tgldariheader = `{{ $request['tgldari'] }}`;
                @endisset
                @isset($request['tglsampai'])
                    tglsampaiheader = `{{ $request['tglsampai'] }}`;
                @endisset
                setRange(true, $.datepicker.formatDate('yy-mm-dd', new Date()))
              
                initDatepicker('datepickerIndex')

                $(document).on('click', '#btnReload', function(event) {
                    $('#jqGrid').jqGrid('setGridParam', {
                        postData: {
                            tgldari: $('#tgldariheader').val(),
                            tglsampai: $('#tglsampaiheader').val()
                        },
                    }).trigger('reloadGrid');
                    selectedRows = []
                    $('#gs_').prop('checked', false)
                })

                $("#jqGrid").jqGrid({
                        url: `${apiUrl}returbeliheader`,
                        mtype: "GET",
                        styleUI: 'Bootstrap4',
                        iconSet: 'fontAwesome',
                        datatype: "json",
                        postData: {
                            tgldari: $('#tgldariheader').val(),
                            tglsampai: $('#tglsampaiheader').val()
                        },
                        colModel: [{

                                label: 'ID',
                                name: 'id',
                                align: 'right',
                                width: '80px',
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
                                width: '170px',
                               
                            },
                            {
                                label: 'No BUkti Pembelian',
                                name: 'pembeliannobukti',
                                align: 'left',
                                width: '180px'
                            },
                            {
                                label: 'Supplier',
                                name: 'suppliernama',
                                align: 'left',
                                width: '180px'
                            },
                            {
                                label: 'keterangan',
                                name: 'keterangan',
                                align: 'left'
                            },
                            {
                                label: 'Total',
                                name: 'total',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
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

                    .customPager({
                        buttons: [{
                                id: 'add',
                                innerHTML: '<i class="fa fa-plus"></i> ADD',
                                class: 'btn btn-primary btn-sm mr-1',
                                onClick: function(event) {
                                    createReturBeliHeader()
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
                                        // editReturBeliHeader(selectedId)
                                        cekValidasiAksi(selectedId, 'EDIT')
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
                                        // deleteReturBeliHeader(selectedId, 'DELETE')
                                        cekValidasiAksi(selectedId, 'DELETE')
                                    }
                                }
                            },
                            {
                                id: 'view',
                                innerHTML: '<i class="fa fa-eye"></i> VIEW',
                                class: 'btn btn-orange btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    viewReturBeliHeader(selectedId)
                                }
                            }
                        ]
                    })
                /* Append clear filter button */
                loadClearFilter($('#jqGrid'))

                /* Append global search */
                loadGlobalSearch($('#jqGrid'))
                
                setTimeout(() => {
                    // $('#jqGrid_searchText').val(getQueryStringValue('nobukti')).trigger("input");

                    $('#gs_pembeliannobukti').val(getQueryStringValue('nobukti')).trigger("input");

                    $('#gs_pembeliannobukti').val(getQueryStringValue('nobukti'));

                    var filter = {
                        "groupOp": "AND",
                        "rules": [
                            {
                                "field": "pembeliannobukti",
                                "op": "cn",
                                "data": getQueryStringValue('nobukti')
                            }
                        ]
                    };

                    var grid = $('#jqGrid');
                    grid.jqGrid('setGridParam', {
                        datatype: 'json',
                        search: true,  // Aktifkan pencarian
                        postData: {
                            filters: JSON.stringify(filter)
                        }
                    }).trigger("reloadGrid");
                }, 100);

                $('#add .ui-pg-div')
                    .addClass(`btn btn-sm btn-primary`)
                    .parent().addClass('px-1')

                $('#edit .ui-pg-div')
                    .addClass('btn btn-sm btn-success')
                    .parent().addClass('px-1')

                $('#delete .ui-pg-div')
                    .addClass('btn btn-sm btn-danger')
                    .parent().addClass('px-1')

                function permission() {

                    if (!`{{ $myAuth->hasPermission('returbeliheader', 'store') }}`) {
                        $('#add').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('returbeliheader', 'show') }}`) {
                        $('#view').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('returbeliheader', 'update') }}`) {
                        $('#edit').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('returbeliheader', 'destroy') }}`) {
                        $('#delete').attr('disabled', 'disabled')
                    }
                }


            })

            
            function clearSelectedRows() {
                    selectedRows = []

                    $('[name="check[]"]').parents('tr').removeClass('bg-light-blue')
                    $('[name="check[]"]').prop('checked', false);
                }


            function selectAllRows(element) {
                $.ajax({
                    url: `${apiUrl}returbeliheader/getpembeliandetail`,
                    method: 'GET',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        limit: 0,
                        pembelianid: $('#crudForm').find('[name=pembelianid]').val(),
                    },
                    success: (response) => {
                        selectedRows = response.data.map((row) => row.id);

                        selectedRows.forEach((id) => {
                            $('[name="check[]"]').parents('tr').addClass('bg-light-blue')
                            $('[name="check[]"]').prop('checked', true);

                        });
                    }
                })
            }
        </script>
    @endpush()
@endsection
