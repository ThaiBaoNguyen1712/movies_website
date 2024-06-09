<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;

    // protected $table = 'Movies_table';// Ánh xạ lại với bảng Movies_table
    use HasFactory;
    protected $fillable = [
        'title',
        'name_eng',
        'slug',
        'tags',
        'description',
        'status',
        'season',
        'resolution',
        'category_id',
        'thuocphim',
        'country_id',
        'phim_hot',
        'views',
        'trailer',
        'sotap',
        'phude',
        'create_at',
        'update_at',
        'thoiluong',
        'year',
        'actor',
        'director',
        'genre_id',
        'image',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class,'genre_id');
    }
    public function movie_genre()
    {
        return $this->belongsToMany(Genre::class,'movie_genre','movie_id','genre_id');

    }
    public function movie_category()
    {
        return $this->belongsToMany(Category::class,'movie_category','movie_id','category_id');

    }
    public function episode()
    {
        return $this->hasMany(Episode::class);
    }
    
}
