@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="formCrud">
                    <div class="card-body" style="padding: 7px!important;">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label">Tgl Pengiriman<span class="text-danger">*</span></label>
                            <div class="col-sm-2 mb-2">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control periode datepickerIndex">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <a id="btnReload" class="btn btn-primary">
                                    <i class="fas fa-sync"></i>
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

    @include('pesananfinalheader._details')
    @include('pesananfinalheader._modal')
    @include('pesananfinalheader._modaleditallpembelian')
    @include('pesananfinalheader._modaleditallpenjualan')

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

        let modalReport = $('#rangeTglModal').find('.modal-body').html()
        let modalBatalPembelian = $('#rangeTglPengiriman').find('.modal-body').html()

        $('#rangeTglModal').on('hidden.bs.modal', () => {
            $('#rangeTglModal').find('.modal-body').html(modalReport)
            initDatepicker('datepickerIndex')
        })

        $('#rangeTglPengiriman').on('hidden.bs.modal', () => {
            $('#rangeTglPengiriman').find('.modal-body').html(modalBatalPembelian)
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
            var besok = new Date();
            besok.setDate(besok.getDate());
            $('#formCrud').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');
            $("#tabs").tabs()
            let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
            loadDetailGrid()
            initDatepicker('datepickerIndex')

            $(document).on('click', '#btnReload', function(event) {
                $('#jqGrid').jqGrid('setGridParam', {
                    postData: {
                        periode: $('#formCrud').find('[name=periode]').val(),
                    },
                }).trigger('reloadGrid');
                selectedRows = []
                $('#gs_').prop('checked', false)
            })

            $(document).on('change', `#formCrud [name="periode"]`, function() {
                $('#jqGrid').jqGrid('setGridParam', {
                    postData: {
                        periode: $('#formCrud').find('[name=periode]').val(),
                    },
                }).trigger('reloadGrid');

                selectedRows = []
                $('#gs_').prop('checked', false)
            });


            $("#jqGrid").jqGrid({
                    url: `${apiUrl}pesananfinalheader`,
                    mtype: "GET",
                    styleUI: 'Bootstrap4',
                    iconSet: 'fontAwesome',
                    postData: {
                        periode: $('#formCrud').find('[name=periode]').val(),
                        filters: JSON.stringify({
                            groupOp: "AND",
                            rules: [{
                                    field: "",
                                    op: "cn",
                                    data: "on"
                                },
                                {
                                    field: "statusmemo",
                                    op: "eq",
                                    data: "AKTIF"
                                }
                            ]
                        })
                    },
                    datatype: "json",
                    colModel: [{
                            label: '',
                            name: '',
                            width: 40,
                            // align: 'center',
                            sortable: false,
                            clear: false,
                            stype: 'input',
                            searchable: false,
                            searchoptions: {
                                type: 'checkbox',
                                clearSearch: false,
                                dataInit: function(element) {
                                    $(element).removeClass('form-control')
                                    $(element).parent().addClass('text-center')
                                    $(element).addClass('checkbox-selectall')

                                    $(element).on('click', function() {
                                        $(element).attr('disabled', true)
                                        if ($(this).is(':checked')) {
                                            selectAllRows()
                                        } else {
                                            clearSelectedRows()
                                        }
                                    })

                                }
                            },
                            formatter: (value, rowOptions, rowData) => {
                                return `<input type="checkbox" class="checkbox-jqgrid" name="pesananfinalheaderid[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                            },
                        }, {

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
                            label: 'NO BUKTI PESANAN',
                            name: 'nobuktipesanan',
                            align: 'left',
                            width: '170px'
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
                            label: 'NO BUKTI PENJUALAN',
                            name: 'nobuktipenjualan',
                            align: 'left',
                            width: '200px',
                            formatter: function(cellvalue, options, rowObject) {
                               
                               // Call second formatter (fontColorFormat)
                               return fontColorFormat(cellvalue, options, rowObject, 'blue');
                           },
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
                            label: 'tgl cetak',
                            name: 'tglcetak',
                            align: 'left',
                            formatter: "date",
                            formatoptions: {
                                srcformat: "ISO8601Long",
                                newformat: "d-m-Y"
                            }
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
                                    $(element).val('AKTIF').trigger('change');
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
                                createPesananFinalHeader()
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
                            id: 'edithargajual',
                            innerHTML: '<i class="fa fa-pen"></i> EDIT ALL PESANAN CUSTOMER',
                            class: 'btn btn-success btn-sm mr-1 btn-editallpesanancustomer',
                            onClick: function(event) {
                                editAllPenjualan()
                            }
                        },
                        {
                            id: 'edithargabeli',
                            innerHTML: '<i class="fa fa-pen"></i> EDIT ALL PESANAN SUPPLIER',
                            class: 'btn btn-success btn-sm mr-1 btn-editallpesanansupplier',
                            onClick: function(event) {
                                editAllPembelian()
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
                                    viewPesananFinalHeader(selectedId)
                                }
                               
                            }
                        },
                        {
                            id: 'reportpembelian',
                            innerHTML: '<i class="fa fa-print"></i> REPORT PESANAN',
                            class: 'btn btn-info btn-sm mr-1',
                            onClick: () => {
                                $('#formRangeTgl').data('action', 'reportpembelian')
                                $('#rangeTglModal').find('button:submit').html(`Report`)
                                $('#rangeTglModal').modal('show')
                            }
                        },
                        {
                            id: 'reportpembelianharga',
                            innerHTML: '<i class="fa fa-print"></i> REPORT PESANAN 2',
                            class: 'btn btn-info btn-sm mr-1 reportpesanan2',
                            onClick: () => {
                                $('#formRangeTgl').data('action', 'reportpembelianharga')
                                $('#rangeTglModal').find('button:submit').html(`Report`)
                                $('#rangeTglModal').modal('show')
                            }
                        },
                        {
                            id: 'combain',
                            innerHTML: '<i class="fas fa-object-group"></i> GABUNG PESANAN',
                            class: 'btn btn-info btn-combain btn-sm mr-1',
                            onClick: () => {
                                combainPesananFinalHeader()
                            }
                        },
                        {
                            id: 'createPenjualan',
                            innerHTML: '<i class="fa fa-check"></i> CREATE PENJUALAN',
                            class: 'btn btn-primary btn-sm mr-1 createpenjualan',
                            onClick: () => {
                                createPenjualan()
                            }
                        },
                        {
                            id: 'createPembelian',
                            innerHTML: '<i class="fa fa-check"></i> CREATE PEMBELIAN',
                            class: 'btn btn-primary btn-sm mr-1 createpembelian',
                            onClick: () => {
                                createPembelian()
                            }
                        },
                        {
                            id: 'batalPenjualan',
                            innerHTML: '<i class="fa fa-trash"></i> CANCEL PENJUALAN',
                            class: 'btn btn-warning btn-sm mr-1',
                            onClick: () => {
                                cekValidasiPenjualan()
                            }
                        },
                        {
                            id: 'hapusPembelian',
                            innerHTML: '<i class="fa fa-trash"></i> CANCEL PEMBELIAN',
                            class: 'btn btn-primary btn-sm mr-1 deletepembelian',
                            onClick: () => {
                                $('#formTglPengiriman').data('action', 'hapuspembelian')
                                $('#rangeTglPengiriman').find('button:submit').html(`HAPUS PEMBELIAN`)
                                $('#rangeTglPengiriman').modal('show')
                            }
                        },
                        // {
                        //     id: 'unapproval',
                        //     innerHTML: '<i class="fas fa-object-group"></i>UNAPPROVAL REPORT PEMBELIAN',
                        //     class: 'btn btn-outline-primary btn-sm mr-1',
                        //     onClick: () => {

                        //         $('#formConfirm').data('action', 'unapproval')
                        //         $('#confirmModal').find('button:submit').html(`UnApproval`)
                        //         $('#confirmModal').modal('show')

                        //     }
                        // },


                    ]
                    
                })
            $('#jqGrid_nobuktipenjualan').css("color", 'blue')
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

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'show') }}`) {
                    $('#view').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'export') }}`) {
                    $('#export').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'report') }}`) {
                    $('#report').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('pesananfinalheader', 'combain') }}`) {
                    $('#combain').addClass('ui-disabled')
                }
            }

            $('#formConfirm').submit(event => {
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
                let formConfirm = $('#formConfirm')
                let username = formConfirm.find('[name=username]').val()
                let password = formConfirm.find('[name=password]').val()
                let unApproval = 'unApproval'
                if ($('#formConfirm').data('action') == 'unapproval') {
                    $.ajax({
                        url: `${apiUrl}user/confirmuser`,
                        method: 'GET',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            username: username,
                            password: password
                        },
                        success: function(response) {
                            if (response.data == true) {
                                $.ajax({
                                    url: `${apiUrl}pesananfinalheader/acos`,
                                    method: 'GET',
                                    headers: {
                                        Authorization: `Bearer ${accessToken}`
                                    },
                                    data: {
                                        username: username,
                                        method: unApproval,
                                    },
                                    success: function(response) {
                                        if (response.data == true) {
                                            dari = $('#formCrud').find('[name=periode]').val()
                                            unApprovalReportPembelian(dari);
                                        } else {
                                            showDialog(response.message);
                                            $('#confirmModal').modal('hide')
                                        }
                                    },
                                    error: function(error) {
                                        if (error.status === 422) {
                                            $('.is-invalid').removeClass('is-invalid');
                                            $('.invalid-feedback').remove();
                                            setErrorMessages($('#crudForm'), error.responseJSON.errors);
                                        } else {
                                            showDialog(error.responseJSON.message);
                                        }
                                    }
                                })
                            } else {
                                showDialog(response.message);
                                $('#confirmModal').modal('hide')
                            }
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                                setErrorMessages($('#crudForm'), error.responseJSON.errors);
                            } else {
                                showDialog(error.responseJSON.message);
                            }
                        }
                    })
                }
            })

            $('#btnImport').click(function(event) {
                event.preventDefault()

                let url = `${apiUrl}pesananfinalheader/import`
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

            $('#rangeTglModal').on('shown.bs.modal', function() {
                var tglpengiriman = new Date()
                tglpengiriman.setDate(tglpengiriman.getDate())
                $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', tglpengiriman)).trigger('change');
                initLookupMaster()
                initDatepicker()
            })

            $('#rangeTglPengiriman').on('shown.bs.modal', function() {
                var tglpengiriman = new Date()
                tglpengiriman.setDate(tglpengiriman.getDate())
                $('#formTglPengiriman').find('[name=tglpengiriman]').val($.datepicker.formatDate('dd-mm-yy', tglpengiriman)).trigger('change');
                initDatepicker()
            })

            $('#formTglPengiriman').submit(event => {
                event.preventDefault()
                if ($('#formTglPengiriman').data('action') == 'hapuspembelian') {
                    cekValidasiPembelian()
                }
            })

            $('#formRangeTgl').submit(event => {
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

                let formRange = $('#formRangeTgl')
                let dari = formRange.find('[name=dari]').val()
                let karyawan = formRange.find('[name=karyawannama]').val()
                params = `&dari=${dari}`;

                if (karyawan) {
                    params += `&karyawan=${karyawan}`;
                }

                if ($('#formRangeTgl').data('action') == 'export') {
                    let actionUrl = `{{ route('pesananfinalheader.export') }}`

                    /* Clear validation messages */
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
                } else if ($('#formRangeTgl').data('action') == 'reportpembelian') {
                    if (karyawan) {
                        $.ajax({
                            url: `${apiUrl}pesananfinaldetail/reportpembelian`,
                            method: 'GET',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            data: {
                                forReportPb: true,
                                dari: dari,
                                karyawan: karyawan
                            },
                            success: function(response) {
                                // console.log(response)
                                ReportPembelian(response)
                                $('#rangeTglModal').modal('hide')
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
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        });
                    } else {
                        $.ajax({
                                url: `${apiUrl}pesananfinaldetail/reportpembelian`,
                                method: 'GET',
                                headers: {
                                    Authorization: `Bearer ${accessToken}`
                                },
                                data: {
                                    forReportPbAll: true,
                                    dari: dari,
                                },
                                success: function(response) {
                                    // console.log(response)

                                    ReportPembelian(response)
                                    $('#rangeTglModal').modal('hide')
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
                } else if ($('#formRangeTgl').data('action') == 'reportpembelianharga') {
                    if (karyawan) {
                        $.ajax({
                            url: `${apiUrl}pesananfinaldetail/reportpembelian`,
                            method: 'GET',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            data: {
                                forReportPb: true,
                                dari: dari,
                                karyawan: karyawan
                            },
                            success: function(response) {
                                ReportPembelianHarga(response)
                                $('#rangeTglModal').modal('hide')
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
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        });
                    } else {
                        $.ajax({
                                url: `${apiUrl}pesananfinaldetail/reportpembelian`,
                                method: 'GET',
                                headers: {
                                    Authorization: `Bearer ${accessToken}`
                                },
                                data: {
                                    forReportPbAll: true,
                                    dari: dari,
                                },
                                success: function(response) {
                                    ReportPembelianHarga(response)
                                    $('#rangeTglModal').modal('hide')
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
                }
            })

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

        function cekValidasiPembelian() {
            $.ajax({
                url: `{{ config('app.api_url') }}pesananfinalheader/cekvalidasipembelian`,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    tglpengiriman: $('#rangeTglPengiriman').find('[name="tglpengiriman"]').val()
                },
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                    var error = response.error
                    if (error) {
                        $('#rangeTglPengiriman').modal('hide')
                        showDialog(response)
                    } else {
                        hapusPembelian()
                    }
                },
                 error: error => {
                    $('#rangeTglPengiriman').modal('hide')
                    console.log(error.responseJSON.errors);
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages($('#crudForm'), error.responseJSON.errors);
                    } 
                },
            })
        }

        function cekValidasiPenjualan() {
            $.ajax({
                url: `{{ config('app.api_url') }}pesananfinalheader/cekvalidasipenjualan`,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    id: selectedRows
                },
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                success: response => {
                    console.log(response)
                    var error = response.error
                    if (error) {
                        showDialog(response)
                    } else {
                        batalPenjualan()
                    }
                }
            })
        }

        function ReportPembelianHarga(response) {
            let pembeliandetail = response.data;
            let tglPengiriman = pembeliandetail[0].tglpengiriman;

            Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

            Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

            report = new Stimulsoft.Report.StiReport();
            dataSet = new Stimulsoft.System.Data.DataSet("Data");
            report.loadFile(`{{ asset('public/reports/ReportPembelianHarga.mrt') }}`);
            dataSet.readJson({
                'pembeliandetail': pembeliandetail,
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
                    var fileName = 'LaporanPesanan' + tglPengiriman;
                    Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
                }, Stimulsoft.Report.StiExportFormat.Pdf);
            });

            // $.ajax({
            //     url: `${apiUrl}pesananfinalheader/updatetglcetak`,
            //     method: 'POST',
            //     headers: {
            //         Authorization: `Bearer ${accessToken}`
            //     },
            //     data: {
            //         dari: $('#formRangeTgl').find('[name=dari]').val(),
            //     },
            //     success: function(response) {
            //         console.log('success')
            //     },
            //     error: function(error) {
            //         if (error.status === 422) {
            //             $('.is-invalid').removeClass('is-invalid');
            //             $('.invalid-feedback').remove();
            //             setErrorMessages($('#crudForm'), error.responseJSON.errors);
            //         } else {
            //             showDialog(error.responseJSON.message);
            //         }
            //     }
            // })
        }

        function ReportPembelian(response) {
            let pembeliandetail = response.data;
            let tglPengiriman = pembeliandetail[0].tglpengiriman;

            Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");

            Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS");

            report = new Stimulsoft.Report.StiReport(); 
            dataSet = new Stimulsoft.System.Data.DataSet("Data");
            report.loadFile(`{{ asset('public/reports/ReportPembelian.mrt') }}`);
            dataSet.readJson({
                'pembeliandetail': pembeliandetail,
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
                    var fileName = 'LaporanPesanan' + tglPengiriman;
                    Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
                }, Stimulsoft.Report.StiExportFormat.Pdf);
            });

            // $.ajax({
            //     url: `${apiUrl}pesananfinalheader/updatetglcetak`,
            //     method: 'POST',
            //     headers: {
            //         Authorization: `Bearer ${accessToken}`
            //     },
            //     data: {
            //         dari: $('#formRangeTgl').find('[name=dari]').val(),
            //     },
            //     success: function(response) {
            //         console.log('success')
            //     },
            //     error: function(error) {
            //         if (error.status === 422) {
            //             $('.is-invalid').removeClass('is-invalid');
            //             $('.invalid-feedback').remove();
            //             setErrorMessages($('#crudForm'), error.responseJSON.errors);
            //         } else {
            //             showDialog(error.responseJSON.message);
            //         }
            //     }
            // })
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
                    ceklist: true,
                    filters: JSON.stringify({
                        groupOp: "AND",
                        rules: [{
                                field: "",
                                op: "cn",
                                data: "on"
                            },
                            {
                                field: "statusmemo",
                                op: "eq",
                                data: "AKTIF"
                            }
                        ]
                    })
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