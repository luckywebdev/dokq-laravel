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
					読Qへの会員登録が完了しました
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody class="text-md-center">
						<tr>
							<td colspan="6">
							    <?php if($user->role==config('consts')['USER']['ROLE']['GROUP']): ?>
									<?php echo e($user->group_name); ?><br>
									<?php echo e($user->rep_post); ?>　　<?php echo e($user->rep_name); ?>　様
								<?php elseif($user->role==config('consts')['USER']['ROLE']['AUTHOR']): ?>
								 <?php echo e($user->firstname_nick); ?>　<?php echo e($user->lastname_nick); ?>　様
								<?php else: ?>
								 <?php echo e($user->firstname); ?>　<?php echo e($user->lastname); ?>　様
								<?php endif; ?><br><br>
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
					    <?php if($user->role==0): ?>
						<tr>
							<td colspan="6">
								このたびは、読Qへ会員登録をしていただき、ありがとうございました。登録が完了しましたので、正式な読Qネームとパスワードですぐにログインしていただけます。ログイン後、速やかに児童生徒様及び教員の方の登録をしていただきますようお願いいたします。<br>
							</td>
						</tr>
						<tr style="font-weight: 600;">
							<td style=" width: 50%;">貴団体の読Qネーム：</td>
							<td style="width: 50%;"><?php echo e($user->username); ?></td>
							<td></td>
						</tr>
						<tr style="font-weight: 600;">
							<td >パスワード：</td>
							<td ><?php echo e($user->passwordShow()); ?></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="6">
								なお、請求書をPDFファイル形式で作成し、メールで送信させていただきますので、よろしくお願い申し上げます。
							</td>							
						</tr>
						<?php else: ?>
						<tr>
							<td colspan="6">
							読Qへの会員登録が完了しました。下記に、読Qネームとパスワードの一部を表示しています。すぐにログインして読Qを始めていただけます。
							</td>
						</tr>
						<tr style="font-weight: 600;">
							<td style="width: 40%">読Qネーム：</td>
							<td style="width: 60%"><?php echo e($user->username); ?></td>
							<td></td>
						</tr>
						<tr style="font-weight: 600;">
							<td>パスワード：</td>
							<td><?php echo e($user->passwordShow()); ?></td>
							<td></td>
						</tr>
						<?php endif; ?>
						<tr>
						    <td colspan="6"><br>
                                ※このEメールアドレスは配信専用です。このメッセージに返信しないようお願いいたします。<br>
                                お問い合わせがある場合は、トップページ最下部の、お問合せフォームからお願いします。
						    </td>
						</tr>
						<tr>
							<td colspan="6">
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