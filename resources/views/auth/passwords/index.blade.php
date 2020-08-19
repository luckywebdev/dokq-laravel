@extends('auth.layout')

@section('contents')
<div class="login">
    <div class="logo" style="margin-top: 10px !important; padding-bottom: 0px !important;">
        <a href="{{url('/')}}" style="color:white; font-family: 'Judson', HGP明朝B;">
            読Q
        </a>
    </div>
    <div class="content">
        <form class="forget-password" method="POST" action="">
             <h3>パスワードを忘れた場合</h3>
            <p>
                端末の急な破損などでパスワードや読Qネームがわからなくても、顔認証登録がしてあれば、パスワードなどを取り戻せる場合があります。顔認証登録をしてある方・・・・・
            </p>
            <p class="text-md-center">
                <a href="{{url('auth/forgot_verify_face')}}" class="btn btn-warning">顔認証で情報を取り戻す</a>
            </p>
            <div class="create-account"></div>
            <br><br><br>
            <p>
              	顔認証を未登録の方は、ご登録のEメールアドレス宛に、パスワード再設定用のURLを送信します。そのURLをクリックして、パスワードを再設定していただきますようお願い申し上げます。
            </p>
            <p class="text-md-center">
                <a href="{{url('auth/forgot_email_pwd')}}" class="btn btn-warning">登録Eメールアドレスに再設定案内を送る</a>
            </p>
            <div class="create-account text-md-right" style="padding-bottom: 20px;">
                <a href="{{url("/")}}" class="btn btn-info" style="margin-right: 20px;">読Qトップに戻る</a>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
    </div>    
</div>


@endsection
