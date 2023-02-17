@extends('auth.layout')


@section('contents')
<?php
	$group_types = config('consts')['USER']['GROUP_TYPE'][1];
	$auth_types = config('consts')['USER']['AUTH_TYPE'][0];
	$genders = config('consts')['USER']['GENDER'];
	$purposes = config('consts')['USER']['PURPOSE'][1];
	
?>
<div class="container register">
	<div class="form">
		<form id="groupstep3-form" class="form-horizontal" method="post" role="form" action="{{ url('/auth/register/enterdetaildata') }}" enctype="multipart/form-data">
			<input type="hidden" name="refresh_token" value="{{$user->refresh_token}}" id="refresh_token"/>
			<input type="hidden" name="user_id" value="{{$user->id}}" id="user_id"/>
			<input type="hidden" name="fileno" value="{{$user->fileno}}" id="fileno"/>
			<input type="hidden" name="upfilename" value="{{isset($_GET['upfilename']) ? $_GET['upfilename'] : ''}}" id="upfilename"/>
			<div class="form-wizard">
			    <div class="col-md-1" style="margin-top: 10px; padding: 0 !important;">
                    <a class="text-md-center" href="{{url('/')}}">
						<img class="logo_img" src="{{ asset('img/logo_img/logo_reserve_2.png') }}">
                        <!-- <h1 style="margin: 0 !important; font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', HGP明朝B;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1>
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
						<li class="nav-item active">
							<span class="step">
							<span class="number"> 2 </span>
							<span class="desc">
								<i class="fa fa-check"></i> ステップ２ 
							</span>
							</span>
						</li>
						<li class="nav-item active">
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
						<div class="progress-bar progress-bar-striped progress-bar-success" style="width:50%;">
						</div>
					</div>				
				</div>
			</div>

			<h3 class="text-md-center">団体会員詳細情報入力</h3>
			<a href="<?php echo asset('manual/group.pdf');?>" class="offset-md-11 btn btn-warning" style="margin-bottom: 10px;">入力方法</a>

			@if(count($errors) > 0)
				@include('partials.alert', array('errors' => $errors->all()))
			@endif
			{{ csrf_field() }}

			<div class="form-group">
				<div class="col-md-12">
					<table class="table table-bordered">
					    <tbody class="text-md-center">
					 		<tr class="info">
						        <td>団体・学校名</td>
						        <td>ふりがな</td>
						        <td>代表者</td>
						        <td>担当者</td>
							</tr>
					        <tr>
						        <td>
						        	{{$user->group_name}}
						        </td>
						        <td>
						        	{{$user->group_yomi}}
					        	</td>
						        <td>
						        	{{$user->rep_name}}
						        </td>
						        <td>
						        	{{$user->teacher}}
						        </td>
						        
					      	</tr>
					        <tr class="info">
						        <td colspan="2">所在地</td>
						        <td>メールアドレス</td>
						        <td>電話番号</td>
					      	</tr>
					        <tr>
						        
						        <td colspan="2">
						        	〒
						        	{{$user->address4}}―{{$user->address5}}
						        	{{$user->address1}}
						        	{{$user->address2}}
						        	{{$user->address3}}
						        						        	
						        </td>
						        <td>
						        	{{$user->email}}
						        </td>
						        <td>
						        	{{$user->phone}}
						        </td>
						        
					      	</tr>
					    </tbody>
					</table>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="control-label text-md-left col-md-10" style="font-size:16px">代表者本人確認書類アップロード:
					<a href="{{url('/security')}}" class="caption-subject theme-font bold uppercase" style="font-size:12px">個人情報保護方針はこちら</a>
				</label>	
			</div>

			<div class="form-group row {{ $errors->has('phone') ? ' has-danger' : '' }}" >
				<label class="control-label col-md-3 text-md-right">{{$auth_types['TITLE']}}:</label>
				<div class="col-md-4">
					<select name="auth_type" class="form-control bs-select">
						@foreach($auth_types['CONTENT'] as $key=>$auth_type )
							@if($user->auth_type == $key)
								<option value="{{$key}}" selected> {{$auth_type}} </option>
							@else
								<option value="{{$key}}"> {{$auth_type}} </option>
							@endif
						@endforeach
					</select>
					@if ($errors->has('auth_type'))
						<span class="form-control-feedback">
							<span>{{ $errors->first('auth_type') }}</span>
						</span>
					@endif
				</div>

				<div class="fileinput fileinput-new" data-provides="fileinput">
					<span class="btn btn-warning btn-file" style="margin-bottom: 10px">
					<span class="fileinput-new">ファイルを選択</span>
					<span class="fileinput-exists">変更</span>
					<input required type="file" name="authfile" id="authfile">

					</span>
					<span class="fileinput-filename">
					</span>
					&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
					</a>
				</div>
			</div>

			<div class="row form-group"> 
				<!-- <label class="control-label col-md-2 text-md-left" for="address4" style="font-size:16px;align-self:center">学校Wi-Fi:</label> -->
				<div class="col-md-3 text-md-right pt-2" style="padding-top: 15%">               
					<div class="col-md-3" style="padding-top:30px; display: inline">
                        <input type="{{"checkbox"}}" class="checkboxes" id="fixed_flag" name="fixed_flag" @if ($user->fixed_flag == 1) checked @endif>
                    </div>
                    <div class="tools col-md-9" style="padding-top: 10px"> 
                        <label class="label-above">学内IPで制限を行う。<br>(固定IPのみ）</label>                                                   
                    </div>
                </div>   				
				<!-- <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">Wi-Fi番号</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="wifi" name="wifi" value="{{$user->wifi}}" placeholder="53257">
                </div> -->
                
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">学校IPアドレス</label>                                                   
					</div>  
					@if(isset($user->ip_address) && $user->ip_address !== null && $user->ip_address !== "")
					<input type="{{"text"}}" class="form-control base_info text-md-right" name="ip_address"  id="ip_address" value="{{$local_ip}}" placeholder="192.100.10.21">
					@else
					<input type="{{"text"}}" class="form-control base_info text-md-right" name="ip_address"  id="ip_address" value="{{$local_ip}}" placeholder="192.100.10.21">
					@endif
                </div> 
                <!-- <div class="col-md-2 text-md-right">               
                    <div class="tools"> user->ip_address
                        <label class="label-above">NAT利用?</label>                                                   
                    </div>
                    <div style="padding-top:8px;">
                        <input type="{{"checkbox"}}" class="checkboxes" id="nat_flag" name="nat_flag" @if ($user->nat_flag == 1) checked @endif>
                    </div>
                </div>               
                
                <div class="col-md-2 text-md-right">                        
                    <div class="tools">
                        <label class="label-above">IP帯域</label>                                                   
                    </div>  
                    <input type="{{"text"}}" class="form-control base_info text-md-right" name="ip_global_address"  id="ip_global_address" value="{{$user->ip_global_address}}" placeholder="192.100.10.1">
                </div> -->
                <div class="col-md-2 text-md-right">               
                    <div class="tools">
                        <label class="label-above">ネットマスク</label>                                                   
                    </div>
                    <input type="{{"text"}}" class="form-control base_info text-md-right" id="mask" name="mask" value="{{$user->mask}}" placeholder="255.255.0.0">
                </div>
            </div>

			<div class="form-group row">
				<label class="control-label text-md-left col-md-12" style="font-size:16px">利用人数（アカウント数）の登録・・・　　　教師の人数および各クラスの児童生徒数を登録します。
				</label>
					
			</div>

			<div class="form-group row" class="class_container" id="class_container1">
				<label class="control-label col-md-1 text-md-right">会員種別:</label>
				<div class="col-md-2">
					<select class="form-control class_type" style="height: 33px !important">
						@foreach(config('consts')['CLASS_TYPE'] as $key =>$classType)
							<option value="{{$key}}"> {{$classType}}</option>
						@endforeach
					</select>
				</div>
				
				<div class="col-md-3">
					<label class="control-label col-md-2 text-md-right">学年:</label>
					<div class="col-md-10">
						<div id="counts">
							<div class="input-group">
								<select class="form-control class_grade" name="class_grade" style="height: 33px !important">
									<option value="0">無し</option>
									@for($i = 1; $i < 7; $i++)
									<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
						</div>
						<label class="help-block"  style="color:red">
							教師は学年・クラス名の入力不要
						</label>
					</div>
					
				</div>

				<label class="control-label col-md-1 text-md-right">クラス名:</label>
				<div class="col-md-2">					
					<div class="input-group">
						<input type="text" name="class_number" class="form-control class_number col-md-8" style="margin-right:10px">
						<label class="control-label text-md-left label-after-input col-md-2">組</label>

					</div>
					
				</div>
				
				<label class="control-label col-md-1 text-md-right">人数:</label>
				<div class="col-md-1">
					<div id="counts">
						<div class="input-group">
							<input required type="number" name="member_counts" class="spinner-input  form-control class_member_counts" maxlength="3" min="1" value="1">
						</div>
					</div>
				</div>
				<label class="control-label text-md-left label-after-input">名(半角)</label>
				
				<input type="hidden" value="" name="inform" id="inform">
				
<!--				<div class="col-md-2 text-md-right">-->
<!--					<div class="row">-->
<!--						<div class="col-md-7">-->
<!--							<label class="control-label text-md-left">合計:</label>-->
<!--						</div>-->
<!--						<div class="col-md-5">-->
<!--							<label class="control-label text-md-left" id="total_members" members="{{$totalMembers}}">{{$totalMembers}} 名</label>-->
<!--						</div>-->
<!--					</div>-->
<!--					<div class="row">-->
<!--						<div class="col-md-7">-->
<!--							<label class="control-label text-md-left">合計金額:</label>-->
<!--						</div>-->
<!--						<div class="col-md-5">-->
<!--							<label class="control-label text-md-left" id="total_price">{{$totalMembers*1200}}  円</label>-->
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
			</div>

			<div class="form-group row" id = "div-add">
				<div class="col-md-12 text-md-center">
					<div class="col-md-5"></div>
					<div class="col-md-1 text-md-right">
						<button type="button" class="btn btn-success btn-circle" id="class_add" cid="-1"><i class="fa fa-check"></i> 追　加 </button>
					</div>
					<div class="col-md-6 text-md-left">
						<button type="button" class="btn btn-danger btn-circle hide" id="class_cancel">キャンセル </button>
						<span class="help-block"  style="color:red" id="add_help">
							追加をクリックすると、下記の表に入力されます
						</span>
					</div>				
					
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
					
					<table class="table table-bordered" id="class_table">
						<thead>
							<tr class="info">
						        <th>会員種別</th>
						        <th>学年</th>
						        <th>クラス</th>
						        <th>人数</th>
						        <th style="color:red">修正</th>
						        <th style="color:red">削除</th>
							</tr>	
						</thead>
					    <tbody class="text-md-center">						
							@foreach($classes as $class)
							<tr id="trc_{{$class->id}}" cid="{{$class->id}}">
								<td>{{config('consts')['CLASS_TYPE'][$class->type]}}</td>
								<td>@if($class->grade != 0 ){{$class->grade}}@endif</td>
								<td>{{$class->class_number}}</td>
								<td>{{$class->member_counts}}</td>
								<td class='class_edit cicon'><i class='fa fa-edit'/></td>
								<td class='class_del cicon'><i class='fa fa-remove'/></td>
							</tr>
							@endforeach
								
					    </tbody>
					</table>
					<table class="table table-bordered" id="sum_table">
						<tr>
							<td>合計（児童生徒を含む人数）:</td>
							<td id="total_members" members="{{$totalMembers}}">{{$totalMembers}} 名</td>
							<td>会費合計（児童生徒を含める場合の年額）</td>
							<td id="total_price">{{$totalMembers*1200}}  円</td>
						</tr>
						<tr>
							<td>合計（児童生徒を含めない人数）:</td>
							<td id="nopupil_total_members" members="{{$nopupiltotalMembers}}">{{$nopupiltotalMembers}} 名</td>
							<td>会費合計（児童生徒を含めない場合の年額）</td>
							<td id="nopupil_total_price">{{$nopupiltotalMembers*1200}}  円</td>
						</tr>
					</table>
					
				</div>
			</div>
			
			<div class="form-group form-actions row">
				<div class="offset-md-4 col-md-4 text-md-center col-sm-12" style="margin-bottom:8px">
					<button type="submit" id="submit_btn" class="btn btn-success">確認画面</button>
				</div>
				<div class="col-md-4 text-md-right col-sm-12" style="margin-bottom:8px">
					<a href="{{url('/')}}" class="btn btn-info">読Qトップへ戻る</a>
				</div>
			</div>
			<input type="hidden" name="class_info" value=""/>
		</form>
		
	</div>
</div>
<!-- Modal -->
<div id="alertModal" class="modal fade draggable draggable-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>エラー</strong></h4>
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
@stop
@section('scripts')
	<style>
		.cicon{
			text-align: center;
			cursor: pointer;
		}
		.cicon i{
			font-size: 15px;
			color: red;			
		}
	</style>
	<script type="text/javascript">
		var handleInputMasks = function () {
	        $.extend($.inputmask.defaults, {
	            'autounmask': true
	        });
	        
	        $("#phone").inputmask("mask", {
	            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
	        }); //specifying fn & options
	    }
     	var handleSpinners = function () {
        
	        $('.spinner-input').parent().parent().spinner({value:0, min: 0});
	        
	    }
	    handleInputMasks();
	    handleSpinners();

	    $(document).ready(function(){	
	    	
	    	//$('.fileinput-filename').text($("#upfilename").val());

	    	var handlefilesize = function () {
	    		var fileno = $("#fileno").val();
	    		if(fileno == 'no'){
	    			$("#alert_text").html("{{config('consts')['MESSAGES']['PASSWORD_EXIST']}}");
	        		$("#alertModal").modal();
	    		}
	    		
	    		if($(".class_type").val() == 0 || $(".class_type").val() == 1 || $(".class_type").val() == 2 || $(".class_type").val() == 3){
	    			$(".class_grade").attr("disabled",true);
	    			$(".noteacher").removeClass("hide");
					$(".noteacher").addClass("show");
	    		}
				else{
					$(".class_grade").attr("disabled",false);
					$(".noteacher").removeClass("show");
					$(".noteacher").addClass("hide");
				}
			}
	    	 handlefilesize();
			$("#class_cancel").click(function(){
				$("#class_add").html("<i class='fa fa-check'></i>追　加");
				$("#class_add").attr("cid",0);
				$("#class_cancel").addClass("hide");
				
				$(".class_type").val(0);
				$(".class_grade").val(0);
//				$(".class_number").val(1);
				$(".class_member_counts").val(1);
			});

			$(".class_type").change(function(){
				
				if($(".class_type").val() == 0 || $(".class_type").val() == 1 || $(".class_type").val() == 2 || $(".class_type").val() == 3)
				{
					$(".class_grade").attr("disabled",true);
					$(".noteacher").removeClass("hide");
					$(".noteacher").addClass("show");
				}	
				else{
					$(".class_grade").attr("disabled",false);
					$(".noteacher").removeClass("show");
					$(".noteacher").addClass("hide");
				}
					
			});
 			
	    	$(".class_del").click(function(){
				var id = $(this).parent().attr("cid");
				var userid = $("#user_id").val();
				$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/del?id=" + id + "&userid="+userid,
				function(data){
					/*var total_members = parseInt($("#total_members").attr("members"));
					var tds = $("#trc_" + id + " td");
					total_members -=parseInt($(tds[3]).html());
					$("#total_members").attr("members", total_members);
					$("#total_members").html(total_members+" 名");
					$("#total_price").html((total_members*1200)+ "  円");

					var nopupil_total_members = parseInt($("#nopupil_total_members").attr("members"));
					if(class_type < 4)
						nopupil_total_members -=parseInt($(tds[3]).html());
					$("#nopupil_total_members").attr("members", nopupil_total_members);
					$("#nopupil_total_members").html(nopupil_total_members+" 名");
					$("#nopupil_total_price").html((nopupil_total_members * 1200)+ "  円");*/

					$("#total_members").attr("members", data1.totalMembers);
					$("#total_members").html(data1.totalMembers+" 名");
					$("#total_price").html((data1.totalMembers*1200)+ "  円");

					$("#nopupil_total_members").attr("members", data1.nopupiltotalMembers);
					$("#nopupil_total_members").html(data1.nopupiltotalMembers+" 名");
					$("#nopupil_total_price").html((data1.nopupiltotalMembers * 1200)+ "  円");

					$("#trc_" + id).remove();
					var n = $("#class_table tbody tr").length;
					
				});
			});

			$(".class_edit").click(function(){
				var cid = $(this).parent().attr("cid");

				$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/get?id=" + cid,
					function(data){
						$(".class_type").val(data.type);
						$(".class_grade").val(data.grade);
						$(".class_number").val(data.class_number);
						$(".class_member_counts").val(data.member_counts);
						
						$("#class_add").attr("cid",data.id);
						$("#class_add").html("&nbsp;更&nbsp; 新&nbsp;");
						$("#class_cancel").removeClass("hide");
						$("#add_help").addClass("hide");

					});
				
			});

			$("#class_add").click(function(){
				var cid = $(this).attr("cid");
				var class_type =  $(".class_type").val();
				var class_grade = $(".class_grade").val();
				var members = $(".class_member_counts").val();
				var class_number = $(".class_number").val();
				var group_id = '<?php echo $user->id?>';

				if(class_type == -1 || class_grade == -1 ){
					//alert("please select correct Class Type, Grade");
					//$("#alert_text").html("please select correct Class Type, Grade");
					$("#alert_text").html("{{config('consts')['MESSAGES']['WRONG_DATA']}}");
	        		$("#alertModal").modal();
				}else if(members == '' || members < 1){
					$("#alert_text").html("{{config('consts')['MESSAGES']['NUMBERS_DATA']}}");
	        		$("#alertModal").modal();
				}else{
					$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/check?type="+class_type+"&grade="+class_grade+"&group_id="+group_id+"&class_number="+class_number+"&cid="+cid,
						function(data, status){

						if(data == "false"){
							//alert("please select correct Class Type, Grade");
							$("#alert_text").html("{{config('consts')['MESSAGES']['WRONG_MEMBERDATA_DOUBLE']}}");
	        				$("#alertModal").modal();
						}else{
						var class_types = JSON.parse('<?php echo json_encode(config('consts')['CLASS_TYPE'])?>');

						if(cid==-1){							
							$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/add?type="+class_type+"&grade="+class_grade+"&member_counts="+members + "&group_id="+group_id+"&class_number="+class_number,
								function(data, status){
									/*var total_members = parseInt($("#total_members").attr("members"));
									total_members +=parseInt(members); 
									$("#total_members").attr("members", total_members);
									$("#total_members").html(total_members+" 名");
									$("#total_price").html((total_members * 1200)+ "  円");

									var nopupil_total_members = parseInt($("#nopupil_total_members").attr("members"));
									if(class_type < 4)
										nopupil_total_members +=parseInt(members);
									$("#nopupil_total_members").attr("members", nopupil_total_members);
									$("#nopupil_total_members").html(nopupil_total_members+" 名");
									$("#nopupil_total_price").html((nopupil_total_members * 1200)+ "  円");*/

									$("#total_members").attr("members", data.totalMembers);
									$("#total_members").html(data.totalMembers+" 名");
									$("#total_price").html((data.totalMembers*1200)+ "  円");

									$("#nopupil_total_members").attr("members", data.nopupiltotalMembers);
									$("#nopupil_total_members").html(data.nopupiltotalMembers+" 名");
									$("#nopupil_total_price").html((data.nopupiltotalMembers * 1200)+ "  円");
								
									$("#class_add").attr("cid","-1");
									$(".class_type").val(0);
									$(".class_grade").val(0);
									$(".class_number").val("");
									$(".class_member_counts").val(1);
									
									var html = $("#class_table tbody").html();
									html +="<tr id='trc_"+data.newclass.id+"' cid='"+data.newclass.id+"'>";
									html += "<td>" + class_types[class_type] + "</td>";
									if(class_grade != 0)
										html += "<td>" + class_grade + "</td>";
									else
										html += "<td></td>";
									html += "<td>" + class_number+"</td>";
									html += "<td>" + members + "</td>";
									html += "<td class='class_edit cicon'><i class='fa fa-edit'></a></td>";
									html += "<td class='class_del cicon'><i class='fa fa-remove'></a></td>";
									html += "</tr>";
									

									$("#class_table tbody").html(html);
									$("#class_table").removeClass("hide");	
			
									$(".class_del").click(function(){
										var id = $(this).parent().attr("cid"); 
										var userid = $("#user_id").val();
										$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/del?id=" + id + "&userid="+userid,
										function(data1){
											/*var total_members = parseInt($("#total_members").attr("members"));
											var tds = $("#trc_" + id + " td");
											total_members -=parseInt($(tds[3]).html());
											$("#total_members").attr("members", total_members);
											$("#total_members").html(total_members+" 名");
											$("#total_price").html((total_members*1200)+ "  円");

											var nopupil_total_members = parseInt($("#nopupil_total_members").attr("members"));
											if(class_type < 4)
												nopupil_total_members -=parseInt($(tds[3]).html());
											$("#nopupil_total_members").attr("members", nopupil_total_members);
											$("#nopupil_total_members").html(nopupil_total_members+" 名");
											$("#nopupil_total_price").html((nopupil_total_members * 1200)+ "  円");*/
											
											$("#total_members").attr("members", data1.totalMembers);
											$("#total_members").html(data1.totalMembers+" 名");
											$("#total_price").html((data1.totalMembers*1200)+ "  円");

											$("#nopupil_total_members").attr("members", data1.nopupiltotalMembers);
											$("#nopupil_total_members").html(data1.nopupiltotalMembers+" 名");
											$("#nopupil_total_price").html((data1.nopupiltotalMembers * 1200)+ "  円");

											$("#trc_" + id).remove();
											var n = $("#class_table tbody tr").length;
											
										});
									});
			
									$(".class_edit").click(function(){
										var cid = $(this).parent().attr("cid");
			
										$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/get?id=" + cid,
											function(data){
												$(".class_type").val(data.type);
												$(".class_grade").val(data.grade);
												$(".class_number").val(data.class_number);
												$(".class_member_counts").val(data.member_counts);
		
												$("#class_add").attr("cid",data.id);
												$("#class_add").html("&nbsp;更&nbsp; 新&nbsp;");
												$("#class_cancel").removeClass("hide");
												$("#add_help").addClass("hide");
											});
										
									});
								});
						}else{
							$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/update?type="+class_type+"&grade="+class_grade+"&member_counts="+members + "&group_id="+group_id + "&id="+cid+"&class_number="+class_number,
									function(data, status){
										/*var total_members = parseInt($("#total_members").attr("members"));
										var tds = $("#trc_" + cid + " td");
										total_members -=parseInt($(tds[3]).html());
										total_members +=parseInt(members);
										$("#total_members").attr("members", total_members);
										$("#total_members").html(total_members+" 名");
										$("#total_price").html((total_members * 1200)+ "  円");

										var nopupil_total_members = parseInt($("#nopupil_total_members").attr("members"));
										
										if(class_type < 4){
											nopupil_total_members -=parseInt($(tds[3]).html());
											nopupil_total_members +=parseInt(members);
										}
										$("#nopupil_total_members").attr("members", nopupil_total_members);
										$("#nopupil_total_members").html(nopupil_total_members+" 名");
										$("#nopupil_total_price").html((nopupil_total_members * 1200)+ "  円");*/

										$("#total_members").attr("members", data.totalMembers);
										$("#total_members").html(data.totalMembers+" 名");
										$("#total_price").html((data.totalMembers*1200)+ "  円");

										$("#nopupil_total_members").attr("members", data.nopupiltotalMembers);
										$("#nopupil_total_members").html(data.nopupiltotalMembers+" 名");
										$("#nopupil_total_price").html((data.nopupiltotalMembers * 1200)+ "  円");
								
									    var html ="<td>" + class_types[class_type] + "</td><td>";
										if(class_grade != 0)
											html += class_grade;
										html += "</td><td>"+class_number+"</td><td>" + members + "</td><td class='class_edit cicon'><i class='fa fa-edit'></a></td><td class='class_del cicon'><i class='fa fa-remove'></a></td>";

										$("#trc_" + cid).html(html);
										$("#class_add").html("<i class='fa fa-check'></i>追　加");
										$("#class_add").attr("cid",-1);
										$("#class_cancel").addClass("hide");
										$("#add_help").removeClass("hide");
			
										$(".class_type").val(0);
										$(".class_grade").val(0);
										$(".class_number").val('');
										$(".class_member_counts").val(1);
										$("#class_add").attr("cid",-1);
		
										$(".class_del").click(function(){
											var id = $(this).parent().attr("cid");
											var userid = $("#user_id").val();
											$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/del?id=" + id + "&userid="+userid,
											function(data1){
												/*var total_members = parseInt($("#total_members").attr("members"));
												var tds = $("#trc_" + id + " td");
												total_members -=parseInt($(tds[3]).html());
												$("#total_members").attr("members", total_members);
												$("#total_members").html(total_members+" 名");
												$("#total_price").html((total_members*1200)+ "  円");

												var nopupil_total_members = parseInt($("#nopupil_total_members").attr("members"));
												if(class_type < 4)
													nopupil_total_members -=parseInt($(tds[3]).html());
												$("#nopupil_total_members").attr("members", nopupil_total_members);
												$("#nopupil_total_members").html(nopupil_total_members+" 名");
												$("#nopupil_total_price").html((nopupil_total_members * 1200)+ "  円");*/

												$("#total_members").attr("members", data1.totalMembers);
												$("#total_members").html(data1.totalMembers+" 名");
												$("#total_price").html((data1.totalMembers*1200)+ "  円");

												$("#nopupil_total_members").attr("members", data1.nopupiltotalMembers);
												$("#nopupil_total_members").html(data1.nopupiltotalMembers+" 名");
												$("#nopupil_total_price").html((data1.nopupiltotalMembers * 1200)+ "  円");

												$("#trc_" + id).remove();
												var n = $("#class_table tbody tr").length;
												
											});
										});
				
										$(".class_edit").click(function(){
											var cid = $(this).parent().attr("cid");
				
											$.get("<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/classes/get?id=" + cid,
												function(data){
													$(".class_type").val(data.type);
													$(".class_grade").val(data.grade);
													$(".class_number").val(data.class_number);
													$(".class_member_counts").val(data.member_counts);
		
													$("#class_add").attr("cid",data.id);
													$("#class_add").html("&nbsp;更&nbsp; 新&nbsp;");
													$("#class_cancel").removeClass("hide");
													$("#add_help").addClass("hide");
												});
											
										});
							});							
							}
						}
					});
				}
			});
			
			
	    });
	</script>
	<script type="text/javascript" src="{{asset('js/login.js')}}"></script>
@stop