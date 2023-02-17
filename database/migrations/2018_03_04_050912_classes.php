<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Classes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function(Blueprint $table){
        	$table->increments('id');
        	$table->integer('type');
        	$table->tinyInteger('grade')->default(0);
        	$table->string('class_number',255)->nullable();
        	$table->integer('member_counts')->nullable();
        	$table->integer('group_id')->unsigned();
        	$table->integer('teacher_id')->unsigned()->nullable();
        	//$table->integer('vice_teacher_id')->unsigned()->nullable();
        	$table->integer('year')->nullable();
            $table->tinyInteger('active')->default(1); //1: active 2: delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classes');
    }
}
