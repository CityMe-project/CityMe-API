<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->uuid('option_id')->unique()->primary();
            $table->uuid('question_id')->unsigned();
            $table->foreign('question_id')->references('question_id')->on('questions');
            $table->string('text')->nullable();
            $table->string('type')->nullable();
            $table->string('order')->nullable();
            $table->boolean('complement')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }
}
