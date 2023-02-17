
<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>">

    <style type="text/css">
	.caution{
		font-size: 16px;
	}
	.caution tr{
		margin-bottom: 10px;
	}
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="breadcum">
        <div class="container-fluid">
            <div class="row">
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo e(url('/')); ?>">
                            読Qトップ
                        </a>
                    </li>
                    <li class="hidden-xs">
                        >   <a href="<?php echo e(url('/top')); ?>">協会トップ</a>
                    </li>
                    <li class="hidden-xs">
                        > データ選択・作業選択
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">読Q本カード</h3>
        
        <div class="form-body">
            <form class="form register-form"  id="validate-form" method="post" role="form" action="<?php echo e(url('/admin/save_book_data')); ?>"  enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <?php if(count($errors) > 0): ?>
                <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <input type="hidden" name="id" id="id" value="<?php echo e($book->id); ?>"> 
            <input type="hidden" name="delete_id" id="delete_id" value=""> 
                <div class="row form-group">
                    <div class="col-md-1"></div>   
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above" style="color: #31708f">読Q本ID</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="dqid" name="dqid" value="dq<?php echo e($book->id); ?>" readonly  style="color: #31708f; cursor: pointer; background: #d9edf7; border-color: #9ad3ef">
                    </div>
                    <div class="col-md-4 margin-bottom-5 <?php echo e($errors->has('title') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">タイトル</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="title" name="title" value="<?php echo e(old('title')!='' ? old('title'):( isset($book)? $book->title: '')); ?>" >
                        <?php if($errors->has('title')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('title')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 margin-bottom-5 <?php echo e($errors->has('title_furi') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">タイトルよみがな</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="title_furi" name="title_furi" value="<?php echo e(old('title_furi')!='' ? old('title_furi'):( isset($book)? $book->title_furi: '')); ?>">
                        <?php if($errors->has('title_furi')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('title_furi')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1 "></div>
                    <div class="col-md-2  margin-bottom-5 <?php echo e($errors->has('firstname_nick') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">著者ペンネーム 姓</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="firstname_nick" name="firstname_nick" value="<?php echo e(old('firstname_nick')!='' ? old('firstname_nick'):( isset($book)? $book->firstname_nick: '')); ?>">
                        <?php if($errors->has('firstname_nick')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('firstname_nick')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2  margin-bottom-5 <?php echo e($errors->has('lastname_nick') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">著者ペンネーム 名</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="lastname_nick" name="lastname_nick" value="<?php echo e(old('lastname_nick')!='' ? old('lastname_nick'):( isset($book)? $book->lastname_nick: '')); ?>">
                        <?php if($errors->has('lastname_nick')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('lastname_nick')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('firstname_yomi') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">著者よみがな 姓</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="firstname_yomi" name="firstname_yomi" value="<?php echo e(old('firstname_yomi')!='' ? old('firstname_yomi'):( isset($book)? $book->firstname_yomi: '')); ?>" >
                        <?php if($errors->has('firstname_yomi')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('firstname_yomi')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('lastname_yomi') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">著者よみがな 名</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="lastname_yomi" name="lastname_yomi" value="<?php echo e(old('lastname_yomi')!='' ? old('lastname_yomi'):( isset($book)? $book->lastname_yomi: '')); ?>" >
                        <?php if($errors->has('lastname_yomi')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('lastname_yomi')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 ">               
                        <div class="tools">
                            <label class="label-above">著者読Qネーム</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info " id="username" name="username" value="<?php echo e(old('username')!='' ? old('username'):( isset($book)? $book->username: '')); ?>" readonly>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('point') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">読Q本ポイント</label>                                                   
                        </div>
                        <input type="<?php echo e("number"); ?>" min="0" class="form-control base_info" id="point" name="point" value="<?php echo e(old('point')!='' ? old('point'):( isset($book)? $book->point: '')); ?>">
                        <?php if($errors->has('point')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('point')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('quiz_count') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">出題数</label>                                                   
                        </div>
                        <input type="<?php echo e("number"); ?>" min="0" class="form-control base_info" id="quiz_count" name="quiz_count" value="<?php echo e(old('quiz_count')!='' ? old('quiz_count'):( isset($book)? $book->quiz_count: '')); ?>">
                        <?php if($errors->has('quiz_count')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('quiz_count')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('test_short_time') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">時短最大秒数</label>                                                   
                        </div>
                        <input type="<?php echo e("number"); ?>" min="0" class="form-control base_info" id="test_short_time" name="test_short_time" value="<?php echo e(( isset($book)? $book->test_short_time: (old('test_short_time')!='' ? old('test_short_time') : ''))); ?>">
                        <?php if($errors->has('test_short_time')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('test_short_time')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">読Q推薦図書か</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control text-md-right base_info date-picker" id="recommend_flag" name="recommend_flag" value="<?php if($book->recommend_flag !== null && $book->recommend_flag != '0000-00-00'): ?> <?php echo e($book->recommend_flag); ?><?php endif; ?>">
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">アマゾンURL</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="url" name="url" value="<?php echo e(old('url')!='' ? old('url'):( isset($book)? $book->url: '')); ?>">
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">               
                        <div class="tools">
                            <label class="label-above">本の形態</label>                                                   
                        </div>
                        <select class="bs-select" name="type" id="type" style="height:33px !important">
                            <?php $__currentLoopData = config('consts')['BOOK']['TYPE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if(old('type')!=''): ?> 
                                                            <?php if(old('type') == $key): ?> selected <?php endif; ?>
                                                        <?php else: ?>
                                                             <?php if(isset($book) && $book->type == $key): ?> selected <?php endif; ?>
                                                        <?php endif; ?>><?php echo e($type); ?></option>
                                                        
                                            
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('type')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('type')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3 margin-bottom-5 <?php echo e($errors->has('recommend') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">推奨年代</label>                                                   
                        </div>
                        <select name="recommend" class="form-control select2me calc"  placeholder="選択..." style="height:33px !important">
                            <option></option>
                            <?php $__currentLoopData = config('consts')['BOOK']['RECOMMEND']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $recommend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php if(old('recommend') != ''): ?> <?php if(old('recommend')== $key): ?> selected <?php endif; ?> <?php elseif(isset($book)&& $book->recommend == $key): ?> selected <?php endif; ?>><?php echo e($recommend['TITLE']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>          
                        </select>
                        <?php if($errors->has('recommend')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('recommend')); ?></span>
                        </span>
                    <?php endif; ?>
                    </div>
                    <div class="col-md-2 margin-bottom-5 <?php echo e($errors->has('recommend_coefficient') ? ' has-danger' : ''); ?>">               
                        <div class="tools">
                            <label class="label-above">係数</label>                                                   
                        </div>
                        <input type="<?php echo e("number"); ?>" min="0" class="form-control base_info" id="recommend_coefficient" name="recommend_coefficient" value="<?php echo e(old('recommend_coefficient')!='' ? old('recommend_coefficient'):( isset($book)? $book->recommend_coefficient: '')); ?>" >
                         <?php if($errors->has('recommend_coefficient')): ?>
                        <span class="form-control-feedback">
                            <span><?php echo e($errors->first('recommend_coefficient')); ?></span>
                        </span>
                        <?php endif; ?>   
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">認定日</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="replied_date1" name="replied_date1" value="<?php echo e($book->replied_date1?with(date_create($book->replied_date1))->format("Y-m-d"):""); ?>" readonly>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row form-group">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">               
                        <div class="tools">
                            <label class="label-above">ジャンル</label>                                                   
                        </div>
                        <select class="form-control select2me calc" name="categories[]" id="categories[]" multiple placeholder="選択..." style="min-width:100px;" required>
                                <option></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!is_null(old('categories')) && count(old('categories')) > 0): ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if(in_array($category->id,  old('categories'))): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
                                    <?php elseif(isset($book) && !is_null($book->category_ids()) && count($book->category_ids()) > 0): ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if(in_array($category->id,  $book->category_ids())): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>
                                    <?php elseif((!is_null(old('categories')) && count(old('categories')) == 0) && (!isset($book) || (is_object($book->category_ids()) && count($book->category_ids()) == 0)) && $key == 8): ?>
                                        <option value="<?php echo e($category->id); ?>" selected ><?php echo e($category->name); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($errors->has('categories')): ?>
                            <span class="form-control-feedback" style="color:red">
                                <span><?php echo e($errors->first('categories')); ?></span>
                            </span>
                            <?php endif; ?>
                    </div>
                    <div class="col-md-2 ">               
                        <div class="tools">
                            <label class="label-above">出版社</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="publish" name="publish" value="<?php echo e(old('publish')!='' ? old('publish'):( isset($book)? $book->publish: '')); ?>">
                        <?php if($errors->has('publish')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('publish')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">               
                        <div class="tools">
                            <label class="label-above">ISBN</label>                                                   
                        </div>
                        <input type="<?php echo e("text"); ?>" class="form-control base_info" id="isbn" name="isbn" value="<?php echo e(old('isbn')!='' ? old('isbn'):( isset($book)? $book->isbn: '')); ?>">
                        <?php if($errors->has('isbn')): ?>
                        <span class="form-control-feedback" style="color:red">
                            <span><?php echo e($errors->first('isbn')); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->max_rows); ?></td>
                            <th class="col-md-2 text-md-center align-middle">1行字数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->max_chars); ?></td>
                            <th class="col-md-2 text-md-center align-middle">本文ページ数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->pages); ?></td>
                            <th class="col-md-2 text-md-center align-middle"></th><td class="col-md-1 text-md-center align-middle"></td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">空白のページ数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->entire_blanks); ?></td>
                            <th class="col-md-2 text-md-center align-middle">3/4空白頁数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->quarter_filled); ?></td>
                            <th class="col-md-2 text-md-center align-middle">1/2空白頁数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->half_blanks); ?></td>
                            <th class="col-md-2 text-md-center align-middle">1/4空白頁数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->quarter_blanks); ?></td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">p30短行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->p30); ?></td>
                            <th class="col-md-2 text-md-center align-middle">p50短行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->p50); ?></td>
                            <th class="col-md-2 text-md-center align-middle">p70短行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->p70); ?></td>
                            <th class="col-md-2 text-md-center align-middle">p90短行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->p90); ?></td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center align-middle">p110短行数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->p110); ?></td>
                            <th class="col-md-2 text-md-center align-middle">総字数</th><td class="col-md-1 text-md-center align-middle"><?php echo e($book->total_chars); ?></td>
                            <th class="col-md-2 text-md-center align-middle">参考字数</th><td class="col-md-1 text-md-center align-middle" colspan="2">
                            <input type="text" class="form-control base_info" id="recog_total_chars" name="recog_total_chars" value="<?php echo e(old('recog_total_chars')!='' ? old('recog_total_chars'):( isset($book)? $book->recog_total_chars: '')); ?>" placeholder="<?php echo e($book->recog_total_chars); ?>"></td>
                            <td class="col-md-1 text-md-center"></td>
                        </tr>
                    </table>
                </div>

                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">登録者読Ｑネーム</th><td class="col-md-2 text-md-center" style="vertical-align:middle;"><?php if(isset($book->Register) && $book->Register !== null && $book->register_id != 0): ?> <?php echo e($book->Register->username); ?> <?php endif; ?></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">監修者読Ｑネーム</th><td class="col-md-2 text-md-center" style="vertical-align:middle;"><?php if(isset($book->Overseer)): ?><?php echo e($book->Overseer->username); ?><?php endif; ?></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">著者監修者</th><td class="col-md-2 text-md-center" style="vertical-align:middle;">
                                <input type="checkbox" id="author_overseer_flag" name="author_overseer_flag" class="form-control" <?php if($book->author_overseer_flag == 1): ?> checked <?php endif; ?>>
                           </td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;">保有クイズ数</th><td class="col-md-2 text-md-center" style="vertical-align:middle;"><?php echo e($book->ActiveQuizes->count()); ?></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;"></th><td class="col-md-2 text-md-center" style="vertical-align:middle;"></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle;"></th><td class="col-md-2 text-md-center" style="vertical-align:middle;"></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1 col-md-10">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-green">
                                    <th class="col-sm-1">№</th>
                                    <th class="col-sm-10">帯文</th>
                                    <th class="col-md-1"></th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center article_body">
                                 <?php $__currentLoopData = $book->Articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article_id=>$article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                 
                                <tr class="info">
                                    <td style="vertical-align:middle;"><?php echo e($article_id+1); ?></td>
                                    <td style="vertical-align:middle;"><?php echo e($article->content); ?></td>
                                    <td style="vertical-align:middle;">
                                        <a id = "<?php echo e($article->id); ?>" onclick="articledel(<?php echo e($article->id); ?>);">削除</a>
                                    </td>
                                </tr>   
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                           
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1 col-md-10">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-green">
                                    <th class="col-sm-1">№</th>
                                    <th class="col-sm-11">保有クイズ本文</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                                  <?php $__currentLoopData = $book->ActiveQuizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz_id=>$quize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                 
                                <tr class="info">
                                    <td style="vertical-align:middle;"><?php echo e($quiz_id+1); ?></td>
                                    <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<u style='text-decoration:underline;'>", $quize->question); $st = str_replace_first("#", "</u>", $st); 
                                                        $st = str_replace_first("＃", "<u style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</u>", $st);
                                                        for($i = 0; $i < 30; $i++) {
                                                            $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                            $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                        } 
                                                        echo $st  ?></td>
                                </tr>   
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                 
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-1"></div>
                    <div class="tab-content1">
                        <table class="table table-striped table-bordered table-hover data-table">
                            <thead>
                                <tr class="bg-blue">
                                    <th class="col-sm-6">表紙画像1</th>
                                    <th class="col-sm-6">表紙画像2</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                                <img src="<?php if($book->cover_img != null): ?> <?php echo e(url($book->cover_img)); ?> <?php endif; ?>" <?php if($book->url !== null && $book->url != ''): ?> onclick="javascript:location.href='<?php echo e(url($book->url)); ?>'" <?php endif; ?> alt=""/>
                                            </div>
                                            <div class="text-md-center"><span>&nbsp;<?php if($book->coverimg_date): ?>画像登録日 : <?php echo e($book->coverimg_date); ?><?php endif; ?></span></div>
                                            <div class="text-md-center">
                                                <span class="btn btn-file btn-primary">
                                                    <span class="fileinput-new">ファイルを選択</span>
                                                    <span class="fileinput-exists">変　更</span>
                                                    <input type="file" name="coverimg" >
                                                </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">キャンセル </a>
                                                <?php if($errors->has('filemaxsize')): ?>
                                                <span class="form-control-feedback">
                                                    <span><?php echo e($errors->first('filemaxsize')); ?></span>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <span style="color:red">表紙画像1のチェック</span>
                                            <input type="checkbox" class="form-control" id="coverimge_check" name="coverimge_check" <?php if($book->coverimge_check == 1): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="text-md-center"><span>&nbsp;</span></div>
                                            <div class="text-md-center">
                                                <span class="btn btn-file btn-primary">
                                                    <span class="fileinput-new">ファイルを選択</span>
                                                    <span class="fileinput-exists">変　更</span>
                                                    <input type="file" name="coverimg1" >
                                                </span>
                                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">キャンセル </a>
                                                <?php if($errors->has('filemaxsize1')): ?>
                                                <span class="form-control-feedback">
                                                    <span><?php echo e($errors->first('filemaxsize1')); ?></span>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <span style="color:red">表紙画像2のチェック</span>
                                            <input type="checkbox" class="form-control" id="coverimg_check2" name="coverimg_check2"  >
                                        </div>
                                    </td>
                                </tr>                                              
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="tab-content1">
                    <table class="table table-bordered">
                        <tr>
                            <th class="col-md-2 text-md-center">受検回数</th><td class="col-md-2 text-md-center"><?php echo e($book->TestedNums->count()); ?></td>
                            <th class="col-md-2 text-md-center">受検者実数</th><td class="col-md-2 text-md-center"><?php echo e($book->TestedRealNums->count()); ?></td>
                            <th class="col-md-2 text-md-center">合格者数</th><td class="col-md-2 text-md-center"><?php echo e($book->passedNums->count()); ?></td>
                        </tr>
                        <tr>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">帯文数</th><td class="col-md-2 text-md-center" style="vertical-align:middle"><?php echo e($book->Articles->count()); ?></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">良書認数</th><td class="col-md-2 text-md-center" style="vertical-align:middle"><?php echo e($book->angate); ?></td>
                            <th class="col-md-2 text-md-center" style="vertical-align:middle">前年度合格者数順位/全登録冊数</th><td class="col-md-2 text-md-center" style="vertical-align:middle"><?php echo e($book->Rank_tested_lastyear($book->id)); ?>/<?php echo e($book->Registered_book_counter()->count()); ?></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
        <div class="row" style="margin-top:8px">
            <div class="offset-md-4 col-md-1 text-md-right col-xs-4">
                <button type="button" class="btn btn-success save-continue" style="margin-bottom:8px">保　存</button>
            </div>
            <div class="offset-md-1 col-md-1 text-md-right col-xs-4">
                <button type="button" class="btn btn-danger delete-continue" style="margin-bottom:8px">削　除</button>
            </div>
            <div class="col-md-5 text-md-right col-xs-4">
                <a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
            </div>
        
        </div>
    </div>
</div>
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_text"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning confirm modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>
  </div>
</div>

<div id="bookdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_bookdel_text"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning bookdelete modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>
  </div>
</div>
<div id="alertSuccessModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong>成功</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_text1"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-info" >確　認</button>
        </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
<script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <script type="text/javascript">
        ComponentsDropdowns.init();
		$("#phone").inputmask("mask", {
            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
        });            
        $("#address4").inputmask("mask", {
            "mask":"999"
        });
        $("#address5").inputmask("mask", {
            "mask":"9999"
        });
        $(".save-continue").click(function(){
            $("#validate-form").submit();
        });

        $(".delete-continue").click(function(){
            $("#alert_bookdel_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_BOOK_DELETE']); ?>");
            $("#bookdelModal").modal();
        });

        $(".bookdelete").click(function() {
            $("#validate-form").attr("action", '<?php echo e(url("/admin/deletebookByAdmin")); ?>');
            $("#validate-form").submit();
        });

        var recommend = 0;
       
        $("select[name=recommend]").change(function(){
            var temp = $("select[name=recommend]").val();
            var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];

            if( temp != ""){
                recommend = pointarray[temp];
            }
            $("input[name=recommend_coefficient]").val(recommend);
            
        });

        $("#dqid").click(function () {
            var book_id = $("#id").val();
            location.href = `<?php echo e(url('book/${book_id}/detail')); ?>`
        })

        var articledel = function(delete_id){
            $("#delete_id").val(delete_id); 
            $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_DELETE']); ?>");
            $("#alertModal").modal();
        }
        $(".confirm").click(function() {
            var data = {_token: $('meta[name="csrf-token"]').attr('content') ,
                        book_id: <?php echo e($book->id); ?>,
                         delete_id: $("#delete_id").val()};
            
            $.ajax({
                type: "post",
                url: "<?php echo e(url('/admin/deletearticlebyadmin')); ?>",
                data: data,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },          
                success: function (response){
                    if(response.status == 'success'){
                        $(".article_body").html("");
                        var html = "";
                        var articles = response.articles;
                        for(var i=0; i < articles.length; i++){
                            html += "<tr class='info'><td style='vertical-align:middle;'>";
                            html += i+1;
                            html += "</td><td style='vertical-align:middle;'>";
                            html += articles[i]['content'];
                            html += "</td><td style='vertical-align:middle;'>";
                            html += "<a id = '";
                            html += articles[i]['id'] + "' onclick='articledel(";
                            html +=  articles[i]['id'] + ");'>削除</a></td></tr>";
                        } 
                        $(".article_body").html(html);
                        $("#alert_text1").html("<?php echo e(config('consts')['MESSAGES']['ARTICLE_DELETE_SUCCEED']); ?>");
                        
                    }
                    $("#alertSuccessModal").modal();
                }
            })
        });
        var handleDatePickers = function () {

            if (jQuery().datepicker) {
                $('.date-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    language: 'ja'
                });
            }
        }
        handleDatePickers();

	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>