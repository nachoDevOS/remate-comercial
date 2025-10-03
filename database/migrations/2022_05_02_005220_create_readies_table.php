<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('readies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('day_id')->nullable()->constrained('days');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('lote')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('price_add',10,2)->nullable();
            $table->decimal('total_weight',10,2)->nullable();
            $table->smallInteger('defending')->nullable();
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readies');
    }
}
