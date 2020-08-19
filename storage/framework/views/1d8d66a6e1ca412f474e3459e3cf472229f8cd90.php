<?php $__env->startSection('styles'); ?>
     <!-- data table -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')); ?>"/>
     <!-- data table -->

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
	                	 > 団体アカウント 
		            </li>
	            	<li class="hidden-xs">
	                	<a href="#"> > 教職員名簿</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Q 団体教職員名簿: <?php echo e($group->group_name); ?></h3>

			<div class="row">
				<div class="col-md-12">
					<?php if(isset($message)): ?>
						<?php echo $__env->make('partials.alert',array('message'=>$message), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
					<?php endif; ?>
					<div class="form-horizontal">
						<form class="form-horizontal form" id="form" role="form" action="">
						<?php echo e(csrf_field()); ?>


						<div class="form-group">
							<label class="control-label col-sm-2">作業を選択:</label>
							<div class="col-md-3">
								<select class="bs-select form-control" id="action" name="action" style="height:33px !important">
									<option value="0"></option>
									<option value="1" id="edit">カードで編集</option>
									<option value="2" id="delete">当校から削除(準会員になります)</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<?php echo $__env->make('group.teacher_set.table', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							</div>
						</div>
						<input type="hidden" name="selected" id="selected" value=""/>
					</form>
					</div>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" id="back">戻　る</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong><?php echo e(config('consts')['MESSAGES']['21B1']); ?></strong></h4>
					<button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<input type="password" name="password" id="password" autofocus="true" class="form-control" placeholder="">
							<span class="help-block " id="password_error"></span>
					 	</div>
					 </div>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
					<button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
				</div>
			</div>
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
<div id="TdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span>この教職員データを削除しますか？</span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-loading-text="確認中..." class="delete_teacher btn btn-primary">は い</button>
			<button type="button" data-dismiss="modal" class="btn btn-info modal-close">いいえ</button>
        </div>
    </div>

  </div>
</div>
	<input type="hidden" id="reloadFlag" name="reloadFlag" value="<?php echo e($group->reload_flag); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<!-- data table -->
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/media/js/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group_data_table.js')); ?>"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<!-- data table -->
	<script type="text/javascript">
		
		$(document).ready(function(){
			ComponentsDropdowns.init();
			flag = 100;
			if($("#reloadFlag").val()){
				flag = $("#reloadFlag").val();
			}
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});
				$("#action").attr("disabled", true);
			}else{
				$("#action").attr("disabled", false);
			}
			
			$("#authModal .modal-close").click(function(){
				history.go(-1);
			});
		
   			/*$("#year").click(function(){
   				location.href="/group/teacher/list?year=" + $("#year").val();
   			})*/
			$(".checkboxes").click(function(){
				
				var checkboxes = [];
				var checkids = $(".checkboxes");
				
				for(var i = 0; i < checkids.length; i++){
					if($(checkids[i]).parent().hasClass("checked")){
						checkboxes[checkboxes.length]= $(checkids[i]);
					}					
				}
				
				if(checkboxes.length == 0)
					$(".group-checkable").parent().removeClass("checked");
				else if(checkboxes.length == checkids.length)
					$(".group-checkable").parent().addClass("checked");
			})
   			$("#back").click(function(){
				$("#form").attr("method", "get");
				$("#form").attr("action", "<?php echo e(url('/')); ?>");
				$("#form").submit();
			    })
   			
   			$("#action").change(function(){
   				var checkboxes = [];
				var checkids = $(".checkboxes");
				
				for(var i = 0; i < checkids.length; i++){
					if($(checkids[i]).parent().hasClass("checked")){
						checkboxes[checkboxes.length]= $(checkids[i]);
					}					
				}
   				if($(':selected').attr('id') == 'edit'){

   	   				if(checkboxes.length == 0){
						//alert("please check teacher");
						$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CHECK_TEACHER']); ?>");
	        			$("#alertModal").modal();
						$(this).val("");
						return;
   	   	   			}
   	   				if(checkboxes.length > 1){
						
						$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CHECK_ONETEACHER']); ?>");
	        			$("#alertModal").modal();
						$(this).val("");
						return;
   	   	   			}
   	   				if(checkboxes.length == 1){
 	   	   				$('#selected').val($('.checker .checked .checkboxes').attr('id'));  	   	   				
   	   	   				$("#form").attr("method", "get")
   	   			    	$("#form").attr("action",'<?php echo e(url("/group/teacher/edit/card")); ?>');
   	   			    	$("#form").submit();
   	   	   			}
   				}
   				if($(':selected').attr('id') == 'delete'){
					if(checkboxes.length == 0){
						
						$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CHECK_TEACHER']); ?>");
	        			$("#alertModal").modal();
						$(this).val("");
						return;
					}else{
						$("#TdelModal").modal();
					}
				}
					if(checkboxes.length != 0){
//						
                    }
   	   		});
            $(".delete_teacher").click(function(){
                var t = '';
                var checkboxes = [];
				var checkids = $(".checkboxes");
				
				for(var i = 0; i < checkids.length; i++){
					if($(checkids[i]).parent().hasClass("checked")){
						checkboxes[checkboxes.length]= $(checkids[i]);
					}					
				}

				for(i =0;i<checkboxes.length;i++){
                    t+=$(checkboxes[i]).attr("id");
	                if(i < checkboxes.length-1){
	                    t+=",";
	                }
                }

                $('#selected').val(t);
                $("#form").attr("method", "post");
                $("#form").attr("action",'<?php echo e(url("/group/teacher/delete")); ?>');
                $("#form").submit()
            });
		});
		TableManaged.init();
    </script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/list.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>