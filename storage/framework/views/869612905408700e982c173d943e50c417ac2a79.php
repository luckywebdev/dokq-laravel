
<?php $__env->startSection('styles'); ?>
    <style type="text/css">
    	.caution{
    		font-size: 16px;
    	}
    	.caution li{
    		margin-bottom: 10px;
    	}
		li{
			list-style: none;
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
					> <a href="<?php echo e(url('book/search')); ?>">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> 受検の注意
				</li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">読Ｑ受検の注意</h3>
							
			<div class="row">
				<div class="offset-md-1 col-md-10">
					<form class="form form-horizontal" action="<?php echo e(url('/book/test/agree')); ?>" method="post">
						<?php echo e(csrf_field()); ?>

						<?php if(isset($book)&&Auth::check()): ?>
							<input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
							<input type="hidden" name="mode" value="0">
						<?php endif; ?>
						<div class="form-body">
							<div class="form-group row">
								<div class="col-md-12">
									<div class="caution">
										<li>
											<strong>試験監督について</strong>
										</li>
										<li>
											・  読Ｑ受検には、<strong>試験監督</strong>が必要です。受検開始から終了まで、試験監督は不正がないよう受検者と受検者の受検画面を見守ります。
										</li>
										<li>
											・  試験監督は、適性検査に合格した２０歳以上の読Ｑ会員（同居家族を除く）が、務めることができます。（適性検査は合格するまで何度でも受けることが可能です）
										</li>
										<li>
											・  試験監督は、パスワード入力と顔認証を、受検者の端末で行います。試験監督履歴はマイ書斎内に記録されます。
										</li>
										<li>
											・  受検者が合格すると、試験監督は再び受検者の端末で顔認証を行います。
										</li>
										<li>
											・  受検者に不正があった場合、試験監督は受検画面の「中止する」をタップします（不合格となります）。または合格画面が出た後10分の間に試験監督による顔認証をしないと、不合格になります。
										</li>
										<li>
											<strong>禁止事項</strong>
										</li>
										<li>
											問題を声に出して読む、カンニング、人と会話する、スクリーンショット取得、メモを取る、試験監督から受検画面が見えないようにする、その他不正が疑われる行為。
										</li>
										<li>
											受検者がこのような行為を行った場合、<strong>試験監督が受検を中止し、不合格とします。</strong>
										</li>
										<li>
											何か問題があった場合は、問合せからご連絡ください。
										</li>
										<li>
											<strong>受検の流れ</strong>
										</li>
										<li>
											①  受検者の本人確認：　受検者は、下記「同意して次へ」をタップし、パスワード入力と顔認証による本人確認をします。（すでに顔認証登録が済んでいる方はパスワード入力がスキップされ、顔認証画面へ）
										</li>
										<li>
											②  学校内受検の場合以外は、「試験監督の顔認証」をクリックします。（学校内受検の場合はそのまま待機します）
										</li>
										<li>
											③  試験監督の本人確認：　試験監督が、受検者の端末で、パスワード入力と顔認証をおこないます。（学校内受検の場合は顔認証ではなく、先生があなたの受検画面に教師パスワードを自動入力します）
										</li>
										<li>
											④  受検スタート：　本のタイトルと回答方法を確認し、「受検スタート」をタップすると、第１問が始まります。
										</li>
										<li>
											⑤  ①〇、または②× をクリックすると「次へ」が出てきますので、クリックすると、次の問題になります。
										</li>
										<li>
											⑥  １問の回答時間の制限：　問題文1問の制限時間は<strong>３０秒</strong>です。超過すると不正解となり、自動的に次問へ移動します。
										</li>
										<li>
											⑦  8割以上の正解、または2割以上の不正解が判明した<strong>時点で受検終了</strong>となり、合否が表示されます。
										</li>
										<li>
											<strong>合格の場合</strong>
										</li>
										<li>
											①  「顔認証」をタップし、<strong>試験監督に</strong>顔認証（学校内受検の場合は教師パスワード入力）をしてもらうと、合格が確定します。学校内受検の場合は、挙手などで先生に合格したことを知らせて、<strong>教師パスワードを入力</strong>してもらいましょう。
										</li>
										<li>
											②  10分後までに試験監督による認証が完了しないと、不合格になります。すみやかに認証してもらいましょう。
										</li>
										<li>
											③  合格後、続けて別の本の受検が可能です。画面の指示に従ってください。
										</li>
										<li>
											<strong>不合格の場合</strong>
										</li>
										<li>
											①  続けて、同じ本を再受検できます。（1回目とは違う問題が出題されます。）その場合、本人や監督の認証は不要です。
										</li>
										<li>
											②  2度目も不合格だった場合は、3日間（不合格時点から72時間）その本の受検はできません。
										</li>
										<li>
											③  不合格の場合、監督による認証はありません。別の本を受検できます。
										</li>
										<li>
											<strong>ポイントについて</strong>
										</li>
										<li>
											・　合格ポイント・・・合格すると、読Ｑ本ポイントが、あなたの読Ｑポイントに加算されます。
										</li>
										<li>
											・　短時間加算ポイント・・・受検開始から終了までに要した時間が所定時間の半分以下で合格した場合、その書籍の読Ｑ本ポイントの1割の加算ポイントを得ることができます。<br>
											　例：　全10問の読Ｑ本の場合の短時間加算ポイント・・・30秒×1/2×10問＝2分30秒2分30秒以内に合格すれば、合格ポイントが1割多く獲得できます。
										</li>
										<li>
											マイ書斎へ記録されます
										</li>
										<li>
											・　マイ書斎連絡帳へ、おめでとうメッセージが来ます。昇級したら、昇級のお祝いメッセージも届きます。
										</li>
										<li>
											・　マイ書斎に記録が載ります。確認して、ぜひ合格記録やマイ本棚を公開しましょう。
										</li>
									</div>	
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
								<button class="btn btn-primary">同意して次へ</button>
							</div>
							<div class="col-md-6 text-md-right col-xs-6" style="text-align:right;">
								<a class="btn btn-info pull-right" href="<?php echo e(url('/')); ?>">トップに戻る</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
	   $(document).ready(function(){
			$('body').addClass('page-full-width');
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>