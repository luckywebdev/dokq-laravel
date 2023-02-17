<?php 
  if(Auth::check()&&Auth::user()->isTeacher()|| Auth::user()->isRepresen() || Auth::user()->isItmanager() || Auth::user()->isLibrarian() || Auth::user()->isOther()){
    $topmenu = config('consts')['TOP_MENU']['SECONDHEADER'];
  }
  
?>

<div class="header second">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation float-right font-transform-inherit">
          <ul >
            @foreach($topmenu as $key=>$menu)
              @if(isset($menu['CHILD']))
                <li class="dropdown  @if(isset($page_info['top']) && $page_info['top'] == $key) active @endif">
                  <a class="dropdown-toggle" data-toggle="dropdown"  href="javascript:;">
                   {{$menu['TITLE']}}
                  </a>
                  <ul class="dropdown-menu">
                    @foreach($menu['CHILD'] as $subkey=>$submenu)
                      <li class="@if(isset($page_info['subtop']) && $page_info['subtop'] == $subkey) active @endif"><a href="{{url($submenu['LOCATION'])}}">{{$submenu['TITLE']}}</a></li>
                    @endforeach
                  </ul>
                </li>  
              @else
                <li class=" @if(isset($page_info['top']) && $page_info['top'] == $key) active @endif"><a href="{{url($menu['LOCATION'])}}">{{$menu['TITLE']}}</a></li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <!-- END NAVIGATION -->
  </div>
</div>