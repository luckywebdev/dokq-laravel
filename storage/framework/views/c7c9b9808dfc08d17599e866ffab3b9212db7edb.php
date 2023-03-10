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
	                	> 退会手続き中リスト		

		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>

	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">退会手続き中リスト</h3>
			<div class="row">
				<div class="col-md-12">
					<?php if(isset($message)): ?>
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							<?php echo e($message); ?>

						</p>
					</div>
					<?php endif; ?>
					<table class="table table-hover table-bordered">
					    <thead>
					      <tr  class="bg-primary">
					        <th>退会連絡日</th>
					        <th>氏名</th>
					        <th>読Qネーム</th>
					        <th>年齢</th>
					        <th>級</th>
					        <th>入会日</th>
					        <th>分類</th>
					        <th>都道府県</th>
                            <th>メールアドレス</th>
                            <th>paypal停止日</th>
                            <th>完了メール送信</th>
                            <th>送信日</th>
					      </tr>
					    </thead>
					    <tbody class="text-md-center">
							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr class="text-md-center">
								<td class="align-middle col-md-1"><?php echo e(with(date_create($user->escape_date))->format('Y/m/d')); ?></td>
								<td class="align-middle col-md-1"><a id="user_a" href="<?php echo e(url('mypage/other_view/' . $user->id)); ?>" class="font-blue" oncontextmenu="handleRightClick('<?php echo e($user->id); ?>','<?php echo e($user->email); ?>','<?php echo e($user->active); ?>'); return false;"><?php if($user->isAuthor()): ?><?php echo e($user->fullname_nick()); ?><?php else: ?><?php echo e($user->fullname()); ?><?php endif; ?></a></td>
								<td class="align-middle col-md-1"><?php echo e($user->username); ?></td>
								<td class="align-middle col-md-1"><?php echo e(date_diff(date_create($user->birthday ), date_create('today'))->y); ?></td>
								<td class="align-middle col-md-1"><?php echo e($user->level); ?></td>
								<td class="align-middle"><?php echo e($user->replied_date2? with(date_create($user->replied_date2))->format('Y/m/d'): ""); ?></td>
								<td class="align-middle col-md-1"><?php echo e(config('consts')['USER']['TYPE'][$user->role]); ?></td>
								<td class="align-middle col-md-1"><?php echo e($user->address1."  ".$user->address2); ?></td>
								<td class="align-middle"><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></td>
								<td class="align-middle">
									<?php if($user->paypal_stop_date != null): ?>
									<input required type="text" readonly="true" name="paypal_stop_date" value="<?php echo e($user->paypal_stop_date); ?>" id="paypal_stop_date" user_id="<?php echo e($user->id); ?>" class="big-form-control date-picker paypal_stop_date" placeholder="（西暦を２回タップして選択）">
									<?php else: ?>
									<input required type="text" readonly="true" name="paypal_stop_date" value="<?php echo e(old('paypal_stop_date')); ?>" id="paypal_stop_date" user_id="<?php echo e($user->id); ?>" class="big-form-control date-picker paypal_stop_date" placeholder="（西暦を２回タップして選択）">
									<?php endif; ?>
									<?php if($errors->has('paypal_stop_date')): ?>
									<span class="form-control-feedback">
										<span><?php echo e($errors->first('paypal_stop_date')); ?></span>
									</span>
									<?php endif; ?>
								</td>
								<td class="align-middle">
									<?php if(!$user->unsubscribe_date): ?> 
									<a class="btn btn-email btn-warning" href="#" user_id="<?php echo e($user->id); ?>" style="padding-top: 0; padding-bottom:0; color: #FFF; font-weight:600">送信</a>
									<?php else: ?>
									<?php echo e("送信済"); ?>

									<?php endif; ?>
								</td>
								<td class="align-middle"><?php echo e($user->unsubscribe_date? with(date_create($user->unsubscribe_date))->format('Y/m/d'): ""); ?></td>
								
							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
				</div>
			</div>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
	 function handleRightClick(user_id, user_email, user_active) {
            
		//$("#testvalue").html(user_id);  
		//mailto(user_email);
		var str="<a href='mailto:"+user_email+"' style='color:#757b87;'>Eメールを送る</a>"	
		$("#email_tag").html(str);
		
		if(user_active == 1){
			$("#userdata_tag").attr('disabled', true);
		}
		var str="<a href='/admin/personaldata/"+user_id+"' style='color:#757b87;'>データ画面へ遷移</a>"	
			$("#userdata_tag").html(str);
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

		$(".btn-email").on("click", function(e){
			e.preventDefault();
			var user_id = $(this).attr("user_id");
			var paypal_stop_date = "";
			//  href="<?php echo e(url('/admin/unsubscribe_email/'.$user->id)); ?>"
			$(".paypal_stop_date").each(function () {
				var user = $(this).attr("user_id");
				if (user == user_id) {
					paypal_stop_date = $(this).val();
				}
			})
			var info = {
				_token: $('meta[name="csrf-token"]').attr('content'),
				paypal_stop_date: paypal_stop_date
			}
			var err = "<?php echo config('consts')['MESSAGES']['EMAIL_SERVER_ERROR'] ?>";
			var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/admin/unsubscribe_email/" + $(this).attr('user_id');
			$.ajax({
				type: "get",
				url: post_url,
				data: info,
				beforeSend: function (xhr) {
					var token = $('meta[name="csrf-token"]').attr('content');
					if (token) {
								return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				success: function (response){
					console.log("response", response);
					if(response.success == true){
						location.reload();
					} else {
						window.alert(err);
					}
				}
			});
		});

	});
	$("#phone").inputmask("mask", {
		"mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
	});

	var handleDatePickers = function () {
		if (jQuery().datepicker) {
				$('.date-picker').datepicker({
						rtl: Metronic.isRTL(),
						orientation: "left",
						autoclose: true,
						language: 'ja'
				});
		}
	}

	handleDatePickers();

</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>