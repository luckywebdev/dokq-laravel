

<?php $__env->startSection('styles'); ?>
    <style type="text/css">
        th {
            background-color: #4CAF50;
            color:white;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="breadcum">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo e(url('/')); ?>">
                            読Qトップ
                        </a>
                    </li>
                    <li class="hidden-xs">
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > お問合せ対応
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="page-head">
				<div class="page-title">
					<h3>読Qへお問合せ
                        <?php if(isset($message)): ?>
                        <button type="button" class="btn btn-warning del_sel pull-right">削 除</button>
                        <?php endif; ?>
                    </h3>
				</div>
			</div>
            <div class="row panel panel-default form">
                <form class="form-horizontal form-row-seperated col-md-8 offset-md-2" id="form" role="form" action="">
                    <div class="form-body">
                        <div class="form-group" >
                            <label class="control-label col-md-3" style="margin-right:20px">受付日:</label>
                            <input type="text" class="form-control col-md-6" readonly value="<?php echo e(isset($message) ? with((date_create($message->created_at)))->format('Y.m.d') : ""); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" style="margin-right:20px">お名前:</label>
                            <input type="text" class="form-control col-md-6" readonly value="<?php echo e(isset($message) ? $message->name : ""); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" style="margin-right:20px">読Qネーム:</label>
                            <input type="text" class="form-control col-md-6" readonly value="<?php echo e(isset($message) ?$message->username : ""); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" style="margin-right:20px">メールアドレス:</label>
                            <a href="mailto:<?php echo e(isset($message) ? $message->email : ""); ?>">
                            <input class="form-control col-md-6" readonly value="<?php echo e(isset($message) ? $message->email : ""); ?>"></a>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" style="margin-right:20px">お問合せ内容:</label>
                            <textarea class="form-control col-md-6" readonly  name="content" id="content" rows="5"><?php echo e(isset($message) ? $message->content : ""); ?></textarea>
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" style="margin-right:20px">返信内容:</label>
                            <textarea class="form-control col-md-6" name="post" id="post" rows="5"><?php echo e(isset($message->post) ? $message->post : ""); ?></textarea>
                            <div class="col-md-2 notify_send">
                               <?php if(isset($message)): ?> <button type="button" class="btn btn-primary" id="send">送　信</button> <?php endif; ?>
                            </div>
                        </div>
                   </div>
                   <input type="hidden" name="checkid" id="checkid" value="<?php echo e(isset($message) ? $message->id: ""); ?>">
                </form>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
 <script type="text/javascript">
        $(document).ready(function(){
           $("#send").click(function(){
                if($("#post").val() == "" ){
                    $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['MESSAGE_REQUIRED']); ?>");
                    $("#alertModal").modal();
                }else{
                    $("#form").attr("method", "get")
                    $("#form").attr("action",'<?php echo e(url("/admin/quiz_answer")); ?>');
                    $("#form").submit(); 
                }
            });

            $(".del_sel").click(function() {
                var del_chk = [ $('#checkid').val() ];
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    quizIds: del_chk,
                    type: 1
                };
                var post_url = "/admin/quiz_delete";
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
                        console.log("response===>", response);
                        if(response.status){
                            window.location.href = '/admin/quiz_answer';
                        }
                        else
                            alert('Delete error') ;
                    }
                });  
            });

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>