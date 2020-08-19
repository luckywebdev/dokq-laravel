<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportGraphBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportgraph_backup', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('backup_date');
        	$table->boolean('flag')->default(false); //0 other person 1 myself
        	$table->tinyInteger('area')->default(0); //0 クラス 1 学年 2 市内 3 県内 4 国内 
            $table->tinyInteger('period')->default(0); //0 四半期（3カ月間） 1 年度（1年間） 2 生涯
            $table->integer('persons')->default(0);
            $table->double('dq_point')->default(0);
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
        Schema::drop('reportgraph_backup');
    }
}
