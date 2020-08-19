
<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php
  if($type=='gene') 
	$page_title = $page_title;
  else if($type=='category')
  	$page_title = $page_title;
  else if($type=='latest')
  	$page_title = $page_title;
  else if($type=='ranking'){
  	$page_title = '';
  	$searchpupil_flag = false;
  	foreach(config('consts')['BOOK']['RANKINGS_title'] as $key=>$ranking){
  		if($key== $rank){ 
  			$page_title = $ranking.'の';
  			if($key == 0 || $key == 1 || $key == 2 || $key == 3 || $key == 4) 
  				$searchpupil_flag = true;
  			break;
  		}
  	}
  	if($gender== 1){
  		if($searchpupil_flag)  $page_title .= '女子';
  		else $page_title .= '女性';
  	}
  	else if($gender== 2){
  		if($searchpupil_flag)  $page_title .= '男子';
  		else $page_title .= '男性';
  	}
  	else $page_title .= '男女';
	$page_title .= 'によく読まれている読Q本ランキング';
  }
?>
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
					> <a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> <?php echo e($page_title); ?>

				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				<?php if($type=='ranking'): ?>
					<?php echo e($page_title); ?>(合格者人数ランキング）
				<?php else: ?>
					<?php echo e($page_title); ?>

				<?php endif; ?>
			</h3>
			
			<?php if($type=='ranking'): ?>
			<div class="form form-horizontal">
				<form class="form-horizontal" action="<?php echo e(url('book/search/ranking')); ?>" method="post">
				<?php echo e(csrf_field()); ?>

					<input type="hidden" name="rank" id="rank" value="<?php echo e($rank); ?>"/>
					<input type="hidden" name="user_id" id="user_id" value="<?php echo e(Auth::id()); ?>">
					<input type="hidden" name="book_id" id="book_id" value="">
					<input type="hidden" name="work_test" id="work_test" value="<?php if(isset($work_test)): ?><?php echo e($work_test); ?> <?php endif; ?>">

					<div class="form-group row">
						<label class="control-label col-md-1 text-md-right">性別</label>
						<div class="col-md-2">
							<select class="bs-select form-control" name="gender">
								<option></option>
								<option value="2" <?php if(isset($gender) && $gender == 2): ?> selected <?php endif; ?>>男</option>
								<option value="1" <?php if(isset($gender) && $gender == 1): ?> selected <?php endif; ?>>女</option>
								<option value="3" <?php if(isset($gender) && $gender == 3): ?> selected <?php endif; ?>>男女分けない</option>
							</select>
						</div>

						<label class="control-label col-md-1 text-md-right">期間</label>
						<div class="col-md-3">
							<select class="bs-select form-control" name="period">
								<option></option>
								<?php $__currentLoopData = config('consts')['BOOK']['RANKING_PERIOD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($key); ?>" <?php if(isset($period) && $period == $key): ?> selected <?php endif; ?>><?php echo e($p); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
						<div class="col-md-2">
							<button class="btn btn-primary">次 へ<i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>
			<?php else: ?>
				<form class="form-horizontal" action="" method="post">
				<?php echo e(csrf_field()); ?>

					<input type="hidden" name="book_id" id="book_id" value="">
					<input type="hidden" name="work_test" id="work_test" value="<?php if(isset($work_test)): ?><?php echo e($work_test); ?> <?php endif; ?>">
					<input type="hidden" name="content" id="content" value="<?php if(isset($content)): ?><?php echo e($content); ?> <?php endif; ?>">
				</form>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<?php echo $__env->make('books.book.search.table', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 margin-bottom-10">
					<button type="button" class="btn pull-right btn-info" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<h4>
						この本を、読みたい本に登録しました。
					</h4>
					<h4>
						マイ書斎の、読みたい本リストで確認できます。
					</h4>

				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade draggable draggable-modal" id="confirmModal1" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<h4>
						既に読みたい本に登録されたほんです。
					</h4>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は年齢制限のある本なので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
    <div class="modal fade" id="myfailedModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
	          <p>この本のクイズに2度目も不合格でしたので、3日間この本を受検できません。他の本の受検はできます。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
    </div>
	<div class="modal fade" id="passModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>エラー</strong></h4>
	        </div>
	        <div class="modal-body">
	          <p>この本は、すでに合格していますので、受検できません。</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
	        </div>
	      </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			
    		$('body').addClass('page-full-width');
			ComponentsDropdowns.init();

			$('.towishlist').click(function(){
				var self = $(this);
				var id   = $(this).attr('id');
				var arr  = id.split('_');
				var book_id = arr[2];//self.closest('.book_id');
				<?php if(Auth::check() && Auth::id()): ?> 
					$user_id = <?php echo e(Auth::id()); ?>;
				<?php else: ?>
				   	$user_id = '';
				<?php endif; ?>
				var info = {
		    		user_id: $user_id,
		    		book_id: book_id,
		    		work_test: $("#work_test").val(),
		    		content: $("#content").val(),
		    		_token: $('meta[name="csrf-token"]').attr('content')
		    	}
				$.ajax({
					type: "post",
		      		url: "<?php echo e(url('/book/regWishlist')); ?>",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	if(response.status == 'success'){
				    		$(".towishlist").addClass('disabled');
	//			    		$('.towishlist').removeClass('towishlist');

				    		$("#confirmModal").modal('show');	
				    	}else if(response.status == 'failed'){
	//			    		bootboxNotification(response.message);
				    		$("#confirmModal1").modal('show');
				    	}
				    	
			    	}
				});	
			});

			$('.towishlist1').click(function(){
				<?php if(Auth::check() && Auth::id()): ?> 
					$user_id = <?php echo e(Auth::id()); ?>;
				<?php else: ?>
				   	$user_id = '';
				<?php endif; ?>

				var info = {
		    		user_id: $user_id,
		    		book_id: $(".towishlist1").attr('id'),
		    		work_test: $("#work_test").val(),
		    		content: $("#content").val(),
		    		_token: $('meta[name="csrf-token"]').attr('content')
		    	}
				$.ajax({
					type: "post",
		      		url: "<?php echo e(url('/book/regWishlist')); ?>",
				    data: info,
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	if(response.status == 'success'){
				    		$("#"+$(".towishlist1").attr('id')).addClass('disabled');
		//			    		$('.towishlist1').removeClass('towishlist1');

				    		$("#confirmModal").modal('show');	
				    	}else if(response.status == 'failed'){
		//			    		bootboxNotification(response.message);
				    		$("#confirmModal1").modal('show');
				    	}
				    	
			    	}
				});	
			});

			$(".test_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/test') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});
			$(".detail_btn").click(function() {
				$("#book_id").val($(this).attr("id")); 
				$(".form-horizontal").attr("action", "<?php echo url('book/detail') ?>");
   		    	$(".form-horizontal").attr("method", "post");
   		    	$(".form-horizontal").submit();
			});

			<?php if($errors == "false"): ?>
				$('#myModal').modal('show');
			<?php endif; ?>
			<?php if($errors == "alert"): ?>
				$('#myfailedModal').modal('show');
			<?php endif; ?>
			<?php if($errors == "pass"): ?>
				$('#passModal').modal('show');
			<?php endif; ?>

			$(".age_limit").click(function() {
				$('#myModal').modal('show');
			});
			$(".book_equal").click(function() {
				$('#passModal').modal('show');
			});

		});

		
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>