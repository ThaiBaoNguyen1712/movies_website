<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Information;
use App\Models\TruyCap;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $info = Information::first();
        $phim_hot = Movie::where('phim_hot', 1)->where('status', 1)->orderBy('year','DESC')->orderBy('update_at', 'DESC')->take(15)->get();
        $phim_hot_sidebar = Movie::where('phim_hot', 1)
        ->where('status', 1)
        ->inRandomOrder() // Lấy ngẫu nhiên
        ->take(15)
        ->get();
    
        // $phim_hot_trailer = Movie::where('resolution', 5)->where('status', 1)->orderBy('update_at', 'DESC')->take(10)->get();

        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('id', 'ASC')->where('status', 1)->get();
        $country = Country::orderBy('id', 'ASC')->where('status', 1)->get();
        $access = TruyCap::value('access');

        $category_total =Category::all()->count();
        $genre_total =Genre::all()->count();
        $country_total =Country::all()->count();
        $movie_total=Movie::all()->count();
        View::share([
            'info' => $info,
            'phim_hot' => $phim_hot,
            'phim_hot_sidebar' => $phim_hot_sidebar,
            // 'phim_hot_trailer' => $phim_hot_trailer,
            'category_home' => $category,
            'genre_home' => $genre,
            'country_home' => $country,

            //admin
            'category_total'=>$category_total,
            'genre_total'=>$genre_total,
            'country_total'=>$country_total,
            'movie_total'=>$movie_total,
            'access'=>$access
        ]);
    }
}
