<?php
    if (isset($id)) { ?>
<table id="salesLookup<?= $id ?>" class="lookup-grid"></table>
<?php
    } else { ?>
<table id="salesLookup" class="lookup-grid"></table>
<?php } ?>
<div class="loadingMessage">

    <img class="loading-image" src="{{ asset('libraries/tas-lib/img/loading-lookup.gif') }}" alt="Loading">
    <p class="loading-text">Loading data...</p>

</div>
</div>


<?php
$idLookup = isset($id) ? $id : null;

?>
<script>
    var idLookup = '{{ $idLookup }}';
    var idTop

    selector = $(`#salesLookup{{ isset($id) ? $id : null }} `)


    selector.jqGrid({
        url: `{{ config('app.api_url') . 'customer' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
            aktif: `{!! $Aktif ?? '' !!}`,
        },
        idPrefix: 'salesLookup',
        colModel: [{
                label: "ID",
                name: "id",
                width: "50px",
                hidden: true,
                sortable: false,
                search: false,
            },

            {
                label: "Name",
                name: "name",
                width: '350px',


            },
            {
                label: "Code",
                name: "code",
                searchoptions: {
                    sopt: ['cn']
                }
            },
            {
                label: "Contact",
                name: "contactname",
            },
            {
                label: "Description",
                name: "description",
            },
            {
                label: "Telephone",
                name: "telephone",
            },
            {
                label: "Address",
                name: "address",
            },
            {
                label: "City",
                name: "city",
            },
            {
                label: "Postal Code",
                name: "postalcode",
            },
            {
                label: "Status Aktif",
                name: "status_aktif",
            },
            {
                label: "Modified By",
                name: "modified_by",
            },
            {
                label: "Created At",
                name: "created_at",
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y H:i:s",
                },
            },
            {
                label: "Updated At",
                name: "updated_at",
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y H:i:s",
                },
            },
        ],
        // autowidth: true,
        // responsive: true,
        height: 350,
        fixed: true,
        rowNum: `{!! $limit ?? 20 !!}`,
        rownumbers: false,
        rownumWidth: 0,
        rowList: [10, 20, 50, 0],
        sortable: true,
        sortname: 'nama',
        sortorder: 'asc',
        page: 1,
        toolbar: [true, "top"],
        // pager: $('#salesLookupPager'),
        viewrecords: true,
        prmNames: {
            sort: 'sortIndex',
            order: 'sortOrder',
            rows: 'limit'
        },
        jsonReader: {
            root: 'data',
            total: 'attributes.totalPages',
            records: 20,
        },
        // gridview: true,
        autowidth: true,
        scrollOffset: 1,
        scrollrows: false,
        shrinkToFit: false,
        scrollLeftOffset: "25%",
        scroll: true,
        height: 350,
        page: 1,
        // forceFit:true,  
        // loadtext: " Data Sedang Dimuat",
        selectedIndex: 0,
        triggerClick: false,
        search: true,
        serializeGridData: function(postData, searching) {
            searching = `{{ $searching }}`
            searchText = `.{{ $searchText }} `

            aksi = `{!! $aksi ?? '' !!}`

            postData.sort_indexes = [postData.sort_index];
            postData.sort_orders = [postData.sort_order];

            var colModel = $(this).jqGrid("getGridParam", "colModel"),
                l = colModel.length,
                i,
                rules = [],
                searchValue = $(searchText).val(),
                cm;

            input = $(searchText).data('input')

            if (input) {
                var typeSearch = '{{ $typeSearch ?? '' }}'

                if (typeSearch === 'ALL') {

                    for (i = 0; i < l; i++) {
                        cm = colModel[i];

                        if (cm.search !== false && (cm.stype === undefined || cm.stype ===
                                "text")) {
                            rules.push({
                                field: cm.name,
                                op: "cn",
                                data: searchValue.toUpperCase(),
                            });


                            postData.filters = JSON.stringify({
                                groupOp: "OR",
                                rules: rules,
                            });
                        }

                    }

                    // $(searchText).focus()

                    postData.searching = searching;
                    postData.searchText = searchText;

                } else {
                    cm = colModel[searching];

                    if (cm.search !== false && (cm.stype === undefined || cm.stype ===
                            "text")) {

                        postData.filters = JSON.stringify({
                            groupOp: "AND",
                            rules: [{
                                field: cm.name,
                                op: "cn",
                                data: $(searchText).val().toUpperCase()
                            }]
                        });

                        $(searchText).focus()
                    }

                    postData.searching = searching;
                    postData.searchText = searchText;
                }

                delete postData.sort_index;
                delete postData.sort_order;
            }

            return postData;
        },

        loadBeforeSend: function(jqXHR) {
            $('.loadingMessage').show();
            idTop = selector.attr('id')


            $(`#load_${idTop}`).remove()

            if (detectDeviceType() == 'mobile') {

                $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')

                $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')

                var title = '{{ $title ?? '' }}'
                var label = $("<label>").attr("for", "searchText")
                    .css({
                        "font-weight": "normal",
                        "padding-left": "10px",
                        "padding-top": "5px"
                    })
                    .text(title);

                $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
                    "height": "1px",

                })

            } else {
                var title = '{{ $title ?? '' }}'
                var label = $("<label>").attr("for", "searchText")
                    .css({
                        "font-weight": "normal",
                        "padding-left": "10px",
                        "padding-top": "1px"
                    })
                    .text(title);

                $(`#gbox_${idTop}`).find('.ui-jqgrid').css({
                    "min-height": "24px!important"
                })

                $(`#gbox_${idTop}`).find('.ui-userdata-top').css({
                    "height": "1px",
                    "min-height": "25px"
                })

            }

            // Mengecek apakah label belum ada sebelumnya
            if ($(`#t_${idTop} label[for='searchText']`).length === 0) {
                $(`#t_${idTop}`).append(label);
            }


            var hideLabel = '{{ $hideLabel ?? '' }}'

            if (hideLabel) {
                $(`#gbox_${idTop}`).find('.ui-jqgrid-hdiv').hide()
            }


            $('.ui-scroll-popup').addClass('d-none')
            $('.modal-loader-content').addClass('d-none')



            jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
            setGridLastRequest($(this), jqXHR)

        },
        onSelectRow: function(id) {
            activeGrid = this;

            let limit = $(this).jqGrid("getGridParam", "postData").limit;
            let page = $(this).jqGrid("getGridParam", "page");
            let selectedIndex = $(this).jqGrid("getCell", id, "rn") - 1;

            if (selectedIndex >= limit)
                selectedIndex = selectedIndex - limit * (page - 1);

            $(this).jqGrid("setGridParam", {
                selectedIndex,
            });
        },
        loadComplete: function(data) {

            $('.loadingMessage').hide();
            idTop = selector.attr('id')

            if (detectDeviceType() == 'mobile') {
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('padding', '12px')
                $('.lookup-grid tr:not(.jqgfirstrow) td').css('font-size', '1rem')
                $(`#gview_${idTop} .ui-th-column `).css('font-size', '1rem')

            }

            let modal = $('#crudModal')
            let form = modal.find('form')
            let valueName = `{{ $valueName }}`

            changeJqGridRowListText();

            if (data.data.length === 0) {
                // $(form).find('.is-invalid').removeClass('is-invalid');
                // $(form).find('.invalid-feedback').remove();

                // errorLength = {
                //     [`${valueName}`]: 'the data does not exist in the database',
                // }

                // if ($('#detailData tbody').find(`[name="${valueName}"]`)) {
                //     $('#detailData tbody').find(`[name="${valueName}"]`).first().val('')
                // } else {
                //     $(`#crudForm [name=${valueName}]`).first().val('');
                // }


                // setErrorMessages(form, errorLength)

                $('#parameterGrid').each((index, element) => {
                    abortGridLastRequest($(element))
                    clearGridHeader($(element))
                })
            } else {
                $(form).find('.is-invalid').removeClass('is-invalid');
                $(form).find('.invalid-feedback').remove();
            }

            if (detectDeviceType() == 'desktop') {
                $(document).unbind('keydown')
                // setCustomBindKeys($(this))
                initResize($(this))


                let selectedIndex = $(this).jqGrid("getGridParam").selectedIndex;

                if (selectedIndex > $(this).getDataIDs().length - 1) {
                    selectedIndex = $(this).getDataIDs().length - 1;
                }

                if ($(this).jqGrid("getGridParam").triggerClick) {

                    $(this)
                        .find(`tr[id="${$(this).getDataIDs()[selectedIndex]}"]`)
                        .click();

                    $(this).jqGrid("setGridParam", {
                        triggerClick: false,
                    });
                } else {

                    // $(this).setSelection($(this).getDataIDs()[selectedIndex]);
                }
            }

            $('.clearsearchclass').click(function() {
                clearColumnSearch($(this))
            })

            $(this).setGridWidth($('#lookupCabang').prev().width())
            setHighlight($(this))
        },

    })

    // .jqGrid("setLabel", "rn", "No.")
    // .customPager()
</script>

</html>
