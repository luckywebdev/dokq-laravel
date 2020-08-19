<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function(Blueprint $table){
        	$table->increments('id');
        	$table->integer('article_id')->unsigned();
        	$table->integer('voter_id')->unsigned();
        	$table->enum('status', array('0','1'));
        	$table->tinyInteger('voter_visi_type')->default(0);
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
        Schema::drop('votes');
    }
}
