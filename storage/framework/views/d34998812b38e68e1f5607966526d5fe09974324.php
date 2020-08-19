
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
	            <li>
	                > <a href="<?php echo e(url('/book/search')); ?>">本を検索</a>
	            </li>
	            <li>
	                > <a <?php if($book->active >= 3): ?> href="<?php echo url('book').'/'.$book->id.'/detail'; ?>" <?php endif; ?>>本のページ</a>
	            </li>
	            <li class="hidden-xs">
	                > 帯文の投稿と投
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">帯文の投稿と投票</h3>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" id="voteForm" method="post">
					<?php echo e(csrf_field()); ?>

						<div class="form-body">
							<div class="row">
								<label class="offset-md-1 col-md-7 pull-left">
								<h4>タイトル: 
								<?php if($book->active >= 3): ?>
									<a href="<?php echo e(url('book/'.$book->id.'/detail')); ?>" class="font-blue-madison"><?php echo e($book->title); ?></a>
								<?php else: ?>
									<?php echo e($book->title); ?>

								<?php endif; ?>
								</h4>
								<br><h4>著者: <?php echo e($book->fullname_nick()); ?></h4></label>
							</div>
							<div class="row">
								<label class="offset-md-1 col-md-7 pull-left"><h4>帯文に投票する</h4></label>
							</div>

							<div class="row">
								<div class="offset-md-1 col-md-10">
									<div class="portlet light">
										<div class="portlet-body" style="height: 300px;">
											<div class="table-scrollable table-scrollable-borderless scroller" style="height:280px;width:100%" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
												<table class="table table-bordered table-hover table-striped">
													<thead>
													    <tr class="blue" style="width:100% !important;vertical-align:middle;">
                                                            <th style="width:10% !important;vertical-align:middle;">投稿日</th>
                                                            <th style="width:15% !important;vertical-align:middle;">投稿者</th>
                                                            <th style="width:30% !important;vertical-align:middle;">帯文</th>
                                                            <th style="width:15% !important;vertical-align:middle;">いいね！<br>と言っている人数</th>
                                                            <?php if($is_passed == 1 && $is_checked == 1): ?>
                                                            <th style="width:15% !important;vertical-align:middle;">いいね！<br>する</th>
                                                            <th style="width:15% !important;vertical-align:middle;">いいねを<br>取り消す</th>
                                                            <?php endif; ?>
														</tr>
													</thead>
													<tbody class="text-md-center">
													<?php $index = 1; ?>
													<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<tr style="width:100% !important;vertical-align:middle;text-align:center;">
															<td style="vertical-align:middle;text-align:center;"><?php echo e(date_format($article->created_at, "Y-m-d")); ?></td>
															<?php if($is_checked == 1): ?>
																<td style="vertical-align:middle;text-align:center;"><a href="<?php echo e(url('mypage/other_view/' . $article->register_id)); ?>" class="font-blue-madison">
																	<?php if($article->User->age() < 15): ?>
														                中学生以下ー<?php echo e($index++); ?>

														            <?php else: ?>
														                <?php if($article->register_visi_type == 0): ?> <?php if($article->User->role  != config('consts')['USER']['ROLE']['AUTHOR']): ?> <?php echo e($article->User->fullname()); ?> <?php else: ?> <?php echo e($article->User->fullname_nick()); ?> <?php endif; ?> <?php else: ?> <?php echo e($article->User->username); ?> <?php endif; ?>
														            <?php endif; ?>
																	</a>
																</td>
															<?php else: ?> 
																<td style="vertical-align:middle;text-align:center;">
																<?php if($article->User->age() < 15): ?>
														                中学生以下ー<?php echo e($index++); ?>

														        <?php else: ?>
														            <?php if($article->register_visi_type == 0): ?> <?php if($article->User->role  != config('consts')['USER']['ROLE']['AUTHOR']): ?> <?php echo e($article->User->fullname()); ?> <?php else: ?> <?php echo e($article->User->fullname_nick()); ?> <?php endif; ?> <?php else: ?> <?php echo e($article->User->username); ?> <?php endif; ?>
																<?php endif; ?>
																</td>
															<?php endif; ?>
															<td style="vertical-align:middle;text-align:center;"><?php echo e($article->content); ?></td>
															<td style="vertical-align:middle;text-align:center;"><?php echo e(count($article->Votes)); ?>人</td>
															<?php if($is_passed == 1 && $is_checked == 1): ?>
																<?php if($article->VotesMine(Auth::id()) == 0): ?>
																<td style="vertical-align:middle;text-align:center;"><a class="font-blue-madison like" href="<?php echo url('/book/' . $article->id . '/update_article_vote');?>">いいね！</a></td>
																<td style="vertical-align:middle;text-align:center;"><a class="font-blue-madison unlike" style="color: grey !important" value="$key">いいね！を<br>取り消す</a></td>
																<?php elseif($article->VotesMine(Auth::id()) == 1): ?>
																<td style="vertical-align:middle;text-align:center;"><a class="font-blue-madison like" style="color: grey !important" value="$key">いいね！</a></td>
																<td style="vertical-align:middle;text-align:center;"><a class="font-blue-madison unlike" href="<?php echo e(url('/book/' . $article->id . '/update_article_vote')); ?>">いいね！を<br>取り消す</a></td>
																<?php endif; ?>
															<?php endif; ?>
														</tr>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php if($is_passed == 1 && $is_checked == 1 && $is_article == 0): ?>
							<div class="row">
								<label class="offset-md-1 col-md-7 pull-left"><h4>帯文を投稿する</h4></label>
							</div>
							<div class="form-group row">
								<div class="offset-md-1 col-md-10">
									<div class="row">
										<label class="control-label col-md-12 text-md-left">
											本の帯を作るつもりで、まだ読んでいない人が読みたくなるような帯文を投稿しましょう！<br>
											結末がわかってしまうような帯文は避けてください。適切でない投稿は、通知することなく削除させていただきますのでご了承願います。
										</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<textarea required rows="2" id="content" class="form-control popover-help" maxlength="19" name="content" placeholder="帯文を入力（全角19文字まで）"></textarea>
											<span class="help-block">投稿の削除は、マイ書斎内の、帯文投稿履歴から行ってください。</span>
										</div>
										<label class="control-label col-md-4">投稿と投票の表示名を選択（匿名不可） </label>
										<div class="col-md-2">
											<select class="bs-select form-control" name="mode_disp_name" id="mode_disp_name"> 
												<option value="0">本名</option>
												<option value="1">読Qネーム</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>							
						</div>	
						<?php if($is_passed == 1 && $is_checked == 1 && $is_article == 0): ?>
						<div class="form-actions text-md-center">
							<button type="button" class="btn btn-warning" id="contribute">投　稿</button>
						</div>
						<?php endif; ?>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" id="back">戻　る</button>
				</div>
			</div>
		</div>
	</div>

<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text">入力してください!</span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
			$('#content').maxlength({
	            limitReachedClass: "label label-danger",
	            alwaysShow: true
	        });
	        $(".popover-help").popover();

	        $("#contribute").click(function() {
	            if($('#content').val() == "") {
	                $("#alertModal").modal();
	            } else {
                    $("#voteForm").attr("action", "<?php echo url('/book/' . $book['id'] . '/add_article');?>");
                    $("#voteForm").submit();
	            }
	        });
	        $("#back").click(function() {
	            history.go(-1);
	            
		        //$("#voteForm").attr("action", "<?php echo url('/book/' . $book['id'] . '/detail');?>"); 
		        //$("#voteForm").attr("method", "get");
		        //$("#voteForm").submit();
	        });
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>