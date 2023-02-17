			<div class="row">
				<div class="col-md-12">
					@if(isset($message))
					<div class="alert alert-info alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
						<strong>お知らせ!</strong>
						<p>
							{{$message}}
						</p>
					</div>
					@endif
					<div class="table-responsive">
						<table class="table table-hover table-bordered">
							@if(Auth::user()->isAdmin())
						    <thead>
						    	<tr class="success">
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>
							        <th>応募者数</th>					        
						        </tr>
						    </thead>
						    @else
						    <thead>
						    	<tr class="success">
							        <th>募集開始日</th>
							        <th>タイトル</th>
							        <th>著者</th>
							        <th>読Q本ID</th>
							        <th>ポイント</th>
							        <th>推奨年代</th>							        
							        <th>今集まっているクイズ数</th>							        
							        <th>監修者に応募する</th>
						        </tr>
						    </thead>
						    @endif
						    @if(Auth::user()->isAdmin())
						    <tbody class="text-md-center">
								@foreach ($books as $book)
								<tr>
									<td>{{ $book->replied_date1? with((date_create($book->replied_date1)))->format('Y/m/d'):"" }}</td>
									<td class="didor"><a href="{{url('admin/can_book_c?book_id='.$book->id)}}" class="font-blue">{{$book->title}}</a></td>
									<td >{{$book->fullname_nick()}}</td>
									<td class="xin">dq{{$book->id}}</td>
									<td>{{floor($book->point*100)/100}}</td>
									<td>{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
									<td>{{$book->PendingOverseers()->count()}}</td>								
								</tr>
								@endforeach
							</tbody>
							@else
							<tbody class="text-md-center">
								@foreach ($books as $book)
								<tr>
									<td>{{ $book->replied_date1? with((date_create($book->replied_date1)))->format('Y/m/d'):"" }}</td>
									<td class="didor">{{$book->title}}</td>
									<td >{{$book->fullname_nick()}}</td>
									<td class="xin">dq{{$book->id}}</td>
									<td>{{floor($book->point*100)/100}}</td>
									<td>{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>									
									<td>{{$book->PendingQuizes()->count()}}</td>									
									<td class="proposal" bid="{{$book->id}}"><a style="color: blue">
									    @if(Auth::user()->isAdmin())
									    監修者に応募
									    @else
									    監修者に応募
									    @endif
									</a></td>
								</tr>
								@endforeach
							</tbody>

							@endif
						</table>
						

					</div>
				</div>
			</div>