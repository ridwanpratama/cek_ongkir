<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request; //new Laravel 7 HTTP Client
use App\Province;
use App\City;

class getApiRajaOngkirController extends Controller
{
    public function index(Request $request){
        //Variabel key dan url API raja ongkir
        $key = ''; // Gunakan API key dari Raja ongkir
        $cost_url = 'https://api.rajaongkir.com/starter/cost';
        
        

        //Variabel yang valuenya didapat dari request()
        if($request->has('origin') && $request->has('origin') && $request->has('destination') && $request->has('weight') && $request->has('courier')){
            $name = $request->name;
            $data_origin = $request->origin;
            $data_destination = $request->destination;
            $data_weight = $request->weight;
            $data_courier = $request->courier;

            $origin_name = City::where('id','=',$data_origin)->first();
            $destination_name = City::where('id','=',$data_destination)->first();

            //logic untuk calculate cost
            $cost = $this->postData($key,$cost_url,$data_origin,$data_destination,$data_weight,$data_courier);
            //$cost->throw();
            $result_cost = $cost['rajaongkir']['results'][0]['costs'];
        }
        else{
            $name = "";
            $origin_name = "";
            $destination_name = "";
            $data_weight = "";
            $data_courier = "";
            $result_cost = null;
        }            

        //load data provinsi dari database
        $provinces = Province::all();    
    
        //load view form
        return view('form',compact('provinces','result_cost','name','origin_name','destination_name','data_weight','data_courier'));
        
    }
    
    //function untuk load select dependant
    public function getCitiesAjax($id)
    {
        $cities = City::where('province_id','=', $id)->pluck('city_name','id');       
    
        return json_encode($cities);
    }

    //function untuk calculate cost 
    private function postData($key, $url,$data_origin,$data_destination,$data_weight,$data_courier){
        //retry() maskudnya function untuk retry hit API jika time out sebanyak parameter pertama dan range interval pada parameter kedua dalam milisecon
        //asForm() maksudnya menggunakan application/x-www-form-urlencoded content type biasanya untuk method POST
        //withHeaders() maksudnya parameter header (Jika diminta, masing2 API punya header masing-masing dan yang tidak pakai header)
        return Http::retry(10, 200)->asForm()->withHeaders([            
            'key' => $key
        ])->post($url, [
            'origin' => $data_origin,
            'destination' => $data_destination,
            'weight' => $data_weight,
            'courier' => $data_courier
        ]);
        //setelah $url itu adalah array yaitu parameter wajib yg dibutuhkan ketika meminta POST request
    }

}