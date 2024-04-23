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
        let sortnameDetail = 'productnama'
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
                        label: 'PRODUK',
                        name: 'productnama',
                    },
                    {
                        label: 'satuan',
                        name: 'satuannama',
                    },
                    {
                        label: 'qty',
                        name: 'qty',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'HARGA',
                        name: 'harga',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                    },
                    {
                        label: 'Total',
                        name: 'totalharga',
                        align: 'right',
                        formatter: currencyFormatNoDoubleZero,
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangandetail',
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
                    pembelianid: id
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
                            productnama: 'Total:',
                            totalharga: data.attributes.totalNominal,
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
    }

    function loadDetailData(id) {
        abortGridLastRequest($('#detailGrid'))

        $('#detailGrid').setGridParam({
            url: `${apiUrl}returjualdetail`,
            datatype: "json",
            postData: {
                returjualid: id
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>
@endpush