

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
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > クイズのランダム出題方法及び再受検についての仕様書
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズのランダム出題方法および再受検についての仕様書</h3>
			<div class="row">
				<div class="col-md-10">
					<h4>
						クイズ文について
					</h4>
					<br>
					<ul>
						<li>ランダム出題の決まり事</li>
						<li>始めの３問・・・前半以外から出題（最初しか読んでいない受検者を振るい落とすため）</li>
						<li>残りは、前半、中盤、後半、全体から同じくらいずつ、順不同でランダムにまんべんなく出題。</li>
						<li>再受検では違う問題を出す・・・同じ人に２度同じ出題をするのを、回避する。特に１回目不合格でも直後に再受検できるので注意。（出題数の3倍以上のクイズストックがある。4回目受検からは、同じクイズ文が出てきてしまうのは仕方がない）</li>
						<li>同じ受検者に対して各問の出題の回数（１回目、２回目）、出題の順番</li>
					</ul>
				</div>
				<div class="col-md-10">
					<h4>
						再受検について
					</h4>
					<ul>
						<li>初回不合格の場合、その場ですぐ再受検ができる。それも不合格だった場合は、3日間（72時間）は受検不可。(他の本は受検できる）受検しようとするとダイアログboxで警告される。</li>
					</ul>
				</div>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>