<?php
    require_once 'vendor/autoload.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $response = '...'; 
    $data = json_decode($response, true);
    $html = 
    '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Report Item</title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            th.centered {
                text-align: center;
            }
            th.title {
                text-align: center;
                font-size: 20px;
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <h1 class="title">Report Item</h1>
        <table>
            <thead>
                <tr class="centered">
                    <th>Name</th>
                    <th>Qty Min</th>
                    <th>Qty Max</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Modified By</th>
                </tr>
            </thead>
        </table>
    </body>
    </html>';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('output.pdf');
?>
