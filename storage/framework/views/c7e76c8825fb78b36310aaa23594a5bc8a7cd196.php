<?php 
  if(Auth::check()&&Auth::user()->isTeacher()|| Auth::user()->isRepresen() || Auth::user()->isItmanager() || Auth::user()->isLibrarian() || Auth::user()->isOther()){
    $topmenu = config('consts')['TOP_MENU']['SECONDHEADER'];
  }
  
?>

<div class="header second">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation float-right font-transform-inherit">
          <ul >
            <?php $__currentLoopData = $topmenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(isset($menu['CHILD'])): ?>
                <li class="dropdown  <?php if(isset($page_info['top']) && $page_info['top'] == $key): ?> active <?php endif; ?>">
                  <a class="dropdown-toggle" data-toggle="dropdown"  href="javascript:;">
                   <?php echo e($menu['TITLE']); ?>

                  </a>
                  <ul class="dropdown-menu">
                    <?php $__currentLoopData = $menu['CHILD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="<?php if(isset($page_info['subtop']) && $page_info['subtop'] == $subkey): ?> active <?php endif; ?>"><a href="<?php echo e(url($submenu['LOCATION'])); ?>"><?php echo e($submenu['TITLE']); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </li>  
              <?php else: ?>
                <li class=" <?php if(isset($page_info['top']) && $page_info['top'] == $key): ?> active <?php endif; ?>"><a href="<?php echo e(url($menu['LOCATION'])); ?>"><?php echo e($menu['TITLE']); ?></a></li>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- END NAVIGATION -->
  </div>
</div>