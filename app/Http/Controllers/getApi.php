<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class getApi extends Controller
{
    public function index(){
        $response = Http::withHeaders([
            'key' => '24ab350702001990c8f460a5ca4a5e32'
        ])->post('https://api.rajaongkir.com/starter/cost');
        
        return $response->body();
    }
}
