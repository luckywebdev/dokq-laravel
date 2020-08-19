

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
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
	            	<a href="<?php echo e(url('/mypage/top')); ?>">
	                	 > マイ書斎
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="<?php echo e(url('/mypage/main_info')); ?>">
	                	 > 基本情報
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	> 読書認定書の発行
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読書認定書</h3>
			<div class="row" id = "include">
				<div class="col-md-3"></div>
				<div class="col-md-6">						
					<div style="width:100%;height:100%;border:solid 1px;">
						<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
							<div class="row">
								  <div class="col-md-12">  
                                    <div class="tools" style="float: left;">
                                        <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 40px">Q</span></h2>
                                    </div>                       
                                    <div class="tools text-md-right" style="float: right;">
                                        <span class="text-md-right text-md-top" style="float:right;">2〇〇〇年〇月〇日</span>
                                    </div>
                                </div>
								<div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div>
								<div class="col-md-12">
									<h4 class="text-md-center">読書認定書</h4>
									<h5 class="text-md-center">（パスコード：　〇〇〇〇〇）</h5>
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-left">〇〇 〇〇　様</div>
								<div class="col-md-12 text-md-left">(読Qネーム：　〇〇〇〇〇〇)</div>
								<div class="col-md-12 text-md-right" style="float:right;">一般社団法人読書認定協会</div>
								<div class="col-md-12 text-md-right" style="float:right;">代表理事　神部ゆかり</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									あなたは、当協会の運営する読Q検定において、下表の通り、書籍についての検定試験に合格されました。
								</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍一覧（抜粋）(2〇〇〇年〇月〇日 現在)</div>    
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="col-md-2">合格日</th>
												<th class="col-md-2">タイトル</th>
												<th class="col-md-2">著者</th>
												<th class="col-md-2">出版社</th>
												<th class="col-md-1">読Q本ID</th>
											</tr>
										</thead>
										<tbody class="text-md-center">
											
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3"></div>
			</div>
			<form class="form form-horizontal offset-md-2">
			<input type="hidden" id="index" name="index" value="<?php echo e($index); ?>">
			<input type="hidden" id="items" name="items" value="<?php echo e($items); ?>">
			<div class="form-group row margin-top-20">
				<div class="col-md-12 text-md-center">
					<button type="button" class="btn btn-success btn-press">この形式で、読書認定書を発行する</button>
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
			</form>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
			$(".btn-press").click(function(){
				var index = $("#index").val();
				var items = $("#items").val();
                
				location.href = '<?php echo e(url("/mypage/settlement_certi/")); ?>'+ "/" + index +"/"+items;
				
			});
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>