<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameColumnsGeometriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geometries', function (Blueprint $table) {
            $table->renameColumn('answer_id_related', 'answer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geometries', function (Blueprint $table) {
            $table->renameColumn('answer_id', 'answer_id_related');
        });
    }
}
