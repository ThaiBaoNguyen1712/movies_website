@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
              

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(isset($linkmovie))
                {!! Form::open(['method' => 'PUT', 'route' => ['linkmovie.update', $linkmovie->id], 'class' => 'form-horizontal']) !!}
                @else
                {!! Form::open(['method' => 'POST', 'route' => 'linkmovie.store', 'class' => 'form-horizontal']) !!}
                @endif
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
             
                  {!! Form::label('title', 'Tên link') !!}
                  {!! Form::text('title', isset($linkmovie) ? $linkmovie->title:'', ['class' => 'form-control','placeholder' =>'Nhập tiêu đề...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'Mô tả') !!}
                  {!! Form::textarea('description', isset($linkmovie) ? $linkmovie->description:'', ['class' => 'form-control','placeholder'=>'Nhập mô tả...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('status', 'Tình trạng') !!}
                  {!! Form::select('status',['1'=>'Hiển thị','0'=>'Không hiển thị'],  isset($linkmovie) ? $linkmovie->status: null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="btn-group pull-right">
                    @if(isset($linkmovie))
                    {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}

                    @else
                    {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success']) !!}
                    @endif
                
                  </div>
                  {!! Form::close() !!}

                </div>
                <table id="myTable" class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Tình trạng</th>
                        <th scope="col">#</th>

                      </tr>
                    </thead>
                    <tbody>
                            @foreach($list as $key => $link)
                                <tr id="{{ $link->id }}">
                                    <th scope="row">{{ $key +1 }}</th>
                                    <td>{{ $link->title }}</td>
                                    <td>{{ $link->description }}</td>
                                    <td>
                                        @if($link->status == 1)
                                            Hiển thị
                                        @elseif($link->status == 0)
                                            Không hiển thị
                                        @endif
                                    </td>

                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['linkmovie.destroy', $link->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('linkmovie.edit',$link->id) }}" class="btn btn-warning">Sửa</a>
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

