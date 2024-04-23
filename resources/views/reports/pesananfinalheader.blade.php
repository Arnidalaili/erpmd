<?php require base_path('reports/stireport_config.inc'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Laporan Pesanan Final</title>
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('libraries/tas-lib/js/terbilang.js?version='. config('app.version')) }}"></script>
  <script type="text/javascript">
    let pesananfinal = <?= json_encode($pesananfinal); ?>;
    let pesananfinaldetail = <?= json_encode($pesananfinaldetail); ?>;
    
    var report;
    var dataSet;

    function Start() {
      Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
      report = new Stimulsoft.Report.StiReport();
      dataSet = new Stimulsoft.System.Data.DataSet("Data");

      report.loadFile(`{{ asset('public/reports/ReportPesananFinalHeader.mrt') }}`);
      dataSet.readJson({
        'pesananfinal': pesananfinal,
        'pesananfinaldetail': pesananfinaldetail
      });

      report.regData(dataSet.dataSetName, '', dataSet);
      report.dictionary.synchronize();

      report.renderAsync(function () {
        report.exportDocumentAsync(function(pdfData) {
          var fileName = 'LaporanPesananFinal';
          Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
        }, Stimulsoft.Report.StiExportFormat.Pdf);
      });
    }

    // function exportAndDownloadPDF() {
      
    //   report.renderAsync(function () {
    //     report.exportDocumentAsync(function(pdfData) {
    //       var fileName = 'LaporanPesananFinal';
    //       Stimulsoft.System.StiObject.saveAs(pdfData, fileName + '.pdf', 'application/pdf');
    //     }, Stimulsoft.Report.StiExportFormat.Pdf);
    //   });
    // }
  </script>
  <style>
    .stiJsViewerPage {
      word-break: break-all !important;
    }
  </style>
</head>
<body onLoad="Start()">
</body>
</html>
