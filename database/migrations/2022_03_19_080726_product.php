<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("produk", function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->string("nama_produk");
            $table->string("deskripsi_produk");
            $table->integer("harga_produk");
            $table->integer("kategori_id");
            $table->string("image");
            $table->integer("status")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

;
