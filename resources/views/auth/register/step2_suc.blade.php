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
						<li class="nav-item">
							<span  class="step">
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
			<h2 class="text-sm-center"> 確 認 画 面</h2>
			{{ csrf_field() }}
			<table class="table table-bordered">
			    <tbody class="text-md-center">
			 		<tr>
				        <td class="info">団体名　（種別）</td>
				        <td colspan="3">{{$user->group_name}} ({{$user->group_yomi}})</td>
					</tr>
					<tr>
				        <td class="info">代表者名</td>
				        <td colspan="3">{{$user->rep_name}}</td>
					</tr>
					<tr>
				        <td class="info">住所</td>
				        <td colspan="3">〒 {{$user->address4}}―{{$user->address5}} {{$user->address1}} {{$user->address2}} {{$user->address3}} </td>
					</tr>
					<tr>
				        <td class="info">電話</td>
				        <td colspan="3">{{$user->phone}}</td>
					</tr>
					<tr>
				        <td class="info">担当者名</td>
				        <td colspan="3">{{$user->teacher}}</td>
				        
					</tr>
					<tr>
				        <td class="info align-middle">Wi-Fi</td>
				        <!-- <td >番号: {{$user->wifi}}</td> -->
				        <td >IP住所: {{$user->ip_address}}</td>
				        <td>ネットマスク: {{$user->mask}} </td>
						
					</tr>
					<tr>
				        <td class="info">担当者メールアドレス</td>
				        <td colspan="3">{{$user->email}}</td>
					</tr>
					<tr>
				        <td class="info">代表者本人確認書類</td>
				        <td >種類…
				        	{{config('consts')['USER']['AUTH_TYPE'][$user->role]['CONTENT'][$user->auth_type]}}
			        	</td>
				        <td><a href="{{asset($user->file)}}" download>添付ファイル</a></td>
				        <!--<td><a href="{{url('/auth/download/'.$user->username.'')}}">添付ファイル</a></td>-->
					</tr>
					<tr>
				        <td class="info">申込人数合計</td>
				        <td colspan="3"><span class="text-danger">{{$user->totalMemberCounts()}}</span> 名  詳細は下記</td>
					</tr>
					@foreach($user->registerclasses as $class)
					<tr>
				        <td>{{config('consts')['CLASS_TYPE'][$class->type]}} 
				        @if ($class->grade < 1)
				        	
				        @else
				        	{{$class->grade}}学年
				        @endif
				        </td>

				        <td>{{$class->class_number}} @if ($class->class_number != '') 組  @endif</td>
				        <td>{{$class->member_counts}} 名</td>
					</tr>
					@endforeach
					
					<tr>
						<td class="info">合計（児童生徒を含む人数）</td>
						<td colspan="3">{{$user->totalMemberCounts()}} 名</td>
					</tr>
					<tr>
						<td class="info">合計（児童生徒を含めない人数）</td>
						<td colspan="3">{{$user->nopupiltotalMemberCounts()}} 名</td>
					</tr>
			    </tbody>
			</table>
			
			
			<div class="form-group form-actions row">
				<div class="offset-md-4 col-md-4 text-md-center col-sm-12">
					<a href="{{url('auth/register/'.$user->role.'/4?refresh_token='.$user->refresh_token)}}" class="btn btn-success" style="margin-bottom:8px">IDとパスワード正式登録画面へ進む</a>
				</div>
				<div class="col-md-4 text-md-right col-sm-12">
					
					<a href="{{url('/auth/register/'.$user->role.'/3?refresh_token='.$user->refresh_token)}}" class="btn btn-info" style="margin-bottom:8px">戻って修正する</a>					
					

					<!-- <a href="javascript:history.go(-1)" class="btn btn-info">戻って修正する</a> -->
				</div>
			</div>
		</div>
		
	</div>
</div>
@stop
