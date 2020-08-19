<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TeacherHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->integer('group_id')->unsigned();
        	$table->string('group_name', 255)->nullable();
            $table->tinyInteger('teacher_role')->default(0);
            $table->tinyInteger('grade')->default(0);
            $table->string('class_number',255)->nullable();
            $table->integer('class_id')->unsigned()->nullable();
            $table->integer('year')->nullable();
            $table->integer('member_counts')->nullable();
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
        Schema::drop('teacher_history');
    }
}
