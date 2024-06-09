<!DOCTYPE html>
<html lang="vi">
   <head>
      <meta charset="utf-8" />
      <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
      <meta name="theme-color" content="#234556">
      <meta http-equiv="Content-Language" content="vi" />
      <meta content="VN" name="geo.region" />
      <meta name="DC.language" scheme="utf-8" content="vi" />
      <meta name="language" content="Việt Nam">
      

      <link rel="shortcut icon" href="https://www.pngkey.com/png/detail/360-3601772_your-logo-here-your-company-logo-here-png.png" type="image/x-icon" />
      <meta name="revisit-after" content="1 days" />
      <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
      <title>Phim hay - Xem phim hay nhất tại PHIM CƠM </title>
      <meta name="description" content="Phim Cơm  - Xem phim hay nhất, xem phim online miễn phí, phim hot , phim nhanh" />
      <link rel="canonical" href="">
      <link rel="next" href="" />
      <meta property="og:locale" content="vi_VN" />
      <meta property="og:title" content="Phim Cơm  - Xem phim hay nhất" />
      <meta property="og:description" content="Phim Cơm  - Xem phim hay nhất, phim hay trung quốc, hàn quốc, việt nam, mỹ, hong kong , chiếu rạp" />
      <meta property="og:url" content="" />
      <meta property="og:site_name" content="Phim Cơm - Xem phim hay nhất" />
      <meta property="og:image" content="" />
      <meta property="og:image:width" content="300" />
      <meta property="og:image:height" content="55" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
     
      <link rel='dns-prefetch' href='//s.w.org' />
      
      <link rel='stylesheet' id='bootstrap-css' href='{{ asset('client/css/bootstrap.min.css?ver=5.7.2') }}' media='all' />
      <link rel='stylesheet' id='style-css' href='{{ asset('client/css/style.css?ver=5.7.2') }}' media='all' />
      <link rel='stylesheet' id='wp-block-library-css' href='{{ asset('client/css/style.min.css?ver=5.7.2') }}' media='all' />
      <script type='text/javascript' src='{{ asset('client/js/jquery.min.js?ver=5.7.2') }}' id='halim-jquery-js'></script>
      
      <style type="text/css" id="wp-custom-css">
         .textwidget p a img {
         width: 100%;
         }
      </style>
     
   </head>
   <body class="home blog halimthemes halimmovies" data-masonry="">
      <header id="header">
         <div class="container">
            <div class="row" id="headwrap">
               <div class="col-md-3 col-sm-6 slogan">
     
               <a class="logo" href="{{route('homepage')}}" title="phim hay ">
                  <p class="text-center">
                   
                     <img class="logo" src="{{ asset('uploads/logo/'.$info->logo) }}" style="height: 30px" alt="Phim hay- Xem phim hay nhất" />
                  
                 
                  </p>
               </a>
                
               </div>
               <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                  <div class="header-nav">
                     <div class="col-xs-12">
                     
                        <div class="form-group form-timkiem">
                           <form action="{{ route('tim-kiem') }}" method="GET">
                               <div class="input-group col-xs-12">
                                   <input id="timkiem" type="text" name="search" class="form-control" placeholder="Tìm kiếm..." autocomplete="off" required>
                                   <span class="input-group-btn">
                                       <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                   </span>
                               </div>
                           </form>
                       </div>
                       
                     
                           <ul class="list-group"  id="result" style="display: none;overflow:scroll;max-height:70vh">

                           </ul>
                     
                        <ul class="ui-autocomplete ajax-results hidden"></ul>
                     </div>
                  </div>
               </div>
               <div class="col-md-4 hidden-xs">
                  <div id="get-bookmark" class="box-shadow"><i class="hl-bookmark"></i><span> Bookmarks</span><span class="count">0</span></div>
                  <div id="bookmark-list" class="hidden bookmark-list-on-pc">
                     <ul style="margin: 0;"></ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <div class="navbar-container">
         <div class="container">
            <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim" aria-expanded="false">
                  <span class="sr-only">Menu</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <button type="button" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                  <span class="hl-search" aria-hidden="true"></span>
                  </button>
                  <button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">
                  Bookmarks<i class="hl-bookmark" aria-hidden="true"></i>
                  <span class="count">0</span>
                  </button>
                  <button type="button" class="navbar-toggle collapsed pull-right get-locphim-on-mobile">
                  <a href="javascript:;" id="expand-ajax-filter" style="color: #ffed4d;">Lọc <i class="fas fa-filter"></i></a>
                  </button>
               </div>
               <div class="collapse navbar-collapse" id="halim">
                  <div class="menu-menu_1-container">
                     <ul id="menu-menu_1" class="nav navbar-nav navbar-left">
                        <li class="current-menu-item active"><a title="Trang Chủ" href="{{route('homepage')}}">Trang Chủ</a></li>
                        @foreach($category_home as $key => $cate)
                           @if($cate->appear_nav == 1)
                           
                              <li class="mega"><a title="{{ $cate->title }}" href="{{ route('category', [$cate->slug]) }}">{{ $cate->title }}</a>                        </li>

                           @endif
                           
                        @endforeach
                        <li class="mega dropdown">
                           <a title="Năm" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Năm <span class="caret"></span></a>
                           <ul role="menu" class=" dropdown-menu">
                              @php
                              $currentYear = date('Y');
                              @endphp
                              @for($year=2000;$year<=$currentYear;$year++)
                              
                                 <li><a title="{{ $year }}" href="{{ url('nam/'.$year) }}">{{ $year }}</a></li>
                              
                              @endfor
                           </ul>
                        </li>
                        <li class="mega dropdown">
                           <a title="Thể Loại" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Thể Loại <span class="caret"></span></a>
                           <ul role="menu" class=" dropdown-menu">
                              @foreach($genre_home as $key => $gen)
                              
                              <li><a title="{{ $gen->title }}" href="{{ route('genre',[$gen->slug]) }}">{{ $gen ->title }}</a></li>
                              @endforeach
                           </ul>
                        </li>
                        <li class="mega dropdown">
                           <a title="Quốc Gia" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">Quốc Gia <span class="caret"></span></a>
                           <ul role="menu" class=" dropdown-menu">
                              @foreach($country_home as $key => $count)
                              
                              <li><a title="{{ $count->title }}" href="{{ route('country',[$count->slug]) }}">{{ $count->title }}</a></li>
                              @endforeach
                           </ul>
                        </li>
                     </ul>
                  </div>
                  <ul class="nav navbar-nav navbar-left" style="background:#000;">
                     <li><a href="{{ route('loc-phim') }}" onclick="locphim()" style="color: #ffed4d;">Lọc Phim</a></li>
                  </ul>
               </div>
            </nav>
            <div class="collapse navbar-collapse" id="search-form">
               <div id="mobile-search-form" class="halim-search-form"></div>
            </div>
            <div class="collapse navbar-collapse" id="user-info">
               <div id="mobile-user-login"></div>
            </div>
         </div>
      </div>
      </div>
      <!-- content -->
        <div class="container">
        @yield('content')
        </div>
      <div class="clearfix"></div>
      <!-- endContent -->
      <footer id="footer" class="clearfix">
         <div class="container footer-columns">
            <div class="row container">
               <div class="widget about col-xs-12 col-sm-4 col-md-4">
                  <div class="footer-logo">
                     <img class="img-responsive" src="{{ asset('uploads/logo/'.$info->logo) }}" alt="Phim hay 2021- Xem phim hay nhất" />
                  </div>
                
               </div>
               <div class="widget about col-xs-12 col-sm-8 col-md-8">
                  <div class="footer-description">
                     {{ $info->description }}
                  </div>
                
               </div>
            </div>
         </div>
      </footer>
      <div id='easy-top'></div>
     
      <script type='text/javascript' src='{{ asset('client/js/bootstrap.min.js?ver=5.7.2') }}' id='bootstrap-js'></script>
      <script type='text/javascript' src='{{ asset('client/js/owl.carousel.min.js?ver=5.7.2') }}' id='carousel-js'></script>
      <script type='text/javascript' src='{{ asset('client/js/halimtheme-core.min.js?ver=1626273138') }}' id='halim-init-js'></script>
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
         showngay();
      })
      function showngay()
      {
         var value=0;
         $.ajax({
            url:"{{ url('/filter-topview') }}",
               method:"GET",
               data:{value:value},
               success:function(data)
               {

                  $('#show'+ value).html(data);
               }
         })
      }
         $('.filter-sidebar').click(function(){
            var href=$(this).attr('href');
            if(href=='#day')
            {
               var value=0;
            }
            else if(href=='#week')
            {
               var value=1;

            }
            else 
            {
               var value=2;
  
            }
            $.ajax({
               url:"{{ url('/filter-topview') }}",
               method:"GET",
               data:{value:value},
               success:function(data)
               {
                  $('#show'+ value).html(data);
                 
               }
               
            })
         })
      </script>
     <script>
          $(document).ready(function(){
    var delayTimer; // Biến để lưu trữ setTimeout
    $('#timkiem').keyup(function(){
        clearTimeout(delayTimer); // Xóa setTimeout hiện tại trước khi thiết lập một mới
        delayTimer = setTimeout(function() {
            $('#result').html('');
            var search = $('#timkiem').val();
            if(search != '') {
                $('#result').css('display','inherit');
                var expression = new RegExp(search, "i");
                var count = 0; // Số lượng phim mẫu đã thêm vào
                $.getJSON('/json_file/movies.json', function(data) {
                    $.each(data, function(key, value){
                        if ((value.title.search(expression) !== -1 || value.description.search(expression) !== -1) && count < 15) {
                            $('#result').css('display', 'inherit');
                            $('#result').append(
                                '<a href="/phim/' + value.slug + '" style="text-decoration: none; color: inherit;">' +
                                '<li style="cursor:pointer" class="list-group-item link-class">' +
                                '<img src="' + (value.image.startsWith('https') ? value.image : '/uploads/movies/' + value.image) + 
                                '" height="40" width="40" class="" />' + 
                                value.title + 
                                '</li></a>'
                            );
                            count++; // Tăng số lượng phim mẫu đã thêm vào
                        }
                    });
                    if (count == 0) {
                        $('#result').append('<li class="list-group-item">Không tìm thấy kết quả cho "' + search + '"</li>');
                    } else if (count == 15) {
                        $('#result').append('<li class="list-group-item">' + search + '</li>');
                    }
                });
            } else {
                $('#result').css('display', 'none');
            }
        }, 200); // Thời gian debounce (ms)
    });

    $('#result').on('click', 'li', function() { 
        var click_text = $(this).text().split('->');
        $('#timkiem').val(click_text[0].trim());
        $("#result").html('');
        $("#result").css('display','none');
    });
});

      </script>
   
      <style>#overlay_mb{position:fixed;display:none;width:100%;height:100%;top:0;left:0;right:0;bottom:0;background-color:rgba(0, 0, 0, 0.7);z-index:99999;cursor:pointer}#overlay_mb .overlay_mb_content{position:relative;height:100%}.overlay_mb_block{display:inline-block;position:relative}#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:600px;height:auto;position:relative;left:50%;top:50%;transform:translate(-50%, -50%);text-align:center}#overlay_mb .overlay_mb_content .cls_ov{color:#fff;text-align:center;cursor:pointer;position:absolute;top:5px;right:5px;z-index:999999;font-size:14px;padding:4px 10px;border:1px solid #aeaeae;background-color:rgba(0, 0, 0, 0.7)}#overlay_mb img{position:relative;z-index:999}@media only screen and (max-width: 768px){#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:400px;top:3%;transform:translate(-50%, 3%)}}@media only screen and (max-width: 400px){#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:310px;top:3%;transform:translate(-50%, 3%)}}</style>
    
      <style>
         #overlay_pc {
         position: fixed;
         display: none;
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: rgba(0, 0, 0, 0.7);
         z-index: 99999;
         cursor: pointer;
         }
         #overlay_pc .overlay_pc_content {
         position: relative;
         height: 100%;
         }
         .overlay_pc_block {
         display: inline-block;
         position: relative;
         }
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 600px;
         height: auto;
         position: relative;
         left: 50%;
         top: 50%;
         transform: translate(-50%, -50%);
         text-align: center;
         }
         #overlay_pc .overlay_pc_content .cls_ov {
         color: #fff;
         text-align: center;
         cursor: pointer;
         position: absolute;
         top: 5px;
         right: 5px;
         z-index: 999999;
         font-size: 14px;
         padding: 4px 10px;
         border: 1px solid #aeaeae;
         background-color: rgba(0, 0, 0, 0.7);
         }
         #overlay_pc img {
         position: relative;
         z-index: 999;
         }
         @media only screen and (max-width: 768px) {
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 400px;
         top: 3%;
         transform: translate(-50%, 3%);
         }
         }
         @media only screen and (max-width: 400px) {
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 310px;
         top: 3%;
         transform: translate(-50%, 3%);
         }
         }
      </style>
     
      <style>
         .float-ck { position: fixed; bottom: 0px; z-index: 9}
         * html .float-ck /* IE6 position fixed Bottom */{position:absolute;bottom:auto;top:expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0))) ;}
         #hide_float_left a {background: #0098D2;padding: 5px 15px 5px 15px;color: #FFF;font-weight: 700;float: left;}
         #hide_float_left_m a {background: #0098D2;padding: 5px 15px 5px 15px;color: #FFF;font-weight: 700;}
         span.bannermobi2 img {height: 70px;width: 300px;}
         #hide_float_right a { background: #01AEF0; padding: 5px 5px 1px 5px; color: #FFF;float: left;}
      </style>


      
   </body>
</html>