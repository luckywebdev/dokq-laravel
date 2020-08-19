<?php $__env->startSection('styles'); ?>
    
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
			            > 	<a href="<?php echo e(url('/top')); ?>">協会トップ</a>
		            </li>
		            <li class="hidden-xs">
	                	> 監修者申請中個人リスト
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">監修者申請中　　個人リスト
			</h3>
			<form class="form form-horizontal" id="change-form" method="post">
			<?php echo e(csrf_field()); ?>

			<input type="hidden" id="items" name="items" value="">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-2" style="margin-bottom:8px;">
							<button type="button" class="btn btn-primary pull-right" id="submit_btn">監修者に変更</button>
						</div>
						<div class="col-md-2" style="margin-bottom:8px;">
							<button type="button" class="btn btn-primary pull-right" id="no_btn">監修者申請却下</button>
						</div>
					</div>
									
					<table class="table table-hover table-bordered">
					    <thead>
					      <tr  class="bg-primary">
					      	<th class="table-checkbox sorting_disabled">
								<div class="checker">
									<span class=""><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"></span>
								</div>
							</th>
					        <th>申請受付日</th>
					        <th>氏名</th>
					        <th>分類</th>
					        <th>メールアドレス</th>
					        <th>読Qネーム</th>
					        <th>資格証</th>
					        <th>住所</th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="text-md-center">
								<td class="align-middle">
									<input type="checkbox" class="checkboxes" id="<?php echo e($user->id); ?>" value="<?php echo e($user->id); ?>"/>
								</td>
								<td class="align-middle col-md-1"><?php echo e($user->replied_date1? with(date_create($user->replied_date1))->format('Y/m/d'): ""); ?></td>
								<td class="align-middle col-md-1"><a id="user_a" href="#" onClick="alertcontent(<?php echo e($user->id); ?>);" oncontextmenu="handleRightClick('<?php echo e($user->id); ?>','<?php echo e($user->email); ?>','<?php echo e($user->active); ?>'); return false;"><?php if($user->isAuthor()): ?><?php echo e($user->fullname_nick()); ?><?php else: ?><?php echo e($user->fullname()); ?><?php endif; ?></a></td>
								<input type="hidden" id="recommend<?php echo e($user->id); ?>" value="<?php echo e($user->recommend_content); ?>">
								<td class="align-middle col-md-1"><?php echo e(config('consts')['USER']['TYPE'][$user->role]); ?></td>
								<td class="align-middle"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></td>
								<td class="align-middle"><a href="<?php echo e(url('mypage/other_view/' . $user->id)); ?>" class="font-blue"><?php echo e($user->username); ?></a></td>
								<td class="align-middle"><a href="<?php echo e($user->file); ?>" class="font-blue"><?php echo e($user->authfile); ?></a></td>
								<td class="align-middle col-md-3">〒 <?php echo e($user->address4); ?>―<?php echo e($user->address5); ?> <?php echo e($user->address1); ?> <?php echo e($user->address2); ?> <?php echo e($user->address3); ?> <?php echo e($user->address6); ?> <?php echo e($user->address7); ?> <?php echo e($user->address8); ?> <?php echo e($user->address9); ?> <?php echo e($user->address10); ?></td>
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>
			</form>
			<div id="popup" style="display:none;z-index:1000;">
               <div id="email_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a href='#' >Eメールを送る</a></div>  
               <div id="userdata_tag" style="padding:5px;padding-left:10px;padding-right:10px;text-align:center;"><a  href="javascript:;" style='pointer-events:none;color:#757b87;'>データ画面へ遷移</a></div>    
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
        	<h4 class="modal-title"><strong>推薦文</strong></h4>
      	</div>
      	<div class="modal-body">
        	<textarea  required id="alert_text" class="form-control" name="alert_text" rows="5"></textarea>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<div id="alertModal1" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text1"></span>
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
		var items = [];

		$(".checkboxes").click(function(){
			var key =  $(this).val();
			if($(this).attr("checked") == "checked"){
				items.push(key);
			}else{

				items.splice(items.indexOf(key));
			}
		})

		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
		var alertcontent = function(id) {
		 	var content=$("#recommend"+id).val(); 
			$("#alert_text").html(content);
			$("#alertModal").modal();
		}

		$("#submit_btn").click(function(){
			if(items.length == 0){
				$("#alert_text1").html("<?php echo e(config('consts')['MESSAGES']['CHECK_SELECT']); ?>");
                $("#alertModal1").modal();
				return;
			}else{
				$("#items").val(items);
				$("#change-form").attr("action", "<?php echo e(url('/admin/recommend_change')); ?>");
	            $("#change-form").submit();
	        }
		});	

		$("#no_btn").click(function(){
			if(items.length == 0){
				$("#alert_text1").html("<?php echo e(config('consts')['MESSAGES']['CHECK_SELECT']); ?>");
                $("#alertModal1").modal();
				return;
			}else{
				$("#items").val(items);
				$("#change-form").attr("action", "<?php echo e(url('/admin/recommend_nochange')); ?>");
	            $("#change-form").submit();
	        }
		});	

		function handleRightClick(user_id, user_email, user_active) {
            
			//$("#testvalue").html(user_id);  
			//mailto(user_email);
			var str="<a href='mailto:"+user_email+"' style='color:#757b87;'>Eメールを送る</a>"	
			$("#email_tag").html(str);
			
			if(user_active == 1){
				$("#userdata_tag").attr('disabled', true);
				var str="<a href='/admin/personaldata/"+user_id+"' style='color:#757b87;'>データ画面へ遷移</a>"	
				$("#userdata_tag").html(str);
			}
	     };
         
	$(function () {
       
  		var $contextMenu = $("#contextMenu");
  		$("body").click(function(){
		    $("#popup").hide();
		});
		$("body").on("contextmenu", "a#user_a", function(e) {
		    $contextMenu.css({
		      display: "block",
		      left: e.pageX,
		      top: e.pageY
		    });
		   
		    $("#popup").show();
		    $("#popup").css("position","absolute");
		    $("#popup").css("left",e.pageX-30);
		    $("#popup").css("top",e.pageY-120);
		    return false;
		});
	});
	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>