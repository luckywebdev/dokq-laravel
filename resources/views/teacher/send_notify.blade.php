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
	            	<a href="{{url('/')}}">
	                	> 団体教師トップ
	                </a>
	            </li>
	            <li class="hidden-xs">
	                <a href="#"> > 児童生徒検索</a>
	            </li>
	            <li class="hidden-xs">
	                <a href="#"> > お知らせ入力</a>
	            </li>
	        </ol>
	        </div>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<h3 class="page-title">
				児童生徒へ連絡、お知らせ、おすすめなど<br>
				<small>(児童のマイ書斎の連絡帳欄に表示されます)</small>
			</h3>

			<div class="row">
				<div class="col-md-12">
					<form class="form-horizontal form" role="form" action="{{url('teacher/post_notify')}}" method="post">
						{{csrf_field()}}
						<input type="hidden" name="pupil" value="{{$toId}}"/>

						<div class="form-group row">

							<label class="control-label col-md-12 text-md-center">
							@foreach($classes as $class)
								@if($class->grade==0)
									{{$class->class_number}}学級								
									@else
										{{$class->grade}}-{{$class->class_number}}
								@endif
							@endforeach &nbsp;
							@foreach($users as $user)
								{{$user->fullname()}}さん&nbsp;
							@endforeach
							宛</label>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">入力欄 100字以内</label>
							<div class="col-md-8">
								<textarea class="form-control msg_content" rows="5" name="content" maxlength="100"></textarea>
							</div>
							<div class="col-md-2 notify_send">
								<button type="submit" class="btn btn-success">確認して送信</button>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12">
								<table class="table table-bordered-purple table-hover">
									<thead>
										<tr class="info">
											<th width="15%">送信日時</th>
											<th width="20%">宛名</th>
											<th width="50%">文面</th>
											<th width="15%">削除</th>
										</tr>
									</thead>
									<tbody class="text-md-center">
										@foreach($messages as $message)
										<tr>
											<td width="15%" >{{date_format($message->created_at,'Y.m.d.H.i a')}}</td>
											<td width="20%">{{$message->to_username}}</td>
											<td width="50%">{{$message->content}}</td>
											<td width="15%">@if(isset($message) && $message->del_flag == 1) 削除
											    @else <a href="{{url('teacher/del_notify?id='.$message->id)}}">削除</a>@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</form>					
				</div>
			</div>
		</div>
	</div>

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
    <script type="text/javascript">
    	$("#class").change(function(){
    	    location.href = "/teacher/send_notify?class=" + $("#class").val();
    	});
		var isChecked = false;
    	$(".form-horizontal:first").submit(function(){
		    if (isChecked) return true;
    	    if ($("#class").val() == -1) {
                $("#alert_text").html("{{config('consts')['MESSAGES']['CLASS_REQUIRED']}}");
                $("#alertModal").modal();
    	    } else if ($("#pupil").val() == -1) {
                $("#alert_text").html("{{config('consts')['MESSAGES']['PUPIL_REQUIRED']}}");
                $("#alertModal").modal();
    	    } else if ($(".msg_content").val() == "") {
                $("#alert_text").html("{{config('consts')['MESSAGES']['REQUIRED']}}");
                $("#alertModal").modal();
    	    } else {
		        isChecked = true;
                $(".form-horizontal").submit();
    	    }
			return false;
    	});
    </script>
@stop