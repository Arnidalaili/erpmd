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
</div>

@include('bank._modal')

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
    let sortname = 'id'
    let sortorder = 'asc'
    let autoNumericElements = []
    let indexRow = 0;

    $(document).ready(function() {
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
                url: `${apiUrl}hpp`,
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
                        label: 'No Bukti Keluar',
                        name: 'pengeluarannobukti',
                        align: 'left'
                    },
                    {
                        label: 'No Bukti Masuk',
                        name: 'penerimaannobukti',
                        align: 'left'
                    },
                    {
                        label: 'Product',
                        name: 'productnama',
                        align: 'left'
                    },
                    {
                        label: 'Qty',
                        name: 'pengeluaranqty',
                        formatter: currencyFormat,
                        align: 'right'
                    },
                    {
                        label: 'Harga Masuk',
                        name: 'penerimaanharga',
                        formatter: currencyFormatNoDoubleZero,
                        align: 'right',
                        formatter: function (cellvalue, options, rowObject) {
                            var formattedValue = currencyFormatNoDoubleZero(cellvalue,true);

                            // Call second formatter (fontColorFormat)
                            return fontColorFormat(formattedValue, options, rowObject,'blue');
                        },
                    },
                    {
                        label: 'Harga Keluar',
                        name: 'pengeluaranharga',
                        formatter: currencyFormatNoDoubleZero,
                        align: 'right',
                        formatter: function (cellvalue, options, rowObject) {
                            var formattedValue = currencyFormatNoDoubleZeroStok(cellvalue,true);

                            // Call second formatter (fontColorFormat)
                            return fontColorFormat(formattedValue, options, rowObject,'red');
                        },
                    },
                    {
                        label: 'Total Masuk',
                        name: 'penerimaantotal',
                        formatter: currencyFormatNoDoubleZero,
                        align: 'right',
                        formatter: function (cellvalue, options, rowObject) {
                            var formattedValue = currencyFormatNoDoubleZeroStok(cellvalue,true);

                            // Call second formatter (fontColorFormat)
                            return fontColorFormat(formattedValue, options, rowObject,'blue');
                        },
                    },
                    {
                        label: 'Total Keluar',
                        name: 'pengeluarantotal',
                        formatter: currencyFormatNoDoubleZero,
                        align: 'right',
                        formatter: function (cellvalue, options, rowObject) {
                            var formattedValue = currencyFormatNoDoubleZeroStok(cellvalue,true);

                            // Call second formatter (fontColorFormat)
                            return fontColorFormat(formattedValue, options, rowObject,'red');
                        },
                    },
                    {
                        label: 'Profit',
                        name: 'profit',
                        formatter: currencyFormatNoDoubleZero,
                        align: 'right',
                        
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
                        name: 'modifiedby',
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
                    // permission()
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

            .customPager({})

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#jqgh_jqGrid_penerimaanharga').css("color", 'blue')
        $('#jqgh_jqGrid_pengeluaranharga').css("color", 'red')
        $('#jqgh_jqGrid_penerimaantotal').css("color", 'blue')
        $('#jqgh_jqGrid_pengeluarantotal').css("color", 'red')


        $('#add .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')

        function permission() {
            if (!`{{ $myAuth->hasPermission('bank', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }
        }

        function fontColorFormat(cellvalue, options, rowObject, color) {
            var color = color;
            var cellHtml = "<span style='color:" + color + "' originalValue='" + cellvalue + "'>" + cellvalue + "</span>";
            return cellHtml;
        }

        // MODAL HIDDEN, REMOVE KOTAK MERAH
        $('#rangeModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })
    })
</script>
@endpush()
@endsection