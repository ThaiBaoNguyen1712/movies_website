@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-responsive ">
                <thead>
                    <tr>
                        <th scope="col">_id</th>
                        <th scope="col">name</th>
                        <th scope="col">slug</th>
                        <th scope="col">origin_name</th>
                        <th scope="col">content</th>
                        <th scope="col">type</th>
                        <th scope="col">status</th>
                        <th scope="col">thumb_url</th>
                        <th scope="col">poster_url</th>
                        <th scope="col">is_copyright</th>
                        <th scope="col">sub_docquyen</th>
                        <th scope="col">chieurap</th>
                        <th scope="col">trailer_url</th>
                        <th scope="col">time</th>
                        <th scope="col">episode_current</th>
                        <th scope="col">episode_total</th>
                        <th scope="col">quality</th>
                        <th scope="col">lang</th>
                        <th scope="col">year</th>
                        <th scope="col">view</th>
                        <th scope="col">actor</th>
                        <th scope="col">director</th>
                        <th scope="col">category</th>
                        <th scope="col">country</th>
                        <th scope="col">episodes</th>
                        <th scope="col">#</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $resp_movie['_id'] }}</td>
                        <td>{{ $resp_movie['name'] }}</td>
                        <td>{{ $resp_movie['slug'] }}</td>
                        <td>{{ $resp_movie['origin_name'] }}</td>
                        <td>{{ $resp_movie['content'] }}</td>
                        <td>{{ $resp_movie['type'] }}</td>
                        <td>{{ $resp_movie['status'] }}</td>
                        <td><img src="{{ $resp_movie['thumb_url'] }}" alt="Thumbnail" width="100"></td>
                        <td><img src="{{ $resp_movie['poster_url'] }}" alt="Poster" width="100"></td>
                        <td>{{ $resp_movie['is_copyright'] ? 'Yes' : 'No' }}</td>
                        <td>{{ $resp_movie['sub_docquyen'] ? 'Yes' : 'No' }}</td>
                        <td>{{ $resp_movie['chieurap'] ? 'Yes' : 'No' }}</td>
                        <td>
                            <iframe 
                                allowfullscreen 
                                frameborder="0" 
                                height="360" 
                                scrolling="no" 
                                src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($resp_movie['trailer_url'], 'v=') }}" 
                                width="100%">
                            </iframe>
                        </td>
                        <td>{{ $resp_movie['time'] }}</td>
                        <td>{{ $resp_movie['episode_current'] }}</td>
                        <td>{{ $resp_movie['episode_total'] }}</td>
                        <td>{{ $resp_movie['quality'] ?? 'N/A' }}</td>
                        <td>{{ $resp_movie['lang'] ?? 'N/A' }}</td>
                        <td>{{ $resp_movie['year'] ?? 'N/A' }}</td>
                        <td>{{ $resp_movie['view'] ?? 'N/A' }}</td>
                        <td>
                            @foreach($resp_movie['actor'] as $actor)
                                <span class="badge badge-info">{{ $actor }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($resp_movie['director'] as $directory)
                                <span class="badge badge-info">{{ $directory }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($resp_movie['category'] as $category)
                                <span class="badge badge-info">{{ $category['name'] }}</span>
                            @endforeach
                        </td>
        
                        <td>
                            @foreach($resp_movie['country'] as $country)
                                <span class="badge badge-info">{{ $country['name'] }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($resp_movie['episodes']))
                            @foreach($resp_movie['episodes'] as $episode)
                                @foreach($episode['server_data'] as $server)
                                    <span class="badge badge-info">{{ $server['name'] }}</span>
                                @endforeach
                            @endforeach
                        @else
                            <p>Không có dữ liệu tập phim.</p>
                        @endif
                        
                        </td>
                        <td>
                            <a href="{{ route('leech-episode',$resp_movie['slug']) }}" class="btn btn-warning btn-sm">Tập phim</a>
                        
                            @php
                                $movie=\App\Models\Movie::where('slug',$resp_movie['slug'])->first();
                            @endphp
                            @if(!$movie)
                                <form action="{{ route('leech-store',$resp_movie['slug']) }}" method="POST">
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
                </tbody>
            </table>
            
            
            </div>
        </div>
    </div>
</div>
@endsection

