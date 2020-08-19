

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
				<div class="offset-md-3 col-md-6">
					<?php if($certi_preview->index == 1): ?>
						<div style="width:100%;height:100%;border:solid 1px;">
							<div style="padding-top:10px; padding-bottom: 10px; padding-left:10px; padding-right:10px;">
								<div class="row">
                                    <div class="col-md-12">  
										<div class="tools" style="float: left;">
											<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_only_up_reverse.png')); ?>">
                                            <!-- <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読<span style="font-family: 'Judson'">Q</span></h2> -->
                                        </div>                       
                                        <div class="tools text-md-right" style="float: right;">
                                            <span class="text-md-right text-md-top" style="float:right;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                            
                                        </div>
                                    </div> 
									
									<div class="col-md-12">
										<h4 class="text-md-center">読書認定書</h4>
										<h5 class="text-md-center">（パスコード：　<?php echo e($user->passcode); ?>）</h5>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left"><?php echo e($user->fullname()); ?>　様</div>
									<div class="col-md-12 text-md-left">(読Qネーム：　<?php echo e($user->username); ?>)</div>
									<div class="offset-md-7 col-md-5 text-md-right" style="background-image: url(<?php echo e(asset('/img/sign1.png')); ?>);background-repeat: no-repeat;background-position: center center;height:100px">
										<br><br>
										<span style="float:right;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;">代表理事　神部ゆかり</span>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12">
										あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">記</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">(<?php echo e(date_format(date_create($certi_preview->backup_date), 'Y年m月d日')); ?> 現在)</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-right">以上</div>
								</div>
							</div>
						</div>
					<?php elseif($certi_preview->index == 2): ?>
						<div style="width:100%;height:100%;border:solid 1px;">
							<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
								<div class="row">
									<div class="col-md-12">  
										<div class="tools" style="float: left;">
											<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_only_up_reverse.png')); ?>">
                                            <!-- <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2> -->
                                        </div>                       
                                        <div class="tools text-md-right" style="float: right;">
                                            <span class="text-md-right text-md-top" style="float:right;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                            
                                        </div>
                                    </div> 
                                    
									<!-- <div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div> -->
									<div class="col-md-12">
										<h4 class="text-md-center">読書認定書</h4>
										<h5 class="text-md-center">（パスコード：　<?php echo e($user->passcode); ?>）</h5>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left"><?php echo e($user->fullname()); ?>　様</div>
									<div class="col-md-12 text-md-left">(読Qネーム：　<?php echo e($user->username); ?>)</div>
									<div class="offset-md-7 col-md-5 text-md-right" style="background-image: url(<?php echo e(asset('/img/sign1.png')); ?>);background-repeat: no-repeat;background-position: center center;height:100px">
										<br><br>
										<span style="float:right;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;">代表理事　神部ゆかり</span>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12">
										あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">記</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>	
									<div class="col-md-12 text-md-left">&nbsp;</div>	
                                    <div class="col-md-12 text-md-center" style="text-align:center;font-size:14px;">合格した書籍一覧（著者名順）　　　　（<?php echo e(date("Y")); ?>年<?php echo e(date("n")); ?>月<?php echo e(date("d")); ?>日現在)</div>    
									<div class="col-md-12 text-md-left">&nbsp;</div>					
									<div class="col-md-12">
										<?php $count = 0; ?>
										<?php
											$myAllHistories = preg_split('/,/', $certi_preview->booktest_success); 
											$counts = count($myAllHistories);
											$first_column_rows = ceil($counts / 2)
										?>
										<?php if(count($myAllHistories) == 0): ?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
										<?php else: ?>
										<div class="col-md-5 col-md-offset-1 col-sm-12">
											<ul class="alt" style="list-style: none; padding-left: 0 !important">
											<?php
												for($k = 0; $k < $first_column_rows; $k++){
													$myAllHistory = $myAllHistories[$k];
													$myBook = preg_split('/:/', $myAllHistory);
											
													if(isset($myBook[1])){
														$author = $myBook[1];
													}
													else{
														$author = "";
													}
													if(isset($myBook[0])){
														$title = $myBook[0];
													}
													else{
														$title = "";
													}

											?>
													<li>
														<?php echo $author." &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; ".$title; ?>
													</li>
											<?php
											}
											?>
											</ul>
										</div>
										<div class="col-md-5 col-md-offset-1 col-sm-12">
											<ul class="alt" style="list-style: none; padding-left: 0 !important">
											<?php
												for($k = $first_column_rows; $k < $counts; $k++){
													$myAllHistory = $myAllHistories[$k];
													$myBook = preg_split('/:/', $myAllHistory);
											
													if(isset($myBook[1])){
														$author = $myBook[1];
													}
													else{
														$author = "";
													}
													if(isset($myBook[0])){
														$title = $myBook[0];
													}
													else{
														$title = "";
													}

											?>
													<li>
														<?php echo $author."&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp; ".$title; ?>
													</li>
											<?php
											}
											?>
											</ul>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php elseif($certi_preview->index == 3): ?>
						<div style="width:100%;height:100%;border:solid 1px;">
							<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
								<div class="row">
									 <div class="col-md-12">  
										<div class="tools" style="float: left;">
											<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_only_up_reverse.png')); ?>">
                                            <!-- <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2> -->
                                        </div>                       
                                        <div class="tools text-md-right" style="float: right;">
                                            <span class="text-md-right text-md-top" style="float:right;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                            
                                        </div>
                                    </div> 
									<!-- <div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div> -->
									<div class="col-md-12">
										<h4 class="text-md-center">読書認定書</h4>
										<h5 class="text-md-center">（パスコード：　<?php echo e($user->passcode); ?>）</h5>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left"><?php echo e($user->fullname()); ?>　様</div>
									<div class="col-md-12 text-md-left">(読Qネーム：　<?php echo e($user->username); ?>)</div>
									<div class="offset-md-7 col-md-5 text-md-right" style="background-image: url(<?php echo e(asset('/img/sign1.png')); ?>);background-repeat: no-repeat;background-position: center center;height:100px">
										<br><br>
										<span style="float:right;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;">代表理事　神部ゆかり</span>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12">
										あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">記</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>	
									<div class="col-md-12 text-md-left">&nbsp;</div>
                                    <div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍の一部　　（著者名/タイトル/出版社/合格日）</div>    
									<div class="col-md-12 text-md-left">&nbsp;</div>						
									<div class="col-md-12">
										<?php $myAllHistories = preg_split('/,/', $certi_preview->booktest_success); ?>
										<?php if(count($myAllHistories) == 0): ?>
											<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
										<?php else: ?>	
										<?php $__currentLoopData = $myAllHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myAllHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $myBook = preg_split('/:/', $myAllHistory); ?>
											<div class="col-md-10 col-md-offset-1 col-sm-12">
											<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  &nbsp;/&nbsp;  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?> &nbsp; /&nbsp;  <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?> &nbsp; /&nbsp;  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php elseif($certi_preview->index == 4): ?>
						<div style="width:100%;height:100%;border:solid 1px;">
							<div style="padding-top:20px; padding-bottom:20px; padding-left:20px; padding-right:20px;">
								<div class="row">
									  <div class="col-md-12">  
										<div class="tools" style="float: left;">
											<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_only_up_reverse.png')); ?>">
                                            <!-- <h2 class="text-md-left" style="margin:0px;font-size:32px;font-family: HGP明朝B;">読Q</h2> -->
                                        </div>                       
                                        <div class="tools text-md-right" style="float: right;">
                                            <span class="text-md-right text-md-top" style="float:right;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                            
                                        </div>
                                    </div> 
									       <!-- <div class="col-md-12 text-md-left" style="font-size:10px;">読書認定級</div> -->
									<div class="col-md-12">
										<h4 class="text-md-center">読書認定書</h4>
										<h5 class="text-md-center">（パスコード：　<?php echo e($user->passcode); ?>）</h5>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-left"><?php echo e($user->fullname()); ?>　様</div>
									<div class="col-md-12 text-md-left">(読Qネーム：　<?php echo e($user->username); ?>)</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="offset-md-7 col-md-5 text-md-right" style="background-image: url(<?php echo e(asset('/img/sign1.png')); ?>);background-repeat: no-repeat;background-position: center center;height:100px">
										<br><br>
										<span style="float:right;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;">代表理事　神部ゆかり</span>
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12">
										あなたは、当協会の運営する読Q検定において、下表の通り、書籍についての検定試験に合格されました。
									</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12 text-md-center">記</div>
									<div class="col-md-12 text-md-left">&nbsp;</div>  
                                    <div class="col-md-12 text-md-center" style="text-align:center;">合格した書籍の一部　　（著者名/タイトル/出版社/合格日）</div>    
                                    <div class="col-md-12 text-md-left">&nbsp;</div>
									<div class="col-md-12">

										<?php $myAllHistories = preg_split('/,/', $certi_preview->booktest_success); ?>
										<?php if(count($myAllHistories) == 0): ?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
										<?php else: ?>
										<?php $__currentLoopData = $myAllHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myAllHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $myBook = preg_split('/:/', $myAllHistory); ?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">
											<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  &nbsp;/&nbsp;  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?>  &nbsp;/ &nbsp; <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?> &nbsp; /&nbsp;  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
										</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<input type="hidden" id="index" value="<?php echo e($index); ?>">
				<div class="col-md-3" style="margin-top:20px;">
					<div class="col-md-12 col-xs-6" style="text-align:right;">
                    
						<form class="form-horizontal" method="post" role="form" action="<?php echo e(url('/mypage/certi_print')); ?>">
						 <?php echo e(csrf_field()); ?>

						 <input type="hidden" id="id" name="id" value="<?php echo e($user->id); ?>">
						<button id = "non-printable" type="button" class="btn btn-success pull-right print">印　刷</button>
						</form>
					</div>
					<div class="col-xs-6 show-xs" style="text-align:right;">
						<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　るa</button>
						<button type="button" class="btn btn-success pull-right btn-press" style="margin-right: 1%">決  済</button>
					</div>
				</div>
			</div>
			
			<div class="hidden-xs offset-md-2 form-group row margin-top-20">
				<div class="col-md-12 text-md-center">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
					<button type="button" class="btn btn-success pull-right btn-press" style="margin-right: 1%">決  済</button>
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
			$(".btn-press").click(function(){
				var index = $("#index").val();
				location.href = '<?php echo e(url("/mypage/certi_pay")); ?>' + "/" + index;       
			});
			$(".print").click(function(){
				//window.print();
				$(".form-horizontal").submit();
			});

			var initBody;
			function beforeprint(){
				initBody = document.body.innerHTML;
				document.body.innerHTML = idprint.innerHTML;
			}
			function afterprint(){
				document.body.innerHTML = initBody;
				location.href = '<?php echo e(url("/mypage/recent_report/")); ?>';
			}
			//window.onbeforeprint = beforeprint;
			//window.onafterprint = afterprint;
			});
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>