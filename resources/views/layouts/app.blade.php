
<!DOCTYPE html>
<html>
  <head>
    <title>
     Admin Web Phim
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta
      name="keywords"
      content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"
    />
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/x-javascript">
      addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);

                      function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <!-- Bootstrap Core CSS -->
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('backend/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- font-awesome icons CSS -->
    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- //font-awesome icons CSS-->
    <!-- side nav css file -->
    <link
      href={{ asset('backend/css/SidebarNav.min.css') }}
      media="all"
      rel="stylesheet"
      type="text/css"
    />
    <!-- //side nav css file -->
    <!-- js-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <script src="{{asset('backend/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{asset('backend/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.js') }}"></script>
    <!--webfonts-->
    <link
      href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
      rel="stylesheet"
    />
    <!--//webfonts-->
    <!-- chart -->
    <script src="{{ asset('backend/js/Chart.js') }}"></script>
    <!-- //chart -->
    <!-- Metis Menu -->
    <script src="{{asset('backend/js/metisMenu.min.js') }}"></script>
    <script src="{{asset('backend/js/metisMenu.min.js') }}"></script>
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet" />
    <!--//Metis Menu -->
    <style>
      #chartdiv {
        width: 100%;
        height: 295px;
      }
    </style>
  
    <link href="{{ asset('backend/css/owl.carousel.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend/js/owl.carousel.js') }}"></script>
  </head>

  <body class="cbp-spmenu-push">
    @if(Auth::check())
    <div class="main-content">
      <div
        class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left"
        id="cbp-spmenu-s1"
      >
        <!--left-fixed -navigation-->
        @include('layouts.navbar')
       
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              // Select all treeview links
              var treeviewLinks = document.querySelectorAll('.treeview > a');
          
              // Iterate over each link
              treeviewLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                  e.preventDefault();
          
                  // Get the parent .treeview element
                  var treeview = this.parentElement;
          
                  // If the clicked treeview is already active, just remove the active class and hide the menu
                  if (treeview.classList.contains('active')) {
                    treeview.classList.remove('active');
                    var menu = treeview.querySelector('.treeview-menu');
                    if (menu) {
                      menu.style.display = 'none';
                    }
                  } else {
                    // Close all other open treeview menus
                    document.querySelectorAll('.treeview.active').forEach(function(activeTreeview) {
                      activeTreeview.classList.remove('active');
                      var menu = activeTreeview.querySelector('.treeview-menu');
                      if (menu) {
                        menu.style.display = 'none';
                      }
                    });
          
                    // Open the clicked treeview menu
                    treeview.classList.add('active');
                    var menu = treeview.querySelector('.treeview-menu');
                    if (menu) {
                      menu.style.display = 'block';
                    }
                  }
                });
              });
            });
          </script>
          
      </div>
      <!--left-fixed -navigation-->
      <!-- header-starts -->
      <div class="sticky-header header-section">
        <div class="header-left">
          <!--toggle button start-->
          <button id="showLeftPush"><i class="fa fa-bars"></i></button>
          <!--toggle button end-->
          <div class="profile_details_left">
            <!--notifications of menu start -->
           
            <div class="clearfix"></div>
          </div>
          <!--notification menu end -->
          <div class="clearfix"></div>
        </div>
        <div class="header-right">
          <!--search-box-->
          <div class="search-box">
            <form class="input">
              <input
                class="sb-search-input input__field--madoka"
                placeholder="Search..."
                type="search"
                id="input-31"
              />
              <label class="input__label" for="input-31">
                <svg
                  class="graphic"
                  width="100%"
                  height="100%"
                  viewBox="0 0 404 77"
                  preserveAspectRatio="none"
                >
                  <path d="m0,0l404,0l0,77l-404,0l0,-77z" />
                </svg>
              </label>
            </form>
          </div>
          <!--//end-search-box-->
          <div class="profile_details">
            <ul>
              <li class="dropdown profile_details_drop">
                <a
                  href="#"
                  class="dropdown-toggle"
                  data-toggle="dropdown"
                  aria-expanded="false"
                >
                  <div class="profile_img">
                    <span class="prfil-img"
                      ><img src="images/2.jpg" alt="" />
                    </span>
                    <div class="user-name">
                      <p>Admin Name</p>
                      <span>Administrator</span>
                    </div>
                    <i class="fa fa-angle-down lnr"></i>
                    <i class="fa fa-angle-up lnr"></i>
                    <div class="clearfix"></div>
                  </div>
                </a>
                <ul class="dropdown-menu drp-mnu">
        
                  <li>
                  <!-- Form ẩn để logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <!-- Thẻ <a> đóng vai trò submit -->
                    <a href="#" onclick="document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> Logout
                    </a>

                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
      <!-- //header-ends -->
      <!-- main content start-->
      <div id="page-wrapper" style="height: max-content">
        <div class="main-page">
          <div class="col_3">
            <div class="col-md-3 widget widget1">
              <div class="r3_counter_box">
                <i class="pull-left fa fa-file icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $category_total }}</strong></h5>
                  <span>Danh mục phim</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 widget widget1">
              <div class="r3_counter_box">
                <i class="pull-left fa fa-list user1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $genre_total }}</strong></h5>
                  <span>Thể loại phim</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 widget widget1">
              <div class="r3_counter_box">
                <i class="pull-left fa fa-globe user2 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $country_total }}</strong></h5>
                  <span>Quốc gia phim</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 widget widget1">
              <div class="r3_counter_box">
                <i class="pull-left fa fa-film dollar1 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $movie_total }}</strong></h5>
                  <span>Phim</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 widget">
              <div class="r3_counter_box">
                <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                <div class="stats">
                  <h5><strong>{{ $access }}</strong></h5>
                  <span>Lượt truy cập</span>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="" style="padding: 10px 0 10px 0"></div>

          {{-- content partiel view --}}
          <div class="">@yield('content')</div>



          <script src="{{ asset('backend/js/amcharts.js') }}"></script>
          <!-- for amcharts js -->
          <script src="{{ asset('backend/js/amcharts.js') }}"></script>
         
        </div>
      </div>
      <!--footer-->
      <div class="footer">
        <p>
          &copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by
          <a href="https://w3layouts.com/" target="_blank">w3layouts</a>
        </p>
      </div>
      <!--//footer-->
    </div>
    @else
    @yield('login')
    @endif
    <!-- new added graphs chart js-->
    <script src="{{ asset('backend/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('backend/js/classie.js') }}"></script>
    <script>
      var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

      showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
      };

      function disableOther(button) {
        if (button !== 'showLeftPush') {
          classie.toggle(showLeftPush, 'disabled');
        }
      }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->
    <!--scrolling js-->
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
    <!--//scrolling js-->
    <!-- side nav js -->
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
    {{-- <script>
      $('.sidebar-menu').SidebarNav();
    </script> --}}
    <!-- //side nav js -->
    <!-- for index page weekly sales java script -->
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
    <script>
      var graphdata1 = {
        linecolor: '#CCA300',
        title: 'Monday',
        values: [
          { X: '6:00', Y: 10.0 },
          { X: '7:00', Y: 20.0 },
          { X: '8:00', Y: 40.0 },
          { X: '9:00', Y: 34.0 },
          { X: '10:00', Y: 40.25 },
          { X: '11:00', Y: 28.56 },
          { X: '12:00', Y: 18.57 },
          { X: '13:00', Y: 34.0 },
          { X: '14:00', Y: 40.89 },
          { X: '15:00', Y: 12.57 },
          { X: '16:00', Y: 28.24 },
          { X: '17:00', Y: 18.0 },
          { X: '18:00', Y: 34.24 },
          { X: '19:00', Y: 40.58 },
          { X: '20:00', Y: 12.54 },
          { X: '21:00', Y: 28.0 },
          { X: '22:00', Y: 18.0 },
          { X: '23:00', Y: 34.89 },
          { X: '0:00', Y: 40.26 },
          { X: '1:00', Y: 28.89 },
          { X: '2:00', Y: 18.87 },
          { X: '3:00', Y: 34.0 },
          { X: '4:00', Y: 40.0 },
        ],
      };
      var graphdata2 = {
        linecolor: '#00CC66',
        title: 'Tuesday',
        values: [
          { X: '6:00', Y: 100.0 },
          { X: '7:00', Y: 120.0 },
          { X: '8:00', Y: 140.0 },
          { X: '9:00', Y: 134.0 },
          { X: '10:00', Y: 140.25 },
          { X: '11:00', Y: 128.56 },
          { X: '12:00', Y: 118.57 },
          { X: '13:00', Y: 134.0 },
          { X: '14:00', Y: 140.89 },
          { X: '15:00', Y: 112.57 },
          { X: '16:00', Y: 128.24 },
          { X: '17:00', Y: 118.0 },
          { X: '18:00', Y: 134.24 },
          { X: '19:00', Y: 140.58 },
          { X: '20:00', Y: 112.54 },
          { X: '21:00', Y: 128.0 },
          { X: '22:00', Y: 118.0 },
          { X: '23:00', Y: 134.89 },
          { X: '0:00', Y: 140.26 },
          { X: '1:00', Y: 128.89 },
          { X: '2:00', Y: 118.87 },
          { X: '3:00', Y: 134.0 },
          { X: '4:00', Y: 180.0 },
        ],
      };
      var graphdata3 = {
        linecolor: '#FF99CC',
        title: 'Wednesday',
        values: [
          { X: '6:00', Y: 230.0 },
          { X: '7:00', Y: 210.0 },
          { X: '8:00', Y: 214.0 },
          { X: '9:00', Y: 234.0 },
          { X: '10:00', Y: 247.25 },
          { X: '11:00', Y: 218.56 },
          { X: '12:00', Y: 268.57 },
          { X: '13:00', Y: 274.0 },
          { X: '14:00', Y: 280.89 },
          { X: '15:00', Y: 242.57 },
          { X: '16:00', Y: 298.24 },
          { X: '17:00', Y: 208.0 },
          { X: '18:00', Y: 214.24 },
          { X: '19:00', Y: 214.58 },
          { X: '20:00', Y: 211.54 },
          { X: '21:00', Y: 248.0 },
          { X: '22:00', Y: 258.0 },
          { X: '23:00', Y: 234.89 },
          { X: '0:00', Y: 210.26 },
          { X: '1:00', Y: 248.89 },
          { X: '2:00', Y: 238.87 },
          { X: '3:00', Y: 264.0 },
          { X: '4:00', Y: 270.0 },
        ],
      };
      var graphdata4 = {
        linecolor: 'Random',
        title: 'Thursday',
        values: [
          { X: '6:00', Y: 300.0 },
          { X: '7:00', Y: 410.98 },
          { X: '8:00', Y: 310.0 },
          { X: '9:00', Y: 314.0 },
          { X: '10:00', Y: 310.25 },
          { X: '11:00', Y: 318.56 },
          { X: '12:00', Y: 318.57 },
          { X: '13:00', Y: 314.0 },
          { X: '14:00', Y: 310.89 },
          { X: '15:00', Y: 512.57 },
          { X: '16:00', Y: 318.24 },
          { X: '17:00', Y: 318.0 },
          { X: '18:00', Y: 314.24 },
          { X: '19:00', Y: 310.58 },
          { X: '20:00', Y: 312.54 },
          { X: '21:00', Y: 318.0 },
          { X: '22:00', Y: 318.0 },
          { X: '23:00', Y: 314.89 },
          { X: '0:00', Y: 310.26 },
          { X: '1:00', Y: 318.89 },
          { X: '2:00', Y: 518.87 },
          { X: '3:00', Y: 314.0 },
          { X: '4:00', Y: 310.0 },
        ],
      };
      var Piedata = {
        linecolor: 'Random',
        title: 'Profit',
        values: [
          { X: 'Monday', Y: 50.0 },
          { X: 'Tuesday', Y: 110.98 },
          { X: 'Wednesday', Y: 70.0 },
          { X: 'Thursday', Y: 204.0 },
          { X: 'Friday', Y: 80.25 },
          { X: 'Saturday', Y: 38.56 },
          { X: 'Sunday', Y: 98.57 },
        ],
      };
    
    </script>
    <!-- //for index page weekly sales java script -->
    <!-- Bootstrap Core JavaScript -->
    <!-- //Bootstrap Core JavaScript -->
   

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
    <script type="text/javascript">
        $('.select-year').change(function(){
            var year =$(this).find(':selected').val();
            var id_phim=$(this).attr('id');
            $.ajax({
                url:"{{ url('/update-year-phim') }}",
                method:"GET",
                data:{year:year,id_phim:id_phim},
                success:function()
                {
                    alert('Thay đổi năm phim ' +year+' thành công');
                }
            })
        })
    </script>
     <script type="text/javascript">
        $('.select-season').change(function(){
            var season =$(this).find(':selected').val();
            var id_phim=$(this).attr('id');
            $.ajax({
                url:"{{ url('/update_season') }}",
                method:"GET",
                data:{season:season,id_phim:id_phim},
                success:function()
                {
                    alert('Thay đổi phim season ' +season+' thành công');
                }
            })
        })
    </script>
    {{-- <script type="text/javascript">
        $('.select-topview').change(function(){
            var topview =$(this).find(':selected').val();
            var id_phim=$(this).attr('id');
            // alert(year);
            // alert(id_phim)
            if(topview==0)
            {
                var text='Ngày';
            }
            else if(topview==1)
            {
                var text='Tuần';
            }
            if(topview==2)
            {
                var text='Tháng';
            }
            $.ajax({
                url:"{{ url('/update-topview-phim') }}",
                method:"GET",
                data:{topview:topview,id_phim:id_phim},
                success:function()
                {
                    alert('Thay đổi phim theo top view ' + text + ' thành công');
                }
            })
        })
    </script> --}}
    <script type="text/javascript">
       function ChangeToSlug() {
    var slug;
    // Lấy text từ thẻ input title
    slug = document.getElementById("slug").value;

    // Chuyển đổi ký tự có dấu thành không dấu
    slug = slug.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ặ|ẵ|â|ấ|ầ|ẩ|ậ|ẫ/g, 'a');
    slug = slug.replace(/é|è|ẻ|ẹ|ẽ|ê|ế|ề|ể|ệ|ễ/g, 'e');
    slug = slug.replace(/í|ì|ỉ|ị|ĩ/g, 'i');
    slug = slug.replace(/ó|ò|ỏ|ọ|õ|ô|ố|ồ|ổ|ộ|ỗ|ơ|ớ|ờ|ở|ợ|ỡ/g, 'o');
    slug = slug.replace(/ú|ù|ủ|ụ|ũ|ư|ứ|ừ|ử|ự|ữ/g, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỵ|ỹ/g, 'y');
    slug = slug.replace(/đ/g, 'd');

    // Xóa các ký tự đặc biệt và khoảng trắng
    slug = slug.replace(/[^a-z0-9\s-]/g, '');

    // Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/\s+/g, '-');

    // Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    slug = slug.replace(/-+/g, '-');

    // Xóa các ký tự gạch ngang ở đầu và cuối
    slug = slug.replace(/^-+|-+$/g, '');

    // In slug ra textbox có id "convert_slug"
    document.getElementById('convert_slug').value = slug;
}

        </script>
         <script>
$( function() {
    $( ".sortable" ).sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            var array_id = [];
            $('.sortable tr').each(function() {
                array_id.push($(this).attr('id'));
            });
           // Đối với category
$.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('resorting.category') }}",
    method: "POST",
    data: { array_id: array_id },
    success: function(data) {
        alert('Sắp xếp thành công');
    }
});


        }
    });
    $( ".sortable1" ).disableSelection();
});

$( function() {
    $( ".sortableGenre" ).sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            var array_id = [];
            $('.sortableGenre tr').each(function() {
                array_id.push($(this).attr('id'));
            });
            console.log(array_id)
            $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('resorting.genre') }}",
    method: "POST",
    data: { array_id: array_id },
    success: function(data) {
        alert('Sắp xếp thành công');
    }
});


        }
    });
    $( ".sortable1" ).disableSelection();
});
$( function() {
    $( ".sortableCountry" ).sortable({
        placeholder: "ui-state-highlight",
        update: function(event, ui) {
            var array_id = [];
            $('.sortableCountry tr').each(function() {
                array_id.push($(this).attr('id'));
            });
           // Đối với category
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('resorting.country') }}",
            method: "POST",
            data: { array_id: array_id },
            success: function(data) {
                alert('Sắp xếp thành công');
            }
        });


        }
    });
    $( ".sortable1" ).disableSelection();
});
            </script>

            <script>
               let table1 = new DataTable('#myTable');
let table2 = new DataTable('#myTable2');
let table3 = new DataTable('#myTable3');
let table4 = new DataTable('#myTable4');


            </script>
            <script type="text/javascript">
                $('.select-movie').change(function(){
                    var id =$(this).val();
          
                    $.ajax({
                        url: "{{route('select-movie')}}",
                        method: "GET",
                        data: {id:id},
                        success: function(data) {
                          $('#show_movie').html(data);
                        }
                    });
                })
            </script>
             <script type="text/javascript">
                $(document).ready(function(){
                    var id = $('.select-movie-exist').val();
  
                    $.ajax({
                        url: "{{route('select-movie')}}",
                        method: "GET",
                        data: {id:id},
                        success: function(data) {
                            $('#show_movie').html(data);
                        }
                    });
                });
            </script>
        
  
      
          
  </body>
</html>
