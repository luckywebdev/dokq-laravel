<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wishlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       	Schema::create('wishlists', function(Blueprint $table){
       		$table->increments('id');
       		$table->integer('user_id')->unsigned();
       		$table->integer('book_id')->unsigned();
          $table->boolean('is_public')->default(false);
       		$table->timestamp('finished_date')->nullable();
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
        Schema::drop('wishlists');
    }
}
