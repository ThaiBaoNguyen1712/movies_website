@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{ route('movie.index') }}" class="btn btn-primary">Liệt kê phim</a>
                <div class="card-header">Quản lý phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @if(isset($movie))
                {!! Form::open(['method' => 'PUT', 'route' => ['movie.update', $movie->id], 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
                @else
                {!! Form::open(['method' => 'POST', 'route' => 'movie.store', 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
                @endif
                <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
             
                  {!! Form::label('title', 'Tiêu đề') !!}
                  {!! Form::text('title', isset($movie) ? $movie->title:'', ['class' => 'form-control','placeholder' =>'Nhập tiêu đề...', 'required' => 'required','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('name_eng') ? ' has-error' : '' }}">
                  {!! Form::label('name_eng', 'Tên Tiếng Anh') !!}
                  {!! Form::text('name_eng', isset($movie) ? $movie->name_eng : '', ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('name_eng') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('trailer') ? ' has-error' : '' }}">
                  {!! Form::label('trailer', 'Trailer') !!}
                  {!! Form::text('trailer',  isset($movie) ? $movie->trailer : '', ['class' => 'form-control', 'placeholder'=>'Nhập trailer']) !!}
                  <small class="text-danger">{{ $errors->first('trailer') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('sotap') ? ' has-error' : '' }}">
                  {!! Form::label('sotap', 'Số tập') !!}
                  {!! Form::text('sotap',  isset($movie) ? $movie->sotap : '', ['class' => 'form-control','placeholder'=>'Nhập số tập']) !!}
                  <small class="text-danger">{{ $errors->first('sotap') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('slug', 'Slug') !!}
                  {!! Form::text('slug', isset($movie) ? $movie->slug :'', ['class' => 'form-control','placeholder' =>'Nhập dữ liệu tìm kiếm ví dụ phim-moi....', 'required' => 'required','id'=>'convert_slug']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('description', 'Mô tả') !!}
                  {!! Form::textarea('description', isset($movie) ? $movie->description:'', ['class' => 'form-control','placeholder'=>'Nhập mô tả...', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                  {!! Form::label('tags', 'Tags phim') !!}
                  {!! Form::text('tags', isset($movie) ? $movie->tags:'', ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('tags') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                  {!! Form::label('status', 'Tình trạng') !!}
                  {!! Form::select('status',['1'=>'Hiển thị','0'=>'Không hiển thị'],  isset($movie) ? $movie->status: null, ['class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('inputname') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('resolution') ? ' has-error' : '' }}">
                  {!! Form::label('resolution', 'Chất lượng hiển thị') !!}
                  {!! Form::select('resolution', ['0'=>'HD','1'=>'SD','2'=>'Cam','3'=>'HDCam','4'=>'FullHD','5'=>'Trailer'], isset($movie)? $movie->resolution :null, ['id' => 'resolution', 'class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('resolution') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('thoiluong') ? ' has-error' : '' }}">
                  {!! Form::label('thoiluong', 'Thời lượng phim') !!}
                  {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong:'', ['class' => 'form-control','placeholder'=>'Nhập thời lượng phim...']) !!}
                  <small class="text-danger">{{ $errors->first('thoiluong') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('phude') ? ' has-error' : '' }}">
                  {!! Form::label('phude', 'Phụ đề') !!}
                  {!! Form::select('phude', ['0'=>'Phụ đề','1'=>'Thuyết minh'], isset($movie)?$movie->phude : '', ['id' => 'phude', 'class' => 'form-control', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('phude') }}</small>
                  </div>
                 
                    <div class="form-group{{ $errors->has('thuocphim') ? ' has-error' : '' }}">
                    {!! Form::label('thuocphim', 'Thuộc phim') !!}
                    {!! Form::select('thuocphim', ['phimbo'=>'Phim bộ','phimle'=>'Phim lẻ'], isset($movie) ? $movie->thuocphim : '', ['id' => 'thuocphim', 'class' => 'form-control', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('thuocphim') }}</small>
                    </div>

                    <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                      {!! Form::label('category', 'Danh mục') !!}
                      <br>
                      @foreach($list_category as $key=>$cate)
                      @if(isset($movie))
                      {!! Form::checkbox('category[]', $cate->id, null !== $movie_category && $movie_category->contains($cate->id)) !!}
                      @else
                      {!! Form::checkbox('category[]',$cate->id,'') !!}
                      @endif
                      {!! Form::label('category',$cate->title) !!}
                      @endforeach
                      <small class="text-danger">{{ $errors->first('inputname') }}</small>
                      </div>

                      {{-- Genre --}}
                    <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                      {!! Form::label('Genre', 'Thể loại') !!}
                      <br>
                      {{-- {!! Form::select('genre_id',$genre,  isset($movie) ? $movie->genre_id: null, ['class' => 'form-control', 'required' => 'required']) !!} --}}
                      @foreach($list_genre as $key=>$gen)
                      @if(isset($movie))
                      {!! Form::checkbox('genre[]', $gen->id, null !== $movie_genre && $movie_genre->contains($gen->id)) !!}
                    
                      @else
                      {!! Form::checkbox('genre[]',$gen->id,'') !!}
                      @endif
                      {!! Form::label('genre',$gen->title) !!}
                      @endforeach
                      <small class="text-danger">{{ $errors->first('inputname') }}</small>
                      </div>

                      {{-- <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                        {!! Form::label('Category', 'Danh mục') !!}
                        {!! Form::select('category_id',$category,  isset($movie) ? $movie->category_id: null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('inputname') }}</small>
                        </div> --}}

                      
                    <div class="form-group{{ $errors->has('inputname') ? ' has-error' : '' }}">
                      {!! Form::label('Country', 'Quốc gia') !!}
                      {!! Form::select('country_id',$country,  isset($movie) ? $movie->country_id: null, ['class' => 'form-control', 'required' => 'required']) !!}
                      <small class="text-danger">{{ $errors->first('inputname') }}</small>
                      </div>
                      <div class="form-group{{ $errors->has('phim_hot') ? ' has-error' : '' }}">
                      {!! Form::label('phim_hot', 'Phim HOT') !!}
                      {!! Form::select('phim_hot', ['1'=>'Có','0'=>'Không'], isset($movie)? $movie->phim_hot : '' , ['id' => 'phim_hot', 'class' => 'form-control', 'required' => 'required', ]) !!}
                      <small class="text-danger">{{ $errors->first('phim_hot') }}</small>
                      </div>
                      <div class="form-group{{ $errors->has('actor') ? ' has-error' : '' }}">
                      {!! Form::label('actor', 'Diễn viên') !!}
                      {!! Form::text('actor',  isset($movie) ? $movie->actor: null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('actor') }}</small>
                      </div>
                      <div class="form-group{{ $errors->has('director') ? ' has-error' : '' }}">
                      {!! Form::label('director', 'Đạo diễn') !!}
                      {!! Form::text('director',  isset($movie) ? $movie->director: null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('director') }}</small>
                      </div>
                      <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                      {!! Form::label('image', 'Image') !!}
                      {!! Form::file('image') !!}
                    
                      <small class="text-danger">{{ $errors->first('photo') }}</small>
                      </div>
                      @if(isset($movie))
                      <img class='img-fluid' src="{{ asset('uploads/movies/'.$movie->image) }}" height="120px"  alt="">
                      
                      @endif
                  <div class="btn-group pull-right">
                    @if(isset($movie))
                    {!! Form::submit('Cập nhật', ['class' => 'btn btn-success']) !!}

                    @else
                    {!! Form::submit('Thêm dữ liệu', ['class' => 'btn btn-success']) !!}
                    @endif
                
                  </div>
                  {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
