<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
</head>
<body>
<?php
 $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
	<link rel="stylesheet" type="text/css" href="{{asset('css/mailer.css')}}">
	<div style="max-width: 600px;">
		<div style="background: rgb(246, 246, 246);
		color: rgb(82, 82, 82);
		font-family: 'Helvetica Neue, Helvetica, Arial, sans-serif, serif, EmojiFont';
		font-size: 16px; height: 100%;
		line-height: 1.6em;
		margin: 0px;
		padding: 0px;
		width: 100% !important;">
			<div style="border-collapse:collapse; color:#9bb0cf; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; font-size:14px; font-weight:bold; line-height:1; margin:0; padding:20px; text-align:center; vertical-align:top;
		background: #3863A0;
		text-align: center;">
				<h1 style="text-align: center;">
					読Qを退会しました
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody class="text-md-center">
						<tr>
							<td colspan="2">
								@if($user->role==config('consts')['USER']['ROLE']['GROUP'])
									{{$user->group_name}}<br>
									{{$user->rep_post}}　　{{$user->rep_name}}　様
								@elseif($user->role==config('consts')['USER']['ROLE']['AUTHOR'])
								 {{$user->firstname}}　様
								@else
								 {{$user->firstname}}　様
								@endif
								<br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						<tr>
							<td colspan="2">
							このたび、会費お支払い停止の手続きが終了し、読Qの退会が完了しました。これまで読Qをご利用いただき、ありがとうございました。このメールに心当たりが無い場合、読Q宛に、お問合せ欄からご連絡ください。なお、読Qでは、あなたのアカウントを退会後も3カ月間保持します。３か月分の会費を納めていただくことで、復活が可能です。お問合せ欄からご連絡ください。<br>
							</td>
						</tr>
						 <tr>
						    <td colspan="2"><br>
                                ※このメールは配信専用です。このメールに返信しないようお願いいたします。<br>
                                お問い合わせがある場合は、トップページ最下部の、お問合せフォームからお願いします。
						    </td>
						</tr>
						<tr>
							<td colspan="2">
							    <br><br>
								一般社団法人読書認定協会<br><br>
                                {{$actual_link}}
                                <br>
							</td>
						</tr> 
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>