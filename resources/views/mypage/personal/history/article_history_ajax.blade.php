<html>
    <body>
    	<div>
        <?php $i = 1; ?>
            @foreach($voter as $voter_user)

                @if($voter_user->User->age() < 15) 
                	<a href="{{url('mypage/other_view/' . $voter_user->voter_id)}}" style="color:blue;font-size:14px;">中学生以下ー<?php echo($i); $i++;?></a>
                @else 
                	<a href="{{url('mypage/other_view/' . $voter_user->voter_id)}}" style="color:blue;font-size:14px;">@if($voter_user->fullname_is_public) @if($voter_user->role != config('consts')['USER']['ROLE']['AUTHOR']) {{$voter_user->firstname.' '.$voter_user->lastname}} @else {{$voter_user->firstname_nick.' '.$voter_user->lastname_nick}} @endif @else {{$voter_user->username}} @endif</a>
                @endif<br>
            @endforeach
    	</div>
    </body>
</html>
