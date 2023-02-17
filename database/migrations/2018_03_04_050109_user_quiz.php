<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserQuiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_quizes', function(Blueprint $table){
        	$table->increments('id');
        	$table->integer('user_id')->unsigned();
        	$table->integer('book_id')->unsigned();
        	$table->tinyInteger('type')->default(0);
            $table->tinyInteger('status')->default(0);
        	$table->integer('org_id')->unsigned()->nullable();
        	$table->timestamp('created_date')->nullable();
        	$table->timestamp('finished_date')->nullable();
        	$table->timestamp('published_date')->nullable();
        	$table->integer('quiz_id')->unsigned()->nullable();
            $table->string('doq_quizid', 255)->nullable();
        	$table->double('point')->default(0);
        	$table->tinyInteger('test_num')->default(0);
            $table->tinyInteger('passed_test_time')->nullable();
            $table->boolean('is_public')->default(false); //0 非公開 1 公開 
            $table->tinyInteger('examinemethod')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_quizes');
    }
}
