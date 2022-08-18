<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RicorocksDigitalAgency\Soap\Facades\Soap;

class HomeApiController extends Controller
{
    public function getPlanets(Request $request) {
        $planets = Http::get('https://swapi.dev/api/planets?page='.$request->page)->collect();
        return response()->json($planets);
    }
}
