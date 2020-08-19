<?php $__env->startSection('styles'); ?>
<style type="text/css">
	.has-danger .form-control{
		border-width: 2px !important;
	}
	.has-danger{
		font-weight: 600 !important;
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
                	 > 団体アカウント 
	            </li>
            	<li class="hidden-xs">
                	> 教員カードによる権限編集
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">教員カードの登録・編集&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($action == "create"): ?> 【<?php echo e(Auth::user()->group_name); ?>】 <?php else: ?> <?php if(isset($teacher) && isset($teacher->School)): ?>【<?php echo e($teacher->School->group_name); ?>】 <?php endif; ?> <?php endif; ?></h3>
			
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form" method="post" id="form-validation" role="form" action="<?php echo e(url('/group/teacher/update')); ?>">
						
						<?php echo e(csrf_field()); ?>	
						<input type="hidden" id="action" name="action" value="<?php echo e($action); ?>">
						<div class="form-group row <?php echo e($errors->has('firstname') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname') ? ' has-danger' : ''); ?>">
							<label class="control-label col-md-2 text-md-right" for="firstname"> 姓:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="hidden" name="id" id="id" value="<?php echo e($teacher->id); ?>">
									<input type="text" value="<?php echo e($teacher->firstname); ?>" class="form-control" name="firstname" id="firstname">
								<?php else: ?>
									 <input type="hidden" name="id" id="id" value="create">
									 <input type="text" value="<?php echo e(old('firstname') !='' ? old('firstname') : (isset($_GET['firstname']) ?  $_GET['firstname'] : '')); ?>" class="form-control" name="firstname" id="firstname">
								<?php endif; ?>
								<?php if($errors->has('firstname')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('firstname')); ?></span>
								</span>
								<?php endif; ?>
														
							</div>
							<label class="control-label col-md-2 text-md-right" for="lastname"> 名:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->lastname); ?>" class="form-control" name="lastname" id="lastname" readonly>
								<?php else: ?>
									<input type="text" value="<?php echo e(old('lastname') !='' ? old('lastname') : (isset($_GET['lastname']) ?  $_GET['lastname'] : '')); ?>" class="form-control" name="lastname" id="lastname">
								<?php endif; ?>
								<?php if($errors->has('lastname')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('lastname')); ?></span>
								</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group row <?php echo e($errors->has('firstname_roma') ? ' has-danger' : ''); ?> <?php echo e($errors->has('last_roma') ? ' has-danger' : ''); ?>">
							<label class="control-label col-md-2 text-md-right" for="firstname_roma">姓ローマ字:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->firstname_roma); ?>" class="form-control" name="firstname_roma" id="firstname_roma">
								<?php else: ?>
									<input type="text" value="<?php echo e(old('firstname_roma')); ?>" class="form-control" name="firstname_roma" id="firstname_roma">
								<?php endif; ?>
								<?php if($errors->has('firstname_roma')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('firstname_roma')); ?></span>
								</span>
								<?php endif; ?>
							</div>
			
							<label class="control-label col-md-2 text-md-right" for="lastname_roma"> 名ローマ字:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->lastname_roma); ?>" class="form-control" name="lastname_roma" id="lastname_roma">
								<?php else: ?>
									<input type="text" value="<?php echo e(old('lastname_roma')); ?>" class="form-control" name="lastname_roma" id="lastname_roma">
								<?php endif; ?>
								<?php if($errors->has('lastname_roma')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('lastname_roma')); ?></span>
								</span>
								<?php endif; ?>
								
							</div>
						</div>
						<div class="form-group row <?php echo e($errors->has('firstname_yomi') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname_yomi') ? ' has-danger' : ''); ?>">
							<label class="control-label col-md-2 text-md-right" for="lastname_roma">姓カタカナ:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->firstname_yomi); ?>" class="form-control" name="firstname_yomi" id="firstname_yomi">
								<?php else: ?>
									<input type="text" value="<?php echo e(old('firstname_yomi')); ?>" class="form-control" name="firstname_yomi" id="firstname_yomi">
								<?php endif; ?>
								<?php if($errors->has('firstname_yomi')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('firstname_yomi')); ?></span>
								</span>
								<?php endif; ?>
							</div>
			
							<label class="control-label col-md-2 text-md-right" for="lastname_yomi"> 名カタカナ:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->lastname_yomi); ?>" class="form-control" name="lastname_yomi" id="lastname_yomi">
								<?php else: ?>
									<input type="text" value="<?php echo e(old('lastname_yomi')); ?>" class="form-control" name="lastname_yomi" id="lastname_yomi">
								<?php endif; ?>
								<?php if($errors->has('lastname_yomi')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('lastname_yomi')); ?></span>
								</span>
								<?php endif; ?>
								
							</div>
						</div>
						<div class="form-group row <?php echo e($errors->has('gender') ? ' has-danger' : ''); ?> <?php echo e($errors->has('birthday') ? ' has-danger' : ''); ?>">
							<label class="control-label col-md-2 text-md-right" for="gender">性別:</label>
							<div class="col-md-2">
								<?php if($action == "edit"): ?>
									<select class="form-control" name="gender" id="gender" style="height:34px;">
									
									<?php for($i = 1; $i < 3; $i++): ?>
										<option value="<?php echo e($i); ?>" <?php if($teacher->gender == $i): ?> selected <?php endif; ?>><?php echo e(config('consts')['USER']['GENDER'][$i]); ?></option>
									<?php endfor; ?>
									</select>
								<?php else: ?>
									<select class="form-control" name="gender" id="gender" style="height:34px;" id="gender">
									
									<?php for($i = 1; $i < 3; $i++): ?>
										<option value="<?php echo e($i); ?>" <?php if(old('gender') == $i): ?> selected <?php endif; ?>><?php echo e(config('consts')['USER']['GENDER'][$i]); ?></option>
									<?php endfor; ?>
									</select>
								<?php endif; ?>
								<?php if($errors->has('gender')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('gender')); ?></span>
								</span>
								<?php endif; ?>
							</div>

							<label class="control-label col-md-3 text-md-right" for="brithday"> 生年月日:</label>
							<div class="col-md-2">
								<?php if($action == "edit"): ?>
									<input required type="text" readonly="true" name="birthday" value="<?php echo e($teacher->birthday); ?>" id="birthday" class="form-control date-picker">
								<?php else: ?>
									<input required type="text" readonly="true" name="birthday" value="<?php echo e(old('birthday') !='' ? old('birthday') : (isset($_GET['birthday']) ?  $_GET['birthday'] : '')); ?>" id="birthday" class="form-control date-picker">
								<?php endif; ?>
								<?php if($errors->has('birthday')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('birthday')); ?></span>
								</span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="form-group row <?php echo e($errors->has('r_password') ? ' has-danger' : ''); ?>">
							<label class="control-label col-md-2 text-md-right" for="username">読Qネーム<br>(自動入力):</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="text" value="<?php echo e($teacher->username); ?>" class="form-control" name="username" readonly>
								<?php else: ?>
									<input type="text" value="<?php echo e(old('username')); ?>" class="form-control" name="username" id="username" readonly>
								<?php endif; ?>
							</div>
			
							<label class="control-label col-md-2 text-md-right" for=""> パスワード<br>(自動生成入力）:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<?php if(isset($teacher) && isset($teacher->School) && $teacher->School->id == Auth::id()): ?> 
										<input type="text" value="<?php echo e($teacher->r_password); ?>" class="form-control" name="r_password" id="r_password">
									<?php else: ?>
										<input type="text"  value="" placeholder="●●●●●●●"  class="form-control" name="r_password" id="r_password">
									<?php endif; ?>
								<?php else: ?>
									<input type="text" value="<?php echo e(old('r_password')); ?>" class="form-control" name="r_password" id="r_password">
								<?php endif; ?>
								<?php if($errors->has('r_password')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('r_password')); ?></span>
								</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group row <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">								
							<label class="control-label col-md-2 text-md-right" for="email">メールアドレス:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<input type="email" value="<?php echo e($teacher->email); ?>" class="form-control" name="email" id="email">
								<?php else: ?>
									<input type="email" value="<?php echo e(old('email')); ?>" class="form-control" name="email" id="email">
								<?php endif; ?>
								<?php if($errors->has('email')): ?>
									<span class="form-control-feedback">
										<span><?php echo e($errors->first('email')); ?></span>
									</span>
								<?php endif; ?>
							</div>
							<label class="control-label col-md-2 text-md-right" >種類:</label>
							<div class="col-md-3">
								<?php if($action == "edit"): ?>
									<select class="form-control" name="role" id="role" style="height:34px;">
									<?php for($i = 4; $i < 9; $i++): ?>
										<option value="<?php echo e($i); ?>" <?php if($teacher->role == $i): ?> selected <?php endif; ?>><?php echo e(config('consts')['USER']['TYPE'][$i]); ?></option>
									<?php endfor; ?>
									</select>
								<?php else: ?>
									<select class="form-control" name="role"  id="role" style="height:34px;">
									
									<?php for($i = 4; $i < 9; $i++): ?>
										<option value="<?php echo e($i); ?>"><?php echo e(config('consts')['USER']['TYPE'][$i]); ?></option>
									<?php endfor; ?>
									</select>
								<?php endif; ?>
							</div>
						</div>

						<div class="form-group row" style="margin-bottom:0px">
							<label class="control-label col-md-2 text-md-right" for="address4" style="margin-top:20px">住所:&nbsp;〒</label>
							<div class="col-md-1">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input type="text" name="address4" value="<?php echo e(old('address4')!='' ? old('address4'):( isset($teacher)? $teacher->address4: '')); ?>" class="form-control" id="address4" placeholder="251"/>
									</div>
									<!-- <div class="col-xs-9" style="padding-left:10px;">
										<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字3行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address4')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address4')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="cross2-xs" >―</span>
							<div class="col-md-1">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input type="text" name="address5" value="<?php echo e(old('address5')!='' ? old('address5'):( isset($teacher)? $teacher->address5: '')); ?>" class="form-control" id="address5" placeholder="0043"/>
									</div>
									<!-- <div class="col-xs-9" style="padding-left:10px;">
										<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字4行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address5')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address5')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<div class="col-md-2
								<?php if($errors->has('address1')): ?>
									has-danger
								<?php endif; ?>">
								<span class="col-xs-12" style="font-size:10px;padding-left:0px">都道府県</span>
								<div class="col-md-12 col-xs-6" style="padding:0px;">
									<input required type="text" name="address1" value="<?php echo e(old('address1')!='' ? old('address1'):( isset($teacher)? $teacher->address1: '')); ?>" class="form-control" placeholder="神奈川県">
								</div>
								<?php if($errors->has('address1')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address1')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
							<div class="col-md-2
									<?php if($errors->has('address1')): ?>
										has-danger
									<?php endif; ?>">
								<span class="col-xs-12" style="font-size:10px;padding-left:0px">市区郡町村</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-6" style="padding:0px;">
										<input required type="text" name="address2" value="<?php echo e(old('address2')!='' ? old('address2'):( isset($teacher)? $teacher->address2: '')); ?>" class="form-control" placeholder="横浜市青葉区">
									</div>
								</div>
								<?php if($errors->has('address2')): ?>
								<span class="form-control-feedback has-danger">
									<span><?php echo e($errors->first('address2')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
							<div class="col-md-2">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-6" style="padding:0px;">
										<input type="text" name="address3" class="form-control popover-help" value="<?php echo e(old('address3')!='' ? old('address3'):( isset($teacher)? $teacher->address3: '')); ?>" placeholder="美しが丘東"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。" >
									</div>
								</div>
								<!-- <?php if($errors->has('address3')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address3')); ?></span>
								</span>
								<?php endif; ?> -->
							</div>
							<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
						</div>
						<div class="form-group row
							<?php if($errors->has('address6') || $errors->has('address7') || $errors->has('address8') || $errors->has('address10')): ?>
								has-danger
							<?php endif; ?>">
							<div class="control-label col-md-2 text-md-right"></div>				
							<div class="col-md-1">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input  type="text" name="address6" value="<?php echo e(old('address6')!='' ? old('address6'):( isset($teacher)? $teacher->address6: '')); ?>" class="form-control" id="address6" placeholder="5"/>
									</div>
									<div class="col-xs-9" style="font-size:10px;padding-left:10px;">
										<span class="show-xs" style="padding-left:0px;padding-top:8px">(丁目)</span>
									</div>
									<!--<div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
										<span class="show-xs" style="color:red;padding-left:0px;">数字5行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address6')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address6')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="cross2-xs" >―</span>
							<div class="col-md-1">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input  type="text" name="address7" value="<?php echo e(old('address7')!='' ? old('address7'):( isset($teacher)? $teacher->address7: '')); ?>" class="form-control" id="address7" placeholder="8"/>
									</div>
									<div class="col-xs-9" style="font-size:10px;padding-left:10px;">
										<span class="show-xs" style="padding-left:0px;padding-top:8px">(番)</span>
									</div>
									<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
										<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address7')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address7')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="cross2-xs" >―</span>
							<div class="col-md-1">
								<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input  type="text" name="address8" value="<?php echo e(old('address8')!='' ? old('address8'):( isset($teacher)? $teacher->address8: '')); ?>" class="form-control" id="address8" placeholder="24"/>
									</div>
									<div class="col-xs-9" style="font-size:10px;padding-left:10px;">
										<span class="show-xs" style="padding-left:0px;padding-top:8px">(号)</span>
									</div>
									<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
										<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address8')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address8')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
							<div class="col-md-2">
								<span class="col-xs-12" style="font-size:10px;padding-left:0px">建物名</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-6" style="padding:0px;">
										<input type="text" name="address9" value="<?php echo e(old('address9')!='' ? old('address9'):( isset($teacher)? $teacher->address9: '')); ?>" class="form-control" placeholder="フラワーマンション"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。">
									</div>
								</div>
								<?php if($errors->has('address9')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address9')); ?></span>
								</span>
								<?php endif; ?>
							</div>
							<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
							<div class="col-md-2">
								<span class="col-xs-12" style="font-size:10px;padding-left:0px">部屋番号、階数</span>
								<div class="col-md-12 col-xs-12" style="padding:0px;">
									<div class="col-md-12 col-xs-3" style="padding:0px;">
										<input  type="text" name="address10" value="<?php echo e(old('address10')!='' ? old('address10'):( isset($teacher)? $teacher->address10: '')); ?>" class="form-control" id="address10" placeholder="2F"/>
									</div>
									<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
										<span class="show-xs" style="color:red;padding-left:0px;">英数字5行しか入らないように欄を小さく</span>
									</div> -->
								</div>
								<?php if($errors->has('address10')): ?>
								<span class="form-control-feedback">
									<span><?php echo e($errors->first('address10')); ?></span>
								</span>
								<?php endif; ?>
							</div>			
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right" for="email">今年度役割:</label>
							<!--<div class="col-md-3 control-label" style="text-align:left">
							<?php echo e(Auth::user()->group_name); ?> / 
							<?php if($action == "edit"): ?>
								<?php echo e(config('consts')['USER']['TYPE'][$teacher->role]); ?>

							<?php else: ?>
								<?php echo e(config('consts')['USER']['TYPE'][4]); ?>

							<?php endif; ?>
							<?php echo e(Date('Y')); ?>年度
												
							</div>-->
							<label class="control-label col-md-5 text-md-left" style="font-size: 16px;" id="result"></label>
						</div>
						<?php if($action == "edit"): ?>
						<div class="form-group">
							<div class="col-md-5">
								<h4 class="text-md-center">役割履歴</h4>
										<?php $before_year = 0; $before_groupname = '';
											$current_year = 0; $current_groupname = ''; 
											$bShow = false; 
											?>

										<?php $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											
											<?php  $current_year = $history->year; 
													$current_groupname = $history->group_name;
													$bShow = false; ?>
											<?php if(Auth::id() == $history->group_id): ?>
												<label class="control-label col-md-12 " style="text-align:center; font-size:16px;">
													
													<?php if($history->grade == 0): ?>
														<?php if($history->class_number !== null): ?> <?php echo e($history->class_number); ?>学級 <?php endif; ?>
													<?php elseif($history->grade == 0 && ($history->class_number == '' || $history->class_number == null)): ?>
														<?php echo e($history->grade); ?>年
													<?php else: ?>
														<?php echo e($history->grade); ?>-<?php echo e($history->class_number); ?>学級
													<?php endif; ?>
													<?php if($teacher->id == $history->teacher_id): ?>
														<?php echo e($teacher->firstname); ?> <?php echo e($teacher->lastname); ?><?php endif; ?>
													(<?php if($history->teacher_role == 4): ?>教師<?php elseif($history->teacher_role == 5): ?>司書<?php elseif($history->teacher_role == 6): ?>代表（校長、教頭等）<?php elseif($history->teacher_role == 7): ?>IT担当者<?php else: ?>その他<?php endif; ?>)
													
													/<?php echo e($history->year); ?>年度
													<?php if($history->member_counts != 0 && $history->member_counts !==null): ?>/<?php echo e($history->member_counts); ?>名<?php endif; ?>
												</label>
											<?php else: ?>
												<?php
													if($before_year != $current_year){
														echo("<label class='control-label col-md-12' style='text-align:center; font-size:16px;'>当校に在籍せず/".$history->year.'年度</label>');
														$before_year = $current_year;
														$bShow = true;
													}

													/*if ( $before_groupname !=  $current_groupname) {
														if ( $bShow == false )
															echo("<label class='control-label col-md-12' style='text-align:center; font-size:16px;'>当校に在籍せず/".$history->year.'年度</label>');
															
														$before_groupname = $current_groupname; 
													}
													*/												
												 ?>
											<?php endif; ?>
																			
											
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									
							</div>
							<div class="col-md-7">
								<table class="table table-bordered  table-hover table-striped">
									<thead >
										<tr class="info">
											<th class="text-md-center text-sm-center">権限の種類</th>
											<th class="text-md-center text-sm-center">権限の有無</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										<?php $__currentLoopData = config('consts')['USER']['RIGHTS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$right): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td><strong><?php echo e($key); ?></strong> - <?php echo e($right); ?></td>
												<td class="text-md-center text-sm-center align-middle">
														<i name="<?php echo e($key); ?>" id="<?php echo e($key); ?>" class="fa <?php echo e($key=='F' && ($teacher->role !=  6 || $teacher->role !=  7)? 'fa-times': 'fa-circle-o'); ?>"></i>
												</td>
											</tr>	
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>
						</div>
						<?php endif; ?>
						<div class="form-group">
							<div class="col-md-6 offset-md-3 text-md-center">
								<button type="button" id="confirm" class="btn btn-primary hidden" >確認して更新</button>
								<button type="button" id="card_move" class="btn btn-primary hidden" >当団体の教員カードに登録し、権限の委譲をする</button>
								<a class="btn btn-info" href="<?php echo e(url($forwardurl)); ?>">戻　る</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong><?php echo e(config('consts')['MESSAGES']['21B1']); ?></strong></h4>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">
							<?php echo e(csrf_field()); ?>

							<input type="hidden" name="id" id="id" value="<?php echo e(Auth::id()); ?>">
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

	<div id="moveModal" class="modal fade draggable draggable-modal" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	    	<div class="modal-header">
	        	<h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
	      	</div>
	      	<div class="modal-body">
	        	<span id="alert_text">この教員を貴団体の教員カードに登録して、権限の委譲をしますか?</span>
	     	</div>
	        <div class="modal-footer">
	            <button type="button" data-dismiss="modal" class="btn btn-primary yes_btn" >確　認</button>
	            <button type="button" data-dismiss="modal" class="btn btn-info modal-close">戻　る</button>
	        </div>
	    </div>

	  </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();

			<?php if($action == "create"): ?>
				$('#confirm').removeClass('hidden');
			<?php else: ?>				
				<?php if(isset($teacher) && $teacher->active == 1 && isset($teacher->School) && $teacher->School->id == Auth::id()): ?> 
					$('#confirm').removeClass('hidden');
				<?php else: ?>
					$('#card_move').removeClass('hidden');
					$('#firstname').attr('disabled', true);
					$('#firstname_roma').attr('disabled', true);
					$('#lastname_roma').attr('disabled', true);
					$('#firstname_yomi').attr('disabled', true);
					$('#lastname_yomi').attr('disabled', true);
					$('#gender').attr('disabled', true);
					$('#r_password').attr('disabled', true);
					$('#email').attr('disabled', true);
					$('#role').attr('disabled', true);
				<?php endif; ?>
			<?php endif; ?>
			$('#confirm').click(function(){
				//if($('#id').val() == "create"){
					$("#form-validation").attr("method", "post");
			    	$("#form-validation").attr("action",'<?php echo e(url("/group/teacher/update")); ?>');
			    	$("#form-validation").submit();
				//}
				
		    });

		    $('#card_move').click(function(){
				$('#moveModal').modal('show');
		    });

		    $('.yes_btn').click(function(){
				$('#card_move').addClass('hidden');
				$('#confirm').removeClass('hidden');
				<?php if(isset($teacher)): ?>
					$('#r_password').val("<?php echo e($teacher->r_password); ?>");
				<?php endif; ?>
				$('#firstname').attr('disabled', false);
				$('#firstname_roma').attr('disabled', false);
				$('#lastname_roma').attr('disabled', false);
				$('#firstname_yomi').attr('disabled', false);
				$('#lastname_yomi').attr('disabled', false);
				$('#gender').attr('disabled', false);
				$('#r_password').attr('disabled', false);
				$('#email').attr('disabled', false);
				$('#role').attr('disabled', false);
		    });

		    $("#lastname_roma").keyup(function(){
				var lastname_roma = $(this).val();
				var ran = new String(Math.random());
				var ran1 = ran.substring(2,5); 
				
				$("#username").val(lastname_roma.toLowerCase() + "0"+ ran1 + $("#gender").val() + "s");
				//$("#username").val(lastname_roma.toLowerCase() + "0"+ Math.floor(Math.random()*1000000/1000) + $("#gender").val() + "s");
			});

			$("#gender").change(function(){
				var lastname_roma = $("#lastname_roma").val();
				var ran = new String(Math.random());
				var ran1 = ran.substring(2,5); 
				
				$("#username").val(lastname_roma.toLowerCase() + "0"+ ran1 + $("#gender").val() + "s");
				//$("#username").val(lastname_roma.toLowerCase() + "0"+ Math.floor(Math.random()*1000000/1000) + $("#gender").val() + "s");
			});

			<?php if($action != 'edit'): ?>
				$("#r_password").val(Math.floor(Math.random() * 10000000000 / 100));
			<?php endif; ?>

			 var oldBirthday = "";

			 $("#birthday").change(function() {
			    if ($("#birthday").val() == "" || oldBirthday == $("#birthday").val()) {
			        return;
			    }
			    oldBirthday = $("#birthday").val()
			    //handleDupUserCheck();
			});

			$("#role").change(function(){
				handleRole();

		    });

		    var handleRole = function(){
		    	<?php if(isset($teacher) && $teacher->active == 1): ?>
			    	var str = '';
			    	str += '<?php echo e(Auth::user()->group_name); ?>' + '/';
			 		str += $("#role  option:selected").text() + '/';
			 		//var today = new Date();
			 		str += <?php echo e($current_season['year']); ?> + '年度';  			    		
			    	
			 		$("#result").html(str);

			 		<?php if($action == 'edit'): ?>
				 		//代表（校長、教頭等）, IT担当者 
				 		if($("#role").val() == "<?php echo e(config('consts')['USER']['ROLE']['REPRESEN']); ?>" || $("#role").val() == "<?php echo e(config('consts')['USER']['ROLE']['ITMANAGER']); ?>")
							$("#F").removeClass('fa-times').addClass('fa-circle-o');
						else
							$("#F").removeClass('fa-circle-o').addClass('fa-times');
					<?php endif; ?>
				<?php endif; ?>
		    }

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

		    var handleInputMasks = function () {
		        $.extend($.inputmask.defaults, {
		            'autounmask': true
		        });

		        $("#birthday").inputmask("y/m/d", {
		            //"placeholder": "yyyy/mm/dd"
		        }); //multi-char placeholder
		        $("#phone").inputmask("mask", {
		            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
		        });
		        $("#address4").inputmask("mask", {
			        "mask":"999"
		        });
				$("#address5").inputmask("mask", {
			        "mask":"9999"
		        });
				$("#address6").inputmask("mask",{
			        "mask":"99999"
				});
				$("#address7").inputmask("mask",{
			        "mask":"9999"
				});
				$("#address8").inputmask("mask",{
			        "mask":"9999"
				});$("#address10").inputmask("mask",{
			        "mask":"*****"
				});

		    }
		    handleDatePickers();
		    handleInputMasks();
		    handleRole();
		});	

		</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>