@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table id="myTable" class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Số tập</th>
                        <th scope="col">Server</th>
                        <th scope="col">Link Embed from Ophim1.com</th>
                        <th scope="col">Link Embed from Phimapi.com</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resp['episodes'] as $key => $res)
                    <tr>
                        <th scope="row">{{ $key +1 }}</th>
                        <td>{{ $resp['movie']['name'] }}</td>
                        <td>{{ $resp['movie']['slug'] }}</td>
                        <td>{{ $resp['movie']['episode_total'] }}</td>
                        <td>{{ $res['server_name'] }}</td>

                        <td>
                            @foreach($res['server_data'] as $server_1)
                            <ul>
                                <li>Tập : {{ $server_1['name'] }}
                                    <input type="text" class="form-control" value="{{ $server_1['link_embed'] }}" id="">
                                </li>
                            </ul>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($resp_kkphim['episodes'][$key]))
                            @foreach($resp_kkphim['episodes'][$key]['server_data'] as $server_2)
                            <ul>
                                <li>Tập : {{ $server_2['name'] }}
                                    <input type="text" class="form-control" value="{{ $server_2['link_embed'] }}" id="">
                                </li>
                            </ul>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('leech-episode-store', ['slug' => $resp['movie']['slug'], 'from' => 'OPhim']) }}" method="POST">
                                @csrf
                                <input type="submit" value="Thêm tập phim từ OPhim" class="btn btn-success btn-sm">
                            </form>
                            <form action="{{ route('leech-episode-store',['slug' => $resp['movie']['slug'],'from'=>'KKPhim']) }}" method="POST">
                                @csrf
                                <input type="submit" value="Thêm tập phim từ KKPhim" class="btn btn-primary btn-sm">
                            </form>
                            <form action="{{ route('leech-episode-store',['slug' => $resp['movie']['slug'],'from'=>'All']) }}" method="POST">
                                @csrf
                                <input type="submit" value="Thêm tập phim từ cả 2 nguồn" class="btn btn-secondary btn-sm">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
