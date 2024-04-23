<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FakturPenjualanDetailController extends Controller
{
    public $title = 'Faktur Penjualan Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'fakturpenjualan_id' => $request->fakturpenjualan_id,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'fakturpenjualandetail', $params);

        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
