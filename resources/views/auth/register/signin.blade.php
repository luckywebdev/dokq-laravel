@extends('layout')
@section('styles')

@stop

@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">パスワード入力</h3><br>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" action="{{url('/auth/signin')}}" method="post">
						{{csrf_field()}}
		                <input type="hidden" name="refresh_token" value="{{$user->refresh_token}}" />
		                <input type="hidden" name="type" value="{{$type}}" />
						
						<div class="form-body">
							<div class="form-group row">
								<label class="offset-md-2 col-md-3 control-label">
									パスワード入力
								</label>
								<div class="col-md-3">
									<input type="password" class="form-control" name="password" id="password" value="" >
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
										<!--
										<h5 class="offset-md-5 col-md-4 text-md-left" style="color:#f00;">
											 パスワードを忘れた方は、
											<a href="{{url('/book/test/forget_pwd')}}" class="font-blue-madison">こちら</a>
										</h5>
										-->
									</div>
								@endif
							
						</div>	
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<button class="offset-md-5 btn btn-primary">送　信</button>
									<button type="button" class=" btn btn-danger" >キャンセル</button>
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
	   	$('#password').val('');
			$('body').addClass('page-full-width');
			$('.btn-danger').click(function(){
				//location.reload();
				$("input").val('');
			});
		});
    </script>
@stop