<table class="table table-striped table-bordered table-hover data-table" id="member_table">
	<thead>
		<tr class="danger">
			<th class="table-checkbox">
				<input type="checkbox" class="group-checkable" data-set="#member_table .checkboxes"/>
			</th>
			<th>
				 姓
			</th>
			<th>
				名
			</th>
			<th>
				 性別
			</th>
			<th>
				 カタカナ
			</th>
			<th>
				 姓ローマ字
			</th>
			<th>
				 名ローマ字
			</th>
			<th>
				 読Qネーム
			</th>
			<th>
				 パスワード
			</th>
			<th>
				 メールアドレス
			</th>
			<th>
				教師/司書
			</th>
		</tr>
	</thead>
	<tbody class="text-md-center">
	@foreach($members as $key=>$member)
		<tr class="odd gradeX" data-id="{{$member->id}}">
			<td>
				<input type="checkbox" class="checkboxes" id="{{$member->id}}" name="teacher" value="{{$member->id}}"/>
			</td>
			<td>
			 	{{$member->firstname}}
			</td>
			<td>
				 {{$member->lastname}}
			</td>
			<td>
				 {{config('consts')['USER']['GENDER'][$member->gender]}}
			</td>
			<td>
				 {{$member->firstname_yomi}} {{$member->lastname_yomi}}
			</td>
			<td>
				 {{$member->firstname_roma}}
			</td>
			<td>
				 {{$member->lastname_roma}}
			</td>
			<td>
				 {{$member->username}}
			</td>
			<td>
				 {{$member->passwordShow()}}
			</td>
			<td>
				 {{$member->email}}
			</td>
			<td>
				 {{config('consts')['USER']['TYPE'][$member->role]}}
			</td>
			
		</tr>
	@endforeach
	</tbody>
</table>
<script>
	
</script>