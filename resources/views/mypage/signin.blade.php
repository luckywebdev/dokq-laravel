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
					> <a href="{{url('mypage/top')}}">マイ書斎</a>
				</li>
				<li class="hidden-xs">
					> パスワード入力
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">パスワード入力</h3><br>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" action="{{url('/mypage/signin')}}" method="post">
						{{csrf_field()}}
						<input type="hidden" id="index" name="index" value="{{$index}}">
						<div class="form-body">
							<div class="form-group row">
								<label class="offset-md-2 col-md-3 control-label">パスワード入力</label>
								<div class="col-md-3">
									<input type="password" class="form-control" name="password" id="password">
									@if ($errors->has('password'))
					                    <span class="help-block">
					                        <strong>{{ $errors->first('password') }}</strong>
					                    </span>
					                @endif
								</div>								
							</div>
                            @if($errors->has('invalid_pwd'))
                            <div class="form-group row">
                                <h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">パスワードが間違っています。</h5>
                                <h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">
                                    パスワードを忘れた方は、
                                    <a href="{{url('/book/test/forget_pwd')}}" class="font-blue-madison">こちら</a>
                                </h5>
                            </div>
                            @endif
						</div>	
						<div class="form-body">
							<div class="row">
								<div class="col-md-7 text-md-right">
									<button class="offset-md-5 btn btn-primary">送　信</button>
									<button type="button" class="btn btn-danger">キャンセル</button>
								</div>
								<div class="col-md-5">
									<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
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
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
			$('.btn-danger').click(function(){
				location.reload();
			});
		});
    </script>
@stop