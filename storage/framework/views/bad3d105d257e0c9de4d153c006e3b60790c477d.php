

<?php $__env->startSection('styles'); ?>
	<style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;	
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
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">マイ書斎</a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修本一覧
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
					<h3 class="page-title caption col-md-11">監修本一覧</h3>
					<?php if(!$otherview_flag): ?>			
					<div class="tools" style="float:right;">
						<input type="checkbox" <?php if($overseerbook_is_public == 1): ?>checked <?php endif; ?> class="make-switch" id="overseerbook_is_public" data-size="small">
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
						<?php if(!$otherview_flag): ?>
						<table class="table table-bordered table-hover" >
							<thead>
								<tr class="blue">
									<th class="col-md-1"  style="padding:0px">監修決定日</th>
									<th class="col-md-2"  style="padding:0px">タイトル</th>
									<th class="col-md-1"  style="padding:0px">著者</th>
									<th class="col-md-1"  style="padding:0px">読Q本ID</th>
									<th class="col-md-1"  style="padding:0px">読Q本認定日</th>
									<th class="col-md-1"  style="padding:0px">出題数</th>
									<th class="col-md-1"  style="padding:0px">認定ｸｲｽﾞ数</th>
									<th class="col-md-2"  style="padding:0px">帯文管理</th>
									<th class="col-md-2"  style="padding:0px;font-size:13px">各書籍の<br>クイズストックへ</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
								<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php if(Auth::user()->role == config('consts')['USER']['ROLE']['AUTHOR'] && is_array($book->Overseer) && count($book->Overseer) == 0): ?> <?php echo e(with((date_create($book->replied_date1)))->format('Y/m/d')); ?> <?php else: ?> <?php echo e(with((new Date($book->replied_date3)))->format('Y/m/d')); ?><?php endif; ?></td>
										<td><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($book->title); ?></a></td>
										<td><a href="<?php echo e(url('/book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($book->fullname_nick()); ?></a></td>
										<td><a <?php if($book->active >= 3): ?> href="<?php echo e(url('/book/'.$book->id.'/detail')); ?>" <?php endif; ?> class="font-blue-madison">dq<?php echo e($book->id); ?></a></td>
										<td><?php if($book->active == 6): ?> <?php echo e(with($book->updated_at)->format('Y/m/d')); ?> <?php endif; ?></td>
										<td><?php echo e($book->quiz_count); ?></td>
										<td><?php echo e($book->ActiveQuizes()->count()); ?></td>
										<td><a href="<?php echo e(url('/book/'.$book->id.'/article/manage')); ?>" class="font-blue-madison">帯文管理</a></td>
										<td><?php if($book->active == 6): ?><a href="<?php echo e(url('/mypage/quiz_store/1/'.$book->id)); ?>" class="font-blue-madison"> <?php else: ?><a href="<?php echo e(url('/mypage/quiz_store/2/'.$book->id)); ?>" class="font-blue-madison"><?php endif; ?> クイズストック</a></td>
										
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>	
						<?php else: ?>
						<table class="table table-bordered table-hover">
							<thead>
								<tr class="blue">
									<th class="col-md-3">タイトル</th>
									<th class="col-md-3">読Q本ID</th>
									<th class="col-md-3">ジャンル</th>
									<th class="col-md-3">ポイント</th>
								</tr>
							</thead>
							<tbody class="text-md-center">
							    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><a <?php if($book->active >= 3): ?> href="<?php echo e(url("/book/" . $book->id . "/detail")); ?>" <?php endif; ?> class="font-blue-madison"><?php echo e($book->title); ?></a></td>
									<td>dq<?php echo e($book->id); ?></td>
									<td><?php $__currentLoopData = $book->category_names(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($one."、"); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
									<td><?php echo e(floor($book->point*100)/100); ?></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>	
						<?php endif; ?>
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
	<script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/dataTables.bootstrap.js')); ?>"></script>
	<script src="<?php echo e(asset('js/quiz-allowed-records.js')); ?>"></script>
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