@extends('auth.layout')

@section('styles')

<style>
	.content1{
		background-color: #eceef1;
		border-radius: 7px !important;
		margin: 0px auto 10px auto;
		padding: 30px;
		overflow: hidden;
		position: relative; 
		max-width: 800px !important;
	}
	
	.logo{
		margin-top: 0px !important;	
	}
}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $("#phone").inputmask("mask", {
        "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
    });
    
    $(".btn_next").click(function() {
        var firstname = $("#firstname").val();
        var lastname = $("#lastname").val();

        if(firstname != "" && lastname != ""){
            $("#verify_form").submit();
        } else {
            if(firstname == ""){
                $("#firstname-container").addClass("has-danger");
                $("#firstname-container .form-control-feedback").removeClass("hidden");
                $("#firstname-container input").focus();
                return;
            } else {
                $("#firstname-container").removeClass("has-danger");
                $("#firstname-container .form-control-feedback").addClass("hidden");
            }

            if(lastname == "") {
                $("#lastname-container").addClass("has-danger");
                $("#lastname-container .form-control-feedback").removeClass("hidden");
                $("#lastname-container input").focus();
            }else{
                $("#lastname-container").removeClass("has-danger");
                $("#lastname-container .form-control-feedback").removeClass("hidden");
            }
        }
    });
});
</script>
@endsection

@section('contents')
<div class="login">
    <div class="logo">
        <a href="{{url('/')}}" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    </div>
    <div class="container content1">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span>
                   お名前が違います。
                </span>
            </div>
        @endif
         @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="verify_form" method="post" action="/auth/forgot_pre_face_verify">
            {{ csrf_field() }}
            <div id="names" style="display: block;">
                <p style="font-size:14px">
    		        顔認証登録があると、お名前やその他の入力と顔認証によって、読Qネームやパスワードを取り戻すことが出来る場合があります。（情報が古い場合など、認証ができないこともあります。）
    			    下記に入力し、「顔認証」ボタンを押してください。
                </p>
                
                <div class="form-group row">
                	<div id="firstname-container" class="col-md-8">
    	            	<label class="control-label col-md-6 text-md-left">お名前（漢字）　姓</label>
    	            	<div class="col-md-5">
                            <input type="text" name="firstname" class="form-control" id="firstname">
    	            		<span class="form-control-feedback hidden">
    							<span>入力してください。</span>
    						</span>
    	            	</div>
                	</div>
                	<div id="lastname-container" class="col-md-4">
    	            	<label class="control-label col-md-1 text-md-right">名</label>
    	            	<div class="col-md-10">
    	            		<input type="text" name="lastname" class="form-control" id="lastname">
    	            		<span class="form-control-feedback hidden">
    							<span>入力してください。</span>
    						</span>
    	            	</div>
                	</div>
                </div>
                
                <div class="form-group row">
                	<div id="phone-container" class="col-md-8">
                        <label class="control-label col-md-6 text-md-left">登録電話番号（わかれば）</label>
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control" id="phone">
                        </div>
                	</div>
                	<label class="control-label col-md-4 text-md-left">（半角英数字でハイフン無し）</label>
                </div>
                
                <div class="form-group row">
                	<div id="email-container" class="col-md-8">
                        <label class="control-label col-md-6 text-md-left">登録Eメールアドレス（わかれば）</label>
                        <div class="col-md-6">
                            <input type="text" name="email" class="form-control" id="email">
                        </div>
                	</div>
                	<label class="control-label col-md-4">（半角英数字）</label>
                </div>
                
                <div class="form-group row">
                	<div class="col-md-6 text-md-left">
                		<a href="{{url("/")}}" class="btn btn-info">読Qトップに戻る</a>
                	</div>
                	<div class="col-md-6 text-md-right">
                		<button type="button" class="btn btn-success btn_next">顔認証</button>
                	</div>
                </div>
                
                <p style="font-size:14px">
    			    認証されると、マイ書斎内の 基本情報編集画面になります。
    			    パスワード、読QネームやEメールアドレスをメモしてください。また必要であれば変更してください。
                </p>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>
@endsection
