@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Quản lý thông tin website</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                {!! Form::open(['method' => 'PUT', 'route' => ['info.update', $info->id], 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
             
                  {!! Form::label('title', 'Tiêu đề') !!}
                  {!! Form::text('title', isset($info) ? $info->title:'', ['class' => 'form-control','placeholder' =>'Nhập tiêu đề...', 'required' => 'required','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'Mô tả') !!}
                  {!! Form::textarea('description', isset($info) ? $info->description:'', ['class' => 'form-control','placeholder'=>'Nhập mô tả...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                    {!! Form::label('logo', 'logo') !!}
                    {!! Form::file('logo') !!}
                  
                    <small class="text-danger">{{ $errors->first('photo') }}</small>
                    </div>
                    @if(isset($info))
                    <img class='img-fluid' src="{{ asset('uploads/logo/'.$info->logo) }}" alt="">
                    @endif
                  <div class="btn-group pull-right">
               
                    {!! Form::submit('Cập nhật thông tin website', ['class' => 'btn btn-success']) !!}


                  </div>
                  {!! Form::close() !!}

                </div>
                {{-- <table id="myTable" class="table">
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
                    <tbody class="sortable">
    @foreach($list as $key => $cate)
        <tr id="{{ $cate->id }}">
            <th scope="row">{{ $key +1 }}</th>
            <td>{{ $cate->title }}</td>
            <td>{{ $cate->slug }}</td>
            <td>{{ $cate->description }}</td>
            <td>
                @if($cate->status == 1)
                    Hiển thị
                @elseif($cate->status == 0)
                    Không hiển thị
                @endif
            </td>

                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['info.destroy', $cate->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('info.edit',$cate->id) }}" class="btn btn-warning">Sửa</a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table> --}}
            </div>
        </div>
    </div>
</div>
@endsection

