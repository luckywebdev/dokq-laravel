<?php
    if(Auth::guest()){
        $topmenu = config('consts')['TOP_MENU']['BEFORE']; 
    } else{
        $topmenu = array();
    }
    $title = '読書認定級';

    if(Auth::check()&&Auth::user()->isAdmin()){
        $topmenu = config('consts')['TOP_MENU']['ADMIN'];
    } else if(Auth::check()&&Auth::user()->isGroup()){
        $topmenu = config('consts')['TOP_MENU']['GROUP'];
    }else if(Auth::check()&&Auth::user()->isTeacher()){
        if(Auth::user()->active == 1 && Session::has('teacher_auth') && Session::get('teacher_auth') == 1)
            $topmenu = config('consts')['TOP_MENU']['TEACHER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_TEACHER'];
    }else if(Auth::check()&&Auth::user()->isLibrarian()){
        $topmenu = config('consts')['TOP_MENU']['LIBRARIAN'];
    }else if(Auth::check()&&Auth::user()->isRepresen()){
       
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['REPRESEN'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_REPRESEN'];
    }else if(Auth::check()&&Auth::user()->isItmanager()){
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['ITMANAGER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_ITMANAGER'];
    }else if(Auth::check()&&Auth::user()->isOther()){
        if(Auth::user()->active == 1)
            $topmenu = config('consts')['TOP_MENU']['OTHER'];
        else
            $topmenu = config('consts')['TOP_MENU']['ASSISTANT_OTHER'];
    }else{
        $topmenu = config('consts')['TOP_MENU']['COMMON'];
    }
    $helpmenu = config('consts')['TOP_MENU']['HELP'];
    $topmenu = array_merge($topmenu, $helpmenu);
?>
<!-- Icon Section Start -->
<div class="header-section" style="margin-bottom: 0 !important;">
    <div class="container">
        <ul class="list-inline">
            <li class="page-logo">
                <a class="text-md-center" href="{{url('/')}}">
                    <img class="logo_img" src="{{ asset('img/logo_img/logo3.png') }}">
                    <!-- <h1 style="margin: 0 !important; color:white; font-family: 'Ms Mincho', 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN', 'Roboto Serif' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif, 'Judson', 'Maven Pro', sans-serif !important;">読<span style="font-family: 'Judson'; font-size: 48px">Q</span></h1> -->
                    <!-- <h6 style="margin: 0 !important; color:darkgray; font-family: 'ヒラギノ明朝 ProN' , 'Hiragino Mincho ProN' , '游明朝','游明朝体',YuMincho,'Yu Mincho' , 'ＭＳ 明朝' , 'MS Mincho' , HiraMinProN-W3 , 'TakaoEx明朝' , TakaoExMincho , 'MotoyaLCedar' , 'Droid Sans Japanese' , serif;">{{$title}}</h6> -->
                </a>
            </li>
            <li class="pull-right" style="margin-top: 10px;">
                <ul class="list-inline">
                    <li>
                        @if(Auth::check() && Auth::user()->isGroup())
                        <a href="/top" class="text-white">
                            {{Auth::user()->group_name}}
                        </a>
                        @endif
                        @if(Auth::check() && Auth::user()->isSchoolMember())
                        <a href="/top" class="text-white">
                            @if(Auth::user()->isLibrarian() && Auth::user()->active == 1)
                                @if(Auth::user()->org_id != 0 && !is_null(Auth::user()->School()))
                                    {{Auth::user()->School->group_name}}
                                @else

                                @endif
                            @elseif(Auth::user()->active == 2)
                                
                            @else
                                {{Auth::user()->School->group_name}}
                            @endif
                        </a>
                        @endif
                    </li>

                    @guest
                    <li><a class="nav-link text-white" href="{{ route('auth/login') }}">ログイン</a></li>
                    <li><a class="nav-link text-white" href="{{ route('auth/register') }}">新規登録</a></li>
                    @else
                    <li>
                        @if( Auth::user()->isGroup() )
                        @elseif( Auth::user()->isAdmin() )
                        <a class="nav-link text-white" href="{{ url('/mypage/top') }}">
                            {{ Auth::user()->username }}
                        </a>
                        @else
                        <a class="nav-link text-white" href="{{ url('mypage/top') }}">
                            @if( !Auth::user()->isGeneral() ) {{ config('consts')['USER']['TYPE'][Auth::user()->role] }}  @endif
                            @if(Auth::user()->active == 2)
                                準会員
                            @endif
                            <span class="display_name margin-left-20">
                            @if(Auth::user()->role != config('consts')['USER']['ROLE']['AUTHOR'])
                                @if(Auth::user()->fullname_is_public) 
                                {{ Auth::user()->fullname() }} 
                                @else {{ Auth::user()->username }} 
                                @endif
                            
                            @else
                                @if(Auth::user()->fullname_is_public) 
                                {{ Auth::user()->fullname_nick()}} 
                                @else {{ Auth::user()->username }} 
                                @endif
                            @endif
                            </span>
                        </a>
                        @endif

                    </li>
                    <li>
                        <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault();localStorage.removeItem('certi_list');document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="get" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endguest
                </ul>
                @if(Auth::check() && !Auth::user()->isGroup() && !Auth::user()->isAdmin() && $page_info['top'] == "mypage" && $page_info['subside'] == "top")
                <ul class="list-inline">
                    <li>
                        <label class="control-label text-white">表示名 :</label>
                        <input type="checkbox" class="form-control" id="fullname_is_public1" name="fullname_is_public1" uid="{{Auth::id()}}" value="0" @if(Auth::user()->fullname_is_public == 0) {{"checked"}} @endif >
                        <label class="control-label text-white">読Qネーム</label>
                        <input type="checkbox" class="form-control" id="fullname_is_public2" name="fullname_is_public2" uid="{{Auth::id()}}" value="1" @if(Auth::user()->fullname_is_public == 1) {{"checked"}} @endif >
                        @if(Auth::user()->role != 3)
                            <label class="control-label text-white">本名</label>
                        @else
                            <label class="control-label text-white">筆名</label>
                        @endif
                        <label class="_result"></label>
                    </li>
                </ul>
                @endif
            </li>
        </ul>
    </div>
</div>
<!-- //Icon Section End -->
<!-- Nav bar Start -->
<nav class="navbar navbar-default container" style="padding-bottom: 0px;padding-right:0px;min-height:30px;">
    <div id="collapse">
        <ul class="nav navbar-nav navbar-right" style="flex-direction: row;margin-right:0px;height:30px;">
            @foreach($topmenu as $key=>$menu)
                @if(isset($menu['CHILD']))
                    <li class="dropdown  @if(isset($page_info['top']) && $page_info['top'] == $key) active @endif">
                        
                        <a class="dropdown-toggle" style="padding-top:0px;padding-left:5px;padding-right:5px;padding-bottom:0px; color:white;text-align:center"  data-toggle="dropdown"  href="javascript:;">
                            {{$menu['TITLE']}}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($menu['CHILD'] as $subkey=>$submenu)
                                <li class="@if(isset($page_info['subtop']) && $page_info['subtop'] == $subkey) active @endif">
                                    <a href="{{url('/').$submenu['LOCATION']}}">{{$submenu['TITLE']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>  
                @else
                    <li class=" @if(isset($page_info['top']) && $page_info['top'] == $key) active @endif" >
                        
                        <a href="{{url('/').$menu['LOCATION']}}" style="padding-top:0px;padding-left:5px;padding-right:5px;padding-bottom:0px; color:white;text-align:center">{{$menu['TITLE']}}</a>
                    </li>
                @endif
               
            @endforeach
        </ul>
    </div>
</nav>
