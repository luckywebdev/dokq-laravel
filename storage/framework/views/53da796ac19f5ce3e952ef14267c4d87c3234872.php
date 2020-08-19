

<?php $__env->startSection('styles'); ?>

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
                        > 読書認定書ストック
                    </li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
	<div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h3>読書認定書ストック</h3>
                </div>
            </div>
            <form class="form form-horizontal" id="search-form" name="search-form" method="get">
                <?php echo e(csrf_field()); ?>

            
            <div class="row">
                <div class="dataTables_wrapper no-footer col-md-12 ">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover data-table no-footer" id="member_table">
                            <thead class="blue">
                                <tr class="blue">
                                    <th class="align-middle" style="width:15%;">閲覧開始日<br>（パスコード連絡日<br>の翌日）</th>
                                    <th class="align-middle" style="width:20%;">依頼者読Qネーム</th>
                                    <th class="align-middle" style="width:10%;">認定書<br>級のみ</th>
                                    <th class="align-middle" style="width:10%;">級と合格記録<br>20冊の認定書</th>
                                    <th class="align-middle" style="width:10%;">級と公開中の<br>合格記録全冊の<br>認定書</th>
                                    <th class="align-middle" style="width:10%;">合格記録20冊の<br>認定書（級非表示）<br>の認定書</th>
                                    <th class="align-middle" style="width:10%;">パスコード</th>
                                    <th class="align-middle" style="width:15%;">閲覧終了日</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                          
                            <?php $__currentLoopData = $bookcredits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $bookcredit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="info">
                                    <td><?php echo e(date_format(date_add(date_create($bookcredit->backup_date), date_interval_create_from_date_string("1 days")), "Y-m-d")); ?></td>
                                    <td><?php echo e($bookcredit->username); ?></td>
                                    <td><?php if($bookcredit->index == 1): ?>〇<?php endif; ?></td>
                                    <td><?php if($bookcredit->index == 2): ?>〇<?php endif; ?></td>
                                    <td><?php if($bookcredit->index == 3): ?>〇<?php endif; ?></td>
                                    <td><?php if($bookcredit->index == 4): ?>〇<?php endif; ?></td>
                                    <td><?php echo e($bookcredit->passcode); ?></td>
                                    <td><?php echo e(date_format(date_add(date_create($bookcredit->backup_date), date_interval_create_from_date_string("6 months")), "Y-m-d")); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>          
            
            </form>
           
            <div class="row">
                <div class="col-md-11">
                    <a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>