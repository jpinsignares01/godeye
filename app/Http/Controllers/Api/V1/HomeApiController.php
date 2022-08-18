<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RicorocksDigitalAgency\Soap\Facades\Soap;

class HomeApiController extends Controller
{
    /* 
    * Get planets per page
    */
    public function getPlanets(Request $request) {
        $planets = Http::get('https://swapi.dev/api/planets?page='.$request->page)->collect();
        return response()->json($planets);
    }

    /* 
    * Get person
    */
    public function getPerson(Request $request) {
        $person = Http::get($request->person)->collect();
        $person['height_formated'] = trim(Soap::to('https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL')->call('NumberToWords', ['ubiNum' => $person['height']])->response->NumberToWordsResult);
        $person['mass_formated'] = trim(Soap::to('https://www.dataaccess.com/webservicesserver/NumberConversion.wso?WSDL')->call('NumberToWords', ['ubiNum' => $person['mass']])->response->NumberToWordsResult);
        return response()->json($person);
    }
}
