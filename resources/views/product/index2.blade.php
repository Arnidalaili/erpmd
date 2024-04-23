@extends('layouts.master')

@section('content')
    <!-- Grid -->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <table id="jqGrid"></table>
            </div>
        </div>
    </div>

    @include('product._modal')
    {{-- @include('product._modaleditall') --}}
    @include('product._modaleditall')

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
            let sortname = 'nama'
            let sortorder = 'asc'
            let autoNumericElements = []
            let indexRow = 0;

            $(document).ready(function() {
                $("#jqGrid").jqGrid({
                        url: `${apiUrl}product`,
                        mtype: "GET",
                        styleUI: 'Bootstrap4',
                        iconSet: 'fontAwesome',
                        datatype: "json",
                        cellEdit: true,
                        cellsubmit: "clientArray",
                        afterSaveCell: function(
                            status,
                            message,
                            cellValue,
                            rowIndex,
                            colIndex
                        ) {
                            let rowData = $("#jqGrid").getRowData();

                            rowData = rowData.map((item) => ({
                                nama: item.nama,
                                hargajual: item.hargajual,

                            }));

                            console.log(rowData)

                        },
                        data: [{
                            nama: null,
                            hargajual: null,
                        }, ],
                        colModel: [{
                                label: 'ID',
                                name: 'id',
                                align: 'right',
                                width: '70px',
                                search: false,
                                hidden: true
                            },
                            {
                                label: 'NAMA',
                                name: 'nama',
                                width: '200px',
                                align: 'left',
                                editable: true,
                                editoptions: {
                                    autocomplete: 'off'
                                }

                            },
                            {
                                label: 'HARGA JUAL',
                                name: 'hargajual',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                                editable: true,
                                editoptions: {
                                    autocomplete: 'off'
                                }
                            },
                            {
                                name: 'supplierid',
                                index: 'supplierid',
                                editable: true,
                                hidden: true, // Sembunyikan input yang tidak ingin ditampilkan pada form
                                edittype: 'custom',
                                editoptions: {
                                    custom_element: function(value, options) {
                                        // Membuat elemen <input type="hidden">
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = options.name;
                                        hiddenInput.value = value;
                                        hiddenInput.className = 'filled-row';

                                        return hiddenInput;
                                    },
                                    custom_value: function(elem, operation, value) {
                                        // Mengembalikan nilai yang akan disimpan dalam baris data jqGrid
                                        return $(elem).val();
                                    }
                                }
                            },
                            {
                                label: 'SUPPLIER',
                                name: 'suppliernama',
                                align: 'left',
                                editable: true,
                                edittype: 'custom',
                                editoptions: {
                                    custom_element: function(value, options) {
                                        // Membuat elemen <input type="text">
                                        var textInput = document.createElement('input');
                                        textInput.type = 'text';
                                        textInput.name = options.name;
                                        textInput.value = value;
                                        textInput.id = 'customernama'; // Tambahkan ID sesuai kebutuhan
                                        textInput.className =
                                            'form-control lg-form supplier-lookup filled-row';
                                        textInput.autocomplete = 'off';

                                        initLookupIndex()

                                        return textInput;
                                    },
                                    custom_value: function(elem, operation, value) {
                                        // Mengembalikan nilai yang akan disimpan dalam baris data jqGrid
                                        return $(elem).val();
                                    }
                                }
                            },
                            {
                                label: 'SATUAN',
                                name: 'satuannama',
                                align: 'left',
                                editable: true,
                                editoptions: {
                                    autocomplete: 'off'
                                }
                            },
                            {
                                label: 'HARGA BELI',
                                name: 'hargabeli',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 1',
                                name: 'hargakontrak1',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 2',
                                name: 'hargakontrak2',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 3',
                                name: 'hargakontrak3',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 4',
                                name: 'hargakontrak4',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 5',
                                name: 'hargakontrak5',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
                            },
                            {
                                label: 'HARGA KONTRAK 6',
                                name: 'hargakontrak6',
                                width: '160px',
                                align: 'right',
                                formatter: currencyFormatNoDoubleZero,
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
                            permission()
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

                    .customPager({
                        buttons: [{
                                id: 'add',
                                innerHTML: '<i class="fa fa-plus"></i> ADD',
                                class: 'btn btn-primary btn-sm mr-1',
                                onClick: () => {
                                    createProduct()
                                }
                            },
                            {
                                id: 'edit',
                                innerHTML: '<i class="fa fa-pen"></i> EDIT',
                                class: 'btn btn-success btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    editProduct(selectedId)
                                }
                            },
                            {
                                id: 'editall',
                                innerHTML: '<i class="fa fa-pen"></i> EDIT ALL',
                                class: 'btn btn-success btn-sm mr-1',
                                onClick: () => {
                                    // var rowDataArray = $("#jqGrid").jqGrid('getRowData');
                                    // var selectedColumnsDataArray = rowDataArray.map(function(rowData) {

                                    //     return {
                                    //         id: rowData['id'],
                                    //         nama: rowData['nama'],
                                    //         hargajual: parseFloat(rowData['hargajual'].replace(/,/g,
                                    //             ''))
                                    //     };
                                    // });

                                    // var data = JSON.stringify(selectedColumnsDataArray);
                                    editAll()


                                    // editAll(data)

                                }
                            },
                            {
                                id: 'delete',
                                innerHTML: '<i class="fa fa-trash"></i> DELETE',
                                class: 'btn btn-danger btn-sm mr-1',
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    deleteProduct(selectedId)
                                }
                            },
                            {
                                id: 'report',
                                innerHTML: '<i class="fa fa-print"></i> REPORT',
                                class: 'btn btn-info btn-sm mr-1',
                                onClick: () => {
                                    $('#rangeModal').data('action', 'report')
                                    $('#rangeModal').find('button:submit').html(`Report`)
                                    $('#rangeModal').modal('show')
                                }
                            },
                            {
                                id: 'export',
                                innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                                class: 'btn btn-warning btn-sm mr-1',
                                onClick: () => {
                                    $('#rangeModal').data('action', 'export')
                                    $('#rangeModal').find('button:submit').html(`Export`)
                                    $('#rangeModal').modal('show')
                                }
                            },
                            {
                                id: 'import',
                                innerHTML: '<i class="fa fa-file-import"></i> IMPORT',
                                class: 'btn btn-info btn-sm mr-1',
                                onClick: () => {
                                    $('#importModal').data('action', 'import')
                                    $('#importModal').find('button:submit').html(`Import`)
                                    $('#importModal').modal('show')
                                }
                            },
                        ]
                    })

                /* Append clear filter button */
                loadClearFilter($('#jqGrid'))

                /* Append global search */
                loadGlobalSearch($('#jqGrid'))


                $('#add .ui-pg-div')
                    .addClass(`btn-sm btn-primary`)
                    .parent().addClass('px-1')

                $('#edit .ui-pg-div')
                    .addClass('btn-sm btn-success')
                    .parent().addClass('px-1')

                $('#delete .ui-pg-div')
                    .addClass('btn-sm btn-danger')
                    .parent().addClass('px-1')

                $('#report .ui-pg-div')
                    .addClass('btn-sm btn-info')
                    .parent().addClass('px-1')

                $('#export .ui-pg-div')
                    .addClass('btn-sm btn-warning')
                    .parent().addClass('px-1')

                function permission() {
                    if (!`{{ $myAuth->hasPermission('product', 'store') }}`) {
                        $('#add').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('product', 'update') }}`) {
                        $('#edit').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('product', 'destroy') }}`) {
                        $('#delete').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('product', 'export') }}`) {
                        $('#export').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('product', 'report') }}`) {
                        $('#report').attr('disabled', 'disabled')
                    }

                    if (!`{{ $myAuth->hasPermission('product', 'import') }}`) {
                        $('#report').attr('disabled', 'disabled')
                    }
                }

                $('#btnImport').click(function(event) {
                    event.preventDefault()

                    let url = `${apiUrl}product/import`
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

                $('#rangeModal').on('shown.bs.modal', function() {
                    if (autoNumericElements.length > 0) {
                        $.each(autoNumericElements, (index, autoNumericElement) => {
                            autoNumericElement.remove()
                        })
                    }

                    $('#formRange [name]:not(:hidden)').first().focus()

                    $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
                    $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
                    if (page == 0) {
                        $('#formRange [name=dari]').val(page)
                        $('#formRange [name=sampai]').val(totalRecord)
                    } else {
                        $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                        $('#formRange [name=sampai]').val(totalRecord)
                    }

                    autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                        digitGroupSeparator: ',',
                        decimalCharacter: '.',
                        decimalPlaces: 0,
                        allowDecimalPadding: false,
                        minimumValue: 1,
                        maximumValue: totalRecord
                    })
                })

                // MODAL HIDDEN, REMOVE KOTAK MERAH
                $('#rangeModal').on('hidden.bs.modal', function() {

                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                })

                $('#formRange').submit(function(event) {
                    event.preventDefault()

                    let params
                    let submitButton = $(this).find('button:submit')

                    submitButton.attr('disabled', 'disabled')
                    $('#processingLoader').removeClass('d-none')

                    /* Set params value */
                    for (var key in postData) {
                        if (params != "") {
                            params += "&";
                        }
                        params += key + "=" + encodeURIComponent(postData[key]);
                    }

                    let formRange = $('#formRange')
                    let offset = parseInt(formRange.find('[name=dari]').val()) - 1
                    let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
                    params += `&offset=${offset}&limit=${limit}`

                    getCekExport(params).then((response) => {
                        if ($('#rangeModal').data('action') == 'export') {
                            $.ajax({
                                url: `{{ config('app.api_url') }}product/export?` + params,
                                type: 'GET',
                                beforeSend: function(xhr) {
                                    xhr.setRequestHeader('Authorization',
                                        `Bearer {{ session('access_token') }}`);
                                },
                                xhrFields: {
                                    responseType: 'arraybuffer'
                                },
                                success: function(response, status, xhr) {
                                    if (xhr.status === 200) {
                                        if (response !== undefined) {
                                            var blob = new Blob([response], {
                                                type: 'product/vnd.ms-excel'
                                            });
                                            var link = document.createElement('a');
                                            link.href = window.URL.createObjectURL(blob);
                                            link.download = 'laporanproduct' + new Date()
                                                .getTime() + '.xlsx';
                                            link.click();
                                        }
                                        $('#rangeModal').modal('hide')
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('#processingLoader').addClass('d-none')
                                    submitButton.removeAttr('disabled')
                                }
                            }).always(() => {
                                $('#processingLoader').addClass('d-none')
                                submitButton.removeAttr('disabled')
                            })
                        } else if ($('#rangeModal').data('action') == 'report') {
                            window.open(`{{ route('product.report') }}?${params}`)
                            submitButton.removeAttr('disabled')
                            $('#processingLoader').addClass('d-none')
                            $('#rangeModal').modal('hide')
                        }
                    }).catch((error) => {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()
                            let status
                            if (error.responseJSON.hasOwnProperty('status') == false) {
                                status = false
                            } else {
                                status = true
                            }
                            statusText = error.statusText
                            errors = error.responseJSON.errors
                            $.each(errors, (index, error) => {
                                let indexes = index.split(".");
                                if (status === false) {
                                    indexes[0] = 'sampai'
                                }
                                let element;
                                element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[
                                    0];
                                if ($(element).length > 0 && !$(element).is(":hidden")) {
                                    $(element).addClass("is-invalid");
                                    $(`
                                            <div class="invalid-feedback">
                                            ${error[0].toLowerCase()}
                                            </div>
                                    `).appendTo($(element).parent());
                                } else {
                                    setTimeout(() => {
                                        return showDialog(error);
                                    }, 100)
                                }
                            });
                            $(".is-invalid").first().focus();
                            $('#processingLoader').addClass('d-none')

                        } else {
                            showDialog(error.statusText)
                        }
                    }).finally(() => {
                        $('.ui-button').click()
                        submitButton.removeAttr('disabled')
                    })
                })



                function getCekExport(params) {

                    params += `&cekExport=true`

                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: `${apiUrl}product/export?${params}`,
                            dataType: "JSON",
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            success: (response) => {
                                resolve(response);
                            },
                            error: error => {
                                reject(error)

                            },
                        });
                    });
                }



            })

            // function editAll(data) {

            //     $.ajax({
            //         url: `${apiUrl}product/editall`,
            //         method: 'POST',
            //         dataType: 'JSON',
            //         headers: {
            //             Authorization: `Bearer ${accessToken}`
            //         },
            //         data: {
            //             product: data
            //         },
            //         success: response => {
            //             id = response.data.id
            //         },
            //         error: error => {
            //             if (error.status === 422) {
            //                 $('.is-invalid').removeClass('is-invalid')
            //                 $('.invalid-feedback').remove()

            //                 setErrorMessages(form, error.responseJSON.errors);
            //             } else {
            //                 showDialog(error.responseJSON)
            //             }
            //         },
            //     }).always(() => {
            //         $('#processingLoader').addClass('d-none')
            //         $(this).removeAttr('disabled')
            //     })
            // }

            // function isObjectHasValue(object) {
            //     let hasValue = false;

            //     $.each(object, (index, value) => {
            //         if (value) {
            //             hasValue = true;
            //         }
            //     });

            //     return hasValue;
            // }

           
        </script>
    @endpush()
@endsection
