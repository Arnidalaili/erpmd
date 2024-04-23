@extends('layouts.master')

@section('content')
    <!-- Grid -->
    <div id="editAllPenjualanIndex">


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form id="editAllFormIndexPenjualan">
                        <div class="card card-easyui bordered mb-4">
                            <div class="card-header">
                            </div>

                            <div class="card-body" style="padding: 7px!important;">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-2 col-form-label">Tgl Pengiriman<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-2 mb-2">
                                        <div class="input-group">
                                            <input type="text" name="tglpengirimanjual" id="tglpengirimanjual"
                                                class="form-control lg-form datepicker filled-row">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-easyui bordered mb-4">
                            <div class="card-body" style="padding: 7px!important;">
                                <table class="table table-bordered" id="editAllPenjualanIndex">
                                    <thead>
                                        <!-- Add your table header here if needed -->
                                    </thead>
                                    <tbody id="editAllTableBodyPenjualanIndex"></tbody>
                                </table>
                            </div>
                            
                        </div>
                    </form>
                    <div class="card-footer" style="background-color: white;">
                        <button id="cekpesanan" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Cek Pesanan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- @include('cekpesanan._modal') --}}
    @include('cekpesanan._editallpenjualan')
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
                    selectAllRows(element, pesananfinalid)
                } else {
                    clearSelectedRows(element, pesananfinalid)
                }
            }


            $(document).ready(function() {
                $(document).on('change', `[id="tglpengirimanjual"]`, function() {
                    getAllPenjualanIndex(1, 10)
                });

                $(document).on('click', '#cekpesanan', function(event) {
                   console.log('cekpesanan');
                   editAllPenjualan()
                })

                editAllPenjualanIndex()

                
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
                        periode: $('#editAllFormIndexPenjualan').find('[name=tglpengirimanjual]').val(),
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
                        periode: $('#editAllFormIndexPenjualan').find('[name=tglpengirimanjual]').val(),
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
