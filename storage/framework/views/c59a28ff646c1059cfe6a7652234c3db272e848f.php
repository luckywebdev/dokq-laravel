
	<table class="table table-striped table-bordered table-hover data-table" id="sample_<?php echo e($type); ?>">
		<thead>
			<tr class="bg-blue">
			<?php if($type == 'gene'): ?>
				<th>タイトル</th>
				<th>著者</th>
				<th>ページ数</th>
				<th>ポイント</th>
				<th>帯文 </th>
				<th>合格者数</th>
				<th>表紙画像</th>
				<th>選択</th>
			<?php endif; ?>
			<?php if($type == 'category'): ?>
				<th>タイトル</th>
				<th>著者</th>
				<th>ポイント</th>
				<th>推奨年代</th>
				<th>分類</th>
				<th>読Q合格者数</th>
				<th>表紙画像</th>
				<th>この本を受検</th>
			<?php endif; ?>
			<?php if($type == 'period'): ?>
				<th>タイトル</th>
				<th>著者</th>
				<th>ページ数</th>
				<th>ポイント</th>
				<th>帯文 </th>
				<th>読Q合格者数</th>
				<th>選択</th>
			<?php endif; ?>
			<?php if($type =='latest'): ?>
				<th>認定日順</th>
				<th>タイトル </th>
				<th>著者</th>
				<th>出版社名</th>
				<th>ISBN</th>
				<th>推奨年代</th>
				<th>ポイント</th>
				<th>表紙画像</th>
				<th>選択</th>
			<?php endif; ?>
			<?php if($type =='ranking'): ?>
				<th>順位</th>
				<th>タイトル</th>
				<th>著者</th>
				<th>ポイント</th>
				<th>推奨年代</th>
				<th>読Q合格者数</th>
				<th>表紙画像</th>
				<th>この本を受検</th>
			<?php endif; ?>
			</tr>
		</thead>
		<tbody class="text-md-center">
			<?php $i = 0;?>
			<?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php $i++;?>
				<?php if($type == 'category'): ?>
					<tr>
						<td style="vertical-align:middle">
                            <b hidden="true"><?php echo e($book->title_furi); ?></b>
							<?php if($book->active >= 3): ?><a href="<?php echo e(url('book/'. $book->id .'/detail')); ?>" ><?php echo e($book->title); ?></a><?php else: ?> <?php echo e($book->title); ?><?php endif; ?>
							<?php if($book->active <= 5): ?>
							<div class="clearfix"></div>
							<span class="text-danger float-center">
								(クイズ募集中の本)
							</span>
							<?php endif; ?>
							<?php if($book->active == 3): ?>
							<div class="clearfix"></div>
							<span class="text-danger float-center">
								(監修者募集中の本)
							</span>
							<?php endif; ?>
						</td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->fullname_yomi()); ?></b>
                        <a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($book->fullname_nick()); ?></a>
                        </td>
						<td style="vertical-align:middle"><?php echo e(floor($book->point*100)/100); ?></td>
						<td style="vertical-align:middle; white-space: nowrap"><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
						<td style="vertical-align:middle; white-space: nowrap">
							<?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php if($key + 1 == count($book->categories)): ?>
									<?php echo e($category->name); ?>

								<?php else: ?>
									<?php echo e($category->name); ?>、
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</td>
						<td style="vertical-align:middle"><?php if(isset($book->passedNums) && count($book->passedNums) != 0): ?><?php echo e(count($book->passedNums)); ?><?php endif; ?></td>
						<td>
							<img src="<?php echo e(asset($book->cover_img)); ?>" <?php if($book->url !== null && $book->url != ''): ?> onclick="javascript:location.href='<?php echo e(url($book->url)); ?>'" <?php endif; ?> alt="" height="80px">
						</td>
						<td style="vertical-align:middle">
							<?php if($book->active == 2): ?>	
								読Q対象外の本のため<br>登録できません<br>
								（<?php echo e(isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''); ?>）
							<?php else: ?>
								<?php if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1): ?>
									<?php if(Auth::user()->getBookyear($book->id) !== null): ?>
										<span class="btn btn-xs btn-info  margin-bottom-10 age_limit">この本を受検</span>
									<?php elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null): ?>
										<span class="btn btn-xs btn-info margin-bottom-10 book_equal">この本を受検</span>
									<?php else: ?>
										<button type="button" id="<?php echo e($book->id); ?>" class="test_btn btn btn-xs btn-info margin-bottom-10">この本を受検</button>
									<?php endif; ?>
								<?php else: ?>
									<span class="btn btn-xs btn-info margin-bottom-10 disabled">この本を受検</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if($book->active >= 3): ?>
									<button type="button" id="<?php echo e($book->id); ?>" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								<?php else: ?>
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if($book->active <= 5): ?>
									<a href="#" class="btn btn-xs btn-warning margin-bottom-10">この本のクイズを作る</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
				<?php if($type == 'gene'): ?>					
					<tr>						
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->title_furi); ?></b> 
                        <?php if($book->active >= 3): ?><a href="<?php echo e(url('book/'. $book->id .'/detail')); ?>" ><?php echo e($book->title); ?></a><?php else: ?> <?php echo e($book->title); ?><?php endif; ?>
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->fullname_yomi()); ?></b>  
                        <a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($book->fullname_nick()); ?></a>
                        </td>
						<td style="vertical-align:middle"><?php echo e($book->pages); ?></td>
						<td style="vertical-align:middle"><?php echo e(floor($book->point*100)/100); ?></td>
						<td style="vertical-align:middle; white-space: nowrap"><?php echo e($book->TopArticle()); ?></td>
						<td style="vertical-align:middle"><?php if(count($book->passedNums) != 0): ?><?php echo e(count($book->passedNums)); ?><?php endif; ?></td>
						<td>
							<img src="<?php echo e(asset($book->cover_img)); ?>" <?php if($book->url !== null && $book->url != ''): ?> onclick="javascript:location.href='<?php echo e(url($book->url)); ?>'" <?php endif; ?> alt="" height="80px">
						</td>
						<td>
							<?php if($book->active == 2): ?>	
								読Q対象外の本のため<br>登録できません<br>
								（<?php echo e(isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''); ?>）
							<?php else: ?>
								<?php if($book->active >= 3): ?>
									<button type="button" id="<?php echo e($book->id); ?>" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								<?php else: ?>
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember()): ?>
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="<?php echo e($book->id); ?>" style="margin-bottom:8px;">読みたい本に追加</button>
								<?php else: ?>
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
				<?php if($type == 'latest'): ?>
					<tr>
						<td style="vertical-align:middle"><?php echo e(with(date_create($book->qc_date))->format('Y/m/d')); ?></td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->title_furi); ?></b>    
                        <?php if($book->active >= 3): ?><a href="<?php echo e(url('book/'. $book->id .'/detail')); ?>" ><?php echo e($book->title); ?></a><?php else: ?> <?php echo e($book->title); ?><?php endif; ?>
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->fullname_yomi()); ?></b>
                        <a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue-madison"><?php echo e($book->fullname_nick()); ?></a>
                        </td>
						<td style="vertical-align:middle"><?php echo e($book->publish); ?></td>
						<td style="vertical-align:middle"><?php echo e($book->isbn); ?></td>
						<td style="vertical-align:middle; white-space: nowrap"><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
						<td style="vertical-align:middle"><?php echo e(floor($book->point*100)/100); ?></td>
						<td>
							<img src="<?php echo e(asset($book->cover_img)); ?>" <?php if($book->url !== null && $book->url != ''): ?> onclick="javascript:location.href='<?php echo e(url($book->url)); ?>'" <?php endif; ?> alt="" height="80px">
						</td>
						<td>
							<?php if($book->active == 2): ?>	
								読Q対象外の本のため<br>登録できません<br>
								（<?php echo e(isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''); ?>）

							<?php else: ?>
								<?php if($book->active >= 3): ?>
									<button type="button" id="<?php echo e($book->id); ?>" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								<?php else: ?>
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember()): ?>
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="<?php echo e($book->id); ?>" style="margin-bottom:8px;">読みたい本に追加</button>
								<?php else: ?>
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
				<?php if($type == 'ranking'): ?>
					<tr>
						<td style="vertical-align:middle"><?php echo e($i); ?>位</td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->title_furi); ?></b>    
                        <?php if($book->active >= 3): ?><a href="<?php echo e(url('book/'. $book->id .'/detail')); ?>" ><?php echo e($book->title); ?></a><?php else: ?> <?php echo e($book->title); ?><?php endif; ?>
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true"><?php echo e($book->fullname_yomi()); ?></b>  
                        <a href="<?php echo e(url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())); ?>" class="font-blue-madison">
				        <?php echo e($book->fullname_nick()); ?></a></td>
						<td style="vertical-align:middle"><?php echo e(floor($book->point*100)/100); ?></td>
						<td style="vertical-align:middle; white-space: nowrap"><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
						<td style="vertical-align:middle"><?php if($book->ranking != 0): ?><?php echo e($book->ranking); ?><?php endif; ?></td>
						<td>							
							<img src="<?php echo e(asset($book->cover_img)); ?>" <?php if($book->url !== null && $book->url != ''): ?> onclick="javascript:location.href='<?php echo e(url($book->url)); ?>'" <?php endif; ?>  height="80px;">							
						</td>
						<td>
							<?php if($book->active == 2): ?>	
								読Q対象外の本のため<br>登録できません<br>
								（<?php echo e(isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''); ?>）

							<?php else: ?>
								<?php if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1): ?>
									<?php if(Auth::user()->getBookyear($book->id) !== null): ?>
										<span class="btn btn-xs btn-info  margin-bottom-10 age_limit">この本を受検</span>
									<?php elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null): ?>
										<span class="btn btn-xs btn-info margin-bottom-10 book_equal">この本を受検</span>
									<?php else: ?>
										<button type="button" id="<?php echo e($book->id); ?>" class="test_btn btn btn-xs btn-info margin-bottom-10">この本を受検する</button>
									<?php endif; ?>
								<?php else: ?>
									<span class="btn btn-xs btn-info margin-bottom-10 disabled">この本を受検</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if($book->active >= 3): ?>
									<button type="button" id="<?php echo e($book->id); ?>" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								<?php else: ?>
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								<?php endif; ?>
								<div class="clearfix"></div>
								<?php if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember()): ?>
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="<?php echo e($book->id); ?>" style="margin-bottom:8px;">読みたい本に追加</button>
								<?php else: ?>
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
	

	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<h4>
						この本を、読みたい本に登録しました。
					</h4>
					<h4>
						マイ書斎の、読みたい本リストで確認できます。
					</h4>

				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade draggable draggable-modal" id="confirmModal1" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<h4>
						既に読みたい本に登録されたほんです。
					</h4>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
