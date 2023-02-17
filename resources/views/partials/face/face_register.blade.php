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
		max-width: 530px !important;	
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

		var video = document.querySelector('video'), canvas;

		if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // access the web cam
            navigator.mediaDevices.getUserMedia({ video: true })
            // permission granted:
              .then(function (stream) {
                  //video.src = window.URL.createObjectURL(stream);
                try {
                  video.srcObject = stream;
                } catch (error) {
                  video.src = window.URL.createObjectURL(stream);
                }
                  
                $(".camera-widget").removeClass('camera-placeholder');
                $("#btn_verify").removeClass('disabled');
              })
              // permission denied:
              .catch(function (error) {
                  alert('カメラにアクセスできません。');
              });
        } else {
            alert('お使いのブラウザのバージョンではHTML5がサポートされていないため、正しく動作しません。ブラウザのバージョンをアップグレードしてから再度お試しください。');
        }		

		function takeSnapshot() {
            var img = document.querySelector('img') || document.createElement('img');
            var context;
            var width = video.offsetWidth
              , height = video.offsetHeight;

            canvas = canvas || document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;

            context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, width, height);
            
            img.src = canvas.toDataURL('image/jpeg');
            return img.src;
        }

         $("#btn_exit").click(function(){
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();            

            if(firstname != "" && lastname != ""){      
                
                $("#cameraImg").val(takeSnapshot());
                $("#verify_form").submit();         
            }else {
                if(firstname == ""){
                    $("#firstname-container").addClass("has-danger");
                    $("#firstname-container .form-control-feedback").removeClass("hidden");
                    $("#firstname-container input").focus();
                    return;
                }else{
                    $("#firstname-container").removeClass("has-danger");
                    $("#firstname-container .form-control-feedback").addClass("hidden");
                }

                if(lastname == ""){
                    $("#lastname-container").addClass("has-danger");
                    $("#lastname-container .form-control-feedback").removeClass("hidden");
                    $("#lastname-container input").focus();
                }else{
                    $("#lastname-container").removeClass("has-danger");
                    $("#lastname-container .form-control-feedback").removeClass("hidden");
                }
            }           
        });
       

    
     $("#btn_next").click(function(){   

            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val(); 
            
            if(firstname != "" && lastname != ""){      
                 $("#names").css('display','none');
                 $("#face").css('display','block');       
            }else {
                if(firstname == ""){
                    $("#firstname-container").addClass("has-danger");
                    $("#firstname-container .form-control-feedback").removeClass("hidden");
                    $("#firstname-container input").focus();
                    return;
                }else{
                    $("#firstname-container").removeClass("has-danger");
                    $("#firstname-container .form-control-feedback").addClass("hidden");
                }

                if(lastname == ""){
                    $("#lastname-container").addClass("has-danger");
                    $("#lastname-container .form-control-feedback").removeClass("hidden");
                    $("#lastname-container input").focus();
                }else{
                    $("#lastname-container").removeClass("has-danger");
                    $("#lastname-container .form-control-feedback").removeClass("hidden");
                }
            }
        });
     $("#btn_failed").click(function(){   

            $("#names").css('display','none');
            $("#face").css('display','none');       
            $("#failed_text").css('display','block');       
        });
     $("#btn_prev").click(function(){   

            $("#names").css('display','none');
            $("#face").css('display','block');       
            $("#failed_text").css('display','none');       
        });

     $("#btn_verify").click(function(){        
            $("#failed_alert").css('display','none');
            var info = {
                firstname: $("#firstname").val(),
                lastname: $("#lastname").val(),
                email: $("#email").val(),
                phone:$("#phone").val(),
                cameraImg: takeSnapshot(),
                login:"0",
                _token: $('meta[name="csrf-token"]').attr('content')
            } 
            // alert(takeSnapshot());   
            $.ajax({
                type: "post",
                url: "{{url('/auth/faceverify')}}",
                data: info,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }                    
                },          
                success: function (response){
                    alert("1234");
                    // alert(response.status);   
                    if(response.status == 'success'){
                        $("#btn_exit").removeClass('disabled');   
                        $("#btn_exit").css('display','block');   
                        $("#btn_verify").addClass('disabled');
                        $("#btn_failed").addClass('disabled');
                         $("#verify_form").submit();  
                        // location.href='/auth/facelogin';
                    }else if(response.status == 'failed'){
//                      bootboxNotification(response.message)
                        $("#failed_alert").css('display','block');
                    }
                    
                }
            }); 
        });

    });


        
</script>
@endsection

@section('contents')
<div class="login">
    <div class="logo">
        <a href="{{url('/')}}" style="color:white; font-family: HGP明朝B;">読Q</a>
    </div>
    <div class="container content1">
         @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form id="verify_form" method="post" action="/auth/facelogin">
            {{ csrf_field() }}
            <input type="hidden" name="cameraImg" id="cameraImg"/>
            
            <div id="face" style="display: none;">
                <p>顔認識します。「顔認証」をクリックして、レンズを見てください。</p>
                <div class="form-group row" >
                    <div class="col-md-12">
                        <div class="camera-widget camera-placeh1older" align="center">
                            <video style="width:100%; height:90%;" autoplay="autoplay"></video>
                        </div>
                    </div>
                </div>
               <!--  <div class="col-md-6 text-md-right">
                        <button type="button" class="btn btn-success" id="btn_verify">認証</button>
                </div>
                <div class="col-md-6 text-md-right">
                        <button type="button" class="btn btn-success disabled " id="btn_exit">認証完了</button>
                </div>
                 
                <div class="col-md-12 text-md-right" style="margin-top: 20px">
                        <a type="button" class="btn btn-success" id="btn_failed">顔認証エラーになる場合</a>
                </div>
                <div class="col-md-6 text-md-right" id="failed_alert" style="display: none;">
                      <p><br>顔認識に失敗しました。もう一度行ってください。</p>
                </div> -->
               
                <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                        <button style = "border-radius:200px; height:35px; width:35px; background-color:red; border-color:red;" type="button" class="btn btn-success" id="btn_verify"></button>
                </div>
                <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                        <a style=" display: none;" type="button" class="btn disabled btn-danger" id="btn_exit">認証完了</a>
                </div>
                <div class="col-md-12 text-md-right col-xs-12" style="margin-top: 20px;text-align:right;">
                        <a type="button" class="btn btn-success" id="btn_failed">顔認証エラーになる場合</a>
                </div>
                <div class="col-md-6 text-md-right col-xs-6" id="failed_alert" style="display: none;text-align:right;">
                      <p><br>顔認識に失敗しました。もう一度行ってください。</p>
                </div>
            </div>

            <div id="names" style="display: block;">    
                <p>
    		                 顔認証登録があると、お名前やその他の入力と顔認証によって、読Qネームやパスワードを取り戻すことが出来る場合があります。（情報が古い場合など、認証ができないこともあります。）
    			      下記に入力し、「顔認証」ボタンを押してください。
                </p>               
                
                <div class="form-group row">
                	<div id="firstname-container">
    	            	<label class="control-label col-md-5 text-md-left">お名前（漢字）　姓</label>
    	            	<div class="col-md-7">
    	            		<input type="text" name="lastname" class="form-control" id="lastname">
    	            		<span class="form-control-feedback hidden">
    							<span>入力してください。</span>
    						</span>
    	            	</div>	            	
                	</div>
                	<div id="lastname-container">
    	            	<label class="control-label col-md-1 text-md-right">名</label>
    	            	<div class="col-md-10">
                            <input type="text" name="firstname" class="form-control" id="firstname">      		
    	            		<span class="form-control-feedback hidden">
    							<span>入力してください。</span>
    						</span>
    	            	</div>
                	</div>
                </div>
                
                <div class="form-group row">
                	<label class="control-label col-md-3 text-md-left">登録電話番号<br>（わかれば）</label>
                	<div class="col-md-3">
                		<input type="text" name="phone" class="form-control" id="phone">
                	</div>
                	<label class="control-label col-md-6 text-md-left">（半角英数字でハイフン無し）</label>
                </div>
                
                <div class="form-group row">
                	<label class="control-label col-md-3 text-md-left">登録Eメールアドレス<br>（わかれば）
                	</label>
                	<div class="col-md-3">
                		<input type="text" name="email" class="form-control" id="email">
                	</div>
                	<label class="control-label col-md-6">（半角英数字）</label>
                </div>
                
                <div class="form-group row">
                	<div class="col-md-6 text-md-left">
                		<a href="{{url('auth/forgot_pwd')}}" class="btn btn-info">戻　る</a>
                	</div>
                	<div class="col-md-6 text-md-right">
                		<button type="button" class="btn btn-success" id="btn_next">顔認証</button>
                	</div>            	
                </div>
                
                <p>
    			            認証されると、マイ書斎内の 基本情報編集画面(7.5b)になります。
    			パスワード、読QネームやEメールアドレスをメモしてください。また必要であれば変更してください。            
                </p>
            </div>

            <div id="failed_text" style="display: none;">
                <p>
                    顔認証ができませんでした。
                    つきましては、顔認証再登録のため、本人確認をさせていただきます。<br>
                    下記の「送信」ボタンを押すと、ご登録のメールアドレス宛に、<br>
                    顔認証再設定案内を送付します。
                    再登録終了後は、T.2 読Qトップ画面に戻ります。
                </p>
                <div class="col-md-6 text-md-right" style="margin-top: 20px">
                        <a href="{{url('/')}}" type="button" class="btn btn-success" >送信</a>
                </div>
                <div class="col-md-6 text-md-right">
                        <button type="button" style="margin-top: 20px" id="btn_prev" class="btn btn-success" >もう一度顔認証する</button>
                </div>
                <div class="col-md-12 text-md-right">
                        <a href="{{url('/')}}" type="button" class="btn btn-success" style="margin-top: 20px">読Qトップに戻る</a>
                </div>             
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>
@endsection
