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
        <h3 class="page-title">会員情報カード</h3>
        
        <div class="form-body">
        <form class="form register-form"  id="validate-form" method="post" role="form" action="<?php echo e(url('/admin/save_personal_data')); ?>"  enctype="multipart/form-data">
        <?php if(count($errors) > 0 && $errors->has('servererr')): ?>
            <?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="id" id="id" value="<?php echo e($user->id); ?>"> 
            <div class="row form-group">
                <div class="col-md-2 text-md-right <?php echo e($errors->has('username') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">読Qネーム</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="username" name="username" value="<?php echo e(old('username') !='' ? old('username') : (isset($user) ?  $user->username : '')); ?>">
                    <?php if($errors->has('username')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('username')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('r_password') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">パスワード</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="r_password" name="r_password" value="<?php echo e(old('r_password') !='' ? old('r_password') : (isset($user) ?  $user->r_password : '')); ?>">
                    <?php if($errors->has('r_password')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('r_password')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('firstname') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">姓</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="firstname" name="firstname" value="<?php echo e(old('firstname') !='' ? old('firstname') : (isset($user) ?  $user->firstname : '')); ?>">
                    <?php if($errors->has('firstname')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('firstname')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('lastname') ? ' has-danger' : ''); ?>">                 
                    <div class="tools">
                        <label class="label-above">名</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="lastname" name="lastname" value="<?php echo e(old('lastname') !='' ? old('lastname') : (isset($user) ?  $user->lastname : '')); ?>">
                    <?php if($errors->has('lastname')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('lastname')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('firstname_yomi') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">姓よみがな</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="firstname_yomi" name="firstname_yomi" value="<?php echo e(old('firstname_yomi') !='' ? old('firstname_yomi') : (isset($user) ?  $user->firstname_yomi : '')); ?>">
                    <?php if($errors->has('firstname_yomi')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('firstname_yomi')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('lastname_yomi') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">名よみがな</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="lastname_yomi" name="lastname_yomi" value="<?php echo e(old('lastname_yomi') !='' ? old('lastname_yomi') : (isset($user) ?  $user->lastname_yomi : '')); ?>">
                    <?php if($errors->has('lastname_yomi')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('lastname_yomi')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right <?php echo e($errors->has('firstname_roma') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">姓ローマ字</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="firstname_roma" name="firstname_roma" value="<?php echo e(old('firstname_roma') !='' ? old('firstname_roma') : (isset($user) ?  $user->firstname_roma : '')); ?>">
                    <?php if($errors->has('firstname_roma')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('firstname_roma')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right <?php echo e($errors->has('lastname_roma') ? ' has-danger' : ''); ?>">               
                    <div class="tools">
                        <label class="label-above">名ローマ字</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="lastname_roma" name="lastname_roma" value="<?php echo e(old('lastname_roma') !='' ? old('lastname_roma') : (isset($user) ?  $user->lastname_roma : '')); ?>">
                    <?php if($errors->has('lastname_roma')): ?>
                    <span class="form-control-feedback" style="color:red">
                        <span><?php echo e($errors->first('lastname_roma')); ?></span>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">著者ペンネーム 姓</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="firstname_nick"  id="firstname_nick" value="<?php echo e(old('firstname_nick') !='' ? old('firstname_nick') : (isset($user) ?  $user->firstname_nick : '')); ?>" class="form-control text-md-right" <?php if(!$user->isAuthor()): ?> readonly <?php endif; ?>>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">著者ペンネーム 名</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="lastname_nick"  id="lastname_nick" value="<?php echo e(old('lastname_nick') !='' ? old('lastname_nick') : (isset($user) ?  $user->lastname_nick : '')); ?>" class="form-control text-md-right" <?php if(!$user->isAuthor()): ?> readonly <?php endif; ?>>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">ペンネームよみがな 姓</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="firstname_nick_yomi"  id="firstname_nick_yomi" value="<?php echo e(old('firstname_nick_yomi') !='' ? old('firstname_nick_yomi') : (isset($user) ?  $user->firstname_nick_yomi : '')); ?>" class="form-control text-md-right" <?php if(!$user->isAuthor()): ?> readonly <?php endif; ?>>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">ペンネームよみがな 名</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="lastname_nick_yomi"  id="lastname_nick_yomi" value="<?php echo e(old('lastname_nick_yomi') !='' ? old('lastname_nick_yomi') : (isset($user) ?  $user->lastname_nick_yomi : '')); ?>" class="form-control text-md-right" <?php if(!$user->isAuthor()): ?> readonly <?php endif; ?>>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">性別</label>                                                   
                    </div>
                    <select class="bs-select form-control base_info text-md-right" name="gender" id="gender">
                        <?php for($i = 1; $i < 3; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php if(isset($user)&& $user->gender == $i): ?> selected <?php endif; ?>><?php echo e(config('consts')['USER']['GENDER'][$i]); ?></option>
                        <?php endfor; ?>
                    </select>  
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">生年月日</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="birthday" name="birthday" value="<?php echo e(old('birthday') !='' ? old('birthday') : (isset($user) ?  $user->birthday : '')); ?>" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">電話</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="phone"  id="phone" value="<?php echo e($user->phone); ?>" class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">メールアドレス</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="email" name="email" value="<?php echo e($user->email); ?>">
                </div>
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">保護者メアド</label>                                                   
                    </div>
                    <input type="<?php echo e("text"); ?>" class="form-control base_info text-md-right" id="teacher" name="teacher" value="<?php echo e($user->teacher); ?>" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">現表示名</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="fullname_is_public"  id="fullname_is_public" value="<?php if($user->fullname_is_public): ?><?php echo e($user->fullname()); ?><?php else: ?><?php echo e($user->username); ?><?php endif; ?>" class="form-control text-md-right" readonly>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">現住所〒1</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address4" value="<?php echo e($user->address4); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">現住所〒2</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address5" value="<?php echo e($user->address5); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">都道府県</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address1" value="<?php echo e($user->address1); ?>"  class="form-control text-md-right " readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">市区町村</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address2" value="<?php echo e($user->address2); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">町名</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address3" value="<?php echo e($user->address3); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地１</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address6" value="<?php echo e($user->address6); ?>"  class="form-control text-md-right" readonly>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地２</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address7" value="<?php echo e($user->address7); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">番地３</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address8" value="<?php echo e($user->address8); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">建物名</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address9" value="<?php echo e($user->address9); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">
                    <div class="tools">
                        <label class="label-above text-md-right">部屋番号・階</label>
                    </div>
                    <input type="<?php echo e("text"); ?>" name="address10" value="<?php echo e($user->address10); ?>"  class="form-control text-md-right" readonly>
                </div>
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">入会日時</label>                                                   
                    </div>  
                    <input type="<?php echo e("text"); ?>" name="replied_date3"  id="replied_date3" value="<?php echo e(old('replied_date3') !='' ? old('replied_date3') : (isset($user) ?  $user->replied_date3 : '')); ?>" class="form-control text-md-right" readonly>
                </div> 
                
                
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">現有効期限</label>                                                   
                    </div>  
                    <?php if($user->isPupil()): ?>
                    <input type="<?php echo e("text"); ?>" name="payment" class="form-control" id="payment" value="<?php if($user->properties == 0): ?><?php echo e(config('consts')['PAYMENT_METHOD'][0]); ?><?php elseif($user->pay_content !== null && $user->pay_content !== ''): ?><?php echo e(config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'.$user->period); ?><?php else: ?><?php echo e(''); ?><?php endif; ?>"  readonly>
                    <?php else: ?>
                    <input type="<?php echo e("text"); ?>" name="payment" class="form-control" id="payment" value="<?php if($user->properties == 0): ?><?php echo e(''); ?><?php elseif($user->pay_content !== null && $user->pay_content !== ''): ?><?php echo e(config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'.$user->period); ?><?php else: ?><?php echo e(''); ?><?php endif; ?>"  readonly>
                    <?php endif; ?>

                </div>
            </div>                       
                    
            
            <div class="tab-content1">
                <table class="table table-bordered">
                    <tr>
                        <td class="col-md-2 text-md-center">現生涯ポイント</td><td class="col-md-1 text-md-center"><?php echo e($user->total_point); ?></td>
                        <td class="col-md-2 text-md-center">現在の級</td><td class="col-md-1 text-md-center"><?php echo e($user->rank); ?></td>
                        <td class="col-md-2 text-md-center">登録した本の数</td><td class="col-md-1 text-md-center"><?php echo e($user->allowedbooks->count()); ?></td>
                        <td class="col-md-2 text-md-center">認定されたクイズ数</td><td class="col-md-1 text-md-center"><?php echo e($user->allowedquizes); ?></td>
                    </tr>
                    <tr>
                        <td class="col-md-2 text-md-center">受検回数</td><td class="col-md-1 text-md-center"><?php echo e($user->testquizes); ?></td>
                        <td class="col-md-2 text-md-center">合格回数</td><td class="col-md-1 text-md-center"><?php echo e($user->testallowedquizes); ?></td>
                        <td class="col-md-2 text-md-center">試験監督した回数</td><td class="col-md-1 text-md-center"><?php echo e($user->testoverseer); ?></td>
                        <td class="col-md-2 text-md-center">試験監督した実人数</td><td class="col-md-1 text-md-center"><?php echo e($user->testoverseers); ?></td>
                    </tr>
                    <tr>
                        <td class="col-md-2 text-md-center">適性検査合格日</td><td class="col-md-1 text-md-center"><?php echo e($user->replied_date4?with(date_create($user->replied_date4))->format("Y-m-d"):""); ?></td>
                        <td class="col-md-2 text-md-center">監修本数</td><td class="col-md-1 text-md-center"><?php echo e($user->overseerbooks->count()); ?></td>
                        <td class="col-md-2 text-md-center">著書読Ｑ本の数</td><td class="col-md-1 text-md-center"><?php echo e(count($user->authorbooks)); ?></td>
                        <td class="col-md-2 text-md-center">本棚公開非公開</td><td class="col-md-1 text-md-center"><?php if($user->book_allowed_record_is_public == 1): ?>公開<?php else: ?>非公開<?php endif; ?></td>
                    </tr>
                </table>
                <?php if($user->role == config('consts')['USER']['ROLE']["PUPIL"]): ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-purple">
                            <th class="col-sm-2">所属先(生徒)</th>
                            <th class="col-sm-1">現学年</th>
                            <th class="col-sm-1">現学級</th>
                            <th class="col-sm-2">現　担任</th>
                            <th class="col-sm-2">入学・転入日</th>
                            <th class="col-sm-2">卒業・転出日</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">
                    <?php $__currentLoopData = $user->pupilHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$pupilHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                              
                        <tr class="info">
                            <td style="vertical-align:middle;"><?php echo e($pupilHistory->group_name); ?></td>
                            <td style="vertical-align:middle;"><?php if($pupilHistory->grade != 0): ?><?php echo e($pupilHistory->grade); ?><?php endif; ?></td>
                            <td style="vertical-align:middle;"><?php echo e($pupilHistory->class_number); ?></td>
                            <td style="vertical-align:middle;"><?php echo e($pupilHistory->teacher_name); ?></td>
                            <td style="vertical-align:middle;"><?php echo e($pupilHistory->created_at); ?></td>
                            <td style="vertical-align:middle;"><?php echo e($pupilHistory->updated_at); ?></td>
                        </tr> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                             
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if($user->isSchoolMember()): ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-yellow">
                            <th class="col-sm-2">所属先(教員)</th>
                            <th class="col-sm-1">役職名</th>
                            <th class="col-sm-2">所属日</th>
                            <th class="col-sm-1">担任学年</th>
                            <th class="col-sm-1">担任学級</th>
                            <th class="col-sm-2">異動転出日</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">  
                    <?php $__currentLoopData = $user->teacherHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$teacherHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                 
                        <tr >
                            <td style="vertical-align:middle;"><?php echo e($teacherHistory->group_name); ?></td>
                            <td style="vertical-align:middle;">
                                <?php if($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['TEACHER']): ?> 教員
                                <?php elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['LIBRARIAN']): ?> 司書
                                <?php elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['REPRESEN']): ?> 代表（校長、教頭等）
                                <?php elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['ITMANAGER']): ?> IT担当者
                                <?php elseif($teacherHistory->teacher_role == config('consts')['USER']['ROLE']['OTHER']): ?> その他
                                <?php endif; ?>
                            </td>
                            <td style="vertical-align:middle;"><?php echo e($teacherHistory->created_at); ?></td>
                            <td style="vertical-align:middle;"><?php if($teacherHistory->grade != 0): ?><?php echo e($teacherHistory->grade); ?><?php endif; ?></td>
                            <td style="vertical-align:middle;"><?php echo e($teacherHistory->class_number); ?></td>
                            <td style="vertical-align:middle;"><?php echo e($teacherHistory->updated_at); ?></td>
                        </tr> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                                
                    </tbody>
                </table>
                <?php endif; ?>
                <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
                    <div class="col-md-4" style="padding-left:0px;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="align-middle" style="width:30%;padding-left:0px;padding-right:0px;">登録読Ｑ本ＩＤ</th>                            
                                    <th class="align-middle" style="width:70%;">登録読Ｑ本</th>
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            <?php $__currentLoopData = $user->allowedbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$allowedbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                  
                                <tr>
                                    <td class="align-middle">dq<?php echo e($allowedbook->bookid); ?></td>
                                    <td class="align-middle"><?php echo e($allowedbook->title); ?></td>
                                </tr> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                             
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4" style="padding-left:0px;">
                        <?php if(count($user->authorbooks) > 0 && !$user->isGeneral() && $user->isPupil()): ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="col-sm-1" style="padding-left:0px;padding-right:0px;">監修読Ｑ本ＩＤ</th>
                                        <th class="col-sm-2">監修読Ｑ本</th>
                                    </tr>
                                </thead>
                                <tbody class="text-md-center">   
                                <?php $__currentLoopData = $user->overseerbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$overseerbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                               
                                    <tr >
                                        <td style="vertical-align:middle;">dq<?php echo e($overseerbook->id); ?></td>
                                        <td style="vertical-align:middle;"><?php echo e($overseerbook->title); ?></td>
                                    </tr>  
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                             
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-4" style="padding-left:0px;padding-right:0px;">
                        <?php if(count($user->authorbooks) > 0 && ($user->isAuthor() || $user->isAdmin())): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="col-sm-1" style="padding-left:0px;padding-right:0px;">著書読Ｑ本ＩＤ</th>
                                    <th class="col-sm-2">著書読Ｑ本</th>                            
                                </tr>
                            </thead>
                            <tbody class="text-md-center">                                                                 
                            <?php $__currentLoopData = $user->authorbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$authorbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                               
                                <tr >
                                    <td style="vertical-align:middle;">dq<?php echo e($authorbook->id); ?></td>
                                    <td style="vertical-align:middle;"><?php echo e($authorbook->title); ?></td>
                                </tr>  
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                             
                            </tbody>
                        </table>
                         <?php endif; ?>
                    </div>
                   
                </div>
                <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
                   
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-red">
                                    <th class="align-middle" style="width:20%;padding-left:0px;padding-right:0px;">合格読Ｑ本ＩＤ</th>                            
                                    <th class="align-middle" style="width:70%;">合格読Ｑ本</th>
                                    <th class="align-middle" style="width:10%;">削除</th>                            
                                </tr>
                            </thead>
                            <tbody class="text-md-center">
                            <?php $__currentLoopData = $user->myAllHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$myAllHistory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                  
                                <tr>
                                    <td class="align-middle">dq<?php echo e($myAllHistory->book_id); ?></td>
                                    <td class="align-middle"><?php echo e($myAllHistory->title); ?></td>
                                    <td class="align-middle"><input type="checkbox" class="checkboxes" id="<?php echo e($myAllHistory->id); ?>" name="myAllHistory" value="<?php echo e($myAllHistory->id); ?>"/></td>
                                </tr> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                             
                            </tbody>
                        </table>
                        <div class="col-md-12 text-md-center col-xs-12 pull-right" style="text-align:center;">
                            <button type="button" class="btn btn-primary success_cancel"  style="margin-bottom:8px">合格記録を削除</button>
                        </div>
                        <input type="hidden" name="selected" id="selected" value=""/>
                    
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-blue">
                            <th class="col-sm-3">画像枠予備</th>
                            <th class="col-sm-3">著者、監修者ﾌﾟﾛﾌｨｰﾙ画像</th>
                            <th class="col-sm-3">本人確認書類画像</th>
                            <th class="col-sm-3">資格書類画像</th>                            
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;"></td>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="<?php if($user->myprofile != null): ?> <?php echo e(url($user->myprofile)); ?> <?php endif; ?>" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;<?php if($user->myprofile_date): ?>画像登録日 : <?php echo e($user->myprofile_date); ?><?php endif; ?></span></div>
                                    <div class="text-md-center" style="height: 34px;">                                      
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                            </td>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="<?php if($user->file != null): ?> <?php echo e(url($user->file)); ?> <?php endif; ?>" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;<?php if($user->authfile_date): ?>画像登録日 : <?php echo e($user->authfile_date); ?><?php endif; ?></span></div>
                                    <div class="text-md-center">
                                        <span class="btn btn-file btn-primary">
                                            <span class="fileinput-new">ファイルを選択</span>
                                            <span class="fileinput-exists">変　更</span>
                                            <input type="file" name="authfile" >
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
                                    <span style="color:red">本人確認画像のチェック</span>
                                    <input type="checkbox" class="form-control" id="authfile_check" name="authfile_check" <?php if($user->authfile_check == 1): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                                </div>
                            </td>
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="<?php if($user->certifile != null): ?> <?php echo e(url($user->certifile)); ?> <?php endif; ?>" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;<?php if($user->certifile_date): ?>画像登録日 : <?php echo e($user->certifile_date); ?><?php endif; ?></span></div>
                                    <div class="text-md-center">
                                        <span class="btn btn-file btn-primary">
                                            <span class="fileinput-new">ファイルを選択</span>
                                            <span class="fileinput-exists">変　更</span>
                                            <input type="file" name="certificatefile" >
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
                                    <span style="color:red">資格書類画像のチェック</span>
                                    <input type="checkbox" class="form-control" id="certifile_check" name="certifile_check" <?php if($user->certifile_check == 1): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                                </div>
                            </td>
                        </tr>                                              
                    </tbody>
                </table>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-green">
                            <th class="col-sm-6">現顔登録</th>
                            <th class="col-sm-6">前回顔登録</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" style="width: 150px; height: 150px;">
                                        <img src="<?php if($user->image_path != null): ?> <?php echo e(url($user->image_path)); ?> <?php endif; ?>" alt=""/>
                                    </div>
                                    <div class="text-md-center"><span>&nbsp;<?php if($user->imagepath_date): ?>登録日 : <?php echo e($user->imagepath_date); ?><?php endif; ?></span></div>
                                    <div class="text-md-center" style="height: 34px;">                                      
                                    </div>
                                </div>
                                <div>
                                    <span style="color:red">顔と書類画像の照合</span>
                                    <input type="checkbox" class="form-control" id="imagepath_check" name="imagepath_check" <?php if($user->imagepath_check == 1): ?> <?php echo e("checked"); ?> <?php endif; ?> >
                                </div>
                            </td>
                            <td style="vertical-align:middle;"></td>
                        </tr>                                              
                    </tbody>
                </table>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-green">
                            <th class="col-sm-12">メモ</th>
                        </tr>
                    </thead>
                    <tbody class="text-md-center">                                                                 
                        <tr >
                            <td style="vertical-align:middle;">
                                <textarea id="memo" class="form-control" name="memo" maxlength="80" rows="3"><?php echo e(old('memo')!=""? old('memo') : (isset($user) ? $user->memo : '')); ?></textarea>
                            </td>
                        </tr>                                              
                    </tbody>
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
<!-- Modal -->
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
            <button type="button" data-dismiss="modal" class="btn btn-info" >戻　る</button>
        </div>
    </div>

  </div>
</div>
<div id="perdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span id="alert_perdel_text"></span>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-warning perdelete modal-close" >実　行</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close" >戻　る</button>
        </div>
    </div>
  </div>
</div>
<div id="TdelModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><strong style="font-family: 'Judson'">読Q</strong></h4>
        </div>
        <div class="modal-body">
            <span>合格記録を削除しますか?</span>
        </div>
        <div class="modal-footer">
            <button type="button" data-loading-text="確認中..." class="delete_booksuccess btn btn-primary">は い</button>
            <button type="button" data-dismiss="modal" class="btn btn-info modal-close">いいえ</button>
        </div>
    </div>

  </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>" type="text/javascript"></script>
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
            $("#alert_perdel_text").html("<?php echo e(config('consts')['MESSAGES']['CONFIRM_PER_DELETE']); ?>");
            $("#perdelModal").modal();
        });

        $(".perdelete").click(function() {
            $("#validate-form").attr("action", '<?php echo e(url("/admin/deleteperByAdmin")); ?>');
            $("#validate-form").submit();
        });

        $(".success_cancel").click(function(){
            var checkboxes = [];
            var checkids = $(".checkboxes");
            
            for(var i = 0; i < checkids.length; i++){
                if($(checkids[i]).parent().hasClass("checked")){
                    checkboxes[checkboxes.length]= $(checkids[i]);
                }                   
            }
            if(checkboxes.length == 0){
                $("#alert_text").html("<?php echo e(config('consts')['MESSAGES']['CHECK_BOOK_CANCEL']); ?>");
                $("#alertModal").modal();
                $(this).val("");
                return;
            }else{
                $("#TdelModal").modal();
            }

           
        });

        $(".delete_booksuccess").click(function(){
            var t = '';
            var checkboxes = [];
            var checkids = $(".checkboxes");
            
            for(var i = 0; i < checkids.length; i++){
                if($(checkids[i]).parent().hasClass("checked")){
                    checkboxes[checkboxes.length]= $(checkids[i]);
                }                   
            }

            for(i =0;i<checkboxes.length;i++){
                t+=$(checkboxes[i]).attr("id");
                if(i < checkboxes.length-1){
                    t+=",";
                }
            }

            $('#selected').val(t);

            $("#validate-form").attr("action", "<?php echo e(url('/admin/success_cancel')); ?>");
            $("#validate-form").submit();
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

        var handleInputMasks = function () {
            $.extend($.inputmask.defaults, {
                'autounmask': true
            });

            $("#birthday").inputmask("y/m/d", {
                "placeholder": "yyyy/mm/dd"
            }); //multi-char placeholder
           

        }
        var handleComponents = function() {
            $('#memo').maxlength({
                limitReachedClass: "label label-danger",
                alwaysShow: true
            });
        }
        handleComponents();
        handleDatePickers();
        handleInputMasks();
    </script>
    <script type="text/javascript" src="<?php echo e(asset('js/group/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>