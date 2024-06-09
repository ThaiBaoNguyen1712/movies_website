@extends('layouts.layout')
@section('content')

<div class="row container" id="wrapper">
            <div class="halim-panel-filter">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span>Phim thuộc năm  » <span class="breadcrumb_last" aria-current="page">{{ $year }}</span></span></span></div>
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
                     <h1 class="section-title"><span>Phim {{ $year }}</span></h1>
                  </div>
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
                     {{-- <ul class='page-numbers'>
                        <li><span aria-current="page" class="page-numbers current">1</span></li>
                        <li><a class="page-numbers" href="">2</a></li>
                        <li><a class="page-numbers" href="">3</a></li>
                        <li><span class="page-numbers dots">&hellip;</span></li>
                        <li><a class="page-numbers" href="">55</a></li>
                        <li><a class="next page-numbers" href=""><i class="hl-down-open rotate-right"></i></a></li>
                     </ul> --}}
                     {!! $movie->links("pagination::bootstrap-5") !!}

                  </div>
               </section>
            </main>
            @include('Movies.include.sidebar')

         </div>

         @endsection