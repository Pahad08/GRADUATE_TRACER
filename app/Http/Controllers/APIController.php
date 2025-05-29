<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function HEIName()
    {
        $response = Http::withOptions(['stream' => true,])->timeout(60)->retry(3, 100)->withHeader('PORTAL-API', config('services.PORTAL_API'))
            ->acceptJson()->get(config('services.PORTAL_URL'));
        $heis = null;

        if ($response->successful()) {
            $decode_response = json_decode($response->body(), true);

            $heis = collect($decode_response)->unique('instName')->mapWithKeys(function ($item) {
                return [$item['instCode'] => $item['instName']];
            })->toArray();
        } elseif ($response->failed()) {
            $heis = ['error' => 'Error fetching data'];
        }

        return response()->json($heis);
    }

    public function UniqueHEi()
    {
        $response = Http::withOptions(['stream' => true])->timeout(60)->retry(3, 100)->withHeader('PORTAL-API', config('services.PORTAL_API'))
            ->acceptJson()->get(config('services.PORTAL_URL'));
        $heis = null;

        if ($response->successful()) {
            $decode_response = json_decode($response->body(), true);

            $heis = $decode_response;
        } else {
            $heis = ['error' => 'Error fetching data'];
        }
        return response()->json($heis);
    }
}