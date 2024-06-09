<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;

//Controllers Admin
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\GenreController;

use App\Http\Controllers\MovieController;

use App\Http\Controllers\EpisodeController;

use App\Http\Controllers\CountryController;

use App\Http\Controllers\InformationController;

use App\Http\Controllers\LinkMovieController;

use App\Http\Controllers\LeechMovieController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[IndexController::class,'home'])->name('homepage');

Route::get('/danh-muc/{slug}',[IndexController::class,'category'])->name('category');
Route::get('/the-loai/{slug}',[IndexController::class,'genre'])->name('genre');

Route::get('/quoc-gia/{slug}',[IndexController::class,'country'])->name('country');

Route::get('/phim/{slug}',[IndexController::class,'movie'])->name('movie');

Route::get('/xem-phim/{slug}/{tap}/{server_active}',[IndexController::class,'watch'])->name('watch');

Route::get('/so-tap',[IndexController::class,'episode'])->name('so-tap');

Route::get('loc-phim',[IndexController::class,'filter'])->name('loc-phim');
Route::get('locphim',[IndexController::class,'locphim'])->name('locphim');

Auth::routes();
Route::get('/home',[HomeController::class,'index'])->name('home');
Route::get('/tim-kiem',[IndexController::class,'timkiem'])->name('tim-kiem');
//route admin
Route::resource('category',CategoryController::class);
Route::post('resorting-category', [CategoryController::class, 'resorting'])->name('resorting.category');
Route::post('resorting-genre', [GenreController::class, 'resorting'])->name('resorting.genre');
Route::post('resorting-country', [CountryController::class, 'resorting'])->name('resorting.country');


Route::resource('info',InformationController::class);
Route::resource('genre',GenreController::class);
Route::resource('country',CountryController::class);
Route::resource('movie',MovieController::class);
Route::resource('episode',EpisodeController::class);
Route::resource('linkmovie',LinkMovieController::class);


Route::get('select-movie',[EpisodeController::class,'select_movie'])->name('select-movie');
Route::get('add-episode/{id}',[EpisodeController::class,'add_episode'])->name('add-episode');

Route::get('/nam/{year}',[IndexController::class,'year'])->name('year');
Route::get('/tag/{tag}',[IndexController::class,'tag']);
Route::get('/update-year-phim',[MovieController::class,'update_year']);
Route::get('/update-topview-phim',[MovieController::class,'update_topview']);
Route::get('/filter-topview',[MovieController::class,'filter_topview']);
Route::get('/update_season',[MovieController::class,'update_season']);
Route::get('/update_movie_api{slug}',[MovieController::class,'update_movie_api'])->name('update_movie_api');

Route::post('watch-video', [MovieController::class,'watch_video'])->name('watch-video');

//leech movie
Route::get('leech-movie',[LeechMovieController::class,'leech_movie'])->name('leech-movie');
Route::get('leech-movie-select',[LeechMovieController::class,'leech_movie_select'])->name('leech-movie-select');
Route::get('leech-store-all',[LeechMovieController::class,'leech_store_all'])->name('leech-store-all');
Route::get('leech-store-all-page',[LeechMovieController::class,'leech_store_all_page'])->name('leech-store-all-page');


Route::post('watch-leech-detail',[LeechMovieController::class,'watch_leech_detail'])->name('watch-leech-detail');
Route::post('watch-leech-detail-episode',[LeechMovieController::class,'watch_leech_detail_episode'])->name('watch-leech-detail-episode');

Route::get('leech-detail/{slug}',[LeechMovieController::class,'leech_detail'])->name('leech-detail');
Route::get('leech-episode/{slug}',[LeechMovieController::class,'leech_episode'])->name('leech-episode');
Route::post('leech-store/{slug}',[LeechMovieController::class,'leech_store'])->name('leech-store');
Route::post('leech-episode-store/{slug}/{from}',[LeechMovieController::class,'leech_episode_store'])->name('leech-episode-store');



Route::get('/create_sitemap', function () {
    Artisan::call('generate:sitemap');
    return redirect()->back()->with('status', 'Sitemap updated successfully!');
})->name('create_sitemap');
