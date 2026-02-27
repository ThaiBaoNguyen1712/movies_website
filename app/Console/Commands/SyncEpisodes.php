<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncEpisodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
   // app/Console/Commands/SyncEpisodes.php
    public function handle()
    {
        // Lấy 20 phim bộ chưa hoàn thành, ưu tiên phim mới cập nhật
        $movies = Movie::whereIn('thuocphim', ['phimbo', 'hoathinh'])
            ->where(function($query) {
                $query->where('sotap', 'LIKE', '%?%')
                    ->orWhereRaw('(SELECT COUNT(DISTINCT episode) FROM episodes WHERE episodes.movie_id = movies.id) < CAST(REGEXP_REPLACE(sotap, "[^0-9]", "") AS UNSIGNED)');
            })
            ->orderBy('update_at', 'desc')
            ->take(20) 
            ->get();

        foreach ($movies as $movie) {
            $this->info("Đang kiểm tra tập mới cho: " . $movie->title);
            // Gọi lại hàm xử lý đã viết ở Controller (nên chuyển hàm này vào Movie Service hoặc Repository)
            app(\App\Http\Controllers\MovieController::class)->_leech_episodes($movie->slug, 'OPhim');
            app(\App\Http\Controllers\MovieController::class)->_leech_episodes($movie->slug, 'KKPhim');
        }
    }
}