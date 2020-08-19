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
            $(".btn-verify").removeClass('disabled');
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

    $(".btn-failed").click(function(){
        $("#face").css('display','none');
        $("#failed_text").css('display','block');
    });

    $(".btn-retry").click(function(){
        $("#face").css('display','block');
        $("#failed_text").css('display','none');
    });

    $(".btn-prev").click(function(){
        history.go(-1);
    });

    $(".btn-verify").click(function(){
        $(".failed-alert").css('display','none');
        var mode = $("#mode").val();
        var info = {
            user_id: $("#user_id").val(),
            cameraImg: takeSnapshot(),
            login:"0",
            mode: mode,
            book_id: $("#book_id").val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            type: "post",
            url: "{{url('/auth/overseerface_verify_result')}}",
            data: info,

            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function (response){
                if(response.status == 'success'){
                    $(".verify_exit").css('display','block');
                    $(".btn-verify").addClass('disabled');
                    $(".btn-failed").addClass('disabled');
                    setTimeout(function(){
                        if(mode == 3){
                            $("#success_form").attr("action", "/book/test/success");
                            $("#success_form").submit();
                        }else{
                            $("#examinemethod").val(0);
                            $("#test-start-form").attr("action", "/book/test/start");
                            $("#test-start-form").submit();
                        }
                       // location.href='/book/test/start?book_id=' + $("#book_id").val() + '&password=' + $("#password").val();
                    },2000);
                } else if(response.status == 'failed') {
                    //  bootboxNotification(response.message)
                    $(".failed-alert").css('display','block');
                    //  setTimeout(function(){
                    //  location.href='/auth/login';
                    //  },2000);
                }
            },
            error: function (err) {                
                $(".failed-alert").css('display','block');
            }
        });
    });


    $(".btn-sendmail").click(function() {
        var info = {
            user_id: $("#user_id").val(),
            email: '{{$user->email}}',
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            type: "post",
            url: "{{url('/auth/face_verify_email')}}",
            data: info,

            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function (response){

                if(response.status == 'success'){
                    location.href='/';
                } else if(response.status == 'failed') {
                    //                      bootboxNotification(response.message)
                    $(".failed-alert").css('display','block');
                }
            },
            error: function (err) {
                $(".failed-alert").css('display','block');
            }
        });
    });
});
</script>
@endsection

@section('contents')
<input type="hidden" name="mode" id="mode" value="@if(isset($mode)){{$mode}}@endif"/>
<div class="login">
    <div class="logo">
        <a href="{{url('/')}}" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    </div>
    <div class="container content1">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form action="" method="post" id="test-start-form">
            {{csrf_field()}}
            <input type="hidden" name="book_id" id="book_id" value="{{$bookId}}"/>
            <input type="hidden" name="user_id" id="user_id" value="{{$userId}}"/>
            <input type="hidden" name="password" id="password" value="{{$password}}"/>
            <input type="hidden" name="examinemethod" id="examinemethod" value="">
        </form>
        @if(isset($mode))
            @if($mode==3)
                <form action="" method="post" id="success_form">
                    {{csrf_field()}}
                    <input type="hidden" name="book_id" id="book_id" value="{{$bookId}}"/>
                </form>
            @endif
        @endif
        <div id="face">
            <p>顔認識します。顔を枠の中に入れ、「顔認証」をクリックして、レンズを見てください。</p>
            <div class="form-group row" >
                <div class="col-md-12">
                    <div class="camera-widget camera-placeh1older" align="center">
                        <video style="width:100%; height:100%;" autoplay="autoplay"></video>
                    </div>
                </div>
            </div>
            <div class="form-group row" >
                <div class="col-md-12 text-md-right verify-exit hide">
                    <label class="control-label font-red">認証完了</label>
                </div>
            </div>
            <div class="form-group row" >
                <div class="col-md-2 text-md-left col-xs-3" style="text-align:left;">
                    <button type="button" class="btn btn-info btn-prev" style="margin-bottom:8px;">戻　る</button>
                </div>
                <div class="col-md-2 text-md-center col-xs-3" style="text-align:center;">
                    <button type="button" class="btn btn-warning btn-verify" style="margin-bottom:8px;">顔認証</button>
                </div>
                <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                    <button type="button" class="btn btn-success btn-failed" style="margin-bottom:8px;">顔認証エラーになる場合</button>
                </div>
                </div>
            <div class="form-group row">
                <div class="col-md-12 text-md-center failed-alert" style="display: none;">
                    <span class="font-red"><br>顔認識に失敗しました。もう一度行ってください。</span>
                </div>
            </div>
        </div>

        <div id="failed_text" style="display: none;">
            <div class="form-group row" >
            <label class="offset-md-1 control-label">
                顔認証ができませんでした。<br>
                つきましては、顔認証再登録のため、本人確認をさせていただきます。<br>
                下記の「送信」ボタンを押すと、ご登録のメールアドレス宛に、顔認証再設定案内を送付します。<br>
                再登録終了後は、読Qトップ画面に戻ります。
            </label>
            </div>

            <div class="form-group row" >
                <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                    <button type="button" class="btn btn-warning btn-sendmail"  style="margin-bottom:8px">送　信</button>
                </div>
                <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                    <button type="button" class="btn btn-success btn-retry">もう一度顔認証する</button>
                </div>
            </div>
            <div class="form-group row" >
                <div class="col-md-12 text-md-right">
                    <a href="{{url('/')}}" class="btn btn-info">読Qトップに戻る</a>
                </div>
            </div>
            
        </div>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>
@endsection
