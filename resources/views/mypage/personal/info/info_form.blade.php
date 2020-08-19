<form class="form register-form"  id="validate-form" method="post" role="form" action="{{url('/mypage/edit_info/update')}}">
	@if(count($errors) > 0 && $errors->has('servererr'))
		@include('partials.alert', array('errors' => $errors->all()))
	@endif
	{{ csrf_field() }}
	<input type="hidden" id="email" name="email" value="{{$user->email}}">
	<div class="form-body">
		<div class="row form-group">
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px" >
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch fullname_is_public" id="fullname_is_public" data-size="small" @if($user->fullname_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')
				
				@else
					
				@endif

				<div class="tools">
					<label class="label-above">氏名</label>													
				</div>
				@if($type == 'other_view'&& $edit != 1 && ($user->fullname_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info" id="name" name="name" value="aaaaa" readonly>
				@elseif($type == 'view'&& ($user->fullname_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info" id="name" name="name" value="aaaaa" readonly>
				@else
				<input type="text" class="form-control base_info" id="name" name="name" value="@if($user->isAuthor()){{$user->fullname_nick()}}@else{{$user->fullname()}}@endif" readonly>
				@endif
			</div>

			<div class="col-md-3 text-md-right" style="text-align:right;padding-top:5px">
				<!-- @if($type=="edit")
					@if( $age >= 15 )				
						<input type="checkbox" class="make-switch" id="fullname_yomi_is_public" data-size="small" @if($user->fullname_yomi_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')

				@else
					
				@endif	-->
				
				<div class="tools">
					<label class="label-above">フリガナ(全角）</label>								
				</div>
				@if($type == 'other_view' && $edit != 1 && ($user->fullname_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info" id="name_furi" value="aaaaa" readonly>
				@elseif($type == 'view' && ($user->fullname_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info" id="name_furi" value="aaaaa" readonly>
				@else
				<input type="text" class="form-control base_info" id="name_furi" value="@if($user->isAuthor()){{$user->fullname_nick_yomi()}}@else{{$user->full_furiname()}}@endif" readonly>
				@endif
			</div>
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px">
				@if($type=="edit")
					@if( $age >= 15 )				
						<input type="checkbox" class="make-switch" id="gender_is_public" data-size="small" @if($user->gender_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')

				@else
					
				@endif

				<div class="tools">
					<label class="label-above">性別</label>													
				</div>

				@if($type == 'other_view')
					@if($edit != 1  && ($user->gender_is_public == 0 && $age >= 15))
						<input type="password" class="form-control base_info" name="gender" id="gender" value="aa" readonly disabled>
					@else
						<input type="text" class="form-control base_info" name="gender" id="gender" value="{{config('consts')['USER']['GENDER'][$user->gender]}}" readonly disabled>
					@endif
				@elseif($type =="view")
					@if($user->gender_is_public == 0 && $age >= 15)
						<input type="password" class="form-control base_info" name="gender" id="gender" value="aa" readonly disabled>
					@else
					@for($i = 1; $i < 3; $i++)
	        			@if ($user->gender == $i) 
	        			<input type="text" class="form-control base_info" name="gender" id="gender" value="{{config('consts')['USER']['GENDER'][$i]}}" readonly disabled>
	        			@endif
	        		@endfor
	        		@endif
				@else
				<select class="bs-select form-control base_info" name="gender" id="gender">
	        		@for($i = 1; $i < 3; $i++)
	        			<option value="{{$i}}" @if ($user->gender == $i) selected @endif>{{config('consts')['USER']['GENDER'][$i]}}</option>
	        		@endfor
	        	</select>
	        	@endif 				
			</div>
			<div class="col-md-3 text-md-right" style="text-align:right;padding-top:5px">
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch" id="birthday_is_public" data-size="small" @if($user->birthday_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')
				
				@else
					
				@endif
				
				<div class="tools {{ $errors->has('birthday') ? ' has-danger' : '' }} {{ $errors->has('birthday') ? ' has-danger' : '' }}" >
					<label class="label-above">生年月日（半角）</label>
				</div>
				@if($type == 'other_view' && $edit != 1 && ($user->birthday_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info date-picker" id="birthday" name="birthday" value="aaaaa" @if($type!="edit") readonly disabled @endif>
				@elseif($type == 'view' && ($user->birthday_is_public == 0 || $age < 15))
				<input type="password" class="form-control base_info date-picker" id="birthday" name="birthday" value="aaaaa" @if($type!="edit") readonly disabled @endif>
				@else
				<input type="text" class="form-control base_info date-picker" id="birthday" name="birthday" value="{{old('birthday')!='' ? old('birthday'):( isset($user)? $user->birthday: '')}}" @if($type!="edit") readonly disabled @endif>
				@endif
				@if ($errors->has('birthday'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('birthday') }}</span>
				</span>
				@endif
			</div>
			<div class="col-md-2 text-md-right" style="text-align:right;padding-top:5px">
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch" id="role_is_public" data-size="small" @if($user->role_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')
				
				@else
					
				@endif
				
				<div class="tools">
					<label class="label-above">属性</label>												
				</div>
				@if($type == 'other_view' && $edit != 1  && ($user->role_is_public == 0|| $age < 15))
				<input type="password" class="form-control base_info" name="" id="" value="aaaa" readonly disabled>
				@elseif($type == 'view' && ($user->role_is_public == 0|| $age < 15))
				<input type="password" class="form-control base_info" name="" id="" value="aaaa" readonly disabled>
				@else
				<input type="text" class="form-control base_info" name="" id="" value="@if($user->isGroupSchoolMember() && $user->active == 1)教職員会員@elseif($user->isGroupSchoolMember() && $user->active == 2)教職員準会員	@elseif($user->isGeneral() && $user->active == 1)一般会員@elseif($user->isGeneral() && $user->active == 2)一般準会員@elseif($user->isPupil() && $user->active == 1){{config('consts')['PROPERTIES'][$user->properties]}} @elseif($user->isPupil() && $user->active == 2)児童生徒準会員@elseif($user->isOverseer() && $user->active == 1)	監修者会員@elseif($user->isOverseer() && $user->active == 2)監修者準会員@elseif($user->isAuthor() && $user->active == 1)著者会員	@elseif($user->isAuthor() && $user->active == 2)著者準会員@endif" readonly disabled>
				@endif
			</div>
		</div>
		@if($user->isPupil() && $user->active == 1 && ($type!="other_view" || ($type=="other_view" && $edit == 1)))
		<div class="row form-group">
		
			@if($type == "view")
			@elseif(isset($classes) && $classes != "" && ($pupilflag == 1 || $pupilflag == 2))
			<div class="col-md-4 text-md-right" >				
				@if($type!="other_view")<label class="label-above" style="color:red">非公開</label>@endif				
				<div class="tools">
					<label class="label-above">学級</label>													
				</div>

					<div class="input-group">
					@if(isset($pupilflag) && $pupilflag == 1) 
						@if($type == 'other_view' && $edit == 1)
							<input type="text" class="form-control base_info" id="class_1" name="class_1" value="@if($classes->grade != 0) {{$classes->grade}}- @endif{{$classes->class_number}} @if($classes->TeacherOfClass !== null){{$classes->TeacherOfClass->fullname()}}@endif学級/{{$classes->year}}年度" readonly >
						@else
							<input type="text" class="form-control base_info" id="class_1" name="class_1" value="@if($classes->grade != 0) {{$classes->grade}}- @endif{{$classes->class_number}} @if($classes->TeacherOfClass !== null){{$classes->TeacherOfClass->fullname()}}@endif学級/{{$classes->year}}年度" readonly >
						@endif
					@else
						@if($type == 'other_view' && $edit == 1)
							@foreach($classes as $class)
								<input type="text" class="form-control base_info" id="class_1" name="class_1" value="@if($class->grade != 0) {{$class->grade}}- @endif{{$class->class_number}} @if($class->TeacherOfClass !== null){{$class->TeacherOfClass->fullname()}}@endif学級/{{$class->year}}年度"  readonly >
							@endforeach
						@else
							@foreach($classes as $class)
								<input type="text" class="form-control base_info" id="class_1" name="class_1" value="@if($class->grade != 0) {{$class->grade}}- @endif{{$class->class_number}} @if($class->TeacherOfClass !== null){{$class->TeacherOfClass->fullname()}}@endif学級/{{$class->year}}年度"  readonly >
							@endforeach
						@endif
					@endif					
					</div>
			</div>
			@endif
		</div>
		@endif
		<div class="row form-group">
			<label class="control-label col-md-1 text-md-right address-xs" for="address4" >住所:&nbsp;〒</label>
			<div class="col-md-2 text-md-right {{ $errors->has('address4') ? ' has-danger' : '' }}" style="text-align:right;">
				<div class="col-md-12 co-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					@if($type=="edit")
						@if( $age >= 15 )
							<input type="checkbox" class="make-switch" id="address_is_public" data-size="small" @if($user->address_is_public == 1) checked @endif>				
						@else
							<label class="label-above" style="color:red;text-align:right;">非公開</label>
						@endif
					@elseif($type == 'other_view')
						
					@else
						
					@endif
				</div>	
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						@if($type == 'other_view' && $edit != 1 && ($user->address_is_public == 0 && $age >= 15))
					    <input required type="password" name="address4" value="aa"  class="form-control" id="address4" @if($type!="edit") readonly @endif>
				    	@elseif($type == 'view' && ($user->address_is_public == 0 && $age >= 15))
					    <input required type="password" name="address4" value="aa"  class="form-control" id="address4" @if($type!="edit") readonly @endif>
				    	@else
				    	<input required type="text" name="address4" value="{{old('address4')!='' ? old('address4'):( isset($user)? $user->address4: '')}}"  class="form-control" id="address4" @if($type!="edit") readonly @else placeholder="251" @endif >
				    	@endif
				    </div>
				    <!-- <div class="col-xs-9" style="padding-left:10px;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字3行しか入らないように欄を小さく</span>
					</div> -->
		    	</div>
				
		    	@if ($errors->has('address4'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address4') }}</span>
				</span>
				@endif
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
			<div class="col-md-1 text-md-right {{ $errors->has('address5') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					@if($type == 'edit')
						<label class="label-above" style="color:red">非公開</label>													
					@endif
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>	
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						@if($type == 'other_view' && $edit != 1)
					    <input required type="password" name="address5" value="aa" class="form-control" id="address5"  @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view')
				    	<input required type="password" name="address5" value="aa" class="form-control" id="address5"  @if($type!="edit") readonly @endif >
				    	@else
				    	<input required type="text" name="address5" value="{{old('address5')!='' ? old('address5'):( isset($user)? $user->address5: '')}}"  class="form-control" id="address5"  @if($type!="edit") readonly @else placeholder="0043" @endif >
				    	@endif
				    </div>
				    <!-- <div class="col-xs-9" style="padding-left:10px;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;padding-top:8px">数字4行しか入らないように欄を小さく</span>
					</div> -->
			    </div>
				
		    	@if ($errors->has('address5'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address5') }}</span>
				</span>
				@endif
			</div>
			<div class="col-md-2 text-md-right {{ $errors->has('address1') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">都道府県</label>													
					</div>
					@if($type=="edit")
						@if( $age >= 15 )
							<input type="checkbox" class="make-switch" id="address1_is_public" data-size="small" @if($user->address1_is_public == 1) checked @endif>				
						@else
							<label class="label-above" style="color:red">非公開</label>
						@endif
					@elseif($type == 'other_view')
						
					@else
						
					@endif
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						@if($type == 'other_view' && $edit != 1 && ($user->address1_is_public == 0 && $age >= 15))
						<input required type="password" name="address1" id="address1" value="aa"  class="form-control"  @if($type!="edit") readonly @endif>
				    	@elseif($type == 'view' && ($user->address1_is_public == 0 && $age >= 15))
						<input required type="password" name="address1" id="address1" value="aa"  class="form-control"  @if($type!="edit") readonly @endif>
				    	@else
				    	<input required type="text" name="address1" id="address1" value="{{old('address1')!='' ? old('address1'):( isset($user)? $user->address1: '')}}"  class="form-control"  @if($type!="edit") readonly @else placeholder="神奈川県" @endif>
				    	@endif
				    </div>
				</div>
		    	@if ($errors->has('address1'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address1') }}</span>
				</span>
				@endif 				
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
			<div class="col-md-2 text-md-right {{ $errors->has('address2') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">市区郡町村</label>													
					</div>
					@if($type=="edit")
						@if( $age >= 15 )
							<input type="checkbox" class="make-switch" id="address2_is_public" data-size="small" @if($user->address2_is_public == 1) checked @endif>				
						@else
							<label class="label-above" style="color:red">非公開</label>
						@endif
					@elseif($type == 'other_view')
						
					@else
						
					@endif
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						@if($type == 'other_view' && $edit != 1 && ($user->address2_is_public == 0 && $age >= 15))
						<input required type="password" name="address2" id="address2" value="aa"  class="form-control"  @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view' && ($user->address2_is_public == 0 && $age >= 15))
						<input required type="password" name="address2" id="address2" value="aa"  class="form-control"  @if($type!="edit") readonly @endif >
				    	@else
				    	<input required type="text" name="address2" id="address2" value="{{old('address2')!='' ? old('address2'):( isset($user)? $user->address2: '')}}"  class="form-control"  @if($type!="edit") readonly @else placeholder="横浜市青葉区" @endif >
				    	@endif
				    </div>
				</div>
				@if ($errors->has('address2'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address2') }}</span>
				</span>
				@endif
			</div>
			<span class="cross1-xs" >―</span>
			<div class="col-md-2 text-md-right {{ $errors->has('address3') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					@if($type == 'edit')
						<label class="label-above" style="color:red">町名番地非公開</label>													
					@endif
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						@if($type == 'other_view' && $edit != 1)
						<input type="password" name="address3" id="address3" value="aa" class="form-control"  @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view')
				    	<input type="password" name="address3" id="address3" value="aa" class="form-control"  @if($type!="edit") readonly @endif >
				    	@else
				    	<input type="text" name="address3" id="address3" value="{{old('address3')!='' ? old('address3'):( isset($user)? $user->address3: '')}}"  class="form-control"  @if($type!="edit") readonly @else placeholder="美しが丘東" @endif >
				    	@endif
				    </div>
				</div>
		    	@if ($errors->has('address3'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address3') }}</span>
				</span>
				@endif
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		</div>

		<div class="row form-group">
			<div class="control-label col-md-1 text-md-right"></div>	
		    <div class="col-md-2 text-md-right {{ $errors->has('address6') ? ' has-danger' : '' }}" style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						@if($type == 'other_view' && $edit != 1)
						<input type="password" name="address6" id="address6" value="a"  class="form-control"  @if($type!="edit") readonly @endif>
				   		@elseif($type == 'view')
						<input type="password" name="address6" id="address6" value="a"  class="form-control"  @if($type!="edit") readonly @endif>
				   		@else
				   		<input type="text" name="address6" id="address6" value="{{old('address6')!='' ? old('address6'):( isset($user)? $user->address6: '')}}"  class="form-control"  @if($type!="edit") readonly @else placeholder="5" @endif >
				   		@endif
				   	</div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(丁目)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字5行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		   		@if ($errors->has('address6'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address6') }}</span>
				</span>
				@endif
			</div>
			<span class="cross1-xs" >―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 text-md-right {{ $errors->has('address7') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						@if($type == 'other_view' && $edit != 1)
						<input type="password" name="address7" id="address7" value="a"  class="form-control" @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view')
						<input type="password" name="address7" id="address7" value="a"  class="form-control" @if($type!="edit") readonly @endif >
				    	@else
				    	<input type="text" name="address7" id="address7" value="{{old('address7')!='' ? old('address7'):( isset($user)? $user->address7: '')}}"  class="form-control" @if($type!="edit") readonly @else placeholder="8" @endif >
				    	@endif
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(番)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
					</div>  -->
				</div>
		    	@if ($errors->has('address7'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address7') }}</span>
				</span>
				@endif
			</div>	    
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-1 form-group {{ $errors->has('address8') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    @if($type == 'other_view'&& $edit != 1)
						<input type="password" name="address8" id="address8" value="aa"  class="form-control" @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view')
						<input type="password" name="address8" id="address8" value="aa"  class="form-control" @if($type!="edit") readonly @endif >
				    	@else
				    	<input type="text" name="address8" id="address8" value="{{old('address8')!='' ? old('address8'):( isset($user)? $user->address8: '')}}"  class="form-control" @if($type!="edit") readonly @else placeholder="24" @endif >
				    	@endif
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(号)</span>
					</div>
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		    	@if ($errors->has('address8'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address8') }}</span>
				</span>
				@endif
		    </div>
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group {{ $errors->has('address9') ? ' has-danger' : '' }} ">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">建物名</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">
					    @if($type == 'other_view' && $edit != 1)
						<input type="password" name="address9" id="address9" value="aaa"  class="form-control" @if($type!="edit") readonly @endif >
				    	@elseif($type == 'view')
						<input type="password" name="address9" id="address9" value="aaa"  class="form-control" @if($type!="edit") readonly @endif >
				    	@else
				    	<input type="text" name="address9" id="address9" value="{{old('address9')!='' ? old('address9'):( isset($user)? $user->address9: '')}}"  class="form-control" @if($type!="edit") readonly @else placeholder="フラワーマンション" @endif >
				    	@endif
				    </div>
				</div>
		    	@if ($errors->has('address9'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address9') }}</span>
				</span>
				@endif
		    </div>
		    <span class="cross1-xs" >―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group {{ $errors->has('address10') ? ' has-danger' : '' }} ">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">部屋番号、階数</label>													
					</div>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    @if($type == 'other_view' && $edit != 1)
						<input type="password" name="address10" id="address10" value="aa"  class="form-control" @if($type!="edit") readonly @endif>
				    	@elseif($type == 'view')
						<input type="password" name="address10" id="address10" value="aa"  class="form-control" @if($type!="edit") readonly @endif>
				    	@else
				    	<input type="text" name="address10" id="address10" value="{{old('address10')!='' ? old('address10'):( isset($user)? $user->address10: '')}}"  class="form-control" @if($type!="edit") readonly @else placeholder="2F" @endif >
				    	@endif
				    </div>
				    <!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">英数字5行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		    	@if ($errors->has('address10'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address10') }}</span>
				</span>
				@endif
		    </div>
		</div>

		<div class="row form-group">
			<div class="col-md-4 text-md-right" style="text-align:right;">
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch username_is_public" id="fullname_is_public" data-size="small" @if($user->fullname_is_public == 0) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')
				
				@else
					
				@endif

				<div class="tools">
					<label class="label-above">読Qネーム</label>													
				</div>	
				@if($type == 'other_view' && $edit != 1 && ($user->fullname_is_public == 1 || $age < 15))					
				<input type="password" name="username" value="aaaa" id="username" class="form-control" readonly>
				@elseif($type == 'view' && ($user->fullname_is_public == 1 || $age < 15))					
				<input type="password" name="username" value="aaaa" id="username" class="form-control" readonly>
				@else
				<input type="text" name="username" value="{{$user->username}}" id="username" class="form-control" readonly>
				@endif
			</div>
			<div class="col-md-4 text-md-right {{ $errors->has('phone') ? ' has-danger' : '' }} " style="text-align:right;">
				@if($type == 'edit')
				<label class="label-above" style="color:red">非公開</label>
				@endif
				<div class="tools">
					<label class="label-above">電話</label>													
				</div>	
				@if($type == 'other_view' && $edit != 1 )
				<input type="password" name="phone"  id="phone" value="aaaaa" class="form-control" @if($type!="edit") readonly @endif>
				@elseif($type == 'view')
				<input type="password" name="phone"  id="phone" value="aaaaa" class="form-control" @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="phone"  id="phone" value="{{old('phone')!='' ? old('phone'):( isset($user)? $user->phone: '')}}" class="form-control" @if($type!="edit") readonly @endif>
				@endif
				@if ($errors->has('phone'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('phone') }}</span>
				</span>
				@endif
			</div>

			<div class="col-md-4 text-md-right {{ $errors->has('r_password') ? ' has-danger' : '' }} {{ $errors->has('r_password') ? ' has-danger' : '' }}" style="text-align:right;">
				@if($type =="edit")
				<label class="label-above" style="color:red">非公開</label>
				@endif
				<div class="tools">
					<label class="label-above">パスワード</label>													
				</div>	
				@if(($type == 'other_view' && $edit != 1) || $type == 'view')
				<input type="password" name="r_password"  id="r_password" value="aaa" class="form-control" @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="r_password"  id="r_password" value="{{old('r_password')!='' ? old('r_password'):( isset($user)? $user->r_password: '')}}" class="form-control" @if($type!="edit") readonly @endif>
				@endif
				@if ($errors->has('r_password'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('r_password') }}</span>
				</span>
				@endif
			</div>
		</div>

		<div class="row form-group">
			<div class="col-md-4 text-md-right" style="text-align:right;">
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch" id="org_id_is_public" data-size="small" @if($user->org_id_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')

				@else
					
				@endif
				<div class="tools">
					<label class="label-above">所属１</label>										
				</div>
				@if($type == 'other_view' && $edit != 1 && ($user->org_id_is_public == 0 && $age >= 15))
			    <input required type="password" name="group_name" value="aaa"  class="form-control" id="group_name" @if($type!="edit") readonly @endif>
		    	@elseif($type == 'view' && ($user->org_id_is_public == 0 && $age >= 15))
		    	<input required type="password" name="group_name" value="aaa"  class="form-control" id="group_name" @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="group_name" class="form-control" id="group_name" value="{{old('group_name')!='' ? old('group_name'):( isset($user)? $user->group_name: '')}}" @if($type!="edit") readonly @endif>
				@endif
			</div>

			<div class="col-md-4 text-md-right" style="text-align:right;">
				@if($type=="edit")
					@if( $age >= 15 )
						<input type="checkbox" class="make-switch" id="groupyomi_is_public" data-size="small" @if($user->groupyomi_is_public == 1) checked @endif>				
					@else
						<label class="label-above" style="color:red">非公開</label>
					@endif
				@elseif($type == 'other_view')

				@else
					
				@endif
								
				<div class="tools">
					<label class="label-above">所属 2</label>						
				</div>
				@if($type == 'other_view' && $edit != 1 && ($user->groupyomi_is_public == 0 || $age < 15))
				<input type="password" name="group_yomi" class="form-control" id="group_yomi" value="aaa" @if($type!="edit") readonly @endif>
				@elseif($type == 'view' && ($user->groupyomi_is_public == 0 || $age < 15))
				<input type="password" name="group_yomi" class="form-control" id="group_yomi" value="aaa" @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="group_yomi" class="form-control" id="group_yomi" value="{{old('group_yomi')!='' ? old('group_yomi'):( isset($user)? $user->group_yomi: '')}}" @if($type!="edit") readonly @endif>
				@endif
			</div>

			@if(isset($pupilflag) && $pupilflag == 1) 
			<div class="col-md-4 text-md-right" style="text-align:right;">
				@if($type == "edit")
				<label class="label-above" style="color:red">非公開</label>
				<div class="tools">
					<label class="label-above">この基本情報編集権限保持者</label>													
				</div>
				<input type="text" name="representer" class="form-control" id="representer" value="@if($user->org_id > 0)本人、学校代表、担任教師 @endif" readonly>
				@endif
			</div>
			@endif

		</div>
				
		<div class="row form-group ">
			<div class="col-md-4 text-md-right{{ $errors->has('email') ? ' has-danger' : '' }} {{ $errors->has('email') ? ' has-danger' : '' }}" style="text-align:right;">
				@if($type == "edit")
				<label class="label-above" style="color:red">非公開</label>
				@endif
				<div class="tools">
					<label class="label-above">メールアドレス（半角英数）</label>													
				</div>
				@if($type == 'other_view' && $edit != 1 )
				<?php $firststr = substr ($user->email, 0, 1); $email = $firststr."••••";?>
				<input type="text" name="email" class="form-control" id="email" value="{{$email}}" @if($type!="edit") readonly @endif>
				@elseif($type == 'view')
				<?php $firststr = substr ($user->email, 0, 1); $email = $firststr."••••";?>
				<input type="text" name="email" class="form-control" id="email" value="{{$email}}" @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="email" class="form-control" id="email" value="{{old('email')!='' ? old('email'):( isset($user)? $user->email: '')}}" @if($type!="edit") readonly @endif>
				@endif
				@if ($errors->has('email'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('email') }}</span>
				</span>
				@endif
			</div>

			<div class="col-md-4 text-md-right" style="text-align:right;">
				@if($type == "edit")
				<label class="label-above" style="color:red">公開</label>
				@endif
				<div class="tools">
					<label class="label-above">会費支払い方法</label>													
				</div>
				@if($user->isPupil())
				<input type="text" name="payment" class="form-control" id="payment" value="@if($user->properties == 0){{config('consts')['PAYMENT_METHOD'][0]}}@elseif($user->pay_content !== null && $user->pay_content !== ''){{config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'}}@else{{''}}@endif"  readonly @if($type!="edit") readonly @endif>
				@else
				<input type="text" name="payment" class="form-control" id="payment" value="@if($user->properties == 0){{''}}@elseif($user->pay_content !== null && $user->pay_content !== ''){{config('consts')['PAY_LIST'][$user->pay_content].$user->pay_amount.'円'}}@else{{''}}@endif"  readonly @if($type!="edit") readonly @endif>
				@endif
			</div>
		</div>
		@if($type != "other_view")
		<div class="row form-group">
			<div class="col-md-12">				
				<div class="row">
					<div class="col-md-4">	
										
						<!-- <a href="{{url('/mypage/face_verify/2')}}" class="btn btn-warning pull-left" style="margin-bottom:8px;">顔認証登録</a> -->
						
					</div>					
					<div class="col-md-4">
						@if ($type == "view")
							@if(Auth::user()->isPupil() && Auth::user()->group_type == 0 )
							<a href="{{url('/mypage/recognize')}}" class="btn btn-warning pull-left" style="margin-bottom:8px;" disabled >顔認証して閲覧・編集する</a>
							@else
							<a href="{{url('/mypage/recognize')}}" class="btn btn-warning pull-left" style="margin-bottom:8px;" >顔認証して閲覧・編集する</a>
							@endif
						@elseif ($type == "edit")
							@if(Auth::user()->isPupil() && Auth::user()->group_type == 0 )
								<button type="button" class="btn btn-primary pull-left" id="update_info" style="margin-bottom:8px;" disabled>確認して更新</button>
							@else
								<button type="button" class="btn btn-primary pull-left" id="update_info" style="margin-bottom:8px;">確認して更新</button>
							@endif
						@endif
					</div>
					<div class="col-md-4">
						<!-- <a href="{{url('/mypage/face_verify/1')}}" class="btn btn-warning pull-right">会費支払い方法を変更する</a> -->
					</div>
				</div>
			</div>
			
			
		</div>
		@endif
	</div>
</form>
