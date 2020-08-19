@extends('auth.layout')

@section('contents')
    <div class="login">
    	<div class="logo">
    		<a href="{{url('/')}}" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    	</div>
        <div class="content">
        	@if(session('status'))
        		<div class="alert alert-success">
        			{{session('status')}}
        		</div>
        	@endif
            <form class="form-horizontal" method="POST" action="{{url('/auth/doresetpwd')}}">
            @if(count($errors) > 0)
                @include('partials.alert', array('errors' => $errors->all()))
            @endif
              	{{ csrf_field() }}
                <input type="hidden" id="email" name="email" value="{{$user->email}}">
        				<h3>パスワードの再設定</h3>
        				<p>&nbsp;</p>
                    <input type="hidden" name="token" value="{{ $user->refresh_token }}">
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">                            
                          <input id="username" type="text" class="form-control" value="{{ $user->username }}" disabled>
                     </div>
                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           <p class="helper-block">
            								新しいパスワードを入力（半角英数８文字以上１５文字以内）
            						   </p>
            							<input id="password" type="password" class="form-control" name="password" required>									
                                @if ($errors->has('password'))
                                   <span class="help-block">
                                       <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                                
                      </div>
                      <div class="form-group">
                      	  <label style="padding-left:0px !important; margin-left: -3px !important"><input type="checkbox" id="show_password">パスワードを表示する</label>
                      </div>
                      <div class="form-group">
                            <div class="offset-md-1 col-md-5">
                                <button type="submit" class="btn btn-warning">送　信</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url("/")}}" class="btn btn-info">読Qトップに戻る</a>
                            </div>
                      </div>
             </form> 
         </div>                   
    </div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$("#show_password").change(function(){
				var status = $(this).attr("checked");
				
				if(status ==  'checked'){
					
					$("#password").attr("type","text");
				}else{
					
					$("#password").attr("type","password");
				}
			});
		});
	</script>	
@endsection
