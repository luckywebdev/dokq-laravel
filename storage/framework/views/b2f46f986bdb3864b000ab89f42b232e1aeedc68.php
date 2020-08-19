<form class="form register-form"  id="validate-form" method="post" role="form" action="<?php echo e(url('/mypage/edit_info/update')); ?>">
	<?php if(count($errors) > 0 && $errors->has('servererr')): ?>
		<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
	<?php echo e(csrf_field()); ?>

	<input type="hidden" id="email" name="email" value="<?php echo e($user->email); ?>">
	<div class="form-body">
		<div class="row form-group">
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px" >
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch fullname_is_public" id="fullname_is_public" data-size="small" <?php if($user->fullname_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>
				
				<?php else: ?>
					
				<?php endif; ?>

				<div class="tools">
					<label class="label-above">氏名</label>													
				</div>
				<?php if($type == 'other_view'&& $edit != 1 && ($user->fullname_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info" id="name" name="name" value="aaaaa" readonly>
				<?php elseif($type == 'view'&& ($user->fullname_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info" id="name" name="name" value="aaaaa" readonly>
				<?php else: ?>
				<input type="text" class="form-control base_info" id="name" name="name" value="<?php if($user->isAuthor()): ?><?php echo e($user->fullname_nick()); ?><?php else: ?><?php echo e($user->fullname()); ?><?php endif; ?>" readonly>
				<?php endif; ?>
			</div>

			<div class="col-md-3 text-md-right" style="text-align:right;padding-top:5px">
				<!-- <?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>				
						<input type="checkbox" class="make-switch" id="fullname_yomi_is_public" data-size="small" <?php if($user->fullname_yomi_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>

				<?php else: ?>
					
				<?php endif; ?>	-->
				
				<div class="tools">
					<label class="label-above">フリガナ(全角）</label>								
				</div>
				<?php if($type == 'other_view' && $edit != 1 && ($user->fullname_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info" id="name_furi" value="aaaaa" readonly>
				<?php elseif($type == 'view' && ($user->fullname_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info" id="name_furi" value="aaaaa" readonly>
				<?php else: ?>
				<input type="text" class="form-control base_info" id="name_furi" value="<?php if($user->isAuthor()): ?><?php echo e($user->fullname_nick_yomi()); ?><?php else: ?><?php echo e($user->full_furiname()); ?><?php endif; ?>" readonly>
				<?php endif; ?>
			</div>
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>				
						<input type="checkbox" class="make-switch" id="gender_is_public" data-size="small" <?php if($user->gender_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>

				<?php else: ?>
					
				<?php endif; ?>

				<div class="tools">
					<label class="label-above">性別</label>													
				</div>

				<?php if($type == 'other_view'): ?>
					<?php if($edit != 1  && ($user->gender_is_public == 0 && $age >= 15)): ?>
						<input type="password" class="form-control base_info" name="gender" id="gender" value="aa" readonly disabled>
					<?php else: ?>
						<input type="text" class="form-control base_info" name="gender" id="gender" value="<?php echo e(config('consts')['USER']['GENDER'][$user->gender]); ?>" readonly disabled>
					<?php endif; ?>
				<?php elseif($type =="view"): ?>
					<?php if($user->gender_is_public == 0 && $age >= 15): ?>
						<input type="password" class="form-control base_info" name="gender" id="gender" value="aa" readonly disabled>
					<?php else: ?>
					<?php for($i = 1; $i < 3; $i++): ?>
	        			<?php if($user->gender == $i): ?> 
	        			<input type="text" class="form-control base_info" name="gender" id="gender" value="<?php echo e(config('consts')['USER']['GENDER'][$i]); ?>" readonly disabled>
	        			<?php endif; ?>
	        		<?php endfor; ?>
	        		<?php endif; ?>
				<?php else: ?>
				<select class="bs-select form-control base_info" name="gender" id="gender">
	        		<?php for($i = 1; $i < 3; $i++): ?>
	        			<option value="<?php echo e($i); ?>" <?php if($user->gender == $i): ?> selected <?php endif; ?>><?php echo e(config('consts')['USER']['GENDER'][$i]); ?></option>
	        		<?php endfor; ?>
	        	</select>
	        	<?php endif; ?> 				
			</div>
			<div class="col-md-3 text-md-right" style="text-align:right;padding-top:5px">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch" id="birthday_is_public" data-size="small" <?php if($user->birthday_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>
				
				<?php else: ?>
					
				<?php endif; ?>
				
				<div class="tools <?php echo e($errors->has('birthday') ? ' has-danger' : ''); ?> <?php echo e($errors->has('birthday') ? ' has-danger' : ''); ?>" >
					<label class="label-above">生年月日（半角）</label>
				</div>
				<?php if($type == 'other_view' && $edit != 1 && ($user->birthday_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info date-picker" id="birthday" name="birthday" value="aaaaa" <?php if($type!="edit"): ?> readonly disabled <?php endif; ?>>
				<?php elseif($type == 'view' && ($user->birthday_is_public == 0 || $age < 15)): ?>
				<input type="password" class="form-control base_info date-picker" id="birthday" name="birthday" value="aaaaa" <?php if($type!="edit"): ?> readonly disabled <?php endif; ?>>
				<?php else: ?>
				<input type="text" class="form-control base_info date-picker" id="birthday" name="birthday" value="<?php echo e(old('birthday')!='' ? old('birthday'):( isset($user)? $user->birthday: '')); ?>" <?php if($type!="edit"): ?> readonly disabled <?php endif; ?>>
				<?php endif; ?>
				<?php if($errors->has('birthday')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('birthday')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch" id="role_is_public" data-size="small" <?php if($user->role_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>
				
				<?php else: ?>
					
				<?php endif; ?>
				
				<div class="tools">
					<label class="label-above">属性</label>												
				</div>
				<?php if($type == 'other_view' && $edit != 1  && ($user->role_is_public == 0|| $age < 15)): ?>
				<input type="password" class="form-control base_info" name="" id="" value="aaaa" readonly disabled>
				<?php elseif($type == 'view' && ($user->role_is_public == 0|| $age < 15)): ?>
				<input type="password" class="form-control base_info" name="" id="" value="aaaa" readonly disabled>
				<?php else: ?>
				<input type="text" class="form-control base_info" name="" id="" value="<?php if($user->isGroupSchoolMember() && $user->active == 1): ?>教職員会員<?php elseif($user->isGroupSchoolMember() && $user->active == 2): ?>教職員準会員	<?php elseif($user->isGeneral() && $user->active == 1): ?>一般会員<?php elseif($user->isGeneral() && $user->active == 2): ?>一般準会員<?php elseif($user->isPupil() && $user->active == 1): ?><?php echo e(config('consts')['PROPERTIES'][$user->properties]); ?> <?php elseif($user->isPupil() && $user->active == 2): ?>児童生徒準会員<?php elseif($user->isOverseer() && $user->active == 1): ?>	監修者会員<?php elseif($user->isOverseer() && $user->active == 2): ?>監修者準会員<?php elseif($user->isAuthor() && $user->active == 1): ?>著者会員	<?php elseif($user->isAuthor() && $user->active == 2): ?>著者準会員<?php endif; ?>" readonly disabled>
				<?php endif; ?>
			</div>
		</div>
		<?php if($user->isPupil() && $user->active == 1 && ($type!="other_view" || ($type=="other_view" && $edit == 1))): ?>
		<div class="row form-group">
		
			<?php if($type == "view"): ?>
			<?php elseif(isset($classes) && $classes != "" && ($pupilflag == 1 || $pupilflag == 2)): ?>
			<div class="col-md-4 text-md-right" >				
				<?php if($type!="other_view"): ?><label class="label-above" style="color:red">非公開</label><?php endif; ?>				
				<div class="tools">
					<label class="label-above">学級</label>													
				</div>

					<div class="input-group">
					<?php if(isset($pupilflag) && $pupilflag == 1): ?> 
						<?php if($type == 'other_view' && $edit == 1): ?>
							<input type="text" class="form-control base_info" id="class_1" name="class_1" value="<?php if($classes->grade != 0): ?> <?php echo e($classes->grade); ?>- <?php endif; ?><?php echo e($classes->class_number); ?> <?php if($classes->TeacherOfClass !== null): ?><?php echo e($classes->TeacherOfClass->fullname()); ?><?php endif; ?>学級/<?php echo e($classes->year); ?>年度" readonly >
						<?php else: ?>
							<input type="text" class="form-control base_info" id="class_1" name="class_1" value="<?php if($classes->grade != 0): ?> <?php echo e($classes->grade); ?>- <?php endif; ?><?php echo e($classes->class_number); ?> <?php if($classes->TeacherOfClass !== null): ?><?php echo e($classes->TeacherOfClass->fullname()); ?><?php endif; ?>学級/<?php echo e($classes->year); ?>年度" readonly >
						<?php endif; ?>
					<?php else: ?>
						<?php if($type == 'other_view' && $edit == 1): ?>
							<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<input type="text" class="form-control base_info" id="class_1" name="class_1" value="<?php if($class->grade != 0): ?> <?php echo e($class->grade); ?>- <?php endif; ?><?php echo e($class->class_number); ?> <?php if($class->TeacherOfClass !== null): ?><?php echo e($class->TeacherOfClass->fullname()); ?><?php endif; ?>学級/<?php echo e($class->year); ?>年度"  readonly >
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php else: ?>
							<?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<input type="text" class="form-control base_info" id="class_1" name="class_1" value="<?php if($class->grade != 0): ?> <?php echo e($class->grade); ?>- <?php endif; ?><?php echo e($class->class_number); ?> <?php if($class->TeacherOfClass !== null): ?><?php echo e($class->TeacherOfClass->fullname()); ?><?php endif; ?>学級/<?php echo e($class->year); ?>年度"  readonly >
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					<?php endif; ?>					
					</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="row form-group">
			<label class="control-label col-md-1 text-md-right address-xs" for="address4" >住所:&nbsp;〒</label>
			<div class="col-md-2 text-md-right <?php echo e($errors->has('address4') ? ' has-danger' : ''); ?>" style="text-align:right;">
				<div class="col-md-12 co-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<?php if($type=="edit"): ?>
						<?php if( $age >= 15 ): ?>
							<input type="checkbox" class="make-switch" id="address_is_public" data-size="small" <?php if($user->address_is_public == 1): ?> checked <?php endif; ?>>				
						<?php else: ?>
							<label class="label-above" style="color:red;text-align:right;">非公開</label>
						<?php endif; ?>
					<?php elseif($type == 'other_view'): ?>
						
					<?php else: ?>
						
					<?php endif; ?>
				</div>	
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($type == 'other_view' && $edit != 1 && ($user->address_is_public == 0 && $age >= 15)): ?>
					    <input required type="password" name="address4" value="aa"  class="form-control" id="address4" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php elseif($type == 'view' && ($user->address_is_public == 0 && $age >= 15)): ?>
					    <input required type="password" name="address4" value="aa"  class="form-control" id="address4" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php else: ?>
				    	<input required type="text" name="address4" value="<?php echo e(old('address4')!='' ? old('address4'):( isset($user)? $user->address4: '')); ?>"  class="form-control" id="address4" <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="251" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				    <!-- <div class="col-xs-9" style="padding-left:10px;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字3行しか入らないように欄を小さく</span>
					</div> -->
		    	</div>
				
		    	<?php if($errors->has('address4')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address4')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
			<div class="col-md-1 text-md-right <?php echo e($errors->has('address5') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<?php if($type == 'edit'): ?>
						<label class="label-above" style="color:red">非公開</label>													
					<?php endif; ?>
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>	
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($type == 'other_view' && $edit != 1): ?>
					    <input required type="password" name="address5" value="aa" class="form-control" id="address5"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view'): ?>
				    	<input required type="password" name="address5" value="aa" class="form-control" id="address5"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input required type="text" name="address5" value="<?php echo e(old('address5')!='' ? old('address5'):( isset($user)? $user->address5: '')); ?>"  class="form-control" id="address5"  <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="0043" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				    <!-- <div class="col-xs-9" style="padding-left:10px;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字4行しか入らないように欄を小さく</span>
					</div> -->
			    </div>
				
		    	<?php if($errors->has('address5')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address5')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<div class="col-md-2 text-md-right <?php echo e($errors->has('address1') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">都道府県</label>													
					</div>
					<?php if($type=="edit"): ?>
						<?php if( $age >= 15 ): ?>
							<input type="checkbox" class="make-switch" id="address1_is_public" data-size="small" <?php if($user->address1_is_public == 1): ?> checked <?php endif; ?>>				
						<?php else: ?>
							<label class="label-above" style="color:red">非公開</label>
						<?php endif; ?>
					<?php elseif($type == 'other_view'): ?>
						
					<?php else: ?>
						
					<?php endif; ?>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<?php if($type == 'other_view' && $edit != 1 && ($user->address1_is_public == 0 && $age >= 15)): ?>
						<input required type="password" name="address1" id="address1" value="aa"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php elseif($type == 'view' && ($user->address1_is_public == 0 && $age >= 15)): ?>
						<input required type="password" name="address1" id="address1" value="aa"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php else: ?>
				    	<input required type="text" name="address1" id="address1" value="<?php echo e(old('address1')!='' ? old('address1'):( isset($user)? $user->address1: '')); ?>"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="神奈川県" <?php endif; ?>>
				    	<?php endif; ?>
				    </div>
				</div>
		    	<?php if($errors->has('address1')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address1')); ?></span>
				</span>
				<?php endif; ?> 				
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
			<div class="col-md-2 text-md-right <?php echo e($errors->has('address2') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">市区郡町村</label>													
					</div>
					<?php if($type=="edit"): ?>
						<?php if( $age >= 15 ): ?>
							<input type="checkbox" class="make-switch" id="address2_is_public" data-size="small" <?php if($user->address2_is_public == 1): ?> checked <?php endif; ?>>				
						<?php else: ?>
							<label class="label-above" style="color:red">非公開</label>
						<?php endif; ?>
					<?php elseif($type == 'other_view'): ?>
						
					<?php else: ?>
						
					<?php endif; ?>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<?php if($type == 'other_view' && $edit != 1 && ($user->address2_is_public == 0 && $age >= 15)): ?>
						<input required type="password" name="address2" id="address2" value="aa"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view' && ($user->address2_is_public == 0 && $age >= 15)): ?>
						<input required type="password" name="address2" id="address2" value="aa"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input required type="text" name="address2" id="address2" value="<?php echo e(old('address2')!='' ? old('address2'):( isset($user)? $user->address2: '')); ?>"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="横浜市青葉区" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				</div>
				<?php if($errors->has('address2')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address2')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<span class="cross1-xs" >―</span>
			<div class="col-md-2 text-md-right <?php echo e($errors->has('address3') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<?php if($type == 'edit'): ?>
						<label class="label-above" style="color:red">町名番地非公開</label>													
					<?php endif; ?>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<?php if($type == 'other_view' && $edit != 1): ?>
						<input type="password" name="address3" id="address3" value="aa" class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view'): ?>
				    	<input type="password" name="address3" id="address3" value="aa" class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input type="text" name="address3" id="address3" value="<?php echo e(old('address3')!='' ? old('address3'):( isset($user)? $user->address3: '')); ?>"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="美しが丘東" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				</div>
		    	<?php if($errors->has('address3')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address3')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		</div>

		<div class="row form-group">
			<div class="control-label col-md-1 text-md-right"></div>	
		    <div class="col-md-2 text-md-right <?php echo e($errors->has('address6') ? ' has-danger' : ''); ?>" style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($type == 'other_view' && $edit != 1): ?>
						<input type="password" name="address6" id="address6" value="a"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				   		<?php elseif($type == 'view'): ?>
						<input type="password" name="address6" id="address6" value="a"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				   		<?php else: ?>
				   		<input type="text" name="address6" id="address6" value="<?php echo e(old('address6')!='' ? old('address6'):( isset($user)? $user->address6: '')); ?>"  class="form-control"  <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="5" <?php endif; ?> >
				   		<?php endif; ?>
				   	</div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(丁目)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字5行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		   		<?php if($errors->has('address6')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address6')); ?></span>
				</span>
				<?php endif; ?>
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 text-md-right <?php echo e($errors->has('address7') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($type == 'other_view' && $edit != 1): ?>
						<input type="password" name="address7" id="address7" value="a"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view'): ?>
						<input type="password" name="address7" id="address7" value="a"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input type="text" name="address7" id="address7" value="<?php echo e(old('address7')!='' ? old('address7'):( isset($user)? $user->address7: '')); ?>"  class="form-control" <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="8" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(番)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
					</div>  -->
				</div>
		    	<?php if($errors->has('address7')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address7')); ?></span>
				</span>
				<?php endif; ?>
			</div>	    
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-1 form-group <?php echo e($errors->has('address8') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    <?php if($type == 'other_view'&& $edit != 1): ?>
						<input type="password" name="address8" id="address8" value="aa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view'): ?>
						<input type="password" name="address8" id="address8" value="aa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input type="text" name="address8" id="address8" value="<?php echo e(old('address8')!='' ? old('address8'):( isset($user)? $user->address8: '')); ?>"  class="form-control" <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="24" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(号)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		    	<?php if($errors->has('address8')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address8')); ?></span>
				</span>
				<?php endif; ?>
		    </div>
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group <?php echo e($errors->has('address9') ? ' has-danger' : ''); ?> ">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">建物名</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">
					    <?php if($type == 'other_view' && $edit != 1): ?>
						<input type="password" name="address9" id="address9" value="aaa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php elseif($type == 'view'): ?>
						<input type="password" name="address9" id="address9" value="aaa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?> >
				    	<?php else: ?>
				    	<input type="text" name="address9" id="address9" value="<?php echo e(old('address9')!='' ? old('address9'):( isset($user)? $user->address9: '')); ?>"  class="form-control" <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="フラワーマンション" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				</div>
		    	<?php if($errors->has('address9')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('address9')); ?></span>
				</span>
				<?php endif; ?>
		    </div>
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group <?php echo e($errors->has('address10') ? ' has-danger' : ''); ?> ">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">部屋番号、階数</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    <?php if($type == 'other_view' && $edit != 1): ?>
						<input type="password" name="address10" id="address10" value="aa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php elseif($type == 'view'): ?>
						<input type="password" name="address10" id="address10" value="aa"  class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				    	<?php else: ?>
				    	<input type="text" name="address10" id="address10" value="<?php echo e(old('address10')!='' ? old('address10'):( isset($user)? $user->address10: '')); ?>"  class="form-control" <?php if($type!="edit"): ?> readonly <?php else: ?> placeholder="2F" <?php endif; ?> >
				    	<?php endif; ?>
				    </div>
				    <!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
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

		<div class="row form-group">
			<div class="col-md-4 text-md-right" style="text-align:right;">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch username_is_public" id="fullname_is_public" data-size="small" <?php if($user->fullname_is_public == 0): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>
				
				<?php else: ?>
					
				<?php endif; ?>

				<div class="tools">
					<label class="label-above">読Qネーム</label>													
				</div>	
				<?php if($type == 'other_view' && $edit != 1 && ($user->fullname_is_public == 1 || $age < 15)): ?>					
				<input type="password" name="username" value="aaaa" id="username" class="form-control" readonly>
				<?php elseif($type == 'view' && ($user->fullname_is_public == 1 || $age < 15)): ?>					
				<input type="password" name="username" value="aaaa" id="username" class="form-control" readonly>
				<?php else: ?>
				<input type="text" name="username" value="<?php echo e($user->username); ?>" id="username" class="form-control" readonly>
				<?php endif; ?>
			</div>
			<div class="col-md-4 text-md-right <?php echo e($errors->has('phone') ? ' has-danger' : ''); ?> " style="text-align:right;">
				<?php if($type == 'edit'): ?>
				<label class="label-above" style="color:red">非公開</label>
				<?php endif; ?>
				<div class="tools">
					<label class="label-above">電話</label>													
				</div>	
				<?php if($type == 'other_view' && $edit != 1 ): ?>
				<input type="password" name="phone"  id="phone" value="aaaaa" class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php elseif($type == 'view'): ?>
				<input type="password" name="phone"  id="phone" value="aaaaa" class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="phone"  id="phone" value="<?php echo e(old('phone')!='' ? old('phone'):( isset($user)? $user->phone: '')); ?>" class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
				<?php if($errors->has('phone')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('phone')); ?></span>
				</span>
				<?php endif; ?>
			</div>

			<div class="col-md-4 text-md-right <?php echo e($errors->has('r_password') ? ' has-danger' : ''); ?> <?php echo e($errors->has('r_password') ? ' has-danger' : ''); ?>" style="text-align:right;">
				<?php if($type =="edit"): ?>
				<label class="label-above" style="color:red">非公開</label>
				<?php endif; ?>
				<div class="tools">
					<label class="label-above">パスワード</label>													
				</div>	
				<?php if(($type == 'other_view' && $edit != 1) || $type == 'view'): ?>
				<input type="password" name="r_password"  id="r_password" value="aaa" class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="r_password"  id="r_password" value="<?php echo e(old('r_password')!='' ? old('r_password'):( isset($user)? $user->r_password: '')); ?>" class="form-control" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
				<?php if($errors->has('r_password')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('r_password')); ?></span>
				</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4 text-md-right" style="text-align:right;">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch" id="org_id_is_public" data-size="small" <?php if($user->org_id_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>

				<?php else: ?>
					
				<?php endif; ?>
				<div class="tools">
					<label class="label-above">所属１</label>										
				</div>
				<?php if($type == 'other_view' && $edit != 1 && ($user->org_id_is_public == 0 && $age >= 15)): ?>
			    <input required type="password" name="group_name" value="aaa"  class="form-control" id="group_name" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
		    	<?php elseif($type == 'view' && ($user->org_id_is_public == 0 && $age >= 15)): ?>
		    	<input required type="password" name="group_name" value="aaa"  class="form-control" id="group_name" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="group_name" class="form-control" id="group_name" value="<?php echo e(old('group_name')!='' ? old('group_name'):( isset($user)? $user->group_name: '')); ?>" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
			</div>

			<div class="col-md-4 text-md-right" style="text-align:right;">
				<?php if($type=="edit"): ?>
					<?php if( $age >= 15 ): ?>
						<input type="checkbox" class="make-switch" id="groupyomi_is_public" data-size="small" <?php if($user->groupyomi_is_public == 1): ?> checked <?php endif; ?>>				
					<?php else: ?>
						<label class="label-above" style="color:red">非公開</label>
					<?php endif; ?>
				<?php elseif($type == 'other_view'): ?>

				<?php else: ?>
					
				<?php endif; ?>
								
				<div class="tools">
					<label class="label-above">所属 2</label>						
				</div>
				<?php if($type == 'other_view' && $edit != 1 && ($user->groupyomi_is_public == 0 || $age < 15)): ?>
				<input type="password" name="group_yomi" class="form-control" id="group_yomi" value="aaa" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php elseif($type == 'view' && ($user->groupyomi_is_public == 0 || $age < 15)): ?>
				<input type="password" name="group_yomi" class="form-control" id="group_yomi" value="aaa" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="group_yomi" class="form-control" id="group_yomi" value="<?php echo e(old('group_yomi')!='' ? old('group_yomi'):( isset($user)? $user->group_yomi: '')); ?>" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
			</div>

			<?php if(isset($pupilflag) && $pupilflag == 1): ?> 
			<div class="col-md-4 text-md-right" style="text-align:right;">
				<?php if($type == "edit"): ?>
				<label class="label-above" style="color:red">非公開</label>
				<div class="tools">
					<label class="label-above">この基本情報編集権限保持者</label>													
				</div>
				<input type="text" name="representer" class="form-control" id="representer" value="<?php if($user->org_id > 0): ?>本人、学校代表、担任教師 <?php endif; ?>" readonly>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		</div>
				
		<div class="row form-group ">
			<div class="col-md-4 text-md-right<?php echo e($errors->has('email') ? ' has-danger' : ''); ?> <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>" style="text-align:right;">
				<?php if($type == "edit"): ?>
				<label class="label-above" style="color:red">非公開</label>
				<?php endif; ?>
				<div class="tools">
					<label class="label-above">メールアドレス（半角英数）</label>													
				</div>
				<?php if($type == 'other_view' && $edit != 1 ): ?>
				<?php $firststr = substr ($user->email, 0, 1); $email = $firststr."••••";?>
				<input type="text" name="email" class="form-control" id="email" value="<?php echo e($email); ?>" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php elseif($type == 'view'): ?>
				<?php $firststr = substr ($user->email, 0, 1); $email = $firststr."••••";?>
				<input type="text" name="email" class="form-control" id="email" value="<?php echo e($email); ?>" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="email" class="form-control" id="email" value="<?php echo e(old('email')!='' ? old('email'):( isset($user)? $user->email: '')); ?>" <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
				<?php if($errors->has('email')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('email')); ?></span>
				</span>
				<?php endif; ?>
			</div>

			<div class="col-md-4 text-md-right" style="text-align:right;">
				<?php if($type == "edit"): ?>
				<label class="label-above" style="color:red">公開</label>
				<?php endif; ?>
				<div class="tools">
					<label class="label-above">会費支払い方法</label>													
				</div>
				<?php if($user->isPupil()): ?>
				<input type="text" name="payment" class="form-control" id="payment" value="<?php if($user->properties == 0): ?><?php echo e(config('consts')['PAYMENT_METHOD'][0]); ?><?php elseif($user->pay_content !== null && $user->pay_content !== ''): ?><?php echo e(config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'); ?><?php else: ?><?php echo e(''); ?><?php endif; ?>"  readonly <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php else: ?>
				<input type="text" name="payment" class="form-control" id="payment" value="<?php if($user->properties == 0): ?><?php echo e(''); ?><?php elseif($user->pay_content !== null && $user->pay_content !== ''): ?><?php echo e(config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'); ?><?php else: ?><?php echo e(''); ?><?php endif; ?>"  readonly <?php if($type!="edit"): ?> readonly <?php endif; ?>>
				<?php endif; ?>
			</div>
		</div>
		<?php if($type != "other_view"): ?>
		<div class="row form-group">
			<div class="col-md-12">				
				<div class="row">
					<div class="col-md-4">	
										
						<!-- <a href="<?php echo e(url('/mypage/face_verify/2')); ?>" class="btn btn-warning pull-left" style="margin-bottom:8px;">顔認証登録</a> -->
						
					</div>					
					<div class="col-md-4">
						<?php if($type == "view"): ?>
							<?php if(Auth::user()->isPupil() && Auth::user()->group_type == 0 ): ?>
							<a href="<?php echo e(url('/mypage/recognize')); ?>" class="btn btn-warning pull-left" style="margin-bottom:8px;" disabled >顔認証して閲覧・編集する</a>
							<?php else: ?>
							<a href="<?php echo e(url('/mypage/recognize')); ?>" class="btn btn-warning pull-left" style="margin-bottom:8px;" >顔認証して閲覧・編集する</a>
							<?php endif; ?>
						<?php elseif($type == "edit"): ?>
							<?php if(Auth::user()->isPupil() && Auth::user()->group_type == 0 ): ?>
								<button type="button" class="btn btn-primary pull-left" id="update_info" style="margin-bottom:8px;" disabled>確認して更新</button>
							<?php else: ?>
								<button type="button" class="btn btn-primary pull-left" id="update_info" style="margin-bottom:8px;">確認して更新</button>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<div class="col-md-4">
						<!-- <a href="<?php echo e(url('/mypage/face_verify/1')); ?>" class="btn btn-warning pull-right">会費支払い方法を変更する</a> -->
					</div>
				</div>
			</div>
			
			
		</div>
		<?php endif; ?>
	</div>
</form>
