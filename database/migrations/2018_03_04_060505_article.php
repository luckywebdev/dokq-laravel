<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Article extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function(Blueprint $table){
        	$table->increments('id');
        	$table->integer('book_id')->unsigned();
        	$table->text('content');
        	$table->integer('register_id')->unsigned();
        	$table->integer('register_visi_type');
        	$table->tinyInteger('junior_visible')->default(0);
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
        Schema::drop('articles');
    }
}
