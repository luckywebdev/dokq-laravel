@extends('layout')
@section('styles')
    
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container-fluid">
	    	<div class="row">
		        <ol class="breadcrumb">
		            <li>
		                <a href="{{url('/')}}">
		                	読Qトップ
		                </a>
		            </li>
		            <li class="hidden-xs">
	                	 > 団体アカウント 
		            </li>
		            <li class="hidden-xs">
	                	<a href="#"> > 団体マニュアル</a>
		            </li>
		        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">団体</h3>

			<div class="row">
				<iframe class="iframe_help_score" src="{{asset('/manual/group_manual.pdf')}}"></iframe>
			</div>
			
		</div>
	</div>
@stop
@section('scripts')
    
@stop