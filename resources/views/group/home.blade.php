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
			                > 団体アカウントトップ
			            </li>
			        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">団体トップページ</h3>
			
			<form action="/group/edit_teacher_top" class="form-horizontal">
				<div class="form-body">
					<div class="form-group" style="margin-top:10px;margin-bottom:20px;">
						<div class="col-md-12">
							<div class="portlet solid blue">
								<div class="portlet-title" style="font-size:18px;">
									<p><b>読Qからのお知らせ</b></p>
								</div>
								<div class="portlet-body" style="font-size:18px;">
									
									@if(count($messages) > 0)
										@foreach($messages as $mess)
											<p>({{with((date_create($mess->created_at)))->format('Y.m.d')}}) @if($mess->from_id == Auth::id()){{$mess->post}}@else{{$mess->content}}@endif</p>
										@endforeach
									@else
									<br>									
									@endif
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2"  style="margin-bottom:8px;">学級を選択</label>
						<div class="col-md-4"  style="margin-bottom:8px;">
							<select name="group_id" class="bs-select form-control">
								@foreach($classes as $class)
								<option value="{{$class->id}}" @if($current_season < $class->year) disabled @endif>
								@if($class->grade == 0)									
									@if($class->class_number !== null && $class->class_number != '')
										{{$class->class_number}}
										@if($class->teacher_name !== null && $class->teacher_name != '')
											{{$class->teacher_name}} 
										@endif
										学級 /
									@else
										@if($class->teacher_name !== null && $class->teacher_name != '')
											{{$class->teacher_name}} 学級 /
										@endif
									@endif
								@elseif($class->class_number == '' || $class->class_number == null)
									{{$class->grade}} {{$class->teacher_name}}年 /
								@else
									{{$class->grade}}-{{$class->class_number}} {{$class->teacher_name}}学級 /
								@endif	
								{{$class->year}}年度							
								@if($class->member_counts != 0 && $class->member_counts !== null)
								 	{{$class->member_counts}}名
								@endif									
								</option>
								@endforeach
<!--								<option>〇-〇中村学級/2017年度　33名</option>-->
							</select>
						</div>
						<div  style="margin-bottom:8px;">
							<button type="submit" class="btn btn-primary">学級トップページへ</button>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-info pull-right" href="{{url('/')}}">読Qトップへ戻る</a>
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script src="{{asset('js/components-dropdowns.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			ComponentsDropdowns.init();
		});
    </script>
@stop