<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2021-08-27
 * Time: 21:09
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PopulationController extends Controller
{
    public function worldPopulation(Request $request)
    {
        $worldRecord = json_decode($this->worldRecordData())->body;
        $allCountry = json_decode($this->allCountry())->body->countries;
        $page = $request->input('page');
        if(empty($page)) {
            $page = 1;
        }
        $top20 = array_slice($allCountry, 0, 20);
        $countries = array_slice($top20, $page * 10 - 10, 10);
        $result = [];
        foreach($countries as $key => $country) {
            $result[$country] = json_decode($this->populationByName(str_replace('&', '%26',str_replace(' ', '%20', $country))))->body ?? [];
        }

        return view('index')->with([
            'allRecord' => $worldRecord,
            'result' => $result,
            'page' => $page,
            'total' => 20,
            'route' => Route::currentRouteName()
        ]);
    }

    public function all(Request $request)
    {
        $worldRecord = json_decode($this->worldRecordData())->body;
        $allCountry = json_decode($this->allCountry())->body->countries;

        $page = $request->input('page');
        if(empty($page)) {
            $page = 1;
        }
        $result = [];
        $countries = array_slice($allCountry, $page * 10 - 10, 10);
        foreach($countries as $key => $country) {
            $result[$country] = json_decode($this->populationByName(str_replace('&', '%26',str_replace(' ', '%20', $country))))->body ?? [];
        }

        return view('index')->with([
            'allRecord' => $worldRecord,
            'result' => $result,
            'page' => $page,
            'total' => $worldRecord->total_countries,
            'route' => Route::currentRouteName()
        ]);
    }
    private function worldRecordData()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://world-population.p.rapidapi.com/worldpopulation",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: world-population.p.rapidapi.com",
                "x-rapidapi-key: ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07"
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    private function allCountry()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://world-population.p.rapidapi.com/allcountriesname",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: world-population.p.rapidapi.com",
                "x-rapidapi-key: ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }

    private function populationByName($name)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://world-population.p.rapidapi.com/population?country_name=" . $name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: world-population.p.rapidapi.com",
                "x-rapidapi-key: ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if($err) {
            dd($err, $name);
        }
        curl_close($curl);

        return $response;
    }
}