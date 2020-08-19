
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
	                <a href="#"> > 読Q本の検索</a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">

			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4"><h3 class="page-title">読Q本の検索<br><small>読Qに登録されている本を検索します。</small></h3></div>
				<div class="col-md-4" style="display:flex; justify-content:flex-end">
					<div class="top-news">
						<?php echo $advertise->search_page_top; ?>
					</div>
				</div>
				<div class="col-md-1"></div>
			</div>							
			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form" method="get">
						<?php echo e(csrf_field()); ?>


						<div class="form-group text-md-center row">
							<div class="offset-md-2 col-md-4 text-md-center col-sm-6 col-xs-6">
								<a class="btn btn-warning margin-bottom-10" href="<?php echo e(url('/book/search/help')); ?>">検索のしかた</a>
							</div>
							<div class="offset-md-2 col-md-4 text-md-left col-sm-6 col-xs-6">
								<a class="btn btn-warning" href="<?php echo e(url('/book/result/help')); ?>">検索結果の見方</a>
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-12">
								<h4 class="form-section" style="padding-left:15px !important">タイトル、著者、ISBNからさがす場合</h4>
								<div class="form-group row">
									<label class="control-label col-md-2 text-md-right">タイトル</label>
									<div class="col-md-5 margin-bottom-10" >
										<input type="text" id="title" name="title" class="form-control" placeholder="漢字、ひらがな、カタカナ　OK">
										<span style="color:red">スペースを開けずに入力してください。</span>
									</div>
									<div class="col-md-3">
										<select class="bs-select form-control" name="title_mode"> 
											<option value="1">を含む</option>
											<option value="0">から始まる</option>
											<option value="2">と一致する</option>
										</select>
									</div>
								</div>	
							
								<div class="form-group row ">
									<div class="col-md-12">
										<label class="control-label col-md-2 text-md-right">著者</label>
										<div class="col-md-2">
											<label class="control-label col-md-1 text-md-right">姓:</label>
											<div class="col-md-10" style="margin-left:10px"><input type="text" id="firstname_nick" name="firstname_nick" class="form-control" placeholder="芥川"></div>
										</div>
										<div class="col-md-2 margin-bottom-10">
											<label class="control-label col-md-1 text-md-right">名:&nbsp;&nbsp;</label>
											<div class="col-md-10" style="margin-left:10px"><input type="text" id="lastname_nick" name="lastname_nick" class="form-control" placeholder="龍之介"></div>
										</div>
										<div class="offset-md-1 col-md-3">
											<select class="bs-select form-control" name="writer_mode"> 
												<option value="1">を含む</option>
												<option value="0">から始まる</option>
												<option value="2">と一致する</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="control-label col-md-2 text-md-right">ISBN</label>
									<div class="col-md-5">
										<input type="text" id="isbn" name="isbn" class="form-control" placeholder="493586523">
										<span style="color:red">ISBNの数字のうち、４から始まる９桁の半角数字</span>
									</div>
									<div class="col-md-3">
										<label class="control-label">と一致する</label>
									</div>
								</div>
							</div>
							
						</div>
						<h4 class="form-section" style="padding-left:15px !important">帯文のキーワードからさがす場合</h4>
						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">キーワード</label>
							<div class="col-md-5 margin-bottom-10">
								<input type="text" id="keyword" name="keyword" class="form-control" placeholder="入力例：　せつない">
								<span style="color:red">スペースを開けずに入力してください。</span>
							</div>
							<div class="col-md-3">
								<select class="bs-select form-control" name="keyword_mode">
									<option value="1">を含む</option>
									<option value="0">から始まる</option>
									<option value="2">と一致する</option>
								</select>
							</div>
						</div>

						<h4 class="form-section" style="padding-left:15px !important">良さそうな本を選ぶ場合</h4>
						<div class="form-group row">
							<div class="offset-md-2 col-md-5">
								<select class="select2me form-control" id="sort" name="sort" placeholder="年代別おすすめ本からさがす">
									<option value=""></option>
									<option value="0">年代別おすすめ本からさがす</option>
									<option value="1">新しく認定された読Q本からさがす</option>
									<option value="2">ジャンルからさがす</option>
									<option value="3" >ランキングからさがす</option> <!-- <?php if(!$logined): ?> disabled <?php endif; ?> -->
								</select>
							</div>
						</div>

						<div class="form-body row">
							<div class="offset-md-3 col-md-3 col-xs-6 text-md-right">
								<a class="btn btn-primary" style="color: white; margin-bottom:8px;">次　へ</a>
							</div>
							<div class="col-md-3 col-xs-6 text-md-left">								
								<a id="btnCancel" class="btn btn-danger" style="color: white; margin-bottom:8px;">キャンセル</a>
							</div>
							<div class="col-md-3 text-md-right">
								<a class="btn btn-info pull-right" href="<?php echo e(url('/')); ?>">トップに戻る</a>
							</div>
						</div>
					
					</form>
				</div>
			</div>
			<div class="row">
				
			</div>
		</div>
	</div>
	<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<span id="alert_text">検索値を入力してください!</span>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
				</div>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
		});

		$(".btn-primary").click(function(){
			var title = $("#title").val();
			var firstname_nick = $("#firstname_nick").val();
			var lastname_nick = $("#lastname_nick").val();
			var isbn = $("#isbn").val();
			var keyword = $("#keyword").val();
			var sort = $("#sort").val();
			if(title == "" && firstname_nick == "" && lastname_nick == "" && isbn == "" && keyword == "" && sort == ""){
				$("#alertModal").modal("show");
			}
			else{
				$(".form").attr("method", 'get');
				$(".form").attr('action', '/book/search_result');
				$(".form").submit();
			}
		});

    	$("#btnCancel").click(function(){
    		$("input").val("");
    		$("input").css("background-color", "white");
    		//$("select").val(0);
	    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>