@extends('layouts.app')

@section('content')
<!-- Trigger the modal with a button -->
<!-- Modal -->
<div id="videdoModal" class="modal fade " role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="video_title"></h4>
      </div>
      <div class="modal-body">
        <p id="video_desc"></p>
        <p class="text-center" id="video_link"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="container-fluid w-100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{ route('movie.create') }}" class="btn btn-primary">Thêm phim</a>

                <div class="card-header">Quản lý phim</div>
                
                <table id="myTable" class="table table-hover table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tiêu đề</th>
                        {{-- <th scope="col">Tên Tiếng Anh</th> --}}

                        <th scope="col">Đường dẫn</th>
                        <th scope="col">Hình ảnh</th>
                        {{-- <th scope="col">Mô tả</th> --}}
                        <th scope="col">Danh mục</th>
                        <th scope="col">Thuộc phim</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Quốc gia</th>
                        {{-- <th scope="col">HOT</th> --}}
                        <th scope="col">Phụ đề</th>
                        <th scope="col">Thời lượng</th>
                        <th scope="col">Season</th>
                        <th scope="col">Trailer</th>
                        <th scope="col">Số tập</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày cập nhật</th>
                        <th scope="col">Năm</th>

                        {{-- <th scope="col">Top views</th> --}}

                        <th scope="col">Tình trạng</th>
                        <th scope="col">#</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key =>$movie)
                      <tr>
                        <th scope="row">{{ $key +1 }}</th>
                        
                        <td>{{ $movie->title }}</td>
                        
                        {{-- <td>{{ $movie->name_eng }}</td> --}}
                        <td>{{ $movie->slug }}</td>
                        @php
                          $image_check = substr($movie->image,0,5);   
                        @endphp
                        @if($image_check =='https')
                        <td> <figure><img class="lazy img-responsive" src="{{$movie->image}}"></figure> </td>
                    
                        @else
                        <td> <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/'.$movie->image)}}"></figure> </td>

                       
                        @endif
                        {{-- <td>{{ $movie->description }}</td> --}}
                        <td> @foreach($movie->movie_category as $mov_cate)
                          <span class="badge bg-dark"> {{ $mov_cate->title }}</span>
                            @endforeach
                            </td>
                        <td>
                          @if($movie->thuocphim=='phimbo')
                          Phim bộ
                          @else
                          Phim lẻ
                          @endif
                        </td>
                        <td> @foreach($movie->movie_genre as $mov_gen)
                      <span class="badge bg-dark"> {{ $mov_gen->title }}</span>
                        @endforeach
                        </td>
                        <td>{{ $movie->country->title }}</td>
                        {{-- <td>
                            @if($movie->phim_hot==1)
                            Có
                            @else
                            Không
                            @endif
                        </td> --}}
                        <td>
                            @if($movie->phude ==0) 
                            Phụ đề
                            @elseif($movie->phude ==1) 
                            Thuyết minh
                            @endif
                         </td>
                         <td>{{ $movie->thoiluong }}</td>
                         <td>
        
                            {!! Form::selectRange('season',0,20,isset($movie->season)? $movie->season :'0',['class'=>'select-season','id'=>$movie->id]) !!}
                        </td>
                        <th scope="col">{{$movie->trailer}}</th>
                        <th class="text-center">{{ $movie->episode_count }} / {{ $movie->sotap }}
                          @php
                            $episode_current = (int)$movie->episode_count;
                            $episode_total =(int)$movie->sotap;
                          @endphp
                          @if( $episode_current ==  $episode_total)
                          -Hoàn thành
                          @elseif($episode_current <  $episode_total)
                          -Chưa hoàn thành
                          @elseif($movie->sotap == "?" ||$movie->sotap == "? tập" )
                          -Chưa kết thúc phim
                          @endif
                          @foreach($movie->episode as $key =>$ep)
                          <button class="show_video" type="button" data-toggle="modal" data-movie_video_id="{{ $ep->movie_id }}" data-video_episode="{{ $ep->episode }}" data-target="#videdoModal" id="openModalMovie" style="color:#fff;cursor: pointer;">
                            <span class="badge badge-primary text-white">{{ $ep->episode }}</span>
                        </button>
                          @endforeach
                          <a href="{{ route('add-episode',[$movie->id]) }}" class="btn btn-success btn-sm">Liệt kê tập phim</a>
                          <a href="{{ route('leech-episode',$movie->slug) }}" class="btn btn-warning btn-sm">Thêm tập phim API</a>
                        </th>

                         <td>{{ $movie->create_at }}</td>
                         <td>{{ $movie->update_at }}</td>
                         <td>
                          {!! Form::selectYear('year', 1990, date('Y'), isset($movie->year) ? $movie->year : '', ['class' => 'select-year', 'id' => $movie->id ]) !!}
                         </td>
                         {{-- <td>
                            {!! Form::Select('topview',['0'=>'Ngày','1'=>'Tuần','2'=>'Tháng'], isset($movie) ? $movie->topview : '',
                            ['class'=>'select-topview','id'=>$movie->id]) !!}
                         </td> --}}
                        <td>
                            @if($movie->status == 1)
                                Hiển thị
                            @elseif($movie->status == 0)
                                Không hiển thị
                            @endif

                            </td>
                      

                        <td>
                      
                            {!! Form::open(['method' => 'DELETE', 'route' => ['movie.destroy', $movie->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger btn-sm'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('movie.edit',$movie->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <a href="{{ route('update_movie_api',$movie->slug) }}" class="btn btn-primary btn-sm">Cập nhật phim API</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(document).on('click', '.show_video', function() {
        var movie_id = $(this).data('movie_video_id');
        var episode_id = $(this).data('video_episode');

        $.ajax({
            url: '{{ route("watch-video") }}',
            method: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { movie_id: movie_id, episode_id: episode_id },
            success: function(data) {
                $('#video_title').html(data.video_title);
                $('#video_link').html(data.video_link);
                $('#video_desc').html(data.video_desc);
                $('#videdoModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
});

</script>

@endsection
