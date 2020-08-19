<!DOCTYPE html>
<html>
<head>
	<title>読Qに登録申請</title>
</head>
<body>
<?php
 $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/mailer.css')); ?>">
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
								<?php if($user->role==config('consts')['USER']['ROLE']['GROUP']): ?>
									<?php echo e($user->group_name); ?>

									<br>
									<?php echo e($user->rep_post); ?>　　<?php echo e($user->rep_name); ?>　様
								<?php elseif($user->role==config('consts')['USER']['ROLE']['AUTHOR']): ?>
								 <?php echo e($user->firstname_nick); ?>　<?php echo e($user->lastname_nick); ?>　様
								<?php else: ?>
								 <?php echo e($user->firstname); ?>　<?php echo e($user->lastname); ?>　様
								<?php endif; ?>
								<br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						<?php if($user->role == config('consts')['USER']['ROLE']['GROUP']): ?>
						<tr>
							<td colspan="6">
								以下の仮IDと仮パスワードでログインし、正式登録をお願い申し上げます。
								<br>
								下記URLをクリックして、上記IDとパスワードでログインし、団体の詳細を入力していただきます様お願い申し上げます。
								<br>
								<br>
								<?php if($user->role==config('consts')['USER']['ROLE']['GROUP']): ?>
								<?php echo e($actual_link."/auth/register/".$user->role."/2"); ?>

								<?php elseif($user->role==config('consts')['USER']['ROLE']['OVERSEER']
								        || $user->role==config('consts')['USER']['ROLE']['TEACHER']
								        || $user->role==config('consts')['USER']['ROLE']['LIBRARIAN']): ?>
								<?php echo e($actual_link."/auth/register/".config('consts')['USER']['ROLE']['OVERSEER']."/2?refresh_token=".$user->refresh_token); ?>

								<?php else: ?>
								<?php echo e($actual_link."/auth/register/".$user->role."/2?refresh_token=".$user->refresh_token); ?>

								<?php endif; ?>
							</td>
						</tr>
						<tr style="font-weight: 600;">
							<td style="width: 40%;">仮ID:</td>
							<td style="width: 60%;"><?php echo e($user->t_username); ?></td>
							<td></td>
						</tr>
						<tr style="font-weight: 600;">
							<td>仮パスワード:</td>
							<td><?php echo e($user->t_password); ?></td>
							<td></td>
						</tr>
						<?php else: ?>
						<tr>
							<td colspan="6">
								下記URLより、本登録をしていただきますようお願い申し上げます。<br>
								<?php echo e($actual_link."/auth/register/".$user->role."/2?refresh_token=".$user->refresh_token); ?>

							</td>
						</tr>
						<?php endif; ?>
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