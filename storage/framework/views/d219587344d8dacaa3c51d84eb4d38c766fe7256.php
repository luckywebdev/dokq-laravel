<table class="table table-striped table-bordered table-hover data-table full-response-width" id="sample_1">
    <thead>
        <tr class="bg-primary">
            <th width="30%">タイトル</th>
            <th width="15%">著者</th>
            <th width="5%">ポイント</th>
            <th width="15%">推奨年代</th>
            <th width="5%">読Q合格者数</th>
            <th width="10%">表紙画像</th>
            <th width="15%">この本を受検</th>
            <th width="5%">本編集</th>
            <!--<th>yomi</th>-->
        </tr>
    </thead>
    <tbody class="text-md-center">
    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="odd gradeX book_list_tr" data-id="">
            <td style="vertical-align:middle; width: 30%">
                <b hidden="true"><?php echo e($book->title_furi); ?></b>
                <?php if($book->active >= 3): ?>
                    <a href="<?php echo e(url('book/'.$book->id.'/detail')); ?>" class="font-blue-madison" style="font-size: 150%"><?php echo e($book->title); ?></a>
                <?php else: ?>
                    <span style="font-size: 150%"><?php echo e($book->title); ?></span>
                <?php endif; ?>
                <p>
                    <?php $__currentLoopData = $book->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-success"><?php echo e($category->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
            </td>
            <td style="vertical-align:middle; width: 15%">  
            <b hidden="true"><?php echo e($book->fullname_yomi()); ?></b>
            <a href="#" class="font-blue-madison author_view" did="<?php echo e($book->writer_id); ?>" fullname="<?php echo e($book->fullname_nick()); ?>" >
                <?php echo e($book->fullname_nick()); ?></a>
                </td>
            <td style="vertical-align:middle; width: 5%"><?php echo e(floor($book->point*100)/100); ?></td>
            <td style="vertical-align:middle; width: 15%"><?php echo e(config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']); ?></td>
            <td style="vertical-align:middle; width: 5%"><?php if(count($book->passedNums) != 0): ?><?php echo e(count($book->passedNums)); ?><?php endif; ?></td>
            <td style="vertical-align:middle; width: 10%"><?php if(!is_null($book->image_url))echo $book->image_url; else ''; ?></td>
            <td style="width: 15%">
                <?php if($book->active == 2): ?>    
                    読Q対象外の本のため<br>登録できません<br>
                    （<?php echo e(isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''); ?>）

                <?php else: ?>
                    <?php if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1): ?>
                        <?php if(Auth::user()->getBookyear($book->id) !== null): ?>
                            <span class="btn doq_btn btn-info age_limit">この本を受検する</span>
                        <?php elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null): ?>
                            <span class="btn doq_btn btn-info book_equal">この本を受検する</span>
                        <?php else: ?>
                            <button type="button" id="<?php echo e($book->id); ?>" class="btn doq_btn btn-info test_btn">この本を受検する</button>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="btn doq_btn btn-info disabled">この本を受検する</span>
                    <?php endif; ?><br>
                    <?php if($book->active >= 3): ?>
                        <button type="button" id="<?php echo e($book->id); ?>" class="btn doq_btn btn-primary detail_btn">この本の詳細を見る</button>
                    <?php else: ?>
                        <span class="btn doq_btn btn-info disabled">この本の詳細を見る</span>
                    <?php endif; ?>
                    <br>
                    <?php if($book->active >= 3 && $book->active < 6): ?>
                        <button type="button" id="<?php echo e($book->id); ?>" class="btn doq_btn btn-success quiz_btn">この本のクイズを作る</button>
                    <?php elseif($book->active == 6 && Auth::check() && (Auth::id() == $book->overseer_id || Auth::user()->isAdmin() || Auth::user()->fullname_nick() == $book->fullname_nick())): ?>
                        <button type="button" id="<?php echo e($book->id); ?>" class="btn doq_btn btn-success quiz_btn">この本のクイズを作る</button>
                    <?php else: ?>
                    <span class="btn doq_btn btn-success disabled">この本のクイズを作る</span>
                    <?php endif; ?><br>
                    <?php if($book->active == 3 ): ?>
                        <?php if(Auth::user() !== null && (Auth::user()->isOverseerAll() || Auth::user()->isAdmin())): ?>
                        <button type="button" id="<?php echo e($book->id); ?>" class="btn doq_btn btn-warning overseer_btn">この本の監修者に応募する</button>                        
                        <?php else: ?>
                        <span class="btn doq_btn btn-warning disabled">この本の監修者に応募する</span>
                        <?php endif; ?>
                    <?php else: ?>
                    <span class="btn doq_btn btn-warning disabled">この本の監修者に応募する</span>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td style="width: 5%">
                <?php if(Auth::user() && (Auth::user()->isAdmin())): ?>
                <a class="btn doq_btn btn-info" href="<?php echo e(url('/book/'.$book->id.'/edit/0')); ?>">編&nbsp;&nbsp;&nbsp;&nbsp;集</a><br>
                <?php else: ?>
                &nbsp;
                <?php endif; ?>
            </td>

        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>