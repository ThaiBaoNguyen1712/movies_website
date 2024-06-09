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
            <div class="col-md-6 text-right">
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
    $('#select-page').change(function(){
        var page = $(this).val();
        $.ajax({
            url: '{{ route("leech-movie-select") }}',
            method: "GET",
            data: { page: page },
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
    // Hàm chuyển đổi chuỗi thành slug
    function stringToSlug(str) {
        // Đổi chữ hoa thành chữ thường
        str = str.toLowerCase();

        // Xóa các ký tự không phải chữ cái hoặc số
        str = str.replace(/[^a-z0-9\s-]/g, '');

        // Thay đổi khoảng trắng và dấu gạch ngang thành một dấu gạch ngang duy nhất
        str = str.replace(/[\s-]+/g, '-');

        return str;
    }

    $('#search').click(function(){
        var input = $('#slug').val();
        var slug = stringToSlug(input);
        var url = '{{ route("leech-detail", ["slug" => ":slug"]) }}';
        url = url.replace(':slug', slug);

        $.ajax({
            url: url,
            method: "GET",
            success: function(response) {
                // Chuyển hướng trình duyệt đến URL mới
                window.location.href = url;
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
     var url = '{{ route("leech-store-all") }}';
 
     // Hiển thị hiệu ứng loading khi bắt đầu gửi request
     $('#loading').show();
 
     $.ajax({
         url: url,
         method: "GET",
         data: { page: page },
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

