<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruyCap extends Model
{
    protected $table = 'truycap';
    public $timestamps =false;
    protected $primaryKey = 'id';
    protected $fillable = ['access'];
    use HasFactory;
}
