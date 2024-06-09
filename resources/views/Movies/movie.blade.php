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
                   <div class="yoast_breadcrumb hidden-xs"><span><span><a href="{{ route('category',[$movie->category->slug]) }}">{{ $movie->category->title }}</a> » <span><a href="{{ route('country',[$movie->country->slug]) }}">{{ $movie->country->title }}</a> » <span class="breadcrumb_last" aria-current="page">{{ $movie->title }}</span></span></span></span></div>
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
               
                <div class="halim-movie-wrapper">
                   <div class="title-block">
                      <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                         <div class="halim-pulse-ring"></div>
                      </div>
                      <div class="title-wrapper" style="font-weight: bold;">
                         Bookmark
                      </div>
                   </div>
                   <div class="movie_info col-xs-12">
                      <div class="movie-poster col-md-3">
                        @php
                        $image_check = substr($movie->image,0,5);   
                      @endphp
                        @if($image_check =='https')
                        <img class="movie-thumb" src="{{ $movie->image }}" alt="{{ $movie->title }}">

                        @else
                        <img class="movie-thumb" src="{{ asset('uploads/movies/'.$movie->image) }}" alt="{{ $movie->title }}">

                        @endif
                         @if($movie->resolution!==5)
                         <div class="bwa-content">
                            <div class="loader"></div>
                            <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$episode_tapdau->episode.'/server-'.$episode_tapdau->server) }}" class="bwac-btn">
                            <i class="fa fa-play"></i>
                            </a>
                         </div>
                         @endif
                      </div>
                      <div class="film-poster col-md-9">
                         <h1 class="movie-title title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{ $movie->title }}</h1>
                         <h2 class="movie-title title-2" style="font-size: 12px;">{{ $movie->name_eng }}</h2>
                         <ul class="list-info-group">
                            <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                              @if($movie->resolution ==0) 
                              HD
                              @elseif($movie->resolution ==1) 
                              SD
                              @elseif($movie->resolution ==2) 
                               Cam
                               @elseif($movie->resolution ==3) 
                               HDCam
                              @elseif($movie->resolution ==4) 
                              FullHD
                              @elseif($movie->resolution ==5) 
                              Trailer
                              @endif   
                           </span><span class="episode">
                              Phụ đề
                              @if($movie->season !=0)
                                 - Season {{ $movie->season }}
                              
                              @elseif($movie->phude ==1) 
                              Thuyết minh
                                  @if($movie->season !=0)
                                 - Season {{ $movie->season }}
                              @endif
                              @endif
                           </span>  </li>
                              
                           @if($movie->season !=0)
                           
                              <li class="list-info-group-item"><span>Season</span> : <span class="episode"> {{ $movie->season }}</span></li>
                           
                           @endif
                            {{-- <li class="list-info-group-item"><span>Điểm IMDb</span> : <span class="imdb">7.2</span></li> --}}
                            <li class="list-info-group-item"><span>Thời lượng</span> : {{ $movie->thoiluong }}</li>
                            <li class="list-info-group-item"><span>Tập phim</span> : 
                              @if($movie->thuocphim =='phimbo')
                              {{ $episode_current_list_count }}/{{ $movie->sotap }} - 
                              @if($episode_current_list_count == $movie->sotap)
                              Hoàn thành
                              @else
                              Chưa hoàn thành
                              @endif
                              @elseif($movie->thuocphim=='phimle')
                              @foreach($episode as $key=>$ep_le)
                                 <a href="{{ url('xem-phim/'.$movie->slug.'/tap-'.$ep_le->episode) }}">{{ $ep_le->episode}}</a>
                              @endforeach
                              @endif
                     
                           </li>
                           
                            <li class="list-info-group-item"><span>Thể loại</span> : 
                              @foreach($movie->movie_genre as $mov_gen)
                          
                              <a href="{{ route('genre',[$mov_gen->slug]) }}" rel="category tag"> {{ $mov_gen->title }}</a>
                                @endforeach
                              </li>
                            <li class="list-info-group-item"><span>Quốc gia</span> : <a href="{{ route('country',[$movie->country->slug]) }}" rel="tag">{{ $movie->country->title }}</a></li>
                            <li class="list-info-group-item"><span>Diễn viên</span> : {{ $movie->actor }}</li>
                            <li class="list-info-group-item"><span>Đạo diễn</span> : {{ $movie->director }}</li>
                              
                           </ul>
                         <div class="movie-trailer hidden"></div>
                      </div>
                   </div>
                </div>
                <div class="clearfix"></div>
                <div id="halim_trailer"></div>
                <div class="clearfix"></div>
                <div class="section-bar clearfix">
                   <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
                </div>
                <div class="entry-content htmlwrap clearfix">
                   <div class="video-item halim-entry-box">
                      <article id="post-38424" class="item-content">
                         Phim <a href="{{ route('movie',$movie->slug) }}">{{ $movie->title }}</a> - {{ $movie->year }} - {{ $movie->country->title }}:
                         <p>{{ $movie->title }}&#8211; {{ $movie->description }}</p>

                  
                           {{-- trailer phim --}}
                           <?php
                           if (!function_exists('convertToEmbedUrl')) {
                              function convertToEmbedUrl($url) {
                                 // Regular expression pattern to match YouTube URLs
                                 $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
                                 
                                 if (preg_match($pattern, $url, $matches)) {
                                       $videoId = $matches[1]; // Extract the video ID
                                       return 'https://www.youtube.com/embed/' . $videoId; // Convert to embed URL
                                 }
                                 return '';
                              }
                           }

                           // Convert the trailer URL to embed URL
                           $embedLink = convertToEmbedUrl($movie->trailer);
                           ?>

                           <div id="halim_trailer">
                              <iframe width="100%" height="415" src="{{ $embedLink }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                           </div>

                           
                          
                         <h5>Từ Khoá Tìm Kiếm:</h5>
                         @if($movie->tags !=null)
                           @php
                           $tags = array();
                           $tags =explode(',',$movie->tags);
                           @endphp
                         <ul>
                           @foreach($tags as $key => $tag)
                              <li><a href="{{ url('tag/'.$tag) }}">{{ $tag  }}</a> </li>
                           @endforeach
                         </ul>
                         @else
                           chưa có từ khóa cho phim
                         @endif
                      </article>
                   </div>
                </div>
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