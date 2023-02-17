@extends('layout')
@section('styles')
    <style type="text/css">
    	.caution{
    		font-size: 16px;
    	}
    	.caution li{
    		margin-bottom: 10px;
    	}
    </style>
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
					<a href="{{url('book/search')}}"> > 読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					<a href="{{url('/quiz/create')}}"> > クイズを作る</a>
				</li>
				<li class="hidden-xs">
					<a href="#">ｸｲｽﾞを作る際の注意</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズを作る際の注意</h3>
							
			<div class="row">
				<div class="col-md-12">
				  	<div class="form">
						<form class="form-horizontal" action="{{url('quiz/create')}}">
							{{csrf_field()}}
							@if(isset($book)&&Auth::check())
								<input type="hidden" name="book_id" value="{{$book->id}}">
							@endif
							<div class="form-body">
								<div class="row">
									<div class="col-md-5">
										<div class="row test_content">
											<div class="col-sm-1" style="align-self:center">
												<h3 class="book_title">出題サンプル</h3>
											</div>
											
											<div class="col-sm-11">
												<div class="portlet light">
													<div class="portlet-body">
														<div class="row">
															<div class="col-sm-3 quiz_content "  style="padding-right:0px;height:420px;">
																<h5 class="font_gogic" style="max-width: 20px;text-align: left;font-family:HGP明朝B;">
																	 <?php 
																	 	$st = "次の文の#　　　#線部が本の内容︵ないよう︶と合︵あ︶っていれば〇︵①︶､違︵ちが︶っていれば×︵②︶を選︵えら︶んで、「次へ｣をクリックしてください｡"; 
																	 	$st = str_replace_first("#", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:line-through !important;font-family:HGP明朝B;'>", $st); $st = str_replace_first("#", "</span>", $st); 
																		$st = str_replace_first("＃", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:line-through;font-family:HGP明朝B;'>", $st); $st = str_replace_first("＃", "</span>", $st);
																		$st = str_replace("、", "、", $st); $st = str_replace("､", "、", $st); 
																		$st = str_replace("」", "﹂", $st); $st = str_replace("｣", "﹂", $st); 
																		$st = str_replace("「", "﹁", $st); $st = str_replace("｢", "﹁", $st);
																		$st = str_replace("（", "︵", $st); $st = str_replace("(", "︵", $st);
																		$st = str_replace("）", "︶", $st); $st = str_replace(")", "︶", $st); 
																		$st = str_replace("。", "。", $st); $st = str_replace("｡", "。", $st);
																		for($i = 0; $i < 30; $i++) {
																		 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("*", "︶</span>", $st);
																			$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("＊", "︶</span>", $st);
																		} 
																		echo $st;  ?>
																		<span style="font-size:0px;color:#fff;">ー</span>
																</h5>
															</div>
															
															<div class="col-sm-2 quiz_content" style="padding-right:0px;height:420px;">
																<h4 class="font_gogic" style="max-width: 30px;text-align: left;font-family:HGP明朝B;">
																	 <?php $st = "誕生日*たんじょうび*の朝*あさ*、なつみは、#バス#にとびのった｡"; 
																	 	$st = str_replace_first("#", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:overline !important;font-family:HGP明朝B;'>", $st); $st = str_replace_first("#", "</span>", $st); 
																		$st = str_replace_first("＃", "<span class='font_gogic' style='writing-mode:vertical-rl !important;text-decoration:overline;font-family:HGP明朝B;'>", $st); $st = str_replace_first("＃", "</span>", $st);
																		$st = str_replace("、", "、", $st); $st = str_replace("､", "、", $st); 
																		$st = str_replace("」", "﹂", $st); $st = str_replace("｣", "﹂", $st); 
																		$st = str_replace("「", "﹁", $st); $st = str_replace("｢", "﹁", $st);
																		$st = str_replace("（", "︵", $st); $st = str_replace("(", "︵", $st);
																		$st = str_replace("）", "︶", $st); $st = str_replace(")", "︶", $st); 
																		$st = str_replace("。", "。", $st); $st = str_replace("｡", "。", $st);
																		for($i = 0; $i < 30; $i++) {
																		 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("*", "︶</span>", $st);
																			$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>︵", $st); $st = str_replace_first("＊", "︶</span>", $st);
																		} 
																		echo $st;  ?>
																		<span style="font-size:0px;color:#fff;">ー</span>
																</h4>
															</div>
															<div class="col-sm-2 answer_content">
																<div class="btn-group" data-toggle="buttons">
																	<label class="btn btn-primary btn-block" id="btn_yes" style="margin-bottom:6px;">
																	<input type="radio" class="toggle">①</label>
																	<div>〇</div>																	
																	<label class="btn btn-danger btn-block" id="btn_no" style="margin-bottom:6px;">
																	<input type="radio" class="toggle">②</label>
																	<div>X</div>																	
																</div>
															</div>
															<div class="col-sm-2 tonext_content">
																<button type="button" class="btn btn-warning" id="next">次<br>へ</button>
															</div>
															<div class="col-sm-3">
																<div class="row">
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">出典· · · · · · · · ·<span style="font-size:0px;color:#fff;">ー</span></p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">著者· · · · · · · · ·<span style="font-size:0px;color:#fff;">ー</span></p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">本の登録者· · · ·<span style="font-size:0px;color:#fff;">ー</span></p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">クイズ作成者· · ·<span style="font-size:0px;color:#fff;">ー</span></p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;">クイズ監修者· · ·<span style="font-size:0px;color:#fff;">ー</span></p>
																</div>
																<div class="row">
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;"><span style="font-size:0px;color:#fff;">ー</span>﹁夢の国に行ったよ﹂&nbsp;︵〇〇出版社︶<span style="font-size:0px;color:#fff;">ー</span></p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;"><span style="font-size:0px;color:#fff;">ー</span>〇〇 〇〇</p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;"><span style="font-size:0px;color:#fff;">ー</span>南　英雄</p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;"><span style="font-size:0px;color:#fff;">ー</span>taro02412</p>
																	<p class="font_gogic" style="writing-mode:vertical-rl;max-width: 5px; text-align:left;margin-left: 15px;font-family:HGP明朝B;"><span style="font-size:0px;color:#fff;">ー</span>鈴木　武</p>																																		
																</div>
															</div>	
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-7">
										<ul class="caution">
											<li>
												読Ｑの検定は、本を読み終わったことを認定するための検定テストです。読んだ人ならだれにでもわかる問題を作りましょう。
											</li>
											<li><strong>検定の形式</strong></li>
											<li>
												① 傍線部が本の内容と合っていれば〇、違っていれば×を選ぶ、一問一答形式の〇×クイズです。出題数および合格すると獲得できるポイントは、本の長さと難易度によって違います。
											</li>
											<li>
												② １問の制限時間は３０秒です。３０秒間に回答しないと不正解となり次の問題に移ります。
											</li>
											<li>
												③ 正解が一定数（出題数の８０％）に達すると、合格画面が表示され、検定テストは終了します。　
											</li>
											<li>
												④ 不正解が一定数（出題数の２０％）に達した場合も、不合格画面が表示され、検定テストは終了します。
											</li>
											<li>
												⑤ 合格すると、その本の読Ｑポイントを獲得します。制限時間の半分以下で合格した場合、１０％の加算があります。
											</li>
											
											<li><b>クイズ文の作り方</b></li>
											<li>
												① 文脈に関連する部分から出題するクイズを作りましょう。文脈とは、その本の内容やストーリーを人におしえてあげるときに、あなたが話す部分です。取るに足らない部分からの出題は、読んだ人にも解けない恐れがあります。
											</li>
											<li>
												② 読解クイズではなく、読み終わったかを測るクイズです。具体的で分かりやすい問題を作りましょう。
											</li>
											<li>
												③ 傍線部は、#(ハッシュマーク)で囲んでください。短い文なら全文を囲んでもかまいません。#が無いと次へ進めません。
											</li>
											<li>
												④ #で囲んでいない部分は、必ず本の内容に添っている文章にしてください。	
											</li>
											<li>
												⑤ 本の文章をそっくりそのまま使わず、なるべく自分の言葉でクイズを作りましょう。	
											</li>
											<li>
												⑥ 漢字や読み仮名などは作品に忠実にクイズを作りましょう。読み仮名は、「すぐに洗濯（せんたく）をした。」のように漢字のあとに（）で小さく示します。入力方法は、「すぐに洗濯＊せんたく＊をした。」のように、＊を使用して読み仮名を囲んでください。
											</li>
											<li>
												⑦ １つのクイズの字数制限は１５０字ですが、時短ポイント（制限時間の半分以下ならポイントが１０％加算）を考慮して、なるべく短く簡潔な文章を作りましょう。　
											</li>
											<li>
												⑧ 作成文面例
												<br>・ 桃太郎とともに鬼ヶ島へ行ったのは、#犬、猫、にわとり#でした。
												<br>・ 浦島太郎は、竜宮城で♯とてもつらい日々を過ごしました。#
											</li>
											<li></li>
											<li><b>※本の種類によって違うクイズ作成方法</b></li>
											<li>
												⑨ 教養書、実用書の読了確認クイズを作成するのは、文学作品よりも少々難しいです。この種類の本の〇×クイズは、読んでいない人でも、常識的に〇×が推測できてしまう場合が多く、特に答えが×のクイズは作成上注意が必要です。教養書や実用書の、答えが×のクイズ文を作るには、書籍に書かれている内容を正反対にしたり一部変えたりするのではなく、その書籍に全く書かれていない内容のクイズ文にすると推測が難しいので、おすすめです。
											</li>
											<li>
												⑩ 短編集など、複数の作品が含まれる本のクイズを作る場合、クイズ冒頭に（）で作品タイトルを入れてから、クイズ文を入力するか、または、「〇〇〇（作品名）において・・・」、など、受検者にわかるように文章を作成してください。
											</li>
											<li>
												⑪ 古い、少年少女文学全集などについては、複数の著者の作品が1冊に収まっているため、作品ごとの読Ｑ本登録をお願いしています。青空文庫など別の形で出版されていることも多いので、検索し既に読Ｑ本か確認してください。
											</li>
											<li></li>
											<li><b>〇か×かの選択</b></li>
											<li>
												作成したクイズの傍線部（#で囲んだ部分）が、本文の内容と合っているなら1（〇）を選択。本文の内容と違っている場
											</li>
											<li>
												合や本文に無い内容の場合は２（×）を選択してください。
											</li>
											<li></li>
											<li><b>出典箇所の入力</b></li>
											<li>
												① 本のどのあたりからクイズを作ったかを、「前半、中盤、後半、全体、本文に無い」から選びましょう。
											</li>
											<li>
												② 出典ページを入力してください。紙の本でない場合等は空欄でもかまいませんが、監修者による確認作業の手助けになるので、なるべく入力をお願いいたします。
											</li>
											<li>
												③　正解が×のクイズを作成する場合でも、関連する内容のページがあれば入力してください。
											</li>
											<li></li>
											<li><b>クイズ作成者表示名</b></li>
											<li>
												認定されると、クイズ作成者として、読Ｑ本ページと検定問題画面に名前が載ります。　「本名、読Ｑネーム、掲載無し」から表示方法を選択してください。クイズを何度かに分けて複数作成する場合、名前の表示方法は１つに統一していただきますようお願いします。
											</li>
											<li><b>送信方法</b></li>
											<li>
												① 「完了して確認画面へ」をクリック。すると作成したクイズが表示されます。
											</li>
											<li>
												②  間違いが無いか、特に正解の１と２について確認してください。
											</li>
											<li>
												③  戻って編集したい場合「編集」をクリックすると戻ることができます。消したい場合は「削除」をクリックします。
											</li>
											<li>
												④  同じ本のクイズを続けて作る場合は「もっと作る」をクリックしてください。作成数に制限はありません。
											</li>
											<li>
												⑤  クイズ作成を終了し、作成したクイズを協会宛に送信する場合は「完了して送信」をクリックします。作ったクイズはマイ書斎の「読Ｑ活動全履歴」から確認できます。
											</li>
											<li><b>認定について</b></li>
											<li>
												①  一定数クイズが集まると監修者がクイズを審査し認定します。クイズ認定後、その本は正式に読Ｑ本となり、受検が可能になります。クイズ認定の結果はクイズ作成者マイ書斎連絡帳にお知らせし、認定されたクイズは、マイ書斎の「作成クイズの認定記録」に記載されます。また読Ｑ本のページのクイズ作成者欄に、作成者名が指定した表示名で載ります。
											</li>
											<li>
												②  同じ内容のクイズが複数の会員から投稿された場合、送信日の早いもの、文章が分かりやすいものを優先して審査します。但し、初投稿の会員である場合など、読Ｑ活動の意欲アップのため、優先させる場合があります。
											</li>
											<li>
												③  認定に際し、協会や監修者による若干の文章編集が入る場合があります。
											</li>
											<li><b>獲得ポイントについて</b></li>
											<li>
												④  作成したクイズが認定されると、読Ｑ本ポイントの10％のポイントが獲得できます。（但し10問分まで）
											</li>
											<li>
												⑤  １冊の本から最大限のポイント獲得例としては、本の登録+クイズ１０問以上認定+検定合格+時短ポイント＝受検だけの場合に比べて２．２倍も多くポイントを取得できます。
											</li>
										</ul>	
									</div>
								</div>
							</div>	
							<div class="form-actions right">
								@if (isset($book)&&Auth::check())
								<!--	<button class="btn btn-success">この本のクイズを作る</button> -->
								@endif								
								<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
@stop