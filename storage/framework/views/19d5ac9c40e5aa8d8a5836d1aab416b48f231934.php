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
	            	<a href="#">
	                	 > 読Q活動の履歴
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > 本の登録・認定記録
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
		    	<div class="col-md-12">	
					<h3 class="page-title caption col-md-11">本を登録し、読Q本認定された記録</h3>
					<?php if(!$otherview_flag): ?>				
					<div class="tools" style="float:right;">
						<input type="checkbox" <?php if($book_allowed_record_is_public == 1): ?>checked <?php endif; ?> class="make-switch" id="book_allowed_record_is_public" data-size="small">
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div>
						<table class="table table-bordered table-hover"  id="book_reg_history">
							<thead>
								<tr class="blue">
									<th class="col-md-1">認定日</th>
									<th class="col-md-3">タイトル</th>
									<th class="col-md-1">著者</th>
									<th class="col-md-2">著者名ひらがな</th>
									<th class="col-md-1">読Q本</th>
									<th class="col-md-2">読Q本ポイント</th>
									<th class="col-md-2">登録者表示名</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								<?php $__currentLoopData = $allowed_books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowed_book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr class="info">
									<td><?php echo e(date_create($allowed_book->finished_date)->format('Y.n.d')); ?></td>
									<td><a <?php if($allowed_book->Book->active >= 3): ?> href="<?php echo e(url('book/' . $allowed_book->book_id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($allowed_book->Book->title); ?></a></td>
									<td><a href="<?php echo e(url('/book/search_books_byauthor?writer_id=' . $allowed_book->Book->writer_id.'&fullname='.$allowed_book->Book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($allowed_book->Book->fullname_nick()); ?></a></td>
									<td><?php echo e($allowed_book->Book->fullname_yomi()); ?></td>
									<td><a <?php if($allowed_book->Book->active >= 3): ?> href="<?php echo e(url('book/' . $allowed_book->book_id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison">dq<?php echo e($allowed_book->book_id); ?></a></td>
									<td><?php echo e(floor($allowed_book->point*100)/100); ?></td>
									<td>
										<?php if($allowed_book->Book->register_visi_type == 0): ?>
											<?php if($allowed_book->User->age() >= 15): ?>
												<?php if($allowed_book->User->isAuthor()): ?>
													<?php echo e($allowed_book->User->fullname_nick()); ?>

												<?php else: ?>
													<?php echo e($allowed_book->User->fullname()); ?>

												<?php endif; ?>
											<?php else: ?>
												中学生以下非表示
											<?php endif; ?>
										<?php else: ?>
											<?php echo e($allowed_book->User->username); ?>

										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
	
	<script>
		jQuery(document).ready(function() {
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
		});   
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>