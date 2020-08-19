@extends('layout')

@section('styles')
@stop
@section('breadcrumb')
	<div class="breadcum">
	    <div class="container" style="width: 100%;">
	        <ol class="breadcrumb">
	            <li>
	                <a href="{{url('/')}}">
	                	読Qトップ 
	                </a>
	            </li>
	            <li class="hidden-xs">
	            	<a href="#">
	                	 > マイ書斎
	                </a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">マイ書斎</h3>

			<div class="row">
				<div class="col-md-12">
					
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script>
		jQuery(document).ready(function() {
			$('body').addClass('page-full-width');
		});   
	</script>
@stop