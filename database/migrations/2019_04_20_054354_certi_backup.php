<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CertiBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certi_backup', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('username', 255)->nullable();
            $table->tinyInteger('index')->default(0);
            $table->integer('passcode')->unsigned()->nullable();
            $table->date('backup_date')->nullable();
        	$table->tinyInteger('level')->default(10);
        	$table->double('sum_point')->default(0);
            $table->text('booktest_success')->nulllable();
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
        Schema::drop('certi_backup');
    }
}
