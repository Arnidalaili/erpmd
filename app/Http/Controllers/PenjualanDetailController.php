<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PenjualanDetailController extends MyController
{
    public $title = 'Pesanan Final Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'penjualanId' => $request->penjualanId,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'penjualandetail', $params);

        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
