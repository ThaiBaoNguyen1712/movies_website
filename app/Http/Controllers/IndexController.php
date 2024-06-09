<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Movie_Category;
use App\Models\TruyCap;

use App\Models\Information;
use App\Models\LinkMovie;

use DB;


class IndexController extends Controller
{
    public function timkiem(Request $request)
    {
        if(isset($_GET['search']))
        {
            $search=$_GET['search'];
      
        $movie= Movie::where('title','LIKE','%'.$search.'%')->orderBy('update_at','DESC')->paginate(40);
            }
            else{
                return redirect()->to('/');
            }
        return view('Movies.search', compact('search','movie'));
        
    }
    public function home()
    {
        $truycap = TruyCap::find(1);

        if ($truycap) {
            $truycap->access += 1;
        } else {
            $truycap = new TruyCap();
            $truycap->access = 1;
        }
        
        $truycap->save();
        
        $category_home=Category::with('movie_category.movie')->orderBy('position','ASC')->where('status',1)->get();
        
        return view('Movies.home', compact('category_home'));
    }
    public function category($slug)
    {
        $cate_slug = Category::where('slug',$slug)->first();
        $movie= Movie::where('category_id', $cate_slug->id)->paginate(40);
        $movie_category=Movie_Category::where('category_id',$cate_slug->id)->get();
        $many_category=[];
        foreach($movie_category as $key=>$mov)
        {
            $many_category[]=$mov->movie_id;
        }
        $movie = Movie::whereIn('id', $many_category)->orderBy('update_at','DESC')->paginate(40);
        return view('Movies.category', compact('cate_slug','movie'));
    }
    public function filter()
    {

        $movie= Movie::paginate(40);

        return view('Movies.filter', compact('movie'));
    }
    public function locphim(Request $request)
    {
        $sort = $request->input('sort');
        $genre_ids = $request->input('genre'); // Có thể là mảng hoặc giá trị đơn
        $country_id = $request->input('country');
        $year = $request->input('year');
        
        // Kiểm tra xem tất cả các tham số có trống không
        if (!$sort && !$genre_ids && !$country_id && !$year) {
            return redirect()->back();
        } else {
            // Tạo truy vấn phim
            $query = Movie::withCount('episode')->where('status', 1);
            
            // Thêm các điều kiện vào truy vấn nếu có giá trị
            if ($genre_ids) {
                $query->whereHas('movie_genre', function($q) use ($genre_ids) {
                    if (is_array($genre_ids)) {
                        $q->whereIn('genre_id', $genre_ids);
                    } else {
                        $q->where('genre_id', $genre_ids);
                    }
                });
            }
            if ($country_id) {
                $query->where('country_id', $country_id);
            }
            if ($year) {
                $query->where('year', $year);
            }
            if ($sort) {
                if ($sort == 'views') {
                    $query->orderBy('views', 'DESC');
                } elseif ($sort == 'title') {
                    $query->orderBy('title', 'ASC');
                } elseif ($sort == 'date') {
                    $query->orderBy('update_at', 'DESC');
                } elseif ($sort == 'year') {
                    $query->orderBy('year', 'DESC');
                } else {
                    $query->orderBy('update_at', 'DESC');
                }
            }
            // Lấy kết quả phân trang
            $movie = $query->paginate(40);
            
            // Trả về view với các biến cần thiết
            return view('Movies.filter', compact('movie'));
        }
    }
    

    
    public function genre($slug)
    {

        $gen_slug = Genre::where('slug',$slug)->first();
        //nhieu the loai
        $movie_genre=Movie_Genre::where('genre_id',$gen_slug->id)->get();
        $many_genre=[];
        foreach($movie_genre as $key=>$mov)
        {
            $many_genre[]=$mov->movie_id;
        }
        $movie = Movie::whereIn('id', $many_genre)->orderBy('update_at','DESC')->paginate(40);
        return view('Movies.genre', compact('gen_slug','movie'));
    }
    public function country($slug)
    {
     
        $con_slug = Country::where('slug',$slug)->first();
        $movie= Movie::with('genre','country','category')->where('country_id', $con_slug->id)->paginate(40);
        return view('Movies.country', compact('con_slug','movie'));
    }
    public function movie($slug)
    {   

        $movie = Movie::with('category','genre','movie_genre')->where('slug',$slug)->where('status',1)->first();
        $movie_related = Movie::where('status',1)->where('category_id',$movie->category->id)
        ->orderBy(DB::raw('RAND()'))->whereNotIn('slug',[$slug])->take(15)->get();
 
        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(3)->get();
        $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->take(1)->first();
       
        $episode_current_list=Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->get();
        $episode_current_list_count=$episode_current_list->count();

        //tăng views
        $movie->views += 1;
        $movie->save();
        return view('Movies.movie',compact('movie','movie_related',
        'episode','episode_tapdau','episode_current_list_count'));

    }
    public function year($year)
    {
        $year=$year;
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('update_at','DESC')->take('20')->get();

        $movie= Movie::with('genre','country','category')->where('year', $year)->paginate(40);
        return view('Movies.year', compact('year','movie','phim_hot_sidebar'));
    }
    
    public function watch($slug, $tap = null, $server_active = null)
    {
        $movie = Movie::with('category', 'genre', 'movie_genre','movie_category', 'episode')
                      ->where('slug', $slug)
                      ->where('status', 1)
                      ->first();
    
        $movie_related = Movie::where('status', 1)
                              ->where('category_id', $movie->category->id)
                              ->orderBy(DB::raw('RAND()'))
                              ->whereNotIn('slug', [$slug])
                              ->take(15)
                              ->get();
    
        if (isset($tap)) {
            $tapphim = substr($tap, strpos($tap, 'tap-') + 4);
            if (($slashPos = strpos($tapphim, '/')) !== false) {
                $tapphim = substr($tapphim, 0, $slashPos);
            }
        } else {
            $tapphim = 1;
        }
    
        if (isset($server_active)) {
            $server_id = intval(substr($server_active, strpos($server_active, 'server-') + 7));
        } else {
            $server_id = null;
        }
    
        if ($server_id) {
            $episode = Episode::where('movie_id', $movie->id)
                              ->where('episode', $tapphim)
                              ->where('server', $server_id)
                              ->first();
        } else {
            $episode = Episode::where('movie_id', $movie->id)
                              ->where('episode', $tapphim)
                              ->first();
        }
    
        $server = LinkMovie::orderBy('id', 'DESC')->get();
        $episode_movie = Episode::where('movie_id', $movie->id)
                                ->orderBy('episode', 'DESC')
                                ->get()
                                ->unique('server');
        $episode_list = Episode::where('movie_id', $movie->id)
                               ->orderByRaw('CAST(episode AS UNSIGNED) ASC')
                               ->get();
        
        return view('Movies.watch', compact('movie', 'movie_related', 'episode', 'tapphim', 'server', 'episode_movie', 'episode_list', 'server_active'));
    }
    
    
    public function episode()
    {
        return view('Movies.episode');
    }
    public function tag($tag)
    {
       
        $tag=$tag;
        $phim_hot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('update_at','DESC')->take('20')->get();

        $movie= Movie::with('genre','country','category')->where('tags','LIKE','%'.$tag.'%')->orderBy('update_at','DESC')->paginate(40);
        return view('Movies.tag', compact('tag','movie','phim_hot_sidebar'));
    }
}
