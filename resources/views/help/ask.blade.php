@extends('layout')
@section('styles')
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="{{asset('css/pages/timeline.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('css/pages/news.css')}}" rel="stylesheet" type="text/css"/>
	<!-- END PAGE LEVEL STYLES -->
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
                	<a href="{{url('/about_site')}}"> > 読Qとは</a>
	            </li>
	             <li class="hidden-xs">
                	<a href="#"> > お問合せ</a>
	            </li>
	        </ol>
	    </div>
	</div>
@stop
@section('contents')
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="row">
				<div class="col-md-12">
					<span class="" style="color: #80b8e6; border-bottom: 5px solid #feb8ce; font-size: 40px; font-weight: bolder; text-stroke:#feb8ce; text-shadow: 2px 2px 0px #FFFFFF, 5px 4px 0px rgba(0,0,0,0.15), 8px 0px 3px #feb8ce; padding-right: 10%">お問合せ</span>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<br>
					<p style="font-size:16px;">
						読Ｑに関しての質問や、検定やウェブサイトについてのお問合せを受け付けています。会員の方はログインしてから入力してください。<br>
						会員の方への返信は、読Ｑ連絡帳宛とさせていただきます。非会員の方への返信はＥメールにて返信いたします。<br>
						少人数で対応しているため、返信に時間を要しますこと、ご理解いただきますようお願い申し上げます。<br>

					</p>
				</div>
			</div>

			<div class="row" >
				<div class="col-md-12" style="margin-left: 100px; margin-top: 1%;">
					<form class="form-horizontal form" role="form" action="{{url('/ask/sendMessage')}}" method="post">
						{{csrf_field()}}
						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">受付日:</label>	
							<div class="col-md-3">
								<input type="text" class="form-control" name="send_day" id="send_day" value="{{Date('Y/m/d')}}" readonly>
							</div>
						</div>
						<div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right">お名前:</label>	
							<div class="col-md-3">
							@if(isset($user) && $user->role ==config('consts')['USER']['ROLE']['GROUP'])
								@if(isset($user))
									<input type="hidden" name="id" id="id" value="{{$user->id}}" >
									<input type="text" class="form-control" name="name" id="name" value="{{$user->group_name}}" readonly>
								@else
									<input type="hidden" name="id" id="id" value="0">
									<input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
								@endif
								@if ($errors->has('name'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('name') }}</span>
									</span>
								@endif
							@else
								@if(isset($user))
									<input type="hidden" name="id" id="id" value="{{$user->id}}" >
									<input type="text" class="form-control" name="name" id="name" value="{{$user->firstname}} {{$user->lastname}} " readonly>
								@else
									<input type="hidden" name="id" id="id" value="0">
									<input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
								@endif
								@if ($errors->has('name'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('name') }}</span>
									</span>
								@endif
							@endif
							</div>
						</div>
						@if(isset($user))
						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">読Qネーム:</label>	
							<div class="col-md-3">
									<input type="text" class="form-control" name="username" id="username" value="{{$user->username}}" readonly>
							</div>
						</div>
						@else
							<input type="hidden" name="username" id="username" value="">
						@endif
						<div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
							<label class="control-label col-md-2 text-md-right">メールアドレス:</label>	
							<div class="col-md-3">
								@if(isset($user))
									<input type="text" class="form-control" name="email" id="email" value="" readonly>
								@else
									<input type="text" class="form-control" name="email" id="email" value="">
								@endif
								@if ($errors->has('email'))
									<span class="form-control-feedback">
										<span>{{ $errors->first('email') }}</span>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label class="control-label col-md-2 text-md-right">お問合せ内容:</label>
							<div class="col-md-7">
								<textarea required class="form-control" name="content" id="content" rows="5"></textarea>
<!--								<input type="text" name="content" id="content">-->
							</div>
							<div class="col-md-2 notify_send">
								<button type="submit" class="btn btn-primary" id="send">送　信</button>
							</div>
						</div>
					</form>					
				</div>
			</div>			
		</div>
	</div>
	<!--<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog modal-sm">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title"><strong>成功</strong></h4>
	          
	        </div>
	        <div class="modal-body">
	          <p style="color:red">{{config('consts')['MESSAGES']['MSG_MAIL_SEND']}}</p>
	        </div>
	        <div class="modal-footer">
	          <button type="button"  class="btn btn-default" data-dismiss="modal">戻　る</button>
	        </div>
	      </div>
	    </div>
	  </div>-->
<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        	<h4 class="modal-title"><strong>成功</strong></h4>
      	</div>
      	<div class="modal-body">
        	<span id="alert_text" style="color:red">{{config('consts')['MESSAGES']['MSG_MAIL_SEND']}}</span>
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
		$(document).ready(function(){
			@if(session('success'))
				$('#myModal').modal('show');
			@endif
			})
	</script>
@stop