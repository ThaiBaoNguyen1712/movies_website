@extends('layouts.layout')
@section('content')
<div class="container">
         <div class="row fullwith-slider"></div>
      </div>
      <div class="container">
         <div class="row container" id="wrapper">
            <div class="halim-panel-filter">
               <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                  <div class="ajax"></div>
               </div>
            </div>
            {{-- <div class="col-xs-12 carausel-sliderWidget">
               <section id="halim-advanced-widget-4">
                  <div class="section-heading">
                     <a href="danhmuc.php" title="Phim Chiếu Rạp">
                     <span class="h-text">Phim Chiếu Rạp</span>
                     </a>
                     <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="4" data-showpost="12" data-widgetid="halim-advanced-widget-4" data-layout="6col"><span data-text="Chiếu Rạp"></span></li>
                     </ul>
                  </div>
                  <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                     <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-38424">
                        <div class="halim-item">
                           <a class="halim-thumb" href="{{ route('movie') }}" title="GÓA PHỤ ĐEN">
                              <figure><img class="lazy img-responsive" src="https://lumiere-a.akamaihd.net/v1/images/p_blackwidow_disneyplus_21043-1_63f71aa0.jpeg" alt="GÓA PHỤ ĐEN" title="GÓA PHỤ ĐEN"></figure>
                              <span class="status">HD</span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>Vietsub</span> 
                              <div class="icon_overlay"></div>
                              <div class="halim-post-title-box">
                                 <div class="halim-post-title ">
                                    <p class="entry-title">GÓA PHỤ ĐEN</p>
                                    <p class="original_title">Black Widow</p>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </article>
                  </div>
               </section>
               <div class="clearfix"></div>
            </div> --}}
            <div id="halim_related_movies-2xx" class="wrap-slider">
               <div class="section-bar clearfix">
                  <h3 class="section-title"><span>Phim HOT</span></h3>
               </div>
               <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                  @foreach($phim_hot as $key => $hot)
                  
                  <article class="thumb grid-item post-38498">
                     <div class="halim-item">
                        <a class="halim-thumb" href="{{ route('movie',$hot->slug) }}" title="{{ $hot->title }}">
                           @php
                           $image_check = substr($hot->image,0,5);   
                         @endphp
                         @if($image_check =='https')
                         <figure><img class="lazy img-responsive" src="{{ $hot->image }}" alt="{{ $hot->title }}" title="{{ $hot->title }}"></figure>
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
                              Cam
                              @elseif($hot->resolution ==4) 
                              FullHD
                              @elseif($hot->resolution ==5) 
                              Trailer
                              @endif
                           </span>
                           <span class="episode"><i class="fa fa-play" aria-hidden="true"></i> @if($hot->phude ==0) 
                              Phụ đề
                              @if($hot->season !=0)
                                 - Season {{ $hot->season }}
                              @endif
                              @elseif($hot->phude ==1) 
                              Thuyết minh
                                  @if($hot->season !=0)
                                 - Season {{ $hot->season }}
                              @endif
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
                  owl.owlCarousel({loop: true,margin: 4,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="hl-down-open rotate-left"></i>', '<i class="hl-down-open rotate-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 5}}})});
               </script>
            </div>
         

            
            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8" style="display: flex; flex-direction: column;">
{{-- 
               @foreach ($category_home as $category) 
                 @foreach ($category->movie_category->take(12) as $movieCategory) 
                    <h3>{{ $movieCategory->movie->title }}</h3> 
                 
                    
               @endforeach
               @endforeach --}}

               @foreach($category_home as $category)
               <section id="halim-advanced-widget-2">
                   <div class="section-heading">
                       <a href="{{ route('category', $category->slug) }}" title="{{ $category->title }}">
                           <span class="h-text">{{ $category->title  }}  »</span>
                       </a>
                   </div>
                   <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                     @foreach ($category->movie_category->take(12) as $movieCategory) 
                       <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-{{ $movieCategory->movie->id }}">
                           <div class="halim-item">
                               <a class="halim-thumb" href="{{ route('movie', $movieCategory->movie->slug) }}">
                                   @php
                                       $image_check = substr($movieCategory->movie->image, 0, 5);
                                   @endphp
                                   @if($image_check == 'https')
                                   <figure><img class="lazy img-responsive" src="{{ $movieCategory->movie->image }}" alt="" title="{{ $movieCategory->movie->image }}"></figure>
                                   @else
                                   <figure><img class="lazy img-responsive" src="{{ asset('uploads/movies/'.$movieCategory->movie->image) }}" alt="" title="{{ $movieCategory->movie->image }}"></figure>
                                   @endif
                                   <span class="status">
                                       @if($movieCategory->movie->resolution == 0)
                                           HD
                                       @elseif($movieCategory->movie->resolution == 1)
                                           SD
                                       @elseif($movieCategory->movie->resolution == 2 || $movieCategory->movie->resolution == 3)
                                           Cam
                                       @elseif($movieCategory->movie->resolution == 4)
                                           FullHD
                                       @elseif($movieCategory->movie->resolution == 5)
                                           Trailer
                                       @endif
                                   </span>
                                   <span class="episode">
                                       <i class="fa fa-play" aria-hidden="true"></i>
                                       @if($movieCategory->movie->phude == 0)
                                           Phụ đề
                                       @elseif($movieCategory->movie->phude == 1)
                                           Thuyết minh
                                       @endif
                                       @if($movieCategory->movie->season != 0)
                                           - Season {{ $movieCategory->movie->season }}
                                       @endif
                                   </span> 
                                   <div class="icon_overlay"></div>
                                   <div class="halim-post-title-box">
                                       <div class="halim-post-title">
                                           <p class="entry-title">{{ $movieCategory->movie->title }}</p>
                                           <p class="original_title">{{ $movieCategory->movie->description }}</p>
                                       </div>
                                   </div>
                               </a>
                           </div>
                       </article>
                       @endforeach
             

                   </div>
               </section>
               @endforeach
               
               <div class="clearfix"></div>
         
   
            </main>
           {{-- SIDEBAR --}}
           <div class="w-100 h-100 float-right " style="right: 0;">
           @include('Movies.include.sidebar')
         </div>
         </div>
      </div>
  @endsection