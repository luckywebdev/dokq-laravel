@extends('layout')
@section('styles')
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
					<a href="#"> > 受検</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title"></h3>
							
			<div class="row margin-top-20">
				<div class="offset-md-1 col-md-10">
					<table class="table table-no-border table-hover">
						<tr>
							<td class="h4 text-md-center" colspan="2">
								@if($status == 1)
								続けてもう1回、同じ本のクイズにチャレンジできます。<br>（違う問題が出ます）
								@elseif($status == 0)
								2回続けて不合格になりましたので、読Q規定により、この本の受検は3日間できません。
								@endif
							</td>
						</tr>
						@if($status == 1)
						<tr>
							<td class="h4 text-md-right">もう1回受検しますか？</td>
							<td class="text-md-left">
								<button type="button" id="retest" class="btn btn-success">再受検する</a>
								<!--<form action="{{url('/book/test/caution')}}" method="get" id="form"> -->
								<form action="{{url('/book/test/start')}}" method="post" id="form">
								 {{csrf_field()}}
									<input type="hidden" name="book_id" value="{{$book_id}}">
									<input type="hidden" name="quiz_block_num" value="{{$quiz_block_num}}">
									<input type="hidden" name="user_id" id="user_id" value="{{$teacher_id}}"/>
								</form>
							</td>
						</tr>
						@endif
						<tr>
							<td class="h4 text-md-right">違う本を受検する。</td>
							<td class="text-md-left">
								<a href="{{url('/book/search')}}" class="btn btn-warning" style="margin-bottom:8px">本を検索して受検</a>
								<a href="{{url('/mypage/wish_list')}}" class="btn btn-warning" style="margin-bottom:8px">マイ書斎から受検</a>
							</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">終了してトップ画面に戻る</td>
							<td class="text-md-left">
								<a href="{{url('/')}}" class="btn btn-info" style="margin-bottom:8px">読Qトップに戻る</a>
							</td>
						</tr>
						<tr>
							<td class="h4 text-md-right">終了してログアウトする</td>
							<td class="text-md-left">
								<a href="{{route('logout')}}" class="btn btn-danger" style="margin-bottom:8px">終了してログアウト</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script>
	   $(document).ready(function(){
		$('body').addClass('page-full-width');
		// var socket = io('http://localhost:3000');
		var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
		var datas = {
			id: '<?php echo Auth::id(); ?>'
		};
		socket.emit('test-failed', JSON.stringify(datas));
		socket.on('test-overseer', function(msg){
			var data = JSON.parse(msg);
			if(data.test == 1){
				var datas = {
					id: '<?php echo Auth::id(); ?>'
				};
				socket.emit('test-failed', JSON.stringify(datas));
			}
	   });

		$('#retest').click(function(){
				$("#form").submit();
		});
		history.pushState(null, null, location.href);
			window.onpopstate = function () {
		history.go(1);
		};		
	});
    </script>
@stop