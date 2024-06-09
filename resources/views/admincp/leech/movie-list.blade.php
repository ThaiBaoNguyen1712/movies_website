<table id="myTable" class="table table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col">STT</th>
        <th scope="col">Id</th>
        <th scope="col">Tên phim</th>
        <th scope="col">Tên chính thức</th>
        <th scope="col">Hình ảnh phim</th>
        <th scope="col">Hình ảnh poster</th>
        <th scope="col">Slug</th>
        <th scope="col">Năm</th>
        <th scope="col">#</th>
      </tr>
    </thead>
    <tbody>
            @foreach($resp['items'] as $key => $res)
                <tr>
                    <th scope="row">{{ $key }}</th>
                    <td>{{ $res['_id'] }}</td>
                    <td>{{ $res['name'] }}</td>
                    <td>{{ $res['origin_name'] }}</td>
                   
                    <td> <figure><img class="lazy img-responsive" src="{{$resp['pathImage']. $res['thumb_url']}}"></figure> </td>
                    <td><figure><img class="lazy img-responsive" src="{{$resp['pathImage']. $res['poster_url']}}"></figure></td>
                    <td>{{ $res['slug'] }}</td>
                    <td>{{ $res['year'] }}</td>
                    <td>
                        {{-- <a target="blank" href="{{ route('leech-detail',$res['slug']) }}" class="btn btn-primary btn-sm">Chi tiết</a> --}}
                        <button type="button" class="btn btn-primary btn-sm leech_details" data-movie_slug="{{ $res['slug'] }}" data-toggle="modal" data-target="#chitietphim">
                          Chi tiết
                      </button>
                        <a href="{{ route('leech-episode',$res['slug']) }}" class="btn btn-warning btn-sm">Tập phim</a>                        
                        <button type="button" class="btn btn-success btn-sm leech_details_episode" data-movie_slug="{{ $res['slug'] }}" data-toggle="modal" data-target="#tapphim">
                          Mở modal tập phim
                      </button>
                        @php
                            $movie=\App\Models\Movie::where('slug',$res['slug'])->first();
                        @endphp
                        @if(!$movie)
                            <form action="{{ route('leech-store',$res['slug']) }}" method="POST">
                                @csrf
                                <input type="submit" class="btn btn-success  btn-sm" value="Thêm phim" name="" id="">
                            </form>
                        @else
                        <form action="{{ route('movie.destroy',$movie->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                          <input type="submit" class="btn btn-danger  btn-sm" value="Xóa phim">
                        </form>
                        @endif
                    </td>
      
      </tr>
      @endforeach
    </tbody>
  </table>