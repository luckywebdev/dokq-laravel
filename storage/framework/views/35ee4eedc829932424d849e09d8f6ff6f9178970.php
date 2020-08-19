

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
<style>
    .arrow{
        display: none!important;
    }
    .popover{
        float: right!important;
        margin-left: -135px!important;
        margin-top: 10px;
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
	            	<a href="#">
	                	 > 児童生徒履歴
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
		<div class="page-content">
            <div class = "col-md-10">
			    <h3 class="page-title">児童生徒履歴</h3>
            </div>
            <div class ="col-md-2">
    			<div class="row">
                    
                </div>
            </div>
            <div class = "col-md-12">				
    			<div class="row">
    				<div class="col-md-12">
    					<form class="form form-horizontal" style="margin-top:8px;">
                        <div class="portlet-body" style="height: 300px;">
                            <div class="scroller " style="height:280px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                <table class="table table-striped col-md-12">
                                    <thead>
                                        <tr class="success">
                                            <th class="col-md-3 col-xs-3">日にち</th>
                                            <th class="col-md-3 col-xs-3">所属</th>
                                            <th class="col-md-6 col-xs-6">学級</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="text-md-center">
                                        <?php $__currentLoopData = $pupilhistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="align-middle"><?php echo e(date_format(date_create($history->created_at), "Y/m/d")); ?></td>
                                                <td class="align-middle"><?php echo e($history->group_name); ?></td>
                                                <td class="align-middle"><?php echo e($history->class); ?></td>
                                                
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-actions text-md-left">
                            
                            <button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
                        </div>                        
    					</form>
    				</div>
    			</div>
    			
            </div>
            <form class="form form-horizontal" name = "value" id = "value" action = "/mypage/article_history">
                <input type = "hidden" id = "idarry" name = "idarry">
            </form>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(window).load(function(){
            
        });
    	$(document).ready(function(){
            
		});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>