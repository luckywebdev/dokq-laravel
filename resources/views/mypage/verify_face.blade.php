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
        $("#failed_text").css('display','none');
        $("#pupil_failed_text").css('display','none');
        @if(Auth::user()->isPupil() && Auth::user()->active == 1)
            $("#pupil_failed_text").css('display','block');
        @else
            $("#failed_text").css('display','block');
        @endif
    });

    $(".btn-retry").click(function(){
        $("#face").css('display','block');
        $("#failed_text").css('display','none');
        $("#pupil_failed_text").css('display','none');
    });

    $(".btn-prev").click(function(){
        history.go(-1);
    });

    $(".btn-next").click(function(){
        $("#face_form").attr("method", "post")
        $("#face_form").attr("action",'{{url("/mypage/signin_teacher")}}');
        $("#face_form").submit();
    });

    $(".btn-verify").click(function(){
        $(".failed-alert").css('display','none');
        var info = {
            user_id: $("#user_id").val(),
            cameraImg: takeSnapshot(),
            login:"0",
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            type: "post",
            url: "{{url('/auth/face_verify_result')}}",
            data: info,
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function (response){
                console.log("--token--", token);

                console.log(response);
                if(response.status == 'success'){
                    $(".verify_exit").css('display','block');
                    $(".btn-verify").addClass('disabled');
                    $(".btn-failed").addClass('disabled');
                    setTimeout(function(){
                        @if($index == 1)
                            $("#face_form").attr("action", "/mypage/payment");
                        @elseif($index == 2)
                            $("#face_form").attr("action", "/mypage/edit_info");
                        @elseif($index == 3)
                            $("#face_form").attr("action", "/auth/escape_group");
                        @endif
                        
                        $("#face_form").submit();
                    },2000);
                } else if(response.status == 'failed') {
                    //                      bootboxNotification(response.message)
                    $(".failed-alert").css('display','block');
//                    setTimeout(function(){
//                        location.href='/auth/login';
//                    },2000);
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
                console.log(response);
                if(response.status == 'success'){
                    location.href='/';
                } else if(response.status == 'failed') {
                    //bootboxNotification(response.message)
                    $('#myfailedModal').modal('show');
                }
            },
            error: function (err) {
                $('#myfailedModal').modal('show');
            }
        });
    });
});
</script>
@endsection

@section('contents')
<div class="login">
    <div class="logo">
        <a href="{{url('/')}}" style="color:white; font-family: 'Judson', 'Maven Pro', sans-serif !important, HGP明朝B;">読Q</a>
    </div>
    <div class="container content1">
    <form class="form form-horizontal" action="" method="post" id="face_form">
        {{csrf_field()}}
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <input type="hidden" name="user_id" id="user_id" value="{{$userId}}"/>
        <input type="hidden" name="cameraImg" id="cameraImg"/>
        <input type="hidden" id="email" name="email" value="{{$user->email}}">
        <input type="hidden" id="index" name="index" value="{{$index}}">
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
                <div class="col-md-3 text-md-left col-xs-3" style="text-align:left;">
                    <button type="button" class="btn btn-info btn-prev" style="margin-bottom:8px;">戻　る</button>
                </div>
                <div class="col-md-3 text-md-center col-xs-3" style="text-align:center;">
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
            <label class="offset-md-1 ">
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
        <div id="pupil_failed_text" style="display: none;">
            <div class="form-group row" >
            <label class="offset-md-1 control-label  text-md-left">
                顔認証ができませんでした。<br>
                つきましては、顔認証を再登録します。<br>
                下記の「次へ」ボタンを押すと、教師パスワード入力画面になり、その後 顔認証登録画面へ移ります。
            </label>
            </div>
            <div class="form-group row" >
                <div class="col-md-6 text-md-right">
                    <button type="button" class="btn btn-warning btn-next"  style="margin-bottom:8px">次 へ</button>
                </div>
                <div class="col-md-6 text-md-right">
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
    </form>
    </div> 
    <div class="modal fade" id="myfailedModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><strong>エラー</strong></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>{{config('consts')['MESSAGES']['EMAIL_SERVER_ERROR']}}</p>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
            </div>
          </div>
        </div>
      </div>   
</div>
@endsection
