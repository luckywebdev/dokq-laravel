<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Quiz extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizes', function(Blueprint $table){
        	$table->increments('id');
            $table->string('doq_quizid', 255)->nullable();
        	$table->integer('book_id')->unsigned();
        	$table->integer('register_id')->unsigned();
        	$table->integer('register_visi_type');
        	$table->text('question');
        	$table->integer('answer');
        	$table->integer('app_page')->unsigned()->nullable()->default(0);
        	$table->integer('app_range');
        	$table->integer('active');
        	$table->timestamp('published_date')->nullable();
            $table->integer('overseer_id')->unsigned()->nullable();
            $table->tinyInteger('reason')->default(0);
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
        Schema::drop('quizes');
    }
}
