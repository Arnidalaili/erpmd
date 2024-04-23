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

<!-- Detail -->

@include('penjualanheader._details')
@include('penjualanheader._modal')
@include('penjualanheader._modaleditallpenjualan')

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
    let tgldariheader
    let tglsampaiheader



            let modalReport = $('#rangeTglModal').find('.modal-body').html()
            let modalReportDetail = $('#rangeTglModalInv').find('.modal-body').html()

            $('#rangeTglModal').on('hidden.bs.modal', () => {
                $('#rangeTglModal').find('.modal-body').html(modalReport)
                initDatepicker('datepickerIndex')
            })
            $('#rangeTglModalInv').on('hidden.bs.modal', () => {
                $('#rangeTglModalInv').find('.modal-body').html(modalReportDetail)
                initDatepicker('datepickerIndex')
            })


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

        @isset($request['tgldariheader'])
        tgldariheader = `{{ $request['tgldariheader'] }}`;
        @endisset
        @isset($request['tglsampaiheader'])
        tglsampaiheader = `{{ $request['tglsampaiheader'] }}`;
        @endisset
        setRange(true, $.datepicker.formatDate('yy-mm-dd', new Date()))


        initDatepicker('datepickerIndex')

        $(document).on('click', '#btnReload', function(event) {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldariheader: $('#tgldariheader').val(),
                    tglsampaiheader: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
            selectedRows = []
            $('#gs_').prop('checked', false)
        })

        $(document).on('change', `#formCrud [name="tgldariheader"]`, function() {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldariheader: $('#tgldariheader').val(),
                    tglsampaiheader: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
        });

        $(document).on('change', `#formCrud [name="tglsampaiheader"]`, function() {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    tgldariheader: $('#tgldariheader').val(),
                    tglsampaiheader: $('#tglsampaiheader').val()
                },
            }).trigger('reloadGrid');
        });

        $("#jqGrid").jqGrid({
                url: `${apiUrl}penjualanheader`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    tgldariheader: $('#tgldariheader').val(),
                    tglsampaiheader: $('#tglsampaiheader').val()
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
                        label: 'top',
                        name: 'topmemo',
                        width: 100,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['topmemo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['topmemo'])) {
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
                            let top = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${top.WARNA}; color: #fff;">
                  <span>${top.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {

                            let top = JSON.parse(rowObject.topmemo)

                            return ` title="${top.MEMO}"`
                        }
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        align: 'left',
                        width: '170px',

                    },
                    {
                        label: 'tgl bukti',
                        name: 'tglbukti',
                        align: 'left',
                        // width: '110px',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
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
                        label: 'NO BUKTI PESANAN FINAL',
                        name: 'pesananfinalnobukti',
                        align: 'left',
                        width: '200px'
                    },

                    {
                        label: 'alamat pengiriman',
                        name: 'alamatpengiriman',
                        align: 'left',
                        width: 300
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangan',
                        align: 'left'
                    },
                    {
                        label: 'TAX',
                        name: 'tax',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'TAX AMOUNT',
                        name: 'taxamount',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'DISCOUNT',
                        name: 'discount',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'subtotal',
                        name: 'subtotal',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
                    },
                    {
                        label: 'total',
                        name: 'total',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                        width: '170px'
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
            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: function(event) {
                            createPenjualanHeader()
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
                        innerHTML: '<i class="fa fa-pen"></i> EDIT ALL',
                        class: 'btn btn-success btn-sm mr-1 btn-editallpesanancustomer',
                        onClick: function(event) {
                            var dari = new Date()
                            dari.setDate(dari.getDate())
                            var today = $.datepicker.formatDate('dd-mm-yy', dari)

                            //  cekValidasiAksiEditAll('EDIT ALL')
                            editAllPenjualan()
                            // editingAtEditAll(today, 'EDIT ALL')
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
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                viewPenjualanHeader(selectedId)
                            }
                        }
                    },
                    // {
                    //     id: 'reportprofit',
                    //     innerHTML: '<i class="fa fa-print"></i> LAPORAN',
                    //     class: 'btn btn-info btn-sm mr-1',
                    //     onClick: () => {
                    //         $('#formRangeTglInv').data('action', 'reportprofit')
                    //         $('#rangeTglModalInv').find('button:submit').html(`Report`)
                    //         $('#rangeTglModalInv').modal('show')
                    //     }
                    // },

                    {
                        id: 'invoice',
                        innerHTML: '<i class="fa fa-print"></i> INVOICE',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                            // dataInvoicePenjualan(selectedId)
                            window.open(`{{ route('penjualanheader.invoice') }}?id=${selectedId}`)
                        }
                    },

                ],
                extndBtn: [{
                    id: 'report',
                    title: 'Report',
                    caption: 'Report',
                    innerHTML: '<i class="fa fa-print"></i> LAPORAN',
                    class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
                    dropmenuHTML: [{
                            id: 'reportprofit',
                            text: "LAP. PROFIT PENJUALAN",
                            onClick: () => {
                                $('#formRangeTglInv').data('action', 'reportprofit')
                                $('#rangeTglModalInv').find('button:submit').html(`Report`)
                                $('#rangeTglModalInv').modal('show')
                            }
                        },
                        {
                            id: 'reportpenjualandetail',
                            text: "LAP. PENJUALAN DETAIL",
                            onClick: () => {
                                $('#formRangeTglInv').data('action', 'reportprofitdetail')
                                $('#rangeTglModalInv').find('button:submit').html(`Report`)
                                $('#rangeTglModalInv').modal('show')
                            }
                        },
                    ],
                }, ]

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

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'reportprofit') }}`) {
                $('#report').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penjualanheader', 'combain') }}`) {
                $('#combain').addClass('ui-disabled')
            }
        }


        $('#rangeTglModalInv').on('shown.bs.modal', function() {
            var tglpengiriman = new Date()
            tglpengiriman.setDate(tglpengiriman.getDate())
            $('#formRangeTglInv').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy',
                tglpengiriman)).trigger('change');
            $('#formRangeTglInv').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy',
                tglpengiriman)).trigger('change');
            // initLookupMaster()
            initDatepicker()
        })

        $('#formRangeTglInv').submit(event => {

            event.preventDefault()
            let params
            let actionUrl = ``
            let submitButton = $(this).find('button:submit')

            /* Clear validation messages */
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            /* Set params value */
            for (var key in postData) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }

            let formRange = $('#formRangeTglInv')
            let dari = formRange.find('[name=dari]').val()
            let sampai = formRange.find('[name=sampai]').val()

            if ($('#formRangeTglInv').data('action') == 'reportprofit') {
                // console.log('test')
                $.ajax({
                        url: `${apiUrl}penjualanheader/reportprofit`,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: dari,
                            sampai: sampai
                        },
                        success: function(response) {
                            // console.log(response)
                            reportProfit(response.data, response.dari, response.sampai)
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#rangeTglModal').modal('hide')
                                setErrorMessages($('#crudForm'), error.responseJSON.errors);
                            } else {
                                showDialog(error.responseJSON.message);
                            }
                        }
                    })
                    .always(() => {
                        $('#processingLoader').addClass('d-none')
                        submitButton.prop('disabled', false)
                    });
            } else if ($('#formRangeTglInv').data('action') == 'reportprofitdetail') {
                $.ajax({
                        url: `${apiUrl}penjualanheader/reportprofitdetail`,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            dari: dari,
                            sampai: sampai
                        },
                        success: function(response) {
                            // console.log(response)
                            reportProfitDetail(response.data, response.dari, response.sampai)
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                $('#rangeTglModal').modal('hide')
                                setErrorMessages($('#crudForm'), error.responseJSON.errors);
                            } else {
                                showDialog(error.responseJSON.message);
                            }
                        }
                    })
                    .always(() => {
                        $('#processingLoader').addClass('d-none')
                        submitButton.prop('disabled', false)
                    });
            }
        });


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

    function reportProfit(datas, daris, sampais) {
        let data = datas;
        let dari = daris;
        let sampai = sampais;

        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
            "{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

        report = new Stimulsoft.Report.StiReport();
        dataSet = new Stimulsoft.System.Data.DataSet("Data");
        report.loadFile(`{{ asset('public/reports/ReportProfitPenjualan.mrt') }}`);
        dataSet.readJson({
            'data': data,
            'dari': dari,
            'sampai': sampai
        });

        report.regData(dataSet.dataSetName, '', dataSet);
        report.dictionary.synchronize();

        // var options = new Stimulsoft.Designer.StiDesignerOptions()
        // options.appearance.fullScreenMode = true
        // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
        // designer.report = report;
        // designer.renderHtml('content');

        report.renderAsync(function() {
            report.exportDocumentAsync(function(pdfData) {
                var fileName = `LaporanPenjualan Periode ${dari} s.d ${sampai}`;
                Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
            }, Stimulsoft.Report.StiExportFormat.Pdf);
        });
    }


    function reportProfitDetail(datas, daris, sampais) {
        let data = datas;
        let dari = daris;
        let sampai = sampais;

        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
            "{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

        report = new Stimulsoft.Report.StiReport();
        dataSet = new Stimulsoft.System.Data.DataSet("Data");
        report.loadFile(`{{ asset('public/reports/ReportLaporanPenjualanDetail.mrt') }}`);
        dataSet.readJson({
            'data': data,
            'dari': dari,
            'sampai': sampai
        });

        report.regData(dataSet.dataSetName, '', dataSet);
        report.dictionary.synchronize();

        // var options = new Stimulsoft.Designer.StiDesignerOptions()
        // options.appearance.fullScreenMode = true
        // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
        // designer.report = report;
        // designer.renderHtml('content');

        report.renderAsync(function() {
            report.exportDocumentAsync(function(pdfData) {
                // var fileName = 'LaporanPenjualanDetail Periode ' + dari + '-' + sampai;
                var fileName = `LaporanPenjualanDetail Periode ${dari} s.d ${sampai}`;
                Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
            }, Stimulsoft.Report.StiExportFormat.Pdf);
        });
    }

    function dataInvoicePenjualan(selectedId) {

        let headerRequest = $.ajax({
            url: `${apiUrl}penjualanheader/${selectedId}/invoice`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            }
        });

        let detailParams = {
            forInvoice: true,
            penjualanid: selectedId
        };

        let detailRequest = $.ajax({
            url: `${apiUrl}penjualandetail`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                detail: detailParams
            }
        });

        Promise.all([headerRequest, detailRequest])
            .then(responses => {
                let headerResponse = responses[0].data;
                let detailResponse = responses[1].data;

                invoicePenjualan(headerResponse, detailResponse)
            })
            .catch((error) => {
                showDialog(error.statusText)
            })
            .finally(() => {
                $('.modal-loader').addClass('d-none')
            });
    }

    function invoicePenjualan(headerResponse, detailResponse) {
        let header = headerResponse;
        let detail = detailResponse;

        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
            "{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

        report = new Stimulsoft.Report.StiReport();
        dataSet = new Stimulsoft.System.Data.DataSet("Data");
        report.loadFile(`{{ asset('public/reports/ReportInvoicePenjualan.mrt') }}`);
        dataSet.readJson({
            'header': header,
            'detail': detail
        });

        report.regData(dataSet.dataSetName, '', dataSet);
        report.dictionary.synchronize();

        // var options = new Stimulsoft.Designer.StiDesignerOptions()
        // options.appearance.fullScreenMode = true
        // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
        // designer.report = report;
        // designer.renderHtml('content');

        report.renderAsync(function() {
            report.exportDocumentAsync(function(pdfData) {
                var fileName = 'InvoicePenjualan ' + header.customernama;
                Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
            }, Stimulsoft.Report.StiExportFormat.Pdf);
        });
    }

    function clearSelectedRows() {
        selectedRows = []
        status = []

        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}pesananfinalheader`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                periode: $('#formCrud').find('[name=periode]').val(),
                ceklist: true
            },
            success: (response) => {
                selectedRows = response.data.map((pesananfinalheader) => pesananfinalheader.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()
@endsection