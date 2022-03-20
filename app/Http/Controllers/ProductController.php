<?php

namespace App\Http\Controllers;

use App\Http\Helper\CurlHelper;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index()
    {
        $curl = new CurlHelper();
        $response = $curl->get(env("URL_API") . "product");
        $result = [];
        if ($response["status"] == "SUCCESS") {
            $result = $response["data"];
        }
        return view("Catalog.index")->with(["product" => $result]);
    }

    public function listProduct()
    {
        return view("Product.index");
    }

    public function dataProdukView()
    {
        $curl = new CurlHelper();
        $response = $curl->get(env("URL_API") . "kategori/list");
        $result = [];
        if ($response["status"] == "SUCCESS") {
            $result = $response["data"];
        }
        return view("Product.create")->with("kategori", $result);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'kategoriId' => 'required',
            'file' => 'required'
        ]);

        if (!empty($validator->fails())) {
            return response()->json([
                'status' => 'success',
                'messsage' => withErrors($validator)->withInput()
            ]);
        }
        $file = $request->file('file');
        $path = public_path('image_product');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $name = uniqid() . '_' . trim($request->get("nama") . '.png');

        $file->move($path, $name);

        $data = [
            "nama_produk" => $request->get("nama"),
            "deskripsi_produk" => $request->get("deskripsi"),
            "harga_produk" => $request->get("harga"),
            "kategori_id" => $request->get("kategoriId"),
            "image" => $name
        ];

        $curl = new CurlHelper();
        $response = $curl->post($data, env("URL_API") . 'product');

        $res = json_decode($response, true);

        if ($res["status"] == "ERROR") {
            return response()->json([
                'status' => 'success',
                'messsage' => "Nama harus beda"
            ], 501);
        }

        return response()->json([
            'status' => 'success',
            'messsage' => $response
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->get("id");

        $data = [
            "id" => $id
        ];

        $curl = new CurlHelper();

        $curl->post($data, env('URL_API') . 'product/delete');

        return 'success';
    }

    public function dataProdukEdit($id)
    {
        $curl = new CurlHelper();
        $response = $curl->get(env("URL_API") . "product/data-edit/" . $id);
        $responseKategori = $curl->get(env("URL_API") . "kategori/list");

        $result = [];
        $resultData = [];
        if ($response["status"] == "SUCCESS") {
            $resultData = $response["data"];
        }
        if ($responseKategori["status"] == "SUCCESS") {
            $result = $responseKategori["data"];
        }

        return view("Product.update")->with(["kategori" => $result, 'data' => $resultData]);
    }
}
