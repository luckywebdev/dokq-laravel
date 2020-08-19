<!DOCTYPE html>
<html>
<head>
	<title>読Qに登録申請</title>
</head>
<body>
<?php
 $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
	<link rel="stylesheet" type="text/css" href="{{asset('css/mailer.css')}}">
	<div style="max-width: 600px;">
		<div style="background: rgb(246, 246, 246);
		color: rgb(82, 82, 82);
		font-family: 'Helvetica Neue, Helvetica, Arial, sans-serif, serif, EmojiFont';;
		font-size: 16px; height: 100%; 
		line-height: 1.6em;
		margin: 0px;
		padding: 0px;
		width: 100% !important;">
			<div style="border-collapse:collapse; color:#9bb0cf; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; font-size:14px; font-weight:bold; line-height:1; margin:0; padding:20px; text-align:center; vertical-align:top;
		background: #3863A0;
		text-align: center;">
				<h1 style="text-align: center;">
					読Qに登録申請していただき、ありがとうございます。
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody class="text-md-center">
						<tr>
							<td colspan="6">
								@if($user->role==config('consts')['USER']['ROLE']['GROUP'])
									{{$user->group_name}}
									<br>
									{{$user->rep_post}}　　{{$user->rep_name}}　様
								@elseif($user->role==config('consts')['USER']['ROLE']['AUTHOR'])
								 {{$user->firstname_nick}}　{{$user->lastname_nick}}　様
								@else
								 {{$user->firstname}}　{{$user->lastname}}　様
								@endif
								<br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						@if($user->role == config('consts')['USER']['ROLE']['GROUP'])
						<tr>
							<td colspan="6">
								以下の仮IDと仮パスワードでログインし、正式登録をお願い申し上げます。
								<br>
								下記URLをクリックして、上記IDとパスワードでログインし、団体の詳細を入力していただきます様お願い申し上げます。
								<br>
								<br>
								@if($user->role==config('consts')['USER']['ROLE']['GROUP'])
								{{$actual_link."/auth/register/".$user->role."/2"}}
								@elseif($user->role==config('consts')['USER']['ROLE']['OVERSEER']
								        || $user->role==config('consts')['USER']['ROLE']['TEACHER']
								        || $user->role==config('consts')['USER']['ROLE']['LIBRARIAN'])
								{{$actual_link."/auth/register/".config('consts')['USER']['ROLE']['OVERSEER']."/2?refresh_token=".$user->refresh_token}}
								@else
								{{$actual_link."/auth/register/".$user->role."/2?refresh_token=".$user->refresh_token}}
								@endif
							</td>
						</tr>
						<tr style="font-weight: 600;">
							<td style="width: 40%;">仮ID:</td>
							<td style="width: 60%;">{{$user->t_username}}</td>
							<td></td>
						</tr>
						<tr style="font-weight: 600;">
							<td>仮パスワード:</td>
							<td>{{$user->t_password}}</td>
							<td></td>
						</tr>
						@else
						<tr>
							<td colspan="6">
								下記URLより、本登録をしていただきますようお願い申し上げます。<br>
								{{$actual_link."/auth/register/".$user->role."/2?refresh_token=".$user->refresh_token}}
							</td>
						</tr>
						@endif
						<tr>
						    <td colspan="6"><br>
                                ※このメールは配信専用です。このメールに返信しないようお願いいたします。<br>
                                お問い合わせがある場合は、トップページ最下部の、お問合せフォームからお願いします。
						    </td>
						</tr>
						<tr>
							<td colspan="6">
							    <br><br>
								一般社団法人読書認定協会<br>
								藤沢市辻堂元町5-7-3<br>
								代表理事　　神部　ゆかり<br>
                                <?php
                                 echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                                ?>
                                <br>
                                <?php
                                	echo config('mail')['from']['address'];
                                ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>