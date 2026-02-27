@extends('layouts.app')

@section('content')
<!-- Modal chi tiet phim -->
<div class="modal fade" id="chitietphim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span id="content-title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="content-detail"></span>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiet tap phim -->
<div class="modal fade" id="tapphim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><span id="content-episode"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <span id="content-detail-episode"></span>
        </div>
        <div class="modal-footer">
            
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<div class="container">
    <div class="row justify-content-center">
        
        <div class="row card-header">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <label for="select-page">Trang API</label>
                    <select class="form-control" name="page" id="select-page">
                        @for($i = 1; $i <= 1000; $i++)
                            <option {{ isset($page) && $page == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <label for="select-page">Trang Crawl</label>
                    <select class="form-control" name="page" id="select-site">
                          <option value="ophim">ophim</option>
                        <option value="kkphim">kkphim</option>

                    </select>
                </div>

            </div>
            <div class="col-md-12 mt-2 text-right">
                <button id="leech-all" class="btn btn-success">
                    <i class="fa fa-download"></i> Đồng bộ tất cả phim trang này
                </button>
            </div>
           
                <div class="col-md-12 mt-4">
                    <div class="input-group">
                        <input type="search" name="slug" placeholder="Nhập tên hoặc slug phim" class="form-control" id="slug">
                        <div class="input-group-append">
                            <button id="search" class="btn btn-primary">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                        <div id="search-results"></div>
                    </div>
                </div>
           
            
            <div class="col-md-12 mt-4">
                <div class="form-row align-items-end">
                   
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Từ trang" id="from-page">
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" placeholder="Đến trang" id="to-page">
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-warning" id="leech-page">
                            <i class="fa fa-download"></i> Đồng bộ tất cả
                        </a>
                    </div>
                </div>
            </div>
            <div id="loading" class="spinner-border text-primary d-none ml-2" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div id="success" class="alert alert-success d-none mt-2" role="alert">
                Thành công thêm tất cả...
            </div>
        </div>
    </div>
    
        <div class="pb-5"></div>
        <div class="col-md-12">
            <div id="movie-list">
                @include('admincp.leech.movie-list')
            </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#select-page, #select-site').change(function(){
        var page = $('#select-page').val();
        var site = $('#select-site').val();
        console.log(page, site);
        $.ajax({
            url: '{{ route("leech-movie-select") }}',
            method: "GET",
            data: { page: page  , site: site },
            success: function(response) {
                $('#movie-list').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
</script>
<script>
$('#search').click(function () {

    var keyword = $('#slug').val().trim();
    if (!keyword) {
        alert('Nhập tên phim');
        return;
    }

    var table = $('#myTable').DataTable();

    // Clear bảng trước
    table.clear().draw();

    $.ajax({
        url: 'https://ophim1.com/v1/api/tim-kiem',
        method: 'GET',
        data: {
            keyword: keyword,
            page: 1,
            limit: 10
        },
        success: function (res) {

            if (res.status !== "success" || !res.data.items.length) {
                table.row.add([
                    '', '', 'Không tìm thấy phim', '', '', '', '', '', ''
                ]).draw();
                return;
            }

            var baseImg = "https://img.ophim.live/uploads/movies/";

            res.data.items.forEach(function (item, index) {

                var thumb = item.thumb_url.includes('http')
                    ? item.thumb_url
                    : baseImg + item.thumb_url;

                var poster = item.poster_url.includes('http')
                    ? item.poster_url
                    : baseImg + item.poster_url;

                var actionButtons = `
                    <button type="button"
                        class="btn btn-primary btn-sm leech_details"
                        data-movie_slug="${item.slug}"
                        data-toggle="modal"
                        data-target="#chitietphim">
                        Chi tiết
                    </button>

                    <a href="/leech-episode/${item.slug}"
                        class="btn btn-warning btn-sm">
                        Tập phim
                    </a>

                    <button type="button"
                        class="btn btn-success btn-sm leech_details_episode"
                        data-movie_slug="${item.slug}"
                        data-toggle="modal"
                        data-target="#tapphim">
                        Mở modal tập phim
                    </button>

                    <form action="/leech-store/${item.slug}"
                        method="POST"
                        style="margin-top:5px;">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit"
                            class="btn btn-success btn-sm"
                            value="Thêm phim">
                    </form>
                `;

                table.row.add([
                    index,
                    item._id || '',
                    item.name || '',
                    item.origin_name || '',
                    `<img src="${thumb}" style="width:100px;">`,
                    `<img src="${poster}" style="width:100px;">`,
                    item.slug || '',
                    item.year || '',
                    actionButtons
                ]);
            });

            table.draw();
        },
        error: function () {
            alert('Lỗi gọi API');
        }
    });

});
</script>
<script>
$('#slug').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();   // tránh submit form reload trang
        $('#search').click();
    }
});
</script>
<script>
    $(document).on('click', '.leech_details', function() {
        var slug = $(this).data('movie_slug');
        var url = '{{ route("watch-leech-detail") }}';
        var site = $('#select-site').val();
        $.ajax({
            url: url,
            method: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { slug: slug , site: site },
            success: function(response) {
                $('#content-title').html(response.content_title);
                $('#content-detail').html(response.content_detail);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
</script>

<script>
    $(document).on('click', '.leech_details', function() {
        var slug = $(this).data('movie_slug');
        var url = '{{ route("watch-leech-detail") }}';

        $.ajax({
            url: url,
            method: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { slug: slug },
            success: function(response) {
                $('#content-title').html(response.content_title);
                $('#content-detail').html(response.content_detail);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
</script>
<script>
    $(document).on('click', '.leech_details_episode', function() {
        var slug = $(this).data('movie_slug');
        var url = '{{ route("watch-leech-detail-episode") }}';

        $.ajax({
            url: url,
            method: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { slug: slug },
            success: function(response) {
                $('#content-episode').html(response.content_episode);
                $('#content-detail-episode').html(response.content_detail_episode);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
</script>
<script>
        $(document).on('click', '#leech-all', function() {
            var page = $('#select-page').val();
            var site = $('#select-site').val();
            var url = '{{ route("leech-store-all") }}';
            var $btn = $(this); // Lưu lại nút để xử lý UI

            // 1. Trước khi gửi: Hiện hiệu ứng chờ
            $('#overlayer').show(); 
            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang leech dữ liệu...');

            $.ajax({
                url: url,
                method: "GET",
                data: { page: page, site: site },
                // Pace.js sẽ tự động vẽ thanh tiến trình trên đầu trang khi thấy request này
                success: function(response) {
                    // 2. Khi thành công
                    $('#overlayer').hide();
                    toastr.success('Leech dữ liệu hoàn tất!');
                    
                    // Reload lại trang sau 1.5s để cập nhật danh sách phim mới
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // 3. Khi lỗi
                    $('#overlayer').hide();
                    $btn.prop('disabled', false).html('Leech Toàn Bộ Trang');
                    toastr.error('Đã xảy ra lỗi trong quá trình Leech!');
                }
            });
        });
</script>
<script>
   $(document).on('click', '#leech-page', function() {
    var page_start = $('#from-page').val();
    var page_end = $('#to-page').val();
  
    var url = '{{ route("leech-store-all-page") }}';
    // Hiển thị hiệu ứng loading khi bắt đầu gửi request
    $('#loading').show();

    $.ajax({
        url: url,
        method: "GET",
        data: { page_start: page_start, page_end:page_end},
        success: function(response) {
            // Ẩn hiệu ứng loading khi request thành công
            $('#loading').hide();

            // Xử lý dữ liệu response ở đây
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Ẩn hiệu ứng loading nếu có lỗi xảy ra
            $('#loading').hide();
            $('#success').show();
            setTimeout(function() {
                $('#success').hide();
            }, 5000);
            alert('Đã xảy ra lỗi: ' + textStatus + ' - ' + errorThrown);
        }
    });
});

</script>

 
@endsection

