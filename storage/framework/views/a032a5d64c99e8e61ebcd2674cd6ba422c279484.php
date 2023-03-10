

<?php $__env->startSection('styles'); ?>
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/login/login.css')); ?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/news.css')); ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>"> -->
    <style>
        .content1{
            /*background-color: #a0a0a0;*/
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
                $(".btn-register").removeClass('disabled');
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

    var count = 5, snapShotImg;

    $(".btn-rec").click(function(){
//        $(".btn-rec").css('background-color','#ff0000');
        $(".camera-image").attr("src", "");
        $(".camera-widget").removeClass("hide");
        $(".photo-image").addClass("hide");
        count = 5;
        countDown();
    });

    function countDown() {
        if(count > 0) {
            count--;
            setTimeout(function(){
                countDown();
            },1000);
            return;
        }
        snapShotImg = takeSnapshot();
//        $(".btn-rec").css('background-color','buttonface');
        $(".camera-image").attr("src", snapShotImg);
        $(".camera-widget").addClass("hide");
        $(".photo-image").removeClass("hide");
        $(".btn-register").addClass("hide");
        $(".btn-rec").addClass("hide");

        var info = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cameraImg: snapShotImg
            
        };
        var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/auth/faceSuccessAjax";
        $.ajax({
            type: "post",
            url: post_url,
            data: info,

            beforeSend: function (xhr) {
                var token = $('meta[name="csrf-token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function (response) {

                if(response.success == true){
                    $(".step1-title").addClass("hide");
                    $(".step2-title").removeClass("hide");
                    $(".step1-btn").addClass("hide");
                    $(".step2-btn").removeClass("hide");
                    $(".btn-register").addClass("hide");
                    $("#image_path").val(response.image_path);
                }
                else{
                    $(".step1-title").removeClass("hide");
                    $(".step2-title").addClass("hide");
                    $(".step1-btn").removeClass("hide");
                    $(".step2-btn").addClass("hide");
                    $(".btn-register").removeClass("hide");
                    $(".btn-rec").addClass("hide");
                    $(".err_txt").html("顔認識に失敗しました。もう一度行ってください。");
                    if(response.message == 'Server is not running!')
                        $(".err_txt").html("<?php echo e(config('consts')['MESSAGES']['FACE_SERVER_NO_STOP']); ?>");
                }
            }
        }); 
    }

    $(".btn-register").click(function() {
        /*$(".step1-title").addClass("hide");
        $(".step2-title").removeClass("hide");
        $(".step1-btn").addClass("hide");
        $(".step2-btn").removeClass("hide");*/
        $(".camera-image").attr("src", "");
        $(".camera-widget").removeClass("hide");
        $(".photo-image").addClass("hide");
        $(".step2-title").addClass("hide");
        $(".step1-title").removeClass("hide");
        $(".step2-btn").addClass("hide");
        $(".step1-btn").removeClass("hide");
        $(".btn-register").addClass("hide");
        $(".btn-rec").removeClass("hide");
        $(".err_txt").html("");
    });

    $(".btn-retry").click(function() {
//        $(".btn-rec").css('background-color','#ff0000');
        $(".camera-image").attr("src", "");
        $(".camera-widget").removeClass("hide");
        $(".photo-image").addClass("hide");
        $(".step2-title").addClass("hide");
        $(".step1-title").removeClass("hide");
        $(".step2-btn").addClass("hide");
        $(".step1-btn").removeClass("hide");
        $(".btn-register").addClass("hide");
        $(".btn-rec").removeClass("hide");
        $(".err_txt").html("");
    });

    $(".btn-ok").click(function() {
        $("#cameraImg").val(snapShotImg);
        $("#register_form").submit();
    });

    $(".btn-cancel").click(function() {
        history.go(-1);
    });
    $('body').addClass('page-full-width');
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container content1">
            <?php if(session('status')): ?>
            <div class="alert alert-success">
                <?php echo e(session('status')); ?>

            </div>
            <?php endif; ?>
            <form id="register_form" method="post" action="/auth/register_face">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="cameraImg" id="cameraImg" />
                <input type="hidden" name="book_id" value="<?php echo e($bookId); ?>" />
                <input type="hidden" name="image_path" id="image_path" value="" />
                <input type="hidden" name="password" value="<?php echo e(Auth::user()->r_password); ?>" />
                <input type="hidden" name="mode" value="<?php echo e($mode); ?>" />
                <input type="hidden" name="user_id" value="<?php echo e(Auth::id()); ?>" />
                <input type="hidden" name="type" value="2" />
                <div class="form-group row">
                    <p class="step1-title">
                        顔データの登録をします。「〇」を押すと、５秒後に撮影しますので、レンズを見てください。
                    </p>
                    <p class="step2-title hide">
                        この画像で登録します。よろしければ「OK」,もう一度撮影する場合は「再撮影」を押してください。
                    </p>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="camera-widget camera-placeh1older" align="center">
                            <video style="width:100%; height:100%;" autoplay="autoplay"></video>
                        </div>
                        <div class="photo-image hide" align="center">
                            <img style="width:100%; height:100%; border: 1px solid;" name="cameraImg" class="camera-image">
                        </div>
                    </div>
                </div>

                <div class="form-group row step1-btn">
                     <div class="row col-md-12" >
                        <div class="col-md-6 text-md-right col-xs-6" style="margin-bottom: 10px;text-align:right;">
                            <button type="button" class="btn btn-rec" style="border-radius: 300px !important; background-color: #ff0000;">　</button>
                            <button type="button" class="btn btn-warning btn-register hide">もう一度行う</button>
                        </div>
                        <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                            <button type="button" class="btn btn-info btn-cancel">戻　る</button>
                        </div>
                    </div>   
                </div>
                <div class="form-group row step2-btn hide">
                    <div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
                        <button type="button" class="btn btn-warning btn-ok" style="margin-bottom:8px">撮影した顔画像で登録</button>
                    </div>
                    <div class="col-md-6 text-md-left col-xs-6" style="text-align:left;">
                        <button type="button" class="btn btn-success btn-retry" style="margin-bottom:8px">再撮影</button>
                    </div>
                </div>
                
                <div class="form-group row face-failed">
                    <div class="col-md-12 text-md-center">
                        <p class="font-red err_txt"></p>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>