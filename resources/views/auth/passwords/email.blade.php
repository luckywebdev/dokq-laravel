@extends('auth.layout')

@section('contents')
<div class="login">
    <div class="logo">
        <a href="{{url('/')}}" style="color:white; font-family: 'Judson', HGP明朝B;">読Q</a>
    </div>
    <div class="content">
         @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="forget-password" method="POST" action="{{url('auth/doforgot_email')}}">
            @if(count($errors) > 0)
                @include('partials.alert', array('errors' => $errors->all()))
            @endif
            {{ csrf_field() }}
             <h3>Eメールアドレス入力</h3>
            <p>
            	登録Eメールを入力してください。パスワード再設定用のURLを送信します。
            </p>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                <input id="email" type="text" class="form-control placeholder-no-fix" name="email" value="{{ old('email') }}" placeholder="Eメールを入力" required>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-actions">
                <a id="back-btn" class="btn btn-info" href="{{url('auth/forgot_pwd')}}" style="padding: 8px 20px !important; font-weight: bold !important;">戻　る</a>
                <button type="submit" class="btn btn-success pull-right">送　信</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>


@endsection
