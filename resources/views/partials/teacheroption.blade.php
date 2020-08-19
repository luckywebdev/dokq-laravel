<option></option>
@foreach($teachers as $teacher)
	<option value="{{$teacher->id}}" @if($teacher->id == $teacher->id) selected @endif>{{$teacher->firstname}} {{$teacher->lastname}}</option>
@endforeach