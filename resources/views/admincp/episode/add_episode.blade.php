@extends('layouts.app')

@section('content')
<div class="container-fluid w-100">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý tập phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
               
                    {!! Form::open(['method' => 'POST', 'route' => 'episode.store', 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
    
               
                  {{-- <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('movie', 'Phim') !!}
                  {!! Form::select('movie_id',['0'=>'Chọn phim', 'Phim mới '=>$list_movie],  isset($episode) ? $episode->movie_id: null, ['class' => 'form-control select-movie', 'readonly']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div> --}}
                  <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                    {!! Form::label('movie', 'Phim') !!}
                    {!! Form::text('movie_title', isset($episode) ? $episode->title : '', ['class' => 'form-control', 'readonly', 'required' => 'required']) !!}
                    {!! Form::hidden('movie_id', isset($episode) ? $episode->id : '', ['class' => 'select-movie-exist']) !!}
                    <small class="text-danger">{{ $errors->first('movie_id') }}</small>
                </div>
                &lt;p&gt;&lt;iframe allowfullscreen frameborder=&quot;0&quot; height=&quot;360&quot; scrolling=&quot;0&quot; src=&quot;&quot; width=&quot;100%&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;
                  <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                  {!! Form::label('link', 'Link phim') !!}
                  {!! Form::text('link', isset($episode) ? $episode->link : '', ['class' => 'form-control','placeholder'=>'Nhập link..', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('link') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('server') ? ' has-error' : '' }}">
                    {!! Form::label('server', 'Link server') !!}
                    {!! Form::select('server', $linkmovie ,isset($linkmovie)? $linkmovie : '', ['id' => 'linkmovie', 'class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('linkmovie') }}</small>
                    </div>
                  <div class="form-group">
                    {!! Form::label('link', 'Tập phim') !!}
                    <select name="episode" class="form-control" id="show_movie">
                    </select>
                </div>
              
                  <br>
                  <div class="btn-group pull-right">
                  
                    
                    {!! Form::submit('Thêm tập phim', ['class' => 'btn btn-success']) !!}
                  
                  
                  </div>
                  {!! Form::close() !!}

                </div>
            </div>
        </div>
        {{-- liệt kê phim --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý tập phim</div>
                <table id="myTable" class="table">
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
                          @if(!$episode)
                          <tr>
                              <td colspan="7">Episode not found</td>
                          </tr>
                          @else
                            <tr>
                              <th scope="row">{{ $key +1 }}</th>
                              
                              <td>{{ $episode->movie->title }}</td>
                              
                              <td><img class='img-fluid' src="{{ asset('uploads/movies/'.$episode->movie->image) }}" alt=""></td>
                              
                              <td>{{ $episode->episode }}</td>
                              
                              {{-- Những thứ chứa đoạn mã html thì {!!  !!} để giải mã và hiện ra luôn --}}
                              <td>{!! $episode->link !!}</td>
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
                            @endif
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
