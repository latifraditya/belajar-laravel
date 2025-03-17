<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('brand'); 
            $table->string('processor');
            $table->integer('ram_gb'); // RAM dalam GB
            $table->string('storage'); // Bisa SSD/HDD
            $table->string('gpu');
            $table->decimal('weight_kg', 5, 2); // Berat dalam kg
            $table->decimal('price_usd', 10, 2); // Harga dalam USD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
