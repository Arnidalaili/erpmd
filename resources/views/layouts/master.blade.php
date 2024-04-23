@php
    date_default_timezone_set('Asia/Jakarta');
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ $title ?? 'No title' }} | {{ config('app.name') }}</title>

  {{-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet"> --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/dist/css/adminlte-customized.min.css') }}">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/daterangepicker/daterangepicker.css') }}">

  <!-- JqGrid -->
  <link rel="stylesheet" href="{{ asset('libraries/jqgrid/570/css/ui.jqgrid-bootstrap4.css') }}" />

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  {{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" /> --}}

  <link rel="stylesheet" href="{{ asset('libraries/datetimepicker/bootstrap-datetimepicker.css') }}">

  <!-- Jquery UI -->
  <link rel="stylesheet" href="{{ asset('libraries/jquery-ui/cupertino/jquery-ui.min.css') }}">

  <!-- Nestable2 -->
  <link rel="stylesheet" href="{{ asset('libraries/nestable2/1.6.0/css/jquery.nestable.min.css') }}" />

  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('libraries/tas-lib/css/styles.css?version=' .  date('YmdHis')) }}">
  <link rel="stylesheet" href="{{ asset('libraries/tas-lib/css/pager.css?version=' .  date('YmdHis')) }}">
  

  <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/dropzone/dropzone.css') }}">

</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="modal-loader d-none">
    <div class="modal-loader-content d-flex align-items-center justify-content-center">
      <img src="{{ asset('libraries/tas-lib/img/loading-blue.gif') }}" rel="preload">
      Loading...
    </div>
  </div>

  <div class="loader" id="loader">
    <img src="{{ asset('libraries/tas-lib/img/hour-glass.gif') }}" rel="preload">
    <span>Loading</span>
  </div>

  <div class="lookup-loader d-none">
    <div class="lookup-loader-content d-flex align-items-center justify-content-center">
      <img src="{{ asset('libraries/tas-lib/img/loading-blue.gif') }}" rel="preload">
      Loading...
    </div>
  </div>

  <div class="processing-loader d-none" id="processingLoader">
    <img src="{{ asset('libraries/tas-lib/img/loading-color.gif') }}" rel="preload">
    <span>Processing</span>
  </div>

  <div id="dialog-message" title="Error" class="text-center text-danger" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-success-message" title="Pesan" class="text-center text-success" style="display: none;">
    <span class="fa fa-check" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-warning-message" title="Pesan" class="text-center text-warning" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-confirm-force" title="Pesan" class="text-center " style="display: none;">
    <span class="fa fa-exclamation-triangle text-warning" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-force-message" title="Pesan" class="text-center text-warning" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-editall-message" title="Pesan" class="text-center text-warning" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-info-message" title="Pesan" class="text-center text-info" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-confirm" title="Pesan" class="text-center " style="display: none;">
    <span class="fa fa-exclamation-triangle text-warning" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  <div id="dialog-editall" title="Pesan" class="text-center text-warning" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p> 
  </div>

  <!-- Modal for import -->
  <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- <div class="modal-header">
          <p class="modal-title" id="importModalLabel">Pilih file</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div> -->
        <form id="formImport" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group row" id="file">
              <div class="col-sm-2">
                <label class="col-form-label">File</label>
              </div>
              <div class="col-sm-10">
                <input type="file" name="fileImport">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnImport">Import</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for report and export -->
  <div class="modal fade" id="rangeModal" tabindex="-1" aria-labelledby="rangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="rangeModalLabel">Pilih baris</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <form id="formRange" target="_blank">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="sidx">
            <input type="hidden" name="sord">

            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Dari</label>
              </div>
              <div class="col-sm-10">
                <input type="tel" name="dari" class="form-control autonumeric-report" autofocus>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Sampai</label>
              </div>
              <div class="col-sm-10">
                <input type="tel" name="sampai" class="form-control autonumeric-report">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Report</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for report Pembelian Pesanan Final -->
  <div class="modal fade" id="rangeTglModal" tabindex="-1" aria-labelledby="rangeTglModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
       <div class="modal-header">
          <p class="modal-title" id="rangeTglModalLabel">Pilih tanggal</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form id="formRangeTgl" target="_blank">
          @csrf
          <div class="modal-body">
            <div class="row form-group">
              <div class="col-12 col-md-4">
                <label class="col-form-label">
                  karyawan
                </label>
              </div>
              <div class="col-12 col-md-8">
                <input type="hidden" name="karyawanid" class="filled-row">
                <input type="text" name="karyawannama" id="karyawannama" class="form-control lg-form karyawan-lookup filled-row" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label">Tanggal Pengiriman</label>
              </div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="text" name="dari" class="form-control datepicker" autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Report</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for report Profit di Penjualan -->
  <div class="modal fade" id="rangeTglModalInv" tabindex="-1" aria-labelledby="rangeTglModalLabelInv" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
       <div class="modal-header">
          <p class="modal-title" id="rangeTglModalLabelInv">Pilih tanggal</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form id="formRangeTglInv" target="_blank">
          @csrf
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label">Dari</label>
              </div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="text" name="dari" class="form-control datepicker" autofocus>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label">Sampai</label>
              </div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="text" name="sampai" class="form-control datepicker" autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Report</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

   <!-- Modal for batal pembelian -->
   <div class="modal fade" id="rangeTglPengiriman" tabindex="-1" aria-labelledby="rangeTglPengirimanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="rangeTglModalLabel">Pilih tanggal</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form id="formTglPengiriman">
          @csrf
          <div class="modal-body">
            <div class="form-group row">
              <div class="col-sm-4">
                <label class="col-form-label">Tanggal Pengiriman</label>
              </div>
              <div class="col-sm-8">
                <div class="input-group">
                  <input type="text" name="tglpengiriman" class="form-control datepicker" autofocus>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Batal Pembelian</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for Confirmation Username & Password-->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
          <p class="modal-title" id="confirmModalLabel">konfirmasi</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form id="formConfirm" target="_blank">
          @csrf
          <div class="modal-body">
            <div class="row form-group">
              <div class="col-12 col-md-3">
                <label class="col-form-label">
                  username <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-9">
                <input type="text" name="username" id="username" class="form-control lg-form form-control lg-form-lg-mobile filled-row">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-3">
                <label class="col-form-label">
                  password <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-9 input-group">
                <input type="password" name="password" id="password" class="form-control lg-form form-control lg-form-lg-mobile filled-row">
                <div class="input-group-append">
                  <div class="input-group-text" style="background-color:#E0ECFF; color:white; width:32px!important;">
                    <span class="fas fa-eye toggle-password" toggle="#password" style="color:#0e2d5f; right:1px!important; position:relative"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for approve kacab-->
  <div class="modal fade" id="approveKacab" tabindex="-1" aria-labelledby="approveKacabLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title">Force Edit</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <form id="formApproveKacab" target="_blank">
          @csrf
          <div class="modal-body">

            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Username</label>
              </div>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="hidden" name="id">
                  <input type="text" name="username" id="username" class="form-control" autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text" style="background-color:#E0ECFF; color:white">
                      <span class="fas fa-user" style="color:#0e2d5f;"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Password</label>
              </div>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="password" name="password" class="form-control password">
                  <div class="input-group-append">
                    <div class="input-group-text focusPass" style="background-color:#E0ECFF; color:white;">
                      <span class="fas fa-eye toggle-password" toggle=".password" style="color:#0e2d5f;"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" id="approvalKacab" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for approve kacab edit all-->
  <div class="modal fade" id="approveKacabEditAll" tabindex="-1" aria-labelledby="approveKacabEditAllLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title">Force Edit</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <form id="formApproveKacabEditAll" target="_blank">
          @csrf
          <div class="modal-body">

            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Username</label>
              </div>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="hidden" name="date">
                  <input type="text" name="username" id="username" class="form-control" autofocus>
                  <div class="input-group-append">
                    <div class="input-group-text" style="background-color:#E0ECFF; color:white">
                      <span class="fas fa-user" style="color:#0e2d5f;"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-2">
                <label class="col-form-label">Password</label>
              </div>
              <div class="col-sm-10">
                <div class="input-group">
                  <input type="password" name="password" class="form-control password">
                  <div class="input-group-append">
                    <div class="input-group-text focusPass" style="background-color:#E0ECFF; color:white;">
                      <span class="fas fa-eye toggle-password" toggle=".password" style="color:#0e2d5f;"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" id="approvalKacabEditAll" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="wrapper">
    @include('layouts._navbar')
    @include('layouts._sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active" style="text-transform: uppercase;">
                  {!! $breadcrumb !!}
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        @yield('content')
      </section>
    </div>

    {{-- <footer class="main-footer">
      <strong>Design &copy; by <a href="#">IT PUSAT</a>.</strong>
    </footer> --}}
  </div>

  <!-- jQuery -->
  <script src="{{ asset('libraries/adminlte/plugins/jquery/jquery.min.js') }}"></script>

  <!-- jQuery UI -->
  <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>

  <!-- Highlight -->
  <script src="{{ asset('libraries/highlight/highlight.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('libraries/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- ChartJS -->
  <script src="{{ asset('libraries/adminlte/plugins/chart.js/Chart.min.js') }}"></script>


  <!-- daterangepicker -->
  <script src="{{ asset('libraries/adminlte/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('libraries/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('libraries/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

  <!-- overlayScrollbars -->
  <script src="{{ asset('libraries/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('libraries/adminlte/dist/js/adminlte.js') }}"></script>

  <!-- JqGrid -->
  <script src="{{ asset('libraries/jqgrid/570/js/jquery.jqGrid.js') }}"></script>
  <script src="{{ asset('libraries/jqgrid/570/js/i18n/grid.locale-en.js') }}"></script>

  <!-- Autonumeric -->
  <script src="{{ asset('libraries/autonumeric/4.5.4/autonumeric.min.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('libraries/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

  {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script> --}}

  <!-- Inputmask -->
  <script src="{{ asset('libraries/inputmask/5.0.6/jquery.inputmask.min.js') }}"></script>

  {{-- <script src="{{ asset('libraries/tas-lib/js/inputmask.js') }}"></script> --}}

  <!-- dropzone -->
  <script src="{{ asset('libraries/adminlte/plugins/dropzone/dropzone.js') }}"></script>

  <!-- Nestable2 -->
  <script src="{{ asset('libraries/nestable2/1.6.0/js/jquery.nestable.min.js') }}"></script>

  <!-- jQuery UI -->
  <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Report -->
  <link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.viewer.js') }}"></script>
  <script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.designer.js') }}"></script>
  <script src="{{ asset('libraries/tas-lib/js/terbilang.js?version='. config('app.version')) }}"></script>

  <script src="{{ asset('js/enable-push.js?version='. date('YmdHis')) }}" defer></script>
  <!-- Custom global script -->
  <script src="{{ asset('libraries/tas-lib/js/pager.js?version='. date('YmdHis')) }}"></script>
  <script src="{{ asset('libraries/tas-lib/js/lookup.js?version='. date('YmdHis')) }}"></script>
  <script src="{{ asset('libraries/tas-lib/js/mains.js?version='. date('YmdHis')) }}"></script>
  {{-- <script src="{{ asset('libraries/tas-lib/js/app.js?version='. date('YmdHis')) }}"></script> --}}
  <script src="{{ asset('libraries/tas-lib/js/movementeditall.js?version='. date('YmdHis')) }}"></script>
  <script src="{{ asset('libraries/tas-lib/js/movementeditallTransaksi.js?version='. date('YmdHis')) }}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
 

  {{-- <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script> --}}
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

  <!-- Pusher -->

  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

  <!-- Custom page script -->
  @stack('scripts')

  <script type="text/javascript">

    let accessToken = `{{ session('access_token') }}`
    let accessTokenEmkl = `{{ session('access_token_emkl') }}`
    let accessTokenMdn = `{{ session('access_token_mdn') }}`
    let accessTokenJkt = `{{ session('access_token_jkt') }}`
    let accessTokenJktTnl = `{{ session('access_token_jkttnl') }}`
    let accessTokenMks = `{{ session('access_token_mks') }}`
    let accessTokenSby = `{{ session('access_token_sby') }}`
    let accessTokenBtg = `{{ session('access_token_btg') }}`
    let appUrl = `{{ url()->to('/') }}`
    let apiUrl = `{{ config('app.api_url') }}`
    let apiEmklUrl = `{{ config('app.emkl_api_url') }}`
    let apiTruckingMdnUrl = `{{ config('app.trucking_api_mdn_url') }}`
    let apiTruckingJktUrl = `{{ config('app.trucking_api_jkt_url') }}`
    let apiTruckingJktTnlUrl = `{{ config('app.trucking_api_jkttnl_url') }}`
    let apiTruckingMksUrl = `{{ config('app.trucking_api_mks_url') }}`
    let apiTruckingSbyUrl = `{{ config('app.trucking_api_sby_url') }}`
    let apiTruckingBtgUrl = `{{ config('app.trucking_api_btg_url') }}`
    var pleaseSelectARow;

    function separatorNumber(object) {
      var value = parseInt(object.value.replaceAll('.', '').replaceAll(',', ''));

      if ($.isNumeric(value)) {
        object.value = value.toLocaleString();
      } else {
        object.value = '';
      }

      return true;
    }

    $(document).on('click', ".toggle-password", function(event) {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    var pusher = new Pusher('861c676f65999341c5a5', {
      cluster: 'ap1'
    });

    // pusher.connection.bind('error', function(err) {
    //   console.error(err);
    // });

    var channel = pusher.subscribe('data-channel');

    channel.bind("App\\Events\\NewNotification", (response) => {

      var message = JSON.parse(response.message);
      if (message.olduser == '<?= auth()->user()->name ?>') {
        showDialogForce(message.message)
        // $("#dialog-force-message").dialog({
        //   close: function(event, ui) {
        //     isAllowedForceEdit = true
        //     approveKacab(message.id)
        //   },
        // });
      }
    });

    channel.bind("App\\Events\\PenjualanHeaderNotification", (response) => {

    var message = JSON.parse(response.message);
    if (message.olduser == '<?= auth()->user()->name ?>') {
      showDialogForce(message.message)
      // $("#dialog-force-message").dialog({
      //   close: function(event, ui) {
      //     isAllowedForceEdit = true
      //     approveKacab(message.id)
      //   },
      // });
    }
    });

    channel.bind("App\\Events\\PembelianHeaderNotification", (response) => {

      var message = JSON.parse(response.message);
      if (message.olduser == '<?= auth()->user()->name ?>') {
        showDialogForce(message.message)
        // $("#dialog-force-message").dialog({
        //   close: function(event, ui) {
        //     isAllowedForceEdit = true
        //     approveKacab(message.id)
        //   },
        // });
      }
    });

    $(".formatdate").datepicker({
        dateFormat: 'dd-mm-yy',
        assumeNearbyYear: true
      })
      .inputmask({
        inputFormat: "dd-mm-yyyy",
        alias: "datetime",
      })
      .focusout(function(e) {
        let val = $(this).val()
        if (val.match('[a-zA-Z]') == null) {
          if (val.length == 8) {
            $(this).inputmask({
              inputFormat: "dd-mm-yyyy",
            }).val([val.slice(0, 6), '20', val.slice(6)].join(''))
          }
        } else {
          $(this).focus()
        }
      })
      .focus(function() {})

    $(document).ready(function() {
      // Echo.channel('export')
      //   .listen('UpdateExportProgress', event => {
      //     $('.modal-body').append(`<div id="progressbar"></div>`)

      //     $(document).find('#progressbar').progressbar({
      //       value: event.progress
      //     })

      //     $('.ui-progressbar-value').addClass('text-center').text(`${parseInt(event.progress)}%`)

      //     if (event.progress >= 100) {
      //       $(document).find('#progressbar').remove()
      //     }
      //   })

      $.ajax({
        url: `${apiUrl}error/geterrors`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          kodeerror: "PSB"
        },
        success: response => {
          pleaseSelectARow = response.keterangan;
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          }
        }
      })
    })

    $(document).on('collapsed.lte.pushmenu', () => {
      $('body').removeClass('sidebar-open')
    })

    $(document).on('shown.lte.pushmenu', () => {
      $('body').addClass('sidebar-open')
    })

    function initLookupMaster() {
      $('.karyawan-lookup').lookup({
        title: 'karyawan Lookup',
        fileName: 'karyawan',
        typeSearch: 'ALL',
        searching: 1,
        beforeProcess: function(test) {
          this.postData = {
            Aktif: 'AKTIF',
            searching: 1,
            valueName: 'karyawan_id',
            searchText: 'karyawan-lookup',
            singleColumn: true,
            hideLabel: true,
            title: 'karyawan',
          }
        },
        onSelectRow: (karyawan, element) => {
          $('#crudForm [name=karyawanid]').first().val(karyawan.id)
          element.val(karyawan.nama)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $('#crudForm [name=karyawanid]').first().val('')
          element.val('')
          element.data('currentValue', element.val())
        }
      })
    }

    function processResult(result, destination = "") {
      if (result) {
        // console.log(destination);
        $.ajax({
          url: `${apiUrl}${destination}`,
          method: 'POST',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          success: response => {
            $('#jqGrid').jqGrid().trigger('reloadGrid');
          },
          error: error => {
            if (error.status === 422) {
              $('.is-invalid').removeClass('is-invalid')
              $('.invalid-feedback').remove()

              setErrorMessages(form, error.responseJSON.errors);
            }
          }
        })
      }
    }




    function setRange(isToday = false,firstDayParam = null, lastDayParam = null) {
     
      // mendapatkan tanggal hari ini
      let today = new Date();
      let formattedLastDay;
      let firstDay
      let lastDay

      if (firstDayParam) {
        firstDay = new Date(firstDayParam);
      } else {
        // mendapatkan tanggal pertama di bulan ini
        firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
      }

      let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);

      if (lastDayParam) {
        lastDay = new Date(lastDayParam);
      } else if (isToday) {
        lastDay = new Date()
        // formattedLastDay=$.datepicker.formatDate('dd-mm-yy', )
      } else {
        // mendapatkan tanggal terakhir di bulan ini
        lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
      }
      formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);



      $('#rangeHeader').find('[name=tgldariheader]').val(formattedFirstDay).trigger('change');
      $('#rangeHeader').find('[name=tglsampaiheader]').val(formattedLastDay).trigger('change');

      $('#crudForm').find(`[name="tgldari"]`).val(formattedFirstDay).trigger('change');
      $('#crudForm').find(`[name="tglsampai"]`).val(formattedLastDay).trigger('change');

    }

    function loadDataHeader(url, addtional = null) {

      let data = {
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val()
      }
      data = {
        ...data,
        ...addtional
      }
      getIndex(url, data).then((response) => {
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        clearGlobalSearch($('#jqGrid'))
        $('#jqGrid').setGridParam({
          url: `${apiUrl}${url}`,
          datatype: "json",
          postData: data,

          page: 1
        }).trigger('reloadGrid')
      }).catch((error) => {
        clearGlobalSearch($('#jqGrid'))

        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          errors = error.responseJSON.errors

          $.each(errors, (index, error) => {
            let indexes = index.split(".");
            let element;
            if (indexes[0] == 'tgldari' || indexes[0] == 'tglsampai') {
              element = $('#rangeHeader').find(`[name="${indexes[0]}header"]`)[0];
            } else {
              element = $('#rangeHeader').find(`[name="${indexes[0]}"]`)[0];
            }

            $(element).addClass("is-invalid");
            $(`
              <div class="invalid-feedback">
              ${error[0].toLowerCase()}
              </div>
			    `).appendTo($(element).parent());

          });

          $(".is-invalid").first().focus();
          $('#processingLoader').addClass('d-none')
        } else {
          showDialog(error.responseJSON)
        }
      })

    }

    function getIndex(url, data) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}${url}`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: data,
          success: (response) => {
            resolve(response);
          },
          error: error => {
            reject(error)
          },
        });
      });
    }

    function setRangeLookup() {
      // mendapatkan tanggal hari ini
      let today = new Date();

      // mendapatkan tanggal pertama di bulan ini
      let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
      let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);

      // mendapatkan tanggal terakhir di bulan ini
      let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
      let formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);

      $('#rangeHeaderLookup').find('[name=tgldariheaderlookup]').val(formattedFirstDay).trigger('change');
      $('#rangeHeaderLookup').find('[name=tglsampaiheaderlookup]').val(formattedLastDay).trigger('change');

    }


    function loadDataHeaderLookup(url, grid, addtional = null) {
      clearGlobalSearch($('#jqGrid'))
      let data = {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val()
      }
      data = {
        ...data,
        ...addtional
      }
      getIndexLookup(url, data).then((response) => {
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        clearGlobalSearch($('#jqGrid'))
        $(`#${grid}`).setGridParam({
          url: `${apiUrl}${url}`,
          datatype: "json",
          postData: data,

          page: 1
        }).trigger('reloadGrid')
      }).catch((error) => {
        clearGlobalSearch($('#jqGrid'))

        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          errors = error.responseJSON.errors

          $.each(errors, (index, error) => {
            let indexes = index.split(".");
            let element;
            element = $('#rangeHeaderLookup').find(`[name="${indexes[0]}headerlookup"]`)[0];

            $(element).addClass("is-invalid");
            $(`
              <div class="invalid-feedback">
              ${error[0].toLowerCase()}
              </div>
			    `).appendTo($(element).parent());

          });

          $(".is-invalid").first().focus();
          $('#processingLoader').addClass('d-none')
        } else {
          showDialog(error.responseJSON)
        }
      })


    }

    function getIndexLookup(url, data) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}${url}`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: data,
          success: (response) => {
            resolve(response);
          },
          error: error => {
            reject(error)

          },
        });
      });
    }
  </script>
</body>

</html>