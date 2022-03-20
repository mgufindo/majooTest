<?php

namespace App\Http\Controllers;

use App\Http\Helper\CurlHelper;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $curl = new CurlHelper();
        $response = $curl->get(env("URL_API")."product");
        $result = [];
        if ($response["status"] == "SUCCESS") {
            $result = $response["data"];
        }
        return view("catalog.index")->with(["product" => $result]);
    }

    public function listProduct()
    {
        return view("product.index");
    }

    public function dataProduk(Request $request)
    {
        $curl = new CurlHelper();
        $data = [
            "draw" => $request->get("draw")
        ];
        $response = $curl->post($data,env("URL_API")."product");
        $result = [];
        if ($response["status"] == "SUCCESS") {
            $result = $response["data"];
        }

        return $result;
    }
}
