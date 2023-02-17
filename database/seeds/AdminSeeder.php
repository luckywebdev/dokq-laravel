<?php

use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;

class AdminSeeder extends DatabaseSeeder {


	public function run()
	{
		$faker = Factory::create();
        $categories = array('児童書','絵本','単行本','文庫本','新書','電子書籍','青空文庫','短編','日本の文学','海外の文学','ファンタジｰ・SF','冒険','純文学','ミステリー','歴史','古典','名作','ノンフィクション・伝記','教養・学術','エッセイ・評論','大人向け');
		DB::table('users')->insert(array(
			"firstname" => "99",
			"lastname" => $faker->unique()->lastname,
			"role" => 15,
			"email" => "doqadmin@doq.jp",
			"r_password" => "99999999",
			"password" => md5("99999999"),
			"username" => "dqadmin",
			"gender" => $faker->numberBetween(0,1),
			"birthday" => $faker->dateTimeBetween('1990-01-01','1990-12-31'),
			"active" => 1,
			"created_at" => now(),
			"updated_at" => now()
		));

        foreach($categories as $category) {
            DB::table('categories')->insert(array(
                "limit" => "0",
                "name" => $category
            ));
        }

        DB::table('alert_mail')->insert(array(
                "sendmail_date" => '2018-01-01 00:00:00',
                "created_date" => '2018-01-01 00:00:00'
            ));
	}

}