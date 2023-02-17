


<?php $__env->startSection('contents'); ?>
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][1];
	$auth_types = config('consts')['USER']['AUTH_TYPE'][$type];
	$genders = config('consts')['USER']['GENDER'];
	$purposes = config('consts')['USER']['PURPOSE'][1];
	$doc = config('consts')['USER']['DOCS'][$type];
?>
<div class="container register">
	<div class="form">
		<form class="form-horizontal" method="post" role="form" action="<?php echo e(route('auth/doregister')); ?>">
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="<?php echo e(url('/')); ?>">
						<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_reserve_2.png')); ?>">
                        <!-- <h1 style="margin: 0 !important;  font-family: 'Ms Mincho', 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN', 'Roboto Serif' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', 'Maven Pro', sans-serif !important;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
                        <h6 style="margin: 0 !important; font-family:'Ms Mincho', 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN', 'Roboto Serif' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', 'Maven Pro', sans-serif !important;">読書認定級</h6> -->
                    </a>
			    </div>
				<div class="form-body col-md-11">
					<ul class="nav nav-pills nav-fill steps">
						<li class="nav-item active">
							<span class="step">
								<span class="number"> 1 </span>
								<span class="desc">
									<i class="fa fa-check"></i> ステップ１
								</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 33%;">
						</div>
					</div>
				</div>
			</div>
			<div class="offset-md-9 col-md-3 col-xs-12">
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<input required type="hidden" name="helpdoc" id="helpdoc" value="<?php echo e($doc['PATH']); ?>">
					<input required type="hidden" id="pdfheight" name="pdfheight" value="">
					<button type="button" id="viewpdf" class="btn btn-info" style="color:white; margin-bottom:8px"><?php echo e($doc['TITLE']); ?></button>
				</div>
				<span class="col-xs-12" style="color:red;font-size:10px;padding-left:0px">※入力の途中でクリックすると、入力内容が消去されますのでご注意ください。</span>
			</div>
			
				<h3 class="text-md-center" style="text-align:center;">
					<?php echo e(config('consts')['USER']['TYPE'][$type]); ?><?php echo e($type == 2 ? '候補' :''); ?>会員登録申請フォーム
					<small style="color: #909090">(すべて必須項目です）</small>
				 </h3>
			 
			 <?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
			<?php echo e(csrf_field()); ?>

			<input type="hidden" name="role" value="<?php echo e($type); ?>">
			<?php if($isAuthor == 1): ?>
				<div class="form-group row <?php echo e($errors->has('firstname_nick') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname_nick') ? ' has-danger' : ''); ?>">
					<label class="control-label col-md-2 text-md-right" for="firstname_nick">ペンネーム  姓:</label>
					<div class="col-md-3">
						<?php if($data!=null): ?>
						<input required type="text" name="firstname_nick" value="<?php echo e($data->firstname_nick); ?>" class="big-form-control" placeholder="ペンネームを入力">
						<?php else: ?>
						<input required type="text" name="firstname_nick" value="<?php echo e(old('firstname_nick')); ?>" class="big-form-control" placeholder="ペンネームを入力">
            			<?php endif; ?>
						<?php if($errors->has('firstname_nick')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('firstname_nick')); ?></span>
						</span>
						<?php endif; ?>
					</div>

					<label class="control-label col-md-2 text-md-right" for="lastname_nick"> 名:</label>
					<div class="col-md-3">
						<?php if($data!=null): ?>
						<input required type="text" name="lastname_nick" value="<?php echo e($data->lastname_nick); ?>" class="big-form-control" placeholder="ペンネームを入力">
						<?php else: ?>
						<input required type="text" name="lastname_nick" value="<?php echo e(old('lastname_nick')); ?>" class="big-form-control" placeholder="ペンネームを入力">
            			<?php endif; ?>
						<?php if($errors->has('lastname_nick')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('lastname_nick')); ?></span>
						</span>
						<?php endif; ?>
					</div>
				</div>

				<div class="form-group row <?php echo e($errors->has('firstname_nick_yomi') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname_nick_yomi') ? ' has-danger' : ''); ?>">
					<label class="control-label col-md-2 text-md-right" for="firstname_yomi">よみがな(全角）姓:</label>
					<div class="col-md-3">
						<?php if($data!=null): ?>
						<input required type="text" name="firstname_nick_yomi" value="<?php echo e($data->firstname_nick_yomi); ?>" class="big-form-control" placeholder="ペンネームを入力">
						<?php else: ?>
						<input required type="text" name="firstname_nick_yomi" value="<?php echo e(old('firstname_nick_yomi')); ?>" class="big-form-control" placeholder="ペンネームを入力">
            			<?php endif; ?>
						<?php if($errors->has('firstname_nick_yomi')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('firstname_nick_yomi')); ?></span>
						</span>
						<?php endif; ?>
					</div>

					<label class="control-label col-md-2 text-md-right" for="lastname_nick_yomi"> 名:</label>
					<div class="col-md-3">
						<?php if($data!=null): ?>
						<input required type="text" name="lastname_nick_yomi" value="<?php echo e($data->lastname_nick_yomi); ?>" class="big-form-control" placeholder="ペンネームを入力">
						<?php else: ?>
						<input required type="text" name="lastname_nick_yomi" value="<?php echo e(old('lastname_nick_yomi')); ?>" class="big-form-control" placeholder="ペンネームを入力">
            			<?php endif; ?>
						<?php if($errors->has('lastname_nick_yomi')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('lastname_nick_yomi')); ?></span>
						</span>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="form-group row <?php echo e($errors->has('firstname') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="firstname" style="align-self:center">
				    <?php if($type == 3) echo "本名"; else echo "名前"; ?>(全角） 姓:
				</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" id="firstname" name="firstname" value="<?php echo e($data->firstname); ?>" class="big-form-control" placeholder="辻堂">
					<?php else: ?>
					<input required type="text" id="firstname" name="firstname" value="<?php echo e(old('firstname')); ?>" class="big-form-control" placeholder="辻堂">
					<?php endif; ?>
					<?php if($errors->has('firstname')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('firstname')); ?></span>
					</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-2 text-md-right" for="lastname" style="align-self:center"> 名:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" id="lastname" name="lastname" value="<?php echo e($data->lastname); ?>" class="big-form-control" placeholder="太郎">
					<?php else: ?>
					<input required type="text" id="lastname" name="lastname" value="<?php echo e(old('lastname')); ?>" class="big-form-control" placeholder="太郎">
					<?php endif; ?>
					<?php if($errors->has('lastname')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('lastname')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row <?php echo e($errors->has('firstname_yomi') ? ' has-danger' : ''); ?> <?php echo e($errors->has('lastname_yomi') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="firstname_yomi" style="align-self:center">よみがな(全角） 姓:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="firstname_yomi" value="<?php echo e($data->firstname_yomi); ?>" class="big-form-control" placeholder="つじどう">
					<?php else: ?>
					<input required type="text" name="firstname_yomi" value="<?php echo e(old('firstname_yomi')); ?>" class="big-form-control" placeholder="つじどう">
					<?php endif; ?>
					<?php if($errors->has('firstname_yomi')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('firstname_yomi')); ?></span>
					</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-2 text-md-right" for="lastname_yomi" style="align-self:center"> 名:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="lastname_yomi" value="<?php echo e($data->lastname_yomi); ?>" class="big-form-control" placeholder="たろう">
					<?php else: ?>
					<input required type="text" name="lastname_yomi" value="<?php echo e(old('lastname_yomi')); ?>" class="big-form-control" placeholder="たろう">
					<?php endif; ?>
					<?php if($errors->has('lastname_yomi')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('lastname_yomi')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row <?php echo e($errors->has('firstname_roma') ? ' has-danger' : ''); ?> <?php echo e($errors->has('last_roma') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="firtname_roma" style="align-self:center">
				    <?php if($type == 3) echo "ペンネームの"; ?>ローマ字(半角） 姓:
				</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="firstname_roma" value="<?php echo e($data->firstname_roma); ?>" class="big-form-control" placeholder="tsujido">
					<?php else: ?>
					<input required type="text" name="firstname_roma" value="<?php echo e(old('firstname_roma')); ?>" class="big-form-control" placeholder="tsujido">
					<?php endif; ?>
					<?php if($errors->has('firstname_roma')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('firstname_roma')); ?></span>
					</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-2 text-md-right" for="lastname_roma" style="align-self:center"> 名:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="lastname_roma" value="<?php echo e($data->lastname_roma); ?>" class="big-form-control" placeholder="taro">
					<?php else: ?>
					<input required type="text" name="lastname_roma" value="<?php echo e(old('lastname_roma')); ?>" class="big-form-control" placeholder="taro">
					<?php endif; ?>
					<?php if($errors->has('lastname_roma')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('lastname_roma')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row <?php echo e($errors->has('gender') ? ' has-danger' : ''); ?> <?php echo e($errors->has('birthday') ? ' has-danger' : ''); ?>" style="margin-bottom:0px">
				<label class="control-label col-md-2 text-md-right" for="gender">性別:</label>
				<div class="col-md-2">
					<select class="bs-select form-control" name="gender">
					<?php if($data!=null): ?>
						<option value="1" <?php if($data->gender == '1'): ?> selected <?php endif; ?> >  <?php echo e(config('consts')['USER']['GENDER'][1]); ?> </option>
						<option value="2" <?php if($data->gender == '2'): ?> selected <?php endif; ?> >  <?php echo e(config('consts')['USER']['GENDER'][2]); ?> </option>
					<?php else: ?>
						<option value="1" <?php if(old('gender') == '1'): ?> selected <?php endif; ?> >  <?php echo e(config('consts')['USER']['GENDER'][1]); ?> </option>
						<option value="2" <?php if(old('gender') == '2'): ?> selected <?php endif; ?> >  <?php echo e(config('consts')['USER']['GENDER'][2]); ?> </option>
					<?php endif; ?>
					</select>
					<?php if($errors->has('gender')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('gender')); ?></span>
					</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-3 text-md-right" for="brithday" style="align-self:center"> 生年月日:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" readonly="true" name="birthday" value="<?php echo e($data->birthday); ?>" id="birthday" class="big-form-control date-picker" placeholder="（西暦を２回タップして選択）">
					<?php else: ?>
					<input required type="text" readonly="true" name="birthday" value="<?php echo e(old('birthday')); ?>" id="birthday" class="big-form-control date-picker" placeholder="（西暦を２回タップして選択）">
					<?php endif; ?>
					<?php if($errors->has('birthday')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('birthday')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row
				<?php if($errors->has('address4') || $errors->has('address5') || $errors->has('address1') || $errors->has('address2') || $errors->has('address3') ): ?>
					has-danger
				<?php endif; ?>" style="margin-bottom:0px">
				<label class="control-label col-md-2 text-md-right" for="address4" style="margin-top:20px" style="align-self:center">住所:&nbsp;〒</label>
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-3" style="padding:0px;">
							<?php if($data!=null): ?>
							<input required type="text" name="address4" value="<?php echo e($data->address4); ?>" class="big-form-control" id="address4" placeholder="251"/>
							<?php else: ?>
							<input required type="text" name="address4" value="<?php echo e(old('address4')); ?>" class="big-form-control" id="address4" placeholder="251"/>
							<?php endif; ?>
						</div>
						<!-- <div class="col-xs-9" style="padding-left:10px;">
							<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字3行しか入らないように欄を小さく</span>
						</div> -->
					</div>
					<?php if($errors->has('address4') || $errors->has('address5') || $errors->has('address1') || $errors->has('address2') || $errors->has('address3')): ?>
					<span class="form-control-feedback">
						<span>住所を正確に入力してください。</span>
					</span>
					<?php endif; ?>
				</div>
				<span class="cross2-xs" >―</span>
				
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-3" style="padding:0px;">
							<?php if($data!=null): ?>
							<input required type="text" name="address5" value="<?php echo e($data->address5); ?>" class="big-form-control" id="address5" placeholder="0043"/>
							<?php else: ?>
							<input required type="text" name="address5" value="<?php echo e(old('address5')); ?>" class="big-form-control" id="address5" placeholder="0043"/>
							<?php endif; ?>
						</div>
						<!-- <div class="col-xs-9" style="padding-left:10px;">
							<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字4行しか入らないように欄を小さく</span>
						</div> -->
					</div>
				</div>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">都道府県</span>
					<div class="col-md-12 col-xs-6" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address1" value="<?php echo e($data->address1); ?>" class="big-form-control" placeholder="神奈川県">
						<?php else: ?>
						<input required type="text" name="address1" value="<?php echo e(old('address1')); ?>" class="big-form-control" placeholder="神奈川県">
						<?php endif; ?>
					</div>
				</div>
				
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">市区郡町村</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-6" style="padding:0px;">
							<?php if($data!=null): ?>
							<input required type="text" name="address2" value="<?php echo e($data->address2); ?>" class="big-form-control" placeholder="横浜市青葉区">
							<?php else: ?>
							<input required type="text" name="address2" value="<?php echo e(old('address2')); ?>" class="big-form-control" placeholder="横浜市青葉区">
							<?php endif; ?>
						</div>
					</div>
				</div>
				
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-2">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-6" style="padding:0px;">
							<?php if($data!=null): ?>
							<input type="text" name="address3" class="big-form-control popover-help" value="<?php echo e($data->address3); ?>" placeholder="美しが丘東"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。" >
							<?php else: ?>
							<input type="text" name="address3" class="big-form-control popover-help" value="<?php echo e(old('address3')); ?>" placeholder="美しが丘東"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。" >
							<?php endif; ?>
						</div>
					</div>
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
							<?php if($data!=null): ?>
							<input  type="text" name="address6" value="<?php echo e($data->address6); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address6" placeholder="5"/>
							<?php else: ?>
							<input  type="text" name="address6" value="<?php echo e(old('address6')); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address6" placeholder="5"/>
							<?php endif; ?>
						</div>
						 <div class="col-xs-9" style="font-size:10px;padding-left:10px;">
							<span class="show-xs" style="padding-left:0px;padding-top:8px">(丁目)</span>
						</div>
						<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
							<span class="show-xs" style="color:red;padding-left:0px;">数字5行しか入らないように欄を小さく</span>
						</div> -->
					</div>

				</div>
				<span class="cross2-xs" >―</span>
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-3" style="padding:0px;">
							<?php if($data!=null): ?>
							<input  type="text" name="address7" value="<?php echo e($data->address7); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address7" placeholder="8"/>
							<?php else: ?>
							<input  type="text" name="address7" value="<?php echo e(old('address7')); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address7" placeholder="8"/>
							<?php endif; ?>
						</div>
						<div class="col-xs-9" style="font-size:10px;padding-left:10px;">
							<span class="show-xs" style="padding-left:0px;padding-top:8px">(番)</span>
						</div>
						<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
							<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
						</div> -->
					</div>
				</div>
				<span class="cross2-xs" >―</span>
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-3" style="padding:0px;">
							<?php if($data!=null): ?>
							<input  type="text" name="address8" value="<?php echo e($data->address8); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address8" placeholder="24"/>
							<?php else: ?>
							<input  type="text" name="address8" value="<?php echo e(old('address8')); ?>" class="big-form-control <?php if($errors->has('address6')): ?> red-border <?php endif; ?>" id="address8" placeholder="24"/>
							<?php endif; ?>
						</div>
						<div class="col-xs-9" style="font-size:10px;padding-left:10px;">
							<span class="show-xs" style="padding-left:0px;padding-top:8px">(号)</span>
						</div>
						<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
							<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
						</div> -->
					</div>
				</div>
				
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">建物名</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-6" style="padding:0px;">
							<?php if($data!=null): ?>
							<input type="text" name="address9" value="<?php echo e($data->address9); ?>" class="big-form-control" placeholder="フラワーマンション"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。">
							<?php else: ?>
							<input type="text" name="address9" value="<?php echo e(old('address9')); ?>" class="big-form-control" placeholder="フラワーマンション"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。">
							<?php endif; ?>
						</div>
					</div>
				</div>
				
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">部屋番号、階数</span>
					<div class="col-md-12 col-xs-12" style="padding:0px;">
						<div class="col-md-12 col-xs-3" style="padding:0px;">
							<?php if($data!=null): ?>
							<input  type="text" name="address10" value="<?php echo e($data->address10); ?>" class="big-form-control" id="address10" placeholder="2F"/>
							<?php else: ?>
							<input  type="text" name="address10" value="<?php echo e(old('address10')); ?>" class="big-form-control" id="address10" placeholder="2F"/>
							<?php endif; ?>
						</div>
						<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle">
							<span class="show-xs" style="color:red;padding-left:0px;">英数字5行しか入らないように欄を小さく</span>
						</div> -->
					</div>
				</div>			
			</div>

			<div class="form-group row <?php echo e($errors->has('phone') ? ' has-danger' : ''); ?>" >
				<label class="control-label col-md-2 text-md-right" for="phone" style="align-self:center">電話番号(半角）:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="phone" value="<?php echo e($data->phone); ?>" id="phone" class="big-form-control">
					<?php else: ?>
					<input required type="text" name="phone" value="<?php echo e(old('phone')); ?>" id="phone" class="big-form-control">
					<?php endif; ?>

					<?php if($errors->has('phone')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('phone')); ?></span>
						</span>
					<?php endif; ?>
				</div>
				<label class="control-label col-md-3 text-md-left label-after-input" style="align-self:center">（ハイフンは入れずに入力してください。）</label>
			</div>

			<div class="form-group row <?php echo e($errors->has('auth_type') ? ' has-danger' : ''); ?> <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="phone" style="align-self:center"><?php echo e($auth_types['TITLE']); ?>:</label>
				<div class="col-md-2">
					<select name="auth_type" class="bs-select form-control">
						<?php $__currentLoopData = $auth_types['CONTENT']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$auth_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($data!=null): ?>
							<option value="<?php echo e($key); ?>" <?php if($data->auth_type == $key): ?> selected <?php endif; ?> > <?php echo e($auth_type); ?> </option>
							<?php else: ?>
							<option value="<?php echo e($key); ?>" <?php if(old('auth_type') == $key): ?> selected <?php endif; ?> > <?php echo e($auth_type); ?> </option>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('auth_type')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('auth_type')); ?></span>
						</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-6 text-md-left" for="phone">
					<?php if($type == 2 || $type == 3): ?>
						<span style="color:red">※　後ほど本人確認書類とともに、画像を送信していただきます。</span>
					<?php else: ?>
						<span style="color:red">※　後ほど画像を送信していただきます。（写真付きでない場合は、2種類）</span>
					<?php endif; ?>
				</label>

			</div>

			<div class="form-group row <?php echo e($errors->has('auth_type') ? ' has-danger' : ''); ?> <?php echo e($errors->has('email') ? ' has-danger' : ''); ?>">

				<label class="control-label col-md-2 text-md-right" for="email" style="align-self:center">メールアドレス:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="email" class="big-form-control" value="<?php echo e($data->email); ?>" id="email" placeholder="〇〇〇〇〇＠〇〇〇〇.jp">
					<?php else: ?>
					<input required type="text" name="email" class="big-form-control" value="<?php echo e(old('email')); ?>" id="email" placeholder="〇〇〇〇〇＠〇〇〇〇.jp">
					<?php endif; ?>
					<?php if($errors->has('email')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('email')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="control-label col-md-6 text-md-right" for="teacher" id="descripte" style="align-self:center">					
				<span style="margin-right: 5%">再開可能な読Ｑネームをお持ちの方は、入力</span> &nbsp;読Qネーム（半角） :  
					<!-- 読Ｑネームを持っている場合、入力　	 -->
				</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input type="text" name="prev_username" class="big-form-control" value="<?php echo e($data->prev_username); ?>" placeholder="">
					<?php else: ?>
					<input type="text" name="prev_username" class="big-form-control" value="<?php echo e(old('prev_username')); ?>" placeholder="">
					<?php endif; ?>

					<?php if($errors->has('prev_username')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('prev_username')); ?></span>
						</span>
					<?php endif; ?>
				</div>
				<span class="offset-md-2" style="color:red;padding-left:10px">※教師会員を再開する予定のある方は、入力しないでください。これは個人会員用です</span>
			</div>
			
			<div class="form-group form-actions row">
				
				<div class="offset-md-4 col-md-4 text-md-center col-sm-12">
					<button type="submit" class="btn btn-success" style="margin-bottom:8px">規約に同意して送信</button>
					<a href="<?php echo e(url('/auth/register')); ?>" class="btn btn-danger"  style="margin-bottom:8px">キャンセル</a>
				</div>
				<div class="col-md-4 text-md-right col-sm-12" style="margin-bottom:8px">
					<a href="<?php echo e(url('/')); ?>" class="btn btn-info">読Qトップへ戻る</a>
				</div>
			</div>

			<div class="form-group row ">
				<label class="control-label col-md-12 text-lg-left" for="group_name"><br><br>
					規約に同意して送信いただきますと、読書認定協会からご登録のEメール宛に、正式登録用URLをお知らせしますので、それを使用してログインしてください。
通知から７日間を過ぎるとログインできなくなりますので、その場合はもう一度最初からお手続きをお願いいたします。
※　3日経ってもメールが届かない場合は、メールアドレスを間違えて登録された可能性があります。恐れ入りますが再度申請をお願いいたします。<br>

				</label>

			</div>
		</form>
	</div>
</div>

<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>おたずね</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>

  </div>
</div>

<div id="confirmModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>おたずね</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text">既に登録した児童生徒がいます。新しい読Q会員で登録しますか、または再登録しますか？</span>
     	</div>
        <div class="modal-footer">
			<button type="button" data-dismiss="modal" class="btn btn-warning">再登録</button>
			<button type="button" data-dismiss="modal" class="create_new btn btn-primary">新しい登録</button>
        	<button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    var handleDupUserCheck = function() {
        var params = "firstname=" + $("#firstname").val() + "&lastname=" + $("#lastname").val() + "&birthday=" + $("#birthday").val();
        $.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/user/dupdoqusercheck?" + params,
            function(data, status){
                if(data.result=="dup") {
                  $("#alert_text").html("読Q会員でしたか？もとの読Qネームでの利用履歴を再開したい場合、読Qネーム入力欄に入力してください。");
                    $("#alertModal").modal();
                    $("#descripte").html("教職員として読Qネームをお持っていた場合、右記に入力　　読Qネーム（半角）:");
               //		$("#confirmModal").modal();
                }
            });
        };
     var oldBirthday = "";
	$("#firstname").blur(handleDupUserCheck);
	$("#lastname").blur(handleDupUserCheck);
	$("#birthday").change(function() {
	    if ($("#birthday").val() == "" || oldBirthday == $("#birthday").val()) {
	        return;
	    }
	    oldBirthday = $("#birthday").val()
	    handleDupUserCheck();
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

		var handleInputMasks = function () {
			var pdfheight  = $(window).height() - 55;
			$("#pdfheight").val(pdfheight);
			
			$.extend($.inputmask.defaults, {
					'autounmask': true
			});

			$("#birthday").inputmask("y/m/d", {
					"placeholder": "yyyy/mm/dd"
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
			});
			$("#address10").inputmask("mask",{
		        "mask":"*****"
			});

	    }
	    handleDatePickers();
	    handleInputMasks();
	    $(".help").click(function(){
	    	$(".popover-help").popover('show')
	    	setTimeout(function(){
	    		$(".popover-help").popover('hide')
	    	},3000)
	    })
	    $("#viewpdf").click(function(){
	    	$(".form-horizontal").attr("action", "/auth/viewpdf");
		    $(".form-horizontal").submit();
	    });
	    var numbers = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.group); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          local: <?php echo $groups ?>
        });
        numbers.initialize();
        $('#group_name').typeahead(null, {
          displayKey: 'group',
          hint: (Metronic.isRTL() ? false : true),
          source: numbers.ttAdapter()
        });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>