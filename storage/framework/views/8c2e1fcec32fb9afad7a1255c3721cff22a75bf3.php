

<?php $__env->startSection('styles'); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
        <?php if($user->isPupil() && $user->active == 1): ?>
            $("#pupil_failed_text").css('display','block');
        <?php else: ?>
            $("#failed_text").css('display','block');
        <?php endif; ?>
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
        $("#verify_form").attr("method", "post")
        $("#verify_form").attr("action",'<?php echo e(url("/auth/signin_teacher")); ?>');
        $("#verify_form").submit();
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
            url: "<?php echo e(url('/auth/face_verify_result')); ?>",
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
                        //location.href='/mypage/edit_info';
                        $("#verify_form").attr("action", "/mypage/edit_info");
                        $("#verify_form").submit();
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
                alert("error");
                $(".failed-alert").css('display','block');
            }
        });
    });

    $(".btn-sendmail").click(function() {
        var info = {
            user_id: $("#user_id").val(),
            email: '<?php echo e($user->email); ?>',
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        $.ajax({
            type: "post",
            url: "<?php echo e(url('/auth/face_verify_email')); ?>",
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
<div class="login">
    <div class="logo">
        <a href="<?php echo e(url('/')); ?>" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    </div>
    <div class="container content1">
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>
        <form id="verify_form" method="post" action="/auth/verify_face_result">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="user_id" id="user_id" value="<?php echo e($userId); ?>"/>
            <input type="hidden" name="cameraImg" id="cameraImg"/>
            
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
                        <label class="control-label font-red" <?php if(isset($user) && $user->active >= 3): ?> disabled <?php endif; ?>>認証完了</label>
                    </div>
                </div>
                <div class="form-group row" >
                    <div class="col-md-3 text-md-left col-xs-3" style="text-align:left;">
                        <button type="button" class="btn btn-info btn-prev">戻　る</button>
                    </div>
                    <div class="col-md-3 text-md-center col-xs-3" style="text-align:center;">
                        <button type="button" class="btn btn-warning btn-verify" <?php if(isset($user) && $user->active >= 3): ?> disabled <?php endif; ?>>顔認証</button>
                    </div>
                    <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                        <button type="button" class="btn btn-success btn-failed"  <?php if(isset($user) && $user->active >= 3): ?> disabled <?php endif; ?>>顔認証エラーになる場合</button>
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
                        <button type="button" class="btn btn-warning btn-sendmail" >送　信</button>
                    </div>
                    <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                        <button type="button" class="btn btn-success btn-retry" >もう一度顔認証する</button>
                    </div>
                </div>
                <div class="form-group row" >
                    <div class="col-md-12 text-md-right">
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップに戻る</a>
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
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップに戻る</a>
                </div>
            </div>
        </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>