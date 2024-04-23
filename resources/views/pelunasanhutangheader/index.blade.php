@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
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

    @include('pelunasanhutangheader._details')
    @include('pelunasanhutangheader._modal')
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
                $(element).parents('tr').find(`[name="nominalbayar[]"]`).prop('readonly', false)
                $(element).parents('tr').find(`[name="keterangandetail[]"]`).prop('readonly', false)
                $(element).parents('tr').find(`[name="potongan[]"]`).prop('readonly', false)
                $(element).parents('tr').find(`[name="keteranganpotongan[]"]`).prop('readonly', false)
                $(element).parents('tr').find(`[name="nominalnotadebet[]"]`).prop('readonly', false)

            } else {
                $(element).parents('tr').removeClass('bg-light-blue')
                $(element).parents('tr').find(`[name="nominalbayar[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                $(element).parents('tr').find(`[name="keterangandetail[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                $(element).parents('tr').find(`[name="potongan[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                $(element).parents('tr').find(`[name="keteranganpotongan[]"]`).prop('readonly', true).addClass('bg-white state-delete')
                $(element).parents('tr').find(`[name="nominalnotadebet[]"]`).prop('readonly', true).addClass('bg-white state-delete')
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

        $(document).ready(function() {
            $("#tabs").tabs()

            let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
            loadDetailGrid()
            setRange()
            initDatepicker()

            $("#jqGrid").jqGrid({
                    url: `${apiUrl}pelunasanhutangheader`,
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
                            label: 'Supplier',
                            name: 'suppliernama',
                            align: 'left',
                            width: '180px'
                        },
                        {
                            label: 'jenis pelunasan',
                            name: 'jenispelunasanhutangmemo',
                            width: 100,
                            stype: 'select',
                            searchoptions: {
                                value: `<?php
                                        $i = 1;
                                        foreach ($data['jenispelunasanhutangmemo'] as $status) :
                                            echo "$status[param]:$status[parameter]";
                                            if ($i !== count($data['jenispelunasanhutangmemo'])) {
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
                                let jenispelunasanhutangmemo = JSON.parse(value)

                                let formattedValue = $(`
                <div class="badge" style="background-color: ${jenispelunasanhutangmemo.WARNA}; color: #fff;">
                  <span>${jenispelunasanhutangmemo.SINGKATAN}</span>
                </div>
              `)

                                return formattedValue[0].outerHTML
                            },
                            cellattr: (rowId, value, rowObject) => {

                                let jenispelunasanhutangmemo = JSON.parse(rowObject.jenispelunasanhutangmemo)

                                return ` title="${jenispelunasanhutangmemo.MEMO}"`
                            }
                        },
                        {
                            label: 'Alat Bayar',
                            name: 'alatbayarnama',
                            align: 'left',
                            width: '180px'
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
                                createPelunasanHutangHeader()
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
                                    editPelunasanHutangHeader(selectedId)
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
                                    deletePelunasanHutangHeader(selectedId, 'DELETE')
                                }
                            }
                        },
                        {
                            id: 'view',
                            innerHTML: '<i class="fa fa-eye"></i> VIEW',
                            class: 'btn btn-orange btn-sm mr-1',
                            onClick: () => {
                                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                viewPelunasanHutangHeader(selectedId)
                            }
                        }
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

            function permission() {

                if (!`{{ $myAuth->hasPermission('pelunasanhutangheader', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pelunasanhutangheader', 'show') }}`) {
                    $('#view').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pelunasanhutangheader', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pelunasanhutangheader', 'destroy') }}`) {
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
                url: `${apiUrl}pelunasanhutangheader/gethutang`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    limit: 0,
                    supplierid: $('#crudForm').find('[name=supplierid]').val(),
                },
                success: (response) => {
                    selectedRows = response.map((row) => row.id);
                    
                    selectedRows.forEach((id) => {
                        $('[name="check[]"]').parents('tr').addClass('bg-light-blue')
                        $('[name="check[]"]').prop('checked', true);

                        $(`[name="nominalbayar[]"]`).prop('readonly', false)
                        $(`[name="keterangandetail[]"]`).prop('readonly', false)
                        $(`[name="potongan[]"]`).prop('readonly', false)
                        $(`[name="keteranganpotongan[]"]`).prop('readonly', false)
                        $(`[name="nominalnotadebet[]"]`).prop('readonly', false)
                    });
                }
            })
        }
    </script>
    @endpush()
    @endsection