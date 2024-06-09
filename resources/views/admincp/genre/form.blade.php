@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý thể loại</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(isset($genre))
                {!! Form::open(['method' => 'PUT', 'route' => ['genre.update', $genre->id], 'class' => 'form-horizontal']) !!}
                @else
                {!! Form::open(['method' => 'POST', 'route' => 'genre.store', 'class' => 'form-horizontal']) !!}
                @endif
                <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
             
                  {!! Form::label('title', 'Tiêu đề') !!}
                  {!! Form::text('title', isset($genre) ? $genre->title:'', ['class' => 'form-control','placeholder' =>'Nhập tiêu đề...', 'required' => 'required','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('slug', 'Slug') !!}
                  {!! Form::text('slug', isset($genre) ? $genre->slug:'', ['class' => 'form-control','placeholder' =>'Nhập dữ liệu tìm kiếm ví dụ phim-moi....', 'required' => 'required','id'=>'convert_slug']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'Mô tả') !!}
                  {!! Form::textarea('description', isset($genre) ? $genre->description:'', ['class' => 'form-control','placeholder'=>'Nhập mô tả...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('status', 'Tình trạng') !!}
                  {!! Form::select('status',['1'=>'Hiển thị','0'=>'Không hiển thị'],  isset($genre) ? $genre->status: null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="btn-group pull-right">
                    @if(isset($genre))
                    {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}

                    @else
                    {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success']) !!}
                    @endif
                
                  </div>
                  {!! Form::close() !!}

                </div>
                <table id="myTable2" class="table">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">#</th>

                      </tr>
                    </thead>
                    <tbody class="sortableGenre">
                        @foreach($list as $key =>$gen)
                      <tr id="{{ $gen->id }}">
                        <th scope="row">{{ $key +1 }}</th>
                        <td>{{ $gen->title }}</td>
                        <td>{{ $gen->slug }}</td>
                        <td>{{ $gen->description }}</td>
                        <td>
                            @if($gen->status == 1)
                                Hiển thị
                            @elseif($gen->status == 0)
                                Không hiển thị
                            @endif

                            </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['genre.destroy', $gen->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('genre.edit',$gen->id) }}" class="btn btn-warning">Sửa</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
