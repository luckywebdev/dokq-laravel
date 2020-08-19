<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table){
        	$table->increments('id');
        	$table->string('group_name', 255)->nullable();
        	$table->string('group_yomi', 255)->nullable();
        	$table->string('group_roma',255)->nulllable();
        	$table->string('rep_name', 255)->nullable();
        	$table->string('rep_post', 255)->nullable();
        	$table->string('firstname', 255);
        	$table->string('firstname_yomi', 255)->nullable();
        	$table->string('firstname_roma', 255)->nullable();
        	$table->string('lastname', 255);
        	$table->string('lastname_yomi', 255)->nullable();
        	$table->string('lastname_roma', 255)->nullable();
        	$table->string('firstname_nick', 255)->nullable();
        	$table->string('firstname_nick_yomi', 255)->nullable();
        	$table->string('firstname_nick_roma', 255)->nullable();
        	$table->string('lastname_nick', 255)->nullable();
        	$table->string('lastname_nick_yomi',255)->nullable();
        	$table->string('lastname_nick_roma',255)->nullable();
        	$table->integer('gender')->default(0);
        	$table->date('birthday');
        	$table->integer('auth_type');
        	$table->string('address1', 255)->nullable();
        	$table->string('address2', 255)->nullable();
        	$table->string('address3', 255)->nullable();
        	$table->string('address4', 255)->nullable();
        	$table->string('address5', 255)->nullable();
            $table->string('address6', 255)->nullable();
            $table->string('address7', 255)->nullable();
            $table->string('address8', 255)->nullable();  
            $table->string('address9', 255)->nullable();  
            $table->string('address10', 255)->nullable();  
        	$table->string('phone', 15);
        	$table->string('teacher', 255)->nullable();
        	$table->integer('group_type')->default(0)->nullable();
        	//$table->integer('teacher_count')->default(0);
        	//$table->integer('pupil_count')->default(0);
        	$table->integer('using_purpose');
        	$table->integer('role');
        	$table->integer('active')->default(0);
        	$table->string('username', 255)->collation('utf8mb4_bin');
        	$table->string('email', 255);
        	$table->string('password', 255);
        	$table->string('r_password', 255);
        	$table->string('t_username', 255)->collation('utf8mb4_bin');
        	$table->string('t_password', 255);
        	$table->text('authfile')->nullable();
        	$table->text('file')->nullable();
            $table->date('authfile_date')->nullable();
            $table->text('certifilename')->nullable();
            $table->text('certifile')->nullable();
            $table->date('certifile_date')->nullable();
            $table->text('myprofilename')->nullable();
            $table->text('myprofile')->nullable();
            $table->date('myprofile_date')->nullable();
        	$table->integer('org_id')->unsigned();
        	$table->integer('testable');
        	$table->string('wifi', 255)->nullable();
            $table->string('ip_address', 255)->nullable();
            $table->string('ip_global_address', 255)->nullable();
            $table->string('mask', 255)->nullable();
            $table->boolean('nat_flag')->default(false);
        	$table->text('refresh_token');
        	$table->text('remember_token');
        	$table->integer('islogged')->default(0);
        	$table->string('image_path',256)->nullable();
            $table->date('imagepath_date',256)->nullable();
            $table->string('beforeimage_path',256)->nullable();
            $table->date('beforeimagepath_date',256)->nullable();
        	$table->string('scholarship',255);
        	$table->string('job',255);
        	$table->string('about',255);
            $table->text('overseerbook_list')->nullable(); //監修本 check 監修者紹介
            $table->tinyInteger('recommend_flag');
            $table->tinyInteger('verifyface_flag')->default(0);
            $table->text('recommend_content');
        	$table->boolean('fullname_is_public')->default(false);
        	$table->boolean('fullname_yomi_is_public')->default(false);
        	$table->boolean('gender_is_public')->default(false);
        	$table->boolean('birthday_is_public')->default(false);
        	$table->boolean('role_is_public')->default(false);
        	$table->boolean('address_is_public')->default(false);
            $table->boolean('address1_is_public')->default(false);
            $table->boolean('address2_is_public')->default(false);
        	$table->boolean('username_is_public')->default(false);
            $table->boolean('groupyomi_is_public')->default(false);
        	$table->boolean('org_id_is_public')->default(false);
            $table->boolean('wishlists_is_public')->default(false);
            $table->boolean('mybookcase_is_public')->default(false);
            $table->boolean('profile_is_public')->default(false);
            $table->boolean('targetpercent_is_public')->default(false);
            $table->boolean('history_all_is_public')->default(false);
            $table->boolean('last_report_is_public')->default(false);
            $table->boolean('ranking_order_is_public')->default(false);
            $table->boolean('passed_records_is_public')->default(false);
            $table->boolean('point_ranking_is_public')->default(false);
            $table->boolean('register_point_ranking_is_public')->default(false);
            $table->boolean('register_record_is_public')->default(false);
            $table->boolean('quiz_allowed_record_is_public')->default(false);
            $table->boolean('book_allowed_record_is_public')->default(false);
            $table->boolean('article_is_public')->default(true);
            $table->boolean('overseerbook_is_public')->default(false);
            $table->boolean('author_readers_is_public')->default(false);
            $table->boolean('aptitude')->default(false);
            $table->integer('passcode')->unsigned()->nullable();
            $table->integer('reload_flag')->default(0);
            $table->boolean('authfile_check')->default(false);
            $table->boolean('certifile_check')->default(false);
            $table->boolean('imagepath_check')->default(false);
            $table->boolean('namepwd_check')->default(false);
        	$table->timestamps();
        	$table->timestamp('replied_date1')->nullable();
        	$table->timestamp('replied_date2')->nullable();
        	$table->timestamp('replied_date3')->nullable();
            $table->timestamp('replied_date4')->nullable(); //適性検査合格日
            $table->timestamp('escape_date')->nullable(); //退会日
            $table->date('settlement_date')->nullable(); //読書認定書の発行有効期限
            $table->string('email_password',255)->nullable(); //送信専用パスワード
            $table->string('email1',255)->nullable(); //個別用１メールアドレス
            $table->string('email1_password',255)->nullable(); //個別用１メールパスワード
            $table->string('email2',255)->nullable(); //個別用2メールアドレス
            $table->string('email2_password',255)->nullable(); //個別用2メールアドレス
            $table->text('member_name')->nullable(); //メンバー名
            $table->date('society_settlement_date',255)->nullable(); //決算
            $table->date('period')->nullable();//現有効期限
            $table->text('memo')->nullable(); //メモ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
