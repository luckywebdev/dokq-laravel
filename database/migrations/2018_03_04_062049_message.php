<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Message extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function(Blueprint $table){
        	$table->increments('id');
        	$table->tinyInteger('type');
        	$table->integer('from_id')->unsigned();
        	$table->text('to_id');
        	$table->text('content');
        	$table->string('post', 255);
            $table->string('name',255);
            $table->string('email',255);
            $table->tinyInteger('search_flag'); //0: default auto message by admin 1: 1人, 1人以上検索条件
            $table->string('search_username',255)->nullable();
            $table->string('search_name',255)->nullable();
            $table->string('search_address1',255)->nullable();
            $table->string('search_address2',255)->nullable();
            $table->string('search_gender',255)->nullable();
            $table->string('search_rank',255)->nullable();
            $table->string('search_usertype',255)->nullable();
            $table->string('search_year',255)->nullable();
            $table->tinyInteger('del_flag');
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
        Schema::drop('messages');
    }
}
