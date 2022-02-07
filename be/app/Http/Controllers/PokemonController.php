<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller
{
    private $baseUrl = 'https://pokeapi.co/api/v2/';

    public function getUserPokemon(Request $request) {
        $liked_ids = DB::table('pokemons')
                    ->select('pokemon_id')
                    ->where('user_id', $request->user_id)
                    ->where('liked','1')
                    ->get();
        
        $disliked_ids = DB::table('pokemons')
                    ->select('pokemon_id')
                    ->where('user_id', $request->user_id)
                    ->where('disliked','1')
                    ->get();

        $result = array (
            'liked_ids' => $liked_ids,
            'liked_count' => $liked_ids->count(),
            'disliked_ids' => $disliked_ids,
            'disliked_count' => $disliked_ids->count()
        );

        return json_encode($result);
    }

    public function addUserPokemon(Request $request) {
        return Pokemon::create([
            'user_id' => $request->user_id,
            'pokemon_id' => $request->pokemon_id,
            'liked' => $request->liked,
            'disliked' => $request->disliked
        ]);
    }

    public function deleteUserPokemon(Request $request) {
        $toDelete = Pokemon::where('pokemon_id', $request->pokemon_id)
                    ->where('user_id', $request->user_id)
                    ->delete();
    }

    public function pokemon($lookUp = null)
    {
        $url = $this->baseUrl.'pokemon/'.$lookUp;
        return $this->sendRequest($url);
    }

    public function sendRequest($url)
    {
        $ch = curl_init();
        $timeout = 5;
        $certificate_location = __DIR__."../../../resources/cert/cacert.pem";

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $certificate_location);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $certificate_location);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code != 200) {
            // return http code and error message
            return json_encode([
                'code'    => $http_code,
                'message' => $data,
            ]);
        }

        return $data;
    }
}
