<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Login';

        return view('login', compact('title'));
    }

    /**
     * To proccess login
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return void
     */
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'password' => 'required'
        ], [
            'user.required' => 'USERNAME WAJIB DIISI',
            'password.required' => 'PASSWORD WAJIB DIISI',
        ]);

        $credentials = [
            'user' => $request->user,
            'password' => $request->password
        ];

        $start = now();
        if (Auth::attempt($credentials)) {

            $token = Http::withHeaders([
                'Accept' => 'application/json'
            ])->withOptions(['verify' => false])
                ->post(config('app.api_url') . 'token', $credentials);

            // dd($token->json());

            // Calculate the time elapsed
            $timeElapsed = now()->diffInMilliseconds($start);

            // dd($timeElapsed);
            session(['access_token' => $token['access_token']]);
            // session(['access_token_emkl' => $tokenEmkl['access_token']]);
            session(['menus' => (new Menu())->getMenu()]);

           if ($token['role_id'] == 'CUSTOMER') {
                return redirect()->route('pesananheader.index');
           }elseif($token['role_id'] == 'KARYAWAN'){
                return redirect()->route('cekpesanan.index');
           }else{
                return redirect()->route('dashboard');
           }

            
        } else {
            return redirect()->back()->withErrors([
                'user_not_found' => 'User not registered'
            ]);
        }
    }


    public function logout()
    {
        Auth::logout();

        session()->forget('menus');

        return redirect()->route('login');
    }

    public function cekIp(Request $request)
    {
        $credentials = [
            'user' => $request->user,
            'password' => $request->password,
        ];
        $dataIp = $credentials;
        $dataIp['ipclient'] = $request->ip();
        dd($dataIp);
        $cekIp = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => true])
            // ->get("https://tasmdn.kozow.com:8074/trucking-api/public/api/" . 'cekIp', $credentials);
            ->get(config('app.api_url') . 'cekIp', $dataIp);
        dd($cekIp['data']);
    }

    public function cek_param()
    {
        $status = [
            "grp" => "STATUS AKSES",
            "subgrp" => "STATUS AKSES",
            "text" => "PUBLIC"
        ];
        $parameter = Http::withHeaders([
            'Accept' => 'application/json'
        ])->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'parameter/getparamrequest', $status);
    }
}
