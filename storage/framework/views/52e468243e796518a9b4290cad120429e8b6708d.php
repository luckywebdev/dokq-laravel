<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
<style>
.aptitude_table td{
	font-size: 150%;
}
.aptitude_table tr:hover{
	background-color: #FFF !important;
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
	            	> 試験監督適性検査
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Q試験監督適性検査</h3>

			<div>
				<div class="row" style="margin-top:50px;">
					<div class="offset-md-1 col-md-10" id="test_content">
					    <input type="hidden" id="user_id" name="user_id" value="<?php echo e(Auth::id()); ?>">
						<table class="table table-no-border table-hover aptitude_table" style="color:black;">
							<tr>
								<td class="col-md-9">1. あなたは高い倫理観をお持ちですか？</td>
								<td class="col-md-1"><input id="1" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="2" name="2" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">2. 読Qは資格試験などの重要な試験ではないので、受検者に答えをおしえてあげてよいと思いますか？</td>
								<td class="col-md-1"><input id="3" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="4" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">3. 読書は大事だと思いますか？</td>
								<td class="col-md-1"><input id="5" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="6" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">4. 本を読み終わっていなくても、読Q受検してよいですか？</td>
								<td class="col-md-1"><input id="7" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="8" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">5. 受検者は、受検中に問題を声に出して読み上げてもかまわないですか？</td>
								<td class="col-md-1"><input id="9" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="10" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">6. 家族や友達が読Q受検するなら、合格できるように問題をおしえてあげたいですか？</td>
								<td class="col-md-1"><input id="11" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="12" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">7. 試験監督は、受検者が不正をしないよう見張ることが仕事だと思いますか？</td>
								<td class="col-md-1"><input id="13" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="14" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
							<tr>
								<td class="col-md-9">8. 読書は娯楽なので、読Qの試験監督はそれほど厳しくある必要はないと思いますか？</td>
								<td class="col-md-1"><input id="15" type='checkbox' class='checkboxes'>はい</td>
								<td class="col-md-1"><input id="16" type='checkbox' class='checkboxes'>いいえ</td>
							</tr>
						</table>
					</div>
				</div>
				<input type="hidden" id="aptitude" name="aptitude" value="<?php echo e($aptitude); ?>">
				<div class="row result_btn">
					<div class="col-md-6 text-md-right">
						<button type="button" class="btn btn-primary" onclick="is_suitable()">結果を表示</button>
					</div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
                    </div>
				</div>

				<div id="aptitudeModal" class="modal fade draggable draggable-modal" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title"><strong>通知！</strong></h4>
							</div>
							<div class="modal-body">
							<span id="alert_text1">あなたは既に適性検査に合格しました。</span>
							</div>
							<div class="modal-footer">
							<button type="button" data-dismiss="modal" class="btn btn-info" >閉じる</button>
							</div>
						</div>
					</div>
				</div>
				<div id="checkModal" class="modal fade draggable draggable-modal" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title"><strong>通知！</strong></h4>
							</div>
							<div class="modal-body">
							<span id="alert_text1">項目を選択してください。</span>
							</div>
							<div class="modal-footer">
							<button type="button" data-dismiss="modal" class="btn btn-info" >閉じる</button>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<script type="text/javascript">
		$(".checkboxes").click(function(){
			var index =  $(this).attr('id');
			i = index % 2;
			if(i == 1 && $(this).attr("checked") == "checked"){
				$(".checkboxes").each(function(j) { //j: start from 0
					if(j == index){
						if($(this).attr("checked") == "checked"){
							$(this).removeAttr('checked');
							$(this).parent().removeClass('checked');
						}
					}
				});
			}else if(i == 0 && $(this).attr("checked") == "checked"){
				$(".checkboxes").each(function(j) { //j: start from 0
					if(j == index-2){
						if($(this).attr("checked") == "checked"){
							$(this).removeAttr('checked');
							$(this).parent().removeClass('checked');
						}
					}
				});
			}
		});
		function is_suitable() {
			var aptitude = $("#aptitude").val();
			var ids = "";
			$('.checkboxes').each(function(index) {
				
				if($(this).attr("checked")) {
					if(ids.length > 0) {
						ids += ","
					}
					ids += $(this).attr('id');;
				}
			});
			var ids_length = ids.split(",").length;
			if(ids == "" || ids_length < 8){
				$("#checkModal").modal('show');
				return;
			}
			if(aptitude != 1){
				var info = {
					_token: $('meta[name="csrf-token"]').attr('content'),
					user_id: $("#user_id").val(),
					value: ids
				}
				var post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/api/user/aptitude";
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
					success: function (response) {
						console.log(response);
						$('.result_btn').empty();
						//$('.result_btn').addClass("hidden");
						if(response.result) {
							$('#test_content').append(
								'<div class="row">'
								+	'<div class="col-md-12">'
								+		'<h4 style="color:#f00;">適性検査結果</h4>'
								+		'<div class="row">'
								+			'<div class="col-md-10">'
								+				'<p style="color:#f00;">あなたは読Q試験監督としての適性があると診断されました。すぐに試験監督をすることができます。</p>'
								+			'</div>'
								+		'</div>'
								+		'<div class="row">' 
								+			'<div class="col-md-6">'
								+			'</div>'
								+			'<div class="col-md-3">'
								+				'<a href="' + "<?php echo e(url('/mypage/oversee_test')); ?>" + '" class="btn btn-info pull-right">試験監督を始める</a>'
								+			'</div>'
								+			'<div class="col-md-3">'
								+				'<a href="' + "<?php echo e(url('/mypage/top')); ?>" + '" class="btn btn-info pull-right">マイ書斎へ戻る</a>'
								+			'</div>'
								+		'</div>'
								+	'</div>'
								+'</div>'
							);
						} else {
							$('#test_content').append(
								'<div class="row">'
								+	'<div class="col-md-12">'
								+		'<h4 style="color:#f00;">適性検査結果</h4>'
								+		'<div class="row">'
								+			'<div class="col-md-10">'
								+				'<p style="color:#f00;">残念ながら、あなたは試験監督としての適性があるとは言えません。あなたが読Qの試験監督をすることを承認できません。</p>'
								+			'</div>'
								+		'</div>'
								+		'<div class="row">' 
								+			'<div class="col-md-6">'
								+			'</div>'
								+			'<div class="col-md-3">'
								+				'<a href="#" class="btn btn-info pull-right" onclick="location.reload()">再試行</a>'
								+			'</div>'
								+			'<div class="col-md-3">'
								+				'<a href="' + "<?php echo e(url('/mypage/top')); ?>" + '" class="btn btn-info pull-right">マイ書斎へ戻る</a>'
								+			'</div>'
								+		'</div>'
								+	'</div>'
								+'</div>'
							);
						}
					}
				});
			}
			else{
				$("#aptitudeModal").modal('show');
				return;
			}
		}
		var test_time = 0;
		var timer = setInterval(function() {
            test_time = test_time +1;
            if(test_time >= 300) {
                
                clearInterval(timer);
                //$('#test_content').empty();
                $('#test_content').append(
                    '<div class="row" style="margin-top:50px;">'
                    +	'<div class="offset-md-1 col-md-10">'
                    +		'<h4 style="color:#f00;">適性検査結果</h4>'
                    +		'<div class="row">'
                    +			'<div class="col-md-10">'
                    +				'<p style="color:#f00;">残念ながら、あなたは試験監督としての適性があるとは言えません。あなたが読Qの試験監督をすることを承認できません。</p>'
                    +			'</div>'
                    +		'</div>'
                    +		'<div class="row">' 
                    +			'<div class="col-md-9">'
                    +			'</div>'
                    +			'<div class="col-md-3">'
                    +				'<a href="' + "<?php echo e(url('/mypage/top')); ?>" + '" class="btn btn-info pull-right">マイ書斎へ戻る</a>'
                    +			'</div>'
                    +		'</div>'
                    +	'</div>'
                    +'</div>'
                );
    		}
        }, 1000);
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>