@extends('auth.layout')


@section('contents')
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][0];
	$purposes = config('consts')['USER']['PURPOSE'][0];
?>
<div class="container register">
	<div class="form">
		<form class="form-horizontal" method="post" role="form" action="{{url('/auth/register/enterdetaildata')}}" enctype="multipart/form-data">
			<input tye="hidden" name="refresh_token" value="{{$user->refresh_token}}"/>
			<input type="hidden" id="email" name="email" value="{{$user->email}}">
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="{{url('/')}}">
						<img class="logo_img" src="{{ asset('img/logo_img/logo_reserve_2.png') }}">
                        <!-- <h1 style="margin: 0 !important; font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
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
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>						
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 66%;">
						</div>
					</div>				
				</div>
			</div>

			<h3 class="text-md-center">
			読Q{{config('consts')['USER']['TYPE'][$type]}}{{$type == 2 ? '候補' :''}}会員本登録
			</h3>
			@if(count($errors) > 0)
				@include('partials.alert', array('errors' => $errors->all()))
			@endif
			{{ csrf_field() }}
			<table class="table table-bordered">
			    <tbody class="text-md-center">
			    	@if($user->role == 3)
				    	<tr class="info">
					        <td>ペンネーム</td>				        
					        <td>ふりがな</td>				        
				      	</tr>
				        <tr>
					        <td>
					        	{{$user->firstname_nick}} {{$user->lastname_nick}}
					        </td>
					        <td >
					        	{{$user->firstname_nick_yomi}} {{$user->lastname_nick_yomi}}
					        </td>				       
				      	</tr>
				      	
				    @endif

			 		<tr class="info">
				        <td>氏名</td>
				        <td>ふりがな</td>
				        <td>性別</td>
				        <td>生年月日</td>
				        <td>本人ﾒｰﾙｱﾄﾞﾚｽ</td>
					</tr>
			        <tr>
				        <td>
				        	{{$user->firstname}} {{$user->lastname}}
				        </td>
				        <td>
				        	{{$user->firstname_yomi}} {{$user->lastname_yomi}}
			        	</td>
				        <td>
				        	{{config('consts')['USER']['GENDER'][$user->gender] }}
				        </td>
				        <td>
				        	{{$user->birthday}}
				        </td>
				        <td>
				        	{{$user->email}}
				        </td>
			      	</tr>
			        <tr class="info">
				        <td>ローマ字</td>
				        <td colspan="2">住所</td>
				        <td>電話番号</td>
				        <td>所属１</td>
			      	</tr>
			        <tr>
				        <td>
				        	{{$user->firstname_roma}} {{$user->lastname_roma}}
				        </td>
				        <td colspan="2">〒
				        	{{$user->address4}} ―
				        	{{$user->address5}}
				        	{{$user->address1}}
				        	{{$user->address2}}
				        	{{$user->address3}}
				        	{{$user->address6}} 
				        	@if($user->address7 !== null || $user->address7 != "") ―@endif
				        	{{$user->address7}} 
				        	@if($user->address8 !== null || $user->address8 != "") ―@endif
				        	{{$user->address8}} 
				        	@if($user->address9 !== null || $user->address9 != "") ―@endif
				        	{{$user->address9}}
				        	@if($user->address10 !== null || $user->address10 != "") ―@endif
				        	{{$user->address10}}
				        </td>
				        <td>
				        	{{$user->phone}}
				        </td>
				        <td>
				        	{{$user->group_name}}
			        	</td>
			      	</tr>
			    </tbody>
			</table>

		    <div class="form-group row">
		    	<label class="control-label col-md-2 text-md-right">読Qネーム:</label>
			    <div class="col-md-2">
			    	<input type="text" id="username" name="username" class="form-control" value="{{$user->username}}" disabled>
			    </div>
				<label class="control-label col-md-2 text-md-left label-after-input" style="color:red">※読Qが指定した固有番号です。</label>

		    	<label class="control-label col-md-2 text-md-right"></label>
			    <div class="col-md-4 sm-12">
			    	<a href="{{url('/choose_payment')}}" class="btn btn-danger">会費支払い方法の選択</a>

			    	<span class="form-text " style="color:red">※会費の引き落とし方法を入力いただきますが、<br/>無料期間内に退会すれば、引き落とされません。</span>
			    </div>
			</div>

			<div class="form-group row {{ $errors->has('password') ? ' has-danger' : '' }}">
			    <label class="control-label col-md-2 text-md-right">パスワード:</label>
			    <div class="col-md-4">
			    	<input type="password" id="password" name="password" class="form-control" value="" required>
			    	<label class="control-label"><input type="checkbox" id="show_pwd" class="form-control">表示する</label>
			    	@if ($errors->has('password'))
					<span class="form-control-feedback">
						<span>{{ $errors->first('password') }}</span>
					</span>
					@endif
			    	<span class="help-block" style="color:red">
					    ※8文字以上の半角英数を入力してください。これも各会員固有の文字列です。<br>
					    既に使われている場合使用できません。<br>
					    <strong>入力したら必ず控えてください。</strong>
					</span>
			    </div>
				    
	    		<label class="control-label col-md-2 text-md-right">本人確認書類アップロード:</label>
		    	<div class="col-md-4">
			    	<div class="fileinput fileinput-new" data-provides="fileinput">
						<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
						<span class="fileinput-new">ファイルを選択</span>
						<span class="fileinput-exists">変更</span>
						<input type="file" name="authfile" required>
						</span>
						<span class="fileinput-filename">
						</span>
						&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
						</a>
						@if ($errors->has('filemaxsize'))
                        <span class="form-control-feedback">
                            <span>{{ $errors->first('filemaxsize') }}</span>
                        </span>
                        @endif
					</div>
				<!--
					<a href="#" class="btn btn-warning" style="margin-bottom: 10px">スマートフォンの画像を選択</a>
				-->
					<span class="form-text">
						<a href="{{url('/security')}}" class="caption-subject theme-font bold uppercase"> 個人情報保護方針はこちら</a>
					</span>
					<span class="form-text " style="color:red;font-size:10px">※入力の途中でクリックすると、入力内容が消去されますのでご注意ください。</span>
				</div>	    
			</div>
			
			<div class="form-group row">

			    @if($user->isAuthor() || $user->isOverseer())
	    		<label class="control-label col-md-3 text-md-right">
	    		@if($user->isAuthor())
	    			著書画像、著者照合画像等アップロード:
    			@else
    				資格書類アップロード:
    			@endif
    			</label>
		    	<div class="col-md-4">
			    	<div class="fileinput fileinput-new" data-provides="fileinput">
						<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
						<span class="fileinput-new">ファイルを選択</span>
						<span class="fileinput-exists">変更</span>
						<input type="file" name="certificatefile" required>
						</span>
						<span class="fileinput-filename">
						</span>
						&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
						</a>
						@if ($errors->has('filemaxsize1'))
                        <span class="form-control-feedback">
                            <span>{{ $errors->first('filemaxsize1') }}</span>
                        </span>
                        @endif
					</div>
				<!--
			    	<a href="#" class="btn btn-warning" style="margin-bottom: 10px">スマートフォンの画像を選択</a>
			    -->
			    </div>
			   	@endif
			</div>
				
			<div class="form-group form-actions row">
				
				<div class="offset-md-4 col-md-4 text-md-center col-sm-12" style="margin-bottom:8px">
					<button type="submit" class="btn btn-success">上記内容で登録する</button>
				</div>
				<div class="col-md-4 text-md-right col-sm-12" style="margin-bottom:8px">
					<a href="{{url('/')}}" class="btn btn-info">読Qトップへ戻る</a>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
@stop

@section('scripts')
<script type="text/javascript">
	var isChecked = false;
	$(".form-horizontal:first").submit(function(){
	    if (isChecked) return true;
		var params = "username=" + $("#username").val() + "&password=" + $("#password").val();
		$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/user/duppasswordcheck?" + params,
			function(data, status){
				if(data.result=="len"){
	        		$("#alert_text").html("{{config('consts')['MESSAGES']['PASSWORD_LENGTH']}}");
	        		$("#alertModal").modal();
	        		$("#password").select();
				} else if(data.result=="dup"){
	        		$("#alert_text").html("{{config('consts')['MESSAGES']['PASSWORD_EXIST']}}");
	        		$("#alertModal").modal();
	        		$("#password").select();
	        	} else {
	        	    isChecked = true;
	        		$(".form-horizontal").submit();
	        	}
			});
		return false;
	});
	$("#show_pwd").change(function() {
	    if($(this).attr("checked")) {
	        $("#password").attr("type", "text");
	    } else {
	        $("#password").attr("type", "password");
	    }
	});
</script>
@stop