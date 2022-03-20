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

    public function dataProdukView()
    {
        $curl = new CurlHelper();
        $response = $curl->get(env("URL_API")."kategori/list");
        $result = [];
        if ($response["status"] == "SUCCESS") {
            $result = $response["data"];
        }
        return view("product.create")->with("kategori", $result);
    }

    public function create(Request $request)
    {
        $file = $request->file('file');
        $path = public_path('image_product');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $name = uniqid() . '_' . trim($request->get("nama").'.png');

        $file->move($path, $name);

        $data = [
            "nama_produk" => $request->get("nama"),
            "deskripsi_produk" => $request->get("deskripsi"),
            "harga_produk" => $request->get("harga"),
            "kategori_id" => $request->get("kategoriId"),
            "image" => $name
        ];

        $curl = new CurlHelper();
        $response = $curl->post($data, env("URL_API").'product');

        return response()->json([
            'status' => 'success',
            'messsage' => $response
        ]);
    }
}
