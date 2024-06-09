<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie_Category extends Model
{
    protected $table = 'movie_category';
    public $timestamps =false;
    use HasFactory;

    //để có thể lồng movie_category.movie -> lấy các thuộc tính của movie khi sử dụng movie_category
    public function movie()
    {
        return $this->belongsTo(Movie::class,'movie_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
