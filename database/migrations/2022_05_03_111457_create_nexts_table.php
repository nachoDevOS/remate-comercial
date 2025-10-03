<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nexts', function (Blueprint $table) {
            $table->id();
            $table->integer('ready_id')->nullable();
            $table->integer('lote')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('price_add',10,2)->nullable();
            $table->string('category')->nullable();
            $table->integer('position')->default(0);
            $table->integer('total');
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
        Schema::dropIfExists('nexts');
    }
}
