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
                @if(isset($category))
                {!! Form::open(['method' => 'PUT', 'route' => ['category.update', $category->id], 'class' => 'form-horizontal']) !!}
                @else
                {!! Form::open(['method' => 'POST', 'route' => 'category.store', 'class' => 'form-horizontal']) !!}
                @endif
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
             
                  {!! Form::label('title', 'Tiêu đề') !!}
                  {!! Form::text('title', isset($category) ? $category->title:'', ['class' => 'form-control','placeholder' =>'Nhập tiêu đề...', 'required' => 'required','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('slug', 'Slug') !!}
                  {!! Form::text('slug', isset($category) ? $category->slug:'', ['class' => 'form-control','placeholder' =>'Nhập dữ liệu tìm kiếm ví dụ phim-moi....', 'required' => 'required','id'=>'convert_slug']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'Mô tả') !!}
                  {!! Form::textarea('description', isset($category) ? $category->description:'', ['class' => 'form-control','placeholder'=>'Nhập mô tả...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('status', 'Tình trạng') !!}
                  {!! Form::select('status',['1'=>'Hiển thị','0'=>'Không hiển thị'],  isset($category) ? $category->status: null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                    {!! Form::label('appear_nav', 'Cho phép xuất hiện trên thanh điều khiển') !!}
                    {!! Form::select('appear_nav',['1'=>'Cho phép','0'=>'Không cho phép'],  isset($category) ? $category->appear_nav: null, ['class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('inputname') }}</small>
                    </div>
                  <div class="btn-group pull-right">
                    @if(isset($category))
                    {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}

                    @else
                    {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success']) !!}
                    @endif
                
                  </div>
                  {!! Form::close() !!}

                </div>
                <table id="myTable" class="table">
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
                            {!! Form::open(['method' => 'DELETE', 'route' => ['category.destroy', $cate->id ],'onsubmit' =>'return confirm("Xóa")']) !!}
                            {!! Form::submit('Xóa',['class'=>'btn btn-danger'])!!}
                            {!! Form::close() !!}
                            <a href="{{ route('category.edit',$cate->id) }}" class="btn btn-warning">Sửa</a>
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

