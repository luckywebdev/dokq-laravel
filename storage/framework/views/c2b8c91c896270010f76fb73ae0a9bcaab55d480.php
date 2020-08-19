<?php 
	$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
	if(Auth::check()&&Auth::user()->isGroup()){
		$sidemenu = config('consts')['SIDE_MENU']['GROUP'];
	}else if(Auth::check() && Auth::user()->isTeacher()){
		$sidemenu = config('consts')['SIDE_MENU']['TEACHER'];
	}else if(Auth::check() && Auth::user()->isRepresen()){
		$sidemenu = config('consts')['SIDE_MENU']['REPRESEN'];
	}else if(Auth::check() && Auth::user()->isItmanager()){
		$sidemenu = config('consts')['SIDE_MENU']['ITMANAGER'];
	}else if(Auth::check() && Auth::user()->isOther()){
		$sidemenu = config('consts')['SIDE_MENU']['OTHER'];
	}else if(Auth::check()&&Auth::user()->isAdmin()){
		$sidemenu = config('consts')['SIDE_MENU']['ADMIN'];
	}
	if(Auth::check()&&$page_info['top'] == 'mypage'){
		if (Auth::user()->isOverseer() || Auth::user()->isAdmin()) {
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_OVERSEER'];
        }else if (Auth::user()->isAuthor()) {
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_AUTHOR'];
        }else if(Auth::user()->isSchoolMember()){
            $sidemenu = config('consts')['SIDE_MENU']['MYPAGE_TEACHER'];
		}else if(Auth::user()->isGeneral()){
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
		}else if(Auth::user()->isPupil()){
			if(Auth::user()->active == 1)
				$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_PUPIL'];
			else
				$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
		}	
	} else if(isset($page_info) && $page_info['top'] == 'about'){
		$sidemenu = config('consts')['SIDE_MENU']['ABOUT'];	
	}
?>
<div class="page-sidebar-wrapper" >
	<div class="page-sidebar navbar-collapse">
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"></div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <?php if(isset($sidemenu) && $sidemenu): ?>
			<?php $__currentLoopData = $sidemenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(isset($menu['CHILD'])): ?>
				    <?php if($menu['TITLE'] == '試験監督をする' && Auth::check() && Auth::user()->age() <= 20): ?> 
				    <?php else: ?>
					<li class="<?php echo e(isset($page_info) ? $page_info['side'] == $key ? 'active open':'':''); ?>">
						<a href="javascript:;">
						<i class="<?php echo e($menu['ICON']); ?>"></i>
						<span class="title"><?php echo e($menu['TITLE']); ?></span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							<?php $__currentLoopData = $menu['CHILD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li class="<?php echo e(isset($page_info) ? $page_info['subside'] == $subkey ? 'active':'':''); ?>">
									<a href="<?php echo e(url('/').$submenu['LOCATION']); ?>" <?php if($submenu['TITLE'] == '試験監督適性検査' && Auth::check()): ?> style="pointer-events:none;" <?php endif; ?>>
									<i class="<?php echo e($submenu['ICON']); ?>"></i>
									<?php echo $submenu['TITLE'] ?>
								</a>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
					<?php endif; ?>
				<?php else: ?>
					<li class="<?php echo e(isset($page_info) ? $page_info['side'] == $key ? 'active':'':''); ?>">
						<a href="<?php echo e(url('/').$menu['LOCATION']); ?>">
						<i class="<?php echo e($menu['ICON']); ?>"></i>
						<span class="title">
							<?php echo $menu['TITLE'] ?>
						</span>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>