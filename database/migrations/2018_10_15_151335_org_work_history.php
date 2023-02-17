<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrgworkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_work_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
        	$table->string('username', 255)->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('group_name', 255);
            $table->tinyInteger('item')->default(0);
            $table->tinyInteger('work_test')->default(0);
            $table->string('objuser_name', 350)->nullable();
            $table->string('class', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('newyear', 255)->nullable();
            $table->double('point')->nullable();
            $table->integer('pupil_numbers')->unsigned()->nullable();
            $table->integer('teacher_numbers')->unsigned()->nullable();
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
        Schema::drop('org_work_history');
    }
}
