<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonadminHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_admin_history', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned();
        	$table->string('username', 255);
            $table->tinyInteger('item')->default(0);
            $table->tinyInteger('work_test')->default(0);
            $table->integer('book_id')->unsigned()->nullable();
            $table->string('title', 255)->nullable();
            $table->string('writer', 255)->nullable();
            $table->string('bookregister_name', 255)->nullable();
            $table->text('content')->nullable();
            $table->date('period')->nullable();
            $table->integer('access_num')->unsigned()->nullable();
            $table->integer('login_num')->unsigned()->nullable();
            $table->integer('test_num')->unsigned()->nullable();
            $table->integer('success_num')->unsigned()->nullable();
            $table->integer('readybook_num')->unsigned()->nullable();
            $table->integer('successbook_num')->unsigned()->nullable();
            $table->integer('quiz_num')->unsigned()->nullable();
            $table->integer('successquiz_num')->unsigned()->nullable();
            $table->integer('org_num')->unsigned()->nullable();
            $table->integer('users_num')->unsigned()->nullable();
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
        Schema::drop('person_admin_history');
    }
}
