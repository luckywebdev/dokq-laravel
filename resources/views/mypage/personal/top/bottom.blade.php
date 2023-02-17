@extends('layout')

@section('styles')
   <link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
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
	            	> マイ書斎下
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">（マイ書斎下）</h3>

			<div class="row">
				<div class="col-md-5 column">
					<div class="news-blocks lime">
						<h4 class="font-blue">読Q活動の履歴</h4>
						
						<table class="table table-no-border">
							<tr>
								<td class="col-md-8" ><a style="text-decoration:none;" href="{{url('mypage/history_all')}}">読Q活動の全履歴を見る</a></td>
								<td class="col-md-4">非公開</td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/pass_history')}}">合格履歴を見る</a></td>
								<td><input type="checkbox" @if ($passed_records_is_public == 1)checked @endif class="make-switch" id="passed_records_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/rank_bq')}}">クイズ作成と読Q本登録ポイントランキングを見る</a></td>
								<td><input type="checkbox" @if ($register_point_ranking_is_public == 1)checked @endif class="make-switch" id="register_point_ranking_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/last_report')}}">書籍登録とクイズ作成の記録を見る</a></td>
								<td><input type="checkbox" @if ($register_record_is_public == 1)checked @endif class="make-switch" id="register_record_is_public" data-size="small"></td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/last_report')}}">読Qレポートバックナンバーを見る</a></td>
								<td>非公開</td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/article_history')}}">帯文投稿履歴を見る</a></td>
								<td>公開</td>
							</tr>
							<tr>
								<td><a style="text-decoration:none;" href="{{url('mypage/history_oversee')}}">試験監督履歴を見る</a></td>
								<td>非公開</td>
							</tr>
						</table>
					</div>

					<div class="news-blocks lime">
						<h4 class="font-blue">読書認定書の発行依頼</h4>
						
						<p>
							読書認定書を発行します。(有料）
						</p>
						<a href="{{url('mypage/create_certi')}}" class="btn btn-warning offset-md-5">次　へ</a>
					</div>

					<div class="news-blocks lime">
						<h4 class="font-blue">
							試験監督をする
							<small style="color: #909090"><br>（初めての場合は適性検査を受けてください。所要時間は約5分です。）</small>
						</h4>
						<a href="{{ url("/mypage/test_overseer") }}" class="btn btn-warning offset-md-2 @if(Auth::user()->aptitude == 1 || Auth::user()->age() <= 20) disabled @endif" style="margin-bottom:8px;">適性検査を受ける</a>
						<a href="{{ url("/mypage/oversee_test") }}" class="btn btn-warning @if(Auth::user()->aptitude == 0 || Auth::user()->age() <= 20) disabled @endif" style="margin-bottom:8px;">試験監督を始める</a>
					</div>
				</div>

				<div class="col-md-5 column">
					<div class="news-blocks blue">
						<h4 class="font-blue">お支払い</h4>
						
						<p>
							読Q有効期限・・・ 年 月 日<br>
							会費、シール購入、読書認定書発行手数料、の支払いと履歴支払い情報へアクセスするには、パスワードと顔認証が必要です。
						</p>
						<a href="#" class="btn btn-warning offset-md-5">顔認証画面へ</a>
					</div>

					<div class="news-blocks blue">
						<h4 class="font-blue">基本情報</h4>
						<table class="table table-bordered">
							<tr>
								<td>生年月日</td>
								<td>{{Auth::user()->birthday}}</td>
							</tr>
							<tr>
								<td>メールアドレス</td>
								<td>{{Auth::user()->email}}</td>
							</tr>
							<tr>
								<td>パスワードなど</td>
								<td>{{Auth::user()->r_password}}</td>
							</tr>
						</table>
						<a href="{{ url("/mypage/other_view_info") }}" class="btn btn-warning offset-md-1" style="margin-bottom:8px;">外部から見た基本情報を見る</a>
						<a href="{{ url('/mypage/face_verify') }}" class="btn btn-warning" style="margin-bottom:8px;">顔認証画面へ</a>
					</div>

					<div class="top-news">
						<?php echo $advertise->mystudy_bottom; ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	
	<script>
		jQuery(document).ready(function() {
			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});
			$(".make-switch").on('switchChange.bootstrapSwitch', function(){
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
				$.ajax({
					type: "post",
		      		url: post_url,
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response) {
			    	}
				});
			});
		});   
	</script>
@stop