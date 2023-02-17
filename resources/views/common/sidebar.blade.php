<?php 
	$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
	if(Auth::check()&&Auth::user()->isGroup()){
		$sidemenu = config('consts')['SIDE_MENU']['GROUP'];
	}else if(Auth::check() && Auth::user()->isTeacher()){
		$sidemenu = config('consts')['SIDE_MENU']['TEACHER'];
	}else if(Auth::check() && Auth::user()->isRepresen()){
		$sidemenu = config('consts')['SIDE_MENU']['REPRESEN'];
	}else if(Auth::check() && Auth::user()->isItmanager()){
		$sidemenu = config('consts')['SIDE_MENU']['ITMANAGER'];
	}else if(Auth::check() && Auth::user()->isOther()){
		$sidemenu = config('consts')['SIDE_MENU']['OTHER'];
	}else if(Auth::check()&&Auth::user()->isAdmin()){
		$sidemenu = config('consts')['SIDE_MENU']['ADMIN'];
	}
	if(Auth::check()&&$page_info['top'] == 'mypage'){
		if (Auth::user()->isOverseer() || Auth::user()->isAdmin()) {
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_OVERSEER'];
        }else if (Auth::user()->isAuthor()) {
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_AUTHOR'];
        }else if(Auth::user()->isSchoolMember()){
            $sidemenu = config('consts')['SIDE_MENU']['MYPAGE_TEACHER'];
		}else if(Auth::user()->isGeneral()){
			$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
		}else if(Auth::user()->isPupil()){
			if(Auth::user()->active == 1)
				$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_PUPIL'];
			else
				$sidemenu = config('consts')['SIDE_MENU']['MYPAGE_GENERAL'];
		}	
	} else if(isset($page_info) && $page_info['top'] == 'about'){
		$sidemenu = config('consts')['SIDE_MENU']['ABOUT'];	
	}
?>
<div class="page-sidebar-wrapper" >
	<div class="page-sidebar navbar-collapse">
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"></div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            @if(isset($sidemenu) && $sidemenu)
			@foreach($sidemenu as $key=>$menu)
				@if(isset($menu['CHILD']))
				    @if($menu['TITLE'] == '試験監督をする' && Auth::check() && Auth::user()->age() <= 20) 
				    @else
					<li class="{{isset($page_info) ? $page_info['side'] == $key ? 'active open':'':''}}">
						<a href="javascript:;">
						<i class="{{$menu['ICON']}}"></i>
						<span class="title">{{$menu['TITLE']}}</span>
						<span class="arrow "></span>
						</a>
						<ul class="sub-menu">
							@foreach($menu['CHILD'] as $subkey=>$submenu)
								<li class="{{isset($page_info) ? $page_info['subside'] == $subkey ? 'active':'':''}}">
									<a href="{{url('/').$submenu['LOCATION']}}" @if($submenu['TITLE'] == '試験監督適性検査' && Auth::check()) style="pointer-events:none;" @endif>
									<i class="{{$submenu['ICON']}}"></i>
									<?php echo $submenu['TITLE'] ?>
								</a>
								</li>
							@endforeach
						</ul>
					</li>
					@endif
				@else
					<li class="{{isset($page_info) ? $page_info['side'] == $key ? 'active':'':''}}">
						<a href="{{url('/').$menu['LOCATION']}}">
						<i class="{{$menu['ICON']}}"></i>
						<span class="title">
							<?php echo $menu['TITLE'] ?>
						</span>
						</a>
					</li>
				@endif
			@endforeach
			@endif
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>