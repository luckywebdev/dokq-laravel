

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/news.css')); ?>">
<style>
    .arrow{
        display: none!important;
    }
    .popover{
        float: right !important;
        margin-left: -135px!important;
        margin-top: -20px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][0];
	$purposes = config('consts')['USER']['PURPOSE'][1];
	$doc = config('consts')['USER']['DOCS'][$type];
?>
<div class="container register">
	<div class="form">
		<form class="form-horizontal" method="post" role="form" action="<?php echo e(route('auth/doregister')); ?>">
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="<?php echo e(url('/')); ?>">
						<img class="logo_img" src="<?php echo e(asset('img/logo_img/logo_reserve_2.png')); ?>">
                        <!-- <h1 style="margin: 0 !important; font-family: 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
                        <h6 style="margin: 0 !important; font-family: HGP明朝B;">読書認定級</h6> -->
                    </a>
			    </div>
				<div class="form-body col-md-11">
					<ul class="nav nav-pills nav-fill steps">
						<li class="nav-item active">
							<span class="step">
								<span class="number"> 1 </span>
								<span class="desc">
									<i class="fa fa-check"></i> ステップ１
								</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２ 
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 3 </span>
							<span class="desc">
								<i class="fa fa-check"></i>	ステップ３
							</span>
							</span>
						</li>
						<li class="nav-item">
							<span class="step">
							<span class="number"> 4 </span>
							<span class="desc"><i class="fa fa-check"></i> ステップ４ </span>
							</span>
						</li>
					</ul>
					<div id="bar" class="progress " role="progressbar">
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width: 25%;">
						</div>
					</div>				
				</div>
			</div>

            <h3 class="text-md-center"><?php echo e(config('consts')['USER']['TYPE'][$type]); ?>会員登録申請フォーム
                <small style="color: #909090">(すべて必須項目です）</small>
            </h3>
			<div class="form-group row">

				<div class="col-md-11">
					<button type="button" class="btn btn-warning help pull-right">入力の説明</button>
				</div>
				<div class="col-md-1">
				</div>
			</div>

			<?php if(count($errors) > 0): ?>
				<?php echo $__env->make('partials.alert', array('errors' => $errors->all()), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endif; ?>
			<?php echo e(csrf_field()); ?>

			<input required type="hidden" name="role" value="0">
			
			<div class="form-group row <?php echo e($errors->has('group_name') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="group_name" style="align-self:center">団体・学校名 (全角）:</label>
				<div class="col-md-9 ">
					<input required type="text" name="group_name" value="<?php echo e(old('group_name')!='' ? old('group_name'):( isset($data) && $data != null? $data->group_name: '')); ?>" class="big-form-control popover-help" id="group_name" data-container="body" data-content="正確に入力してください。この項目は、後で変更できません。" data-placement="bottom"
					data-trigger="hover" placeholder="藤沢市立湘南小学校">
					<?php if($errors->has('group_name')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('group_name')); ?></span>
					</span>
					<?php endif; ?>
			    </div>
			</div>

			<div class="form-group row <?php echo e($errors->has('group_yomi') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="group_yomi" style="align-self:center">よみがな(全角）:</label>
				<div class="col-md-9">
					<?php if($data!=null): ?>
					<input required type="text" name="group_yomi" pattern="^[ぁ-ん]+$" title="全角ひらがなでご入力ください。" value="<?php echo e($data->group_yomi); ?>" class="big-form-control popover-help"  data-placement="right" data-trigger="hover" data-content="ひらがな" id="group_yomi" placeholder="ふじさわしりつしょうなんしょうがっこう">
					<!-- <input required type="text" name="group_yomi" value="<?php echo e($data->group_yomi); ?>" class="big-form-control popover-help"  data-placement="right" data-trigger="hover" data-content="ひらがな" id="group_yomi" placeholder="ふじさわしりつしょうなんしょうがっこう"> -->
					<?php else: ?>
					<input required type="text" name="group_yomi" pattern="[\u3041-\u309F]*" title="全角ひらがなでご入力ください。" value="<?php echo e(old('group_yomi')); ?>" class="big-form-control popover-help"  data-placement="right" data-trigger="hover" data-content="ひらがな" id="group_yomi" placeholder="ふじさわしりつしょうなんしょうがっこう">
					<!-- <input required type="text" name="group_yomi" value="<?php echo e(old('group_yomi')); ?>" class="big-form-control popover-help"  data-placement="right" data-trigger="hover" data-content="ひらがな" id="group_yomi" placeholder="ふじさわしりつしょうなんしょうがっこう"> -->
					<?php endif; ?>
<!--					<span class="help-block">よみがな</span>-->
					<?php if($errors->has('group_yomi')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('group_yomi')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row ">
				<label class="control-label col-md-2 text-md-right" for="group_roma" style="align-self:center">ローマ字(半角）:</label>
				<div class="col-md-9">
					<?php if($data!=null): ?>
					<input required type="text" name="group_roma" value="<?php echo e($data->group_roma); ?>" class="big-form-control popover-help"  data-placement="bottom" data-trigger="hover" data-content="ローマ字" id="group_roma" placeholder="shonan">
					<?php else: ?>
					<input required type="text" name="group_roma" value="<?php echo e(old('group_roma')); ?>" class="big-form-control popover-help"  data-placement="bottom" data-trigger="hover" data-content="ローマ字" id="group_roma" placeholder="shonan">
					<?php endif; ?>
					<?php if($errors->has('group_roma')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('group_roma')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row <?php echo e($errors->has('rep_name') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="rep_name" style="align-self:center">代表者名(全角）:</label>
				<div class="col-md-4">
					<?php if($data!=null): ?>
					<input required type="text" name="rep_name" value="<?php echo e($data->rep_name); ?>" class="big-form-control popover-help" id="rep_name" placeholder="〇〇　〇〇" data-placement="bottom" data-trigger="hover" data-content="姓と名の間にスペースを入れてください。">
					<?php else: ?>
					<input required type="text" name="rep_name" value="<?php echo e(old('rep_name')); ?>" class="big-form-control popover-help" id="rep_name" placeholder="〇〇　〇〇" data-placement="bottom" data-trigger="hover" data-content="姓と名の間にスペースを入れてください。">
					<?php endif; ?>
					<?php if($errors->has('rep_name')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('rep_name')); ?></span>
					</span>
					<?php endif; ?>
				</div>
				<label class="control-label col-md-2 text-md-right" for="rep_post" style="align-self:center">代表者役職(全角）:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="rep_post" value="<?php echo e($data->rep_post); ?>" class="big-form-control" id="rep_post">
					<?php else: ?>
					<input required type="text" name="rep_post" value="<?php echo e(old('rep_post')); ?>" class="big-form-control" id="rep_post">
					<?php endif; ?>
					<?php if($errors->has('rep_post')): ?>
					<span class="form-control-feedback">
						<span><?php echo e($errors->first('rep_post')); ?></span>
					</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row
				<?php if($errors->has('address4') || $errors->has('address5') || $errors->has('address1') || $errors->has('address2') || $errors->has('address3')): ?>
					has-danger
				<?php endif; ?>">
				<label class="control-label col-md-2 text-md-right" for="address4" style="align-self:center">所在地 :&nbsp;〒</label>
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address4" value="<?php echo e($data->address4); ?>" class="big-form-control" id="address4" placeholder="251"/>
						<?php else: ?>
						<input required type="text" name="address4" value="<?php echo e(old('address4')); ?>" class="big-form-control" id="address4" placeholder="251"/>
						<?php endif; ?>
					</div>
					<!-- <div class="col-xs-9" style="padding-left:10px;vertical-align:middle">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字3行しか入らないように欄を小さく</span>
					</div> -->
					<?php if($errors->has('address4') || $errors->has('address5')): ?>
					<span class="form-control-feedback">
						<span>所在地を正確に入力してください。</span>
					</span>
					<?php endif; ?>
				</div>
				<span class="cross2-xs" >―</span>
				<div class="col-md-1">
					<span class="hidden-xs col-xs-12" style="font-size:10px;">&nbsp;</span>
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address5" value="<?php echo e($data->address5); ?>" class="big-form-control" id="address5" placeholder="0043"/>
						<?php else: ?>
						<input required type="text" name="address5" value="<?php echo e(old('address5')); ?>" class="big-form-control" id="address5" placeholder="0043"/>
						<?php endif; ?>
					</div>
					<!-- <div class="col-xs-9" style="padding-left:10px;vertical-align:middle">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字4行しか入らないように欄を小さく</span>
					</div> -->
				</div>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">都道府県</span>
					<div class="col-md-12 col-xs-6" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address1" value="<?php echo e($data->address1); ?>" class="big-form-control" placeholder="神奈川県">
						<?php else: ?>
						<input required type="text" name="address1" value="<?php echo e(old('address1')); ?>" class="big-form-control" placeholder="神奈川県">
						<?php endif; ?>
					</div>
					<?php if($errors->has('address1') || $errors->has('address2') || $errors->has('address3')): ?>
					<span class="form-control-feedback">
						<span>所在地を正確に入力してください。</span>
					</span>
					<?php endif; ?>
				</div>
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-2">
					<span class="col-xs-12" style="font-size:10px;padding-left:0px">市区郡町村</span>
					<div class="col-md-12 col-xs-6" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address2" value="<?php echo e($data->address2); ?>" class="big-form-control" placeholder="藤沢市">
						<?php else: ?>
						<input required type="text" name="address2" value="<?php echo e(old('address2')); ?>" class="big-form-control" placeholder="藤沢市">
						<?php endif; ?>
					</div>
				</div>
				<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
				<div class="col-md-3">
					<span class="hidden-xs col-xs-12" style="font-size:10px">&nbsp;</span>
					<div class="col-md-12 col-xs-6" style="padding:0px;">
						<?php if($data!=null): ?>
						<input required type="text" name="address3" class="big-form-control popover-help" value="<?php echo e($data->address3); ?>" placeholder="辻堂元町8"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。" >
						<?php else: ?>
						<input required type="text" name="address3" class="big-form-control popover-help" value="<?php echo e(old('address3')); ?>" placeholder="辻堂元町8"  data-placement="bottom"  data-trigger="hover" data-content="数字とハイフンは半角で入力してください。" >
						<?php endif; ?>
					</div>
				</div>
				
			</div>
			
			<div class="form-group row <?php echo e($errors->has('phone') ? ' has-danger' : ''); ?> <?php echo e($errors->has('teacher') ? ' has-danger' : ''); ?>" >
				<label class="control-label col-md-2 text-md-right" for="phone" style="padding-top:15px">電話番号(半角）:</label>
				<div class="col-md-4">
					<?php if($data!=null): ?>
					<input required type="text" name="phone" value="<?php echo e($data->phone); ?>" class="big-form-control" id="phone">
					<?php else: ?>
					<input required type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="big-form-control" id="phone">
					<?php endif; ?>
					<span class="help-block">ハイフンは入れずに入力してください。</span>
					<?php if($errors->has('phone')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('phone')); ?></span>
						</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-2 text-md-right" for="group_type" style="padding-top:15px">団体の形態:</label>
				<div class="col-md-3" style="padding-top:5px">
					<select name="group_type" class="bs-select form-control" placeholder="団体の形態">
						<?php $__currentLoopData = config('consts')['USER']['GROUP_TYPE'][1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$group_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($data!=null): ?>
							<option value="<?php echo e($key); ?>" <?php if($data->group_type == $key): ?> selected <?php endif; ?> > <?php echo e($group_type); ?> </option>
							<?php else: ?>
							<option value="<?php echo e($key); ?>" <?php if(old('group_type') == $key): ?> selected <?php endif; ?> > <?php echo e($group_type); ?> </option>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
					<?php if($errors->has('group_type')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('group_type')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row  <?php echo e($errors->has('email') ? ' has-danger' : ''); ?> <?php echo e($errors->has('group_type') ? ' has-danger' : ''); ?>">
				<label class="control-label col-md-2 text-md-right" for="teacher" style="align-self:center" >担当者名(全角) :</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="teacher" value="<?php echo e($data->teacher); ?>" class="big-form-control popover-help" data-trigger="hover"  data-placement="bottom" data-content="姓と名の間にスペースを入れてください。" id="teacher" placeholder="〇〇　〇〇">
					<?php else: ?>
					<input required type="text" name="teacher" value="<?php echo e(old('teacher')); ?>" class="big-form-control popover-help" data-trigger="hover"  data-placement="bottom" data-content="姓と名の間にスペースを入れてください。" id="teacher" placeholder="〇〇　〇〇">
					<?php endif; ?>
					<?php if($errors->has('teacher')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('teacher')); ?></span>
						</span>
					<?php endif; ?>
				</div>

				<label class="control-label col-md-3 text-md-right" for="email" style="align-self:center">担当者メールアドレス:</label>
				<div class="col-md-3">
					<?php if($data!=null): ?>
					<input required type="text" name="email" class="big-form-control popover-help" value="<?php echo e($data->email); ?>" id="email" placeholder="〇〇〇〇〇＠〇〇〇〇.jp" data-trigger="hover"  data-placement="bottom" data-content="交代する際は変更できます。">
					<?php else: ?>
					<input required type="text" name="email" class="big-form-control popover-help" value="<?php echo e(old('email')); ?>" id="email" placeholder="〇〇〇〇〇＠〇〇〇〇.jp" data-trigger="hover"  data-placement="bottom" data-content="交代する際は変更できます。">
					<?php endif; ?>
					<?php if($errors->has('email')): ?>
						<span class="form-control-feedback">
							<span><?php echo e($errors->first('email')); ?></span>
						</span>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group form-actions row">
				<div class="col-md-4 text-md-left col-sm-12 col-sm-row">
					<!--<a href="<?php echo asset('manual/group.pdf')?>" class="btn btn-primary" style="color:white; margin-bottom:8px"><?php echo e($doc['TITLE']); ?></a>-->
					<input required type="hidden" id="pdfheight" name="pdfheight" value="">
					<input required type="hidden" name="helpdoc" id="helpdoc" value="manual/group.pdf">
					<button type="button" id="viewpdf" class="btn btn-info" style="color:white; margin-bottom:8px"><?php echo e($doc['TITLE']); ?></button>
				</div>
				<div class="col-md-4 text-md-center col-sm-12" >
					<button type="submit" class="btn btn-success" style="margin-bottom:8px">規約に同意して送信</button>
					<a href="<?php echo e(url('/auth/register')); ?>" class="btn btn-danger" style="margin-bottom:8px">キャンセル</a>
				</div>
				<div class="col-md-4 text-md-right col-sm-12">
					<a href="<?php echo e(url('/')); ?>" class="btn btn-info" style="margin-bottom:8px">読Qトップへ戻る</a>
				</div>
			</div>
			<label class="control-label col-md-12 text-md-left"><br>規約に同意して送信いただきますと、読書認定協会からご登録のEメール宛に、仮ID、仮パスワードをお知らせしますので、それを使用してログインしてください。
通知から７日間を過ぎるとログインできなくなりますので、その場合はもう一度最初からお手続きをお願いいたします。<br/>
※　3日経ってもメールが届かない場合は、メールアドレスを間違えて登録された可能性があります。恐れ入りますが再度申請をお願いいたします。<br><br>
			</label>
		</form>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
			
	<script type="text/javascript">		
		var handleInputMasks = function () {
			var pdfheight  = $(window).height() - 55;
			$("#pdfheight").val(pdfheight);

	        $.extend($.inputmask.defaults, {
	            'autounmask': true
	        });
	        
	        $("#phone").inputmask("mask", {
	            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
	        }); //specifying fn & options

	        $("#address4").inputmask("mask", {
		        "mask":"999"
	        });
			$("#address5").inputmask("mask", {
		        "mask":"9999"
	        });
	    }
		// $("#group_yomi").change(function () {
			
		// })
 		var handleSpinners = function () {
        
	        $('.spinner-input').parent().parent().spinner({value:0, min: 0});
	        
	    }
	    handleInputMasks();handleSpinners();
	    $(".help").click(function(){
	    //	 $(".popover-help").attr('data-placement','bottom')
	    	 $(".popover-help").popover('show')

	    	setTimeout(function(){
	    		$(".popover-help").popover('hide')
	    	},3000)
	    })
	    $(window).scroll(function(){
	    	 $(".popover-help").popover('hide')
	    });
	    $("#viewpdf").click(function(){
	    	$(".form-horizontal").attr("action", "/auth/viewpdf");
		    $(".form-horizontal").submit();
	    });
	   
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>