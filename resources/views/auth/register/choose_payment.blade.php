@extends('auth.layout')


@section('contents')

<div class="container register">
	<div class="form">
		<div class="form-wizard">
			<div class="form-body">
				<ul class="nav nav-pills nav-fill steps">
					<li class="nav-item active">
						<span class="step">
							<span class="number"> 1 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ１
							</span>
					</li>
					<li class="nav-item active">
						<span class="step">
						<span class="number"> 2 </span>
						<span class="desc">
							<i class="fa fa-check"></i> ステップ２ 
						</span>
						</span>
					</li>
					<li class="nav-item">
						<span class="step">
						<span class="number"> 3 </span>
						<span class="desc">
							<i class="fa fa-check"></i>	ステップ３
						</span>
						</span>
					</li>						
				</ul>
				<div id="bar" class="progress " role="progressbar">
					<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 66%;">
					</div>
				</div>				
			</div>
			
			<center><h1>読Q会費お払込みの手続き</h1></center>
			<br>
			<br>
			<div>
				<h4>月1回払いまたは年1回払いがお選びいただけます。（途中で変更はできません） 初回決済日は2週間後です。</h4><br>
				<h4>それまでは試用期間として無料でご利用いただけます。</h4><br>
				<h4>プルダウンメニューから、低所得家庭のお子さんの会費を肩代わりするあしなが援助金を選択できます。</h4><br>
				<h4>あしなが援助金は、相手のあることですので途中で変更はできません。ご理解ください。</h4><br>
				<h4>プルダウンメニューから選択して「購読」をタップし、Paypalにてお手続きをお願い申し上げます。</h4><br>
				<br>
			</div>	
			<div class="row" style="margin-top:50px;">

				<div class="offset-md-2 col-md-4" style="font-size:16px; text-align: center">
					<form id="monthly_pay_form" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="TLLX3B6S57EUE">
						<table class="mb-3" width="100%">
						<tr><td><input type="hidden" name="on0" value="ReadingQ(reg)">月1回払い 読Q会費</td></tr><tr><td><select name="os0" id="monthly_pay_list">
							<option value="Monthly">月1回払い : ¥100 JPY - 毎月</option>
							<option value="Monthly1">月1回払い(1名援助) : ¥200 JPY - 毎月</option>
							<option value="Monthly2">月1回払い(2名援助) : ¥300 JPY - 毎月</option>
							<option value="Monthly4">月1回払い(4名援助) : ¥500 JPY - 毎月</option>
							<option value="Monthly10">月1回払い(10名援助) : ¥1,100 JPY - 毎月</option>
							<option value="Monthly20">月1回払い(20名援助) : ¥2,100 JPY - 毎月</option>
							<option value="Monthly30">月1回払い(30名援助) : ¥3,100 JPY - 毎月</option>
						</select> </td></tr>
						</table>
						<input type="hidden" name="currency_code" value="JPY">
						<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_subscribeCC_LG.gif" border="0" id="monthly_pay_btn" alt="PayPal - オンラインでより安全・簡単にお支払い">
						<img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
					</form>

				</div>
				<div class="col-md-4" style="font-size:16px; text-align: center">
					<form id="yearly_pay_form" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="AMPJ6KRXXUEY4">
						<table class="mb-3" width="100%">
						<tr><td><input type="hidden" name="on0" value="ReadingQ(reg)">年1回払い読Q会費 </td></tr><tr><td><select name="os0" id="yearly_pay_list">
							<option value="Yearly">年1回払い : ¥1,000 JPY - 毎年</option>
							<option value="Yearly1">年1回払い(1名援助) : ¥2,000 JPY - 毎年</option>
							<option value="Yearly2">年1回払い(2名援助) : ¥3,000 JPY - 毎年</option>
							<option value="Yearly4">年1回払い(4名援助) : ¥5,000 JPY - 毎年</option>
							<option value="Yearly10">年1回払い(10名援助) : ¥11,000 JPY - 毎年</option>
							<option value="Yearly20">年1回払い(20名援助) : ¥21,000 JPY - 毎年</option>
							<option value="Yearly30">年1回払い(30名援助) : ¥31,000 JPY - 毎年</option>
						</select> </td></tr>
						</table>
						<input type="hidden" name="currency_code" value="JPY">
						<input type="image" src="https://www.paypalobjects.com/ja_JP/JP/i/btn/btn_subscribeCC_LG.gif" border="0" id="yearly_pay_btn" alt="PayPal - オンラインでより安全・簡単にお支払い">
						<img alt="" border="0" src="https://www.paypalobjects.com/ja_JP/i/scr/pixel.gif" width="1" height="1">
					</form>

				</div>

			</div>

			<div class="col-md-12 text-md-right col-sm-12 mb-5">
				<a href="javascript:history.go(-1)" class="btn btn-danger">キャンセル</a>
					
			</div>
			<div class="modal fade" id="myfailedModal" role="dialog">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title"><strong>エラー</strong></h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
						<p>支払いが失敗しました。再試行してください。</p>
						</div>
						<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
						</div>
					</div>
				</div>
			</div>   
	</div>
</div>

@stop
@section('scripts')
<script type="text/javascript">

	$("#monthly_pay_btn").click(function(){
		var pay_content = $("#monthly_pay_list").val();
		// var info = {pay_content: pay_content};
		var info = {
			_token: $('meta[name="csrf-token"]').attr('content'),
			pay_content: pay_content
		}

		$.ajax({
			type: "post",
			url: "/auth/register/prepay",
			data: info,
			async: false,
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },
			success: function (response){
				$("#monthly_pay_form").attr('action', 'https://www.paypal.com/cgi-bin/webscr');
				$("#monthly_pay_form").submit();
			},
			error: function (err) {
				$('#myfailedModal').modal('show');
			}
		});
	});
	$("#yearly_pay_btn").click(function(){
		var pay_content = $("#yearly_pay_list").val();
		var info = {
			_token: $('meta[name="csrf-token"]').attr('content'),
			pay_content: pay_content
		}
		$.ajax({
			type: "post",
			url: "/auth/register/prepay",
			data: info,
			async: false,
			beforeSend: function (xhr) {
	            var token = $('meta[name="csrf_token"]').attr('content');
	            if (token) {
	                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
	            }
	        },
			success: function (response){
				$("#yearly_pay_form").attr('action', 'https://www.paypal.com/cgi-bin/webscr');
				$("#yearly_pay_form").submit();
			},
			error: function (err) {
				$('#myfailedModal').modal('show');
			}
		});
	});
</script>
@stop

