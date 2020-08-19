<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PupilHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pupil_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('pupil_id')->unsigned();
        	$table->string('group_name', 255)->nullable();
            $table->tinyInteger('grade')->default(0);
            $table->string('class_number',255)->nullable();
            $table->string('teacher_name',255)->nullable();
        	$table->string('class', 255)->nullable();
            $table->integer('class_id')->unsigned();
        	$table->date('created_at');
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pupil_history');
    }
}
