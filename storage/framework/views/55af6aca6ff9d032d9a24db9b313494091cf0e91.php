	
		<?php echo $__env->make('partials.books.book_list_item', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	
	
<?php echo $books->render(); ?>

<div class="row">
	<div class="col-md-12 margin-bottom-10">
		<?php if(isset($_GET['page']) && $_GET['page'] !== null): ?>
			<a href="<?php echo e(url('book/search')); ?>" class="btn btn-info pull-right">戻　る</a>
		<?php else: ?>
			<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
		<?php endif; ?>
	</div>
</div>