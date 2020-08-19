<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersontestoverseeHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_testoversee_history', function(Blueprint $table){
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
            $table->string('test_username',255)->nullable();
            $table->integer('overseer_num')->nullable();
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
        Schema::drop('person_testoversee_history');
    }
}
