<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PelunasanPiutangHeaderController extends MyController
{
    public $title = 'Pelunasan Piutang Header';

    /**
     * @ClassName index
     */
    public function index()
    {
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama Pelunasan Piutang',
            'statusmemo' => $this->combo('list', 'STATUS', 'STATUS'),
            'jenispelunasanpiutangmemo' => $this->combo('list', 'JENIS PELUNASAN', 'JENIS PELUNASAN'),
        ];
        return view('pelunasanpiutangheader.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'pelunasanhutangheader', $params);

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
}
