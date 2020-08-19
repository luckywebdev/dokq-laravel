<table class="table table-striped table-bordered table-hover data-table" id="member_table">
	<thead>
		<tr class="danger">
			<th class="table-checkbox">
				<input type="checkbox" class="group-checkable" data-set="#member_table .checkboxes"/>
			</th>
			<th>
				 姓
			</th>
			<th>
				名
			</th>
			<th>
				 性別
			</th>
			<th>
				 カタカナ
			</th>
			<th>
				 姓ローマ字
			</th>
			<th>
				 名ローマ字
			</th>
			<th>
				 読Qネーム
			</th>
			<th>
				 パスワード
			</th>
			<th>
				 メールアドレス
			</th>
			<th>
				教師/司書
			</th>
		</tr>
	</thead>
	<tbody class="text-md-center">
	<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr class="odd gradeX" data-id="<?php echo e($member->id); ?>">
			<td>
				<input type="checkbox" class="checkboxes" id="<?php echo e($member->id); ?>" name="teacher" value="<?php echo e($member->id); ?>"/>
			</td>
			<td>
			 	<?php echo e($member->firstname); ?>

			</td>
			<td>
				 <?php echo e($member->lastname); ?>

			</td>
			<td>
				 <?php echo e(config('consts')['USER']['GENDER'][$member->gender]); ?>

			</td>
			<td>
				 <?php echo e($member->firstname_yomi); ?> <?php echo e($member->lastname_yomi); ?>

			</td>
			<td>
				 <?php echo e($member->firstname_roma); ?>

			</td>
			<td>
				 <?php echo e($member->lastname_roma); ?>

			</td>
			<td>
				 <?php echo e($member->username); ?>

			</td>
			<td>
				 <?php echo e($member->passwordShow()); ?>

			</td>
			<td>
				 <?php echo e($member->email); ?>

			</td>
			<td>
				 <?php echo e(config('consts')['USER']['TYPE'][$member->role]); ?>

			</td>
			
		</tr>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>
<script>
	
</script>