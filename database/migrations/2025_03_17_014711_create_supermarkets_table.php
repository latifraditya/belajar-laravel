<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupermarketsTable extends Migration
{
    public function up()
    {
        Schema::create('supermarkets', function (Blueprint $table) {
            $table->id();
            $table->string('branch');
            $table->string('city');
            $table->string('customer_type');
            $table->string('gender');
            $table->string('product_line');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('tax_5', 10, 2);
            $table->decimal('total', 10, 2);
            $table->date('date');
            $table->time('time');
            $table->string('payment');
            $table->decimal('cogs', 10, 2);
            $table->decimal('gross_margin_percentage', 10, 2);
            $table->decimal('gross_income', 10, 2);
            $table->decimal('rating', 3, 1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supermarkets');
    }
}
