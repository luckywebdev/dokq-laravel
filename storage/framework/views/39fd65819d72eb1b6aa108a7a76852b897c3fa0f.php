
<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/css/book/detail.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
    <style>
        .font_gogic{
            font-family:HGP明朝B; 
        }
        .bottom_ad a{
            padding-left: 0px;
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
                    > 本のページ
                </li>
            </ol>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <h3 class="page-title"></h3>

            <div class="row ">
                <div class="col-md-2">
                    <!-- <div>
                        <img class="img-thumbnail full-width" src="<?php if($book->cover_img !== null && $book->cover_img != ''): ?> <?php echo e(url($book->cover_img)); ?> <?php else: ?> <?php echo e(asset('/img/cover.png')); ?> <?php endif; ?>">
                    </div> -->

                    <div class="clearfix"></div>

                    <div class="margin-top-10" style="text-align: center">
                        <?php echo $advertise->book_page_top_left; ?>
                        <div class="col-md-12" style="font-size: 16px !important; margin-top: 10%; font-weight: bolder">
                            <?php echo $book->rakuten_url; ?><br>
                        </div>
                        <div class="col-md-12" style="font-size: 16px !important; font-weight: bolder; margin-top: 5%">
                            <?php echo $book->seven_net_url; ?><br>
                        </div>
                        <div class="col-md-12" style="font-size: 16px !important; font-weight: bolder; margin-top: 5%">
                            <?php echo $book->honto_url; ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="margin-top-10">
                        <div class="top-news">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    
                </div>

                <div class="col-md-5">
                    <form action="<?php echo e(url('/mypage/accept_quiz_list')); ?>" method="post" name="quizstore" id="quizstore">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="book_active" id="book_active" value="<?php echo e($book->active); ?>">
                        <input type="hidden" name="book_id" id="book_id" value="<?php echo e($book->id); ?>">
                        <input type="hidden" name="work_test" id="work_test" value="<?php if(isset($work_test)): ?><?php echo e($work_test); ?> <?php endif; ?>">
                        <input type="hidden" name="content" id="content" value="<?php if(isset($content)): ?><?php echo e($content); ?> <?php endif; ?>">
                        
                        <?php if(Auth::check() && (!Auth::user()->isGroup())): ?>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo e(Auth::id()); ?>">
                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="news-blocks blue1" style="max-height: 250px;">
                                            <div class="row">
                                                <div class="col-md-12 text-md-center" style="text-align:center;">
                                                    <h1 class=" font_gogic" style="margin-top:0px;vertical-align:top; color:black;font-family:HGP明朝B;" id="title_header"><?php echo e($book->title); ?></h1>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                    <h4 class="font_gogic" style="color:black;vertical-align:bottom;font-family:HGP明朝B;">
                                                        <a href="/book/search_books_byauthor?writer_id=<?php echo e($book->writer_id); ?>&fullname=<?php echo e($book->fullname_nick()); ?>" class="text-info font_gogic" style="vertical-align:middle;font-family:HGP明朝B;"><?php echo e($book->fullname_nick()); ?></a>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <span class="font_gogic" style="font-size:14px;color:black;vertical-align:bottom;font-family:HGP明朝B;">
                                                        (<?php echo e(($book->publish)); ?>)
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3" >
                                        <?php if($book->active >= 3 && $book->active < 6): ?>
                                            <label class="label font_gogic" style="color: #f00;font-size: 15px;font-family:HGP明朝B;">クイズ募集中</label>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-3" >
                                        <?php if($book->active == 3): ?>
                                            <?php if(Auth::user()->isOverseerAll() || Auth::user()->isAdmin()): ?>
                                                <label class="label font_gogic" style="color: #f00;font-size: 15px;font-family:HGP明朝B;">監修者募集中</label>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-7 bookdetail-layout1">
                                        <div class="col-md-12">
                                            <div class="row" style="background-image:url('/img/book_detail.png'); background-size: cover; padding-top: 12%; display: flex; justify-content: center">
                                                <?php echo $book->image_url; ?>
                                                <?php if($book->image_url === null || $book->image_url == ''): ?>
                                                    <div class="col-md-12" style="margin-top:70px;">
                                                        <div class="row" style="height:120px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;">
                                                                <h3 class=" font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;vertical-align:top;color:#337ab7;" id="sub_title_header"><?php echo e($book->title); ?></h3>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="height:50px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                                <h4 class="font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;vertical-align:top;">
                                                                    <a href="/book/search_books_byauthor?writer_id=<?php echo e($book->writer_id); ?>&fullname=<?php echo e($book->fullname_nick()); ?>" class="font_gogic" style="vertical-align:middle;font-family:HGP明朝B;"><?php echo e($book->fullname_nick()); ?></a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="height:50px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                                <span class="font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;font-size:14px;color:#337ab7;vertical-align:top;">
                                                                <?php echo e(($book->publish)); ?>

                                                                </span>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row" style="height:100px;background:#ffff00;color:#ff0000">
                                                <span class="font_gogic" style="padding-left:10px;font-family:HGP明朝B;">読者による帯文</span>
                                                <div class="row clearfix"></div>
                                                <table class="table table-no-border table-hover">
                                                    <tbody class="text-md-center">
                                                        <?php $index = 1; ?>
                                                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $articleDatum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($key == 3): ?>
                                                            <?php break; ?>@endbreak
                                                        <?php endif; ?>
                                                        <tr>
                                                            <td class="h5 font_gogic text-md-left bookdetail-font" style="font-family:HGP明朝B;padding-top:0px;padding-bottom:0px;padding-left:2px;padding-right:1px;<?php if($key==0): ?> <?php else: ?> font-size:12px;<?php endif; ?>" <?php if($is_checked == 1): ?> colspan="2"<?php endif; ?>><b><?php echo e($articleDatum->content); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            
                                                            <td style="padding-top:0px;padding-bottom:0px;">
                                                                <a href="<?php echo e(url('mypage/other_view/' . $articleDatum->register_id)); ?>" class="font_gogic" style="font-family:HGP明朝B;color:blue;<?php if($key==0): ?>font-size:15px;<?php else: ?> font-size:12px;<?php endif; ?>">
                                                                    <?php if($articleDatum->User->age() < 15): ?>
                                                                        中学生以下ー<?php echo e($index++); ?>

                                                                     <?php else: ?>
                                                                        <?php if($articleDatum->register_visi_type == 0): ?> 
                                                                            <?php if($articleDatum->User->role  != config('consts')['USER']['ROLE']['AUTHOR']): ?> 
                                                                                <?php echo e($articleDatum->User->fullname()); ?> 
                                                                            <?php else: ?> 
                                                                                <?php echo e($articleDatum->User->fullname_nick()); ?> 
                                                                            <?php endif; ?> 
                                                                        <?php else: ?> 
                                                                            <?php echo e($articleDatum->User->username); ?> 
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                     さん
                                                                </a>
                                                            </td>
                                                            
                                                            <td class="font_gogic" style="font-family:HGP明朝B;padding-top:0px;padding-bottom:0px;<?php if($key==0): ?>font-size:15px;<?php else: ?> font-size:12px;<?php endif; ?>"><b><?php echo e($articleDatum->vote_num); ?> いいね！</b></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row" style="height:20px;background:#000000;color:#ffffff;">
                                                <div class="col-md-12" style="padding-left:10px"  align="center">
                                                    <span class="text-md-center font_gogic" style="font-family:HGP明朝B;">読んで、合格して、帯文を投稿しよう！</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-md-right  margin-top-xs-10" >
                                        <div class="col-md-12" style="padding-right: 0px; padding-left: 0px">
                                            <?php if(Auth::check() && (!Auth::user()->isGroup()) && ($book->isAdult())  && Auth::user()->getEqualBooks($book->id) === null && !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1): ?>
                                                <?php if($book->active == 6 ): ?>
                                                    <?php if(Auth::user()->getBookyear($book->id) !== null): ?>
                                                    <span class="btn btn-warning margin-bottom-15 age_limit" style="width:100%;">この本を受検する</span>
                                                    <?php elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null): ?>
                                                    <span class="btn btn-warning margin-bottom-15 book_equal" style="width:100%;">この本を受検する</span>
                                                    <?php else: ?>
                                                    <button type="button" id="<?php echo e($book->id); ?>" class="test_btn btn btn-warning margin-bottom-15" style="width:100%;">この本を受検する</button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">この本を受検する</span>
                                                <?php endif; ?>
                                            <div class="clearfix"></div>
                                                <?php if($already == 1 || Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->isGroupSchoolMember()): ?>
                                                    <span class="btn btn-warning disabled margin-bottom-15" style="width:100%;">読みたい本に登録する</span>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-warning towishlist  margin-bottom-15" style="width:100%;">読みたい本に登録する</button>
                                                <?php endif; ?>    
                                            <?php else: ?>
                                            <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">この本を受検する</span>
                                            <div class="clearfix"></div>
                                                <?php if($already == 1 || Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->isGroupSchoolMember()): ?>
                                                    <span class="btn btn-warning disabled margin-bottom-15" style="width:100%;">読みたい本に登録する</span>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-warning towishlist  margin-bottom-15" style="width:100%;">読みたい本に登録する</button>
                                                <?php endif; ?>    
                                            <?php endif; ?>
                                            <div class="clearfix"></div>
                                            <?php if($book->active >= 3 && $book->active < 6): ?>
                                                <a href="<?php echo e(url('/quiz/make/caution1?book_id='.$book->id.'')); ?>" class="btn btn-warning margin-bottom-15" style="width:100%;">クイズを作る</a>
                                            <?php elseif($book->active == 6 && Auth::check() && (Auth::id() == $book->overseer_id || Auth::user()->isAdmin() || Auth::user()->fullname_nick() == $book->fullname_nick())): ?>
                                                <a href="<?php echo e(url('/quiz/make/caution1?book_id='.$book->id.'')); ?>" class="btn btn-warning margin-bottom-15" style="width:100%;">クイズを作る</a>
                                            <?php else: ?>
                                                <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">クイズを作る</span>
                                            <?php endif; ?>
                                            <?php if($book->active == 3): ?>
                                                <?php if(Auth::user()->isOverseerAll() || Auth::user()->isAdmin()): ?>
                                                    <div class="clearfix"></div>
                                                    <a href="<?php echo e(url('/mypage/demand_list?book_id='. $book->id)); ?>" class="btn btn-warning margin-bottom-15" style="width:100%;">監修者に応募する</a>
                                                <?php else: ?>
                                                    <div class="clearfix"></div>
                                                    <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">監修者に応募する</span>                        
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="clearfix"></div>
                                                <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">監修者に応募する</span>        
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                        <div class="col-md-12" style="margin-bottom:2px; margin-top: 5px" align="center">
                                            <span class="text-md-center font_gogic" style="font-size:16px;font-family:HGP明朝B;"><b>読者のコーナー</b><br></span>
                                            <span class="text-md-center font_gogic" style="font-size:14px;font-family:HGP明朝B;">おすすめ文を投稿して、この本に、あなたが帯をつけよう！</span>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                        <div class="col-md-12" style="padding-right: 0px; padding-left: 0px">
                                            <?php if(Auth::check() && (!Auth::user()->isGroup())): ?>
                                                <a class="btn btn-primary <?php if($is_checked == 0 || $is_passed == 0 || $is_article == 1): ?> disabled <?php endif; ?> margin-bottom-15" href="<?php echo e(url('book/'.$book->id.'/article/create')); ?>" style="width:100%;color:#fff;">帯文を投稿</a>
                                            <?php else: ?>
                                                <span class="btn btn-primary margin-bottom-15 disabled" style="width:100%;">帯文を投稿</span>
                                            <?php endif; ?>
                                                <div class="clearfix"></div>
                                            <?php if(Auth::check() && (!Auth::user()->isGroup())): ?>
                                                <a class="btn btn-primary margin-bottom-15 <?php if($is_checked == 0 || $is_passed == 0): ?> disabled <?php endif; ?>" href="<?php echo e(url('book/'.$book->id.'/article/create')); ?>" style="width:100%;color:#fff;">帯文に、いいね！</a>
                                            <?php else: ?>
                                                <span class="btn btn-primary margin-bottom-15 disabled" style="width:100%;">帯文に、いいね！</span>
                                            <?php endif; ?>
                                            <div class="clearfix"></div>
                                            <a class="btn btn-primary" href="<?php echo e(url('book/'.$book->id.'/article/create')); ?>" style="width:100%;">もっと見る</a>    
                                        </div>
                                    </div>
                                </div>
                            
                        <?php elseif(!Auth::check()): ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="news-blocks blue1" style="max-height: 250px;">
                                        <div class="row">
                                            <div class="col-md-12 text-md-center">
                                                <h1 class=" font_gogic" style="margin-top:0px;vertical-align:top; color:black;font-family:HGP明朝B;" id="title_header"><?php echo e($book->title); ?></h1>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                <h4 class="font_gogic" style="color:black;vertical-align:bottom;font-family:HGP明朝B;">
                                                    <a href="/book/search_books_byauthor?writer_id=<?php echo e($book->writer_id); ?>&fullname=<?php echo e($book->fullname_nick()); ?>" class="text-info font_gogic" style="vertical-align:middle;font-family:HGP明朝B;"><?php echo e($book->fullname_nick()); ?></a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span class="font_gogic" style="font-size:14px;color:black;vertical-align:bottom;font-family:HGP明朝B;">
                                                    (<?php echo e(($book->publish)); ?>)
                                                    </span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3" >
                                    <?php if($book->active >= 3 && $book->active < 6): ?>
                                        <label class="label font_gogic" style="color: #f00;font-size: 15px;font-family:HGP明朝B;">クイズ募集中</label>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3" >
                                    <?php if($book->active == 3): ?>
                                        <label class="label font_gogic" style="color: #f00;font-size: 15px;font-family:HGP明朝B;">監修者募集中</label>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-7 bookdetail-layout1" >
                                    <div class="col-md-12">
                                            <div class="row"style="background-image:url('/img/book_detail.png'); background-size: cover; padding-top: 12%;  display: flex; justify-content: center">
                                                <?php echo $book->image_url; ?>
                                                <?php if($book->image_url === null || $book->image_url == ''): ?>
                                                    <div class="col-md-12" style="margin-top:70px;">
                                                        <div class="row" style="height:120px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;">
                                                                <h3 class=" font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;vertical-align:top;color:#337ab7;" id="sub_title_header"><?php echo e($book->title); ?></h3>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="height:50px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                                <h4 class="font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;vertical-align:top;">
                                                                    <a href="/book/search_books_byauthor?writer_id=<?php echo e($book->writer_id); ?>&fullname=<?php echo e($book->fullname_nick()); ?>" class="font_gogic" style="vertical-align:middle;font-family:HGP明朝B;"><?php echo e($book->fullname_nick()); ?></a>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="height:50px;">
                                                            <div class="col-md-12 text-md-center" style="text-align:center;" >
                                                                <span class="font_gogic" style="font-family:HGP明朝B;margin-top:0px;margin-left:25px;margin-right:25px;font-size:14px;color:#337ab7;vertical-align:top;">
                                                                <?php echo e(($book->publish)); ?>

                                                                </span>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row" style="height:100px;background:#ffff00;color:#ff0000">
                                                <span class="font_gogic" style="font-family:HGP明朝B;padding-left:10px">読者による帯文</span>
                                                <div class="row clearfix"></div>
                                                <table class="table table-no-border table-hover">
                                                    <tbody class="text-md-center">
                                                        <?php $index = 1; ?>
                                                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $articleDatum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($key == 3): ?>
                                                            <?php break; ?>@endbreak
                                                        <?php endif; ?>
                                                        <tr>
                                                            <td class="h5 font_gogic text-md-left bookdetail-font" style="font-family:HGP明朝B;padding-top:0px;padding-bottom:0px;padding-left:2px;padding-right:1px;<?php if($key==0): ?> <?php else: ?> font-size:12px;<?php endif; ?>" colspan="2"><b><?php echo e($articleDatum->content); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                        
                                                            <td style="padding-top:0px;padding-bottom:0px;">
                                                                <a href="<?php echo e(url('mypage/other_view/' . $articleDatum->register_id)); ?>" class="font_gogic" style="font-family:HGP明朝B;color:blue;<?php if($key==0): ?>font-size:15px;<?php else: ?> font-size:12px;<?php endif; ?>">
                                                                    <?php if($articleDatum->User->age() < 15): ?>
                                                                        中学生以下ー<?php echo e($index++); ?>

                                                                    <?php else: ?>
                                                                        <?php if($articleDatum->register_visi_type == 0): ?> 
                                                                            <?php if($articleDatum->User->role  != config('consts')['USER']['ROLE']['AUTHOR']): ?> 
                                                                                <?php echo e($articleDatum->User->fullname()); ?> 
                                                                            <?php else: ?> 
                                                                                <?php echo e($articleDatum->User->fullname_nick()); ?> 
                                                                            <?php endif; ?> 
                                                                        <?php else: ?> 
                                                                            <?php echo e($articleDatum->User->username); ?> 
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                     さん
                                                                </a>
                                                            </td>
                                                            
                                                            <td class="font_gogic" style="font-family:HGP明朝B;padding-top:0px;padding-bottom:0px;text-align:center;<?php if($key==0): ?>font-size:15px;<?php else: ?> font-size:12px;<?php endif; ?>"><b><?php echo e($articleDatum->vote_num); ?> いいね！</b></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row" style="height:20px;background:#000000;color:#ffffff;">
                                                <div class="col-md-12" style="padding-left:10px"  align="center">
                                                    <span class="text-md-center font_gogic" style="font-family:HGP明朝B;">読んで、合格して、帯文を投稿しよう！</span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-5 text-md-right margin-top-xs-10" >
                                    <div class="col-md-12" style="padding-right: 0px; padding-left: 0px">
                                        <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">この本を受検する</span>
                                        <div class="clearfix"></div>
                                        <span class="btn btn-warning disabled margin-bottom-15" style="width:100%;">読みたい本に登録する</span>
                                        <div class="clearfix"></div>
                                        <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">クイズを作る</span>
                                        <div class="clearfix"></div>
                                            <span class="btn btn-warning margin-bottom-15 disabled" style="width:100%;">監修者に応募する</span>                        
                                        <div class="clearfix"></div>
                                        <div class="col-md-12" style="margin-bottom:2px; margin-top:5px" align="center">
                                            <span class="text-md-center font_gogic" style="font-size:16px;font-family:HGP明朝B;"><b>読者のコーナー</b><br></span>
                                            <span class="text-md-center font_gogic" style="font-size:14px;font-family:HGP明朝B;">おすすめ文を投稿して、この本に、あなたが帯をつけよう！</span>
                                        </div>
                                        <span class="btn btn-primary margin-bottom-15 disabled" style="width:100%;">帯文を投稿</span>
                                        <div class="clearfix"></div>
                                        <span class="btn btn-primary margin-bottom-15 disabled" style="width:100%;">帯文に、いいね！</span>
                                        <div class="clearfix"></div>
                                        <span class="btn btn-primary margin-bottom-15 disabled" style="width:100%;">もっと見る</a>    
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row" style="padding-top:10px">
                            <div class="col-md-12">
                                <div class="news-blocks lime" style="max-height: 250px;">
                                    <div class="scroller" style="height:230px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                        <div class="row">
                                            <h3 class="text-md-left col-md-8">人気本ランキング順位</h3>
                                            <h6 class="text-md-right col-md-4">読Qデータ1</h6>
                                        </div>
                                        <br>
                                        <h4><?php echo e($popular_rank1); ?>位/<?php echo e($total1); ?>冊（昨年度）</h4>
                                        <h4><?php echo e($popular_rank); ?>位/<?php echo e($total2); ?>冊（累計）</h4>
                                        <br>
                                        <p style="font-size:18px">この本が最も読まれた年代とその前後の年代の人に読まれた本ランキングの順位です。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="portlet box green">
                                        <div class="portlet-title">
                                            <span class="caption caption-md">
                                                この本を読んだときの年齢グラフ
                                            </span>
                                        </div>
                                        <div class="portlet-body col-md-12" style="padding-left:0px;">
                                            
                                            <canvas id="bar" width="517" height="230" style="width: 517px; height: 230px;"></canvas>
                                            <div class="legend">
                                                <div style="position: absolute; width: 49px; height: 40px; top: 14px; right: 13px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
                                                <table style="position:absolute;top:14px;right:13px;;font-size:smaller;color:#545454">
                                                <tbody>
                                                <tr>
                                                <td class="legendColorBox">
                                                <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #ff66cc;overflow:hidden">
                                                    
                                                </div>
                                                </div>
                                                </td>
                                                <td class="legendLabel">女性</td>
                                                </tr>
                                                <tr>
                                                <td class="legendColorBox">
                                                <div style="border:1px solid #ccc;padding:1px">
                                                <div style="width:4px;height:0;border:5px solid #4a7ebb;overflow:hidden">
                                                    
                                                </div>
                                                </div>
                                                </td>
                                                <td class="legendLabel">男性</td>
                                                </tr>
                                                </tbody></table>
                                            </div>
                                            <div style = 'font-size:8px;position:absolute;left:15px;top:0px;text-align:center'>(人)</div>
                                        </div>
                                    </div>
                                </div>
                        </div>    
                    </form>
                </div>

                <div class="col-md-5">
                    <div class="hidden-xs-down">
                        <?php echo $advertise->book_page_top_right; ?>
                    </div>

                    <div class="row" style="margin-top: 40px;">
                        <div class="col-md-6 column">
                            <div class="news-blocks lime" style="max-height: 200px;">
                                <div class="scroller" style="height:180px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <p class="text-md-right">読Qデータ2</p>
                                    <h4 class="text-md-left">読Q本ポイント：<?php echo e(floor($book->point * 100) / 100); ?><br><small style="color:gray">（合格すると得られるポイント）</small></h4>
                                    <p style="font-size:16px;"><?php echo e($quizCnt); ?>問中<?php echo e(round($quizCnt* 0.8, 0)); ?>問正解で合格</p>
                                    <p style="font-size:16px;">昨年度合格者　<?php echo e($passCnt1); ?>人</p>
                                    <p style="font-size:16px;">累計合格者   <?php echo e($passCnt2); ?>人</p>
                                </div>
                            </div>

                            <div class="news-blocks lime" style="max-height: 400px;">
                                <div class="scroller" style="height:380px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <p class="text-md-right">読Qデータ3</p>

                                    <table class="table table-no-border">
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">分類：
                                                <?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key + 1 == count($book->categories)): ?>
                                                        <?php echo e($category->name); ?>

                                                    <?php else: ?>
                                                        <?php echo e($category->name); ?>、
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">本の登録者：
                                            <a href="<?php echo e(url('mypage/other_view/' . $book->register_id)); ?>"><?php echo e($book->RegisterShow()); ?></a></td>
                                        </tr>
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">監修者：
                                            <?php if($book->author_overseer_flag == 1): ?>
                                            <a href="<?php echo e(url('mypage/other_view/' . $book->writer_id)); ?>">著者</a>
                                            <?php endif; ?> 
                                            <?php if($overseer !== null): ?>
                                                <?php if($book->author_overseer_flag == 1): ?>、<?php endif; ?>
                                            <a href="<?php echo e(url('mypage/other_view/' . $overseer->id)); ?>">
                                            <?php if($overseer->role != config('consts')['USER']['ROLE']['AUTHOR']){
                                                        if($overseer->fullname_is_public) 
                                                            $title = $overseer->fullname(); 
                                                        else $title = $overseer->username; 
                                                    }else{
                                                        if($overseer->fullname_is_public) 
                                                            $title = $overseer->fullname_nick();
                                                        else $title = $overseer->username; 
                                                    } 
                                                    echo $title;?> 
                                            </a>
                                            <?php endif; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">クイズ作成者：
                                            <?php $__currentLoopData = $quizMaker_ary; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(url('mypage/other_view/' . $value[1])); ?>"><?php echo e($value[0]); ?></a>
                                                <?php if($key < count($quizMaker_ary)-1): ?>
                                                    、
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">推奨年代：<?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="margin-top:0px;padding:0px;padding-right:2px;font-size:16px;">読Q登録日：<?php echo e($book->created_at->format('Y年n月d日')); ?></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="news-blocks lime" style="max-height: 200px;">
                                <div class="scroller" style="height:180px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <p class="text-md-right">読Qデータ４</p>
                                    <p style="font-size:14px;margin-bottom:5px;">「この本は、みんなにおすすめしたい、良い本です。」と、言っている人の数</p>
                                    <p style="font-size:16px;text-align:center;margin-bottom:5px;"><strong><?php echo e($wishCount); ?>人</strong></p>
                                    <p style="font-size:14px"><?php if($book->recommend_flag !== null && $book->recommend_flag != '0000-00-00'): ?>★この本は、読Q推薦図書に指定されています。<?php endif; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 column">
                            <div class="news-blocks" >
                                <div data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <p class="text-md-right">マイデータ</p>
                                    <p style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;" <?php if(!Auth::check() || Auth::user()->isTestOfBook($book->id)): ?> class="font-grey" <?php endif; ?> >●　未受検。まだ読んでいない。</p>
                                    <p <?php if($is_passed == 0): ?> class="font-grey" <?php endif; ?> style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;">●　この本の合格を公開中</p>
                                    <p <?php if($is_passed == 0): ?> class="font-grey" <?php endif; ?> style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;">
                                     ●　<?php if($is_passed == 0): ?> 〇年〇月〇日に合格。
                                     <?php else: ?> <?php echo e(date_format(date_create(Auth::user()->getDateTestPassedOfBook($book->id)), "Y年m月d日に合格。")); ?>

                                     <?php endif; ?>
                                    </p>
                                    <p <?php if(!Auth::check() || !Auth::user()->isQuizMaker($book->id)): ?> class="font-grey" <?php endif; ?> style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;">●　この本のクイズ作成者</p>
                                    <p <?php if(!Auth::check() || !Auth::user()->isOverseerOfBook($book->id)): ?> class="font-grey" <?php endif; ?> style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;">●　この本の監修者</p>
                                    <p <?php if(!Auth::check() || !Auth::user()->isWisher($book->id) || Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->isGroupSchoolMember()): ?> class="font-grey" <?php endif; ?> style="margin-left:10px;margin-top:5px;margin-bottom:0px;font-size:15px;">●　読みたい本に登録中</p>
                                </div>
                            </div>
                            
                            
                            <div class="news-blocks" style="max-height: 200px;">
                                <div class="scroller" style="height:180px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                    <p class="text-md-right">書籍データ</p>
                                    <table class="table table-no-border">
                                        <tr>
                                            <td style="padding-top:5px;padding-right:2px;font-size:16px">タイトル：<?php echo e($book->title); ?>

                                        </tr>
                                        <tr>
                                            <td style="padding-top:5px;padding-right:2px;font-size:16px">著者：<?php echo e($book->fullname_nick()); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:5px;padding-right:2px;font-size:16px">出版社：<?php echo e($book->publish); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding-top:5px;padding-right:2px;font-size:16px">読Q本ID: dq<?php echo e($book->id); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            
                            <div class="top-news bottom_ad">
                                <?php echo $advertise->book_page_bottom_right; ?>
                            </div>
                            <a href="<?php echo url('book').'/'.$book->id.'/search_passer'; ?>" class="btn btn-warning pull-left"<?php if(!Auth::check() ): ?> disabled <?php endif; ?>>この本の読Q合格者を検索</a>
                            <div class="clearfix"></div>
                            <div style="margin-top:10px;">
                                <button type="button" class="btn btn-success pull-left <?php if(!Auth::check() || (!Auth::user()->isAdmin() && !Auth::user()->isOverseerOfBook($book->id) && !Auth::user()->isQuizMaker($book->id))): ?> disabled <?php endif; ?>" >Quiz ストック</button>
                            </div>
                            <div class="socio-icons-wrapper">
                                <ul class="nav justify-content-center socio-icons">
                                    <li class="nav-item">
                                        <a class="nav-link" href="http://www.facebook.com/share.php?u=https://dokq.org/book/<?php echo $book->id; ?>/detail" rel="nofollow" target="popup" onclick="window.open('http://www.facebook.com/share.php?u=https://dokq.org/book/<?php echo $book->id; ?>/detail','popup','width=600,height=600'); return false;" style="cursor: pointer; box-shadow: none;"><i class="fa fa-2x fa-facebook"></i></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://twitter.com/intent/tweet?url=https://dokq.org/book/<?php echo $book->id?>/detail&text=読Ｑ本ページをご覧ください！&hashtags=読Q,読Q本&via=dokq_orgさんから" class="nav-link" rel="nofollow" target="popup" onclick="window.open('https://twitter.com/share?url=https://dokq.org/book/<?php echo $book->id?>/detail&text=読Ｑ本ページをご覧ください！&hashtags=読Q,読Q本&via=dokq_orgさんから','popup','width=600,height=600'); return false;" style="cursor: pointer; box-shadow: none;" ><i class="fa fa-2x fa-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- <div class="shareaholic-canvas" data-app="recommendations" data-app-id="28378626"></div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn pull-right btn-info" onclick="javascript:history.go(-1)">戻　る</button>
                </div>
            </div>
        </div>
    </div>
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><strong>エラー</strong></h4>
            </div>
            <div class="modal-body">
              <p>この本は年齢制限のある本なので、受検できません。</p>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="passModal" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><strong>エラー</strong></h4>
            </div>
            <div class="modal-body">
              <p>この本は、すでに合格していますので、受検できません。</p>
            </div>
            <div class="modal-footer">
              <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
            </div>
          </div>
        </div>
      </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.resize.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.pie.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.stack.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.crosshair.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/flot/jquery.flot.categories.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/Charts.js')); ?>"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="<?php echo e(asset('js/charts/Chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/charts-flotcharts.js')); ?>"></script>

    <script>
        jQuery(document).ready(function() {
            $('body').addClass('page-full-width');
            ChartsFlotcharts.initBarCharts();
            var title_header = $("#title_header").text().length;
            var sub_title_header = $("#sub_title_header").text().length;
            if(title_header > 10 && title_header <= 12){
                $("#title_header").css('font-size', '30px');
            }
            else if(title_header > 12 && title_header <= 15){
                $("#title_header").css('font-size', '22px');
            }
            else if(title_header > 15){
                $("#title_header").css('font-size', '20px');
            }
            if(sub_title_header > 8 && sub_title_header <= 10){
                $("#sub_title_header").css('font-size', '22px');
            }
            else if(sub_title_header > 10 && sub_title_header <= 12){
                $("#sub_title_header").css('font-size', '18px');
            }
            else if(sub_title_header > 12 && sub_title_header <= 16){
                $("#sub_title_header").css('font-size', '14px');
            }
            else if(sub_title_header > 16){
                $("#sub_title_header").css('font-size', '12px');
            }
            $(".btn-success").click(function() {
                //if($("#book_active").val() == 6) {

                   // location.href="/mypage/accept_quiz_list/" + $("#book_id").val();
                //} else {
                 //   location.href="/mypage/acceptable_quiz_list/" + $("#book_id").val();
               // }

               $("#quizstore").submit();
            });

            $(".test_btn").click(function() {
                $("#quizstore").attr("action", "<?php echo url('book/test') ?>");
                   $("#quizstore").attr("method", "post");
                   $("#quizstore").submit();
            });

            $(".age_limit").click(function() {
                $('#myModal').modal('show');
            });
            $(".book_equal").click(function() {
                $('#passModal').modal('show');
            });
        });  

        var barChartData = {
            labels : ["未就学児","小学校低学年","小学校中学年","小学校高学年","中学生","十代後半","二十代","三十代","四十代","五十代","六十代","七十代","八十代以上"],
            datasets : [
            
                {
                    
                    fillColor : "#ff66cc",
                    strokeColor : "#f8cbad",
                    data : [<?php echo e($female[0][0]->number); ?>,<?php echo e($female[1][0]->number); ?>,<?php echo e($female[2][0]->number); ?>,<?php echo e($female[3][0]->number); ?>,<?php echo e($female[4][0]->number); ?>,<?php echo e($female[5][0]->number); ?>,<?php echo e($female[6][0]->number); ?>,<?php echo e($female[7][0]->number); ?>,<?php echo e($female[8][0]->number); ?>,<?php echo e($female[9][0]->number); ?>,<?php echo e($female[10][0]->number); ?>,<?php echo e($female[11][0]->number); ?>,<?php echo e($male[12][0]->number); ?>]
                },
                {
                    fillColor : "#4a7ebb",
                    strokeColor : "#d0cece",
                    
                    data : [<?php echo e($male[0][0]->number); ?>,<?php echo e($male[1][0]->number); ?>,<?php echo e($male[2][0]->number); ?>,<?php echo e($male[3][0]->number); ?>,<?php echo e($male[4][0]->number); ?>,<?php echo e($male[5][0]->number); ?>,<?php echo e($male[6][0]->number); ?>,<?php echo e($male[7][0]->number); ?>,<?php echo e($male[8][0]->number); ?>,<?php echo e($male[9][0]->number); ?>,<?php echo e($male[10][0]->number); ?>,<?php echo e($male[11][0]->number); ?>,<?php echo e($male[12][0]->number); ?>]
                    
                }
            ]
            
        };
        new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
        
        $('.towishlist').click(function(){
            var info = {
                user_id: $("#user_id").val(),
                book_id: $("#book_id").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            }
            $.ajax({
                type: "post",
                  url: "<?php echo e(url('/book/regWishlist')); ?>",
                data: info,
                
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf-token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },            
                success: function (response){
                    if(response.status == 'success'){
                        $(".towishlist").addClass('disabled');
//                        $('.towishlist').removeClass('towishlist');

                        $("#confirmModal").modal('show');    
                    }else if(response.status == 'failed'){
//                        bootboxNotification(response.message)
                        $("#confirmModal1").modal('show');
                    }
                    
                }
            });    
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>