<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonbooksearchHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_booksearch_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
        	$table->string('username', 255)->nullable();
            $table->tinyInteger('item')->default(0);
            $table->tinyInteger('work_test')->default(0);
            $table->tinyInteger('age')->default(0);
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->integer('book_id')->unsigned()->nullable();
            $table->string('title', 255)->nullable();
            $table->string('writer', 255)->nullable();
            $table->string('jangru', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('action', 255)->nullable();
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
        Schema::drop('person_booksearch_history');
    }
}
