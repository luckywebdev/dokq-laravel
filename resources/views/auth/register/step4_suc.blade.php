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
		<div class="form-horizontal">
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
							<span class="step">
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
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>				
						
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 4 </span>
							<span class="desc"><i class="fa fa-check"></i> ステップ４ </span>
							</span>
						</li>						
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 100%;">
						</div>
					</div>				
				</div>
			</div>
			{{ csrf_field() }}
			<div class="jumbotron">
				<h3 class="text-md-center"> 団体会員登録が完了しました</h3>
				<hr class="my-4">
				<p class="lead">
			  		ご登録ありがとうございました。<br>
			  		ご登録いただいた読Qネームとパスワードは、今後ログインする際にご使用ください。<br>
			  		なお、下記「読Qトップへ戻る」ボタンから、既にログインした状態ですぐに読Qを始められます。<br>
			  		必要事項を登録して、読Qによる読書推進を始めましょう。
			  	</p>
			</div>
			
			
			<div class="form-group form-actions row">
				<div class="offset-md-8 col-md-4 text-md-right col-sm-12">
					<a href="{{url('/')}}" class="btn btn-info">読Qトップ画面に戻る</a>
					<a href="{{route('logout')}}" class="btn btn-warning">ログアウト</a>
				</div>
			</div>
		</div>
		
	</div>
</div>
@stop
