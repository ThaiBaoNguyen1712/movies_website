<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $movieSlug;

    public function __construct($movieSlug)
    {
        $this->movieSlug = $movieSlug;
    }

    public function handle()
    {
        // Logic để lưu trữ phim
        app()->call('App\Http\Controllers\LeechMovieController@_leech_store_movie', ['slug' => $this->movieSlug]);
        app()->call('App\Http\Controllers\LeechMovieController@_leech_episodes', ['slug' => $this->movieSlug]);

        // Thêm thông báo cho người dùng (ví dụ với toastr)
       
    }
}
