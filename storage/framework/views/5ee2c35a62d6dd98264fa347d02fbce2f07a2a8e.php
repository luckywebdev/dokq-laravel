

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
			            > 	<a href="<?php echo e(url('/top')); ?>">団体アカウントトップ</a>
		            </li>
		            <li class="hidden-xs">
	                	> 団体の基本情報閲覧編集
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">団体の基本情報閲覧編集</h3>

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
					<table class="table table-hover">
						<tbody class="text-md-center">
							<tr>
								<td style="vertical-align:middle;">
									団体名
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->group_name); ?>

								</td>
								<td style="vertical-align:middle;">
									<span class="label label-warning">
										変更不可
									</span>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									読Qネーム 
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->username); ?>

								</td>
								<td style="vertical-align:middle;">
									<span class="label label-warning">
										変更不可
									</span>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									パスワード
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->passwordShow()); ?>

								</td>
								<td style="vertical-align:middle;">
									<span class="label label-warning">
										変更不可
									</span>
								</td>
							</tr>
							
							<tr>
								<td style="vertical-align:middle;">
									住所
								</td>
								<td style="vertical-align:middle;">
									〒 <?php echo e($user->address4); ?>―<?php echo e($user->address5); ?><?php echo e($user->address1); ?><?php echo e($user->address2); ?><?php echo e($user->address3); ?>

								</td>
								<td style="vertical-align:middle;">
									<button class="btn btn-primary password_confirm" data-key="address" >
										<i class="fa fa-edit"></i> 編集
									</button>
									<div class="modal fade draggable draggable-modal" id="addressModal" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog" >
											<form class="modal-content" method="post" action="<?php echo e(url('/api/group/changedata')); ?>">
												<?php if(isset($id)): ?>
												<input type="hidden" name="id" id="id" value="">
												<?php else: ?>
												<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
												<?php endif; ?>
												<div class="modal-header">
													<h4 class="modal-title text-primary"><strong>新所在地を入力</strong></h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">
													<?php echo e(csrf_field()); ?>

													<div class="form">																											 	
														<div class="form-group">
														    <div class="form-group">

														    </div>
														    <div class="form-group">
														    <input type="number" name="address4" class="form-control" maxlength="3" placeholder="丁目" value="<?php echo e($user->address4); ?>" required>
														    </div>
														    <div class="form-group">
														    <input type="number" name="address5" class="form-control" maxlength="4" placeholder="番" value="<?php echo e($user->address5); ?>" required>
														    </div>
													 	</div>
													 	<div class="form-group">

													 	</div>
														<div class="form-group">
															 <input type="text" name="address1" class="form-control" placeholder="県" value="<?php echo e($user->address1); ?>" >
													 	</div>
													 	<div class="form-group">
															 <input type="text" name="address2" class="form-control" placeholder="市" value="<?php echo e($user->address2); ?>" >
													 	</div>
													 	<div class="form-group">
															 <input type="text" name="address3" class="form-control" placeholder="町" value="<?php echo e($user->address3); ?>" >
													 	</div>													 														 	
													 </div>
												</div>
												<div class="modal-footer text-md-center text-sm-center">
													<button data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
													<button type="button" data-dismiss="modal" class="btn btn-info">戻　る</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									代表電話　
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->phone); ?>

								</td>
								<td style="vertical-align:middle;">
									<button class="btn btn-primary password_confirm" data-key="phone" >
										<i class="fa fa-edit"></i> 編集
									</button>
									<div class="modal fade draggable draggable-modal" id="phoneModal" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog" >
											<form class="modal-content" method="post" action="<?php echo e(url('/api/group/changedata')); ?>">
											<?php if(isset($id)): ?>
											<input type="hidden" name="id" id="id" value="">
											<?php else: ?>
											<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
											<?php endif; ?>
												<div class="modal-header">
													<h4 class="modal-title text-primary"><strong>新代表電話</strong></h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">
													<div class="form">
														<div class="form-group">
														<?php echo e(csrf_field()); ?>

															 <input type="text" id="phone" name="phone" class="form-control" placeholder="新代表電話  " value="<?php echo e($user->phone); ?>" required>
													 	</div>
													 </div>
												</div>
												<div class="modal-footer text-md-center text-sm-center">
													<button data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
													<button type="button" data-dismiss="modal" class="btn btn-info">戻　る</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									代表者  
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->rep_name); ?>

								</td>
								<td style="vertical-align:middle;">
									<button class="btn btn-primary password_confirm" data-key="repname" >
										<i class="fa fa-edit"></i> 編集
									</button>
									<div class="modal fade draggable draggable-modal" id="repnameModal" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog" >
											<form class="modal-content" method="post" action="<?php echo e(url('/api/group/changedata')); ?>">
											<?php if(isset($id)): ?>
											<input type="hidden" name="id" id="id" value="">
											<?php else: ?>
											<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
											<?php endif; ?>
												<div class="modal-header">
													<h4 class="modal-title text-primary"><strong>新代表者を入力</strong></h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

												</div>
												<div class="modal-body">
													<div class="form">
														<div class="form-group">
														<?php echo e(csrf_field()); ?>

															 <input type="text" name="rep_name" class="form-control" value="<?php echo e($user->rep_name); ?>" placeholder="新代表者  " required>
															 
													 	</div>
													 </div>
												</div>
												<div class="modal-footer text-md-center text-sm-center">
													<button data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
													<button type="button" data-dismiss="modal" class="btn btn-info">戻　る</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									IT担当者　
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->teacher); ?>

								</td>
								<td style="vertical-align:middle;">
									<button class="btn btn-primary password_confirm" data-key="teacher" >
										<i class="fa fa-edit"></i> 編集
									</button>
									<div class="modal fade draggable draggable-modal" id="teacherModal" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog" >
											<form class="modal-content" method="post" action="<?php echo e(url('/api/group/changedata')); ?>">
											<?php if(isset($id)): ?>
											<input type="hidden" name="id" id="id" value="">
											<?php else: ?>
											<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
											<?php endif; ?>
												<div class="modal-header">
													<h4 class="modal-title text-primary"><strong>新担当者を入力</strong></h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">
													<div class="form">
														<div class="form-group">
														<?php echo e(csrf_field()); ?>

															 <input type="text" name="teacher" value="<?php echo e($user->teacher); ?>" class="form-control" placeholder="新担当者を入力" required>
															 
													 	</div>
													 </div>
												</div>
												<div class="modal-footer text-md-center text-sm-center">
													<button data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
													<button type="button" data-dismiss="modal" class="btn btn-info">戻　る</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									IT担当者ﾒｰﾙｱﾄﾞﾚｽ　
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->email); ?>

								</td>
								<td style="vertical-align:middle;">
									<button class="btn btn-primary password_confirm" data-key="email" >
										<i class="fa fa-edit"></i> 編集
									</button>
									<div class="modal fade draggable draggable-modal" id="emailModal" tabindex="-1" role="basic" aria-hidden="true">
										<div class="modal-dialog" >
											<form class="modal-content" method="post" action="<?php echo e(url('/api/group/changedata')); ?>">
											<?php if(isset($id)): ?>
											<input type="hidden" name="id" id="id" value="">
											<?php else: ?>
											<input type="hidden" name="id" id="id" value="<?php echo e(Auth::user()->isGroup() ? Auth::id() : Auth::user()->School->id); ?>">
											<?php endif; ?>
												<div class="modal-header">
													<h4 class="modal-title text-primary"><strong>新ﾒｰﾙｱﾄﾞﾚｽを入力</strong></h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">
													<div class="form">
														<div class="form-group">
															<?php echo e(csrf_field()); ?>

															 <input type="email" name="email" value="<?php echo e($user->email); ?>" class="form-control" placeholder="新ﾒｰﾙｱﾄﾞﾚｽ　" required>
													 	</div>
													 </div>
												</div>
												<div class="modal-footer text-md-center text-sm-center">
													<button data-loading-text="確認中..." class="send_password btn btn-primary">送　信</button>
													<button type="button" data-dismiss="modal" class="btn btn-info">戻　る</button>
												</div>
											</form>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td style="vertical-align:middle;">
									読Q有効期限（払込済期間終了）
								</td>
								<td style="vertical-align:middle;">
									<?php echo e($user->period); ?>

								</td>
								<td style="vertical-align:middle;">
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<form action="" id="form">
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" id="back">戻　る</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="passwordModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong><?php echo e(config('consts')['MESSAGES']['21B1']); ?></strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
						<?php echo e(csrf_field()); ?>

							 <input type="hidden" name="modalid" id="modalid" value="<?php echo e(Auth::id()); ?>">
							 <input type="password" name="password" id="password"  class="form-control" placeholder="まずパスワードを入力して下さい。">
							 <span class="help-block " id="password_error">
							 </span>
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

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });
		$("#back").click(function(){
			$("#form").attr("method", "get");
			$("#form").attr("action", "<?php echo e(url('/')); ?>");
			$("#form").submit();
		});
		$("#password").keypress (function(event){
            if(event.keyCode == 13){
            	$("#passwordModal .send_password").trigger('click');
			}
        });

	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>