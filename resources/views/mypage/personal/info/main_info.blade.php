@extends('layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
<style>
	.tools{
		float:left !important;
		margin-bottom:5px !important;
	}
</style>
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="{{url('/mypage/top')}}">
                		> マイ書斎
                	</a>
	            </li>
	            <li class="hidden-xs">
	            	@if($type == 'view')
            	   	 > 基本情報
            	   	@elseif ($type == "edit")
            	   	 > 基本情報の編集
            	   	@elseif ($type == "other_view")
            	   	 > 他人から見た基本情報を確認
	           		@endif
	            </li>	            
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">@if(isset($type) && $type == "other_view")他人から見た基本情報を確認する@else基本情報@endif</h3>
			@if($type == 'view')
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-warning pull-right" href = "/mypage/other_view_info">他人から見た基本情報の表示を確認</a>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="col-md-12">
					@include('mypage.personal.info.info_form')
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<button type="button" class="btn btn-info pull-right" onclick="javascript:history.go(-1)">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong style="font-family: 'Judson'">読Q</strong></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<p>
						更新しました。
					</p>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<a class="btn btn-info" href="{{url('/mypage/top')}}">マイ書斎へ戻る</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	
	<script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="{{asset('plugins/flot/jquery.flot.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.resize.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.pie.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.stack.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.crosshair.min.js')}}"></script>
	<script src="{{asset('plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<script src="{{asset('js/charts-flotcharts.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('plugins/jquery-validation/js/localization/messages_ja.min.js')}}"></script>
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
    	$(document).ready(function(){
    		@if(isset($id) && $id !== null)
    			$('body').addClass('page-full-width');
    			var unique_id = $.gritter.add({
                        // (string | mandatory) the heading of the notification
                        title: '',
                        // (string | mandatory) the text inside the notification
                        text: '他者ページ閲覧中',
                        // (string | optional) the image to display on the left
                        image: '',
                        // (bool | optional) if you want it to fade out on its own or just sit there
                        sticky: true,
                        // (int | optional) the time you want it to be alive for before fading out
                        time: '',
                        // (string | optional) the class name you want to apply to that specific message
                        class_name: 'my-sticky-class'
                    });
 			@endif
    		ComponentsDropdowns.init();
//    		FormValidation.init();
    		@if($type == 'other_view')
        		$('.make-switch').remove();
        	@endif
    		$('.make-switch').bootstrapSwitch({

				onText: "公開",
				offText: "非公開"
			});
        	$(".make-switch").on('switchChange.bootstrapSwitch', function(){
				var post_url;
				post_url = "<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'] ?>/mypage/top/setpublic/" + $(this).attr('id');
				$.ajax({
					type: "post",
		      		url: post_url,
				    data: {},
				    
					beforeSend: function (xhr) {
			            var token = $('meta[name="csrf-token"]').attr('content');
			            if (token) {
			                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
			            }
			        },		    
				    success: function (response){
				    	if(response.type == 'fullname_is_public'){
				    		
				    		if(response.status){
				    			$(".fullname_is_public").attr('checked', 'checked');
				    			$(".fullname_is_public").parent().parent().removeClass('bootstrap-switch-off');
				    			$(".fullname_is_public").parent().parent().addClass('bootstrap-switch-on');
					    		$(".username_is_public").removeAttr('checked');
					    		$(".username_is_public").parent().parent().removeClass('bootstrap-switch-on');
				    			$(".username_is_public").parent().parent().addClass('bootstrap-switch-off');
					    	}else{
					    		$(".fullname_is_public").removeAttr('checked');
					    		$(".fullname_is_public").parent().parent().removeClass('bootstrap-switch-on');
				    			$(".fullname_is_public").parent().parent().addClass('bootstrap-switch-off');
					    		$(".username_is_public").attr('checked', 'checked');
					    		$(".username_is_public").parent().parent().removeClass('bootstrap-switch-off');
				    			$(".username_is_public").parent().parent().addClass('bootstrap-switch-on');
					    	}
				    	}
			    	}
				});
			});
			$('#update_info').click(function(){
				$('#validate-form').submit();
			});
			@if(isset($update) && $update == 'ok')
				$("#confirmModal").modal({backdrop: "static", keyboard: false});$(".draggable").draggable({handle: ".modal-header"});
				
			@endif

			var oldBirthday = "";

			 $("#birthday").change(function() {
			    if ($("#birthday").val() == "" || oldBirthday == $("#birthday").val()) {
			        return;
			    }
			    oldBirthday = $("#birthday").val()
			    handleDupUserCheck();
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
		        $("#phone").inputmask("mask", {
		            "mask": "<?php echo config('consts')['PHONE_MASK'] ?>"
		        });
		        $("#address4").inputmask("mask", {
			        "mask":"999"
		        });
				$("#address5").inputmask("mask", {
			        "mask":"9999"
		        });
				$("#address6").inputmask("mask",{
			        "mask":"99999"
				});
				$("#address7").inputmask("mask",{
			        "mask":"9999"
				});
				$("#address8").inputmask("mask",{
			        "mask":"9999"
				});$("#address10").inputmask("mask",{
			        "mask":"*****"
				});

		    }
		    handleDatePickers();
		    handleInputMasks();
    	})
    </script>
@stop