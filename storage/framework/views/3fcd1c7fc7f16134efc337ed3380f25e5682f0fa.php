

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
                        > お問合せ対応
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
					<h3>お問合せ対応
                    <button type="button" class="btn btn-warning del_sel pull-right">☑した行を削除</button></h3>
				</div>
			</div>
            <div class="row">
            
                <div class="col-md-12">
                <form class="form-horizontal form" id="form" role="form" action="">
                    <div class="dataTables_wrapper no-footer">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr class="blue">
                                    <th>
                                       閲覧
                                    </th>
                                    <th>受付日</th>
                                    <th>発信者名</th>
                                    <th>会員種類非会員</th>
                                    <th>メールアドレス</th>
                                    <th>問い合わせ文 冒頭</th>
                                    <th>返信全文</th>
                                    <th>返信日</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            <?php $__currentLoopData = $inquiris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="info">
                                    <td>
                                        <input type="checkbox" name="chbItem" id="<?php echo e($inquiry->id); ?>" class="checkboxes"  value="<?php echo e($inquiry->id); ?>">
                                    </td>
                                    <td><?php echo e(with((date_create($inquiry->created_at)))->format('Y.m.d')); ?></td>
                                    <td><?php if($inquiry->role == (config('consts')['USER']['ROLE']['GROUP'] || config('consts')['USER']['ROLE']['GENERAL'] ||
                                                            config('consts')['USER']['ROLE']['OVERSEER'] || config('consts')['USER']['ROLE']['AUTHOR'] ||
                                                            config('consts')['USER']['ROLE']['TEACHER'] || config('consts')['USER']['ROLE']['LIBRARIAN'] ||
                                                            config('consts')['USER']['ROLE']['REPRESEN'] || config('consts')['USER']['ROLE']['ITMANAGER'] ||
                                                            config('consts')['USER']['ROLE']['OTHER'] || config('consts')['USER']['ROLE']['PUPIL'] ||
                                                            config('consts')['USER']['ROLE']['ADMIN'])): ?>
                                                    <a href="<?php echo e(url('mypage/other_view/' . $inquiry->from_id)); ?>" class="font-blue"><?php echo e($inquiry->name); ?></a>
                                        <?php else: ?> <?php echo e($inquiry->name); ?> <?php endif; ?></td>
                                    <td>
                                    <?php if($inquiry->from_id != 0): ?>
                                        <?php if($inquiry->role == config('consts')['USER']['ROLE']['GROUP']): ?> <?php echo e(config('consts')['USER']['TYPE'][0]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['GENERAL']): ?> <?php echo e(config('consts')['USER']['TYPE'][1]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['OVERSEER']): ?> <?php echo e(config('consts')['USER']['TYPE'][2]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['AUTHOR']): ?> <?php echo e(config('consts')['USER']['TYPE'][3]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['TEACHER']): ?> <?php echo e(config('consts')['USER']['TYPE'][4]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['LIBRARIAN']): ?> <?php echo e(config('consts')['USER']['TYPE'][5]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['REPRESEN']): ?> <?php echo e(config('consts')['USER']['TYPE'][6]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['ITMANAGER']): ?> <?php echo e(config('consts')['USER']['TYPE'][7]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['OTHER']): ?> <?php echo e(config('consts')['USER']['TYPE'][8]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['PUPIL']): ?> <?php echo e(config('consts')['USER']['TYPE'][9]); ?>

                                        <?php elseif($inquiry->role == config('consts')['USER']['ROLE']['ADMIN']): ?> 管理者
                                        <?php endif; ?>
                                    <?php else: ?> 非会員<?php endif; ?></td>
                                    <td><a href="mailto:<?php echo e($inquiry->email); ?>"><?php echo e($inquiry->email); ?></a></td>
                                    <td><?php echo e($inquiry->content); ?></td>
                                    <td><?php echo e($inquiry->post); ?></td>
                                    <td><?php echo e($inquiry->post != '' ? with((date_create($inquiry->updated_at)))->format('Y.m.d') : ''); ?></td>
                                    <td><input type="checkbox" class="del_chk" data-id="<?php echo e($inquiry->id); ?>" ></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
                            </tbody>    
                        </table>
                    </div>
                </div>
            </form>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <a href="../" class="btn btn-info pull-right" role="button">協会トップへ戻る</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
 <!-- data table -->
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/media/js/jquery.dataTables.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/data-table.js')); ?>"></script>
    <script src="<?php echo e(asset('js/components-dropdowns.js')); ?>"></script>
    <!-- data table -->
    <script type="text/javascript">
        $(document).ready(function(){
            ComponentsDropdowns.init();
            
            var del_chk = [];

            $(".checkboxes").change(function(){
               // alert($(".checkboxes").val());
                var checkboxes = $('input:checked');
                for(i =0;i<checkboxes.length;i++){
                    
                   // $('#selected').val($(checkboxes[i]).val());                          
                    $("#form").attr("method", "get")
                    $("#form").attr("action",'<?php echo e(url("/admin/quiz_answer_card")); ?>');
                    $("#form").submit();
                    
                }
            });

            $(".del_chk").change(function() {
                var chk_state = $(this).attr("checked");
                var chk_id = $(this).data("id");
                if(chk_state == "checked"){
                    if(!del_chk.includes(chk_id)){
                        del_chk.push(chk_id);
                    }
                }
                else{
                    var item_index = del_chk.indexOf(chk_id);
                    if(item_index >= 0){
                        del_chk.splice(item_index, 1);                        
                    }
                }

            })

            $(".del_sel").click(function() {
                var info = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    quizIds: del_chk,
                    type: 0
                };
                var post_url = "/admin/quiz_delete";
                $.ajax({
                    type: "post",
                    url: post_url,
                    data: info,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf-token"]').attr('content');
                        if (token) {
                                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (response) {
                        console.log("response===>", response);
                        if(response.status){
                            window.location.reload();
                        }
                        else
                            alert('Delete error') ;
                    }
                });  
            })

        });
        TableManaged.init();
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>