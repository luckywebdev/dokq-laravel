<option></option>
@foreach($classes as $class)
	<option value="{{$class->id}}">{{$class->classname}}</option>
@endforeach