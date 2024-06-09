<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie_Genre;
use App\Models\Episode;
use App\Models\Movie_Category;

use Carbon\Carbon;
use File;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category','movie_genre','movie_category','country','genre')->withCount('episode')->orderBy('id','Desc')->get();
        
        $path=public_path()."/json_file/";
        if(!is_dir($path))
        {
            mkdir($path,077,true);
        }
        File::put($path.'movies.json',json_encode($list));
        return view('admincp.movie.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Category::pluck('title','id');
        $country=country::pluck('title','id');
        $genre=Genre::pluck('title','id');
        $list_genre=Genre::all();
        $list_category=Category::all();
        $list = Movie::with('category','genre','country')->orderBy('id','Desc')->get();
        
        return view('admincp.movie.form',compact('list','list_category','category','country','genre','list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $movie = new Movie();
        $movie->title= $data['title'];
        $movie->name_eng= $data['name_eng'];
        $movie->slug=$data['slug'];
        $movie->tags=$data['tags'];
        $movie->description=$data['description'];
        $movie->status=$data['status'];
        $movie->resolution=$data['resolution'];
        $movie->thuocphim=$data['thuocphim'];
        foreach($data['genre'] as $key =>$gen)
        {
            $movie->genre_id=$gen[0];
        }
        foreach($data['category'] as $key =>$cate)
        {
            $movie->category_id=$cate[0];
        }
        // $movie->genre_id=$data['genre_id'];
        $movie->country_id=$data['country_id'];
        $movie->phim_hot=$data['phim_hot'];
        $movie->trailer=$data['trailer'];
        $movie->sotap=$data['sotap'];
        $movie->phude=$data['phude'];
        $movie->create_at=Carbon::now('Asia/Ho_Chi_Minh');
        $movie->update_at=Carbon::now('Asia/Ho_Chi_Minh');
        $movie->thoiluong = $data['thoiluong'];
        $movie->views=rand(1000,99999);
        $movie->actor = $data['actor'];
        $movie->director = $data['director'];

        //add image
        $get_image = $request->file('image');

            if($get_image)
            {
                $get_name_image =$get_image->getClientOriginalName(); //hinhanh1.png
                $name_image = current(explode('.',$get_name_image)); // [0] hinhanh1 . [1] png
                $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();//hinhanh123.png
                $get_image->move('uploads/movies/',$new_image);
                $data['product_image']=$new_image;
                $movie->image = $new_image;
            }
            else
            {
                $movie->image='';
            }
        $movie->save();
        //Them nhieu the loai phim
        toastr()->success('Dữ liệu đã được lưu!');
        $movie->movie_genre()->attach($data['genre']);
        $movie->movie_category()->attach($data['category']);
        return redirect()->route('movie.index');

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
        $category=Category::pluck('title','id');
        $country=country::pluck('title','id');
        $genre=Genre::pluck('title','id');
        $list_genre=Genre::all();
        $list_category= Category::all();
        $movie=Movie::find($id);
        $movie_genre= $movie->movie_genre;
        $movie_category= $movie->movie_category;

        $list = Movie::with('category','genre','country')->orderBy('id','Desc')->get();
     
        return view('admincp.movie.form',compact('list','category','country','genre','movie','list_genre','list_category','movie_genre','movie_category'));
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
       
        $data=$request->all();
        $movie = Movie::find($id);
        $movie->title= $data['title'];
        $movie->name_eng= $data['name_eng'];
        $movie->slug=$data['slug'];
        $movie->tags=$data['tags'];
        $movie->description=$data['description'];
        $movie->status=$data['status'];
        $movie->resolution=$data['resolution'];
        // $movie->category_id=$data['category'][0];
        $movie->thuocphim=$data['thuocphim'];
        foreach($data['genre'] as $key =>$gen)
        {
            $movie->genre_id=$gen[0];
        }
        foreach($data['category'] as $key =>$cate)
        {
            $movie->category_id=$cate[0];
        }
        $movie->country_id=$data['country_id'];
        $movie->phim_hot=$data['phim_hot'];
        $movie->trailer=$data['trailer'];
        $movie->sotap=$data['sotap'];
        $movie->phude=$data['phude'];
        $movie->update_at=Carbon::now('Asia/Ho_Chi_Minh');
        $movie->thoiluong = $data['thoiluong'];
        // $movie->views=rand(1000,99999);

        //add image
        $get_image = $request->file('image');

        if($get_image){
            if(!empty($movie->image)){
                unlink('uploads/movie/'.$movie->image);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movie/',$new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //sử dụng đồng bộ để tránh việc lặp lại các thể loại trùng nhau
        $movie->movie_genre()->sync($data['genre']);
        $movie->movie_category()->sync($data['category']);

        toastr()->success('Dữ liệu đã được lưu!');

        return redirect()->route('movie.index');

    }


    // Handle UPDATE API
public function update_movie_api($slug)
{
    try {
        $resp = Http::get("https://ophim1.com/phim/" . $slug)->json();
        $resp_movie = $resp['movie'];

        // Use updateOrCreate to update existing records or create a new one
        $movie = Movie::updateOrCreate(
            ['slug' => $resp_movie['slug']],
            [
                'title' => $resp_movie['name'],
                'name_eng' => $resp_movie['origin_name'],
                'tags' => $resp_movie['name'] . ',' . $resp_movie['slug'],
                'description' => strip_tags($resp_movie['content']),
                'status' => 1,
                'season' => $resp_movie['tmdb']['season'] ?? null,
                'resolution' => $this->getResolution($resp_movie['quality']),
                'thuocphim' => $resp_movie['type'] == 'single' ? 'phimle' : 'phimbo',
                'country_id' => $this->getCountryId($resp_movie['country'][0]['slug']),
                'phim_hot' => $this->isPhimHot($resp_movie['created']['time']),
                'views' => rand(1000, 99999),
                'trailer' => $resp_movie['trailer_url'],
                'sotap' => $resp_movie['episode_total'],
                'phude' => $resp_movie['lang'] == "Lồng tiếng" ? 1 : 0,
                'update_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'thoiluong' => $resp_movie['time'],
                'year' => $resp_movie['year'],
                'actor' => implode(', ', $resp_movie['actor']),
                'director' => implode(', ', $resp_movie['director']),
                'image' => $resp_movie['thumb_url']
            ]
        );

        // Attach genres
        $movie->genres()->sync([]);
        foreach ($resp_movie['category'] as $res_cate) {
            $genre = Genre::where('slug', $res_cate['slug'])->first();
            if ($genre) {
                $movie->genres()->attach($genre->id);
            }
        }

        // Attach categories
        $movie->categories()->sync([]);
        $current_year = date('Y');
        $created_year = date('Y', strtotime($resp_movie['created']['time']));
        $categories = [];

        if ($resp_movie['chieurap'] === true) {
            $category = Category::where('slug', 'phim-chieu-rap')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }
        if ($resp_movie['type'] == "hoathinh") {
            $category = Category::where('slug', 'phim-hoat-hinh')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }
        if ($resp_movie['type'] == "series") {
            $category = Category::where('slug', 'phim-bo')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }
        if ($current_year - $created_year <= 1) {
            $category = Category::where('slug', 'phim-moi')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }
        if ($resp_movie['lang'] == "Lồng tiếng") {
            $category = Category::where('slug', 'phim-thuyet-minh')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }
        if ($resp_movie['type'] == 'single') {
            $category = Category::where('slug', 'phim-le')->first();
            if ($category) {
                $categories[] = $category->id;
            }
        }

        // Sync categories to the movie
        $movie->categories()->sync($categories);

        toastr()->success('Dữ liệu đã được lưu!');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->error('Đã có lỗi, vui lòng kiểm tra lại dữ liệu!');
        return redirect()->back();
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

private function getCountryId($country_slug)
{
    $country = Country::where('slug', $country_slug)->first();
    return $country ? $country->id : Country::where('slug', 'quoc-gia-khac')->first()->id;
}

private function isPhimHot($created_time)
{
    $current_year = date('Y');
    $created_year = date('Y', strtotime($created_time));
    return ($current_year - $created_year <= 1) ? 1 : 0;
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie= Movie::find($id);
        //xoa anh
        if(file_exists('uploads/movies/'.$movie->image) && !empty($movie->image))
        {
             unlink('uploads/movies/'.$movie->image);
        }
        //xoa the loai

        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();
        //Xoa Tap phim
        Episode::whereIn('movie_id',[$movie->id])->delete();
        toastr()->success('Dữ liệu đã được lưu!');

       $movie->delete();
       return redirect()->back();
    }
    public function update_year(Request $request){
        $data= $request->all();
        $movie=Movie::find($data['id_phim']);
        $movie->year=$data['year'];
        $movie->save();

    }
    public function update_topview(Request $request){
        $data= $request->all();
        $movie=Movie::find($data['id_phim']);
        $movie->topview=$data['topview'];
        $movie->save();

    }
    public function update_season(Request $request){
        $data= $request->all();
        $movie=Movie::find($data['id_phim']);
        $movie->season=$data['season'];
        $movie->save();


    }
    public function filter_topview(Request $request)
    {
        $data = $request->all();
        
        // Kiểm tra dữ liệu từ request
        if (isset($data['value'])) {
            $movies = Movie::where('topview', $data['value'])
                            ->orderBy('update_at', 'DESC') // Updated to 'updated_at' which is the correct field
                            ->take(20)
                            ->get();
            $output = '';
            foreach ($movies as $key => $mov) {
                // Xử lý thông tin về độ phân giải
                if ($mov->resolution == 0) {
                    $text = 'HD';
                } elseif ($mov->resolution == 1) { 
                    $text = 'SD';
                } elseif ($mov->resolution == 2) {
                    $text = 'HDCam';
                } elseif ($mov->resolution == 3) { // Fixed duplicate conditions
                    $text = 'Cam';
                } elseif ($mov->resolution == 4) { // Fixed duplicate conditions
                    $text = 'FullHD';
                } else {
                    $text = "Trailer";
                }
                // Tạo HTML cho mỗi bộ phim
                $output .= '<div class="item post-37176'.$mov->id.'">
                <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                    <div class="item-link">';
        
                    $image_check = substr($mov->image, 0, 5);   
                    if ($image_check == 'https') {
                        $output .= '<img src="'.url($mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />';
                    } else {
                        $output .= '<img src="'.url('uploads/movies/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />';
                    }
                    
                    $output .= '<span class="is_trailer">'.$text.'</span>
                                </div>
                                <p class="title">'.$mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">'.$mov->views.' lượt quan tâm </div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;">
                                    <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>';
            }
            echo $output;
        } else {
            echo "Dữ liệu không hợp lệ";
        }
    }
    
    public function watch_video(Request $request)
    {
        $data= $request->all();
        $movie= Movie::find($data['movie_id']);
        $video = Episode::where('movie_id',$data['movie_id'])->where('episode',$data['episode_id'])->first();

        $output['video_title']=$movie->title.'- tập '.$video->episode;
        $output['video_desc']=$movie->description;
        $output['video_link']=$video->link;
        echo json_encode($output);
    }
                
}
