			<div class="row">
				<div class="col-md-12">
					<?php if(isset($message)): ?>
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							<?php echo e($message); ?>

						</p>
					</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							<?php if(Auth::user()->isAdmin()): ?>
						    <thead>
						    	<tr class="success">
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>
							        <th>応募者数</th>					        
						        </tr>
						    </thead>
						    <?php else: ?>
						    <thead>
						    	<tr class="success">
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>							        
							        <th>今集まっているクイズ数</th>							        
							        <th>監修者に応募する</th>
						        </tr>
						    </thead>
						    <?php endif; ?>
						    <?php if(Auth::user()->isAdmin()): ?>
						    <tbody class="text-md-center">
								<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($book->replied_date1? with((date_create($book->replied_date1)))->format('Y/m/d'):""); ?></td>
									<td class="didor"><a href="<?php echo e(url('admin/can_book_c?book_id='.$book->id)); ?>" class="font-blue"><?php echo e($book->title); ?></a></td>
									<td ><?php echo e($book->fullname_nick()); ?></td>
									<td class="xin">dq<?php echo e($book->id); ?></td>
									<td><?php echo e(floor($book->point*100)/100); ?></td>
									<td><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
									<td><?php echo e($book->PendingOverseers()->count()); ?></td>								
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
							<?php else: ?>
							<tbody class="text-md-center">
								<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($book->replied_date1? with((date_create($book->replied_date1)))->format('Y/m/d'):""); ?></td>
									<td class="didor"><?php echo e($book->title); ?></td>
									<td ><?php echo e($book->fullname_nick()); ?></td>
									<td class="xin">dq<?php echo e($book->id); ?></td>
									<td><?php echo e(floor($book->point*100)/100); ?></td>
									<td><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>									
									<td><?php echo e($book->PendingQuizes()->count()); ?></td>									
									<td class="proposal" bid="<?php echo e($book->id); ?>"><a style="color: blue">
									    <?php if(Auth::user()->isAdmin()): ?>
									    監修者に応募
									    <?php else: ?>
									    監修者に応募
									    <?php endif; ?>
									</a></td>
								</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>

							<?php endif; ?>
						</table>
						

					</div>
				</div>
			</div>