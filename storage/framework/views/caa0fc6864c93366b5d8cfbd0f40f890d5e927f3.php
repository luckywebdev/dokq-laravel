<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
</head>
<body>
<?php
 $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/mailer.css')); ?>">
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
					読Q顔認証再登録のご案内
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody>
						<tr>
							<td colspan="2">
								<?php if($user->role==config('consts')['USER']['ROLE']['GROUP']): ?>
									<?php echo e($user->group_name); ?><br>
									<?php echo e($user->rep_post); ?>　　<?php echo e($user->rep_name); ?>　様
								<?php elseif($user->role==config('consts')['USER']['ROLE']['AUTHOR']): ?>
								 <?php echo e($user->username); ?>　様
								<?php else: ?>
								 <?php echo e($user->username); ?>　様
								<?php endif; ?>
								<br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						<tr>
							<td colspan="2">
								顔認証の再登録のご案内をさせていただきます。<br>
                                下記URLより、再登録していただきますようお願いいたします。<br>
								<?php echo e($actual_link."/auth/register_face/0?refresh_token=".$user->refresh_token); ?>

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
                                <?php echo e($actual_link); ?>

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