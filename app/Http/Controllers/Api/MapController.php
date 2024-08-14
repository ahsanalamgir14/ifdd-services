<?php

namespace App\Http\Controllers\Api;

use Http;
use Illuminate\Http\Request;

class MapController extends BaseController
{
    public function searchPlaces(Request $request)
    {
        $name = $request->query('name');
        
        $response = Http::withHeaders([
            'User-Agent' => 'carto/1.0'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $name,
            'format' => 'geojson',
            'limit' => 10
        ]);
        
        return $response;
        return $response->json();
    }
}
