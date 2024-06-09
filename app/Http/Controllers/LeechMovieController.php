<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\LinkMovie;
use App\Models\Episode;
//QUEUE
use App\Jobs\ProcessMovie;

use Carbon\Carbon;
class LeechMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leech_movie(){
        $resp =Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1")->json();
        return view('admincp.leech.index',compact('resp'));
    }
    public function leech_movie_select(Request $request) {
        $page = $request->input('page');
        $resp = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=".$page)->json();
        return view('admincp.leech.movie-list', compact('resp','page'));
    }
    
    public function leech_detail($slug){
        $resp =Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_movie =$resp['movie'];
        return view('admincp.leech.detail',compact('resp_movie'));
    }

    public function watch_leech_detail(Request $request)
        {
            $slug = $request->slug;

            $resp = Http::get('https://ophim1.com/phim/'.$slug)->json();

            $resp_array[] = $resp['movie'];

            $output['content_title'] = '<h3 style="text-align: center;text-transform: uppercase;">'.$resp['movie']['name'].'</h3>';

            $output['content_detail'] = '
                <div class="row">
                    <div class="col-md-5"><img src="'.$resp['movie']['thumb_url'].'" width="100%"></div>
                    <div class="col-md-7">
                        <h5><b>Tên phim :</b>'.$resp['movie']['name'].'</h5>
                        <p><b>Tên tiếng anh:</b> '.$resp['movie']['origin_name'].'</p>
                        <p><b>Trạng thái :</b> '.$resp['movie']['episode_current'].'</p>
                        <p><b>Số tập :</b> '.$resp['movie']['episode_total'].'</p>
                        <p><b>Thời lượng :</b> '.$resp['movie']['time'].'</p>
                        <p><b>Năm phát hành :</b> '.$resp['movie']['year'].'</p>
                        <p><b>Chất lượng :</b> '.$resp['movie']['quality'].'</p>
                        <p><b>Ngôn ngữ :</b> '.$resp['movie']['lang'].'</p>';
                        foreach($resp['movie']['director'] as $dir) {
                            $output['content_detail'] .= 'Đạo diễn: <span class="badge badge-pill badge-info">'.$dir.'</span><br>';
                        }
                        $output['content_detail'] .= '<b>Thể loại :</b>';
                        foreach($resp['movie']['category'] as $cate) {
                            $output['content_detail'] .= '<p><span class="badge badge-pill badge-info">'.$cate['name'].'</span></p>';
                        }
                        $output['content_detail'] .= '<b>Diễn viên :</b>';
                        foreach($resp['movie']['actor'] as $act) {
                            $output['content_detail'] .= '<p><span class="badge badge-pill badge-info">'.$act.'</span></p>';
                        }
                        $output['content_detail'] .= '<b>Quốc gia :</b>';
                        foreach($resp['movie']['country'] as $country) {
                            $output['content_detail'] .= '<p><span class="badge badge-pill badge-info">'.$country['name'].'</span></p>';
                        }
                        $output['content_detail'] .= '
                    </div>
                </div>
            ';

            return response()->json($output); // Trả về response JSON
        }

        public function watch_leech_detail_episode(Request $request)
        {
            $slug = $request->slug;
        
            $resp = Http::get('https://ophim1.com/phim/'.$slug)->json();
            $resp_kkphim = Http::get('https://phimapi.com/phim/'.$slug)->json();
        
            $output['content_episode'] = '<h3 style="text-align: center;text-transform: uppercase;">'.$resp['movie']['name'].'</h3>';
        
            $output['content_detail_episode'] = '
                <div class="row">
                    <div class="col-md-6">
                        <h4>From ophim1.com</h4>';
                        
            foreach($resp['episodes'] as $key => $res){
                foreach($res['server_data'] as $key => $server_1)
                {
                    $output['content_detail_episode'] .= ' <p>'.$server_1['name'].'</p>
                    <p><input type="text" class="form-control" value="'.$server_1['link_embed'].'"></p>';
                }
            }
        
            $output['content_detail_episode'] .= '</div>';
        
            $output['content_detail_episode'] .= '<div class="col-md-6">
                <h4>From phimapi.com</h4>';
        
            foreach($resp_kkphim['episodes'] as $key => $res){
                foreach($res['server_data'] as $key => $server_2)
                {
                    $output['content_detail_episode'] .= ' <p>'.$server_2['name'].'</p>
                    <p><input type="text" class="form-control" value="'.$server_2['link_embed'].'"></p>';
                }
            }
        
            $output['content_detail_episode'] .= '</div>
            </div>';
        
            return response()->json($output); // Trả về response JSON
        }
        

        
        public function _leech_store_movie($slug)
        {
            $resp = Http::get("https://ophim1.com/phim/" . $slug)->json();
            $resp_movie = $resp['movie'];
            $check_movie = Movie::where('slug', $resp_movie['slug'])->count();
            
            if ($check_movie == 0) {
                $movie = new Movie();

                // Các thuộc tính cơ bản của bộ phim
                $movie->title = $resp_movie['name'];
                $movie->name_eng = $resp_movie['origin_name'];
                $movie->slug = $resp_movie['slug'];
                $movie->tags = $resp_movie['name'] . ',' . $resp_movie['slug'];
                $movie->description = strip_tags($resp_movie['content']);
                $movie->status = 1;
                $movie->season = $resp_movie['tmdb']['season'] ?? null;
                $movie->resolution = $this->getResolution($resp_movie['quality']);
                
                // Xử lý danh sách các category
                $categories = [];
                $current_year = date('Y');
                $created_year = date('Y', strtotime($resp_movie['created']['time']));
                if ($resp_movie['chieurap'] === true) {
                    $categories[] = 'phim-chieu-rap';
                } 
                if ($resp_movie['type'] == "hoathinh") {
                    $categories[] = 'phim-hoat-hinh';
                } 
                if ($resp_movie['type'] == "series") {
                    $categories[] = 'phim-bo';
                } 
                if ($current_year - $created_year <= 1) {
                    $categories[] = 'phim-moi';
                } 
                if ($resp_movie['lang'] == "Lồng tiếng") {
                    $categories[] = 'phim-thuyet-minh';
                } 
                if ($resp_movie['type'] == 'single') {
                    $categories[] = 'phim-le';
                } 

                // Các thuộc tính còn lại của bộ phim
                $movie->thuocphim = $resp_movie['type'] == 'single' ? 'phimle' : 'phimbo';
                $country_find = Country::where('slug', $resp_movie['country'][0]['slug'])->first();
                $movie->country_id = $country_find ? $country_find->id : Country::where('slug','quoc-gia-khac')->first()->id;
                $movie->phim_hot = ($current_year - $created_year <= 1) ? 1 : 0;
                $movie->views = rand(1000, 99999);
                $movie->trailer = $resp_movie['trailer_url'];
                $movie->sotap = $resp_movie['episode_total'];
                $movie->phude = ($resp_movie['lang'] == "Lồng tiếng") ? 1 : 0;
                $movie->create_at = Carbon::now('Asia/Ho_Chi_Minh');
                $movie->update_at = Carbon::now('Asia/Ho_Chi_Minh');
                $movie->thoiluong = $resp_movie['time'];
                $movie->year = $resp_movie['year'];
                $movie->actor = implode(', ', $resp_movie['actor']);
                $movie->director = implode(', ', $resp_movie['director']);

                $category_sample = Category::where('slug', $categories[0])->first();
                $movie->category_id =$category_sample->id;

                $genre = Genre::where('slug', $resp_movie['category'][0]['slug'])->first();
                $movie->genre_id = $genre ? $genre->id : null;
                $movie->image = $resp_movie['thumb_url'];
                $movie->save();

                // Attach genres
                foreach ($resp_movie['category'] as $res_cate) {
                    $genre = Genre::where('slug', $res_cate['slug'])->first();
                    if ($genre) {
                        $movie->movie_genre()->attach($genre->id);
                    }
                }

                 // Lưu các category vào cơ sở dữ liệu
                foreach ($categories as $category_slug) {
                    $category = Category::where('slug', $category_slug)->first();
                    if ($category) {
                        $movie->movie_category()->attach($category->id);
                    }
                }
            }
        }


        public function _leech_episodes($slug, $from)
        {
            $movie = Movie::where('slug', $slug)->first();
            $linkmovie_id = ($from == "KKPhim") ? 5 : 3; // Thiết lập id của linkmovie dựa trên giá trị của $from
            $linkmovie = LinkMovie::where('id', $linkmovie_id)->first();
            $resp_all = [];
        
            if ($from == "OPhim") {
                $resp_ophim = Http::get("https://ophim1.com/phim/" . $slug)->json();
                $resp_all[] = $resp_ophim;
            }
            if ($from == "KKPhim") {
                $resp_kkphim = Http::get("https://phimapi.com/phim/" . $slug)->json();
                $resp_all[] = $resp_kkphim;
            }
            $count = 0;
            $list_episode_add = '';
        
            foreach ($resp_all as $resp) {
                foreach ($resp['episodes'] as $key => $res) {
                    foreach ($res['server_data'] as $key_data => $res_data) {
                        $episode_check = Episode::where('episode', $res_data['name'])
                            ->where('movie_id', $movie->id)
                            ->where('server', $linkmovie->id)
                            ->count();
        
                        if ($episode_check == 0) {
                            $ep = new Episode();
                            $ep->movie_id = $movie->id;
                            $ep->link = '<p><iframe allowfullscreen frameborder=0 height="360" scrolling="0" src="' . $res_data['link_embed'] . '" width="100%"></iframe></p>';
                            $ep->episode = $res_data['name'];
        
                            // embed
                            $ep->server = $linkmovie->id;
                            $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                            $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                            $ep->save();
                            $count += 1;
                            $list_episode_add .= $res_data['name'] . ', ';
                        }
                    }
                }
            }

            if ($count > 0) {
                toastr()->success($count . ' tập phim của phim đã được lưu! Bao gồm: ' . $list_episode_add);
            } else {
                toastr()->error('Trùng lặp tất cả, kiểm tra lại dữ liệu!');
            }
        }
        private function getResolution($quality)
        {
            $quality = strtolower($quality);
            switch ($quality) {
                case 'hd':
                    return 0;
                case 'sd':
                    return 1;
                case 'cam':
                    return 2;
                case 'hdcam':
                    return 3;
                case 'fullhd':
                    return 4;
                case 'trailer':
                    return 5;
                default:
                    return null;
            }
        }
        public function leech_store(Request $request, $slug)
        {
            $this->_leech_store_movie($slug);
            toastr()->success('Dữ liệu đã được lưu!');
            return redirect()->back();
        }
        // thêm phim trên 1 trang.
        public function leech_store_all(Request $request)
        {
            ini_set('max_execution_time', 300); // Đặt thời gian tối đa thực thi là 300 giây (5 phút)
            $page = $request->input('page');
            
            try {
                $response = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=" . $page)->json();
            
                if (isset($response['items'])) {
                    $movies = $response['items'];
                    foreach ($movies as $movieData) {
                        $slug = $movieData['slug'];
                        
                        // Kiểm tra API và lưu phim nếu tồn tại
                        if ($this->check_API('KKPhim', $slug)) {
                            $from = 'KKPhim';
                        } elseif ($this->check_API('OPhim', $slug)) {
                            $from = 'OPhim';
                        }
                        
                        if (isset($from)) {
                            $this->_leech_store_movie($slug);
                            $this->_leech_episodes($slug, $from);
                        }
                        
                    }
                    
                    toastr()->success('Dữ liệu đã được lưu!');
                    return redirect()->back();
                } else {
                    return response()->json(['message' => 'Không tìm thấy phim hoặc định dạng phản hồi không chính xác'], 400);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
            }
        }
        // Thêm tất cả phim từ trang... đến trang ....
        public function leech_store_all_page(Request $request)
        {
               // Tăng giới hạn thời gian thực thi
            set_time_limit(600);
            ini_set('max_execution_time', 600);
            
            $pageStart = $request->input('page_start');
            $pageEnd = $request->input('page_end');
            $allMovies = [];
        
            for ($page = $pageStart; $page <= $pageEnd; $page++) {
                try {
                    $response = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=" . $page)->json();
            
                    if (isset($response['items'])) {
                        $movies = $response['items'];
                        foreach ($movies as $movieData) {
                            $slug = $movieData['slug'];
                            
                            // Kiểm tra API và lưu phim nếu tồn tại
                            if ($this->check_API('KKPhim', $slug)) {
                                $from = 'KKPhim';
                            } elseif ($this->check_API('OPhim', $slug)) {
                                $from = 'OPhim';
                            }
                            
                            if (isset($from)) {
                                $this->_leech_store_movie($slug);
                                $this->_leech_episodes($slug, $from);
                            }
                            
                        }
                        $allMovies = array_merge($allMovies, $movies);
                    } else {
                        return response()->json(['message' => 'No movies found or unexpected response format'], 400);
                    }
                } catch (\Exception $e) {
                    return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
                }
            }
        
            if (count($allMovies) > 0) {
                toastr()->success('Dữ liệu đã được lưu!');
                return redirect()->back();
            } else {
                return response()->json(['message' => 'No movies found in the specified range'], 400);
            }
        }
       public function check_API($option, $slug)
        {
            $resp = '';
            if ($option == "KKPhim") {
                $resp = Http::get("https://phimapi.com/phim/" . $slug)->json();
            } elseif ($option == "OPhim") {
                $resp = Http::get("https://ophim1.com/phim/" . $slug)->json();
            }
            
            if (!isset($resp['status']) || !$resp['status']) {
                return false;
            }
            
            if (!isset($resp['episodes']) || empty($resp['episodes'])) {
                return false;
            }
            
            foreach ($resp['episodes'] as $episode) {
                if (!isset($episode['server_data']) || empty($episode['server_data'])) {
                    return false;
                }
                
                foreach ($episode['server_data'] as $server) {
                    if (empty($server['link_embed'])) {
                        return false;
                    }
                }
            }
            
            return true;
        }

        
        // public function leech_store_all_page(Request $request)
        // {
        //     $pageStart = $request->input('page_start');
        //     $pageEnd = $request->input('page_end');
    
        //     for ($page = $pageStart; $page <= $pageEnd; $page++) {
        //         $response = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=" . $page)->json();
    
        //         if (isset($response['items'])) {
        //             $movies = $response['items'];
        //             foreach ($movies as $movieData) {
        //                 $slug = $movieData['slug'];
        //                 ProcessMovie::dispatch($slug);
        //             }
        //         }
        //     }
        //     return response()->json(['message' => 'Jobs dispatched successfully'], 200);
        // }

    
    public function leech_episode($slug){
        $resp =Http::get("https://ophim1.com/phim/".$slug)->json();
        $resp_kkphim = Http::get('https://phimapi.com/phim/'.$slug)->json();
        return view('admincp.leech.leech_episode',compact('resp','resp_kkphim'));
    }
    public function leech_episode_store(Request $request, $slug,$from)
    {
        $this->_leech_episodes($slug,$from);
            return redirect()->back();
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
