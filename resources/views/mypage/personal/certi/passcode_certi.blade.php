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
					<h3 class="page-title">パスコード入力</h3>
				</div>
			</div>
			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8" style="font-size:16px">
					
				</div>
			</div>
			<form class="form form-horizontal" action="{{url('/mypage/passcode/'.$index)}}" method="get">
			{{ csrf_field() }}
				<input type="hidden" id="index" name="index" value="{{$index}}">
				<div class="form-body">
					<div class="form-group row">
						<label class="offset-md-2 col-md-2 control-label">
							パスコード入力
						</label>
						<div class="col-md-3">
							<input type="password" class="form-control" name="pwd" id="pwd" value="" >
							@if ($errors->has('password'))
			                    <span class="help-block">
			                        <strong>{{ $errors->first('password') }}</strong>
			                    </span>
			                @endif
						</div>								
					</div>
					
					@if($errors->has('invalid_pwd'))
					<div class="form-group row">
						<h5 class="offset-md-4 col-md-4 text-md-left" style="color:#f00;">パスコードが間違っています。</h5>
					</div>
					@endif
					
				</div>	
				<div class="form-body">
					<div class="row">
						<div class="col-md-12">
							<button class="offset-md-4 btn btn-primary">送　信</button>
							<button type="button" class=" btn btn-danger" >キャンセル</button>
							<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
						</div>
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
			$('#pwd').focus();
			$('.btn-danger').click(function(){
				//location.reload();
				$("input").val('');
			});
		});
    </script>
@stop