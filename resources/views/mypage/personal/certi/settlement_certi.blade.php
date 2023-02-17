@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}">
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
	            	<a href="#">
	                	 > 読書認定書の発行
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<h3 class="page-title" style="font-size: 24px; font-weight: bold">お支払い</h3>
					<h4 class="text-center" style="font-size: 22px">読書認定書発行手数料、その他 お払込みの手続き</h4>
					<p class="text-center ml-5" style="font-size: 18px">プルダウンメニューから選択して、「今すぐ購入」をクリックしてください。</p>
				</div>
			</div>
			

			<div class="row" style="margin-top:50px;">
				<div class="offset-md-4 col-md-4" style="font-size:16px; text-align: center">

					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="BLJNCVJUQAQWQ">
						<table class="text-center" width="100%" style="padding: 2%">
						<tr><td style="padding:1%"><input type="hidden" name="on0" value="Pay_each_time">都度払込</td></tr><tr><td style="padding:1%"><select name="os0">
							<option value="create_certi_expand">読書認定書 作成または期間延長 ¥300 JPY</option>
							<option value="unpaid">未払い金の支払い ¥300 JPY</option>
						</select> </td></tr>
						</table>
						<input type="hidden" name="currency_code" value="JPY">
						<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
						<img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
					</form>
					<!-- <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="MBHHQEFCXKU4U">
						<table>
						<tr><td><input type="hidden" name="on0" value="Pay_each_time">Pay_each_time</td></tr><tr><td><select name="os0">
							<option value="create_certi_expand">create_certi_expand ¥300 JPY</option>
							<option value="unpaid">unpaid ¥300 JPY</option>
						</select> </td></tr>
						</table>
						<input type="hidden" name="currency_code" value="JPY">
						<input type="image" src="https://www.sandbox.paypal.com/ja_JP/JP/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - オンラインでより安全・簡単にお支払い">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
					</form> -->
				</div>


			</div>
			<form class="form form-horizontal offset-md-2 margin-top-20">
				<input type="hidden" id="index" name="index" value="{{$index}}">

				<div class="form-group row">
					<div class="col-md-12 text-md-center">
						<!-- <button type="button" class="btn btn-success btn-press">決済</button> -->
						<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
					</div>
				</div>
			</form>
			
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			$(".btn-press").click(function(){
				var index = $("#index").val();
				location.href = "/mypage/settlement_user/"+index;
				
			});
			$(".btn-sample").click(function(){
				$index = $("#sort").val();
				if ($index == 1) {
					$("#include").css("display","block");
				}
			});
		});
    </script>
@stop