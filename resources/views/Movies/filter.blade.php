@extends('layouts.layout')
@section('content')

<div class="row container" id="wrapper">
            <div class="halim-panel-filter">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-6">
                        {{-- <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">{{ $movie->title }}</a> » <span class="breadcrumb_last" aria-current="page">2024</span></span></span></div> --}}
                     </div>
                  </div>
               </div>
               <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                  <div class="ajax"></div>
               </div>
            </div>
            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
               <section>
                  <div class="section-bar clearfix">
                     <h1 class="section-title"><span>Lọc phim </span></h1>
                  </div>
                  <div class="row bg-dark text-white p-3 rounded text-center cs-row" style="margin-left:20px">
                    <form action="{{ route('locphim') }}" method="GET" class="w-100">
                      
                        <div class="row gx-3">
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="sort" class="form-select text-center custom-select cs-sort mb-3" style="padding-left:25px">
                                    <option value="">---Sắp xếp---</option>
                                    <option value="date">Ngày đăng</option>
                                    <option value="year">Năm sản xuất</option>
                                    <option value="title">Tên phim</option>
                                    <option value="views">Lượt xem</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6 mb-3">
                                <select name="genre" class="form-select text-center custom-select">
                                    <option value="">---Thể loại---</option>
                                    @foreach($genre_home as $gen)
                                        <option {{ isset($_GET['genre']) && $_GET['genre']== $gen->id ? 'selected' : ''  }} value="{{ $gen->id }}"> {{ $gen->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="country" class="form-select text-center custom-select  mb-3"  style="margin-left:45px">
                                    <option value="">---Quốc gia---</option>
                                    @foreach($country_home as $coun)
                                        <option {{ isset($_GET['country']) && $_GET['country']== $coun->id ? 'selected' : ''  }} value="{{ $coun->id }}">{{ $coun->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-6">
                                <select name="year" class="form-select text-center custom-select  mb-3"  style="margin-left:45px">
                                    <option value="">---Năm---</option>
                                    @for($i=1990;$i <= date('Y');$i++)
                                        <option {{ isset($_GET['year']) && $_GET['year']== $i ? 'selected' : ''  }} value="{{$i}}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12 d-flex justify-content-center align-items-center  mb-3"   style="margin-left:45px">
                                <button type="submit" class="btn btn-gray w-100">Lọc phim</button>
                            </div>
                        </div>
                    </form>
                </div>
                
                
                <style>
              
.form-select {
    color: #fff !important;
    background-color: #495057 !important;
    border: 1px solid #6c757d !important;
    border-radius: 0.25rem !important;
    height: calc(1.5em + 0.75rem + 2px) !important; /* Điều chỉnh chiều cao */
    padding: 0.375rem 0.75rem !important;
}

.form-select:focus {
    color: #fff !important;
    background-color: #495057 !important;
    border-color: #80bdff !important;
    outline: 0 !important;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important;
}

.btn-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
    padding: 0.375rem 0.75rem !important; /* Điều chỉnh padding để khớp với chiều cao */
}

.btn-primary:hover {
    background-color: #0056b3 !important;
    border-color: #004085 !important;
}

.form-group {
    margin-bottom: 1rem !important;
}

.bg-dark .text-white {
    color: #e9ecef !important; /* Màu chữ sáng hơn để dễ đọc */
}
@media (max-width: 576px) {
    .custom-select{
        padding-bottom: 10px
    }
    .cs-row{
        margin-left: -25px;
    }
    .cs-sort {
        margin-left: 25px
    }
}
                </style>


                  <div class="halim_box">
                     @foreach($movie as $key => $mov)
                     <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                        <div class="halim-item">
                           <a class="halim-thumb" href="{{ route('movie',$mov->slug) }}">
                            @php
                            $image_check = substr($mov->image,0,5);   
                         @endphp
                            @if($image_check =='https')
                            <figure><img class="lazy img-responsive" src="{{$mov->image}}" alt="" title="{{ $mov->image }}"></figure>
                            @else
                            <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/'.$mov->image) }}" alt="" title="{{ $mov->image }}"></figure>
                            @endif
                              <span class="status">
                                 @if($mov->resolution ==0) 
                                 HD
                                 @elseif($mov->resolution ==1) 
                                 SD
                                 @elseif($mov->resolution ==2) 
                                  Cam
                                  @elseif($mov->resolution ==3) 
                                  HDCam
                                 @elseif($mov->resolution ==4) 
                                 FullHD
                                 @elseif($mov->resolution ==5) 
                                 Trailer
                                 @endif
                                 </span>
                                 <span class="episode"><i class="fa fa-play" aria-hidden="true"></i> @if($mov->phude ==0) 
                                    Phụ đề
                                 @if($mov->season !=0)
                                    - Season {{ $mov->season }}
                                 @endif
                                 @elseif($mov->phude ==1) 
                                 Thuyết minh
                                     @if($mov->season !=0)
                                    - Season {{ $mov->season }}
                                 @endif
                                 @endif</span>
                              <div class="icon_overlay"></div>
                              <div class="halim-post-title-box">
                                 <div class="halim-post-title ">
                                    <p class="entry-title">{{ $mov->title }}</p>
                                    <p class="original_title">{{ $mov->description }}</p>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </article>
                     @endforeach
                  
                  </div>
                  <div class="clearfix"></div>
                  <div class="text-center">
                     {!! $movie->links("pagination::bootstrap-5") !!}
                  </div>
               </section>
            </main>
            <div class=" float-right">
               @include('Movies.include.sidebar')
             </div>

         </div>

         @endsection