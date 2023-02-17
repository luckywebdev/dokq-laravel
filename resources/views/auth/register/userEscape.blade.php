@extends('layout')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/login/login.css')}}">
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container-fluid">
	        <ol class="breadcrumb">
	            <li>
					<a class="text-md-center" href="{{url('/')}}">
						<!-- <img class="logo_img" src="{{ asset('img/logo_img/logo_reserve_2.png') }}"> -->
	                <a href="{{url('/')}}" style="font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson'">
	                	読<span style="font-family: 'Judson'">Q</span>
	                </a>
	            </li>
	            <li class="hidden-xs">
	                > 退会
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')

	<div class="modal fade draggable draggable-modal" id="authModal" role="basic" aria-hidden="true">
		<div class="modal-dialog" >		    
			<div class="modal-content">
				<div class="modal-header">
					
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="form-group">							
							<p>読Q退会を承りました。会費の支払い停止手続きを始めます。<br>					
								手続きが終わり次第、Eメールにてご連絡いたします。					
							</p>
					 	</div>
					 </div>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button type="button" data-dismiss="modal" id = "logoutEscape" class="btn btn-info modal-close">戻　る</button>
				</div>
			</div>
		</div>
	</div>

@stop

@section('scripts')
	<script type="text/javascript" src="{{asset('js/group/group.js')}}"></script>
	<script type="text/javascript">
	$('body').addClass('page-full-width');
		$(document).ready(function(){
			
			flag = 100;
			if(flag != 2){
				$("#authModal").modal({
	   				backdrop: 'static',
					keyboard: false
				});
			}
			$("#logoutEscape").click(function(){
				location.href="{{route('logout')}}";
			});
		
   			var handleInputMasks = function () {
		        $.extend($.inputmask.defaults, {
		            'autounmask': true
		        });

		        $("#birthday").inputmask("y/m/d", {
		        }); //multi-char placeholder

		    }
		 
		 
		    
		})
    </script>
@stop