
<aside class="sidebar-left">
    <nav class="navbar navbar-inverse">
      <div class="navbar-header">
        <button
          type="button"
          class="navbar-toggle collapsed"
          data-toggle="collapse"
          data-target=".collapse"
          aria-expanded="false"
        >
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <h1>
          <a class="navbar-brand" href="{{ url('/home') }}">
            <img class="logo" src="{{ asset('uploads/logo/'.$info->logo) }}" style="height: 30px" alt="Phim hay- Xem phim hay nhất" />
            
            </a
          >
        </h1>
      </div>
      <div
        class="collapse navbar-collapse"
        id="bs-example-navbar-collapse-1"
      >
        <ul class="sidebar-menu">
          <li class="header">Quản lý thành phần phim</li>
          <li class="treeview">
            <a href="{{ url('/home') }}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          @php
              $segment= Request::segment(1);
          @endphp
          <li class="treeview {{ ($segment == 'category') ? 'active' : '' }}">
            <a href="#">
              <i class="fa  fa-th-large"></i>
              <span>Danh mục phim</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{ route('category.create') }}"
                  ><i class="fa fa-angle-right"></i> Danh mục</a
                >
              </li>
            </ul>
          </li>
         
            <li class="treeview {{ ($segment == 'genre') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-list"></i>
              <span>Thể loại phim</span>
              <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{ route('genre.create') }}"
                  ><i class="fa fa-angle-right"></i>Thể loại</a
                >
              </li>
            </ul>
          </li>
        
          <li class="treeview {{ ($segment == 'country') ? 'active' : '' }} ">
              <a href="#">
                <i class="fa fa-globe"></i>
                <span>Quốc gia phim</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="{{ route('country.create') }}"
                    ><i class="fa fa-angle-right"></i>Quốc gia</a
                  >
                </li>
              </ul>
            </li>
               
          <li class="treeview {{ ($segment == 'movie') ? 'active' : '' }} ">
              <a href="#">
                <i class="fa  fa-film"></i>
                <span>Phim</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="{{ route('movie.create') }}"
                    ><i class="fa fa-angle-right"></i>Thêm phim</a
                  >
                </li>
                <li>
                  <a href="{{ route('movie.index') }}"
                    ><i class="fa fa-angle-right"></i>Liệt kê phim</a
                  >
                </li>
              </ul>
            </li>
            <li class="treeview {{ ($segment == 'episode') ? 'active' : '' }} ">
              <a href="#">
                <i class="fa  fa-indent"></i>
                <span>Tập phim</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="{{ route('episode.create') }}"
                    ><i class="fa fa-angle-right"></i>Thêm tập phim</a
                  >
                </li>
                <li>
                  <a href="{{ route('episode.index') }}"
                    ><i class="fa fa-angle-right"></i>Liệt kê tập phim</a
                  >
                </li>
                
              </ul>
            </li>
            <li class="treeview {{ ($segment == 'linkmovie') ? 'active' : '' }} ">
                <a href="#">
                  <i class="fa  fa-link"></i>
                  <span>Link phim</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{ route('linkmovie.create') }}"
                      ><i class="fa fa-angle-right"></i>Quản lý link phim</a
                    >
                  </li>
                  
                </ul>
              </li>
              <li class="treeview {{ ($segment == 'leech-movie') ? 'active' : '' }} ">
                <a href="#">
                  <i class="fa  fa-code"></i>
                  <span>Leech phim</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="{{ route('leech-movie') }}"
                      ><i class="fa fa-angle-right"></i>Cập nhật phim</a
                    >
                  </li>
                  
                </ul>
              </li>
            
            <li class="treeview {{ ($segment == 'info') ? 'active' : '' }} ">
              <a href="#">
                <i class="fa fa-cog"></i>
                <span>Cấu hình trang web</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="{{ route('info.create') }}"
                    ><i class="fa fa-angle-right"></i>Tùy chỉnh</a
                  >
                </li>
                
              </ul>
            </li>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
    </nav>
  </aside>
