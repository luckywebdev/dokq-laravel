<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonoverseerHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_overseer_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned();
        	$table->string('username', 255);
            $table->tinyInteger('item')->default(0);
            $table->tinyInteger('work_test')->default(0);
            $table->tinyInteger('age')->default(0);
            $table->integer('book_id')->unsigned()->nullable();
            $table->string('title', 255)->nullable();
            $table->string('writer', 255)->nullable();
            $table->integer('quiz_id')->unsigned()->nullable();
            $table->string('doq_quizid', 255)->nullable();
            $table->string('bookregister_name', 255)->nullable();
            $table->text('content')->nullable();
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
        Schema::drop('person_overseer_history');
    }
}
