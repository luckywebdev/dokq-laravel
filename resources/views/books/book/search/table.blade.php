
	<table class="table table-striped table-bordered table-hover data-table" id="sample_{{$type}}">
		<thead>
			<tr class="bg-blue">
			@if($type == 'gene')
				<th>タイトル</th>
				<th>著者</th>
				<th>ページ数</th>
				<th>ポイント</th>
				<th>帯文 </th>
				<th>合格者数</th>
				<th>表紙画像</th>
				<th>選択</th>
			@endif
			@if($type == 'category')
				<th>タイトル</th>
				<th>著者</th>
				<th>ポイント</th>
				<th>推奨年代</th>
				<th>分類</th>
				<th>読Q合格者数</th>
				<th>表紙画像</th>
				<th>この本を受検</th>
			@endif
			@if($type == 'period')
				<th>タイトル</th>
				<th>著者</th>
				<th>ページ数</th>
				<th>ポイント</th>
				<th>帯文 </th>
				<th>読Q合格者数</th>
				<th>選択</th>
			@endif
			@if($type =='latest')
				<th>認定日順</th>
				<th>タイトル </th>
				<th>著者</th>
				<th>出版社名</th>
				<th>ISBN</th>
				<th>推奨年代</th>
				<th>ポイント</th>
				<th>表紙画像</th>
				<th>選択</th>
			@endif
			@if($type =='ranking')
				<th>順位</th>
				<th>タイトル</th>
				<th>著者</th>
				<th>ポイント</th>
				<th>推奨年代</th>
				<th>読Q合格者数</th>
				<th>表紙画像</th>
				<th>この本を受検</th>
			@endif
			</tr>
		</thead>
		<tbody class="text-md-center">
			<?php $i = 0;?>
			@foreach($books as $book)
				<?php $i++;?>
				@if($type == 'category')
					<tr>
						<td style="vertical-align:middle">
                            <b hidden="true">{{$book->title_furi}}</b>
							@if($book->active >= 3)<a href="{{url('book/'. $book->id .'/detail')}}" >{{$book->title}}</a>@else {{$book->title}}@endif
							@if($book->active <= 5)
							<div class="clearfix"></div>
							<span class="text-danger float-center">
								(クイズ募集中の本)
							</span>
							@endif
							@if($book->active == 3)
							<div class="clearfix"></div>
							<span class="text-danger float-center">
								(監修者募集中の本)
							</span>
							@endif
						</td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->fullname_yomi()}}</b>
                        <a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue-madison">{{$book->fullname_nick()}}</a>
                        </td>
						<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
						<td style="vertical-align:middle; white-space: nowrap">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
						<td style="vertical-align:middle; white-space: nowrap">
							@foreach($book->categories as $key=>$category)
								@if($key + 1 == count($book->categories))
									{{$category->name}}
								@else
									{{$category->name}}、
								@endif
							@endforeach
						</td>
						<td style="vertical-align:middle">@if(isset($book->passedNums) && count($book->passedNums) != 0){{count($book->passedNums)}}@endif</td>
						<td>
							<img src="{{asset($book->cover_img)}}" @if($book->url !== null && $book->url != '') onclick="javascript:location.href='{{url($book->url)}}'" @endif alt="" height="80px">
						</td>
						<td style="vertical-align:middle">
							@if($book->active == 2)	
								読Q対象外の本のため<br>登録できません<br>
								（{{isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''}}）
							@else
								@if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1)
									@if(Auth::user()->getBookyear($book->id) !== null)
										<span class="btn btn-xs btn-info  margin-bottom-10 age_limit">この本を受検</span>
									@elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null)
										<span class="btn btn-xs btn-info margin-bottom-10 book_equal">この本を受検</span>
									@else
										<button type="button" id="{{$book->id}}" class="test_btn btn btn-xs btn-info margin-bottom-10">この本を受検</button>
									@endif
								@else
									<span class="btn btn-xs btn-info margin-bottom-10 disabled">この本を受検</span>
								@endif
								<div class="clearfix"></div>
								@if($book->active >= 3)
									<button type="button" id="{{$book->id}}" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								@else
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								@endif
								<div class="clearfix"></div>
								@if($book->active <= 5)
									<a href="#" class="btn btn-xs btn-warning margin-bottom-10">この本のクイズを作る</a>
								@endif
							@endif
						</td>
					</tr>
				@endif
				@if($type == 'gene')					
					<tr>						
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->title_furi}}</b> 
                        @if($book->active >= 3)<a href="{{url('book/'. $book->id .'/detail')}}" >{{$book->title}}</a>@else {{$book->title}}@endif
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->fullname_yomi()}}</b>  
                        <a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue-madison">{{$book->fullname_nick()}}</a>
                        </td>
						<td style="vertical-align:middle">{{$book->pages}}</td>
						<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
						<td style="vertical-align:middle; white-space: nowrap">{{$book->TopArticle()}}</td>
						<td style="vertical-align:middle">@if(count($book->passedNums) != 0){{count($book->passedNums)}}@endif</td>
						<td>
							<img src="{{asset($book->cover_img)}}" @if($book->url !== null && $book->url != '') onclick="javascript:location.href='{{url($book->url)}}'" @endif alt="" height="80px">
						</td>
						<td>
							@if($book->active == 2)	
								読Q対象外の本のため<br>登録できません<br>
								（{{isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''}}）
							@else
								@if($book->active >= 3)
									<button type="button" id="{{$book->id}}" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								@else
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								@endif
								<div class="clearfix"></div>
								@if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember())
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="{{$book->id}}" style="margin-bottom:8px;">読みたい本に追加</button>
								@else
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								@endif
							@endif
						</td>
					</tr>
				@endif
				@if ($type == 'latest')
					<tr>
						<td style="vertical-align:middle">{{with(date_create($book->qc_date))->format('Y/m/d')}}</td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->title_furi}}</b>    
                        @if($book->active >= 3)<a href="{{url('book/'. $book->id .'/detail')}}" >{{$book->title}}</a>@else {{$book->title}}@endif
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->fullname_yomi()}}</b>
                        <a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue-madison">{{$book->fullname_nick()}}</a>
                        </td>
						<td style="vertical-align:middle">{{$book->publish}}</td>
						<td style="vertical-align:middle">{{$book->isbn}}</td>
						<td style="vertical-align:middle; white-space: nowrap">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
						<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
						<td>
							<img src="{{asset($book->cover_img)}}" @if($book->url !== null && $book->url != '') onclick="javascript:location.href='{{url($book->url)}}'" @endif alt="" height="80px">
						</td>
						<td>
							@if($book->active == 2)	
								読Q対象外の本のため<br>登録できません<br>
								（{{isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''}}）

							@else
								@if($book->active >= 3)
									<button type="button" id="{{$book->id}}" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								@else
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								@endif
								<div class="clearfix"></div>
								@if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember())
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="{{$book->id}}" style="margin-bottom:8px;">読みたい本に追加</button>
								@else
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								@endif
							@endif
						</td>
					</tr>
				@endif
				@if ($type == 'ranking')
					<tr>
						<td style="vertical-align:middle">{{$i}}位</td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->title_furi}}</b>    
                        @if($book->active >= 3)<a href="{{url('book/'. $book->id .'/detail')}}" >{{$book->title}}</a>@else {{$book->title}}@endif
                        </td>
						<td style="vertical-align:middle">
                        <b hidden="true">{{$book->fullname_yomi()}}</b>  
                        <a href="{{url('book/search_books_byauthor?writer_id=' . $book->writer_id.'&fullname='.$book->fullname_nick())}}" class="font-blue-madison">
				        {{$book->fullname_nick()}}</a></td>
						<td style="vertical-align:middle">{{floor($book->point*100)/100}}</td>
						<td style="vertical-align:middle; white-space: nowrap">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
						<td style="vertical-align:middle">@if($book->ranking != 0){{$book->ranking}}@endif</td>
						<td>							
							<img src="{{asset($book->cover_img)}}" @if($book->url !== null && $book->url != '') onclick="javascript:location.href='{{url($book->url)}}'" @endif  height="80px;">							
						</td>
						<td>
							@if($book->active == 2)	
								読Q対象外の本のため<br>登録できません<br>
								（{{isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''}}）

							@else
								@if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1)
									@if(Auth::user()->getBookyear($book->id) !== null)
										<span class="btn btn-xs btn-info  margin-bottom-10 age_limit">この本を受検</span>
									@elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null)
										<span class="btn btn-xs btn-info margin-bottom-10 book_equal">この本を受検</span>
									@else
										<button type="button" id="{{$book->id}}" class="test_btn btn btn-xs btn-info margin-bottom-10">この本を受検する</button>
									@endif
								@else
									<span class="btn btn-xs btn-info margin-bottom-10 disabled">この本を受検</span>
								@endif
								<div class="clearfix"></div>
								@if($book->active >= 3)
									<button type="button" id="{{$book->id}}" class="detail_btn btn btn-xs btn-primary margin-bottom-10">詳細を見る</button>
								@else
									<span class="btn btn-xs btn-primary margin-bottom-10 disabled">詳細を見る</span>
								@endif
								<div class="clearfix"></div>
								@if(Auth::check() && !$book->iswishbook() && Auth::user()->getDateTestPassedOfBook($book->id) === null && !Auth::user()->isGroupSchoolMember())
								<button type="button" class="btn btn-xs btn-warning margin-bottom-10 towishlist1" id="{{$book->id}}" style="margin-bottom:8px;">読みたい本に追加</button>
								@else
								<a href="#" class="btn btn-xs btn-warning margin-bottom-10" disabled>読みたい本に追加</a>
								@endif
							@endif
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
	

	<div class="modal fade draggable draggable-modal" id="confirmModal" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				</div>
				<div class="modal-body">
					<h4>
						この本を、読みたい本に登録しました。
					</h4>
					<h4>
						マイ書斎の、読みたい本リストで確認できます。
					</h4>

				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade draggable draggable-modal" id="confirmModal1" tabindex="-1" role="basic" aria-hidden="true">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary"><strong>読Q</strong></h4>
				</div>
				<div class="modal-body">
					<h4>
						既に読みたい本に登録されたほんです。
					</h4>
				</div>
				<div class="modal-footer text-md-center text-sm-center">
					<button data-dismiss="modal" aria-hidden="true" class="btn btn-info">戻　る</button>
				</div>
			</div>
		</div>
	</div>
