<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('type')->default(1);
            $table->date('date')->nullable();
            $table->string('title',500)->nullable();
            $table->text('description')->nullable();
            $table->decimal('percentage',10,2)->nullable();
            $table->smallInteger('fee')->nullable();
            $table->smallInteger('status')->default(2);
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
        Schema::dropIfExists('days');
    }
}
