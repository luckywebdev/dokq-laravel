<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserQuizHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userquizes_history', function(Blueprint $table){
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
        	$table->double('point')->nullable();
        	$table->tinyInteger('test_num')->default(0);
            $table->tinyInteger('passed_test_time')->nullable();
            $table->boolean('is_public')->default(false);
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
        Schema::drop('userquizes_history');
    }
}
