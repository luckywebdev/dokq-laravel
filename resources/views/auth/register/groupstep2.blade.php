@extends('auth.layout')

@section('contents')
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][1];
	$auth_types = config('consts')['USER']['AUTH_TYPE'][0];
	$genders = config('consts')['USER']['GENDER'];
	$purposes = config('consts')['USER']['PURPOSE'][1];
?>
<div class="container register">
	<div class="form">
		<form class="form-horizontal" method="post" role="form" action="{{ url('/auth/register/checktempauth') }}">
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="{{url('/')}}">
						<img class="logo_img" src="{{ asset('img/logo_img/logo_reserve_2.png') }}">
                        <!-- <h1 style="margin: 0 !important; font-family: 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
                        <h6 style="margin: 0 !important; font-family: HGP明朝B;">読書認定級</h6> -->
                    </a>
			    </div>
				<div class="form-body col-md-11">
					<ul class="nav nav-pills nav-fill steps">
						<li class="nav-item active">
							<span class="step" >
								<span class="number"> 1 </span>
								<span class="desc">
									<i class="fa fa-check"></i> ステップ１
								</span>
							</span>
						</li>
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２ 
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 4 </span>
							<span class="desc"><i class="fa fa-check"></i> ステップ４ </span>
							</span>
						</li>
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 50%;">
						</div>
					</div>				
				</div>
			</div>
			<h3 class="text-sm-center"> 仮ID・仮パスワード 入力</h3>
			{{ csrf_field() }}
			<div class="alert alert-info">
				<h5>
					<center>
						 通知した仮IDと仮パスワードを入力してください。
					</center>
				</h5>
			</div>	
			@if(count($errors) > 0)
				@include('partials.alert', array('errors' => $errors->all()))
			@endif
			<div class="form-group row {{ $errors->has('username') ? ' has-danger' : '' }}">
				<label class="control-label col-sm-1 offset-sm-3 text-sm-right" for="username">仮ID:</label>
				<div class="col-md-4">
					<input type="text" required name="username" value="{{old('username')}}" class="form-control">

					@if ($errors->has('username'))
					<span class="form-control-feedback">
						<span>{{ $errors->first('username') }}</span>
					</span>
					@endif
				</div>
			</div>
			<div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">
				<label class="control-label col-sm-1 offset-sm-3 text-sm-right" for="password">仮パスワード:</label>
				<div class="col-md-4">
					<input type="password" required name="password" value="{{old('password')}}" class="form-control" id="password">
					<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">パスワードを表示する</label>
					@if ($errors->has('password'))
					<span class="form-control-feedback">
						<span>{{ $errors->first('password') }}</span>
					</span>
					@endif
				</div>
			</div>			

			<div class="form-group row">
				<label class="control-label offset-md-4 text-danger">
					※ 仮IDと仮パスワードを認識しない場合はもう一度申請をお願いいたします。
				</label>
			</div>
			

			<div class="form-group form-actions row">
				<div class="offset-md-4 col-md-4 text-md-center col-sm-6" style="margin-bottom:8px">
					<button type="submit" class="btn btn-success">次　へ</button>
				</div>
				<div class="col-md-4 text-md-center col-sm-6" style="margin-bottom:8px">
					<a href="{{url("/")}}" class="btn btn-info">読Qトップに戻る</a>
				</div>
			</div>
		</form>
		
	</div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
	$("#show_pwd").change(function() {
	    if($(this).attr("checked")) {
	        $("#password").attr("type", "text");
	    } else {
	        $("#password").attr("type", "password");
	    }
	});
</script>
@stop
