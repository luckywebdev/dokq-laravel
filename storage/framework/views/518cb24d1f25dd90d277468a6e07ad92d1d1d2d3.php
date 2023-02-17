

<?php $__env->startSection('styles'); ?>
	<style>
		thead tr th, tbody tr td{
			vertical-align: middle !important;
			text-align: center !important;
		}
		.alert_msg {
			color: red;
			position: absolute;
			right: 2%;
			font-weight: bold;
			top: 70px;
			white-space: normal;
			width: 60%;
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
	            	> <a href="<?php echo e(url('/mypage/top')); ?>">
	                    本の検索
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> <a href="#">
	                	 クイズを作る
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	> 監修者による認定審査
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">クイズの認定審査リスト</h3>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-2">監修本のタイトルを検索</label>
						
						<div class="col-md-4">
							<select class="form-control select2me"  placeholder="選択..." style="height:33px !important" id="select_book">
								<option></option>
								<option value="<?php echo e($book->id); ?>"  selected><?php echo e($book->title); ?></option>
							</select>
						</div>						
					</div>
				</div>
			</div>
			<?php if($book): ?>
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						
						<div class="panel-heading">
						<div class="row">
							<div class="col-offset-1 col-md-2 text-md-right" style="padding:0px"><span style="color:white;">タイトル：</span></div>
							<div class="col-md-2 text-md-left" style="padding:0px"><span style="color:black;"><?php echo e($book->title); ?></span></div>
							<div class="col-md-1 text-md-right" style="padding:0px"><span style="color:white;">著者：</span></div>
							<div class="col-md-2 text-md-left" style="padding:0px"><span style="color:black;"><?php echo e($book->fullname_nick()); ?></span></div>
							<div class="col-md-1 text-md-right" style="padding:0px"><span style="color:white;">読Q本ID：</span></div>
							<div class="col-md-1 text-md-left" style="padding:0px"><span style="color:black;">dq<?php echo e($book->id); ?></span></div>
							<div class="col-md-1 text-md-right" style="padding:0px"><span style="color:white;">出題数：</span></div>
							<div class="col-md-1 text-md-left" style="padding:0px"><span style="color:black;">全<?php echo e($book->quiz_count); ?> 問</span></div>
							<div class="col-md-1"></div>
						</div>
						<br>
						<div class="row">
							
							<div class="col-offset-1 col-md-2 text-md-right" style="padding:0px"><span style="color:white;">読Q本ポイント：</span></div>
							<div class="col-md-1 text-md-left" style="padding:0px"><span style="color:black;"><?php echo e(floor($book->point*100)/100); ?></span></div>
							<div class="col-md-2 text-md-right" style="padding:0px"><span style="color:white;">クイズ認定ポイント：</span></div>
							<div class="col-md-2 text-md-left" style="padding:0px"><span style="color:black;"><?php echo e(floor($book->point * 0.1*100)/100); ?> / 1問 （10問限度）</span></div>
							<div class="col-md-3 text-md-right" style="padding:0px"><span style="color:white;">認定に必要なクイズの最低数：</span></div>
							<div class="col-md-1 text-md-left" style="padding:0px"><span style="color:black;"><?php echo e($book->quiz_count * 3); ?> 問</span>  </div>
						</div>
					</div>
						<div class="portlet-body">
							<ul class="nav nav-margent" >
								<li class="<?php if(isset($type) && $type == '1'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/mypage/quiz_store/1/'.$book->id)); ?>"><strong>
									認定クイズの閲覧、編集</strong></a>
								</li>
								<li class="<?php if(isset($type) && $type == '2'): ?> active <?php endif; ?>">
									<a href="<?php echo e(url('/mypage/quiz_store/2/'.$book->id)); ?>"><strong>
									監修者による認定審査</strong></a>
								</li>								
							</ul>
							<h5 class="text-bold pull-right alert_msg" style="color: red">注意！：　クイズ作成者が1人だけの場合、読Q本登録を完了できません。 （著者が監修者の場合を除く）</h5>

							<div class="tab-content" style="background: #fcc5fa;">
								
								<div class="tab-pane fade <?php if(isset($type) && $type == '1'): ?> active in <?php endif; ?>" id="tab_1">
									<form class="form-horizontal form" id="form-validation1" action="" role="form" method="post">
									<input type="hidden" name="bookId" id="bookId" value="<?php echo e($book->id); ?>">
									<?php echo e(csrf_field()); ?>

									<table class="table table-striped table-bordered table-hover" style="color:" data-table>
										<thead>
											<tr class="success">
												<th>No</th>
												<th>受付日</th>
												<th width="40%">クイズ本文</th>
												<th>正解</th>
												<th>出典ページ</th>
												<th>名前</th>
												<th>クイズID</th>
												<th>編集</th>
											</tr>
										</thead>
										<?php if(isset($type) && $type == '1'): ?>
										<tbody class="text-md-center">
										
											<?php $__currentLoopData = $book->ActiveQuizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td>	
												<?php echo e($key + 1); ?>	
												</td>
												<td><?php echo e(with($quiz->updated_at)->format("Y/m/d")); ?> <?php if($quiz->active < 2): ?> <br><span style="color:red">新着</span> <?php endif; ?></td>
												<td><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
															$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
															for($i = 0; $i < 30; $i++) {
															 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
																$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
															} 
															echo $st  ?></td>
												<td><?php if($quiz->answer == 1): ?> ① <?php elseif($quiz->answer == 0): ?> ② <?php endif; ?></td>
												<td><?php echo $quiz->AppearPosition() ?></td>
												<td><?php   if($quiz->register_visi_type == 1){
													            if($quiz->Register->role == config('consts')['USER']['ROLE']['AUTHOR'])
													                $quiz_register_name = $quiz->Register->fullname_nick();
													            else
													    		  $quiz_register_name = $quiz->Register->fullname();
													    	}else if($quiz->register_visi_type == 2){
													            $quiz_register_name = $quiz->Register->username;
													        }else{
													            $quiz_register_name = "（".$quiz->Register->username."）";
													        } ?>
													<a href="<?php echo e(url('mypage/other_view/' . $quiz->Register->id)); ?>" class="font-blue">
													<?php echo e($quiz_register_name); ?></a>	
												</td>
												<td><?php if($quiz->doq_quizid !== null): ?><?php echo e($quiz->doq_quizid); ?> <?php endif; ?></td>
												<td>
													<div><a class="quiz_edit font-blue" qid="<?php echo e($quiz->id); ?>">編集</a></div>
												</td>
											</tr>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
										<tbody class="text-md-center">
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td>合計 <span class="success_total"><?php echo e(count($book->ActiveQuizes)); ?></span></td>
												<td></td>
												<td></td>
											</tr>
										</tbody>
										<?php endif; ?>
									</table>
									</form>
									<div class="row">
										
										<div class="col-md-12 text-md-right">
											<button class="btn btn-info"  onclick="javascript:history.go(-1)">戻　る</button>
										</div>
									</div>
									<input type="hidden" id="qid" name="qid" value="">
								</div>
								<div class="tab-pane fade <?php if(isset($type) && $type == '2'): ?> active in <?php endif; ?>" id="tab_2">
									<form class="form-horizontal form" id="form-validation" action="<?php echo e(url('/book/accept')); ?>" role="form" method="post">
									<input type="hidden" name="bookId" id="bookId" value="<?php echo e($book->id); ?>">
									<?php echo e(csrf_field()); ?>

									<table class="table table-striped table-bordered table-hover" id="acceptquiz2" data-table>
										<thead>
											<tr class="success">
												<th>No</th>
												<th class="col-md-1">受付日</th>
												<th class="col-md-4">クイズ本文</th>
												<th class="col-md-1">正解</th>
												<th class="col-md-1">出典ページ</th>
												<th class="col-md-2">名前</th>
												<th class="col-md-1">認定</th>
												<th class="col-md-1">クイズ認定ポイント付与</th>
												<th class="col-md-1">不採択理由</th>
											</tr>
										</thead>
										<?php if(isset($type) && $type == '2'): ?>
										<tbody class="text-md-center">
										
											<?php $__currentLoopData = $book->Quizelists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
												<td>	
												<?php echo e($key + 1); ?>	
												</td>
												<td><?php echo e(with($quiz->updated_at)->format("Y/m/d")); ?> <?php if($quiz->active < 2): ?> <br><span style="color:red">新着</span> <?php endif; ?></td>
												<td><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
															$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
															for($i = 0; $i < 30; $i++) {
															 	$st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
																$st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
															} 
															echo $st;  ?></td>
												<td><?php if($quiz->answer == 1): ?> ① <?php elseif($quiz->answer == 0): ?> ② <?php endif; ?></td>
												<td><?php echo $quiz->AppearPosition() ?></td>
												<td><?php   if($quiz->register_visi_type == 1){
													            if($quiz->Register->role == config('consts')['USER']['ROLE']['AUTHOR'])
													                $quiz_register_name = $quiz->Register->fullname_nick();
													            else
													    		  $quiz_register_name = $quiz->Register->fullname();
													    	}else if($quiz->register_visi_type == 2){
													            $quiz_register_name = $quiz->Register->username;
													        }else{
													            $quiz_register_name = "（".$quiz->Register->username."）";
													        } ?>
													<a href="<?php echo e(url('mypage/other_view/' . $quiz->Register->id)); ?>" class="font-blue">
													<?php echo e($quiz_register_name); ?></a>	
												</td>
												<td>
													<p>
														<input type="checkbox" qid="<?php echo e($quiz->id); ?>" class="allow accept_quiz<?php echo e($quiz->id); ?>" onchange="javascript:onChangeAccept(this);" value="1" name="accept_quiz<?php echo e($quiz->id); ?>" <?php if($quiz->active == 2): ?>checked <?php endif; ?>  <?php if($quiz->active >= 2): ?> disabled <?php endif; ?>> 採択
													</p>
													<p>
														<input type="checkbox" qid="<?php echo e($quiz->id); ?>" class=" reject reject_quiz<?php echo e($quiz->id); ?>" onchange="javascript:onChangeReject(this);" value="0" name="reject_quiz<?php echo e($quiz->id); ?>" <?php if($quiz->active != 2): ?> checked <?php endif; ?> <?php if($quiz->active >= 2): ?> disabled <?php endif; ?>> X
													</p>
												</td>
												<td><?php if($quiz->active != 3): ?><?php echo e(floor($book->point * 0.1*100)/100); ?>  <?php else: ?> 0 <?php endif; ?></td>
												<td>
													<select class="form-control select2me" name="reason<?php echo e($quiz->id); ?>" placeholder="選択..." style="width:100px; height:33px !important">
														<option></option>
														<option value="1" <?php if($quiz->reason == 1): ?> selected <?php endif; ?>><?php echo e(config('consts')['QUIZ']['REJECT_REASON'][0]); ?></option>
														<option value="2" <?php if($quiz->reason == 2): ?> selected <?php endif; ?>><?php echo e(config('consts')['QUIZ']['REJECT_REASON'][1]); ?></option>
														<option value="3" <?php if($quiz->reason == 3): ?> selected <?php endif; ?>><?php echo e(config('consts')['QUIZ']['REJECT_REASON'][2]); ?></option>
													</select>
												</td>
											</tr>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
										<tbody class="text-md-center">
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td>合格合計 </td>
												<td><span class="success_total"><?php echo e(count($book->ActiveQuizes()->get())); ?></span></td>
												<td>不合格合計 </td>
												<td><span class="fail_total"><?php echo e(count($book->UnActiveQuizes()->get())); ?></span></td>
											</tr>
										
										</tbody>
										<?php endif; ?>	
									</table>
									</form>
									<div class="row">
										<div class="col-md-12 text-md-center">
											<br>
											<p>認定したｸｲｽﾞが出題数の3倍に達していて、出典ページがまんべんなく揃っていれば、この本を読Q本認定できます。認定後は原則としてもうクイズ募集しないので、充分に揃ってから登録しまししょう。</p>
										</div>

									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-10 text-md-center ">
												<button type="button" id="btn_submit" class="btn btn-primary" style="margin-bottom:8px" <?php if(count($book->ActiveQuizes) < $book->quiz_count * 3 ): ?> disabled <?php elseif($book->active == 6 && count($book->PendingQuizes) < 1): ?> disabled <?php endif; ?>>読Q本へ登録</button>
											</div>
											<div class="col-md-2 text-md-right ">
												<button class="btn btn-info"  onclick="javascript:history.go(-1)">戻　る</button>
											</div>
										</div>
									</div>
									</form>
									
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php endif; ?>
			
			
		</div>
	</div>
	<input type="hidden" id="qid" name="qid" value="">
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	
      	<div class="modal-body">
        	<span id="alert_text"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning confirm modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<div id="alertDeleteModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	
      	<div class="modal-body">
        	<span id="alert_text2"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >O　K</button>
        </div>
    </div>

  </div>
</div>
<div id="alertSuccessModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>成功</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text1"></span>
     	</div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >確　認</button>
        </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#select_book").change(function(){
				location.href="<?php echo e(url('/mypage/quiz_store/1/')); ?>" + $(this).val();
			});
			$(".quiz_edit").click(function() {
				console.log("$$$");
				// console.log("/quiz/create?quiz=" + $(this).attr("qid") + "&act=accept");
			    location.href = "/quiz/create?quiz=" + $(this).attr("qid") + "&act=accept";
			});
			$(".quiz_delete").click(function () {
				/*var aciveQuiziesCnt = <?php echo e(count($book->ActiveQuizes()->get())); ?>;
				var QuiziesCnt = <?php echo e($book->quiz_count * 3); ?>;
				
				if(aciveQuiziesCnt > QuiziesCnt){
					$("#qid").val($(this).attr("qid"));
                	$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_DELETE']); ?>");
                	$("#alertModal").modal();
				}else{
					//$("#qid").val($(this).attr("qid"));
					var str = "<?php echo e(sprintf(config('consts')['MESSAGES']['QUIZE_NO_DELETE'], $book->quiz_count * 3)); ?>";
                	$("#alert_text2").html(str);
                	$("#alertDeleteModal").modal();
				}*/
                var book_active = <?php echo e($book->active); ?>;
                if(book_active == 6){
                	var str = "<?php echo e(sprintf(config('consts')['MESSAGES']['RECOGQUIZE_NO_DELETE'])); ?>";
                	$("#alert_text2").html(str);
                	$("#alertDeleteModal").modal();
                }else{
                	$("#qid").val($(this).attr("qid"));
                	$("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_DELETE']); ?>");
                	$("#alertModal").modal();
                }
			});
			$(".confirm").click(function() {
		   		location.href = "/quiz/remove/" + $("#qid").val();
			})

			$("#btn_submit").click(function(){
			    $(".form-horizontal").submit();
			});

			$("#quizfinish").click(function(){
				
				var data = {_token: $('meta[name="csrf-token"]').attr('content') , book_id: $("#bookId").val()};
	            $.ajax({
	                type: "post",
	                url: "<?php echo e(url('/book/quizfinish')); ?>",
	                data: data,
	                
	                beforeSend: function (xhr) {
	                    var token = $('meta[name="csrf_token"]').attr('content');
	                    if (token) {
	                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	                    }
	                },          
	                success: function (response){
	                    if(response.status == 'success'){
	                    	$("#quizfinish").attr("disabled", true);

				    		$("#alert_text1").html("<?php echo e(config('consts')['MESSAGES']['QUIZ_FINISH_SUCCEED']); ?>");
							
						}else{
							$("#alert_text1").html("<?php echo e(config('consts')['MESSAGES']['FAILED']); ?>");
						}
						$("#alertSuccessModal").modal();
			        }
	            })
			});
		});

		function onChangeAccept(obj) {
			var set = jQuery(this).attr("data-set");
			if($(obj).attr("checked")) {
				$(".success_total").html(parseInt($(".success_total").html()) + 1);
				if(parseInt($(".fail_total").html()) != 0)
					$(".fail_total").html(parseInt($(".fail_total").html()) - 1);
				$(".reject_quiz" + $(obj).attr("qid")).attr("checked", false);
			} else {
				if(parseInt($(".success_total").html()) != 0)
					$(".success_total").html(parseInt($(".success_total").html()) - 1);
				$(".fail_total").html(parseInt($(".fail_total").html()) + 1);
				$(".reject_quiz" + $(obj).attr("qid")).attr("checked", true);
			}

			if(parseInt($(".success_total").html()) >= <?php echo e($book->quiz_count * 3); ?>){
				
				<?php if(Auth::check() && !Auth::user()->isAuthor()): ?>	
					var checkboxes = $('.allow');
					var quizid_ary = '';
					for(var i = 0; i < checkboxes.length; i++){
						
						if($(checkboxes[i]).parent().hasClass("checked")){

							var qid = $(checkboxes[i]).attr("qid");
							quizid_ary += qid+',';
						}
					}
					//監修者 認定クイズを全部自作
					var data = {_token: $('meta[name="csrf-token"]').attr('content') , quizid_ary: quizid_ary};
					$.ajax({
						type: "post",
						url: "<?php echo e(url('/quiz/isOverseerQuizAjax')); ?>",
						data: data,
						
						beforeSend: function (xhr) {
							var token = $('meta[name="csrf_token"]').attr('content');
							if (token) {
								return xhr.setRequestHeader('X-CSRF-TOKEN', token);
							}
						},          
						success: function (response){
							if(response.status == 'success'){
								$("#btn_submit").removeAttr('disabled');
							}else{
								$("#btn_submit").attr('disabled',true);
							}
						}
					})
				<?php else: ?>
					$("#btn_submit").removeAttr('disabled');
				<?php endif; ?>
				
			}
			else{
				$("#btn_submit").attr('disabled',true);
			}
			jQuery.uniform.update($(".reject_quiz" + $(obj).attr("qid")));
		}

		function onChangeReject(obj) {
            if($(obj).attr("checked")) {
            	if(parseInt($(".success_total").html()) != 0)
                	$(".success_total").html(parseInt($(".success_total").html()) - 1);
                $(".fail_total").html(parseInt($(".fail_total").html()) + 1);
                $(".accept_quiz" + $(obj).attr("qid")).attr("checked", false);
            } else {
                $(".success_total").html(parseInt($(".success_total").html()) + 1);
                if(parseInt($(".fail_total").html()) != 0)
                	$(".fail_total").html(parseInt($(".fail_total").html()) - 1);
                $(".accept_quiz" + $(obj).attr("qid")).attr("checked", true);
            }
            if(parseInt($(".success_total").html()) >= "<?php echo e($book->quiz_count * 3); ?>"){
            	 <?php if(Auth::check() && !Auth::user()->isAuthor()): ?>	
	            	var checkboxes = $('.allow');
	            	var quizid_ary = '';
					for(var i = 0; i < checkboxes.length; i++){
						
						if($(checkboxes[i]).parent().hasClass("checked")){

							var qid = $(checkboxes[i]).attr("qid");
							quizid_ary += qid+',';
						}
					}
					//監修者 認定クイズを全部自作
					var data = {_token: $('meta[name="csrf-token"]').attr('content') , quizid_ary: quizid_ary};
		            $.ajax({
		                type: "post",
		                url: "<?php echo e(url('/quiz/isOverseerQuizAjax')); ?>",
		                data: data,
		                
		                beforeSend: function (xhr) {
		                    var token = $('meta[name="csrf_token"]').attr('content');
		                    if (token) {
		                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
		                    }
		                },          
		                success: function (response){
		                    if(response.status == 'success'){
								$("#btn_submit").removeAttr('disabled');
							}else{
								$("#btn_submit").attr('disabled',true);
							}
				        }
		            })
				<?php else: ?>
					$("#btn_submit").removeAttr('disabled');
				<?php endif; ?>
			}else
            	$("#btn_submit").attr('disabled',true);
	           
            jQuery.uniform.update($(".accept_quiz" + $(obj).attr("qid")));
		}
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>