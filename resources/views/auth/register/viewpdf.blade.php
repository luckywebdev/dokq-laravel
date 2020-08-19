@extends('auth.layout')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/news.css')}}">
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
@stop
	
@section('contents')
<!--<div class="container register">-->

<div >	
	<div  style="margin-bottom:5px">
		<form class="form-horizontal" method="get" role="form" action=" route('authregister/0/1')">
		<input type="hidden" name="role" id="role" value="{{$role}}">
		<input type="hidden" name="data" id="data" value="{{$data}}">
		<input required type="hidden" id="pdfheight" name="pdfheight" value="">

		<embed width="100%" height="{{session('pdfheight')}}" name="plugin" id="plugin" src="<?php echo asset($helpdoc)?>" type="application/pdf" internalinstanceid="87">	
		</form>
		</div>
	
	<div >
		<div class="col-md-12">		
			<button type="button" id="back" class="btn btn-info pull-right"  style="margin-top:0px" >戻　る</button>
		</div>
	</div>
	<div style="margin:0px"></div>
	
</div>
@stop

@section('scripts')
	<script type="text/javascript">	
		$("#plugin").css("height", $(window).height()- 55);
		
		$("#back").click(function(){
			var role = $("#role").val(); 
			var beforepage = "";
			if(role == 0) beforepage = "/auth/register/0/1";
			else if(role == 1) beforepage = "/auth/register/1/1";
			else if(role == 2) beforepage = "/auth/register/2/1";
			else if(role == 3) beforepage = "/auth/register/3/1";
			else{
				history.go(-1);
				return;
			} 
			
	    	$(".form-horizontal").attr("action", beforepage);
		    $(".form-horizontal").submit();

		     
	    })
	</script>
@stop