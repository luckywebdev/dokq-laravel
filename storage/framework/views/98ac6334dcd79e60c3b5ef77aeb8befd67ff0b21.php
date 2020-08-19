
<?php $__env->startSection('styles'); ?>

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
					<a href="<?php echo e(url('book/search')); ?>"> > 読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					<a href="#"> > 年代別 読Q推薦図書、ジャンル、新読Q本からさがす</a>
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">年代別 読Q推薦図書、ジャンル、新読Q本からさがす</h3><br>
							
			<div class="row">
				<div class="col-md-12">
				  	<div class="form form-horizontal">
						
						<form class="form-group row" action="<?php echo e(url('book/search/gene')); ?>">
						
							<div class="offset-md-1 col-md-4">
								<h4 class="text-md-right">
									年代別 読Q推薦図書からさがす<br>
									<small>(登録の新しいものから表示されます）</small>
								</h4>
							</div>
							<div class="col-md-4">
								<select class="bs-select form-control" name="gene">
									<!-- <option></option> -->
									<?php $__currentLoopData = config('consts')['BOOK']['SEARCH_RECOMMENDS']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$recommend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($key); ?>"><?php echo e($recommend); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>

						<form class="form-group row " action="<?php echo e(url('book/search/category')); ?>">
							<div class="offset-md-1 col-md-4">
								<h4 class="text-md-right">
									ジャンルからさがす<br>
									<small>(登録の新しいものから表示されます）</small>
								</h4>
							</div>
							<div class="col-md-4">
								<select class="form-control bs-select" name="categories[]" multiple >
									<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($category->id); ?>" <?php if($category->id==9): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>
						<form class="form-group row" action="<?php echo e(url('book/search/latest')); ?>">
							<div class="offset-md-1 col-md-6">
								<h4 class="text-md-right">この1か月間に新しく読Q本に認定された本からさがす</h4>
							</div>
							<div class="col-md-2 offset-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>
							<div class="form-actions right">
								<a href="<?php echo e(url('book/search')); ?>" class="btn btn-info pull-right">戻　る</a>
							</div>
						</div>
					</div>
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
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>