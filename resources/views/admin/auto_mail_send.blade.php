
@extends('layout')
@section('styles')
    
@stop


@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-title"></div>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3 pull-right">A-タイトル：</div>
						<div class="col-md-8"> ○○〇〇〇〇○○〇〇〇〇</div>
					</div><br>
					<div class="row">
						<div class="col-md-3">B-宛名：</div>
						<div class="col-md-8">○○〇〇〇〇　様</div>
					</div><br>
					<div class="row">
						<div class="col-md-3">C-メール文面：</div>
						<div class="col-md-8">いつも読Qをご活用いただき、ありがとうございます。　〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇　 ○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇○○〇〇〇〇　　なお、このメールは送信専用です。このメールに返信しないようお願い申し上げます。</div>
					</div><br>
					<div class="row">
						<div class="col-md-3">差出人名：</div>
						<div class="col-md-8">一般社団法人読書認定協会【読Q】　〒251-0043 神奈川県藤沢市辻堂元町5-7-3</div>
					</div><br>
					<div class="row">
						<div class="col-md-3">℡：</div>
						<div class="col-md-8">0466-34-2232</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-3">読Q  URL</div>
						<div class="col-md-8"></div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>№</th>
								<th>ボタン</th>
								<th>A-タイトル</th>
								<th>B-宛名　本名 or　読Qネーム</th>
								<th>C-文面</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>2.1</td>
								<td>こちら</td>
								<td>パスワード再登録のご案内</td>
								<td>本名</td>
								<td>パスワード再登録のご案内をさせていただきます。</td>
							</tr>	
						</tbody>
					</table> 
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