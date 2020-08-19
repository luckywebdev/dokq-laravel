<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersontestHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_test_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned();
        	$table->string('username', 255);
            $table->tinyInteger('item')->default(0);
            $table->tinyInteger('work_test')->default(0);
            $table->tinyInteger('age')->default(0);
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->integer('book_id')->unsigned()->nullable();
            $table->string('title', 255)->nullable();
            $table->string('writer', 255)->nullable();
            $table->integer('quiz_id')->unsigned()->nullable();
            $table->string('doq_quizid', 255)->nullable();
            $table->tinyInteger('quiz_order')->nullable();
            $table->integer('testoversee_id')->unsigned()->nullable();
            $table->string('testoversee_username',255)->nullable();
            $table->tinyInteger('tested_time')->nullable();
            $table->double('tested_point')->nullable();
            $table->double('tested_short_point')->nullable();
            $table->double('point')->nullable();
            $table->tinyInteger('rank')->nullable();
            $table->double('thisyear_point')->nullable();
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
        Schema::drop('person_test_history');
    }
}
