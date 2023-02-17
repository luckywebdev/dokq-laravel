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
					<a href="{{url('book/search')}}"> > 読Q本の検索</a>
				</li>
				<li class="hidden-xs">
					<a href="#"> > 年代別 読Q推薦図書、ジャンル、新読Q本からさがす</a>
				</li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">年代別 読Q推薦図書、ジャンル、新読Q本からさがす</h3><br>
							
			<div class="row">
				<div class="col-md-12">
				  	<div class="form form-horizontal">
						
						<form class="form-group row" action="{{url('book/search/gene')}}">
						
							<div class="offset-md-1 col-md-4">
								<h4 class="text-md-right">
									年代別 読Q推薦図書からさがす<br>
									<small>(登録の新しいものから表示されます）</small>
								</h4>
							</div>
							<div class="col-md-4">
								<select class="bs-select form-control" name="gene">
									<!-- <option></option> -->
									@foreach(config('consts')['BOOK']['SEARCH_RECOMMENDS'] as $key=>$recommend)
										<option value="{{$key}}">{{$recommend}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>

						<form class="form-group row " action="{{url('book/search/category')}}">
							<div class="offset-md-1 col-md-4">
								<h4 class="text-md-right">
									ジャンルからさがす<br>
									<small>(登録の新しいものから表示されます）</small>
								</h4>
							</div>
							<div class="col-md-4">
								<select class="form-control bs-select" name="categories[]" multiple >
									@foreach($categories as $category)
										<option value="{{$category->id}}" @if($category->id==9) selected @endif>{{$category->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>
						<form class="form-group row" action="{{url('book/search/latest')}}">
							<div class="offset-md-1 col-md-6">
								<h4 class="text-md-right">この1か月間に新しく読Q本に認定された本からさがす</h4>
							</div>
							<div class="col-md-2 offset-md-2">
								<button class="btn btn-primary"> 次へ <i class="fa fa-search"></i></button>
							</div>
						</form>
							<div class="form-actions right">
								<a href="{{url('book/search')}}" class="btn btn-info pull-right">戻　る</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
    <script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').addClass('page-full-width');
			ComponentsDropdowns.init();
		});
    </script>
@stop