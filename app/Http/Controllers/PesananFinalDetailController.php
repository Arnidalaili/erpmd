<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PesananFinalDetailController extends Controller
{
    public $title = 'Pesanan Final Detail';

    /**
     * Fungsi index
     * @ClassName index
     */
    public function index(Request $request)
    {
        $params = [
            'pesananfinalid' => $request->pesananfinalid,
            'whereIn' => $request->whereIn
        ];

        $response = Http::withHeaders($request->header())
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'pesananfinaldetail', $params);

        $data = [
            'rows' => $response['data'] ?? []
        ];

        return response($data);
    }
}
