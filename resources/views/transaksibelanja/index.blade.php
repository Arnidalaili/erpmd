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
    @include('transaksibelanja._modaleditalltransaksibelanja')
    @include('transaksibelanja._modal')

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
            let sortname = 'tglbukti'
            let sortorder = 'desc'
            let autoNumericElements = []

            $(document).ready(function() {
                $("#tabs").tabs()

                initDatepicker()

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

                })

                $("#jqGrid").jqGrid({
                        url: `${apiUrl}transaksibelanja`,
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
                                label: 'Perkiraan',
                                name: 'perkiraannama',
                                align: 'left',
                                width: '180px'
                            },
                            // {
                            //     label: 'perkiraan flag',
                            //     name: 'perkiraanflag',
                            //     align: 'right',
                            //     width: '80px',
                            // },
                            {
                                label: 'Karyawan',
                                name: 'karyawannama',
                                align: 'left',
                                width: '180px'
                            },
                            {
                                label: 'No Bukti Pembelian',
                                name: 'pembeliannobukti',
                                align: 'left',
                                width: '180px'
                            },
                            {
                                label: 'nominal',
                                name: 'nominal',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                                width: '170px'
                            },
                            {
                                label: 'keterangan',
                                name: 'keterangan',
                                align: 'left',
                                width: '350px'
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
                        // footerrow: true,
                        userDataOnFooter: true,
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

                            activeGrid = $(this)
                            indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                            page = $(this).jqGrid('getGridParam', 'page')
                            let limit = $(this).jqGrid('getGridParam', 'postData').limit
                            if (indexRow >= limit) {
                                indexRow = (indexRow - limit * (page - 1))
                            }
                        },
                        loadComplete: function(data) {
                            changeJqGridRowListText()

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

                            // if (data.attributes) {
                            //     $(this).jqGrid('footerData', 'set', {
                            //         tglbukti: 'Total Panjar:',
                            //         nominal: data.attributes.totalPanjar,
                            //     }, true)
                            // }

                            // $('#card-footer').html('')

                            var col = detectDeviceType() === "desktop" ? 'col-1' : detectDeviceType() === "mobile" ? 'col-4' : '';

                            var footerGridCustom = $(`
                            <div class="card" id="card-footer">
                                <div class="card-body">
                                    <div id="footer-grid">
                                        <div class="row">
                                            <div class="${col}">
                                                <p><strong>TOTAL PANJAR</strong></p>
                                                <p><strong>TOTAL BIAYA</strong></p>
                                                <p><strong>TOTAL SISA</strong></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>
                                                        <p>:</p>
                                                        <p>:</p>
                                                        <p>:</p>
                                                    </b>
                                                </div>
                                              
                                            </div>
                                            <div class="col-6">
                                                <strong><p><span id="total-panjar" class="autonumeric-nozero2"></span></p>
                                                <p><span id="total-biaya" class="autonumeric-nozero2"></span></p>
                                                <p><span id="total-sisa" class="autonumeric-nozero2"></span></p></strong>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        `);

                        if ($('#card-footer').length === 0) {
                            if (detectDeviceType() == "desktop") {
                                footerGridCustom.insertBefore('.bg-white.grid-pager');
                            }else if(detectDeviceType() == "mobile"){
                                footerGridCustom.insertBefore('.grid-overflow');

                            }
                          
                        }
                            $(document).ready(function() {
                                $("#total-panjar").text(data.attributes.totalPanjar || 0);
                                $("#total-biaya").text(data.attributes.totalBiaya || 0);
                                $("#total-sisa").text(data.attributes.totalSisa);
                                initAutoNumericTransakiBelanjaArmada($('#total-panjar'));
                                initAutoNumericTransakiBelanjaArmada($('#total-biaya'));
                                initAutoNumericTransakiBelanjaArmada($('#total-sisa'));
                            });
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
                                    createTransaksiBelanja()
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
                                        cekValidasiAksi(selectedId, 'EDIT')
                                    }
                                }
                            },
                            {
                                id: 'editall',
                                innerHTML: '<i class="fa fa-pen"></i> INPUT ALL',
                                class: 'btn btn-success btn-sm mr-1',
                                onClick: function(event) {
                                    editAllTransaksiBelanja()

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
                                id: 'view',
                                innerHTML: '<i class="fa fa-eye"></i> VIEW',
                                class: 'btn btn-orange btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    viewTransaksiBelanja(selectedId)
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
                    .addClass(`btn btn-sm btn-primary`)
                    .parent().addClass('px-1')

                $('#edit .ui-pg-div')
                    .addClass('btn btn-sm btn-success')
                    .parent().addClass('px-1')

                $('#delete .ui-pg-div')
                    .addClass('btn btn-sm btn-danger')
                    .parent().addClass('px-1')

                function permission() {

                    if (!`{{ $myAuth->hasPermission('transaksibelanja', 'store') }}`) {
                        $('#add').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('transaksibelanja', 'show') }}`) {
                        $('#view').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('transaksibelanja', 'update') }}`) {
                        $('#edit').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('transaksibelanja', 'destroy') }}`) {
                        $('#delete').attr('disabled', 'disabled')
                    }
                }
            })
        </script>
    @endpush()
@endsection
