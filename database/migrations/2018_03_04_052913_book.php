<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Book extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function(Blueprint $table){
        	$table->increments('id');
        	$table->string('title', 255);
        	$table->string('title_furi', 255);
        	$table->string('firstname_nick', 255)->nullable();
            $table->string('lastname_nick', 255)->nullable();
            $table->string('firstname_yomi', 255)->nullable();
            $table->string('lastname_yomi', 255)->nullable();
        	$table->integer('writer_id')->unsigned()->nullable();
        	$table->string('isbn', 255)->nullable();
            $table->string('url', 255)->nullable();
        	$table->text('cover_img');
            $table->date('coverimg_date')->nullable();
            $table->boolean('coverimge_check')->default(false);
        	$table->integer('recommend');
            $table->double('recommend_coefficient')->nullable();
            $table->string('publish', 255)->nullable();
        	$table->integer('max_rows');
        	$table->integer('max_chars');
        	$table->integer('pages');
        	$table->integer('entire_blanks');
        	$table->integer('quarter_filled');
        	$table->integer('half_blanks');
        	$table->integer('quarter_blanks');
        	$table->integer('p30');
        	$table->integer('p50');
        	$table->integer('p70');
        	$table->integer('p90');
        	$table->integer('p110');
        	$table->integer('total_chars')->unsigned()->nullable();
            $table->integer('recog_total_chars')->unsigned()->nullable();
        	$table->double('point');
        	$table->integer('register_visi_type');
        	$table->integer('register_id')->unsigned();
        	$table->integer('active');
        	$table->integer('quiz_status');
        	$table->enum('type', array('0','1'));
        	$table->timestamps();
        	$table->timestamp('qc_date');
        	$table->integer('quiz_count')->default(1);
            $table->integer('test_short_time')->default(0);
        	$table->integer('reason1')->nullable();
        	$table->text('reason2')->nullable();
            $table->integer('overseer_id')->unsigned()->nullable();
            $table->tinyInteger('author_overseer_flag')->default(0);
            $table->date('recommend_flag')->nullable(); //推薦図書に認定
            $table->timestamp('replied_date1');
        	$table->timestamp('replied_date2');
        	$table->timestamp('replied_date3');       	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
