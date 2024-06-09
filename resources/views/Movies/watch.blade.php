@extends('layouts/layout')
@section('content')
<div class="container">
    <div class="row fullwith-slider"></div>
 </div>
 <div class="container">
 <div class="row container" id="wrapper">
    <div class="halim-panel-filter">
       <div class="panel-heading">
          <div class="row">
             <div class="col-xs-6">
                <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">{{ $movie->title }}</a> » <span><a href="{{ route('country', ['slug' => $movie->country->slug]) }}">
               </a> <span class="breadcrumb_last" aria-current="page">{{ $movie->country->title }}</span></span></span></span></div>
             </div>
          </div>
       </div>
       <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
          <div class="ajax"></div>
       </div>
    </div>
    <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
       <section id="content" class="test">
          <div class="clearfix wrap-content">
            <style>
               /* Reset padding and margin to eliminate any default styling */
               body, html {
                   margin: 0;
                   padding: 0;
                   height: 100%;
               }
               
               /* Ensure iframe fills its parent container */
               .video-container {
                   position: relative;
                   width: 100%;
                   padding-bottom: 56.25%; /* Aspect ratio 16:9 */
                   height: 0;
               }
       
               .video-container iframe {
                   position: absolute;
                   top: 0;
                   left: 0;
                   width: 100%;
                   height: 100%;
                   border: 0;
               }
           </style>
            <div class="video-container">
               {!! $episode->link !!}
            </div>
           
             
             <div class="button-watch">
                <ul class="halim-social-plugin col-xs-4 hidden-xs">
                   <li class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                </ul>
                <ul class="col-xs-12 col-md-8">
                   <div class="luotxem"><i class="fa fa-eye"></i>
                      <span>{{ $movie->views }}</span> lượt xem 
                   </div>
                   <div class="luotxem">
                      <a class="visible-xs-inline" data-toggle="collapse" href="#moretool" aria-expanded="false" aria-controls="moretool"><i class="hl-forward"></i> Share</a>
                   </div>
                </ul>
             </div>
             <div class="collapse" id="moretool">
                <ul class="nav nav-pills x-nav-justified">
                   <li class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></li>
                   <div class="fb-save" data-uri="" data-size="small"></div>
                </ul>
             </div>
          
             <div class="clearfix"></div>
             <div class="clearfix"></div>
             <div class="title-block">
                <a href="javascript:;" data-toggle="tooltip" title="Add to bookmark">
                   <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="37976">
                      <div class="halim-pulse-ring"></div>
                   </div>
                </a>
                <div class="title-wrapper-xem full">
                   <h2 class="entry-title"><a href="" title="{{ $movie->title }}" class="tl">{{ $movie->title }}</a></h2>
                </div>
             </div>
             <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
                <article id="post-37976" class="item-content post-37976"></article>
             </div>
             <div class="clearfix"></div>
             <div class="text-center">
                <div id="halim-ajax-list-server"></div>
             </div>
             <div id="halim-list-server">
                <ul class="nav nav-tabs" role="tablist">
                  @if($movie->phude ==0) 
                  <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i class="hl-server"></i> Phụ đề</a></li>
                  @elseif($movie->phude ==1) 
                  <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0" role="tab" data-toggle="tab"><i class="hl-server"></i> Thuyết minh</a></li>
                  @endif</span> 
                 
                </ul>
                <div class="tab-content">
                   <div role="tabpanel" class="tab-pane active server-1" id="server-0">
                      <div class="halim-server">
                        <ul class="halim-list-eps">
                        @foreach($server as $key => $ser)
                           @foreach($episode_movie as $key => $ser_mov)
                               @if($ser_mov->server == $ser->id)
                                   <li style="display: flex" class="halim-episode">
                                       <span class="halim-btn halim-btn-2 halim-info-1-1 box-shadow">
                                           {{ $ser->title }}
                                       </span>
                                   </li>
                                   {{-- tập phim --}}
                                   <ul class="halim-list-eps">
                                       @foreach($episode_list as $key => $epi)
                                           @if($epi->server == $ser->id)
                                               <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$epi->episode.'/server-'.$epi->server) }}">
                                                   <li class="halim-episode">
                                                       <span class="halim-btn halim-btn-2 {{ $tapphim == $epi->episode && $server_active == 'server-'.$ser->id ? 'active' : '' }} halim-info-1-1 box-shadow"
                                                           data-title="Xem phim {{ $movie->title }} - Tập {{ $epi->episode }} - {{ $movie->name_eng }} - 
                                                               @if($movie->phude == 0) Phụ đề
                                                               @elseif($movie->phude == 1) Thuyết minh
                                                               @endif"
                                                           data-h1="{{ $movie->title }} - tập {{ $epi->episode }}">
                                                           {{ $epi->episode }}
                                                       </span>
                                                   </li>
                                               </a>
                                           @endif
                                       @endforeach
                                   </ul>
                               @endif
                           @endforeach
                       @endforeach
                       
                        </a>
                         
                         </ul>
                       
                         <div class="clearfix"></div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="clearfix"></div>
             <div class="htmlwrap clearfix">
                <div id="lightout"></div>
             </div>
       </section>
       <section class="related-movies">
         <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-bar clearfix">
               <h3 class="section-title"><span>CÓ THỂ BẠN MUỐN XEM</span></h3>
            </div>
            <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
              @foreach($movie_related as $key => $hot)
              <article class="thumb grid-item post-38498">
                 <div class="halim-item">
                    <a class="halim-thumb" href="{{ route('movie',$hot->slug) }}" title="{{ $hot->title }}">
                     @php
                     $image_check = substr($hot->image,0,5);   
                     @endphp
                     @if($image_check=='https')
                     <figure><img class="lazy img-responsive" src="{{ $hot->image}}" alt="{{ $hot->title }}" title="{{ $hot->title }}"></figure>
                     @else
                     <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/'.$hot->image) }}" alt="{{ $hot->title }}" title="{{ $hot->title }}"></figure>
                     @endif
                       <span class="status">
                          @if($hot->resolution ==0) 
                          HD
                          @elseif($hot->resolution ==1) 
                          SD
                          @elseif($hot->resolution ==2) 
                           Cam
                           @elseif($hot->resolution ==3) 
                           HDCam
                          @elseif($hot->resolution ==4) 
                          FullHD
                          @endif</span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i> 
                             @if($hot->phude ==0) 
                             Phụ đề
                             @elseif($hot->phude ==1) 
                             Thuyết minh
                             @endif</span> 
                       <div class="icon_overlay"></div>
                       <div class="halim-post-title-box">
                          <div class="halim-post-title ">
                             <p class="entry-title">{{ $hot->title }}</p>
                             <p class="original_title">{{ $hot->name_eng }}</p>
                          </div>
                       </div>
                    </a>
                 </div>
              </article>
           
           @endforeach
              
            </div>
            <script>
               $(document).ready(function($) {				
               var owl = $('#halim_related_movies-2');
               owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
            </script>
         </div>
      </section>
    </main>
    @include('Movies.include.sidebar')

 </div>
 </div>
@endsection