<form class="form-horizontal" method="post" action="<?php echo e(url('quiz/store')); ?>">
	<?php echo e(csrf_field()); ?>

	<input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
	<input type="hidden" name="register_id" value="<?php echo e(Auth::id()); ?>">
	<input type="hidden" name="quiz_id" value="<?php echo e(isset($quiz) ? $quiz->id : 0); ?>">
	<input type="hidden" name="act" value="<?php if(isset($act)): ?> <?php echo e($act); ?> <?php endif; ?>">

	<div class="form-group row <?php echo e($errors->has('question') ? ' has-danger' : ''); ?>">
		<div class="offset-md-1 col-md-10">
			<h4 class="pull-left">本文入力（140字以内）</h4>
			<textarea id="quiz" class="form-control" name="question" maxlength="140" rows="3" placeholder="入力例：　なつみがバスに飛び乗ったのは、＃誕生日の朝＃だった。"><?php echo e(old('question')!=""? old('question') : (isset($quiz) ? $quiz->question : '')); ?></textarea>
			<?php if($errors->has('question')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('question')); ?></span>
				</span>
			<?php endif; ?>
			<span class="form-control-feedback">
				<span class="text_err hide" style="color:#d9534f;"></span>
			</span>
		</div>
	</div>
	<div class="form-group row form-md-line-input <?php echo e($errors->has('answer') ? ' has-danger' : ''); ?>">
		<h4 class=" offset-md-2 col-md-2 control-label text-md-right">正解</h4>
		<div class="col-md-4">
			<select class="bs-select form-control" name="answer">
				<option value="1" <?php if(old('answer') === "1"): ?> selected <?php elseif(old('answer')=='' && (isset($quiz) && $quiz->answer == 1)): ?> selected <?php endif; ?>>1</option>
				<option value="0" <?php if(old('answer') === "0"): ?> selected <?php elseif(old('answer')=='' && (isset($quiz) && $quiz->answer == 0)): ?> selected <?php endif; ?>>2</option>
			</select>
			<?php if($errors->has('answer')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('answer')); ?></span>
				</span>
			<?php endif; ?>
		</div>
	</div>
	<div class="form_quiz_create">
		<div class="row form-group">
			<label class="col-md-5 control-label pull-right">このクイズは、本文のどのあたりから作りましたか？</label>
			<div id="app_page" class="col-md-2">
				<div class="input-group">
					<select class="bs-select form-control" name="app_range">
						<?php $__currentLoopData = config('consts')['QUIZ']['APP_RANGES']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($key); ?>" <?php if($key==old('app_range')): ?> selected <?php endif; ?>  <?php if(isset($quiz) && ($quiz->app_range == $key)): ?> selected <?php endif; ?>><?php echo e($range); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('app_range')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('app_range')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
			
		</div>
		<div class="row form-group <?php echo e($errors->has('app_range') ? ' has-danger' : ''); ?>">
			<label class="col-md-5 control-label pull-right">出典ページ （電子書籍などは空欄可）</label>
			<div class="col-md-2">
				<input type="number" name="app_page" value="<?php echo e(old('app_page')!='' ? old('app_page') : (isset($quiz) ? $quiz->app_page:'')); ?>"  class="spinner-input form-control" maxlength="4" min="0">
			</div>
			<label class="control-label text-md-left label-after-input">ページ（半角）</label>
<!--			<label class="control-label text-md-left label-after-input">（前半から、中盤から、後半から、全体から、本文に無い）</label>-->
		</div>		
	</div>

	<div class="row form-group <?php echo e($errors->has('register_visi_type') ? ' has-danger' : ''); ?>" style="margin-top: 20px">
		<label class="col-md-3 control-label pull-right">クイズ作成者名の掲載:</label>
		<div class="col-md-3">
			<select class="bs-select form-control" name="register_visi_type">
				<?php $__currentLoopData = config('consts')['QUIZ']['REGISTER_VISI_TYPE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($key); ?>" <?php if($key==old('register_visi_type')): ?> selected <?php endif; ?> <?php if(isset($quiz) && ($quiz->register_visi_type == $key)): ?> selected <?php endif; ?> <?php if(isset($quizmakername) && ($quizmakername == $key)): ?> selected <?php endif; ?>><?php echo e($type); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			<?php if($errors->has('register_visi_type')): ?>
				<span class="form-control-feedback">
					<span><?php echo e($errors->first('register_visi_type')); ?></span>
				</span>
			<?php endif; ?>
		</div>
		<label class="control-label text-md-left label-after-input">掲載することをを選んでも、15歳までは非表示になります。</label>
	</div>
	<div class="form-actions text-md-center text-sm-center">
		<button class="btn btn-primary" type="submit" disabled="true"> 完了して確認画面へ </button>
		<button class="btn btn-danger" type="button" onclick="javascript:location.reload()"> キャンセル </button>
		<button class="btn btn-info" type="button" onclick="javascript:history.go(-1)">戻　る</button>
	</div>
</form>