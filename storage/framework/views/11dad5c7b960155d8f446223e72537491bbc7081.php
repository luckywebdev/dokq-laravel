

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
        <h3 class="page-title">クイズ情報</h3>
        <div class="row">
            <div class="col-md-10">
                <a id = "export" href = "<?php if(isset($quizid)): ?> <?php echo e(url('/admin/export_quiz_data/'.$bookid.'/'.$quizid)); ?> <?php else: ?> <?php echo e(url('/admin/export_quiz_data/'.$bookid.'/null')); ?><?php endif; ?>" class="btn btn-warning pull-right" role="button" style="margin-bottom:8px;">CSV Export</a>
            </div>
            <div class="col-md-2">
                <a href="<?php echo e(url('/top')); ?>" class="btn btn-info pull-right" role="button" style="margin-bottom:8px;">協会トップへ戻る</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="form register-form"  id="validate-form" method="post" role="form" action="<?php echo e(url('/admin/save_quiz_data')); ?>"  enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <?php if(count($errors) > 0): ?>
                    <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
                <input type="hidden" name="id" id="id" value="<?php echo e($bookid); ?>"> 
                <table class="table table-striped table-bordered table-hover data-table">
                    <thead>
                        <tr class="bg-blue">
                            <th class="col-sm-1">クイズ№</th>
                            <th class="col-sm-3">文面</th>
                            <th class="col-sm-1">出典</th>
                            <th class="col-sm-1">認定日</th>
                            <th class="col-sm-1">作成者</th>
                            <th class="col-sm-1">認定した<br>監修者ID</th>
                            <th class="col-sm-1">出題回数</th>
                            <th class="col-sm-1">正答数</th>
                            <th class="col-sm-1">誤答数</th>
                            <th class="col-sm-1">時短<br>正答数</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">  
                        <?php if(isset($quizid)): ?>
                            <tr class="info">
                                <td style="vertical-align:middle;"><?php if(isset($quiz->doq_quizid) && $quiz->doq_quizid !==null): ?><?php echo e($quiz->doq_quizid); ?><?php endif; ?></td>
                                <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
                                                            $st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
                                                            for($i = 0; $i < 30; $i++) {
                                                                $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                                $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                            } 
                                                            echo $st  ?></td>
                                <td style="vertical-align:middle;"><?php echo e(config('consts')['QUIZ']['APP_RANGES'][$quiz->app_range]); ?></td>
                                <td style="vertical-align:middle;"><?php echo e(date_format(date_create($quiz->published_date),'Y-m-d')); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->RegisterShow()); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->OverseerShow()); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswer); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswerright); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswerwrong); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswershorttime); ?></td>
                            </tr>
                        <?php else: ?>                                                              
                            <?php $__currentLoopData = $quizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                 
                            <tr class="info">
                                <td style="vertical-align:middle;"><?php if(isset($quiz->doq_quizid) && $quiz->doq_quizid !==null): ?><?php echo e($quiz->doq_quizid); ?><?php endif; ?></td>
                                <td style="vertical-align:middle;"><?php $st = str_replace_first("#", "<span style='text-decoration:underline !important'>", $quiz->question); $st = str_replace_first("#", "</span>", $st); 
        													$st = str_replace_first("＃", "<span style='text-decoration:underline;'>", $st); $st = str_replace_first("＃", "</span>", $st);
                                                            for($i = 0; $i < 30; $i++) {
                                                                $st = str_replace_first("*", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("*", ")</span>", $st);
                                                                $st = str_replace_first("＊", "<span class='font_gogic' style='font-size:10px;font-family:HGP明朝B;'>(", $st); $st = str_replace_first("＊", ")</span>", $st);
                                                            } 
                                                            echo $st  ?></td>
                                <td style="vertical-align:middle;"><?php echo e(config('consts')['QUIZ']['APP_RANGES'][$quiz->app_range]); ?></td>
                                <td style="vertical-align:middle;"><?php echo e(date_format(date_create($quiz->published_date),'Y-m-d')); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->RegisterShow()); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->OverseerShow()); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswer); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswerright); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswerwrong); ?></td>
                                <td style="vertical-align:middle;"><?php echo e($quiz->quizanswershorttime); ?></td>
                            </tr>   
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                        <?php endif; ?>                                              
                    </tbody>
                </table>
                </form>
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
        var recommend = 0;
       
        $("select[name=recommend]").change(function(){
            var temp = $("select[name=recommend]").val();
            var pointarray = [0.1,0.2,0.4,0.5,0.7,0.8,0.9,1.0,1.0,1.5,2.0];

            if( temp != ""){
                recommend = pointarray[temp];
            }
            $("input[name=recommend_coefficient]").val(recommend);
            
        });
	</script>
	<script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>