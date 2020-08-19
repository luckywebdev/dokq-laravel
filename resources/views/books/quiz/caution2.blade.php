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
											<div class="col-sm-1">
												<h3 class="book_title">出題サンプル</h3>
											</div>
											
											<div class="col-sm-11">
												<div class="portlet light" style="width:100%;height:100%">
													<div class="portlet-body" style="width:100%;height:100%;overflow:auto">
														<canvas id = 'txt_canvas' ></canvas> 
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
											<li></li>
											<li><b>クイズの形式</b></li>
											<li>
												①傍線部が本の内容と合っていれば〇、違っていれば×を選ぶ、一問一答形式の〇×クイズです。出題数は本の長さによって違います。
											</li>
											<li>
												②１問の制限時間は３０秒です。３０秒間に回答しないと不正解となり次の問題に移ります。
											</li>
											<li>
												③正解が一定数に達すると、合格画面が表示され、検定テストは終了します。
											</li>
											<li>
												④不正解が一定数に達した場合も、不合格画面が表示され、検定テストは終了します。	
											</li>
											<li></li>
											<li><b>クイズ文の作り方</b></li>
											<li>
												①本文中の大事な部分から出題するクイズを作りましょう。
											</li>
											<li>
												②具体的で分かりやすいクイズを作りましょう。
											</li>
											<li>
											 	③傍線部は、#(シャープ)で囲んでください。短い文なら全文を囲んでもかまいません。
											</li>
											<li>
												④#で囲んでいない部分は、必ず本の内容に添っている文章にしてください。
											</li>
											<li>
												⑤本の文章をそっくりそのまま使わず、なるべく自分の言葉でクイズを作りましょう。
											</li>
											<li>
												⑥１つのクイズの字数制限は１５０字です。作成クイズ数に制限はありません。
											</li>
											<li>
												 ⑦作成文面例
												 <br>・桃太郎とともに鬼ヶ島へ行ったのは、#犬、猫、にわとり#でした。
												 <br>・浦島太郎は、竜宮城で♯とてもつらい日々を過ごしました。#
											</li>
											<li></li>
											<li><b>出典箇所の入力</b></li>
											<li>
												①本文のどのあたりからクイズを作ったかを、「前半、中盤、後半、全体、本文に無い」からびましょう。
											</li>
											<li>
												②出典ページは、電子書籍などの場合は空欄でかまいませんが、監修者による確認作業の手助けになるので、なるべく入力をお願いいたします。
											</li>
											<li>
												③間違っている答えを作成する場合でも、関連するページがあれば入力してください。
											</li>
											<li></li>
											<li><b>クイズ作成者表示名</b></li>
											<li>
												認定されると、クイズ作成者として、読Ｑ本の紹介ページと検定テスト上に名前が載ります。
											</li>
											<li>
												「本名、読Ｑネーム、掲載無し」から表示方法を選択してください。
											</li>
											<li></li>
											<li><b>認定のお知らせ</b></li>
											<li>
												①一定数クイズが集まると監修者がクイズを認定します。結果はマイ書斎連絡帳にお知らせします。
											</li>
											<li>
												②同じクイズが先に作られていたり、文章が適切でない場合などは認定されません。
											</li>
											<li></li>
											<li><b>獲得ポイントについて</b></li>
											<li>
												①作成したクイズが認定されると、読Ｑ本ポイントの10％のポイントが獲得できます。（但し10問分まで）
											</li>
											<li>
												②クイズ認定後、その本は正式に読Ｑ本となり、受検が可能になります。受検して合格すればさらに読Ｑ本ポイントを獲得できますので、1冊から最大で、通常の2倍のポイントを得られることになります。（本の登録もしていた場合、最大で2.1倍のポイント獲得になります）
											</li>
										</ul>	
									</div>
								</div>
							</div>	
							<div class="form-actions right">
								@if (isset($book)&&Auth::check())
								<!--	<button class="btn btn-success">この本のクイズを作る</button> -->
								@endif
								
								<a class="btn btn-warning" href="{{url('quiz/create?book_id='.$book->id)}}">この本のクイズを作る</a>
								<a class="btn btn-info" href="{{url('/')}}">トップに戻る</a>
								 <?php 
								 	$st = "%誕生日*たんじょうび*の%朝*あさ*、なつみは、#バス#にと(びの)った｡"; 
								 	$st = str_replace("、", "、", $st); $st = str_replace("､", "、", $st); 
									$st = str_replace("」", "﹂", $st); $st = str_replace("｣", "﹂", $st); 
									$st = str_replace("「", "﹁", $st); $st = str_replace("｢", "﹁", $st);
									$st = str_replace("（", "︵", $st); $st = str_replace("(", "︵", $st);
									$st = str_replace("）", "︶", $st); $st = str_replace(")", "︶", $st); 
									$st = str_replace("。", "。", $st); $st = str_replace("｡", "。", $st);
									
									echo $st;  ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript" src="{{asset('js/charts/Ruby.js')}}"></script>
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
			
			//var str2 = ["C1#(우리、)#는 %백두*바이드*에서 #개척된 %주체*쭈치*혁명#%위업*거밍위업*을 #반드시 완성해야# 한다."];
			var str2 = ["{{$st}}"];
			new Ruby(document.getElementById('txt_canvas').getContext("2d")).drawText(str2);
			//new Ruby(document.getElementById('txt_canvas2').getContext("2d")).drawText(str2);
		});
    </script>
@stop