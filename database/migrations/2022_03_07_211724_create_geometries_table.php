<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeometriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geometries', function (Blueprint $table) {
            $table->uuid('geometry_id')->unique()->primary();
            $table->text('geom');
            $table->uuid('answer_id_related')->unsigned();
            $table->foreign('answer_id_related')->references('answer_id')->on('answers');
            $table->text('tags')->default();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geometries');
    }
}
