<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function listKategori()
    {
        return view("Kategori.index");
    }
}
