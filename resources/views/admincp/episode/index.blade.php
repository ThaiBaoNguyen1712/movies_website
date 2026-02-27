@extends('layouts.app')

@section('content')
<div class="container-fluid w-100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{ route('episode.create') }}" class="btn btn-primary">Thêm tập phim</a>

                <div class="card-header">Quản lý tập phim</div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ Request::url() }}" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ $search }}" 
                                      class="form-control" placeholder="Nhập số tập hoặc tên phim...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                    @if($search)
                                        <a href="{{ Request::url() }}" class="btn btn-danger">Xóa lọc</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Đường dẫn</th>
                        <th scope="col">Server</th>
                        <th scope="col">#</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach($list_episode as $key =>$episode)
                      <tr>
                        <th scope="row">{{ $key +1 }}</th>
                        
                        <td>{{ $episode->movie->title }}</td>
                        @php
                        $image_check = substr($episode->movie->image,0,5);   
                       @endphp
                      @if($image_check =='https')
                      <td> <figure><img class="lazy img-responsive" src="{{$episode->movie->image}}"style="max-width:66px"></figure> </td>
                  
                      @else
                      <td> 
                        <figure>
                            <img class="lazy img-responsive small-image" src="{{ asset('uploads/movies/'.$episode->movie->image)}}" alt="" style="max-width:66px">
                        </figure>
                    </td>
                    
                        @endif
                        <td>{{ $episode->episode }}</td>
                        
                        {{-- Những thứ chứa đoạn mã html thì {!!  !!} để giải mã và hiện ra luôn --}}
                        <td><p>{{ $episode->link }}</p></td>
                        <td>
                          @foreach($list_server as $key =>$server_link)
                            @if($episode->server == $server_link->id)
                            {{ $server_link ->title }}
                            @endif
                          @endforeach
                        </td>
                      

                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['episode.destroy', $episode->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('episode.edit',$episode->id) }}" class="btn btn-warning">Sửa</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="mt-4 text-center">
                      {!! $list_episode->appends(['search' => $search])->links('pagination::bootstrap-4') !!}
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
