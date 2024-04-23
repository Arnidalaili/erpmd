<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HariLiburController extends MyController
{
    public $title = 'Hari Libur';

    public function index(Request $request)
    {
        $title = $this->title;
        
        $data = [
            'pagename' => 'Menu Utama Hari Libur',
            'combo' => $this->combo('list', 'STATUS', 'STATUS')
        ];

        
        return view('harilibur.index', compact('title', 'data'));
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
            ->get(config('app.api_url') . 'harilibur', $params);

        $data = [
            'total' => $response['attributes']['totalPages'] ?? [],
            'records' => $response['attributes']['totalRows'] ?? [],
            'rows' => $response['data'] ?? [],
            'params' => $response['params'] ?? [],
        ];

        return $data;
    }


    public function combo($aksi,$grp, $subgrp)
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

    public function export(Request $request)
    {
        $params = [
            'offset' => $request->dari - 1,
            'rows' => $request->sampai - $request->dari + 1,
        ];

        $parameters = $this->get($params)['rows'];

        $columns = [
            [
                'label' => 'No',
            ],
            [
                'label' => 'ID',
                'index' => 'id',
            ],
            [
                'label' => 'Group',
                'index' => 'grp',
            ],
            [
                'label' => 'Subgroup',
                'index' => 'subgrp',
            ],
            [
                'label' => 'Text',
                'index' => 'text',
            ],
            [
                'label' => 'Memo',
                'index' => 'memo',
            ],
        ];
        $this->toExcel($this->title, $parameters, $columns);
    }
    
    public function report(Request $request)
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'harilibur', $request->all());

        $hariliburs = $response['data'];
        $i = 0;
        foreach ($hariliburs as $index => $params) {
            $status = $params['status'];
            $result = json_decode($status, true);
            $status = $result['MEMO'];
            $hariliburs[$i]['status'] = $status;
            $i++;
        }
        return view('reports.harilibur', compact('hariliburs'));
    }

   
}
