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
        $page = $request->input('page', 1); // Mặc định là trang 1 nếu trống
        $site = $request->input('site');

        // Chọn URL dựa trên site
        if($site == 'kkphim'){
            $url = "https://phimapi.com/danh-sach/phim-moi-cap-nhat?page=";
        } else {
            // Mặc định là ophim nếu không chọn hoặc chọn ophim
            $url = "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=";
        }

        try {
            $resp = Http::timeout(10)->get($url . $page)->json();
        } catch (\Exception $e) {
            return response()->html("<tr><td colspan='100%'>Lỗi kết nối đến API nguồn</td></tr>");
        }

        // Trả về partial view (chỉ chứa danh sách các dòng tr)
        return view('admincp.leech.movie-list', compact('resp', 'page', 'site'));
    }
    
    public function leech_detail($slug, $site = 'ophim'){
        $url = ($site == 'kkphim') ? "https://phimapi.com/phim/".$slug : "https://ophim1.com/phim/".$slug;
        $resp =Http::get($url)->json();
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
        // 1. Thử lấy từ OPhim trước, nếu không có hoặc lỗi thì thử KKPhim (phimapi.com)
        $resp = Http::get("https://ophim1.com/phim/" . $slug)->json();
        
        // Nếu OPhim không có phim này (status false), thử sang KKPhim
        if(!isset($resp['status']) || $resp['status'] == false) {
            $resp = Http::get("https://phimapi.com/phim/" . $slug)->json();
        }

        // Nếu vẫn không có dữ liệu thì thoát
        if(!isset($resp['movie'])) return;

        $resp_movie = $resp['movie'];
        $check_movie = Movie::where('slug', $resp_movie['slug'])->count();
        
        if ($check_movie == 0) {
            $movie = new Movie();

            // Thuộc tính cơ bản
            $movie->title = $resp_movie['name'];
            $movie->name_eng = $resp_movie['origin_name'];
            $movie->slug = $resp_movie['slug'];
            $movie->tags = $resp_movie['name'] . ',' . $resp_movie['slug'];
            $movie->description = strip_tags($resp_movie['content']);
            $movie->status = 1;
            $movie->season = $resp_movie['tmdb']['season'] ?? null;
            
            // Cần đảm bảo hàm getResolution tồn tại trong Controller
            $movie->resolution = method_exists($this, 'getResolution') ? $this->getResolution($resp_movie['quality']) : 0;
            
            // Xử lý danh sách các category (Logic của bạn)
            $categories = [];
            $current_year = date('Y');
            // Fix lỗi nếu trường created không tồn tại
            $created_time = $resp_movie['created']['time'] ?? now();
            $created_year = date('Y', strtotime($created_time));

            if (($resp_movie['chieurap'] ?? false) === true) $categories[] = 'phim-chieu-rap';
            if ($resp_movie['type'] == "hoathinh") $categories[] = 'phim-hoat-hinh';
            if ($resp_movie['type'] == "series") $categories[] = 'phim-bo';
            if ($current_year - $created_year <= 1) $categories[] = 'phim-moi';
            if (($resp_movie['lang'] ?? '') == "Lồng tiếng") $categories[] = 'phim-thuyet-minh';
            if ($resp_movie['type'] == 'single') $categories[] = 'phim-le';

            $movie->thuocphim = $resp_movie['type'] == 'single' ? 'phimle' : 'phimbo';
            
            // Quốc gia
            $country_slug = $resp_movie['country'][0]['slug'] ?? 'quoc-gia-khac';
            $country_find = Country::where('slug', $country_slug)->first();
            $movie->country_id = $country_find ? $country_find->id : (Country::where('slug','quoc-gia-khac')->first()->id ?? 1);
            
            $movie->phim_hot = ($current_year - $created_year <= 1) ? 1 : 0;
            $movie->views = rand(1000, 99999);
            $movie->trailer = $resp_movie['trailer_url'] ?? '';
            $movie->sotap = $resp_movie['episode_total'] ?? 1;
            $movie->phude = (($resp_movie['lang'] ?? '') == "Lồng tiếng") ? 1 : 0;
            $movie->thoiluong = $resp_movie['time'] ?? '';
            $movie->year = $resp_movie['year'] ?? $current_year;
            
            // Xử lý Actor & Director (Phòng trường hợp API trả về mảng trống)
            $movie->actor = is_array($resp_movie['actor']) ? implode(', ', $resp_movie['actor']) : '';
            $movie->director = is_array($resp_movie['director']) ? implode(', ', $resp_movie['director']) : '';
            
            // Category & Genre mặc định
            if(!empty($categories)) {
                $cat = Category::where('slug', $categories[0])->first();
                $movie->category_id = $cat ? $cat->id : 1;
            } else {
                $movie->category_id = 1; 
            }

            $genre_slug = $resp_movie['category'][0]['slug'] ?? 'phim-moi';
            $genre = Genre::where('slug', $genre_slug)->first();
            $movie->genre_id = $genre ? $genre->id : null;

            // XỬ LÝ ẢNH (Quan trọng nhất)
            // Nếu đã có http (KKPhim) thì giữ nguyên, nếu không thì tự thêm domain OPhim
            $thumb = $resp_movie['thumb_url'];
            $movie->image = (strpos($thumb, 'http') !== false) ? $thumb : "https://img.ophim.tv/uploads/movies/" . $thumb;

            $movie->save();

            // Attach genres
            if(isset($resp_movie['category'])) {
                foreach ($resp_movie['category'] as $res_cate) {
                    $genre = Genre::where('slug', $res_cate['slug'])->first();
                    if ($genre) $movie->movie_genre()->attach($genre->id);
                }
            }

            // Attach categories
            foreach ($categories as $category_slug) {
                $category = Category::where('slug', $category_slug)->first();
                if ($category) $movie->movie_category()->attach($category->id);
            }
            
            // Sau khi lưu xong, cập nhật file JSON để search client không bị thiếu phim mới
            if(method_exists($this, 'updateMovieJson')) {
                $this->updateMovieJson();
            }
        }
    }


            public function _leech_episodes($slug, $from)
        {
            $movie = Movie::where('slug', $slug)->first();
            if (!$movie) return;

            $linkmovie_id = ($from == "KKPhim") ? 5 : 3;
            $linkmovie = LinkMovie::find($linkmovie_id);

            $url = ($from == "KKPhim") ? "https://phimapi.com/phim/" : "https://ophim1.com/phim/";
            $response = Http::get($url . $slug)->json();

            $count = 0;
            $list_episode_add = '';

            if (isset($response['episodes'])) {
                foreach ($response['episodes'] as $server) {
                    foreach ($server['server_data'] as $res_data) {
                        
                        // --- BƯỚC CHUẨN HÓA TRIỆT ĐỂ ---
                        $tap_raw = $res_data['name']; // Ví dụ: "Tập 01", "01", "1"
                        
                        // 1. Xóa chữ "Tập", "tập", dấu cách, dấu gạch ngang... chỉ giữ lại số
                        $tap_clean = preg_replace('/[^0-9]/', '', $tap_raw); 

                        // 2. Ép kiểu về số nguyên để mất số 0 ở đầu (01 -> 1)
                        $tap_phim = (int)$tap_clean; 

                        // Trường hợp đặc biệt: Nếu API trả về chữ "Full" (không có số), preg_replace sẽ ra rỗng
                        // Nếu rỗng thì ta giữ nguyên tên gốc của API (ví dụ "Full")
                        if($tap_clean === '') {
                            $tap_phim = $res_data['name'];
                        }

                        // Kiểm tra trùng lặp
                        $episode_check = Episode::where('movie_id', $movie->id)
                            ->where('episode', $tap_phim)
                            ->where('server', $linkmovie->id)
                            ->exists();

                        if (!$episode_check) {
                            $ep = new Episode();
                            $ep->movie_id = $movie->id;
                            $ep->link = '<p><iframe allowfullscreen frameborder=0 height="360" scrolling="0" src="' . $res_data['link_embed'] . '" width="100%"></iframe></p>';
                            $ep->episode = $tap_phim; // Lưu số sạch 1, 2, 3...
                            $ep->server = $linkmovie_id;
                            $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                            $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                            $ep->save();

                            $movie->update(['update_at' => Carbon::now('Asia/Ho_Chi_Minh')]);
                            $count++;
                            $list_episode_add .= $tap_phim . ', ';
                        }
                    }
                }
            }

            if ($count > 0) {
                toastr()->success($count . ' tập mới đã thêm: ' . rtrim($list_episode_add, ', '));
            } else {
                toastr()->info('Không có tập mới.');
            }
        }

      public function autoSyncMovieEpisodes($slug)
        {
            $movie = Movie::where('slug', $slug)->first();
            if (!$movie) return;

            $sources = [
                'KKPhim' => ['url' => "https://phimapi.com/phim/", 'id' => 5],
                'OPhim'  => ['url' => "https://ophim1.com/phim/", 'id' => 3]
            ];

            $total_added = 0;

            foreach ($sources as $sourceName => $config) {
                if (!$this->check_API($sourceName, $slug)) {
                    continue; 
                }

                try {
                    $response = Http::get($config['url'] . $slug)->json();
                    
                    if (isset($response['episodes'])) {
                        foreach ($response['episodes'] as $server) {
                            foreach ($server['server_data'] as $res_data) {
                                
                                $tap_raw = $res_data['name'];
                                $tap_clean = preg_replace('/[^0-9]/', '', $tap_raw); 
                                $tap_phim = ($tap_clean === '') ? $tap_raw : (int)$tap_clean;

                                $exists = Episode::where('movie_id', $movie->id)
                                    ->where('episode', $tap_phim)
                                    ->where('server', $config['id'])
                                    ->exists();

                                if (!$exists) {
                                    $ep = new Episode();
                                    $ep->movie_id = $movie->id;
                                    $ep->link = '<p><iframe allowfullscreen frameborder=0 height="360" scrolling="0" src="' . $res_data['link_embed'] . '" width="100%"></iframe></p>';
                                    $ep->episode = $tap_phim;
                                    $ep->server = $config['id'];
                                    $ep->created_at = Carbon::now('Asia/Ho_Chi_Minh');
                                    $ep->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                                    $ep->save();

                                    $total_added++;
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error("AutoSync Error [$sourceName] for $slug: " . $e->getMessage());
                }
            }

            // --- SỬA CHỖ NÀY ---
            // Luôn luôn cập nhật update_at để đẩy phim xuống cuối hàng đợi xoay tua
            $movie->update(['update_at' => Carbon::now('Asia/Ho_Chi_Minh')]);

            if ($total_added > 0) {
                \Log::info("AutoSync: Đã thêm $total_added tập mới cho phim: $slug");
            } else {
                // Tùy chọn: Log để biết Cron vẫn đang kiểm tra phim này nhưng chưa có tập
                // \Log::info("AutoSync: Kiểm tra $slug - Không có tập mới.");
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
       public function leech_store_all(Request $request)
        {
            // 1. Tăng thời gian thực thi (leech cả trang tốn khá nhiều request)
            ini_set('max_execution_time', 600); // Tăng lên 10 phút cho chắc
            $page = $request->input('page', 1);
            $site = $request->input('site', 'ophim'); // Lấy site từ request để biết đang leech trang của ai

            try {
                // 2. Xác định URL danh sách dựa trên site người dùng đang chọn
                $url = ($site == 'kkphim') 
                    ? "https://phimapi.com/danh-sach/phim-moi-cap-nhat?page=" 
                    : "https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=";

                $response = Http::get($url . $page)->json();
                
                // Chuẩn hóa items (vì OPhim bọc trong ['data']['items'])
                $movies = $response['items'] ?? ($response['data']['items'] ?? null);

                if ($movies && is_array($movies)) {
                    $successCount = 0;
                    $errorMessages = [];

                    foreach ($movies as $movieData) {
                        try {
                            $slug = $movieData['slug'] ?? null;
                            if (!$slug) continue;

                            // 3. Gọi hàm store đơn lẻ đã sửa ở bước trước (hàm này đã tự check site)
                            $this->_leech_store_movie($slug);
                            
                            // Giả sử hàm _leech_episodes của bạn cần nguồn để biết tải từ đâu
                            // Nếu bạn chưa sửa _leech_episodes, hãy đảm bảo nó cũng check được 2 nguồn
                            $this->_leech_episodes($slug, $site); 
                            
                            $successCount++;
                        } catch (\Exception $e) {
                            $errorMessages[] = "Lỗi phim {$slug}: " . $e->getMessage();
                            continue;
                        }
                    }

                    // 4. FIX LỖI GHI FILE JSON (Quan trọng)
                    if ($successCount > 0) {
                        // Định nghĩa lại $list trước khi ghi file
                        $list = Movie::with('category', 'country')->withCount('episode')->orderBy('id', 'Desc')->get();
                        
                        $path = public_path() . "/json_file/";
                        if (!is_dir($path)) {
                            mkdir($path, 0777, true);
                        }
                        File::put($path . 'movies.json', json_encode($list));

                        toastr()->success("Đã lưu thành công {$successCount} phim!");
                    }

                    if (!empty($errorMessages)) {
                        \Log::error("Lỗi leech_store_all: " . implode('; ', $errorMessages));
                        toastr()->warning("Có " . count($errorMessages) . " phim gặp lỗi.");
                    }

                    return redirect()->back();
                } else {
                    toastr()->error('Không tìm thấy danh sách phim.');
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                \Log::error("Lỗi hệ thống leech: " . $e->getMessage());
                toastr()->error('Lỗi: ' . $e->getMessage());
                return redirect()->back();
            }
        }
        // Thêm tất cả phim từ trang... đến trang ....
        // public function leech_store_all_page(Request $request)
        // {
        //        // Tăng giới hạn thời gian thực thi
        //     set_time_limit(600);
        //     ini_set('max_execution_time', 600);
            
        //     $pageStart = $request->input('page_start');
        //     $pageEnd = $request->input('page_end');
        //     $allMovies = [];
        
        //     for ($page = $pageStart; $page <= $pageEnd; $page++) {
        //         try {
        //             $response = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=" . $page)->json();
            
        //             if (isset($response['items'])) {
        //                 $movies = $response['items'];
        //                 foreach ($movies as $movieData) {
        //                     $slug = $movieData['slug'];
                            
        //                     // Kiểm tra API và lưu phim nếu tồn tại
        //                     if ($this->check_API('KKPhim', $slug)) {
        //                         $from = 'KKPhim';
        //                     } elseif ($this->check_API('OPhim', $slug)) {
        //                         $from = 'OPhim';
        //                     }
                            
        //                     if (isset($from)) {
        //                         $this->_leech_store_movie($slug);
        //                         $this->_leech_episodes($slug, $from);
        //                     }
                            
        //                 }
        //                 $allMovies = array_merge($allMovies, $movies);
        //             } else {
        //                 return response()->json(['message' => 'No movies found or unexpected response format'], 400);
        //             }
        //         } catch (\Exception $e) {
        //             //return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        //         }
        //     }
        
        //     if (count($allMovies) > 0) {
        //         toastr()->success('Dữ liệu đã được lưu!');
        //         return redirect()->back();
        //     } else {
        //         return response()->json(['message' => 'No movies found in the specified range'], 400);
        //     }
        // }
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