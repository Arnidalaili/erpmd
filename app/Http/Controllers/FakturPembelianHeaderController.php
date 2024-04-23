<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FakturPembelianHeaderController extends Controller
{
    public $title = 'Pesanan Header';

    /**
     * @ClassName index
     */

    public function index(Request $request)
    {
        $title = $this->title;

        return view('fakturpembelianheader.index', compact('title'));
    }

    public function get($params = [])
    {

        $params = [
            'offset' => $params['offset'] ?? request()->offset ?? ((request()->page - 1) * request()->rows),
            'limit' => $params['rows'] ?? request()->rows ?? 0,
            'sortIndex' => $params['sidx'] ?? request()->sidx,
            'sortOrder' => $params['sord'] ?? request()->sord,
            'search' => json_decode($params['filters'] ?? request()->filters, 1) ?? [],
            'withRelations' => $params['withRelations'] ?? request()->withRelations ?? false,
        ];

        $response = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualanheader', $params);


        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];


        return $data;
    }

    public function comboList($aksi, $grp, $subgrp)
    {

        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }

    // /**
    //  * Fungsi getNoBukti
    //  * @ClassName getNoBukti
    //  */
    public function getNoBukti($group, $subgroup, $table)
    {
        $params = [
            'group' => $group,
            'subgroup' => $subgroup,
            'table' => $table
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "running_number", $params);

        $noBukti = $response['data'] ?? 'No bukti tidak ditemukan';

        return $noBukti;
    }

    public function report(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $header = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualanheader/' . $id . '/report')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'fakturpenjualan_id' => $id,
        ];
        $details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualandetail', $detailParams)['data'];
        // dd('test');

        return view('reports.fakturpenjualan', compact('header', 'details'));
    }

    public function export(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        $header = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualanheader/' . $id . '/report')['data'];

        //FETCH DETAIL
        $detailParams = [
            'forReport' => true,
            'fakturpenjualan_id' => $id,
        ];
        $details = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualandetail', $detailParams)['data'];

        $invoicedate = $header["invoicedate"];
        $timeStamp = strtotime($invoicedate);
        $dateinvoicedate = date('d-m-Y', $timeStamp);
        $header['invoicedate'] = $dateinvoicedate;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $header['judul']);
        $sheet->setCellValue('A2', $header['judulLaporan']);
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle("A2")->getFont()->setSize(12);
        $sheet->getStyle("A1")->getFont()->setBold(true);
        $sheet->getStyle("A2")->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        $header_start_row = 4;
        $detail_table_header_row = 8;
        $detail_start_row = $detail_table_header_row + 1;

        $alphabets = range('A', 'Z');

        $header_columns = [
            [
                'label' => 'No Invoice',
                'index' => 'noinvoice',
            ],
            [
                'label' => 'Invoice Date',
                'index' => 'invoicedate',
            ],
            [
                'label' => 'Customer Name',
                'index' => 'customer_name',
            ]
        ];

        $detail_columns = [
            [
                'label' => 'NO',
            ],
            [
                'label' => 'ITEM NAME',
                'index' => 'item_name',
            ],
            [
                'label' => 'DESCRIPTION',
                'index' => 'description',
            ],
            [
                'label' => 'QTY',
                'index' => 'qty',
            ],
            [
                'label' => 'PRICE',
                'index' => 'hargasatuan',
                'format' => 'currency'
            ],
            [
                'label' => 'AMOUNT',
                'index' => 'amount',
                'format' => 'currency'
            ]
        ];

        //LOOPING HEADER        
        foreach ($header_columns as $header_column) {
            $sheet->setCellValue('B' . $header_start_row, $header_column['label']);
            $sheet->setCellValue('C' . $header_start_row++, ': ' . $header[$header_column['index']]);
        }
        foreach ($detail_columns as $detail_columns_index => $detail_column) {
            $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_table_header_row, $detail_column['label'] ?? $detail_columns_index + 1);
        }
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
        );

        $style_number = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],

            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        // $sheet->getStyle("A$detail_table_header_row:G$detail_table_header_row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF1F456E');
        $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->applyFromArray($styleArray);

        // LOOPING DETAIL
        $total = 0;
        foreach ($details as $response_index => $response_detail) {

            foreach ($detail_columns as $detail_columns_index => $detail_column) {
                $sheet->setCellValue($alphabets[$detail_columns_index] . $detail_start_row, isset($detail_column['index']) ? $response_detail[$detail_column['index']] : $response_index + 1);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getFont()->setBold(true);
                $sheet->getStyle("A$detail_table_header_row:F$detail_table_header_row")->getAlignment()->setHorizontal('center');
            }
            $sheet->setCellValue("A$detail_start_row", $response_index + 1);
            $sheet->setCellValue("B$detail_start_row", $response_detail['item_name']);
            $sheet->setCellValue("C$detail_start_row", $response_detail['description']);
            $sheet->setCellValue("D$detail_start_row", $response_detail['qty']);
            $sheet->setCellValue("E$detail_start_row", $response_detail['hargasatuan']);
            $sheet->setCellValue("F$detail_start_row", $response_detail['amount']);

            $sheet->getStyle("C$detail_start_row")->getAlignment()->setWrapText(true);
            $sheet->getColumnDimension('C')->setWidth(50);
            $sheet->getStyle("E$detail_start_row:F$detail_start_row")->getNumberFormat()->setFormatCode("#,##0.00");

            $sheet->getStyle("A$detail_start_row:D$detail_start_row")->applyFromArray($styleArray);
            $sheet->getStyle("D$detail_start_row")->applyFromArray($style_number);

            $total += $response_detail['amount'];
            $detail_start_row++;
        }

        $total_start_row = $detail_start_row;
        $sheet->mergeCells('A' . $total_start_row . ':E' . $total_start_row);
        $sheet->setCellValue("A$total_start_row", 'Total')->getStyle('A' . $total_start_row . ':E' . $total_start_row)->applyFromArray($styleArray)->getFont()->setBold(true);
        $sheet->setCellValue("F$total_start_row", number_format((float) $total, '2', '.', ','))->getStyle("F$detail_start_row")->applyFromArray($style_number)->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan Faktur Penjualan' . date('dmYHis');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}