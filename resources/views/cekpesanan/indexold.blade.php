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
                                    <input type="text" name="periode" class="form-control datepickerIndex">
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
</div>

@include('cekpesanan._modal')
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
    let sortname = 'productnama'
    let sortorder = 'desc'
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

    function handlerSelectAll(element) {
        pesananfinalid = $(element).attr('pesananfinalid');
        $(element).removeClass('form-control')
        $(element).parent().addClass('text-center')
        $(element).addClass('checkbox-selectall')
        if (element.checked) {
            selectAllRows(element,pesananfinalid)
        } else {
            clearSelectedRows(element,pesananfinalid)
        }
    }


    $(document).ready(function() {
        $("#tabs").tabs()
        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')

        var besok = new Date();
        besok.setDate(besok.getDate());
        $('#formCrud').find('[name=periode]').val($.datepicker.formatDate('dd-mm-yy', besok)).trigger('change');

        setRange()
        initDatepicker('datepickerIndex')

        $(document).on('click', '#btnReload', function(event) {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    periode: $('#formCrud').find('[name=periode]').val(),
                },
            }).trigger('reloadGrid');
        })

        $(document).on('change', `#formCrud [name="periode"]`, function() {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    periode: $('#formCrud').find('[name=periode]').val(),
                },
            }).trigger('reloadGrid');
        });

        $("#jqGrid").jqGrid({
                url: `${apiUrl}cekpesanan/findpesanandetail`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    periode: $('#formCrud').find('[name=periode]').val(),
                },
                datatype: "json",
                colModel: [
                    { 
                          label: 'cek pesanan', 
                          name: 'cekpesananmemo', 
                          width: 90,
                          stype: 'select', 
                          searchoptions: { 
                            dataInit: function(element) { 
                              $(element).select2({ 
                                width: 'resolve', 
                                theme: "bootstrap4", 
                                ajax: { 
                                  url: `${apiUrl}parameter/combo`, 
                                  dataType: 'JSON', 
                                  headers: { 
                                    Authorization: `Bearer ${accessToken}`
                                  }, 
                                  data: { 
                                    grp: 'CEK PESANAN DETAIL', 
                                    subgrp: 'CEK PESANAN DETAIL' 
                                  }, 
                                  beforeSend: () => { 
                                    // clear options 
                                    $(element).data('select2').$results.children().filter((index, element) => { 
                                      // clear options except index 0, which 
                                      // is the "searching..." label 
                                      if (index > 0) { 
                                        element.remove() 
                                      } 
                                    }) 
                                  }, 
                                  processResults: (response) => {
                                    
                                    let formattedResponse = response.data.map(row => ({ 
                                      id: row.text, 
                                      text: row.text 
                                    })); 
                
                                    formattedResponse.unshift({ 
                                      id: '', 
                                      text: 'ALL' 
                                    }); 
                
                                    return { 
                                      results: formattedResponse 
                                    }; 
                                  }, 
                                } 
                              }); 
                            } 
                          }, 
                          formatter: (value, options, rowData) => { 
                            console.log(value);
                            if (!value) {
                              return ``
                            }
                            let cekpesanan = JSON.parse(value) 
                            console.log(cekpesanan);
                
                            let formattedValue = $(` 
                                <div class="badge" style="background-color: ${cekpesanan.WARNA}; color: #fff;"> 
                                  <span>${cekpesanan.SINGKATAN}</span> 
                                </div> 
                              `) 
                
                            return formattedValue[0].outerHTML 
                          }, 
                          cellattr: (rowId, value, rowObject) => { 
                            if (!rowObject.cekpesananmemo) {
                              return ``
                            }
                            let cekpesanan = JSON.parse(rowObject.cekpesananmemo) 

                            if (!cekpesanan) {
                                    return ``
                                }
                
                            return `title="${cekpesanan.MEMO}"`
                          } 
                        },{
                        label: 'customer',
                        name: 'customernama',
                    }, {
                        label: 'PRODUK',
                        name: 'productnama',
                        width: 250,
                    },
                    {
                        label: 'qty',
                        name: 'qtyjual',
                        width: 100,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'satuan',
                        name: 'satuannama',
                        width: 100,
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangandetail',
                        width: 300,
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
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
                    sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordDetail = $(this).getGridParam("records")
                    limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataDetail = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    setHighlight($(this))

                    if (data.attributes) {
                        $(this).jqGrid('footerData', 'set', {
                            item: 'Total:',
                            total: data.attributes.total,
                        }, true)
                    }
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
                        // cekPesanan()
                        editAllPenjualan()
                    }
                }]

            })
        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))


        $('#add .ui-pg-div')
            .addClass(`btn btn-sm btn-primary`)
            .parent().addClass('px-1')

        function permission() {

            if (!`{{ $myAuth->hasPermission('cekpesanan', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
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
                periode : $('#formCrud').find('[name=periode]').val(),
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
                $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).parents('tr').removeClass('bg-light-blue');
                $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).prop('checked', false);
                
            }
        })

    }

      

    function selectAllRows(element,pesananfinalid) {
      
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
                periode : $('#formCrud').find('[name=periode]').val(),
            },
            success: (response) => {
                // Inisialisasi atau gabungkan array yang baru dengan selectedRows
                if (!selectedRows) {
                    selectedRows = [];
                }
                selectedRows = selectedRows.concat(response.data.map((cekpesanandetail) => cekpesanandetail.id));

                // Tandai baris-baris dan kotak centang yang sesuai
                selectedRows.forEach((pesananfinaldetailid) => {
                    var selectedRow = $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).parents('tr');
                    selectedRow.find(`[name="productnama[]"], [name="productid[]"], [name="satuanid[]"], [name="satuannama[]"], [name="qty[]"], [name="keterangan[]"]`).addClass('checked');
                    $(`[name="check[]"][pesananfinalid="${pesananfinalid}"]`).prop('checked', true).parents('tr').addClass('bg-light-blue');
                });
            }
        })
    }
</script>
@endpush()
@endsection