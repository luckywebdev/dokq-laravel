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
	                	 > 合格履歴
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
					<h3 class="page-title caption col-md-11">読Q合格履歴</h3>
					<?php if(!$otherview_flag): ?>
						<div class="tools" style="float:right;">
							<input type="checkbox" <?php if($passed_records_is_public == 1): ?>checked <?php endif; ?> class="make-switch" id="passed_records_is_public" data-size="small">
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div>					
						<table class="table table-bordered table-hover text-md-center" <?php if(!$otherview_flag): ?> id="passhistory_author_order1" <?php else: ?> id="passhistory_author_order2" <?php endif; ?>>
							<thead>
								<tr class="blue">
									<th class="col-md-1" style="vertical-align:middle;">受検開始日時</th>
									<th class="col-md-2" style="vertical-align:middle;">タイトル</th>
									<th class="col-md-1" style="vertical-align:middle;">著者</th>
									<th class="col-md-1" style="vertical-align:middle;">著者名ひらがな</th>
									<th class="col-md-1" style="vertical-align:middle;">読Q本</th>
									<th class="col-md-1" style="vertical-align:middle;">ポイント</th>
									<th class="col-md-1" style="vertical-align:middle;">受検終了日時</th>
									<th class="col-md-2" style="vertical-align:middle;">試験監督</th>
									<?php if(!$otherview_flag): ?> <th class="col-md-2" style="vertical-align:middle;">1冊ごとの<br>公開非公開</th> <?php endif; ?>
								</tr>
							</thead>
							<tbody class="text-md-center">
								<?php $__currentLoopData = $myAllHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $passed_quiz_record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr class="info">
									<td><?php echo e($passed_quiz_record->finished_date); ?></td>
									<td><a <?php if($passed_quiz_record->Book->active >= 3): ?> href="<?php echo e(url('book/' . $passed_quiz_record->book_id . '/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($passed_quiz_record->Book->title); ?></a></td>
									<td><a href="<?php echo e(url('/book/search_books_byauthor?writer_id='.$passed_quiz_record->Book->writer_id.'&fullname='.$passed_quiz_record->Book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($passed_quiz_record->Book->fullname_nick()); ?></a></td>
									<td><?php echo e($passed_quiz_record->Book->fullname_yomi()); ?></td>
									<td>dq<?php echo e($passed_quiz_record->book_id); ?></td>
									<td><?php echo e(floor($passed_quiz_record->point*100)/100); ?></td>
									<td><?php echo e(date_format(date_add(date_create($passed_quiz_record->finished_date), date_interval_create_from_date_string($passed_quiz_record->passed_test_time."seconds")), "Y-m-d H:i:s")); ?></td>
									<td><a href="<?php echo e(url("/mypage/other_view/".$passed_quiz_record->org_id)); ?>" class="font-blue-madison"><?php echo e($passed_quiz_record->Org_User->username); ?></a></td>
									<?php if(!$otherview_flag): ?> <td><input type="checkbox" class="make-switch onebook" data-size="small" id="<?php echo e($passed_quiz_record->id); ?>" <?php if(($passed_quiz_record->is_public) == 1): ?>checked <?php endif; ?> ></td> <?php endif; ?>
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

			var info = {
			    	_token: $('meta[name="csrf-token"]').attr('content')
			}
			$(".onebook").on('switchChange.bootstrapSwitch', function(){
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/pass_history/setpublic/is_public/" + $(this).attr('id');
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
				    	console.log(response);
			    	}
				});	
			});

			$("#passed_records_is_public").on('switchChange.bootstrapSwitch', function(){
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