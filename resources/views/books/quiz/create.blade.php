@extends('layout')
@section('styles')
    
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
					> <a href="{{url('book/search')}}">読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					> クイズを作る
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="offset-md-2 col-md-8">
					
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="row">
								<div class="col-md-12">
									<h3 class="text-center margin-top-10 margin-bottom-10" style="font-weight: 600">
										クイズ作成カード
									</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										タイトル： <strong>{{$book->title}}</strong>
									</h5>
								</div>
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										著者:  {{$book->fullname_nick()}}
									</h5>
								</div>
								<div class="col-md-4">
									<h5 class="text-center margin-bottom-10 margin-top-10">
										読Q本ID: dq{{$book->id}}
									</h5>
								</div>
							</div>

						</div>
						<div class="portlet-body margin-top-10">
							<div class="form">
								@include('books.quiz.form')
							</div>
							<input type="hidden" id="bookPages" name="bookPages" value="{{$book->pages}}">
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<button class="btn btn-warning float-right">クイズを作る際の注意</button>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script src="{{asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('js/components-dropdowns.js')}}"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('body').addClass('page-full-width');
    		ComponentsDropdowns.init();
    		var handleComponents = function() {
		        $('#quiz').maxlength({
		            limitReachedClass: "label label-danger",
		            alwaysShow: true
		        });
		        $("#app_page").spinner({
		        	min: 1,
		        	value: 0,
		        	step: 1,
		        	max: $("#bookPages").val()
		        })
		    }
		    handleComponents();
		     $(".btn-warning").click(function(){
		    	//$("#quiz").val('');
		    	location.href = '/quiz/answer';
		    });

		    setInterval(function(){
                var question_txt = $("#quiz").val();
                var question_ary = question_txt.split("＃");
                var question_ary1 = question_txt.split("#");
                if(question_txt.length > 0){
                	$(".text_err").removeClass("hide");
                	$(".text_err").html("{{config('consts')['MESSAGES']['POUND_NO']}}");
                }
                if(question_ary.length > 2 || question_ary1.length > 2){
                	$(".btn-primary").removeAttr('disabled');
                	$(".text_err").addClass('hide');
                }
                else{
                	$(".btn-primary").attr('disabled', true);
                }

            },1000)
    	})
    </script>
@stop