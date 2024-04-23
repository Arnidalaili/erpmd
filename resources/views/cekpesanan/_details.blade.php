<div class="container-fluid my-4">
    <div class="row">
        <div class="col-12">
            <table id="detailGrid"></table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        
        function loadDetailGrid() {
            let sortnameDetail = 'id'
            let sortorderDetail = 'asc'
            let totalRecordDetail
            let limitDetail
            let postDataDetail
            let triggerClickDetail
            let indexRowDetail
            let pageDetail = 0
            
           
           
            $('#detailGrid')
                .jqGrid({
                    datatype: 'local',
                    data: [],
                    styleUI: 'Bootstrap4',
                    iconSet: 'fontAwesome',
                    idPrefix: 'detailGrid',
                    colModel: [
                       { 
                          label: 'check', 
                          name: 'cekpesananmemo', 
                          stype: 'select', 
                          width: 80,
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
                        }, {
                            label: 'PRODUK',
                            name: 'productnama',
                        },
                        {
                            label: 'satuan',
                            name: 'satuannama',
                        },
                        {
                            label: 'keterangan',
                            name: 'keterangandetail',
                        },
                        {
                            label: 'qty',
                            name: 'qtyjual',
                            width: 100,
                            align: 'right',
                            formatter: currencyFormat,
                        },
                       
                    ],
                    autowidth: true,
                    shrinkToFit: false,
                    height: 350,
                    rowNum: 10,
                    rownumbers: true,
                    rownumWidth: 45,
                    rowList: [10, 20, 50, 0],
                    footerrow: true,
                    userDataOnFooter: true,
                    toolbar: [true, "top"],
                    sortable: true,
                    sortname: sortnameDetail,
                    sortorder: sortorderDetail,
                    page: pageDetail,
                    viewrecords: true,
                    postData: {
                        pesananid: id
                    },
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

                        // var indexData;
                        // let jlhCeklistIndex = 0

                        // $.each(data.data, function(index,value){
                        //     indexData = index+1
                            
                        //     if(value.cekpesananid != null){
                        //         console.log(value.cekpesananid);
                        //         $(`#detailGrid #detailGrid${value.id}`).find(`td input:checkbox`).prop('checked', true)

                        //         if (!selectedRowDetails.includes(value.id)) {
                        //             selectedRowDetails.push(value.id)
                        //         }
                              
                        //         jlhCeklistIndex++;
                        //     } 
                            
                        // })

                        // if (selectedRowDetails.length == indexData) {
                        //     $('#jqGrid').find('.checkbox-jqgrid').prop('checked',true)
                        // }
                       
                        // if (indexData == jlhCeklistIndex) {
                        //     $('#gs_detailGrid').prop('checked',true)
                                                             
                        // }else{
                        //     $('#gs_detailGrid').prop('checked',false)
                        // }
                       
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

                        if (indexRowDetail > $(this).getDataIDs().length - 1) {
                            indexRowDetail = $(this).getDataIDs().length - 1;
                        }
                        setHighlight($(this))

                        if (data.attributes) {
                            $(this).jqGrid('footerData', 'set', {
                                nama: 'Total:',
                                totalhargajual: data.attributes.totalNominalJual,
                                totalhargabeli: data.attributes.totalNominalBeli,
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

                        clearGlobalSearch($('#detailGrid'))
                    },
                })


                .jqGrid("navGrid", pager, {
                    search: false,
                    refresh: false,
                    add: false,
                    edit: false,
                    del: false,
                })

                .customPager()
            /* Append clear filter button */
            loadClearFilter($('#detailGrid'))

            /* Append global search */
            loadGlobalSearch($('#detailGrid'))

            $('#jqgh_detailGrid_hargajual').css("color", 'blue')
            $('#jqgh_detailGrid_hargabeli').css("color", 'green')
            $('#jqgh_detailGrid_nobuktipembelian').css("color", 'green')
        
          
           
        }

    
        function fontColorFormat(cellvalue, options, rowObject, color) {
            var color = color;
            var cellHtml = "<span style='color:" + color + "' originalValue='" + cellvalue + "'>" + cellvalue + "</span>";
            return cellHtml;
        }

        function loadDetailData(id) {
            abortGridLastRequest($('#detailGrid'))

            $('#detailGrid').setGridParam({
                url: `${apiUrl}cekpesanan/findpesanandetail`,
                datatype: "json",
                postData: {
                    pesananfinalid: id,
                    periode: $('#formCrud').find('[name=periode]').val(),
                },
                page: 1
            }).trigger('reloadGrid')

           
                 
        }
       
    </script>
@endpush
