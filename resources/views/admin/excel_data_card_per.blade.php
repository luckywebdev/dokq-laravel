<html>
	<head>
		<meta charset = "utf-8">
	</head>
	<body>
		<table width="100%" border="0" cellpadding="1" cellspacing="1">
			<thead>
				<tr>
					
				</tr>
			</thead>
			<tbody class="text-md-center">
				@foreach($export_user as $export)
					<tr>
						<td>{{$export->title}}</td>
						<td>{{$export->id}}</td>
						<td>{{$export->r_password}}</td>
						<td>{{$export->birthday}}</td>
						<td>{{$export->phone}}</td>
						<td>{{$export->email}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</body>
</html>