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
	            	<a href="{{url('/mypage/top')}}">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="{{url('/mypage/main_info')}}">
	                	 > 基本情報
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	> 会費お支払い手続きと変更
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">会費お支払い手続きと変更</h3>

			<div class="row">
				<div class="col-md-12">
					<div class="news-blocks blue">
						<h4>
							<a href="#">会費払込済み期間について</a>
						</h4>
						
						<!-- <h5 class="text-md-center">
							年会費　1200円 （月額100円）
						</h5> -->

						<p>
							読Ｑ有効期限（会費払込済期間）・・・{{ $pay_year }}年{{ $pay_month }}月 {{ $pay_date }}日<br>
							会費払込方法・・・・・・・・・・・・・・・・・　{{$pay_content}}<br>
							読書認定書発行手数料の支払いや退会などは、サイドメニューからお手続きください。<br>
							その他のお支払い手続きは、<a href="#" id="payment_set_view" class="" style="font-size: 18px;"><strong>こちら</strong></a>

							<!-- ※ 途中で退会されても、支払われた会費の返金はいたしません。<br><br>
							会費をお支払いいただく方法<br>
							（団体所属のかたは、団体からまとめて支払われます。）<br>
							<li style="margin-left:10px;">クレジットカード決済</li>
							<li style="margin-left:10px;">キャリア決済</li> -->
						</p>
					</div>
				</div>
				<div class="col-md-12" id="payment_set" style="display: none">
					<div class="news-blocks lime">
						<div class="text-md-center">

						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="X3983PUVZPRT4">
							<table class="text-center" width="100%" style="padding: 1%">
							<tr><td style="padding:1%"><input type="hidden" name="on0" value="Other_payments"><h4><strong>その他のお支払い</strong></h4></td></tr>
							<tr><td style="padding:1%"><select name="os0">
								<option value="other_payment_1">その他の支払 ¥300 JPY</option>
								<option value="other_payment_2">その他の支払 ¥500 JPY</option>
								<option value="other_payment_3">その他の支払 ¥1,000 JPY</option>
							</select> </td></tr>
							</table>
							<input type="hidden" name="currency_code" value="JPY">
							<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
							<img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
						</form>
						
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
<script type="text/javascript">
	$(function(){
		$("#payment_set_view").click(function(){
			$("#payment_set").show();
		});
		$(".btn-info").click(function(){
			$("#payment_set").hide();
		});
	});
</script>
@stop