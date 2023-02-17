<?php
    if(Auth::guest()){
        $topmenu = config('consts')['TOP_MENU']['BEFORE']; 
    } else{
        $topmenu = array();
    }
    $title = '読書認定級';

    if(Auth::check()&&Auth::user()->isAdmin()){
        $topmenu = config('consts')['TOP_MENU']['ADMIN'];
    } else if(Auth::check()&&Auth::user()->isGroup()){
        $topmenu = config('consts')['TOP_MENU']['GROUP'];
    }else if(Auth::check()&&Auth::user()->isTeacher()){
        if(Auth::user()->active == 1 && Session::has('teacher_auth') && Session::get('teacher_auth') == 1)
            $topmenu = config('consts')['TOP_MENU']['TEACHER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_TEACHER'];
    }else if(Auth::check()&&Auth::user()->isLibrarian()){
        $topmenu = config('consts')['TOP_MENU']['LIBRARIAN'];
    }else if(Auth::check()&&Auth::user()->isRepresen()){
       
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['REPRESEN'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_REPRESEN'];
    }else if(Auth::check()&&Auth::user()->isItmanager()){
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['ITMANAGER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_ITMANAGER'];
    }else if(Auth::check()&&Auth::user()->isOther()){
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['OTHER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_OTHER'];
    }else{
        $topmenu = config('consts')['TOP_MENU']['COMMON'];
    }
    $helpmenu = config('consts')['TOP_MENU']['HELP'];
    $topmenu = array_merge($topmenu, $helpmenu);
?>
<!-- Icon Section Start -->
<div class="header-section" style="margin-bottom: 0 !important;">
    <div class="container">
        <ul class="list-inline">
            <li class="page-logo">
                <a class="text-md-center" href="<?php echo e(url('/')); ?>">
                    <img class="logo_img" src="<?php echo e(asset('img/logo_img/logo3.png')); ?>">
                    <!-- <h1 style="margin: 0 !important; color:white; font-family: 'Ms Mincho', 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN', 'Roboto Serif' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', 'Maven Pro', sans-serif !important;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1> -->
                    <!-- <h6 style="margin: 0 !important; color:darkgray; font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif;"><?php echo e($title); ?></h6> -->
                </a>
            </li>
            <li class="pull-right" style="margin-top: 10px;">
                <ul class="list-inline">
                    <li>
                        <?php if(Auth::check() && Auth::user()->isGroup()): ?>
                        <a href="/top" class="text-white">
                            <?php echo e(Auth::user()->group_name); ?>

                        </a>
                        <?php endif; ?>
                        <?php if(Auth::check() && Auth::user()->isSchoolMember()): ?>
                        <a href="/top" class="text-white">
                            <?php if(Auth::user()->isLibrarian() && Auth::user()->active == 1): ?>
                                <?php if(Auth::user()->org_id != 0 && !is_null(Auth::user()->School())): ?>
                                    <?php echo e(Auth::user()->School->group_name); ?>

                                <?php else: ?>

                                <?php endif; ?>
                            <?php elseif(Auth::user()->active == 2): ?>
                                
                            <?php else: ?>
                                <?php echo e(Auth::user()->School->group_name); ?>

                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                    </li>

                    <?php if(auth()->guard()->guest()): ?>
                    <li><a class="nav-link text-white" href="<?php echo e(route('auth/login')); ?>">ログイン</a></li>
                    <li><a class="nav-link text-white" href="<?php echo e(route('auth/register')); ?>">新規登録</a></li>
                    <?php else: ?>
                    <li>
                        <?php if( Auth::user()->isGroup() ): ?>
                        <?php elseif( Auth::user()->isAdmin() ): ?>
                        <a class="nav-link text-white" href="<?php echo e(url('/mypage/top')); ?>">
                            <?php echo e(Auth::user()->username); ?>

                        </a>
                        <?php else: ?>
                        <a class="nav-link text-white" href="<?php echo e(url('mypage/top')); ?>">
                            <?php if( !Auth::user()->isGeneral() ): ?> <?php echo e(config('consts')['USER']['TYPE'][Auth::user()->role]); ?>  <?php endif; ?>
                            <?php if(Auth::user()->active == 2): ?>
                                準会員
                            <?php endif; ?>
                            <span class="display_name margin-left-20">
                            <?php if(Auth::user()->role != config('consts')['USER']['ROLE']['AUTHOR']): ?>
                                <?php if(Auth::user()->fullname_is_public): ?> 
                                <?php echo e(Auth::user()->fullname()); ?> 
                                <?php else: ?> <?php echo e(Auth::user()->username); ?> 
                                <?php endif; ?>
                            
                            <?php else: ?>
                                <?php if(Auth::user()->fullname_is_public): ?> 
                                <?php echo e(Auth::user()->fullname_nick()); ?> 
                                <?php else: ?> <?php echo e(Auth::user()->username); ?> 
                                <?php endif; ?>
                            <?php endif; ?>
                            </span>
                        </a>
                        <?php endif; ?>

                    </li>
                    <li>
                        <a class="nav-link text-white" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();localStorage.removeItem('certi_list');document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="get" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php if(Auth::check() && !Auth::user()->isGroup() && !Auth::user()->isAdmin() && $page_info['top'] == "mypage" && $page_info['subside'] == "top"): ?>
                <ul class="list-inline">
                    <li>
                        <label class="control-label text-white">表示名 :</label>
                        <input type="checkbox" class="form-control" id="fullname_is_public1" name="fullname_is_public1" uid="<?php echo e(Auth::id()); ?>" value="0" <?php if(Auth::user()->fullname_is_public == 0): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                        <label class="control-label text-white">読Qネーム</label>
                        <input type="checkbox" class="form-control" id="fullname_is_public2" name="fullname_is_public2" uid="<?php echo e(Auth::id()); ?>" value="1" <?php if(Auth::user()->fullname_is_public == 1): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                        <?php if(Auth::user()->role != 3): ?>
                            <label class="control-label text-white">本名</label>
                        <?php else: ?>
                            <label class="control-label text-white">筆名</label>
                        <?php endif; ?>
                        <label class="_result"></label>
                    </li>
                </ul>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<!-- //Icon Section End -->
<!-- Nav bar Start -->
<nav class="navbar navbar-default container" style="padding-bottom: 0px;padding-right:0px;min-height:30px;">
    <div id="collapse">
        <ul class="nav navbar-nav navbar-right" style="flex-direction: row;margin-right:0px;height:30px;">
            <?php $__currentLoopData = $topmenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($menu['CHILD'])): ?>
                    <li class="dropdown  <?php if(isset($page_info['top']) && $page_info['top'] == $key): ?> active <?php endif; ?>">
                        
                        <a class="dropdown-toggle" style="padding-top:0px;padding-left:5px;padding-right:5px;padding-bottom:0px; color:white;text-align:center"  data-toggle="dropdown"  href="javascript:;">
                            <?php echo e($menu['TITLE']); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <?php $__currentLoopData = $menu['CHILD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="<?php if(isset($page_info['subtop']) && $page_info['subtop'] == $subkey): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(url('/').$submenu['LOCATION']); ?>"><?php echo e($submenu['TITLE']); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>  
                <?php else: ?>
                    <li class=" <?php if(isset($page_info['top']) && $page_info['top'] == $key): ?> active <?php endif; ?>" >
                        
                        <a href="<?php echo e(url('/').$menu['LOCATION']); ?>" style="padding-top:0px;padding-left:5px;padding-right:5px;padding-bottom:0px; color:white;text-align:center"><?php echo e($menu['TITLE']); ?></a>
                    </li>
                <?php endif; ?>
               
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</nav>
