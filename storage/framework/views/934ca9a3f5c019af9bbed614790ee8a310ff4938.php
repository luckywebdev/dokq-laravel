<?php if($type == "subsave"): ?>
	
	 	読Q本への登録が途中保存されています。編集へ戻るには、
		<a href="<?php echo e(url('/book/'.$id.'/edit/'.$msgId)); ?>" >
			<strong>こちら</strong>
		</a>
		をクリックしてください。
<?php else: ?>
	読Q本への登録が途中保存されています。編集へ戻るには、<strong>こちら</strong>をクリックしてください。
	
<?php endif; ?>
