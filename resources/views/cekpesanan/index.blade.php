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
                                <label class="col-12 col-sm-2 col-form-label">Tgl Pengiriman<span
                                        class="text-danger">*</span></label>
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

        @include('cekpesanan._details')
        @include('cekpesanan._modaleditallpenjualan')


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
                let selectedRowDetails = [];


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

                function handlerSelectAll(element) {
                    pesananfinalid = $(element).attr('pesananfinalid');
                    $(element).removeClass('form-control')
                    $(element).parent().addClass('text-center')
                    $(element).addClass('checkbox-selectall')
                    if (element.checked) {
                        selectAllRows(element, pesananfinalid)
                    } else {
                        clearSelectedRows(element, pesananfinalid)
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
                            url: `${apiUrl}cekpesanan/getheader`,
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



                                // if (indexData == jlhCeklist) {
                                //     $('#gs_').prop('checked',true)

                                // }


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
                                    id: 'cekpesanan',
                                    innerHTML: '<i class="fa fa-plus"></i> CEK PESANAN',
                                    class: 'btn btn-primary btn-sm mr-1',
                                    onClick: function(event) {
                                        editAllPenjualan()
                                    }
                                },



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


                })


                function clearSelectedRows(element, pesananfinalid) {
                    // console.log(selectedRows);
                    // Perbarui selectedRows dengan menghapus item yang sesuai
                    // selectedRows = selectedRows.filter(id => id !== pesananfinalid);
                    // selectedRows = []

                    $.ajax({
                        url: `${apiUrl}cekpesanan/findpesanandetail`,
                        method: 'GET',
                        dataType: 'JSON',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            limit: 0,
                            pesananfinalid: pesananfinalid,
                            periode: $('#editAllModalPenjualan').find('[name=tglpengirimanjual]').val(),
                        },
                        success: (response) => {
                            $.each(response.data, function(index, details) {
                                for (var i = 0; i < selectedRows.length; i++) {
                                    if (selectedRows[i] == details.id) {
                                        selectedRows.splice(i, 1);
                                    }
                                }
                            })

                            // Hapus penandaan dan centang pada baris-baris terpilih
                            $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).parents('tr').removeClass(
                                'bg-light-blue');
                            $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).prop('checked', false);

                        }
                    })

                }


                function selectAllRows(element, pesananfinalid) {
                    $.ajax({
                        url: `${apiUrl}cekpesanan/findpesanandetail`,
                        method: 'GET',
                        dataType: 'JSON',
                        headers: {
                            Authorization: `Bearer ${accessToken}`
                        },
                        data: {
                            limit: 0,
                            pesananfinalid: pesananfinalid,
                            periode: $('#editAllModalPenjualan').find('[name=tglpengirimanjual]').val(),
                        },
                        success: (response) => {
                            // Inisialisasi atau gabungkan array yang baru dengan selectedRows
                            if (!selectedRows) {
                                selectedRows = [];
                            }
                            selectedRows = selectedRows.concat(response.data.map((cekpesanandetail) => cekpesanandetail
                                .id));

                            // Tandai baris-baris dan kotak centang yang sesuai
                            selectedRows.forEach((pesananfinaldetailid) => {
                                var selectedRow = $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`)
                                    .parents('tr');
                                selectedRow.find(
                                    `[name="productnama[]"], [name="productid[]"], [name="satuanid[]"], [name="satuannama[]"], [name="qty[]"], [name="keterangan[]"]`
                                ).addClass('checked');
                                $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).prop('checked', true)
                                    .parents('tr').addClass('bg-light-blue');
                            });
                        }
                    })
                }
            </script>
        @endpush()
    @endsection
