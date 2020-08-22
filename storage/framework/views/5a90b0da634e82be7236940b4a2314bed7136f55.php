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
					<a href="#"> > 検索結果の見方</a>
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">検索結果の見方</h3>
			<h5 class="text-center">検索結果画面でのクリック操作は下記の通りです。</h5>

			<div class="row">
				<div class="col-md-12" style="font-size: 16px">
						<p>タイトルをクリック・・・　その本の、読Ｑ本ページへ</p>
						<p>著者名をクリック・・・　その著者の著作一覧表か、著者が読Ｑの会員の場合は著者マイ書斎が表示されます。</p>
						<p>プルダウンメニュー・・昇順降順のプルダウンメニューをクリックすると、並べ替えができます。</p>
						<p>「この本を受検」をクリック・・・受検画面へ　（既に合格済の本や、まだクイズが認定されていない本の場合は、薄く表示されて、クリックできません）</p>
						<p>「この本の詳細を見る」をクリック・・・本のページへ</p>
						<p>「この本のクイズを作る」をクリック・・・クイズを募集中の読Ｑ本の場合は、これをクリックするとクイズ作成画面へ</p>
						<p>「この本の監修者に応募する」をクリック・・・監修者を募集中の読Ｑ本の場合は、これをクリックすると、監修応募画面へ</p>					
						<p>「読みたい本に追加する」をクリック・・・推薦図書から検索した場合に表示され、これをクリックするとマイ書斎の読みたい本リストに追加されます。</p>					

					<br><br><br>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
		});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>