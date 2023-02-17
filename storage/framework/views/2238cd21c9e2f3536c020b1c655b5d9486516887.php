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
					読Qへお問合せをいただきありがとうございます。
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody class="text-md-center">
						<tr>
							<td colspan="2">
								<?php echo e($user->name); ?>　様
								<br><br>
								読Qへお問合せをいただき、まことにありがとうございます。
							</td>
						</tr>
						<tr>
							<td colspan="2">
                            お問合せいただいた内容<br>
                            <?php echo e($user->content); ?>

							</td>
						</tr>
						 <tr>
						    <td colspan="2"><br>
                            返信内容<br>
							<?php echo e($user->post); ?>

							<br><br>
							以上、今後とも、読Qをよろしくお願い申し上げます。
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