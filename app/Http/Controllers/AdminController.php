<?php

namespace App\Http\Controllers;

use App\Http\Helper\CurlHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        $data = [
            "email" => $email,
            "password" => $password
        ];

        $curl = new CurlHelper();
        $respone = $curl->post($data,env("URL_API")."login");

        if ($respone["status"] == "SUCCESS") {
            Cache::add('key',$respone["data"]);
        }

        return $respone;
    }

    public function dashboard()
    {
        return view("dashboard");
    }

    public function logout()
    {
        Cache::flush();
        return redirect('dashboard/login');
    }
}
