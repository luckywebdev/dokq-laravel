@extends('layout')
@section('styles')
<link href="{{url('/plugins/icheck/skins/all.css')}}" rel="stylesheet"/>
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
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> <a href="{{url('book/test/caution')}}">受検の注意</a>
				</li>
				<li class="hidden-xs">
					> <a href="#">監督の認証方法選択</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">試験監督の認証方法を選ぶ</h3><br>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" action="" method="post" id="test-password-form">
					{{csrf_field()}}
						@if(isset($book)&&Auth::check())
							<input type="hidden" name="book_id" value="{{$book->id}}">
							<input type="hidden" name="mode" value="1">
						@endif
						<input type="hidden" name="examinemethod" id="examinemethod" value="">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-md-5 control-label" style="font-size: 16px">教師パスワード自動入力</label>
								<div class="col-md-3">
									<input type="password" class="form-control" name="password" id="password" value="" placeholder="●●●●●●●" readonly>
								</div>								
							</div>
							<div class="form-group row">
								<label class="col-md-5 control-label" style="font-size: 16px">監督の顔認証</label>
								<div class="col-md-3" style="display: flex; align-items: center">
									<input name="is_face" id="is_face" type="checkbox" style="margin-top: 20%">
								</div>								
							</div>
						</div>	
						<div class="form-body">
							<div class="row">
								<div class="col-md-12 text-md-center">
									<button class="btn btn-primary" id="next_btn" disabled style="margin-bottom:8px">次　へ</button>
									<a class="btn btn-info pull-right" style="margin-bottom:8px" href="{{url('/')}}">トップに戻る</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>			
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('plugins/icheck/icheck.min.js')}}"></script>    
	<script>
	   $(document).ready(function(){
		   	//connect socket server
			// var socket = io('http://localhost:3000');
			var socket = io('https://<?php echo config('socket')['SOCKET_SERVER']?>:3000');
			var datas = {
				id: '<?php echo Auth::id(); ?>'
			};
			socket.emit('test-pupil', JSON.stringify(datas));

			socket.on('test-password', function(msg){
				var data = JSON.parse(msg);
				var id = '<?php echo Auth::id();?>';
				var ids = data.ids.split(",");
				for(i = 0; i < ids.length; i++){
					if(ids[i] == id){
						$("#password").val(data.password);
						$("#examinemethod").val(1);
						$("#test-password-form").attr("action", "/book/test/start");
						$("#test-password-form").submit();
					}
				}
		   });

		   socket.on('test-overseer', function(msg){
				var data = JSON.parse(msg);
				if(data.test == 1){
					var datas_response= {
						id: '<?php echo Auth::id(); ?>'
					};
					socket.emit('test-pupil', JSON.stringify(datas_response));
				}
		   });

			$('body').addClass('page-full-width');
			$('.btn-danger').click(function(){
				location.reload();
			});
			$('input[type="checkbox"]').change(function(){
                if($(this).attr("checked") == "checked"){
                    $("#next_btn").removeAttr("disabled");
                }else{
                    $("#next_btn").attr("disabled","");
                }
			});
			$("#next_btn").click(function(){
				var is_face = $("#is_face").attr("checked");
				if(is_face == "checked"){
					$("#test-password-form").attr("action", "/book/test/signin_overseer");
				} else {
				    $("#test-password-form").attr("action", "/book/test/start");
				}
				$("#test-password-form").submit();
			});		
		});
    </script>
@stop