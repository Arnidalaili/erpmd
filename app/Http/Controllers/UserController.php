<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends MyController
{
    public $title = 'User';

    public function index(Request $request)
    {
       
        $title = $this->title;
        $data = [
            'pagename' => 'Menu Utama User',
            'status' => $this->comboStatus('list','STATUS','STATUS'),
            'statusakses' => $this->comboStatus('list','STATUS AKSES','STATUS AKSES'),
        ];
        return view('user.index', compact('title', 'data'));
    }

    public function comboStatus($aksi,$grp,$subgrp)
    {
        $status = [
            'status' => $aksi,
            'grp' => $grp,
            'subgrp' => $subgrp,
        ];
        // dd($status);
        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/combostatus', $status);
        
        return $response['data'];
    }
    public function aclGrid()
    {
        return view('user.acl._grid');
    }

    public function roleGrid()
    {
        return view('user.role._grid');
    }

    public function create()
    {
        $title = $this->title;

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.add', compact('title', 'data'));
    }

    public function edit($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "user/$id");

        $user = $response['data'];

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.edit', compact('title', 'user', 'data'));
    }

    public function delete($id)
    {
        $title = $this->title;

        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . "user/$id");

        $user = $response['data'];

        $data['combo'] = $this->combo('entry');
        $data['combocabang'] = $this->combocabang('entry');

        return view('user.delete', compact('title', 'user', 'data'));
    }

    public function report(Request $request): View
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user', $request->all());

        $users = $response['data'];


        $i = 0;
        foreach ($users as $index => $params) {

            $status = $params['status'];
            $statusakses = $params['statusakses'];

            $result = json_decode($status, true);
            $resultAkses = json_decode($statusakses, true);

            $status = $result['MEMO'];
            $statusakses = $resultAkses['MEMO'];

            $users[$i]['status'] = $status;
            $users[$i]['statusakses'] = $statusakses;
            $i++;
        }

        return view('reports.user', compact('users'));
    }

    public function fieldLength()
    {
        $response = Http::withHeaders($this->httpHeaders)
            ->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/field_length');

        return response($response['data'], $response->status());
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

            // dd('test');
        return $response['data'];
    }

    public function getuserid(Request $request)
    {
        $status = [
            'user' => $request['user'],
        ];

        $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
            ->withToken(session('access_token'))
            ->get(config('app.api_url') . 'user/getuserid', $status);

        return $response['data'];
    }

    // public function combocabang($aksi)
    // {
    //     $status = [
    //         'status' => $aksi,
    //     ];

    //     $response = Http::withHeaders($this->httpHeaders)->withOptions(['verify' => false])
    //         ->withToken(session('access_token'))
    //         ->get(config('app.api_url') . 'user/combocabang', $status);

    //     return $response['data'];
    // }
}
