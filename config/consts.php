<?php
return [
	'SIDE_MENU' => [
		'ADMIN' =>[	
			'reg_list' =>['TITLE' => '入会手続きリスト', 'LOCATION' => '/', 'ICON' => 'fa fa-home', 'CHILD' =>[
					'reg_group_list' => ['TITLE' => '入会手続き中団体リスト', 'LOCATION' => '/admin/reg_group_list', 'ICON'=> 'fa fa-home'],
					'reg_person_list' => ['TITLE' => '入会手続き中個人リスト', 'LOCATION' => '/admin/reg_person_list', 'ICON'=> 'fa fa-home'],
					'reg_overseer_list' => ['TITLE' => '監修者申請中個人リスト', 'LOCATION' => '/admin/reg_overseer_list', 'ICON'=> 'fa fa-home']
				]
			],
			'can_list' => ['TITLE' => ' 候補本', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'can_book_list' => ['TITLE' => ' 候補本リスト（未審査）', 'LOCATION' => '/admin/can_book_list', 'ICON'=> 'fa fa-home'],
					'can_book_b' => ['TITLE' => ' 監修者募集本リストと応募', 'LOCATION' => '/admin/can_book_b', 'ICON'=> 'fa fa-home'],
					'can_book_c' => ['TITLE' => '監修者決定：クイズ編集権限移譲', 'LOCATION' => '/admin/can_book_c', 'ICON'=> 'fa fa-home'],
					'can_book_d' => ['TITLE' => 'クイズ募集中の本リスト', 'LOCATION' => '/admin/can_book_d', 'ICON'=> 'fa fa-home'],
				]				
			],	
			'unsubscribe' => ['TITLE' => '退会手続き中リスト', 'LOCATION' => '/admin/unsubscribe_list', 'ICON'=> 'fa fa-home'],
			'pay_list' => ['TITLE' => '決済リスト', 'LOCATION' => '/admin/pay_list', 'ICON'=> 'fa fa-home'],
			'data_work'=>['TITLE'=>'データ選択・作業選択', 'LOCATION'=>'/','ICON'=>'fa fa-home', 'CHILD' =>[
					'data_work_sel'=>['TITLE'=>'データ選択・作業選択', 'LOCATION'=>'/admin/data_work_sel','ICON'=>'fa fa-home'],
					'advertise'=>['TITLE'=>'広告登録', 'LOCATION'=>'/admin/advertise', 'ICON'=>'fa fa-home'],
					'app_search_history'=>['TITLE'=>'ページビュー時間データ', 'LOCATION'=>'/admin/app_search_history', 'ICON'=>'fa fa-home'],
				]
			],
			'book_ranking' => ['TITLE'=>'読書量ランキング１００', 'LOCATION'=>'/admin/book_ranking', 'ICON'=>'fa fa-home'],
			'search' => ['TITLE'=>'会員検索：マイ書斎閲覧、連絡帳への個別連絡など', 'LOCATION'=>'/', 'ICON'=>'fa fa-home', 'CHILD' =>[
					'mem_search'=>['TITLE'=>'会員検索', 'LOCATION'=>'/admin/mem_search', 'ICON'=>'fa fa-home'],
					'quiz_answer'=>['TITLE'=>'お問合せ対応', 'LOCATION'=>'/admin/quiz_answer', 'ICON'=>'fa fa-home'],
				]
			],
			'admin_basic_info' => ['TITLE'=>'協会の基本情報', 'LOCATION'=>'/', 'ICON'=>'fa fa-home', 'CHILD' => [
					'basic_info'=>['TITLE'=>'協会の基本情報', 'LOCATION'=>'/admin/basic_list', 'ICON'=>'fa fa-home'],
					'notice'=>['TITLE'=>'読Qトップお知らせ追加編集', 'LOCATION'=>'/admin/notice', 'ICON'=>'fa fa-home'],
					'book_credit'=>['TITLE'=>'読書認定書ストック', 'LOCATION'=>'/admin/book_credit', 'ICON'=>'fa fa-home'],			
				]
			],
		],
		'GROUP' =>[
			'group_top' => ['TITLE' => '団体トップページ', 'LOCATION' => '/top', 'ICON'=> 'fa fa-home'],
			'basic_info' => ['TITLE' => '団体の基本情報閲覧編集', 'LOCATION' => '/group/basic_info', 'ICON'=> 'fa fa-home'],
			'teacher_set' => ['TITLE' => '教員・クラス設定', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'search' => ['TITLE' => '団体教員・司書の検索と新規登録', 'LOCATION' => '/group/search_teacher', 'ICON' => 'fa fa-home'],
					'teacher_list' => ['TITLE' => '団体教職員名簿', 'LOCATION' => '/group/teacher/list', 'ICON' => 'fa fa-home'],
					'reg_class' => ['TITLE' => '担任登録', 'LOCATION' => '/group/teacher/reg_class', 'ICON' => 'fa fa-home'],
					'edit_class' => ['TITLE' => '担任の編集・削除', 'LOCATION' => '/group/teacher/edit_class', 'ICON' => 'fa fa-home'],
				]
			],
			'group_manual' => ['TITLE' => '団体マニュアル', 'LOCATION' => '/group/manual', 'ICON'=> 'fa fa-home'],
			'edit_teacher_top' => ['TITLE' => '教師トップページの編集', 'LOCATION' => '/group/edit_teacher_top', 'ICON'=> 'fa fa-home'],
			'rank' => ['TITLE' => '団体の読書量', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD'=>[
					'class_rank' => ['TITLE' => 'クラス対抗読書量順位', 'LOCATION' => '/group/rank/1', 'ICON'=> 'fa fa-home'],
					'school_rank' => ['TITLE' => '学年単位 全国順位', 'LOCATION' => '/group/rank/2', 'ICON'=> 'fa fa-home'],
					'country_rank' => ['TITLE' => '学校対抗 全国順位', 'LOCATION' => '/group/rank/3', 'ICON'=> 'fa fa-home'],
					'before_best' => ['TITLE' => '昨年度全国トップ校', 'LOCATION' => '/group/rank/4', 'ICON'=> 'fa fa-home'],
					'2before_best' => ['TITLE' => '一昨年度全国トップ校', 'LOCATION' => '/group/rank/5', 'ICON'=> 'fa fa-home'],
					'recent_best' => ['TITLE' => '全国トップ校過去5年', 'LOCATION' => '/group/rank/6', 'ICON'=> 'fa fa-home'],
				],
			],
		],
		'TEACHER' =>[
			'teacher_top' => ['TITLE' => '教師TOP学級を選択', 'LOCATION' => '/top', 'ICON'=> 'fa fa-home'],
			'class_activity' => ['TITLE' => 'クラス内の読書量', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'activity' => ['TITLE' => 'クラス内最近の読Q活動', 'LOCATION' => '/class/rank/5', 'ICON'=> 'fa fa-home'],
					'current_rank' => ['TITLE' => 'クラス内今期順位', 'LOCATION' => '/class/rank/1', 'ICON'=> 'fa fa-home'],
					'last_rank' => ['TITLE' => 'クラス内前回順位', 'LOCATION' => '/class/rank/2', 'ICON'=> 'fa fa-home'],
					'year_rank' => ['TITLE' => 'クラス内今年度通算ポイント順位', 'LOCATION' => '/class/rank/3', 'ICON'=> 'fa fa-home'],
					'total_rank' => ['TITLE' => 'クラス内生涯ポイント順位', 'LOCATION' => '/class/rank/4', 'ICON'=> 'fa fa-home']
				]
			],
			'search_pupil' => ['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'ICON'=> 'fa fa-home'],
			'pupil_info' => ['TITLE' => '児童生徒 基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil', 'ICON'=> 'fa fa-home'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C', 'ICON'=> 'fa fa-home'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D', 'ICON'=> 'fa fa-home']
			]],
			'class_list' => ['TITLE' => 'クラス名簿(一括作業用)', 'LOCATION' => '/teacher/class_list', 'ICON'=> 'fa fa-home'],
			'password_history' => ['TITLE' => '受検する児童への試験監督パスワード送信履歴', 'LOCATION' => '/teacher/pwd_history', 'ICON'=> 'fa fa-home'],
			'send_notify' => ['TITLE' => '児童生徒へのお知らせ入力', 'LOCATION' => '/teacher/send_notify', 'ICON'=> 'fa fa-home'],
			// 'cancel_pass' => ['TITLE' => '合格記録の取り消し', 'LOCATION' => '/teacher/cancel_pass', 'ICON'=> 'fa fa-home'],
			'cancel_pass' => ['TITLE' => '合格記録の取り消し', 'LOCATION' => '/class/search_pupil', 'ICON'=> 'fa fa-home'],
			'group_manual' => ['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'ICON'=> 'fa fa-home'],
		],
		'REPRESEN' =>[
			'teacher_top' => ['TITLE' => '教師TOP学級を選択', 'LOCATION' => '/top', 'ICON'=> 'fa fa-home'],
			'basic_info' => ['TITLE' => '団体の基本情報閲覧編集', 'LOCATION' => '/group/basic_info', 'ICON'=> 'fa fa-home'],
			'class_activity' => ['TITLE' => 'クラス内の読書量', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'activity' => ['TITLE' => 'クラス内最近の読Q活動', 'LOCATION' => '/class/rank/5', 'ICON'=> 'fa fa-home'],
					'current_rank' => ['TITLE' => 'クラス内今期順位', 'LOCATION' => '/class/rank/1', 'ICON'=> 'fa fa-home'],
					'last_rank' => ['TITLE' => 'クラス内前回順位', 'LOCATION' => '/class/rank/2', 'ICON'=> 'fa fa-home'],
					'year_rank' => ['TITLE' => 'クラス内今年度通算ポイント順位', 'LOCATION' => '/class/rank/3', 'ICON'=> 'fa fa-home'],
					'total_rank' => ['TITLE' => 'クラス内生涯ポイント順位', 'LOCATION' => '/class/rank/4', 'ICON'=> 'fa fa-home']
				]
			],
			'search_pupil' => ['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'ICON'=> 'fa fa-home'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil', 'ICON'=> 'fa fa-home'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C', 'ICON'=> 'fa fa-home'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D', 'ICON'=> 'fa fa-home']
			]],
			'class_list' => ['TITLE' => 'クラス名簿(一括作業用)', 'LOCATION' => '/teacher/class_list', 'ICON'=> 'fa fa-home'],
			'password_history' => ['TITLE' => '受検する児童への試験監督パスワード送信履歴', 'LOCATION' => '/teacher/pwd_history', 'ICON'=> 'fa fa-home'],
			'send_notify' => ['TITLE' => '児童生徒へのお知らせ入力', 'LOCATION' => '/teacher/send_notify', 'ICON'=> 'fa fa-home'],
			'cancel_pass' => ['TITLE' => '合格記録の取り消し', 'LOCATION' => '/teacher/cancel_pass', 'ICON'=> 'fa fa-home'],
			
			'group_manual' => ['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'ICON'=> 'fa fa-home'],
		],
		'ITMANAGER' =>[
			'teacher_top' => ['TITLE' => '教師TOP学級を選択', 'LOCATION' => '/top', 'ICON'=> 'fa fa-home'],
			'basic_info' => ['TITLE' => '団体の基本情報閲覧編集', 'LOCATION' => '/group/basic_info', 'ICON'=> 'fa fa-home'],
			'class_activity' => ['TITLE' => 'クラス内の読書量', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'activity' => ['TITLE' => 'クラス内最近の読Q活動', 'LOCATION' => '/class/rank/5', 'ICON'=> 'fa fa-home'],
					'current_rank' => ['TITLE' => 'クラス内今期順位', 'LOCATION' => '/class/rank/1', 'ICON'=> 'fa fa-home'],
					'last_rank' => ['TITLE' => 'クラス内前回順位', 'LOCATION' => '/class/rank/2', 'ICON'=> 'fa fa-home'],
					'year_rank' => ['TITLE' => 'クラス内今年度通算ポイント順位', 'LOCATION' => '/class/rank/3', 'ICON'=> 'fa fa-home'],
					'total_rank' => ['TITLE' => 'クラス内生涯ポイント順位', 'LOCATION' => '/class/rank/4', 'ICON'=> 'fa fa-home']
				]
			],
			'search_pupil' => ['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'ICON'=> 'fa fa-home'],
			'pupil_info' => ['TITLE' => '児童生徒 基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil', 'ICON'=> 'fa fa-home'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C', 'ICON'=> 'fa fa-home'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D', 'ICON'=> 'fa fa-home']
			]],
			'class_list' => ['TITLE' => 'クラス名簿(一括作業用)', 'LOCATION' => '/teacher/class_list', 'ICON'=> 'fa fa-home'],
			'password_history' => ['TITLE' => '受検する児童への試験監督パスワード送信履歴', 'LOCATION' => '/teacher/pwd_history', 'ICON'=> 'fa fa-home'],
			'send_notify' => ['TITLE' => '児童生徒へのお知らせ入力', 'LOCATION' => '/teacher/send_notify', 'ICON'=> 'fa fa-home'],
			'cancel_pass' => ['TITLE' => '合格記録の取り消し', 'LOCATION' => '/teacher/cancel_pass', 'ICON'=> 'fa fa-home'],
			
			'group_manual' => ['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'ICON'=> 'fa fa-home'],
		],
		'OTHER' =>[
			'teacher_top' => ['TITLE' => '教師TOP　学級を選択', 'LOCATION' => '/top', 'ICON'=> 'fa fa-home'],
			'class_activity' => ['TITLE' => 'クラス内の読書量', 'LOCATION' => '/', 'ICON'=> 'fa fa-home', 'CHILD' => [
					'activity' => ['TITLE' => 'クラス内最近の読Q活動', 'LOCATION' => '/class/rank/5', 'ICON'=> 'fa fa-home'],
					'current_rank' => ['TITLE' => 'クラス内今期順位', 'LOCATION' => '/class/rank/1', 'ICON'=> 'fa fa-home'],
					'last_rank' => ['TITLE' => 'クラス内前回順位', 'LOCATION' => '/class/rank/2', 'ICON'=> 'fa fa-home'],
					'year_rank' => ['TITLE' => 'クラス内今年度通算ポイント順位', 'LOCATION' => '/class/rank/3', 'ICON'=> 'fa fa-home'],
					'total_rank' => ['TITLE' => 'クラス内生涯ポイント順位', 'LOCATION' => '/class/rank/4', 'ICON'=> 'fa fa-home']
				]
			],
			'search_pupil' => ['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'ICON'=> 'fa fa-home'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil', 'ICON'=> 'fa fa-home'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C', 'ICON'=> 'fa fa-home'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D', 'ICON'=> 'fa fa-home']
			]],
			'class_list' => ['TITLE' => 'クラス名簿(一括作業用)', 'LOCATION' => '/teacher/class_list', 'ICON'=> 'fa fa-home'],
			'password_history' => ['TITLE' => '受検する児童への試験監督パスワード送信履歴', 'LOCATION' => '/teacher/pwd_history', 'ICON'=> 'fa fa-home'],
			'send_notify' => ['TITLE' => '児童生徒へのお知らせ入力', 'LOCATION' => '/teacher/send_notify', 'ICON'=> 'fa fa-home'],
			'cancel_pass' => ['TITLE' => '合格記録の取り消し', 'LOCATION' => '/teacher/cancel_pass', 'ICON'=> 'fa fa-home'],
			
			'group_manual' => ['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'ICON'=> 'fa fa-home'],
		],
		'MYPAGE_GENERAL' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
				'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home']
			]],
			
			'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
			'wish_list' => ['TITLE' => '読みたい本リスト', 'LOCATION' => '/mypage/wish_list', 'ICON'=> 'fa fa-home'],
			'category' => ['TITLE' => 'マイ本棚', 'LOCATION' => '/mypage/category', 'ICON'=> 'fa fa-home'],
			
			'rank_child' => ['TITLE' => '順位', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'rank_by_age' => ['TITLE' => '読Ｑポイント順位', 'LOCATION' => '/mypage/rank_by_age', 'ICON'=> 'fa fa-home'],
				'rank_graph' => ['TITLE' => '順位グラフ', 'LOCATION' => '/mypage/rank_graph', 'ICON'=> 'fa fa-home'],
				'rank_bq' => ['TITLE' => '読書推進活動ランキング', 'LOCATION' => '/mypage/rank_bq', 'ICON'=> 'fa fa-home']
			]],
			'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
				'pass_history' => ['TITLE' => '読Q合格履歴', 'LOCATION' => '/mypage/pass_history', 'ICON'=> 'fa fa-home'],
				'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
				'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
				'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
				'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home'],
				'article_history' => ['TITLE' => '帯文投稿履歴', 'LOCATION' => '/mypage/article_history', 'ICON'=> 'fa fa-home']
			]],
			'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
				'other_view_info' => ['TITLE' => '他人から見た基本情報', 'LOCATION' => '/mypage/other_view_info', 'ICON'=> 'fa fa-home'],
				'become_overseer' => ['TITLE' => '監修者になる', 'LOCATION' => '/mypage/become_overseer', 'ICON'=> 'fa fa-home'],
				'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
			]],
			'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/payment', 'ICON'=> 'fa fa-home'],
			'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '/mypage/create_certi', 'ICON'=> 'fa fa-home'],
				'sample_certi' => ['TITLE' => '読書認定書見本', 'LOCATION' => '/mypage/sample_certi', 'ICON'=> 'fa fa-home']
			]],
			'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
				//'test_overseer' => ['TITLE' => '試験監督適性検査', 'LOCATION' => '/mypage/test_overseer', 'ICON'=> 'fa fa-home'],
				'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
			]]
		],
		'MYPAGE_PUPIL' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
				'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home'],
				'pupil_history' => ['TITLE' => '児童生徒履歴', 'LOCATION' => '/mypage/pupil_history', 'ICON'=> 'fa fa-home']
			]],
			
			'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
			'wish_list' => ['TITLE' => '読みたい本リスト', 'LOCATION' => '/mypage/wish_list', 'ICON'=> 'fa fa-home'],
			'category' => ['TITLE' => 'マイ本棚', 'LOCATION' => '/mypage/category', 'ICON'=> 'fa fa-home'],
			'rank_child' => ['TITLE' => '順位 (児童・生徒）', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'rank_child' => ['TITLE' => '順位 (児童・生徒）', 'LOCATION' => '/mypage/rank_child_pupil', 'ICON'=> 'fa fa-home'],
				'rank_graph' => ['TITLE' => '順位グラフ', 'LOCATION' => '/mypage/rank_graph', 'ICON'=> 'fa fa-home'],
				'rank_bq' => ['TITLE' => '読書推進活動ランキング', 'LOCATION' => '/mypage/rank_bq_child', 'ICON'=> 'fa fa-home']
			]],
			'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
				'pass_history' => ['TITLE' => '読Q合格履歴', 'LOCATION' => '/mypage/pass_history', 'ICON'=> 'fa fa-home'],
				'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
				'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
				'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
				'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home'],
				'article_history' => ['TITLE' => '帯文投稿履歴', 'LOCATION' => '/mypage/article_history', 'ICON'=> 'fa fa-home']
			]],
			'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
				'other_view_info' => ['TITLE' => '他人から見た基本情報', 'LOCATION' => '/mypage/other_view_info', 'ICON'=> 'fa fa-home'],
				//'become_overseer' => ['TITLE' => '監修者になる', 'LOCATION' => '/mypage/become_overseer', 'ICON'=> 'fa fa-home'],
				'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
			]],
			'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/payment', 'ICON'=> 'fa fa-home'],
			//'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/face_verify/1', 'ICON'=> 'fa fa-home'],
			'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '/mypage/create_certi', 'ICON'=> 'fa fa-home'],
				'sample_certi' => ['TITLE' => '読書認定書見本', 'LOCATION' => '/mypage/sample_certi', 'ICON'=> 'fa fa-home']
			]],
			'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
				//'test_overseer' => ['TITLE' => '試験監督適性検査', 'LOCATION' => '/mypage/test_overseer', 'ICON'=> 'fa fa-home'],
				'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
			]]
		],
		'MYPAGE_ASSISSTANT_PUPIL' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
				'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home'],
				'pupil_history' => ['TITLE' => '児童生徒履歴', 'LOCATION' => '/mypage/pupil_history', 'ICON'=> 'fa fa-home']
			]],
			
			'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
			'wish_list' => ['TITLE' => '読みたい本リスト', 'LOCATION' => '/mypage/wish_list', 'ICON'=> 'fa fa-home'],
			'category' => ['TITLE' => 'マイ本棚', 'LOCATION' => '/mypage/category', 'ICON'=> 'fa fa-home'],
			'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
				'pass_history' => ['TITLE' => '読Q合格記録', 'LOCATION' => '/mypage/pass_history', 'ICON'=> 'fa fa-home'],
				'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
				'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
				'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
				'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home'],
				'article_history' => ['TITLE' => '帯文投稿履歴', 'LOCATION' => '/mypage/article_history', 'ICON'=> 'fa fa-home']
			]],
			'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
				'other_view_info' => ['TITLE' => '他人から見た基本情報', 'LOCATION' => '/mypage/other_view_info', 'ICON'=> 'fa fa-home'],
				//'become_overseer' => ['TITLE' => '監修者になる', 'LOCATION' => '/mypage/become_overseer', 'ICON'=> 'fa fa-home'],
				'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
			]],
			'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/payment', 'ICON'=> 'fa fa-home'],
			'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '/mypage/create_certi', 'ICON'=> 'fa fa-home'],
				'sample_certi' => ['TITLE' => '読書認定書見本', 'LOCATION' => '/mypage/sample_certi', 'ICON'=> 'fa fa-home']
			]],
			'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
				//'test_overseer' => ['TITLE' => '試験監督適性検査', 'LOCATION' => '/mypage/test_overseer', 'ICON'=> 'fa fa-home'],
				'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
			]]
		],
		'MYPAGE_AUTHOR' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
				'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home'],
				'mybook_list' => ['TITLE' => '自著リスト', 'LOCATION' => '/mypage/mybooklist', 'ICON'=> 'fa fa-home'],
				'bid_history' => ['TITLE' => '監修応募履歴', 'LOCATION' => '/mypage/bid_history', 'ICON'=> 'fa fa-home'],
				'overseer_books' => ['TITLE' => '監修した本一覧', 'LOCATION' => '/mypage/overseer_books', 'ICON'=> 'fa fa-home'],
				'my_profile' => ['TITLE' => '監修者プロフィール', 'LOCATION' => '/mypage/my_profile', 'ICON'=> 'fa fa-home']
			]],
			
			'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
			'wish_list' => ['TITLE' => '読みたい本リスト', 'LOCATION' => '/mypage/wish_list', 'ICON'=> 'fa fa-home'],
			'category' => ['TITLE' => 'マイ本棚', 'LOCATION' => '/mypage/category', 'ICON'=> 'fa fa-home'],
			'rank_child' => ['TITLE' => '順位', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'rank_by_age' => ['TITLE' => '読Ｑポイント順位', 'LOCATION' => '/mypage/rank_by_age', 'ICON'=> 'fa fa-home'],
				'rank_graph' => ['TITLE' => '順位グラフ', 'LOCATION' => '/mypage/rank_graph', 'ICON'=> 'fa fa-home'],
				'rank_bq' => ['TITLE' => '読書推進活動ランキング', 'LOCATION' => '/mypage/rank_bq', 'ICON'=> 'fa fa-home']
			]],
			'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
				'pass_history' => ['TITLE' => '読Q合格履歴', 'LOCATION' => '/mypage/pass_history', 'ICON'=> 'fa fa-home'],
				'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
				'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
				'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
				'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home']
			]],
			'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
				'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
			]],
			'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/payment', 'ICON'=> 'fa fa-home'],
			'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '/mypage/create_certi', 'ICON'=> 'fa fa-home'],
				'sample_certi' => ['TITLE' => '読書認定書見本', 'LOCATION' => '/mypage/sample_certi', 'ICON'=> 'fa fa-home'],
				//'ok_certi' => ['TITLE' => '読書認定書決済', 'LOCATION' => '/mypage/ok_certi', 'ICON'=> 'fa fa-home']
			]],
			'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
				'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
			]]
		],
		'MYPAGE_OVERSEER' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
				'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home'],
				'bid_history' => ['TITLE' => '監修応募履歴', 'LOCATION' => '/mypage/bid_history', 'ICON'=> 'fa fa-home'],
				'overseer_books' => ['TITLE' => '監修した本一覧', 'LOCATION' => '/mypage/overseer_books', 'ICON'=> 'fa fa-home'],
				'my_profile' => ['TITLE' => '監修者プロフィール', 'LOCATION' => '/mypage/my_profile', 'ICON'=> 'fa fa-home']
			]],
			
			'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
			'wish_list' => ['TITLE' => '読みたい本リスト', 'LOCATION' => '/mypage/wish_list', 'ICON'=> 'fa fa-home'],
			'category' => ['TITLE' => 'マイ本棚', 'LOCATION' => '/mypage/category', 'ICON'=> 'fa fa-home'],
			'rank_child' => ['TITLE' => '順位', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'rank_by_age' => ['TITLE' => '読Ｑポイント順位', 'LOCATION' => '/mypage/rank_by_age', 'ICON'=> 'fa fa-home'],
				'rank_graph' => ['TITLE' => '順位グラフ', 'LOCATION' => '/mypage/rank_graph', 'ICON'=> 'fa fa-home'],
				'rank_bq' => ['TITLE' => '読書推進活動ランキング', 'LOCATION' => '/mypage/rank_bq', 'ICON'=> 'fa fa-home']
			]],
			'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
				'pass_history' => ['TITLE' => '読Q合格履歴', 'LOCATION' => '/mypage/pass_history', 'ICON'=> 'fa fa-home'],
				'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
				'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
				'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
				'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home']
			]],
			'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
				'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
			]],
			'payment' => ['TITLE' => '支払い', 'LOCATION' => '/mypage/payment', 'ICON'=> 'fa fa-home'],
			'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'create_certi' => ['TITLE' => '読書認定書の発行', 'LOCATION' => '/mypage/create_certi', 'ICON'=> 'fa fa-home'],
				'sample_certi' => ['TITLE' => '読書認定書見本', 'LOCATION' => '/mypage/sample_certi', 'ICON'=> 'fa fa-home'],
				//'ok_certi' => ['TITLE' => '読書認定書決済', 'LOCATION' => '/mypage/ok_certi', 'ICON'=> 'fa fa-home']
			]],
			'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
				'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
			]]
		],
        'MYPAGE_TEACHER' =>[
            'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
                'top' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'ICON'=> 'fa fa-home'],
                'other_view' => ['TITLE' => '他人から見たマイ書斎', 'LOCATION' => '/mypage/other_view', 'ICON'=> 'fa fa-home'],
                'bid_history' => ['TITLE' => '監修応募履歴', 'LOCATION' => '/mypage/bid_history', 'ICON'=> 'fa fa-home'],
                'overseer_books' => ['TITLE' => '監修した本一覧', 'LOCATION' => '/mypage/overseer_books', 'ICON'=> 'fa fa-home'],
                'my_profile' => ['TITLE' => '監修者プロフィール', 'LOCATION' => '/mypage/my_profile', 'ICON'=> 'fa fa-home']
            ]],
            
            'site_notify' => ['TITLE' => '読Qからの連絡帳', 'LOCATION' => '/mypage/site_notify', 'ICON'=> 'fa fa-home'],
            
            'site_history' => ['TITLE' => '読Q活動の履歴', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
                'history_all' => ['TITLE' => '読Q活動の全履歴', 'LOCATION' => '/mypage/history_all', 'ICON'=> 'fa fa-home'],
                'quiz_history' => ['TITLE' => '作成クイズの認定記録', 'LOCATION' => '/mypage/quiz_history', 'ICON'=> 'fa fa-home'],
                'book_reg_history' => ['TITLE' => '本の登録認定記録', 'LOCATION' => '/mypage/book_reg_history', 'ICON'=> 'fa fa-home'],
                'recent_report' => ['TITLE' => '読Qレポート', 'LOCATION' => '/mypage/recent_report', 'ICON'=> 'fa fa-home'],
                'last_report' => ['TITLE' => '読Qレポートバックナンバー', 'LOCATION' => '/mypage/last_report', 'ICON'=> 'fa fa-home']
            ]],
            'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
                'main_info' => ['TITLE' => '基本情報', 'LOCATION' => '/mypage/main_info', 'ICON'=> 'fa fa-home'],
                'escape_group' => ['TITLE' => '退会', 'LOCATION' => '/mypage/escape_group', 'ICON'=> 'fa fa-home']
            ]],
            'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
                'oversee_test' => ['TITLE' => '試験監督をする', 'LOCATION' => '/mypage/oversee_test', 'ICON'=> 'fa fa-home'],
                'history_oversee' => ['TITLE' => '試験監督履歴', 'LOCATION' => '/mypage/history_oversee', 'ICON'=> 'fa fa-home']
            ]]
        ],
		'ABOUT' => [
			'about' => ['TITLE' => '読Qとは', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'about_site' => ['TITLE' => '読Qの特長', 'LOCATION' => '/about_site', 'ICON'=> 'fa fa-home'],
				'about_score' => ['TITLE' => '読Qの使い方', 'LOCATION' => '/about_score', 'ICON'=> 'fa fa-home'],
				'about_target' => ['TITLE' => 'ポイントの仕組みと取得目標', 'LOCATION' => '/about_target', 'ICON'=> 'fa fa-home'],
				'about_overseer' => ['TITLE' => '監修者紹介', 'LOCATION' => '/about_overseer', 'ICON'=> 'fa fa-home'],
				'about_test' => ['TITLE' => '受検問題サンプル', 'LOCATION' => '/about_test', 'ICON'=> 'fa fa-home'],
				'about_recog' => ['TITLE' => '顔認証について', 'LOCATION' => '/about_recog', 'ICON'=> 'fa fa-home'],
				'about_sitemap' => ['TITLE' => 'サイトマップ', 'LOCATION' => '/about_sitemap', 'ICON'=> 'fa fa-home'],
				'outline' => ['TITLE' => '法人概要', 'LOCATION' => '/outline', 'ICON'=> 'fa fa-home'],
				'agreement' => ['TITLE' => '会員種類の説明と利用規約', 'LOCATION' => '/agreement', 'ICON'=> 'fa fa-home'],
				'about_pay' => ['TITLE' => '会費・料金について', 'LOCATION' => '/about_pay', 'ICON'=> 'fa fa-home'],
				'security' => ['TITLE' => '個人情報保護方針', 'LOCATION' => '/security', 'ICON'=> 'fa fa-home'],
				'ask' => ['TITLE' => 'お問合せ', 'LOCATION' => '/ask', 'ICON'=> 'fa fa-home'],
				'faq' => ['TITLE' => 'FAQ', 'LOCATION' => '/faq', 'ICON'=> 'fa fa-home']
			]],
			'pdf'  => ['TITLE' => 'pdf', 'LOCATION' => '', 'ICON'=> 'fa fa-home', 'CHILD' => [
				'group' => ['TITLE' => '団体会員についての説明と申し込みの流れ（PDF)', 'LOCATION' => '/auth/viewpdf?role=100&helpdoc=/manual/group.pdf', 'ICON'=> 'fa fa-home'],
				'individual' => ['TITLE' => '個人会員についての説明と申し込みの流れ（PDF)', 'LOCATION' => '/auth/viewpdf?role=100&helpdoc=/manual/user.pdf', 'ICON'=> 'fa fa-home'],
				'overseer' => ['TITLE' => '監修者会員についての説明と申し込みの流れ（PDF)', 'LOCATION' => '/auth/viewpdf?role=100&helpdoc=/manual/overseer.pdf', 'ICON'=> 'fa fa-home'],
				'author' => ['TITLE' => '著者会員についての説明と申し込みの流れ（PDF)', 'LOCATION' => '/auth/viewpdf?role=100&helpdoc=/manual/author.pdf', 'ICON'=> 'fa fa-home']
			]]
		]
	],
	'TOP_MENU' => [
        'ADMIN' =>[
        	'admin_top' =>['TITLE' => '協会トップ', 'LOCATION' => '/top', 'ICON' => 'fa fa-home'],		
        	'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
            'search_book' => ['TITLE' => '本の検索', 'LOCATION' => '/book/search', 'READING' => 'けんさく'],
            'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => 'つく&nbsp;&nbsp;&nbsp;'],
            'test_book' => ['TITLE' => '受検', 'LOCATION' => '/book/search', 'READING' => 'じゅけん'],
        ],
		'GROUP' => [
			'rank'=> ['TITLE' => '団体の読書量', 'LOCATION' => '/', 'READING' => '&nbsp;', 'CHILD' => [
				'class_rank' => ['TITLE' => 'クラス対抗読書量順位', 'LOCATION' => '/group/rank/1'],
				'school_rank' => ['TITLE' => '学年単位 全国順位', 'LOCATION' => '/group/rank/2'],
				'country_rank' => ['TITLE' => '学校対抗 全国順位', 'LOCATION' => '/group/rank/3'],
				'before_best' => ['TITLE' => '昨年度全国トップ校', 'LOCATION' => '/group/rank/4'],
				'2before_best' => ['TITLE' => '一昨年度全国トップ校', 'LOCATION' => '/group/rank/5'],
				'recent_best' => ['TITLE' => '全国トップ校 過去5年', 'LOCATION' => '/group/rank/6'],
			]],
			'teacher_set' => ['TITLE' => '教員・クラス設定', 'LOCATION' => '/', 'READING' => '&nbsp;', 'CHILD' => [
				'search' => ['TITLE' => '団体教員・司書の検索と新規登録', 'LOCATION' => '/group/search_teacher'],
				'teacher_list' => ['TITLE' => '団体教職員名簿', 'LOCATION' => '/group/teacher/list'],
				'teacher_power_edit' => ['TITLE' => '教員カードによる権限編集', 'LOCATION' => '/group/search_teacher'],
				'reg_class' => ['TITLE' => '担任登録', 'LOCATION' => '/group/teacher/reg_class'],
				'edit_class' => ['TITLE' => '担任の編集・削除', 'LOCATION' => '/group/teacher/edit_class'],
			]],
			'search_pupil'=>['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'READING' => '&nbsp;'],
			'group_manual'=>['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'READING' => '&nbsp;']
		],
		'TEACHER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'READING' => '&nbsp;', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D']
			]],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'ASSISTANT_TEACHER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'LIBRARIAN' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'REPRESEN' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'READING' => '&nbsp;', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D']
			]],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'ASSISTANT_REPRESEN' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'ITMANAGER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'READING' => '&nbsp;', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D']
			]],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'ASSISTANT_ITMANAGER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'OTHER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'pupil_info' => ['TITLE' => '児童生徒基本情報', 'LOCATION' => '', 'READING' => '&nbsp;', 'CHILD' => [
				'reg_pupil' => ['TITLE' => '児童生徒基本情報新規登録', 'LOCATION' => '/teacher/reg_pupil'],
				'edit_pupil' => ['TITLE' => '児童生徒の基本情報編集', 'LOCATION' => '/class/search_pupil?mode=C'],
				'del_pupil' => ['TITLE' => '児童生徒基本情報削除', 'LOCATION' => '/class/search_pupil?mode=D']
			]],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'ASSISTANT_OTHER' => [
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '読Q本の検索', 'LOCATION' => '/book/search', 'READING' => '&nbsp;'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => '&nbsp;']
		],
		'SECONDHEADER' => [
			'class_activity' => ['TITLE' => 'クラス内の読書量', 'LOCATION' => '/', 'READING' => '&nbsp;', 'CHILD' => [
					'activity' => ['TITLE' => 'クラス内最近の読Q活動', 'LOCATION' => '/class/rank/5'],
					'current_rank' => ['TITLE' => 'クラス内今期順位', 'LOCATION' => '/class/rank/1'],
					'last_rank' => ['TITLE' => 'クラス内前回順位', 'LOCATION' => '/class/rank/2'],
					'year_rank' => ['TITLE' => 'クラス内今年度通算ポイント順位', 'LOCATION' => '/class/rank/3'],
					'total_rank' => ['TITLE' => 'クラス内生涯ポイント順位', 'LOCATION' => '/class/rank/4']
				]
			],
			'rank'=> ['TITLE' => '団体の読書量', 'LOCATION' => '/', 'READING' => '&nbsp;', 'CHILD' => [
				'class_rank' => ['TITLE' => 'クラス対抗読書量順位', 'LOCATION' => '/group/rank/1'],
				'school_rank' => ['TITLE' => '学年単位全国順位', 'LOCATION' => '/group/rank/2'],
				'country_rank' => ['TITLE' => '学校対抗全国順位', 'LOCATION' => '/group/rank/3'],
				'before_best' => ['TITLE' => '昨年度全国トップ校', 'LOCATION' => '/group/rank/4'],
				'2before_best' => ['TITLE' => '一昨年度全国トップ校', 'LOCATION' => '/group/rank/5'],
				'recent_best' => ['TITLE' => '全国トップ校過去5年', 'LOCATION' => '/group/rank/6'],
			]],
			'class_list'=>['TITLE' => '試験監督・一括操作', 'LOCATION' => '/teacher/class_list', 'READING' => '&nbsp;'],
			'search_pupil'=>['TITLE' => '児童生徒検索', 'LOCATION' => '/class/search_pupil', 'READING' => '&nbsp;'],
			'group_manual'=>['TITLE' => '団体マニュアルを見る', 'LOCATION' => '/group/manual', 'READING' => '&nbsp;'],
		],
		'BEFORE' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/auth/login', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '本の検索', 'LOCATION' => '/book/search', 'READING' => 'けんさく'],
            'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/auth/login', 'READING' => 'つく&nbsp;&nbsp;&nbsp;'],
			'test_book' => ['TITLE' => '受検', 'LOCATION' => '/auth/login', 'READING' => 'じゅけん'],
		],
		'COMMON' =>[
			'mypage' => ['TITLE' => 'マイ書斎', 'LOCATION' => '/mypage/top', 'READING' => '&nbsp;'],
			'search_book' => ['TITLE' => '本の検索', 'LOCATION' => '/book/search', 'READING' => 'けんさく'],
			'quiz_make' => ['TITLE' => 'クイズを作る', 'LOCATION' => '/book/search', 'READING' => 'つく&nbsp;&nbsp;&nbsp;'],
            'test_book' => ['TITLE' => '受検', 'LOCATION' => '/book/search', 'READING' => 'じゅけん'],
		],
		'HELP' =>[
			'about' => ['TITLE' => '読Qとは', 'LOCATION' => '/', 'READING' => '&nbsp;', 'CHILD' => [
				'about_site' => ['TITLE' => '読Qの特長', 'LOCATION' => '/about_site'],
				'about_score' => ['TITLE' => '読Qの使い方', 'LOCATION' => '/about_score'],
				'about_target' => ['TITLE' => 'ポイントの仕組みと取得目標', 'LOCATION' => '/about_target'],
				'about_overseer' => ['TITLE' => '監修者紹介', 'LOCATION' => '/about_overseer'],
				'about_test' => ['TITLE' => '受検問題サンプル', 'LOCATION' => '/about_test'],
				'about_recog' => ['TITLE' => '顔認証について', 'LOCATION' => '/about_recog'],
				'about_sitemap' => ['TITLE' => 'サイトマップ', 'LOCATION' => '/about_sitemap'],
				'outline' => ['TITLE' => '法人概要', 'LOCATION' => '/outline'],
				'agreement' => ['TITLE' => '会員種類の説明と利用規約', 'LOCATION' => '/agreement'],
				'about_pay' => ['TITLE' => '会費・料金について', 'LOCATION' => '/about_pay'],
				'security' => ['TITLE' => '個人情報保護方針', 'LOCATION' => '/security'],
				'ask' => ['TITLE' => 'お問合せ', 'LOCATION' => '/ask'],
				'faq' => ['TITLE' => 'FAQ', 'LOCATION' => '/faq']
			]],
		]
	],
	'USER' => [
        'ROLE' => [
            "GROUP" 	=> 0, //団体
            "GENERAL" 	=> 1, //一般
            "OVERSEER" 	=> 2, //監修者
            "AUTHOR" 	=> 3, //著者
            "TEACHER"	=> 4,
            "LIBRARIAN" => 5,
            "REPRESEN"	=> 6, //代表（校長、教頭等）
            "ITMANAGER"	=> 7, //IT担当者
            "OTHER"		=> 8, //その他
            "PUPIL"		=> 9,
            "ADMIN"		=> 15  //協会
        ],
		'GENDER' => [
			'無', '女','男'
		],
		'AUTH_TYPE' => [
			[ 'TITLE' => '本人確認書類の種類', 'CONTENT' => ['運転免許証','マイナンバーカード（顔写真側）', '健康保険証'] ],
			[ 'TITLE' =>'本人確認書類の種類', 'CONTENT' => [ '運転免許証', 'マイナンバーカード', '住基カード', 'パスポート', '学生証', '社員証', '職員証', 'その他' ]],
			[ 'TITLE' =>'資格の種類', 'CONTENT' => [ '教員免許状', '学士', '修士', '博士', '司書', 'その他']],
			[ 'TITLE' =>'著書の種類', 'CONTENT' =>[ '学術・教養', '小説', '新書', 'ﾉﾝﾌｨｸｼｮﾝ', 'その他']]
		],
		'GROUP_TYPE' => [
			[ '公立学校', '私立学校', '学童'],
			[ '小学校', '中学校', '中高一貫校', '高校', '大学'],
			['sho','chu','chu','ko','dai','','','','','']
		],
		'PURPOSE' =>  [
			[
				' 利用会員による受検、ランキング参加、及びｸｲｽﾞ作成等による読書推進 ',
				' クイズ作成、クイズ監修、試験監督などのボランティア活動を通し、読書を推進 '
			],
			[
				' 受検、及びｸｲｽﾞ作成、読書量ランキング参加など ',
				' クイズ作成、監修、試験監督などのボランティア活動による読書推進 '
			],
		],
		'TYPE' => [
			'団体','一般', '監修者', '著者','教師','司書','代表（校長、教頭等）','IT担当者','その他','生徒', '', '', '', '', '', '協会'
		],
		'RANKPERIOD' => [
			'生涯獲得ポイント','今年度獲得ポイント', '昨年度獲得ポイント'],
		'RANKYEARS' => [
			'10代','20代', '30代','40代','50代','60代','70代','80代以降','全ての年代'],	
		'DOCS' => [
			['TITLE' => '団体会員利用規約と申込の流れ', 'PATH' => 'manual/group.pdf'],
			['TITLE' => '一般会員利用規約と申込の流れ', 'PATH' => 'manual/user.pdf'],
			['TITLE' => '監修者会員利用規約と申込の流れ', 'PATH' => 'manual/overseer.pdf'],
			['TITLE' => '著者会員利用規約と申込の流れ', 'PATH' => 'manual/author.pdf'],
		],
		'RIGHTS' => [
			'A' => '担任している学級児童の基本情報を閲覧、編集',
			'B' => '担任している学級児童の合格記録を削除',
			'C' => '担任している学級児童のマイ書斎内連絡帳にコメント （司書はコメント可）',
			'D' => '全校児童の試験監督、合格履歴や順位の参照',
			'E' => '本の検索、登録、クイズ作成',
			'F' => '学校基本情報の編集、全校児童の基本情報閲覧編集',
		]
	],
	'CLASS_TYPE' => [
		'校長・教頭','クラス担任教師','その他教師（副担任等）','司書','小学生','中学生','高校生','大学生',
	],
	'SEASON'=>["春期", "夏期", "秋期", "冬期"],
	'CLASS_GRADE' => ['無し','1年','2年','3年','4年','5年','6年'],
	'PHONE_MASK' => '99999999999',
	'YEAR_FEE' => 1200,
	'Mailer' => config('mail')['from']['address'],
    'BOOK_REASON' => [
        ['TITLE' => '既に登録されている'],
        ['TITLE' => '読Q本の規定外'],
        ['TITLE' => 'その他の場合入力'],
    ],
	'TEACHER' => [
		'ACTIONS' => [
			'A' => ['TITLE' => '児童生徒マイ書斎閲覧', 'ACTION' => '/mypage/pupil_view'],
			'B' => ['TITLE' => '生徒マイ書斎連絡帳へ入力','ACTION' => '/teacher/send_notify'],
			'C' => ['TITLE' => '生徒の基本情報データ修正','ACTION' => '/teacher/edit_pupil?mode=edit'],
			'D' => ['TITLE' => '生徒の基本情報データ削除','ACTION' => '/teacher/edit_pupil?mode=delete'],
			'E' => ['TITLE' => '合格記録の取り消し','ACTION' => '/teacher/cancel_pass'],
			'F' => ['TITLE' => 'ログインエラー ロックの解除','ACTION' => '/class/pupil/unlock'],
			'G' => ['TITLE' => '顔認証エラーを解除し登録画面へ','ACTION' => 'faceverifyerror'],
		]
	],
	'BOOK' => [
		'TYPE' => ['紙の本', '電子書籍または青空文庫', '字数カウント済みの本'],
		'REASON' => ['既に登録されている', '読Q本の規定外', 'その他の場合入力'],
		'CATEGORIES' => ['児童書','絵本','単行本','文庫本','新書','電子書籍','青空文庫','短編','日本の文学','海外の文学','ﾌｧﾝﾀｼﾞｰ・SF','冒険','純文学','ﾐｽﾃﾘｰ','歴史','古典','名作','ﾉﾝﾌｨｸｼｮﾝ・伝記','教養・学術','ｴｯｾｲ・評論','大人向け'],
		'RECOMMEND' => [
			['TITLE' => '未就学～小学校低学年', 'POINT' =>0.1], //view register.blade.php pointarray
			['TITLE' => '小学校低学年', 'POINT' => 0.2],
			['TITLE' => '小学校低学年～小学校中学年', 'POINT' => 0.4],
			['TITLE' => '小学校中学年', 'POINT'=> 0.5],
			['TITLE' => '小学校中学年～小学校高学年', 'POINT'=> 0.7],
			['TITLE' => '小学校高学年', 'POINT'=> 0.8 ],
			['TITLE' => '小学校高学年～中学生', 'POINT' => 0.9],
			['TITLE' => '中学生以上～大人' , 'POINT' => 1.0],
			['TITLE' => '成人向け（中学生以下受検不可）', 'POINT'=> 1.0],
			['TITLE' => '※名作、学術、教養など', 'POINT'=> 1.5],
			['TITLE' => '※古典', 'POINT'=> 2.0],
		],
		'SEARCH_RECOMMENDS' => [
			'読Qと先生が推薦する、小学校低学年向けの本一覧',
			'読Qと先生が推薦する、小学校中学年向けの本一覧',
			'読Qと先生が推薦する、小学校高学年向けの本一覧',
			'読Qと先生が推薦する、中学生向けの本一覧',
		],
		'RANKINGS' => [
			'小学校低学年に読まれている読Q本ランキング',
			'小学校中学年に読まれている読Q本ランキング',
			'小学校高学年に読まれている読Q本ランキング',
			'中学生に読まれている読Q本ランキング',
			'高校生に読まれている読Q本ランキング',
			'10代に読まれている読Q本ランキング',
			'20代に読まれている読Q本ランキング',
			'30代に読まれている読Q本ランキング',
			'40代に読まれている読Q本ランキング',
			'50代に読まれている読Q本ランキング',
			'60代に読まれている読Q本ランキング',
			'70代に読まれている読Q本ランキング',
			'80代以上に読まれている読Q本ランキング',
			'あなたのクラスメイトによく読まれている読Q本ランキング',
			'あなたの学校の同学年児童に読まれている読Q本ランキング',
			],
		'RANKINGS_title' => [
			'小学校低学年',
			'小学校中学年',
			'小学校高学年',
			'中学生',
			'高校生',
			'10代',
			'20代',
			'30代',
			'40代',
			'50代',
			'60代',
			'70代',
			'80代以上',
			'あなたのクラスメイト',
			'あなたの学校の同学年児童',
			],
		'RANKING_PERIOD' => [
			'前回　四半期',
			'前年度',
			'生涯',
		],
		'REGISTER_VISI_TYPE' => [
			1=>'本名',
			2=>'読Qネーム',
		],

	],
	'QUIZ' => [
		'APP_RANGES' => [
			'前半から', '中盤から','後半から','全体から','本文に無い'
		],
		'REJECT_REASON' => [
            '同じクイズがすでに認定されている。', '文章が分かりにくい。','読Qｸｲｽﾞに相応しいとはいえない。'
        ],
        'REGISTER_VISI_TYPE' => [
			1=>'本名',
			2=>'読Qネーム',
			3=>'掲載しない',
		],
	],
	
	'HISTORY' => [
		'QUIZTEST_HISTORY' => [
			['ITEM' => 'クイズ受検', 'WORK' =>['回答開始','誤答','正答','合格','不合格1度目','不合格2度目','不合格2度目以上']]
		],
		'USERWORK_HISTORY' => [
			['ITEM' => '会員履歴', 'WORK' =>['ログイン','ログアウト','入会初ログイン','退会ログアウト','準会員へ','正会員へ復活','基本情報更新','顔登録','顔認証成功','顔認証失敗','会費支払い','読書認定書']]
		],
		'CONTRIBUTION_HISTORY' => [
			['ITEM' => '投稿', 'WORK' =>['帯文','いいね！','問合せ','いいね！削除']]
		],
		'BOOKQUIZ_HISTORY' => [
			['ITEM' => '本の登録とクイズ作成', 'WORK' =>['本の申請','読Q本認定','読Q本却下','クイズ送信','クイズ認定完了','クイズ認定却下','クイズ削除']]
		],
		'OVERSEER_HISTORY' => [
			['ITEM' => '監修者', 'WORK' =>['クイズ承認','クイズ追加','クイズ編集済','監修希望送信','監修決定','監修落選','著者と監修交代','クイズ削除']]
		],
		'TESTOVERSEE_HISTORY' => [
			['ITEM' => '試験監督', 'WORK' =>['開始顔認証','合格顔認証','検定中止']]
		],
		'BOOKSEARCH_HISTORY' => [
			['ITEM' => '読Q本の検索', 'WORK' =>['書籍名から','著者から','良さそうな推薦図書から','良さそうな/ジャンル','良さそうな/新読Q本','良さそうな/順位順','帯文のキーワードから','空くから','ISBNから']]
		],
		'ADMIN_HISTORY' => [
			['ITEM' => '協会', 'WORK' =>['ログイン', 'ログアウト','読Q本認定','候補本却下','監修者決定','監修者却下','帯文削除','合格取消','アカウント凍結','協会トップ画面保存','著者監修者交代','推薦図書加算係数','有効期限変更','メール送信','お問合せ返信','本のデータ削除','会員データ削除', '', '', '', '退会完了', '']]
		],
		'ORGWORK_HISTORY' => [
			['ITEM' => 'ログイン・ログアウト', 'WORK' =>['ログイン', 'ログアウト']],
			['ITEM' => '団体試験監督', 'WORK' =>['団体試験監督開始（ｐｗ入力）', '団体試験監督合格（ｐｗ入力）']],
			['ITEM' => '児童生徒情報', 'WORK' =>['生徒 入学', '生徒情報更新',  '連絡帳へ送信', '生徒 合格取消', '生徒 転校･削除', '生徒 転入', '', '生徒 卒業']],
			['ITEM' => '教職員情報', 'WORK' =>['教員 異動転出・削除', '教員 異動転入', '教員 新登録']],
			['ITEM' => 'お知らせ', 'WORK' =>['お知らせ送信', 'お知らせ削除']],
			['ITEM' => '団体基本情報', 'WORK' =>['団体人事更新', '団体情報更新']]	,
			['ITEM' => '支払い', 'WORK' =>['支払い']]
		],
	],
	'MESSAGES' => [
		'EDITTOP_COUNTS' => 5,
        'DOQUSER_EXIST' => 'すでに読Q会員です。',
		'GROUP_EXIST' => '既に使用されている団体ネームです。',
		'PASSWORD_LENGTH' => '8文字以上の半角英数を入力してください。',
        'PASSWORD_MAXLENGTH' => '15文字以下の半角英数を入力してください。',
		'PASSWORD_EXIST' => 'すでに使用されているパスワード、または無効のパスワードです。',
		'PASSWORD_NO_USE' => '他のパスワードを入力してください。',
		'USERNAME_MAXERROR' => '郵便番号を含めて30文字以内で入力してください。',
		'TEACHERNAME_NO' => '団体教職員として読Qネームが間違いです。正確に入力してください。',
		'WRONG_DATA' => '会員種別を正確に選択してください。',
		'NUMBERS_DATA' => '人数を正確に選択してください。',
		'WRONG_MEMBERDATA_DOUBLE' => 'すでに使用されている会員情報です。',
		'FILE_MAX_SIZE' => 'ファイル容量は2MB以下でしてください。',
		'CHECK_BOOK_CANCEL' => '合格記録を削除しする本を選択してください。',
		'CHECK_TEACHER' => '教職員を選択してください。',
		'CHECK_ONETEACHER' => '1人の教職員を選択してください。',
		'CHECK_USER' => '会員を選択してください。',
		'MESSAGE_INPUT' => 'メッセージを入力してください。',
		'CHECK_ONEUSER' => '1人の会員を選択してください。',
		'GROUPANDADMINSELECTNO' => '団体や協会は選択することができません。',
		'GROUPMESSAGESNEDNO' => '団体へはメッセージが送信されません。',
		'GROUPSELECTONLY' => '団体だけ選択してください。',
		'TEACHERSELECTONLY' => '教職員だけ選択してください。',
		'TEACHERSENDONLY' => '教職員へだけメッセージを送信することができます。',
		'GROUPSENDONLY' => '団体へだけメッセージを送信することができます。',
		'JOB_REQUIRED' => '作業を選択してください。',
		'CHECK_STUDENT' => '生徒を選択してください。',
		'CHECK_ONESTUDENT' => '1人の生徒を選択してください。',
		'CAMERA_ERROR' => 'カメラにアクセスできません。',
		'FACE_RECOG_1' => 'お使いのブラウザのバージョンではHTML5がサポートされていないため、正しく動作しません。ブラウザのバージョンをアップグレードしてから再度お試しください。',
		'USERNAME_REQUIRED' => '読Qネームを入力してください。',
		'USERNAME_UNIQUE' => '既に使用されている読Qネームです。',
		'PASSWORD_REQUIRED' => 'パスワードを入力してください。',
		'REQUIRED' => 'このフィールドは必須です。',
		'DATE_REQUIRED' => '生年月日を入力してください。',
		'DATE_ERROR' => '生年月日形式がエラーです。',
		'GROUP_INFO_CHANGED' => '団体の基本情報が成功裏に更新たれました。',
		'REMOVED_FROM_SCHOOL' => '当校から正確に削除ました。',
		'ERROR_EXIST' => '入力した情報のなかエラーがあります。',
		'MEMBER_COUNT_ERROR' => '学生人数が満たされます。',
		'FIRSTNAME_REQUIRED' => '姓を入力してください。',
        'LASTNAME_REQUIRED' => '名を入力してください。',
		'FIRST_KATA_REQUIRED' => '姓（カタカナ）を入力してください。',
		'LAST_KATA_REQUIRED' => '名（カタカナ）を入力してください。',
        'FIRST_ROMA_REQUIRED' => '姓（ローマ字）を入力してください。',
        'LAST_ROMA_REQUIRED' => '名（ローマ字）を入力してください。',
        'NAME_REQUIRED' => '氏名を入力してください。',
        'KATA_REQUIRED' => '姓名（カタカナ）を入力してください。',
        'ROMA_REQUIRED' => '氏名（ローマ字）を入力してください。',
		'EMAIL_REQUIRED' => 'Eメールアドレスを入力してください。',
		'EMAIL_EMAIL' => '有効なEメールアドレスを入力してください。',
		'EMAIL_UNIQUE' => '既に使用されているEメールアドレスです。',
		'EMAIL_SERVER_ERROR' => 'メールサーバーに接続することができません。後でまた接続してください。',
		'ROLE_REQUIRED' => '教師・司書を選択してください。',
		'GENDER_REQUIRED' => '性別を選択してください。',
		'CLASS_REQUIRED' => 'クラスを選択してください。',
		'PUPIL_REQUIRED' => '児童生徒を選択してください。',
		'ACTION_REQUIRED' => '操作を選択してください。',
		'FULLNAME_REQUIRED' => '本名（名称）を入力してください。',
		'ADDRESS1_REQUIRED' => '都道府県を入力してください。',
		'ADDRESS2_REQUIRED' => '市区郡町村を入力してください。',
		//'ADDRESS3_REQUIRED' => '町を入力してください。',
		'SAVED' => '正確に保管されました。',
		'SUCCEED' => '操作が成功しました。',
		'ARTICLE_SUCCEED' => '投稿しました。',
		'EDIT_SUCCEED' => '編集を完了しました。',
		'REGISTER_SAVED' => '登録を完了しました。',
		'REGISTER_FINISHIED' => '登録完了しました。',
		'CONFIRM_DELETE' => 'このデータを削除しますか？',
		'QUIZE_NO_DELETE' => '削除することができません。認定に必要なクイズの最低数は%s問題です。',
		'RECOGQUIZE_NO_DELETE' => '認定済みのため削除できません。編集で対処してください。',
        'AUTOMSG_BOOK_ACCEPT' => 'あなたが読Q本に登録申請をしていた「%s」が、読Q本に認定されました。これにより、読Q本ポイントの１０％が、あなたの読Qポイントに加算されます。',
        'AUTOMSG_BOOK_REJECT' => '%sに読Q本に登録申請していただいた「%s」は、残念ながら登録できません。理由:%s',
        'AUTOMSG_TEST_FAILED' => '%sに受検された「%s」の再受検は、%sからできます。',
        'AUTOMSG_TEST_SUCCESS' => '%s： おめでとうございます！「%s」の検定に合格しました。',
        'AUTOMSG_TEST_CANCELED' => '%sの合格は取り消されました。',
        'AUTOMSG_OVERSEER_ACCEPT' => 'あなたを、監修者に認定します。読Qクイズの選定や、担当本のページの投稿管理をお任せします。よろしくお願いいたします。',
        'AUTOMSG_OVERSEER_REJECT' => '残念ながら、あなたを監修者に認定することはできません。今後はぜひクイズ作成や本の登録などで、共に読書推進を行っていただきたく、引き続きよろしくお願いいたします。',
        'AUTOMSG_OVERSEER_DECISION' => 'あなたを、「%s」の監修者に決定します。マイ書斎内の監修応募履歴をご確認ください。読Qクイズの選定や、担当本のページの投稿管理をよろしくお願いいたします。',
        'AUTOMSG_OVERSEER_DEFEAT' => '残念ながら、「%s」の監修者に選ばれませんでした。マイ書斎内の監修応募履歴をご確認ください。',
        'AUTOMSG_QUIZMAKE_ACCEPT' => 'おめでとうございます。作成された「%s」のクイズ%s問が読Qに認定されました。詳細はマイ書斎内の、「読Q活動の全履歴」をご確認ください。',
        'AUTOMSG_QUIZMAKE_REJECT' => '残念ながら、作成された「%s」のクイズ%s問は、読Qに認定されませんでした。詳細はマイ書斎内の、「読Q活動の全履歴」をご確認ください。',
        'AUTOMSG_QUIZMAKE_DELETE' => '残念ながら、読Qに認定された「%s」のクイズ「%s」問は、読Qに認定されませんでした。読Q本ポイントの１０％が,あなたのポイントで削減されます。詳細はマイ書斎内の、「読Q活動の全履歴」をご確認ください。',
        'AUTOMSG_LEVEL_UP' => '昇級おめでとうございます。',
        'AUTOMSG_LEVEL_DOWN' => '残念ながら、下級なりました。',
        'AUTOMSG_DISTRIBUTE' => '読Qレポートが配信されました。マイ書斎からご覧ください。',
        'SETTLEMENT_SUCCESS' => '申請いただいた読書認定書の閲覧用パスコードは、「%s」です。6カ月間有効です。',
        'SETTLEMENT_DELAY' => '今の認定書の閲覧を6カ月間延長しました。',
        'SETTLEMENT_1MONTH' => '現在の読書認定書の閲覧期間は、「%s」までです。延長する場合はマイ書斎の読書認定書発行欄からお手続きください。',
        'EDIT_RIGHT_NO' => '編集権限がありません。',
        '21B1' => '読Q団体パスワードを入力',
		'21B11' => '読Q団体パスワードが違います。',
        '21b12' => '団体教師パスワード入力',
        'PASSWORD_INPUT' => 'パスワードを入力',
        'MSG_MAIL_SEND' => '送信しました。',
        'BOOK_REQUIRED' => '本を選択してください。',
        'REASON_REQUIRED' => ' 理由を入力してください。',
        'MESSAGE_REQUIRED' => ' 返信内容を入力してください。',
        'SENTENCE_REQUIRED' => '入力してください。',
        'FACEVERIFY_DELETE_TOREGISTER' => '顔認証エラーを解除し、登録画面を表示しました。',
        'LOGINERROR_ROCK_REMOVE' => 'ログインエラーによるロックを解除しました。',
        'RECOMMEND_REGISTER' => '監修者と登録されました。ログインする時,読Qネームに「ｋ」を付けてください。',
        'RECOMMEND_NOREGISTER' => '監修者申請を却下しました。',
        'ISBN_UNIQUE' => 'この本は、既に他の人が登録申請をしているため登録できません。',
        'BOOKOUT_UNIQUE' => '申し訳ありません。この本は読Qの対象とする種類の本ではないため、登録できません。',
        'QUIZ_FINISH_SUCCEED' => 'この本のクイズ募集を完了して読Q本へ登録しました。',
        'FAILED' => '操作が失敗しました。',
        'CHECK_ONEQUIZUSER' => '1人を選択くしてください。',
        'CHECK_SELECT' => '選択くしてください。',
        'AUTHOR_USERNAME_ERROR' => '著者の著者監修者読Qネームを正しく入力してください。',
        'ASSOCIATE_MEMBER_ALERT' => '現在、読Q準会員です。読Qを採用している団体に所属するか、またはマイ書斎から会費支払い手続きをすると、正会員となり受検ができるようになります。',
        'FULLNAME_USERNAME_ALERT' => '名前や読Qネームを入力してください。',
        'AGE_LIMIT_ALERT' => 'この本は年齢制限のある本なので、受検できません。',
        'FACE_SERVER_NO_STOP' => '今顔認識を進行することができません。後でまたしてください。',
        'FACE_NO' => '顔を枠の中に入れ、レンズを見てください。',
        'POUND_NO' => '傍線部を＃で囲ってください。',
        'DATATYPE_REQUIRED' => 'データ種類を選択してください。',
        'BOOKID_REQUIRED' => '読Q本IDを入力してください。',
        'QUIZID_REQUIRED' => '読Qクイズ№を入力してください。',
        'PERIOD_SELECTED' => '期間を選択してください。',
        'USEHISTORY_SELECTED' => '利用履歴を選択してください。',
        'ARTICLE_DELETE_SUCCEED' => 'この本の帯文了を正確に削除ました。',
        'DATA_NO' => 'データがありません。',
        'SEARCH_REQUIRED' => '検索条件を入力してください。',
        'EDIT_FINISHED' => '更新しました。',
        'AUTOMSG_ADIN_REGISTER' => '%s： 協会会員に登録しました。',
        'ADMIN_REGISTER_SUCCEED' => '協会会員に登録しました。',
        'CONFIRM_BOOK_DELETE' => 'この読Q本カードを削除しますか？',
        'BOOK_DELETE_SUCCESS' => '%sに読Q本「%s」は、削除されました。',
		'CONFIRM_PER_DELETE' => '会員データを削除すれば、復活することができません。ほんとうにこの会員情報カードを削除しますか？',
		'CONFIRM_ORG_DELETE' => 'この団体を削除しますか？',
		'ORG_DELETE_ERROR' => '団体の削除が失敗しました。',
	],
	'PAY_LIST' => [		
		'monthly' => '月1回払い',
		'monthly1' => '月1回払い(1名援助)',
		'monthly2' => '月1回払い(2名援助)',
		'monthly4' => '月1回払い(4名援助)',
		'monthly10' => '月1回払い(10名援助)',
		'monthly20' => '月1回払い(20名援助)',
		'monthly30' => '月1回払い(30名援助)',		
		'yearly'  => '年1回払い',
		'yearly1' => '年払い(1名援助)',
		'yearly2' => '年1回払い(2名援助)',
		'yearly4' => '年1回払い(4名援助)',
		'yearly10' => '年1回払い(10名援助)',
		'yearly20' => '年1回払い(20名援助)',
		'yearly30' => '年1回払い(30名援助)'
	],
	'PAY_AMOUNT' => [		
		'monthly' => '100',
		'monthly1' => '200',
		'monthly2' => '300',
		'monthly4' => '500',
		'monthly10' => '1100',
		'monthly20' => '2100',
		'monthly30' => '3100',		
		'yearly'  => '1000',
		'yearly1' => '2000',
		'yearly2' => '3000',
		'yearly4' => '5000',
		'yearly10' => '11000',
		'yearly20' => '21000',
		'yearly30' => '31000'
	],
	'HISTORY_ITEM' => [
		'home_top' => 'トップ',
		'search_book' => '本の検索',
		'quize_make' => '本の登録とクイズ作成',
		'book_page' => '本のページ',
		'my_page' => 'マイ書斎',
		'overseer' => '受検',
		'help_page' => '読Qとは',
		'otherviewer' => '他者マイ書斎',
		'admin_page' => '協会'
	],
	'PERIOD_TIME' => [
		['start_time' => date('0-0-0 0:0:0'), 'end_time' => now()],
		['start_time' => date_sub(now(), date_interval_create_from_date_string("12 hours")), 'end_time' => now()],
		['start_time' => date("Y-n-d 0:0:0"), 'end_time' => date("Y-n-d 11:59:59")],
		['start_time' => date("Y-n-d 12:0:0"), 'end_time' => date("Y-n-d 23:59:59")],
		['start_time' => date_sub(date_create(date("Y-n-d 0:0:0")), date_interval_create_from_date_string("4 days")), 'end_time' => date_sub(date_create(date("Y-n-d 23:59:59")), date_interval_create_from_date_string("1 days"))],
		['start_time' => date_sub(date_create(date("Y-n-d 0:0:0")), date_interval_create_from_date_string("8 days")), 'end_time' => date_sub(date_create(date("Y-n-d 23:59:59")), date_interval_create_from_date_string("1 days"))],
		['start_time' => date_sub(date_create(date("Y-n-d 0:0:0")), date_interval_create_from_date_string("1 months")), 'end_time' => date_sub(date_create(date("Y-n-d 23:59:59")), date_interval_create_from_date_string("1 days"))],
		['start_time' => date_sub(date_create(date("Y-n-d 0:0:0")), date_interval_create_from_date_string("3 months")), 'end_time' => date_sub(date_create(date("Y-n-d 23:59:59")), date_interval_create_from_date_string("1 days"))],
		['start_time' => date_sub(date_create(date("Y-n-d 0:0:0")), date_interval_create_from_date_string("6 months")), 'end_time' => date_sub(date_create(date("Y-n-d 23:59:59")), date_interval_create_from_date_string("1 days"))],
		['start_time' => date('0-0-0 0:0:0'), 'end_time' => now()]
	],
	'HELP_PAGE' => [
		'読Qの特長', '読Ｑの使い方', 'ポイントの仕組みと取得目標', '監修者紹介', '受検問題サンプル', '顔認証について', 'サイトマップ', '法人概要', '会員種類の説明と利用規約', '会費・料金について', '個人情報保護方針', 'お問合せ', 'よくある質問'
	],
	'PROPERTIES' => [
		'学校が会費負担', '一般会員', ''
	],
	'PAYMENT_METHOD' => [
		'学校が会費負担', '月額　　円', '年額　　円'
	]
];
 