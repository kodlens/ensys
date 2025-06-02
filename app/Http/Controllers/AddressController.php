<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use App\Models\Religion;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //

    public function loadProvinces(){
        $provinces = Province::orderBy('provDesc', 'asc')
        ->get();
        return $provinces;
    }


    public function loadCities(Request $req){
        $id = $req->prov;
        $cities = City::where('province_id', $id)
            ->orderBy('citymunDesc', 'asc')
            ->get();
        return $cities;
    }

    public function loadBarangays(Request $req){
        $provId = $req->prov;
        $cityId = $req->city;

        $barangays = Barangay::where('province_id', $provId)
            ->where('city_id', $cityId)
            ->orderBy('brgyDesc', 'asc')
            ->get();
        return $barangays;
    }

    public function loadReligions(Request $req){
        $data = Religion::orderBy('religion', 'asc')
            ->get();
        return $data;
    }


}
