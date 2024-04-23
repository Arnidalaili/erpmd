<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenjualanHeaderController extends MyController
{
    
    public $title = 'Penjualan Header';
    
    public function index(Request $request)
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Penjualan Header',
            'statusmemo' => $this->combo('list', 'STATUS', 'STATUS'),
            'topmemo' => $this->combo('list', 'TOP', 'TOP'),
        ];

        return view('penjualanheader.index', compact('title', 'data'));
    }

    public function combo($aksi, $grp, $subgrp)
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
            ->get(config('app.api_url') . 'penjualanheader', $params);

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

    public function invoice(Request $request)
    {
        //FETCH HEADER
        $id = $request->id;
        
        $header = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penjualanheader/'.$id.'/invoice')['data'];

        $detailParams = [
            'forInvoice' => true,
            'penjualanid' => $request->id
        ];

        $detail = Http::withHeaders(request()->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penjualandetail', $detailParams)['data'];

        // dd($header, $detail, $detailParams, $id, config('app.api_url') . 'penjualandetail', $detailParams);

        return view('reports.invoicepenjualan', compact('header', 'detail'));
    }


}
