<?php
namespace App\Http\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurlHelper {
    public function post($request,$url)
    {
        $header["Content-Type"] =  "application/json";

        $response = Http::withHeaders(
            $header
        )->post($url,$request);

        if ($response->status() != 200) {
            return $result = json_encode( [
                "status" => "ERROR",
                "code" => $response->status()
            ]);
            Log::error("response status not 200 : ".$response->body());
            die();
        }

        return  json_decode($response->body(), true);
    }

    public function get($url)
    {
        $header["Content-Type"] =  "application/json";

        $response = Http::withHeaders(
            $header
        )->get($url);

        if ($response->status() != 200) {
            return $result = json_encode( [
                "status" => "ERROR",
                "code" => $response->status()
            ]);
            Log::error("response status not 200 : ".$response->body());
            die();
        }

        return  json_decode($response->body(), true);
    }
}
