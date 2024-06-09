
<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
       <div class="section-bar clearfix">
        <span>Phim Hot</span>
       </div>
       <section class="tab-content">
          <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
             <div class="halim-ajax-popular-post-loading hidden"></div>
             <div id="halim-ajax-popular-post" class="popular-post">
                @foreach($phim_hot_sidebar as $key => $hot_sidebar)
                <div class="item post-37176">
                   <a href="{{ route('movie',$hot_sidebar->slug) }}" title="{{ $hot_sidebar->title }}">
                      <div class="item-link">
                        @php
                        $image_check = substr($hot_sidebar->image,0,5);   
                      @endphp
                      @if($image_check=='https')
                      <img src="{{$hot_sidebar->image }}" class="lazy post-thumb" alt={{ $hot_sidebar->title }} title="{{ $hot_sidebar->title }}" />
                      @else
                      <img src="{{ asset('uploads/movies/'.$hot_sidebar->image) }}" class="lazy post-thumb" alt={{ $hot_sidebar->title }} title="{{ $hot_sidebar->title }}" />
                      @endif
                         <span class="is_trailer">@if($hot_sidebar->resolution ==0) 
                            HD
                            @elseif($hot_sidebar->resolution ==1) 
                            SD
                            @elseif($hot_sidebar->resolution ==2) 
                             Cam
                            @elseif($hot_sidebar->resolution ==3) 
                            Cam
                            @elseif($hot_sidebar->resolution ==4) 
                            FullHD
                            @elseif($hot_sidebar->resolution ==5) 
                            Trailer
                            @endif</span>
                      </div>
                      <p class="title">{{ $hot_sidebar->title }}</p>
                   </a>
                   <div class="viewsCount" style="color: #9d9d9d;">
                     @if($hot_sidebar->views > 0)
                     {{$hot_sidebar->views  }} lượt quan tâm
                     @else
                     @php
                    echo rand(1000,99999) 
                     @endphp
                     lượt quan tâm
                     @endif
                  </div>
                   <div style="float: left;">
                      <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                      <span style="width: 0%"></span>
                      </span>
                   </div>
                </div>
                @endforeach
           </div>
          </div>
          <div class="clearfix"></div>
       </section>
    </aside>
       {{-- <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
           <div class="section-bar clearfix">
            <div class="">
                <span>Top views</span>
                <ul class="halim-popular-tab nav nav-pills section-title" role="tablist">
                  <li role="presentation" class="active">
                     <a class="nav-link filter-sidebar active" role="tab" href="#day" data-toggle="tab" data-showpost="10" data-type="today">Ngày</a>
                 </li>                 
                   <li role="presentation">
                       <a class="nav-link filter-sidebar" role="tab" href="#week" data-toggle="tab" data-showpost="10" data-type="week">Tuần</a>
                   </li>
                   <li role="presentation">
                       <a class="nav-link filter-sidebar" role="tab" href="#month" data-toggle="tab" data-showpost="10" data-type="month">Tháng</a>
                   </li>
               
               </ul>
               
             </div>
           </div>
           <section class="tab-content">
              <div role="tabpanel" id="day" class="tab-pane active halim-ajax-popular-post">
                 <div class="halim-ajax-popular-post-loading hidden"></div>
                 <div id="halim-ajax-popular-post" class="popular-post">
                   
                    <span id="show0"></span>
                    
                 </div>
              </div>
              <div role="tabpanel" id="week" class="tab-pane halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
               
                   <span id="show1"></span>
                </div>
             </div>
             <div role="tabpanel" id="month" class="tab-pane  halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
                
                   <span id="show2"></span>
                </div>
             </div>
            </section>
        
           <div class="clearfix"></div>
        </div>
     </aside>
    
    </div> --}}
