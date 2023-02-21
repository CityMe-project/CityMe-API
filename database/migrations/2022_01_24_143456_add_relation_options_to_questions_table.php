<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationOptionsToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->uuid('question_id_related')->nullable()->unsigned();
            $table->foreign('question_id_related')->references('question_id')->on('questions');
            $table->uuid('option_id_related')->nullable()->unsigned();
            $table->foreign('option_id_related')->references('option_id')->on('options');
            $table->text('note')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('question_id_related');
            $table->dropColumn('option_id_related');
            $table->dropColumn('note');
        });
    }
}
