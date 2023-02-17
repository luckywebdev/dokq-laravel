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
					読Q退会用URLの送付
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
								 {{$user->username}}　様
								@else
								 {{$user->username}}　様
								@endif
								<br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						<tr>
							<td colspan="2">
								このたび、読Qを退会される旨のお申し出を承りました。つきましては、下記URLをクリックしていただくことで、会費の支払い停止手続を始めさせていただきます。このメールに心当たりが無い場合、読Q宛に、お問合せ欄からご連絡ください。なお、読Qでは、あなたのアカウントを退会後も3カ月間保持します。退会していた間の会費を納めていただければ、3か月以内なら復活することが可能です。ポイントや合格履歴などを取り戻すことはできません。<br>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								{{$actual_link."/auth/user_escape/?refresh_token=".$user->refresh_token}}
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