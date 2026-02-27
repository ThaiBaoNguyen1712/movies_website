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
    <link rel="icon" href="/uploads/logo/logo9942.png" type="image/png">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://maxcdn.bootstrapcdn.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://maxcdn.bootstrapcdn.com">
    <link rel='dns-prefetch' href='//s.w.org' />
    
    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('client/css/bootstrap.min.css?ver=5.7.2') }}" as="style">
    <link rel="preload" href="{{ asset('client/css/style.css?ver=5.7.2') }}" as="style">
    <link rel="preload" href="{{ asset('client/js/jquery.min.js?ver=5.7.2') }}" as="script">
    <link rel="preload" href="{{ asset('uploads/logo/'.$info->logo) }}" as="image">
    
    <!-- preconnect to img domain -->
    <link rel="preconnect" href="https://img.ophim.live">
    <link rel="dns-prefetch" href="https://img.ophim.live">

    <link rel="preconnect" href="https://phimimg.com">
    <link rel="dns-prefetch" href="https://phimimg.com">
    <!-- Critical CSS -->
    <link rel='stylesheet' id='bootstrap-css' href='{{ asset('client/css/bootstrap.min.css?ver=5.7.2') }}' media='all' />
    <link rel='stylesheet' id='style-css' href='{{ asset('client/css/style.css?ver=5.7.2') }}' media='all' />
    <link rel='stylesheet' id='wp-block-library-css' href='{{ asset('client/css/style.min.css?ver=5.7.2') }}' media='all' />
    <link rel="stylesheet" href="{{ asset('client/css/mobile-fix.css') }}">
    
    <!-- Defer non-critical CSS -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    
    <link rel="preload" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"></noscript>
    
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css"></noscript>
    
    <!-- Preload critical JS -->
    <script type='text/javascript' src='{{ asset('client/js/jquery.min.js?ver=5.7.2') }}' id='halim-jquery-js'></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    
    <link rel="shortcut icon" href="https://www.pngkey.com/png/detail/360-3601772_your-logo-here-your-company-logo-here-png.png" type="image/x-icon" />
    <meta name="revisit-after" content="1 days" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    
    <title>Phim hay - Xem phim hay nhất tại PHIM CƠM </title>
    <meta name="description" content="Phim Cơm  - Xem phim hay nhất, xem phim online miễn phí, phim hot , phim nhanh" />
    <link rel="canonical" href="">
    <link rel="next" href="" />
    
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:title" content="Phim Cơm – Xem phim online HD, Vietsub nhanh nhất" />
    <meta property="og:description" content="Phim Cơm – Xem phim online miễn phí chất lượng HD, Vietsub & Thuyết minh. Tổng hợp phim Trung Quốc, Hàn Quốc, Việt Nam, Mỹ, phim chiếu rạp cập nhật nhanh." />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Phim Cơm - Xem phim hay nhất" />
    <meta property="og:image" content="https://phimcom.io.vn/uploads/logo/logo9942.png">
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="Phim Cơm – Xem phim online HD miễn phí" />
    <!-- Inline critical CSS -->
    <style type="text/css" id="wp-custom-css">
        .textwidget p a img {
            width: 100%;
        }
        
        /* Performance Optimization - Critical */
        * {
            -webkit-tap-highlight-color: transparent;
        }
        
        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        body {
            -webkit-overflow-scrolling: touch;
        }
        
        img {
            content-visibility: auto;
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
                  Tìm kiếm <i class="fa fa-search"></i> 
                </button>
                  <!--Nút đánh dấu phim-->
                  <!--<button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">-->
                  <!--Bookmarks<i class="hl-bookmark" aria-hidden="true"></i>-->
                  <!--<span class="count">0</span>-->
                  <!--</button>-->
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
               <div id="mobile-search-form" class="halim-search-form">
                  <!-- THÊM FORM VÀO ĐÂY -->
                  <div class="form-group form-timkiem">
                     <form action="{{ route('tim-kiem') }}" method="GET">
                        <div class="input-group">
                           <input id="timkiem-mobile" type="text" name="search" class="form-control" placeholder="Tìm kiếm phim..." autocomplete="off" required>
                           <span class="input-group-btn">
                              <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                           </span>
                        </div>
                     </form>
                  </div>
                  <ul class="list-group" id="result-mobile" style="display: none; overflow:scroll; max-height:60vh;"></ul>
               </div>
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
      <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
      <script>
(function() {
    // 1. Hàm nén ảnh và chặn tải ngay lập tức
    const optimizeAndBlock = () => {
        // Tìm tất cả ảnh từ ophim.live
        const selector = 'img[src*="ophim.live"], img[src*="phimimg.com"]';
        const images = document.querySelectorAll(selector);
        
        images.forEach(img => {
            if (!img.dataset.src) {
                let originalSrc = img.src;
                
                // Sử dụng Proxy của Weserv để nén ảnh (Giảm từ 2.8MB xuống ~50KB)
                // Tham số: w=300 (rộng 300px), output=webp (định dạng nhẹ nhất), q=80 (chất lượng 80%)
                let compressedSrc = `https://images.weserv.nl/?url=${encodeURIComponent(originalSrc)}&w=300&output=webp&q=80`;
                
                img.dataset.src = compressedSrc;
                // Chặn request gốc bằng ảnh rỗng
                img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
                img.classList.add('lazy-optimized');
            }
        });
    };

    // Chạy ngay khi trình duyệt đọc code
    optimizeAndBlock();

    // 2. Kích hoạt IntersectionObserver để Lazy Load
    document.addEventListener("DOMContentLoaded", function() {
        // Chạy lại lần nữa cho các ảnh load động (nếu có)
        optimizeAndBlock();

        if ("IntersectionObserver" in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.style.opacity = "1";
                        observer.unobserve(img);
                    }
                });
            }, { rootMargin: "0px 0px 400px 0px" });

            document.querySelectorAll('.lazy-optimized').forEach(img => {
                img.style.transition = "opacity 0.5s";
                img.style.opacity = "0.3";
                imageObserver.observe(img);
            });
        }
    });
})();
</script>
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
        var delayTimer;
        var cachedMovies = null; // Cache dữ liệu JSON
        
        // Load JSON một lần duy nhất khi trang được tải
        $.getJSON('/json_file/movies.json', function(data) {
            cachedMovies = data;
        });
        
        $('#timkiem').keyup(function(){
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                $('#result').html('');
                var search = $('#timkiem').val();
                if(search != '') {
                    $('#result').css('display','inherit');
                    
                    // Kiểm tra xem dữ liệu đã được load chưa
                    if (!cachedMovies) {
                        $('#result').append('<li class="list-group-item">Đang tải dữ liệu...</li>');
                        return;
                    }
                    
                    var expression = new RegExp(search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), "i");
                    var count = 0;
                    var results = []; // Tạo array để chứa kết quả
                    
                    // Dùng for loop thay vì $.each để có thể break sớm
                    for (var i = 0; i < cachedMovies.length && count < 15; i++) {
                        var value = cachedMovies[i];
                        if (value.title.search(expression) !== -1 || value.description.search(expression) !== -1) {
                            results.push(
                                '<a href="/phim/' + value.slug + '" style="text-decoration: none; color: inherit;">' +
                                '<li style="cursor:pointer" class="list-group-item link-class">' +
                                '<img src="' + (value.image.startsWith('https') ? value.image : '/uploads/movies/' + value.image) + 
                                '" height="40" width="40" class="" />' + 
                                value.title + 
                                '</li></a>'
                            );
                            count++;
                        }
                    }
                    
                    // Append tất cả kết quả một lần duy nhất
                    if (count == 0) {
                        $('#result').append('<li class="list-group-item">Không tìm thấy kết quả cho "' + search + '"</li>');
                    } else {
                        $('#result').append(results.join(''));
                        if (count == 15) {
                            $('#result').append('<li class="list-group-item">' + search + '</li>');
                        }
                    }
                    
                } else {
                    $('#result').css('display', 'none');
                }
            }, 300); // Tăng debounce lên 300ms
        });


    $('#result').on('click', 'li', function() { 
        var click_text = $(this).text().split('->');
        $('#timkiem').val(click_text[0].trim());
        $("#result").html('');
        $("#result").css('display','none');
    });
});

      </script>
    <script>
        // Mobile search autocomplete
        var delayTimerMobile;
        $('#timkiem-mobile').keyup(function(){
            clearTimeout(delayTimerMobile);
            delayTimerMobile = setTimeout(function() {
                $('#result-mobile').html('');
                var search = $('#timkiem-mobile').val();
                if(search != '') {
                    $('#result-mobile').css('display','block');
                    var expression = new RegExp(search, "i");
                    var count = 0;
                    $.getJSON('/json_file/movies.json', function(data) {
                        $.each(data, function(key, value){
                            if ((value.title.search(expression) !== -1 || value.description.search(expression) !== -1) && count < 15) {
                                $('#result-mobile').append(
                                    '<a href="/phim/' + value.slug + '" style="text-decoration: none; color: inherit;">' +
                                    '<li style="cursor:pointer" class="list-group-item link-class">' +
                                    '<img src="' + (value.image.startsWith('https') ? value.image : '/uploads/movies/' + value.image) + 
                                    '" height="40" width="40" loading="lazy" />' + 
                                    value.title + 
                                    '</li></a>'
                                );
                                count++;
                            }
                        });
                        if (count == 0) {
                            $('#result-mobile').append('<li class="list-group-item">Không tìm thấy kết quả</li>');
                        }
                    });
                } else {
                    $('#result-mobile').css('display', 'none');
                }
            }, 200);
        });
        
        $('#result-mobile').on('click', 'li', function() { 
            var click_text = $(this).text().split('->');
            $('#timkiem-mobile').val(click_text[0].trim());
            $("#result-mobile").html('');
            $("#result-mobile").css('display','none');
        });
    </script>

      
   </body>
</html>