<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class SatuanController extends MyController
{
    public $title = 'Satuan';

    public function index(Request $request)
    {
        
        $title = $this->title;
        
        $data = [
            'pagename' => 'Menu Utama Satuan',
            'statusmemo' => $this->combo('list')
        ];
        return view('satuan.index', compact('title', 'data'));
    }

    public function combo($aksi)
    {
        
        $status = [
            'status' => $aksi,
            'grp' => 'STATUS',
            'subgrp' => 'STATUS',
        ];

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/combolist', $status);

        return $response['data'];
    }

    public function get($params = [])
    {
// dd('test');
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
            ->get(config('app.api_url') . 'satuan', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'satuan/field_length');

        return response($response['data']);
    }
}
