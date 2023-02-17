@extends('layout')

@section('styles')
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
	            	<a href="{{url('/mypage/main_info')}}">
	                	 > 基本情報
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	> 監修者になる
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			@if(count($errors) > 0)
                @include('partials.alert', array('errors' => $errors->all()))
            @endif
			<h3 class="page-title">監修者になる</h3>

			<div class="row" style="margin-top:50px;">
				<div class="offset-md-2 col-md-8">
					<p>監修者になるには、自己推薦文を入力し、教員免許状、学士などの資格証の画像を送っていただく必要があります。</p>
					<p>読Qの監修者採用規定外の場合でも、自己推薦をしていただき、読Q側で承認すれば、監修者になれます。</p>
					<p>送信いただきましたら、承認の可否を2日以内に協会からメールでご連絡いたします。</p>
					<p>承認後は、読Qネーム末尾に「k」をつけてログインして下さい。</p>
				</div>
			</div>
			
			<form enctype="multipart/form-data" class="form form-horizontal" action="{{url('/mypage/update_userinfo')}}" method="post" id="form1">
				{{csrf_field()}}
				<input type="hidden" name="beforefile" id="beforefile" value="{{isset($beforefile) ? $beforefile : ''}}">
				<input type="hidden" name="beforefilename" id="beforefilename" value="{{isset($beforefilename) ? $beforefilename : ''}}">
	
				<div class="form-group row">
					<div class="offset-md-2 col-md-8">
						<textarea  required id="recommend_content" class="form-control" name="recommend_content" maxlength="200" rows="5" placeholder="自己推薦文入力　200字以内">{{old('recommend_content')!=""? old('recommend_content') : (isset($user->recommend_content) ? $user->recommend_content : '')}}</textarea>
					</div>
				</div>

				<div class="form-group row">
					<div class="offset-md-2 col-md-8">
						<label class="control-label col-md-2 text-md-right">資格証</label>
				    	<div class="col-md-4">
					    	<div class="fileinput @if((isset($user->authfile) && $user->authfile != '')|| old('authfile')) fileinput-exists @else fileinput-new @endif" data-provides="fileinput" style="margin-bottom: 0px;">
								<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
								<span class="fileinput-new">ファイルを選択</span>
								@if((!isset($success) || isset($success) && $success != 1) && (isset($fail) && $fail == 1))
								<span class="fileinput-exists">ファイルを選択</span>
								@else
								<span class="fileinput-exists">変　更</span>
								@endif
								<input type="file" name="authfile" id="authfile" value="{{isset($user->authfile) && isset($user->recommend_flag) && $user->recommend_flag == 1 ?  $user->authfile : ''}}" class="form-control" >
								</span>
								<span class="fileinput-filename">
								</span>
								&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">キャンセル
								</a>
								@if ($errors->has('authfile'))
                                <span class="form-control-feedback">
                                    <span>{{ $errors->first('authfile') }}</span>
                                </span>
                                @endif
							</div>
						</div>
						<button type="button" class="btn btn-primary pull-right" id="submit_btn">送　信</button>
					</div>
				</div>
			</form>
			
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
 <script type="text/javascript" src="{{asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.fileinput-filename').text($("#beforefile").val());

			@if(isset($completed) && $completed == true)
				bootboxNotification('送信しました');
			@endif
			$("#submit_btn").click(function(){
				$("#form1").submit();				
			});
		});
	</script>
@stop