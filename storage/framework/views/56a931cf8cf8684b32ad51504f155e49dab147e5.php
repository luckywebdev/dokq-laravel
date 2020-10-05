<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/tr/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta id="token" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/font-awesome/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/simple-line-icons/simple-line-icons.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/uniform/css/uniform.default.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-select/bootstrap-select.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-toastr/toastr.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/select2/select2.css')); ?>"/>    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-datepicker/css/datepicker3.css')); ?>">
   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/components-rounded.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/style-responsive.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/frontend/themes/blue.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/themes/darkblue.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/layout.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/lib.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/custom.css')); ?>" media="print">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('datatables/plugins/bootstrap/dataTables.bootstrap.css')); ?>"/>
</head>
<body style='width: 21cm;'>
	<div align='left' name = "idprint" style="padding:0px;margin:0px">
		<div class="page-content-wrapper">
			<div class="page-content">                           
				<?php if($certi_preview->index == 1): ?>
					<div style="height:28.7cm;border:solid 1px;padding:20px;">
						<div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="col-md-6 col-xs-6"  style="float: left;">
                                    <h2 class="text-md-left" style="text-align:left;margin:0px;font-size:36px;font-family: HGP明朝B;">読<span style="font-family: 'Judson'">Q</span></h2>
                                </div>
                                <div class="col-md-6 col-xs-6" style="float: right;">
                                    <span class="text-md-right  text-md-top" style="float:right;font-size:14px;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                </div>
                            </div>  
                                                           
							<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:12px;">読書認定級</div>
							<div class="col-md-12 col-xs-12">
								<h4 class="text-md-center" style="text-align:center;font-size:28px;">読書認定書</h4>
								<h5 class="text-md-center" style="text-align:center;font-size:14px;">（パスコード：　<?php echo e($certi_preview->passcode); ?>）</h5>
							</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;"><?php echo e($user->fullname()); ?>　様</div>
							<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;">(読Qネーム：　<?php echo e($user->username); ?>)</div>
							<div class="col-md-12 col-xs-12 text-md-right" style="text-align:rigth;" >
								<div class="col-md-7 col-xs-8"></div>
								<div class="background_print col-md-5 col-xs-4" style="float:right;background-image: url(<?php echo e(asset('/img/sign2.png')); ?>) !important;background-repeat: no-repeat !important;background-position: center center !important;height:100px;">
									<br><br>
									<span style="float:right;font-size:14px;">一般社団法人読書認定協会</span>
									<br>
									<span style="float:right;font-size:14px;">代表理事　神部ゆかり</span>
								</div>
							</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12" style="font-size:16px;">
								あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
							</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">記</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">(<?php echo e(date_format(date_create($certi_preview->backup_date), 'Y年m月d日')); ?> 現在)</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-right" style="text-align:right;font-size:14px;">以上</div>
						</div>
					</div>
				<?php elseif($certi_preview->index == 2): ?>
					<?php $myAllHistories = preg_split('/,/', $certi_preview->booktest_success); 
					$counts = count($myAllHistories);
					$page_amount = ceil($counts / 60);
					for($i = 0; $i < $page_amount; $i++){
						if($i == 0){
					?>
						<div style="height:28.7cm;border:solid 1px;padding:20px;">
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="col-md-6 col-xs-6"  style="float: left;">
										<h2 class="text-md-left" style="text-align:left;margin:0px;font-size:36px;font-family: HGP明朝B;">読Q</h2>
									</div>
									<div class="col-md-6 col-xs-6" style="float: right;">
										<span class="text-md-right  text-md-top" style="float:right;font-size:14px;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
									</div>
								</div>
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:12px;">読書認定級</div>
								<div class="col-md-12 col-xs-12">
									<h4 class="text-md-center" style="text-align:center;font-size:28px;">読書認定書</h4>
									<h5 class="text-md-center" style="text-align:center;font-size:14px;">（パスコード：　<?php echo e($certi_preview->passcode); ?>）</h5>
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;"><?php echo e($user->fullname()); ?>　様</div>
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;">(読Qネーム：　<?php echo e($user->username); ?>)</div>
								<div class="col-md-12 col-xs-12 text-md-right" style="text-align:rigth;" >
									<div class="col-md-7 col-xs-8"></div>
									<div class="background_print col-md-5 col-xs-4" style="float:right;background-image: url(<?php echo e(asset('/img/sign2.png')); ?>) !important;background-repeat: no-repeat !important;background-position: center center !important;height:100px;">
										<br><br>
										<span style="float:right;font-size:14px;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;font-size:14px;">代表理事　神部ゆかり</span>
									</div>
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12" style="font-size:16px;">
									あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">記</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
								<div class="col-md-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>	
								<div class="col-md-12 text-md-left">&nbsp;</div> 
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">合格した書籍一覧（著者名順）　　　　（<?php echo e(date("Y")); ?>年<?php echo e(date("n")); ?>月<?php echo e(date("d")); ?>日現在)</div>    
								
								<!--<div class="col-md-12 text-md-left">&nbsp;</div>	
								<div class="col-md-12 col-xs-12">      
									<div class="col-md-6 col-xs-6 text-md-center" style="float:left; text-align:center;font-size:14px;">合格した書籍一覧（著者名順）</div>
									<div class="col-md-6 col-xs-6 text-md-right" style="float:right; text-align:right;font-size:14px;"><?php echo e(date_format(date_create($certi_preview->backup_date), 'Y年m月d日')); ?>現在</div>                                                                 
								</div>-->
								
								
								<div class="col-md-12 text-md-left">&nbsp;</div>					
								<div class="col-md-12 col-xs-12 " style="width: 100%">
									<?php $count = 0; ?>
									
									<?php if(count($myAllHistories) == 0): ?>
									<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
									<?php else: ?>
									<?php
									if($counts > 60){
										$end_count = 60;
									}
									else{
										$end_count = $counts;
									}
									for($k = 0; $k < $end_count; $k++){
										$myAllHistory = $myAllHistories[$k];
										?>
										<?php $myBook = preg_split('/:/', $myAllHistory); ?>
										<?php
										
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

										if($end_count > 1){
											if($count % 30 == 0){
											?>
											<div style="width: 45%; float:left">
												<ul class="alt" style="list-style: none">
													<li>
														<?php echo $author." / ".$title; ?>
													</li>
											<?php
											}
											elseif($count % 30 == 29){
											?>
													<li>
														<?php echo $author." / ".$title; ?>
													</li>
												</ul>
											</div>
											<?php
											}
											elseif($count == $end_count - 1){
											?>
													<li>
														<?php echo $author." / ".$title; ?>
													</li>
												</ul>
											</div>
											<?php
											}
											else{
											?>
												<li>
													<?php echo $author." / ".$title; ?>
												</li>
											<?php
											}
										}
										else{
											?>
											<div style="width: 45%; float:left">
												<ul class="alt" style="list-style: none">
													<li>
														<?php echo $author." / ".$title; ?>
													</li>
												</ul>
											</div>
										<?php
										}
										$count++;
									}
									?>
									<?php endif; ?>
								</div>
							</div>
						</div>	
					<?php
						}
						else{
					?>
						<div style="height:28.7cm;border:solid 1px;padding:20px; margin-top: 60px">
							<div class="row">
							<div class="col-md-12 col-xs-12 " style="width: 100%">

								<?php $count = 0; ?>
								<?php $myAllHistories = preg_split('/,/', $certi_preview->booktest_success); ?>
								<?php if(count($myAllHistories) == 0): ?>
								<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
								<?php else: ?>
								<?php
								$start_number = $i * 60;
								$end_temp_num = ($i + 1) * 60;
								if($counts > $end_temp_num){
									$end_number = $end_temp_num;
								}
								else{
									$end_number = $counts;
								}
								for($k = $start_number; $k < $end_number; $k++){
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

									if(($counts - $start_number) > 1){
										if($count % 30 == 0){
										?>
										<div style="width: 45%; float:left">
											<ul class="alt" style="list-style: none">
												<li>
													<?php echo $author." / ".$title; ?>
												</li>
										<?php
										}
										elseif($count % 30 == 29){
										?>
												<li>
													<?php echo $author." / ".$title; ?>
												</li>
											</ul>
										</div>
										<?php
										}
										elseif($count == $end_number - 1){
										?>
												<li>
													<?php echo $author." / ".$title; ?>
												</li>
											</ul>
										</div>
										<?php
										}
										else{
										?>
											<li>
												<?php echo $author." / ".$title; ?>
											</li>
										<?php
										}
									}
									else{
										?>
										<div style="width: 45%; float:left">
											<ul class="alt" style="list-style: none">
												<li>
													<?php echo $author." / ".$title; ?>
												</li>
											</ul>
										</div>
									<?php
									}
									$count++;
								}
								?>
								<?php endif; ?>
							</div>
							</div>
						</div>
					<?php
						}
					}
					?>
				<?php elseif($certi_preview->index == 3): ?>
					<?php
						$myAllHistories = preg_split('/,/', $certi_preview->booktest_success);
						$counts = count($myAllHistories);
						$page_amount = ceil($counts / 30);
						for($i = 0; $i < $page_amount; $i++){
							if($i == 0){
						?>
						<div style="height:28.7cm;border:solid 1px;padding:20px">
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<div class="col-md-6 col-xs-6"  style="float: left;">
										<h2 class="text-md-left" style="text-align:left;margin:0px;font-size:36px;font-family: HGP明朝B;">読Q</h2>
									</div>
									<div class="col-md-6 col-xs-6" style="float: right;">
										<span class="text-md-right  text-md-top" style="float:right;font-size:14px;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
									</div>
								</div>  
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:12px;">読書認定級</div>
								<div class="col-md-12 col-xs-12">
									<h4 class="text-md-center" style="text-align:center;font-size:28px;">読書認定書</h4>
									<h5 class="text-md-center" style="text-align:center;font-size:14px;">（パスコード：　<?php echo e($certi_preview->passcode); ?>）</h5>
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;"><?php echo e($user->fullname()); ?>　様</div>
								<div class="col-md-12 col-xs-12 text-md-left" style="text-align:left;font-size:14px;">(読Qネーム：　<?php echo e($user->username); ?>)</div>
								<div class="col-md-12 col-xs-12 text-md-right" style="text-align:rigth;" >
									<div class="col-md-7 col-xs-8"></div>
									<div class="background_print col-md-5 col-xs-4" style="float:right;background-image: url(<?php echo e(asset('/img/sign2.png')); ?>) !important;background-repeat: no-repeat !important;background-position: center center !important;height:100px;">
										<br><br>
										<span style="float:right;font-size:14px;">一般社団法人読書認定協会</span>
										<br>
										<span style="float:right;font-size:14px;">代表理事　神部ゆかり</span>
									</div>
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12" style="font-size:16px;">
									あなたは、当協会の運営する読Q検定において、書籍についての検定試験に所定数の合格をし、下記の読書認定級を取得しました。
								</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">記</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">読Q検定&nbsp;&nbsp;　<?php echo e($certi_preview->level); ?>級</div>
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">合計取得ポイント　　<?php echo e(floor($certi_preview->sum_point*100)/100); ?>&nbsp;ポイント</div>	
								<div class="col-md-12 col-xs-12 text-md-left">&nbsp;</div>
								<div class="col-md-12 col-xs-12 text-md-center" style="text-align:center;font-size:14px;">合格した書籍の一部　　（著者名/タイトル/出版社/合格日）</div>    
								
								<div class="col-md-12 text-md-left">&nbsp;</div>
							</div>
							<div class="row">		
								<div class="col-md-12 col-xs-12">
									<?php if(count($myAllHistories) == 0): ?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
									<?php else: ?>
									<?php
									if($counts > 30){
										$end_count = 30;
									}
									else{
										$end_count = $counts;
									}
									for($k = 0; $k < $end_count; $k++){
										$myAllHistory = $myAllHistories[$k];
										$myBook = preg_split('/:/', $myAllHistory);
									?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">
										<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  /  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?>  /  <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?>  /  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
										</div>
									<?php
									}
									?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php
							}
							else{
					?>
						<div style="height:28.7cm;border:solid 1px;padding:20px; margin-top: 60px">
							<div class="row">		
								<div class="col-md-12 col-xs-12">
									<?php if(count($myAllHistories) == 0): ?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
									<?php else: ?>
									<?php
									$start_number = $i * 30;
									$end_temp_num = ($i + 1) * 30;
									if($counts > $end_temp_num){
										$end_number = $end_temp_num;
									}
									else{
										$end_number = $counts;
									}
									for($k = $start_number; $k < $end_number; $k++){
										$myAllHistory = $myAllHistories[$k];
										$myBook = preg_split('/:/', $myAllHistory);
									?>
										<div class="col-md-10 col-md-offset-1 col-sm-12">
										<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  /  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?>  /  <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?>  /  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
										</div>
									<?php
									}
									?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php 
							}
						}
					?>
				<?php elseif($certi_preview->index == 4): ?>	
					<?php
						$myAllHistories = preg_split('/,/', $certi_preview->booktest_success);
						$counts = count($myAllHistories);
						$page_amount = ceil($counts / 30);
						for($i = 0; $i < $page_amount; $i++){
							if($i == 0){
					?>
					<div style="height:28.7cm;border:solid 1px;padding:20px">
						<div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="col-md-6 col-xs-6"  style="float: left;">
                                    <h2 class="text-md-left" style="text-align:left;margin:0px;font-size:36px;font-family: HGP明朝B;">読Q</h2>
                                </div>
                                <div class="col-md-6 col-xs-6" style="float: right;">
                                    <span class="text-md-right" style="text-align:right;float:right;font-size:14px;"><?php echo e(date("Y").'年'.date("m").'月'.date("d").'日'); ?></span>
                                </div>
                            </div>             
							<div class="col-md-12 text-md-left" style="text-align:left;font-size:12px;">読書認定級</div>
							<div class="col-md-12">
								<h4 class="text-md-center" style="text-align:center;font-size:28px;">読書認定書</h4>
								<h5 class="text-md-center" style="text-align:center;font-size:14px;">（パスコード：　<?php echo e($certi_preview->passcode); ?>）</h5>
							</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 text-md-left" style="text-align:left;font-size:14px;"><?php echo e($user->fullname()); ?>　様</div>
							<div class="col-md-12 text-md-left" style="text-align:left;font-size:14px;">(読Qネーム：　<?php echo e($user->username); ?>)</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 col-xs-12 text-md-right" style="text-align:rigth;" >
								<div class="col-md-7 col-xs-8"></div>
								<div class="background_print col-md-5 col-xs-4" style="float:right;background-image: url(<?php echo e(asset('/img/sign2.png')); ?>) !important;background-repeat: no-repeat !important;background-position: center center !important;height:100px;">
									<br><br>
									<span style="float:right;font-size:14px;">一般社団法人読書認定協会</span>
									<br>
									<span style="float:right;font-size:14px;">代表理事　神部ゆかり</span>
								</div>
							</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12" style="font-size:16px">
								あなたは、当協会の運営する読Q検定において、下表の通り、書籍についての検定試験に合格されました。
							</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
							<div class="col-md-12 text-md-center" style="text-align:center;font-size:14px;">記</div>
							<div class="col-md-12 text-md-left">&nbsp;</div>
                            <div class="col-md-12 text-md-center" style="text-align:center;font-size:14px;">合格した書籍の一部　　（著者名/タイトル/出版社/合格日）</div>    
							<div class="col-md-12 text-md-left">&nbsp;</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<?php $myAllHistories = preg_split('/,/', $certi_preview->booktest_success); ?>
								<?php if(count($myAllHistories) == 0): ?>
								<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
								<?php else: ?>
								<?php
									if($counts > 30){
										$end_count = 30;
									}
									else{
										$end_count = $counts;
									}
									for($k = 0; $k < $end_count; $k++){
										$myAllHistory = $myAllHistories[$k];
										$myBook = preg_split('/:/', $myAllHistory);
								?>
								<div class="col-md-10 col-md-offset-1 col-sm-12">
									<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  /  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?>  /  <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?>  /  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
								</div>
								<?php
									}
								?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php
							}
							else{
					?>
					<div style="height:28.7cm;border:solid 1px;padding:20px; margin-top: 60px">
						<div class="row">
							<div class="col-md-12">
								<?php if(count($myAllHistories) == 0): ?>
								<div class="col-md-10 col-md-offset-1 col-sm-12">&nbsp;</div>
								<?php else: ?>
								<?php
									$start_number = $i * 30;
									$end_temp_num = ($i + 1) * 30;
									if($counts > $end_temp_num){
										$end_number = $end_temp_num;
									}
									else{
										$end_number = $counts;
									}
									for($k = $start_number; $k < $end_number; $k++){
										$myAllHistory = $myAllHistories[$k];
										$myBook = preg_split('/:/', $myAllHistory);
								?>
								<div class="col-md-10 col-md-offset-1 col-sm-12">
									<?php if(isset($myBook[2])): ?> <?php echo e($myBook[2]); ?> <?php endif; ?>  /  <?php if(isset($myBook[1])): ?> <?php echo e($myBook[1]); ?> <?php endif; ?>  /  <?php if(isset($myBook[3])): ?> <?php echo e($myBook[3]); ?> <?php endif; ?>  /  <?php if(isset($myBook[0])): ?> <?php echo e($myBook[0]); ?> <?php endif; ?>
								</div>
								<?php
									}
								?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php 
							}
						}
					?>
				<?php endif; ?>

			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/tether-master/dist/js/tether.min.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-migrate.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery.blockui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery.cokie.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/uniform/jquery.uniform.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-select/bootstrap-select.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.ja.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('plugins/fuelux/js/spinner.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/typeahead/typeahead.bundle.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo e(asset('js/metronic.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/layout.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/demo.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/layout-frontend.js')); ?>"></script>
<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/charts/Chart.js')); ?>"></script>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.resize.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.pie.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.stack.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.crosshair.min.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/flot/jquery.flot.categories.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('js/Theme.js')); ?>"></script>
	<script src="<?php echo e(asset('js/Charts.js')); ?>"></script>
	<script src="<?php echo e(asset('js/flot/jquery.flot.js')); ?>"></script>
	<script src="<?php echo e(asset('js/flot/jquery.flot.orderBars.js')); ?>"></script>
	<script src="<?php echo e(asset('js/charts-flotcharts.js')); ?>"></script>
	<link rel="stylesheet" href="<?php echo e(asset('css/jqwidgets/styles/jqx.base.css')); ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxcore.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdraw.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxchart.core.js')); ?>"></script>
	<script type="text/javascript" src="<?php echo e(asset('css/jqwidgets/jqxdata.js')); ?>"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script type="text/javascript">
		ComponentsDropdowns.init();
        Metronic.init();
        Layout.init();
        LayoutFrontend.init();
        Demo.init();
        $(document).ready(function(){
			window.onbeforeprint = beforeprint;
			window.onafterprint = afterprint;
			setTimeout(function(){
				
                window.print();
               
                location.href="javascript:history.go(-1)";
              //location.href = "/mypage/passcode?pwd="+<?php echo e($user->passcode); ?>;
           },2000);
			
			
		});
		var initBody;
		function beforeprint(){
			initBody = document.body.innerHTML;
			document.body.innerHTML = idprint.innerHTML;
		}
		function afterprint(){
			
			document.body.innerHTML = initBody;
			location.href="javascript:history.go(-1)";
			//location.href = "/mypage/passcode?pwd="+<?php echo e($user->passcode); ?>;
		}
		
	</script>