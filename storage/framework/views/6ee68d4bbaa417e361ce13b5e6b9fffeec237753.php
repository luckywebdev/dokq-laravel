	<div class="row margin-top-10">		
		<div class="offset-md-8 col-md-4">
			<a class="btn btn-warning" href="<?php echo e(url('/book/register/caution')); ?>">登録するときの注意事項
			</a>
		</div>
  	</div>
	<?php echo e(csrf_field()); ?>

	<input type="hidden" name="register_id" value="<?php echo e(Auth::id()); ?>">
	<input type="hidden" name="action" id="action" value="">
	<input type="hidden" name="subsave" value="0" id="subsave">
	<input type="hidden" name="active" id="active" value="<?php echo e(isset($book) ? $book->active : 0); ?>">
	<input type="hidden" name="book_id" value="<?php echo e(isset($book) ? $book->id : old('book_id')); ?>">
	<input type="hidden" name="beforefile" id="beforefile" value="<?php echo e(isset($beforefile) ? $beforefile : ''); ?>">
	<input type="hidden" name="beforefilename" id="beforefilename" value="<?php echo e(isset($beforefilename) ? $beforefilename : ''); ?>">
	<input type="hidden" name="cautionflag" value="<?php if(isset($cautionflag)): ?><?php echo e($cautionflag); ?><?php endif; ?>" id="cautionflag">
	<input type="hidden" name="msg_id" value="<?php if(isset($msgId)): ?><?php echo e($msgId); ?><?php endif; ?>" id="msg_id">
	 <?php if(count($errors) > 0 && $errors->first('savebookerr') != '' && $errors->first('savebookerr') !== null): ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>
               <?php echo e($errors->first('savebookerr')); ?>

            </span>
        </div>
    <?php elseif(count($errors) > 0): ?>
    	<?php echo $__env->make('partials.alert1', array('errors' => ''), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
    <?php if(count($errors) > 0 && $errors->first('bookouterr') != '' && $errors->first('bookouterr') !== null): ?>
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>
               <?php echo e($errors->first('bookouterr')); ?>

            </span>
        </div>
    <?php endif; ?>
	<div class="form-body">
		<h4 class="form-section warning"><strong><?php if(isset($data)): ?> 本の基本情報を編集 <?php else: ?> 本の基本情報を入力ます <?php endif; ?></strong></h4>
		<div class="row top-border">
			<div class="col-md-12 margin-bottom-5 <?php echo e($errors->has('type') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>1.&nbsp;&nbsp;&nbsp;&nbsp;本の種類</strong></label>
				<div class="col-md-5">
					<input type="hidden" id="book_form_flag" name="book_form_flag"/>
					<select class="bs-select" name="type" id="type" style="height:33px !important">
						<?php $__currentLoopData = config('consts')['BOOK']['TYPE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($key); ?>" <?php if(old('type')!=''): ?> 
														<?php if(old('type') == $key): ?> selected <?php endif; ?>
													<?php else: ?>
													 	 <?php if(isset($data) && $data['type'] == $key): ?> selected <?php endif; ?>
													<?php endif; ?>><?php echo e($type); ?></option>
													
										
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('type')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('type')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('title') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>2.&nbsp;&nbsp;&nbsp;&nbsp;本のタイトル（全角）</strong></label>
				<div class="col-md-5">
					<input type="text" name="title" value="<?php echo e(old('title')!='' ? old('title'):( isset($data)? $data['title']: '')); ?>" class="form-control" id="input_1" placeholder="雪国">
					<?php if($errors->has('title')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('title')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('title_furi') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>3.&nbsp;&nbsp;&nbsp;&nbsp;本のタイトルのふりがな（全角）</strong></label>
				<div class="col-md-5">
					<input type="text" name="title_furi" value="<?php echo e(old('title_furi')!='' ? old('title_furi'): (isset($data)? $data['title_furi']: '')); ?>" class="form-control" placeholder="ゆきぐに" id="input_2">
					<?php if($errors->has('title_furi')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('title_furi')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('firstname_nick') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>4.&nbsp;&nbsp;&nbsp;&nbsp;著者名（全角）</strong></label>
				<div class="col-md-2">姓:<input type="text" name="firstname_nick" value="<?php echo e(old('firstname_nick')!='' ? old('firstname_nick'): (isset($book)? $book->firstname_nick: '' )); ?>" class="form-control" placeholder="川端" id="firstname_nick">
					<?php if($errors->has('firstname_nick')): ?>
						<span class="form-control-feedback">
							<span id="Errorbookout"><?php echo e($errors->first('firstname_nick')); ?></span>
						</span>
					<?php else: ?>
						<span id="Errorbookout" style="color:#E45000;display:none;"><?php echo e(config('consts')['MESSAGES']['BOOKOUT_UNIQUE']); ?></span>
					<?php endif; ?>
				</div>
				<div class="col-md-2">
					名:<input type="text" name="lastname_nick" value="<?php echo e(old('lastname_nick')!='' ? old('lastname_nick'): (isset($book)? $book->lastname_nick: '' )); ?>" class="form-control" placeholder="康成" id="lastname_nick">
					<?php if($errors->has('lastname_nick')): ?>
						<span class="form-control-feedback">
							<span id="Errorbookout"><?php echo e($errors->first('lastname_nick')); ?></span>
						</span>
					<?php else: ?>
						<span id="Errorbookout" style="color:#E45000;display:none;"><?php echo e(config('consts')['MESSAGES']['BOOKOUT_UNIQUE']); ?></span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('firstname_yomi') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>5.&nbsp;&nbsp;&nbsp;&nbsp;著者名のふりがな（全角）</strong></label>
				<div class="col-md-2">
					姓:<input type="text" name="firstname_yomi" value="<?php echo e(old('firstname_yomi')!='' ? old('firstname_yomi'): (isset($book)? $book->firstname_yomi: '' )); ?>" class="form-control" placeholder="かわばた" id="firstname_yomi">
					<?php if($errors->has('firstname_yomi')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('firstname_yomi')); ?></span>
						</span>
					<?php endif; ?>
				</div>
				<div class="col-md-2">
					名:<input type="text" name="lastname_yomi" value="<?php echo e(old('lastname_yomi')!='' ? old('lastname_yomi'): (isset($book)? $book->lastname_yomi: '' )); ?>" class="form-control" placeholder="やすなり" id="lastname_yomi">
					<?php if($errors->has('lastname_yomi')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('lastname_yomi')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('isbn') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>6.&nbsp;&nbsp;&nbsp;&nbsp;ISBN（半角数字）</strong></label>
				<div class="col-md-5">
					<input type="text" name="isbn" id="input_5" value="<?php echo e(old('isbn')!='' ? old('isbn'): (isset($data)? $data['isbn']: '')); ?>" class="form-control" placeholder="410100101">
					<?php if($errors->has('isbn')): ?>
						<span class="form-control-feedback">
							<span id="ErrorISBN"><?php echo e($errors->first('isbn')); ?></span>
						</span>
					<?php else: ?>
						<span id="ErrorISBN" style="color:#E45000;display:none;"><?php echo e(config('consts')['MESSAGES']['ISBN_UNIQUE']); ?></span>
					<?php endif; ?>
					
				</div>
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">※電子書籍は空欄可</label>
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">※下記の黄色部分、４から始まる９けたの数字を入力してください	</label>
				
				<div class=" col-md-12 col-md-offset-1">
					<label class="control-label text-md-left">&nbsp;例：&nbsp;ISBN-10:&nbsp;</label>
					<label class="control-label text-md-left" style="background-color:#fefe0c;padding-left:0px">406277088</label>1
				</div>
			
				<div class=" col-md-12 col-md-offset-1">
					<label class="control-label text-md-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ISBN-13:&nbsp;&nbsp;978-</label>
					<label class="control-label text-md-left" style="background-color:#fefe0c;padding-left:0px">406277088</label>0
				</div>
				
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('publish') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>7.&nbsp;&nbsp;&nbsp;&nbsp;出版社（全角）</strong></label>
				<div class="col-md-5">
					<input type="text" name="publish" value="<?php echo e(old('publish') ? old('publish'): (isset($data)? $data['publish']: '')); ?>" class="calc form-control" maxlength="128"  id="input_6" placeholder="新潮文庫">
                    <?php if($errors->has('publish')): ?>
                        <span class="form-control-feedback">
                            <span><?php echo e($errors->first('publish')); ?></span>
                        </span>
                    <?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('categories') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>8.&nbsp;&nbsp;&nbsp;&nbsp;分類・ジャンル(４つまで選べます)</strong></label>
				<div class="col-md-5">
					<select class="form-control select2me calc" name="categories[]" id="categories[]" multiple placeholder="選択..." style="min-width:100px;">
						<option></option>
						<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if((is_object(old('categories')) && count(get_object_vars(old('categories'))) || (is_array(old('category')) && count(old('categories')))) > 0): ?>
								<option value="<?php echo e($category->id); ?>" <?php if(in_array($category->id,  old('categories'))): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
							<?php elseif(isset($book) && !is_null($book->categories()) && count($book->category_ids())): ?> > 0)
								<option value="<?php echo e($category->id); ?>" <?php if(in_array($category->id,  $book->category_ids())): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
							<?php elseif(is_object(old('categories')) && count(get_object_vars(old('categories'))) == 0 && (!isset($book) || count($book->category_ids()) == 0) && $key == 8): ?>
								<option value="<?php echo e($category->id); ?>" selected ><?php echo e($category->name); ?></option>
							<?php else: ?>
								<option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('categories')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('categories')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12 margin-bottom-5 <?php echo e($errors->has('recommend') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>9.&nbsp;&nbsp;&nbsp;&nbsp;推奨年代、難易度</strong></label>
				<div class="col-md-5">
					<select name="recommend" class="form-control select2me calc"  placeholder="選択..." style="height:33px !important">
						<option></option>
						<?php $__currentLoopData = config('consts')['BOOK']['RECOMMEND']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $recommend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($key); ?>" <?php if($key==old('recommend')): ?> selected <?php endif; ?> <?php if(isset($data['recommend'])&&($data['recommend']==$key)): ?> selected <?php endif; ?>><?php echo e($recommend['TITLE']); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('recommend')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('recommend')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-7 text-md-left"><strong>10.&nbsp;&nbsp;&nbsp;&nbsp;表紙画像のファイルを添付してください。</strong></label>
				<div class="col-md-5">
					<textarea id="image_url" name="image_url" rows="3" style="width: 100%"><?php echo e($data['image_url']); ?></textarea>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('url') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>11.&nbsp;&nbsp;&nbsp;&nbsp;ネット書店のURLがあれば貼付してください。</strong></label>
				<div class="col-md-5">
					<textarea id="rakuten_url" name="rakuten_url" rows="3" style="width: 100%"><?php echo e($data['rakuten_url']); ?></textarea>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('url') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;honto で見る。</strong></label>
				<div class="col-md-5">
					<textarea id="honto_url" name="honto_url" rows="3" style="width: 100%"><?php echo e($data['honto_url']); ?></textarea>
				</div>
			</div>				
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('url') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;楽天ブックスで見る。</strong></label>
				<div class="col-md-5">
					<textarea id="seven_net_url" name="seven_net_url" rows="3" style="width: 100%"><?php echo e($data['seven_net_url']); ?></textarea>
				</div>
			</div>				
		<h4 class="form-section warning">
			<strong>本の内容量を測定して、読Q本ポイントを算出します。</strong>
			<label class="control-label warning col-md-12 text-md-left">※青空文庫など総字数をカウント済みの場合は、16番の総字数欄に直接入力してください。</label>
		</h4>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('pages') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>12.&nbsp;&nbsp;&nbsp;&nbsp;本文の最終ページは何ページですか。</strong></label>
				<div class="form-group col-md-5">
					<div class="col-md-1"><h4>p</h4></div>
					<div class="col-md-9 spin">
						<input type="number" min="0" name="pages" value="<?php echo e(old('pages')!='' ? old('pages'): (isset($data)? $data['pages']: '')); ?>" class="param spinner-input form-control" maxlength="3" id="input_8">
						<?php if($errors->has('pages')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('pages')); ?></span>
							</span>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-7 text-md-left"><strong>13.&nbsp;&nbsp;&nbsp;&nbsp;1ページ内に最大で何文字入るかを測定します。</strong></label>
				<div class="col-md-5"></div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('max_rows') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">a.&nbsp;&nbsp;&nbsp;&nbsp;行数…　１ページの中には最大で何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="max_rows" value="<?php echo e(old('max_rows')!='' ? old('max_rows'): (isset($data)? $data['max_rows']: '')); ?>" class="param calc form-control" maxlength="3" id="input_9">
						<?php if($errors->has('max_rows')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('max_rows')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>					
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('max_chars') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">b.&nbsp;&nbsp;&nbsp;&nbsp;字数…　１行の中には最大で何文字ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="max_chars" value="<?php echo e(old('max_chars')!='' ? old('max_chars'): (isset($data)? $data['max_chars']: '')); ?>" class="param calc form-control" maxlength="3" id="input_10">
						<?php if($errors->has('max_chars')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('max_chars')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">文字</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-12 text-md-left"><strong>14.&nbsp;&nbsp;&nbsp;&nbsp;空白部分(挿絵、目次などを含む)があるページ数を数えます。</strong></label>				
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('entire_blanks') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">a.&nbsp;&nbsp;&nbsp;&nbsp;空白ページ、全面イラストページ、目次、解説などのページは、何ページありますか。</label>
				<div class="col-md-7"></div>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="entire_blanks" value="<?php echo e(old('entire_blanks')!='' ? old('entire_blanks'): (isset($data)? $data['entire_blanks']: '')); ?>" class="param calc form-control" maxlength="3" id="input_11">
						<?php if($errors->has('entire_blanks')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('entire_blanks')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">ページ</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('quarter_filled') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">b.&nbsp;&nbsp;&nbsp;&nbsp;4分の3が空白やイラストで、4分の１に字が書かれているページは、何ページありますか。</label>
				<div class="col-md-7"></div>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="quarter_filled" value="<?php echo e(old('quarter_filled')!='' ? old('quarter_filled'): (isset($data)? $data['quarter_filled']: '')); ?>" class="param calc form-control" maxlength="3" id="input_12">
						<?php if($errors->has('quarter_filled')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('quarter_filled')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">ページ</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('half_blanks') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">c.&nbsp;&nbsp;&nbsp;&nbsp;半分が空白やイラストで、半分に字が書かれているページは、何ページありますか。</label>
				<div class="col-md-7"></div>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="half_blanks" value="<?php echo e(old('half_blanks')!='' ? old('half_blanks'): (isset($data)? $data['half_blanks']: '')); ?>" class="param calc form-control" maxlength="3" id="input_13">
						<?php if($errors->has('half_blanks')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('half_blanks')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">ページ</label>
				</div>
			</div>	
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('quarter_blanks') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">d.&nbsp;&nbsp;&nbsp;&nbsp;4分の１が空白やイラストで、4分の３に字が書かれているページは何ページありますか。</label>
				<div class="col-md-7"></div>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
						<input type="number" min="0" name="quarter_blanks" value="<?php echo e(old('quarter_blanks')!='' ? old('quarter_blanks'): (isset($data)? $data['quarter_blanks']: '')); ?>" class="param calc form-control" maxlength="3" id="input_14">
						<?php if($errors->has('quarter_blanks')): ?>
							<span class="form-control-feedback">
								<span><?php echo e($errors->first('quarter_blanks')); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">ページ</label>
				</div>
			</div>			
		</div>
		
		<div class="row">
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-12 text-md-left"><strong>15.&nbsp;&nbsp;&nbsp;&nbsp;モデルページを使用して、１ページ内のおおよその平均字数を測定します。</strong></label>
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">※モデルページ(p30、p50、p70、p90、p110)に空白部分が多い場合は、<br>次のページを使用してください。</label>
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">※行単位で文字量を測定します。(字が少ない行は字数０、字が多い行は最大数であると換算)</label>				
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('p30') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">a.&nbsp;&nbsp;&nbsp;&nbsp;p30の中に、字数が半分以下の行は、何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" min="0" name="p30" value="<?php echo e(old('p30')!='' ? old('p30'): (isset($data)? $data['p30']: '')); ?>" class="param calc form-control" maxlength="3" id="input_15">
					<?php if($errors->has('p30')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('p30')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('p50') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">b.&nbsp;&nbsp;&nbsp;&nbsp;P50の中に、字数が半分以下の行は、何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" min="0" name="p50" value="<?php echo e(old('p50')!='' ? old('p50'): (isset($data)? $data['p50']: '')); ?>" class="param calc form-control" maxlength="3" id="input_16">
					<?php if($errors->has('p50')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('p50')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5  <?php echo e($errors->has('p70') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">c.&nbsp;&nbsp;&nbsp;&nbsp;P70の中に、字数が半分以下の行は、何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" min="0" name="p70" value="<?php echo e(old('p70')!='' ? old('p70'): (isset($data)? $data['p70']: '')); ?>" class="param calc form-control" maxlength="3" id="input_17">
					<?php if($errors->has('p70')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('p70')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('p90') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">d.&nbsp;&nbsp;&nbsp;&nbsp;P90の中に、字数が半分以下の行は、何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" min="0" name="p90" value="<?php echo e(old('p90')!='' ? old('p90'): (isset($data)? $data['p90']: '')); ?>" class="param calc form-control" maxlength="3" id="input_18">
					<?php if($errors->has('p90')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('p90')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>
				</div>
			</div>
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('p110') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-6 col-md-offset-1 text-md-left">e.&nbsp;&nbsp;&nbsp;&nbsp;P110の中に、字数が半分以下の行は、何行ありますか。</label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" min="0" name="p110" value="<?php echo e(old('p110')!='' ? old('p110'): (isset($data)? $data['p110']: '')); ?>" class="param calc form-control" maxlength="3" id="input_19">
					<?php if($errors->has('p110')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('p110')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">行</label>
				</div>
			</div>
		</div>
		
		<div class="row">			
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('total_chars') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-7 text-md-left"><strong>16.&nbsp;&nbsp;&nbsp;&nbsp;総字数・・・・・・・・・・・・・・・・・・</strong></label>
				<div class="form-group col-md-5">					
					<div class="col-md-10 spin">
					<input type="number" value="<?php echo e(old('total_chars')!='' ? old('total_chars'): (isset($data)? $data['total_chars']: '')); ?>" name="total_chars" id="total_chars" readonly class="form-control" maxlength="6">
					<?php if($errors->has('total_chars')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('total_chars')); ?></span>
						</span>
					<?php endif; ?>
					</div>
					<label class="control-label col-md-2 text-md-left">文字</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-12 text-md-left"><strong>17.&nbsp;&nbsp;&nbsp;&nbsp;算出された総字数に、推奨年代やジャンルなどによる読Q規定係数をかけ合わせて、この本の読Q本ポイントを設定します。</strong></label>				
			</div>
			<div class="col-md-12  margin-bottom-5 ">
				<label class="control-label offset-md-1 col-md-6 text-md-left"><strong>この本のポイント・・・・・・・・・・・・・・</strong></label>
				<div class="form-group col-md-5">					
					<div class="col-md-9">
					<input type="text" name="point" value="<?php echo e(old('point')!='' ? old('point'): (isset($data)? floor($data['point']*100)/100: '')); ?>" readonly="true" class="form-control" id="point">
					</div>
					<label class="control-label col-md-3 text-md-left">ポイント</label>
				</div>				
			</div>
		</div>

		<div  class="row">					
			<div class="col-md-12  margin-bottom-5">
				<label class="control-label col-md-12 text-md-left"><strong>18.&nbsp;&nbsp;&nbsp;&nbsp;この本の登録者として、紹介ページに載る名前の表記方法を選択してください。</strong></label>
				<label class="control-label col-md-11 col-md-offset-1 text-md-left">※15歳までは非表示になります。</label>				
			</div>			
			<div class="col-md-12  margin-bottom-5 <?php echo e($errors->has('register_visi_type') ? ' has-danger' : ''); ?>">
				<div class="col-md-7"></div>
				<div class="form-group col-md-5">					
					<div class="col-md-9">
					<select class="bs-select form-control" name="register_visi_type" placeholder="選択.." style="height:33px !important">
						<?php for($i=1; $i<3; $i++): ?>
							<option value="<?php echo e($i - 1); ?>" <?php if(old('register_visi_type')!=''): ?> <?php if($i-1==old('register_visi_type')): ?> selected <?php endif; ?> <?php else: ?> <?php if(isset($data)): ?> <?php if($data['register_visi_type'] == $i-1): ?> selected <?php endif; ?> <?php endif; ?> <?php endif; ?>><?php echo e(config('consts')['BOOK']['REGISTER_VISI_TYPE'][$i]); ?></option>
						<?php endfor; ?>
					</select>
					<?php if($errors->has('register_visi_type')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('register_visi_type')); ?></span>
						</span>
					<?php endif; ?>
					</div><div class="col-md-3"></div>
				</div>
			</div>
		</div>
		<!--/row-->
	</div>
