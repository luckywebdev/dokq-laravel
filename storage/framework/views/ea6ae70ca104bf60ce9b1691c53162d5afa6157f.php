<?php $__env->startSection('contents'); ?>
	<div class="main">
      <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="offset-md-4 col-md-8 col-sm-12">
            <div class="content-page page-404" style="background: #e9ecf3;">
               <div class="number">
                  404
               </div>
               <div class="details">
                  <h3>Oops!  You're lost.</h3>
                  <p>
                     We can not find the page you're looking for.<br>
                     <a href="<?php echo e(route('home')); ?>" class="link">Return home</a> or try the search bar below.
                  </p>
               </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>