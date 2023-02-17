
@extends('layout')
@section('styles')
    
@stop


@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-title">
				<h3>個別送信用Eメールアドレス：　　〇〇〇〇〇〇＠〇〇〇〇</h3>
				<h3>個別送信用メールのパスワード：　　●● ●● ●● ●●</h3>
			</div>
			<div class="row">
				<div class="col-md-12 portlet box purple">
					<div class="portlet-title">
						<div class="caption">新規メッセージ</div>
					</div>
					<div class="portlet-body">
						<ul class="list-group">
							<li class="list-group-item text-md-left">
								To   &nbsp;&nbsp;&nbsp;&nbsp;  〇〇〇〇＠〇〇〇〇〇〇.JP
							</li>
							<li class="list-group-item text-md-left">件名　&nbsp;&nbsp;&nbsp;&nbsp; 〇〇〇〇〇〇〇〇〇〇〇〇</li>
							<li class="list-group-item">
								<textarea class="form-control" rows="15">〇〇　〇〇様
いつも読Qをご利用いただきありがとうございます。
〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇
〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇
〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇

一般社団法人読書認定協会
藤沢市辻堂元町5-7-3
URL
Eメールアドレス　
								</textarea>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript">
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
	</script>
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
	
@stop