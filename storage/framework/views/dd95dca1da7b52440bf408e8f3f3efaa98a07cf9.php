

<?php $__env->startSection('styles'); ?>
   <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
   <style>

	
	td p{
		max-width:20px !important;
		font-size:18px !important;
		font-family: HGP明朝B; 
	}
	td a{
		text-decoration:none !important;
		font-family:HGP明朝B; 
	}
	.font_gogic{
        font-family:HGP明朝B; 
    }
	@media (max-width: 560px){
	   table{
		   width: 1024px !important;
	   }
	   .make_switch{
		   margin-left: 250px !important;
		   margin-bottom: 2% !important;
	   }
   }
</style>
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
	            	<a href="#">
	                	 > マイ本棚
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">マイ本棚</h3>

			<div class="row">
			<?php if(!$otherview_flag): ?>
				<div class="tools make_switch" style="margin-left: 350px">
					<input type="checkbox" <?php if($mybookcase_is_public == 1): ?> checked <?php endif; ?> class="make-switch" id="mybookcase_is_public" data-size="small">
				</div>
			<?php endif; ?>
				<div class="col-md-2" style="margin-left: 100px">
					<select class="bs-select form-control">
						<option id="2" value="2"  <?php if($order == 2): ?> selected <?php endif; ?>>読書日付順</option>
						<option id="0" value="0"  <?php if($order == 0): ?> selected <?php endif; ?>>著者五十音順</option>
						<option id="1" value="1"  <?php if($order == 1): ?> selected <?php endif; ?>>タイトル五十音順</option>
					</select>
				</div>
			</div>

			<div class="row margin-top-10">
				<div class="col-md-12">	
				<div class="" style="min-width: 100%; overflow-x: auto">
					<table class="table table-bordered table-hover  table-category" style="width: 100%">
					<tbody class="text-md-center">
						<?php $row = floor(count($myBooks) / 20)?>
						<?php for($i = 0; $i <= $row; $i++): ?>
						<tr style="height:300px;font-size:16px;padding:12px;">
							<?php for($j = 0; $j < 20; $j++): ?>
							<?php
								if($i % 3 == 0){
									if($j % 4 == 0)     $color = "#FFB5FC";
									elseif($j % 4 == 1) $color = "#F6F99A";
									elseif($j % 4 == 2) $color = "#92FAB2";
									elseif($j % 4 == 3) $color = "#A7D4FB";
								}
								elseif($i % 3 == 1){
									if($j % 4 == 0) $color     = "#F6F99A";
									elseif($j % 4 == 1) $color = "#92FAB2";
									elseif($j % 4 == 2) $color = "#A7D4FB";
									elseif($j % 4 == 3) $color = "#FFB5FC";
								}
								elseif($i % 3 == 2){
									if($j % 4 == 0)     $color = "#92FAB2";
									elseif($j % 4 == 1) $color = "#A7D4FB";
									elseif($j % 4 == 2) $color = "#FFB5FC";
									elseif($j % 4 == 3) $color = "#F6F99A";
								}
							?>

							<?php if(isset($myBooks[$i*20+(19-$j)])): ?>

							<td class="col-md-1 text-md-center" style="background-color:<?php echo e($color); ?>;padding-left:0px;padding-right:0px;">
								<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:300px;">
									<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
										<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;"  <?php if($myBooks[$i*20+(19-$j)]->active >= 3): ?> href="<?php echo e(url("/book/".$myBooks[$i*20+(19-$j)]->id."/detail")); ?>" <?php endif; ?>>
										<?php echo e($myBooks[$i*20+(19-$j)]->title); ?>

										</a>
									</h5>
								</div>
								<div class="row col-md-12" style="writing-mode:vertical-rl;margin-left:0px;margin-right:0px;padding-left:0px;padding-right:0px;height:100px;">
									<h5 class="font_gogic text-md-left" style="align-self:center;font-family:HGP明朝B;">
										<a class="font_gogic" style="text-decoration:none;font-family:HGP明朝B;" href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $myBooks[$i*20+(19-$j)]->writer_id.'&fullname='.$myBooks[$i*20+(19-$j)]->firstname_nick.' '.$myBooks[$i*20+(19-$j)]->lastname_nick)); ?>">
										<?php echo e($myBooks[$i*20+(19-$j)]->firstname_nick.' '.$myBooks[$i*20+(19-$j)]->lastname_nick); ?>

										</a>
									</h5>
								</div>
							</td>
							<?php else: ?>
							<td class="col-md-1">&nbsp;</td>
							<?php endif; ?>
							<?php endfor; ?>
						</tr>
						<?php endfor; ?>
					</tbody>
					</table>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	 <form id="order_form" action="" method="get">
		<input type="hidden" id="order" name="order" value="">
	</form> 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script>
		jQuery(document).ready(function() {
			ComponentsDropdowns.init();
			<?php if($otherview_flag): ?>
				$('body').addClass('page-full-width');
				var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
			<?php endif; ?>
			$('.make-switch').bootstrapSwitch({
				onText: "公開",
				offText: "非公開"
			});

			$(".make-switch").on('switchChange.bootstrapSwitch', function(){
				var info = {
				    _token: $('meta[name="csrf-token"]').attr('content')
				}
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
				$.ajax({
					type: "post",
		      		url: post_url,
				    data: info,

					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },
				    success: function (response){
			    	}
				});
			});
//			$("#check1").on('switchChange.bootstrapSwitch', function(){
//				alert($(this).attr("checked"));
//
//				var info = {
//				    	_token: $('meta[name="csrf-token"]').attr('content')
//				}
//
////				
//				$.ajax({
//					type: "post",
//		      		url: "<?php echo e(url('/mypage/top/setpublic')); ?>",
//				    data: info,
//				    
//					beforeSend: function (xhr) {
//			            var token = $('meta[name="csrf-token"]').attr('content');
//			            if (token) {
//			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
//			            }
//			        },		    
//				    success: function (response){
//				    	if(response.status == '1'){
//				    		$(".wish_public").each(function(index, item){
//								$(item).html("公開");
//							})
//				    	}else if(response.status == '0'){
//				    		$(".wish_public").each(function(index, item){
//								$(item).html("非公開");
//							})
//				    	}
//				    	
//			    	}
//				});	
//
//				
//			});
			
			$('.bs-select').change(function(){
				$("#order").val($(this).val());
				$("#order_form").attr("method", "get");
				$("#order_form").attr("action", "<?php echo e(url('/mypage/category/'.$id)); ?>");
				$("#order_form").submit();
			})
		});   
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>