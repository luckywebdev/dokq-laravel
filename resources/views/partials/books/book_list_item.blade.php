<table class="table table-striped table-bordered table-hover data-table full-response-width" id="sample_1">
    <thead>
        <tr class="bg-primary">
            <th width="30%">タイトル</th>
            <th width="15%">著者</th>
            <th width="5%">ポイント</th>
            <th width="15%">推奨年代</th>
            <th width="5%">読Q合格者数</th>
            <th width="10%">表紙画像</th>
            <th width="15%">この本を受検</th>
            <th width="5%">本編集</th>
            <!--<th>yomi</th>-->
        </tr>
    </thead>
    <tbody class="text-md-center">
    @foreach($books as $book)
        <tr class="odd gradeX book_list_tr" data-id="">
            <td style="vertical-align:middle; width: 30%">
                <b hidden="true">{{$book->title_furi}}</b>
                @if($book->active >= 3)
                    <a href="{{url('book/'.$book->id.'/detail')}}" class="font-blue-madison" style="font-size: 150%">{{$book->title}}</a>
                @else
                    <span style="font-size: 150%">{{$book->title}}</span>
                @endif
                <p>
                    @foreach($book->categories as $category)
                        <span class="label label-success">{{$category->name}}</span>
                    @endforeach
                </p>
            </td>
            <td style="vertical-align:middle; width: 15%">  
            <b hidden="true">{{$book->fullname_yomi()}}</b>
            <a href="#" class="font-blue-madison author_view" did="{{$book->writer_id}}" fullname="{{$book->fullname_nick()}}" >
                {{$book->fullname_nick()}}</a>
                </td>
            <td style="vertical-align:middle; width: 5%">{{floor($book->point*100)/100}}</td>
            <td style="vertical-align:middle; width: 15%">{{config('consts')['BOOK']['RECOMMEND'][$book->recommend]['TITLE']}}</td>
            <td style="vertical-align:middle; width: 5%">@if(count($book->passedNums) != 0){{count($book->passedNums)}}@endif</td>
            <td style="vertical-align:middle; width: 10%"><?php if(!is_null($book->image_url))echo $book->image_url; else ''; ?></td>
            <td style="width: 15%">
                @if($book->active == 2)    
                    読Q対象外の本のため<br>登録できません<br>
                    （{{isset($book->replied_date1)? date_format(date_create($book->replied_date1),'Y.m.d'):''}}）

                @else
                    @if($book->active == 6 && Auth::user() !== null &&  !Auth::user()->isGroupSchoolMember() && Auth::user()->active==1)
                        @if(Auth::user()->getBookyear($book->id) !== null)
                            <span class="btn doq_btn btn-info age_limit">この本を受検する</span>
                        @elseif(Auth::user()->getDateTestPassedOfBook($book->id) !== null || Auth::user()->getEqualBooks($book->id) !== null)
                            <span class="btn doq_btn btn-info book_equal">この本を受検する</span>
                        @else
                            <button type="button" id="{{$book->id}}" class="btn doq_btn btn-info test_btn">この本を受検する</button>
                        @endif
                    @else
                        <span class="btn doq_btn btn-info disabled">この本を受検する</span>
                    @endif<br>
                    @if($book->active >= 3)
                        <button type="button" id="{{$book->id}}" class="btn doq_btn btn-primary detail_btn">この本の詳細を見る</button>
                    @else
                        <span class="btn doq_btn btn-info disabled">この本の詳細を見る</span>
                    @endif
                    <br>
                    @if($book->active >= 3 && $book->active < 6)
                        <button type="button" id="{{$book->id}}" class="btn doq_btn btn-success quiz_btn">この本のクイズを作る</button>
                    @elseif($book->active == 6 && Auth::check() && (Auth::id() == $book->overseer_id || Auth::user()->isAdmin() || Auth::user()->fullname_nick() == $book->fullname_nick()))
                        <button type="button" id="{{$book->id}}" class="btn doq_btn btn-success quiz_btn">この本のクイズを作る</button>
                    @else
                    <span class="btn doq_btn btn-success disabled">この本のクイズを作る</span>
                    @endif<br>
                    @if($book->active == 3 )
                        @if(Auth::user() !== null && (Auth::user()->isOverseerAll() || Auth::user()->isAdmin()))
                        <button type="button" id="{{$book->id}}" class="btn doq_btn btn-warning overseer_btn">この本の監修者に応募する</button>                        
                        @else
                        <span class="btn doq_btn btn-warning disabled">この本の監修者に応募する</span>
                        @endif
                    @else
                    <span class="btn doq_btn btn-warning disabled">この本の監修者に応募する</span>
                    @endif
                @endif
            </td>
            <td style="width: 5%">
                @if(Auth::user() && (Auth::user()->isAdmin()))
                <a class="btn doq_btn btn-info" href="{{url('/book/'.$book->id.'/edit/0')}}">編&nbsp;&nbsp;&nbsp;&nbsp;集</a><br>
                @else
                &nbsp;
                @endif
            </td>

        </tr>
    @endforeach
    </tbody>
</table>