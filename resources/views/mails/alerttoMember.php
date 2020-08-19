<!DOCTYPE html>
<html>
<head>
	<title>現在、読Q準会員です。</title>
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
					
				</h1>
			</div>
			<div style="padding: 20px">
				<table>
					<tbody class="text-md-center">
						<tr>
							<td colspan="2">
								いつも読Qをご利用いただきありがとうございます。
							</td>
						</tr>
						<tr>
							<td colspan="2">
								読Qを採用している団体に所属するか、またはマイ書斎から会費支払い手続きをすると、正会員となり受検ができるようになります。
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
							    <br><br>
								一般社団法人読書認定協会<br>
								藤沢市辻堂元町5-7-3<br>
								代表理事　　神部　ゆかり<br>
                                {{$actual_link}}
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