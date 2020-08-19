

<?php $__env->startSection('styles'); ?>
	<style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;
		}
	</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="<?php echo e(url('/')); ?>">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修者募集本リストと応募
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者募集本リストと応募</h3>

			<?php echo $__env->make('partials.mypage.overseer_demand', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			
			<div class="row">
				<div class="col-md-9">
					<form action="<?php echo e(url('/mypage/demand')); ?>" method="post" id="book_form">
						<?php echo e(csrf_field()); ?>

						<div class="form-group1">
							<div class="col-md-12">
								<div class="col-md-4 text-right">
									<label class="control-label" id="reply"></label>
								</div>
								<div class="col-md-6">
									<input type="hidden" name="book_id" id="book_id" value="<?php echo e(isset($_GET['book_id']) ? $_GET['book_id'] : ''); ?>"/>
									<input type="hidden" name="bookId" id="bookId"/>
									<input type="hidden" name="title" id="title" value="<?php if(isset($title)): ?><?php echo e($title); ?><?php endif; ?>"/>
									<textarea type="text" id="reason" class="form-control"  name="reason" placeholder="応募理由（100字以内）" style="margin-bottom:8px;"><?php if(isset($reason)): ?><?php echo e($reason); ?><?php endif; ?></textarea>
									<span style="color:red">※ 本の監修者に選任されると、監修者紹介画面に本名が公開されます。</span>

								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-primary pull-right" id="btn_submit" style="margin-bottom:8px;">送信</button>
								</div>

							</div>
			    		</div>
		    		</form>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
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
<script>
    jQuery(document).ready(function() {
        <?php if($otherview_flag): ?>
            $('body').addClass('page-full-width');
            var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
        <?php endif; ?>
            
    	var book_id = $("#book_id").val();   	
    	if(book_id == '' || book_id == null)
    		$(".form-group1").addClass("hide");
    	else{
    		$(".form-group1").addClass("show");
    		var books = $("#books").val();

    		var txt1 = "<h5>「" + $("#title").val() + "」";
    		var txt2 = "dq"+ book_id + "の監修者応募</h5>";
    		$("#reply").html(txt1+txt2);

          	//$("#book_id").val($(this).attr("bid")); 
    	} 
    		
        $(".proposal").click(function(){
          	$(".form-group1").removeClass("hide");
          	$(".form-group1").addClass("show");
          	var txt1 = "<h5>「" + $(this).siblings(".didor").text() + "」";
    		var txt2 = $(this).siblings(".xin").text() + "の監修者応募</h5>";
    		$("#reply").html(txt1+txt2);
    		$("#bookId").val($(this).attr("bid"));
    		
			var info = {
                book_id: $(this).attr("bid"),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            $.ajax({
                type: "post",
                url: "<?php echo e(url('/mypage/select_demand')); ?>",
                data: info,

                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function (response){

                	if(response.status == 'success'){
                       
				    	$("#reason").val(response.reason);
                    } else if(response.status == 'no') {
                    	$("#reason").val("");
                    }
                },
                error: function (err) {
                    alert("error");
                    //$(".failed-alert").css('display','block');
                }
            });     
        });
        $("#btn_submit").click(function(){
			var bookId = $("#bookId").val();
            var reason = $("#reason").val();

			if(bookId == "" || bookId == 0 || bookId == null){
                bookId = $("#book_id").val();
                $("#bookId").val(bookId);
                if(bookId == "" || bookId == 0 || bookId == null){
				    $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['BOOK_REQUIRED']); ?>");
        		    $("#alertModal").modal();
                }
			}else if(reason == ""){
				$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['REASON_REQUIRED']); ?>");
       			$("#alertModal").modal();
			}else{
				$("#book_form").submit();
			}			
			//location.href = "/mypage/demand/" + $(this).attr("bid")+"/"+ reason;	
    	});
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>