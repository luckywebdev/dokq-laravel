<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReportBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_backup', function(Blueprint $table){
        	$table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('role')->default(0);
            $table->tinyInteger('type')->nullable();
            $table->date('backup_date');
        	$table->string('degree', 255)->nullable();
        	$table->double('target_percent')->default(0);
            $table->double('threemonth_point')->default(0);
            $table->double('success_point')->default(0);
            $table->double('bookregister_point')->default(0);
            $table->double('quizregister_point')->default(0);
            $table->double('all_point')->default(0);
            $table->double('remain_point')->default(0);
            $table->double('test_point')->default(0);
            $table->string('testcity_rank',255)->nulllable();
            $table->string('testprovince_rank',255)->nulllable();
            $table->string('testcountry_rank',255)->nulllable();
            $table->double('quiz_point')->default(0);
            $table->string('quizcity_rank',255)->nulllable();
            $table->string('quizprovince_rank',255)->nulllable();
            $table->string('quizcountry_rank',255)->nulllable();
            $table->double('quiz_point_before')->default(0);
            $table->string('quizcity_rank_before',255)->nulllable();
            $table->string('quizprovince_rank_before',255)->nulllable();
            $table->string('quizcountry_rank_before',255)->nulllable();
            $table->double('quiz_point_this')->default(0);
            $table->string('quizcity_rank_this',255)->nulllable();
            $table->string('quizprovince_rank_this',255)->nulllable();
            $table->string('quizcountry_rank_this',255)->nulllable();
            $table->double('quiz_point_last')->default(0);
            $table->string('quizcity_rank_last',255)->nulllable();
            $table->string('quizprovince_rank_last',255)->nulllable();
            $table->string('quizcountry_rank_last',255)->nulllable();
            $table->double('quiz_point_all')->default(0);
            $table->string('quizcity_rank_all',255)->nulllable();
            $table->string('quizprovince_rank_all',255)->nulllable();
            $table->string('quizcountry_rank_all',255)->nulllable();
            $table->text('booktest_success')->nulllable();
            $table->text('bookconfirm_success')->nulllable();
            $table->text('quizconfirm_success')->nulllable();
            $table->string('threemonth_name1',255)->nulllable();
            $table->string('threemonth_name2',255)->nulllable();
            $table->string('threemonth_name3',255)->nulllable();
            $table->string('threemonth_name4',255)->nulllable();
            $table->string('threemonth_name5',255)->nulllable();
            $table->string('threemonth_name6',255)->nulllable();
            $table->string('threemonth_name7',255)->nulllable();
            $table->string('threemonth_name8',255)->nulllable();
            $table->double('mythreemonth_point1')->default(0);
            $table->double('mythreemonth_point2')->default(0);
            $table->double('mythreemonth_point3')->default(0);
            $table->double('mythreemonth_point4')->default(0);
            $table->double('mythreemonth_point5')->default(0);
            $table->double('mythreemonth_point6')->default(0);
            $table->double('mythreemonth_point7')->default(0);
            $table->double('mythreemonth_point8')->default(0);
            $table->double('threemonth_point1')->default(0);
            $table->double('threemonth_point2')->default(0);
            $table->double('threemonth_point3')->default(0);
            $table->double('threemonth_point4')->default(0);
            $table->double('threemonth_point5')->default(0);
            $table->double('threemonth_point6')->default(0);
            $table->double('threemonth_point7')->default(0);
            $table->double('threemonth_point8')->default(0);
            $table->string('threemonth_rank1',255)->nulllable(); // 1位/13人 in graph
            $table->string('threemonth_rank2',255)->nulllable();
            $table->string('threemonth_rank3',255)->nulllable();
            $table->string('threemonth_rank4',255)->nulllable();
            $table->string('threemonth_rank5',255)->nulllable();
            $table->string('oneyear_rank1',255)->nulllable();
            $table->string('oneyear_rank2',255)->nulllable();
            $table->string('oneyear_rank3',255)->nulllable();
            $table->string('oneyear_rank4',255)->nulllable();
            $table->string('oneyear_rank5',255)->nulllable();
            $table->string('all_rank1',255)->nulllable();
            $table->string('all_rank2',255)->nulllable();
            $table->string('all_rank3',255)->nulllable();
            $table->string('all_rank4',255)->nulllable();
            $table->string('all_rank5',255)->nulllable();
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
        Schema::drop('report_backup');
    }
}
