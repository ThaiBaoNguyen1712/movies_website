@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{ route('episode.index') }}" class="btn btn-primary">Liệt kê danh sách tập phim</a>
                <div class="card-header">Quản lý tập phim</div>
              

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(isset($episode))
                {!! Form::open(['method' => 'PUT', 'route' => ['episode.update', $episode->id], 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
                @else
                {!! Form::open(['method' => 'POST', 'route' => 'episode.store', 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
                @endif
               
                <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                    {!! Form::label('movie', 'Chọn phim') !!}
                    {!! Form::select('movie_id', ['0' => 'Chọn phim', 'Phim mới ' => $list_movie], isset($episode) ? $episode->movie_id : null, ['class' => 'form-control select-movie', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('inputname') }}</small>
                </div>

                <!-- Include Select2 CSS and JS -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                <!-- Activate Select2 on the select element -->
                <script>
                    $(document).ready(function() {
                        $('.select-movie').select2();
                    });
                </script>

                  {{-- <p>  &lt;p&gt;&lt;iframe allowfullscreen frameborder=&quot;0&quot; height=&quot;360&quot; scrolling=&quot;0&quot; src=&quot;&quot; width=&quot;100%&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;</p> --}}
                  <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                  {!! Form::label('link', 'Link phim') !!}
                  {!! Form::text('link', isset($episode) ? $episode->link : '<p><iframe allowfullscreen frameborder=0 height="360" scrolling="0" src="" width="100%"></iframe></p>', ['class' => 'form-control','placeholder'=>'Nhập link..', 'required' => 'required']) !!}

                  <small class="text-danger">{{ $errors->first('link') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('server') ? ' has-error' : '' }}">
                    {!! Form::label('server', 'Link server') !!}
                    {!! Form::select('server', $linkmovie ,isset($episode)?$episode->server :'', ['id' => 'linkmovie', 'class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('linkmovie') }}</small>
                    </div>
                @if(!isset($episode))
                <div class="form-group">
                        {!! Form::label('link', 'Tập phim') !!}
                        <select name="episode" class="form-control" id="show_movie">
                      
                        </select>
                </div>
                @else
                <div class="form-group{{ $errors->has('episode') ? ' has-error' : '' }}">
                {!! Form::label('episode', 'Tập phim') !!}
                {!! Form::text('episode', isset($episode) ? $episode->episode : '', ['class' => 'form-control', isset($episode) ? 'readonly' : '']) !!}
                <small class="text-danger">{{ $errors->first('episode') }}</small>
                </div>
                @endif
                  <br>
                  <div class="btn-group pull-right">
                    @if(isset($episode))
                    {!! Form::submit('Cập nhật tập phim', ['class' => 'btn btn-success']) !!}

                    @else
                    {!! Form::submit('Thêm tập phim', ['class' => 'btn btn-success']) !!}
                    @endif
                
                  </div>
                  {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
