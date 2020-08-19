<form class="form register-form"  id="validate-form" method="post" role="form" action="">
	<div class="form-body">
		<div class="row form-group form-actions">
			<div class="col-md-2 text-md-center" style="margin-bottom:8px"> 
				<button class="btn btn-primary save-close">保存して閉じる</button>
			</div>
			<div class="col-md-8 text-md-center">
				@if($the_reg_form == 2)
				<button class="btn grey-silver move_btn" href="{{url('/teacher/edit_pupil')}}" type="button"  style="margin-bottom:8px">転校する</button>
				@elseif($the_reg_form == 1)
				<button class="btn grey-silver move_btn hide" href="{{url('/teacher/edit_pupil')}}" type="button"  style="margin-bottom:8px" disabled="true">転校する</button>
				@endif
				@if($the_reg_form == 2)
				<button href="{{url('/teacher/del_pupil')}}" class="btn btn-danger del_btn" type="button" style="margin-bottom:8px">基本情報データ削除</button>
				@elseif($the_reg_form == 1)
				<button href="{{url('/teacher/del_pupil')}}" class="btn btn-danger del_btn hide" type="button" style="margin-bottom:8px" disabled="true">基本情報データ削除</button>
				@endif
				@if($the_reg_form == 2)
				<button class="btn btn-warning graduate_btn" href="{{url('/teacher/edit_pupil')}}" type="button"  style="margin-bottom:8px">卒業する</button>
				@elseif($the_reg_form == 1)
				<button class="btn btn-warning graduate_btn hide" href="{{url('/teacher/edit_pupil')}}" type="button"  style="margin-bottom:8px" disabled="true">卒業する</button>
				@endif
			</div>
			
		</div>
		{{ csrf_field() }}
	
		<input type="hidden" name="update_key" id="update_key" value="{{isset($pupil)? 1 : 0}}"/>
		<input type="hidden" name="pupil_id" id="pupil_id" value="{{isset($pupil)? $pupil->id : 0}}"> 
		@if(count($errors) > 0)
			@include('partials.alert', array('errors' => $errors->all()))
		@endif

		<div class="row">
			<div class="col-md-2 form-group" style="text-align:right;">
			    <div class="tools">
					<label class="label-above">氏</label>													
				</div>
			    <label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control base_info" maxlength="10" id="firstname" value="{{isset($pupil)? $pupil->firstname: old('firstname')}}" name="firstname" placeholder="鈴木">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">名</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control base_info" maxlength="10" id="lastname" value="{{isset($pupil)? $pupil->lastname : old('lastname')}}" name="lastname" placeholder="太郎">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">氏(ヨミ)</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control " id="firstname_yomi" maxlength="20" value="{{isset($pupil)? $pupil->firstname_yomi: old('firstname_yomi')}}" name="firstname_yomi" placeholder="スズキ">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">名(ヨミ)</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control " id="lastname_yomi" maxlength="20" value="{{isset($pupil)? $pupil->lastname_yomi: old('lastname_yomi')}}" name="lastname_yomi" placeholder="タロウ">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-2 form-group " style="text-align:right;">
				<div class="tools">
					<label class="label-above">氏(ローマ字)</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control base_info" id="firstname_roma" maxlength="20" value="{{isset($pupil)? $pupil->firstname_roma: old('firstname_roma')}}" name="firstname_roma" placeholder="suzuki">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">名(ローマ字)</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" class="form-control base_info" id="lastname_roma" maxlength="20" value="{{isset($pupil)? $pupil->lastname_roma: old('lastname_roma')}}" name="lastname_roma" placeholder="taro">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">性別</label>													
				</div>
				<label class="label-above text-danger text-md-right">公開</label>
				<select class="bs-select form-control base_info" name="gender" id="gender">
	        		@for($i = 1; $i < 3; $i++)
	        			<option value="{{$i}}" @if ((isset($pupil)) && ($pupil->gender == $i)) selected @elseif(old('gender') == $i) selected @endif>
	        			{{config('consts')['USER']['GENDER'][$i]}}
	        			</option>
	        		@endfor
	        	</select>
			</div>
			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">生年月日</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<input required type="text" readonly="true" name="birthday" style="background-color: white" value="{{isset($pupil)? $pupil->birthday: old('birthday') }}" id="birthday" class="form-control base_info date-picker" placeholder="2008/04/25">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>
			<div class="col-md-2 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">属性</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<select class="bs-select form-control" name="role" id="role">
					<option value="2"></option>
					<option value="0" @if ((isset($pupil)) && ($pupil->properties == 0)) selected @endif>当校が会費負担</option>
					<option value="1"@if ((isset($pupil)) && ($pupil->properties == 1)) selected @endif>一般会員</option>
	        	</select>
	        	<span class="help-block"></span>
			</div>
			<div class="col-md-3 form-group" style="text-align:right;">
				<div class="tools">
					<label class="label-above">学級</label>													
				</div>
				<label class="label-above text-danger text-md-right">非公開</label>
				<select class="form-control bs-select" name="classes" id="classes" placeholder="選択...">
					<option value=""></option>
						@foreach($the_classes as $class)
						<option value="{{$class->id}}" @if (isset($pupil) && $pupil->PupilsClass->id == $class->id) selected @elseif(old('class') == $class->id) selected @endif>
							@if($class->grade == 0)
								{{$class->class_number}} {{$class->teacher_name}}
								@if(($class->class_number != '' && $class->class_number != null) || ($class->teacher_name != '' && $class->teacher_name != null))
									学級/
								@endif
							@elseif($class->class_number == '' || $class->class_number == null)
								{{$class->grade}} {{$class->teacher_name}}年/
							@else
								{{$class->grade}}-{{$class->class_number}} {{$class->teacher_name}}学級/
							@endif
							{{$class->year}}年度
							@if($class->member_counts != 0 && $class->member_counts !== null)
							 	{{$class->member_counts}}名
							@endif	
						</option>
						@endforeach
				</select>
			</div>
		</div>

		<div class="row form-group">						
			<label class="control-label col-md-1 text-md-right" for="address4" style="margin-top:20px">住所:&nbsp;〒</label>
		    <div class="col-md-1 text-md-right {{ $errors->has('address4') ? ' has-danger' : '' }}" style="text-align:right;">
				<div class="col-md-12 co-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<label class="label-above text-md-right text-danger">公開</label>	
				</div>	
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<input required type="text" name="address4" value="{{isset($pupil)? $pupil->address4: old('address4')}}"  class="form-control" id="address4"  placeholder="251">
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
			<span class="cross1-xs">―</span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-1 text-md-right {{ $errors->has('address5') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>	
					<label class="label-above text-md-right text-danger">非公開</label>	
					
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<input required type="text" name="address5" value="{{isset($pupil)? $pupil->address5: old('address5')}}"  class="form-control" id="address5"  placeholder="0043">
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
					<label class="label-above text-md-right text-danger">公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<input required type="text" name="address1" id="address1" value="{{isset($pupil)? $pupil->address1: old('address1')}}"  class="form-control" placeholder="神奈川県">
				    </div>
				</div>
		    	@if ($errors->has('address1'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address1') }}</span>
				</span>
				@endif 				
			</div>
			<span class="cross1-xs" ></span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 text-md-right {{ $errors->has('address2') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">市区郡町村</label>													
					</div>
					<label class="label-above text-md-right text-danger">公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<input required type="text" name="address2" id="address2" value="{{isset($pupil)? $pupil->address2: old('address2')}}"  class="form-control" placeholder="横浜市青葉区">
				    </div>
				</div>
				@if ($errors->has('address2'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address2') }}</span>
				</span>
				@endif
			</div>
		    <span class="cross1-xs" ></span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
			<div class="col-md-2 text-md-right {{ $errors->has('address3') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>	
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">	
						<input type="text" name="address3" id="address3" value="{{isset($pupil)? $pupil->address3: old('address3')}}"  class="form-control" placeholder="美しが丘東">
				    </div>
				</div>
		    	@if ($errors->has('address3'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address3') }}</span>
				</span>
				@endif
			</div>
			<span class="cross1-xs" ></span>
			<span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		</div>
		<div class="row">
			<div class="control-label col-md-1 text-md-right"></div>	    
		    <div class="col-md-2 text-md-right {{ $errors->has('address6') ? ' has-danger' : '' }}" style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<input type="text" name="address6" id="address6" value=""  class="form-control" placeholder="5">
				   	</div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(丁目)</span>
					</div>
					<!-- {{isset($pupil)? $pupil->address6: old('address6')}} -->
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
		    <span class="cross1-xs">―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 text-md-right {{ $errors->has('address7') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
						<input type="text" name="address7" id="address7" value=""  class="form-control" placeholder="8">
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(番)</span>
					</div>
					<!-- {{isset($pupil)? $pupil->address7: old('address7')}} -->
					<!-- <div class="col-xs-12" style="padding-left:0px;vertical-align:middle;text-align:left;">
						<span class="show-xs" style="color:red;padding-left:0px;">数字4行しか入らないように欄を小さく</span>
					</div> -->
				</div>
		    	@if ($errors->has('address7'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address7') }}</span>
				</span>
				@endif
			</div>
		    <span class="cross1-xs">―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-1 form-group {{ $errors->has('address8') ? ' has-danger' : '' }} " style="text-align:right;">
				<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">&nbsp;</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    <input type="text" name="address8" id="address8" value=""  class="form-control" placeholder="24">
				    </div>
				   	<div class="col-xs-9" style="font-size:10px;padding-left:10px;text-align:left;">
						<span class="show-xs" style="padding-left:0px;padding-top:8px">(号)</span>
					</div>
					<!-- {{isset($pupil)? $pupil->address8: old('address8')}} -->
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
		    <span class="cross1-xs">―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group {{ $errors->has('address9') ? ' has-danger' : '' }} " style="text-align:right;">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">建物名</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-6" style="padding:0px;">
					    <input type="text" name="address9" id="address9" value=""  class="form-control" placeholder="フラワーマンション">
				    </div>
				</div>
				<!-- {{isset($pupil)? $pupil->address9: old('address9')}} -->
		    	@if ($errors->has('address9'))
				<span class="form-control-feedback">
					<span>{{ $errors->first('address9') }}</span>
				</span>
				@endif
		    </div>
		    <span class="cross1-xs">―</span>
		    <span class="show-xs col-xs-12" style="font-size:10px">&nbsp;</span>
		    <div class="col-md-2 form-group {{ $errors->has('address10') ? ' has-danger' : '' }} " style="text-align:right;">
		    	<div class="col-md-12 col-xs-12" style="padding-left:0px;padding-right:0px;">
					<div class="tools">
						<label class="label-above">部屋番号、階数</label>													
					</div>
					<label class="label-above text-md-right text-danger">非公開</label>
				</div>
				<div class="col-md-12 col-xs-12" style="padding:0px;">
					<div class="col-md-12 col-xs-3" style="padding:0px;">
					    <input type="text" name="address10" id="address10" value=""  class="form-control" placeholder="2F">
					</div>
					<!-- {{isset($pupil)? $pupil->address10: old('address10')}} -->
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

		<div class="row">
			<div class="col-md-3 form-group">
				<label class="label-above col-md-7">読Qネーム</label>
				<label class="label-above col-md-4 text-danger text-md-right">非公開</label>
				<input type="text" name="username" value="{{isset($pupil)? $pupil->username: old('username')}}" id="username" maxlength="20" class="form-control base_info">
				<span class="help-block text-danger">（16歳より公開可）</span>
			</div>

			<div class="col-md-3 form-group">
				<label class="label-above col-md-7">パスワード</label>
				<label class="label-above col-md-4 text-danger text-md-right">非公開</label>
				<input required type="text" name="r_password" id="r_password" class="form-control" value="{{isset($pupil)? $pupil->r_password : old('r_password')}}">
				<span class="help-block text-danger">&nbsp;</span>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3 form-group">
				<label class="label-above col-md-8">電話</label>
				<label class="label-above col-md-4 text-danger text-md-right">非公開</label>
				<input required type="text" name="phone"  id="phone" value="{{isset($pupil)? $pupil->phone: old('phone')}}" class="form-control">
			</div>

			<div class="col-md-3 form-group">
				<label class="label-above col-md-8">所属１</label>
				<label class="label-above col-md-4 text-danger text-md-right">公開</label>
				@if(isset($pupil))
					<input type="text" name="group1" class="form-control" id="group1" value="{{isset($pupil)? $pupil->PupilsClass->group->group_name : old('group1')}}" readonly>
				@else
					<input type="text" name="group1" class="form-control" id="group1" value="{{Auth::user()->isGroup() ? Auth::user()->group_name : Auth::user()->School->group_name}}" readonly>
				@endif
			</div>

			<div class="col-md-3 form-group">
				<label class="label-above col-md-8">所属2</label>
				<label class="label-above col-md-4 text-danger text-md-right">非公開</label>
				<input type="text" name="group2" class="form-control" id="group2" value="{{isset($pupil)? $pupil->group_yomi: old('group2')}}">
			</div>
		</div>
				
		<div class="row">
			
			<div class="col-md-3 form-group">
				<label class="label-above col-md-8">メールアドレス<br>（半角英数）</label>
				<label class="label-above col-md-4 text-danger text-md-right">非公開</label>
				<input required type="text" name="email" class="form-control" id="email" value="{{isset($pupil)? $pupil->email: old('email')}}">
				@if ($errors->has('email'))
                    <span class="form-control-feedback">
                        <span>{{ $errors->first('email') }}</span>
                    </span>
                @endif
			</div>
			<div class="col-md-3 form-group">
				<label class="label-above col-md-7">この基本情報編集<br>権限保持者</label>
				<label class="label-above col-md-5 text-md-right">(自動入力)</label>
				<?php
					if (Auth::user()->isGroup()){
						$writer = Auth::user()->rep_name;
					}elseif (Auth::user()->isSchoolMember()) {
						$writer = Auth::user()->firstname . " " .Auth::user()->lastname;
					}
				 ?>
				 @if(isset($pupil))
				 	<input type="text" class="form-control" name="rep_name" value="担任、ＩＴ担当者、代表者" placeholder="担任、ＩＴ担当者、代表者" style="font-weight: bolder" readonly>
				 @else
					<input type="text" class="form-control" name="rep_name" value="担任、ＩＴ担当者、代表者" placeholder="担任、ＩＴ担当者、代表者" readonly>
				 @endif
			</div>
		</div>
		<div class="row">			
			<div class="col-md-4 text-md-center">
				<!--<a href="{{url('/mypage/face_verify')}}" class="btn btn-warning pull-left" style="margin-bottom:8px;">顔認証登録</a>-->
			</div>
			@if($the_reg_form == 1)
			<div class="col-md-4 text-md-left">
				<button type="button" class="btn btn-success save-continue" style="margin-bottom:8px" disabled="true">保存して、続けて新規登録</button>
			</div>
			@else
			<div class="col-md-4 text-md-left">
				<button type="button" class="btn btn-success save-continue"  style="margin-bottom:8px">保　存</button>
			</div>
			@endif		
			<div class="col-md-4 text-md-left">
				<button class="btn btn-danger" type="button" onclick="javascript:location.reload()"> キャンセル </button>
			</div>
		</div>

	</div>
</form>
