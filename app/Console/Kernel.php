<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// Quan trọng: Phải khai báo Namespace của Controller ở đây
use App\Http\Controllers\LeechMovieController;
use App\Http\Controllers\MovieController;

class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\GenerateSitemap::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        // Ghi log kiểm tra mỗi phút
        $schedule->call(function () {
            \Log::info('Cron Job đang hoạt động bình thường vào lúc: ' . now());
        })->everyMinute();

        // Quét phim mới mỗi 30 phút
        $this->autoLeechMovies($schedule);

        // Quét tập phim mới mỗi 15 phút
        $this->autoSyncEpisodes($schedule);

        // Tạo lại sitemap vào 1 giờ sáng hàng ngày
        $schedule->command('sitemap:generate')->dailyAt('01:00');
    }
    
    protected function autoLeechMovies(Schedule $schedule)
    {
        // Phải đặt name() TRƯỚC withoutOverlapping()
        $schedule->call(function () {
            $controller = app(LeechMovieController::class);
            $controller->handleLeechLogic('ophim', 1);
            $controller->handleLeechLogic('kkphim', 1);
        })
        ->name('leech_movies_job')
        ->everyThirtyMinutes()
        ->withoutOverlapping();
    }

    protected function autoSyncEpisodes(Schedule $schedule)
    {
        $schedule->call(function () {
            // Lấy danh sách phim thiếu tập và xoay tua
            $movies = app(MovieController::class)
                        ->getIncompleteMoviesQuery()
                        ->orderByRaw('update_at IS NULL DESC, update_at ASC') 
                        ->limit(24) 
                        ->get();

            $leechController = app(LeechMovieController::class);

            foreach ($movies as $movie) {
                // Gọi hàm auto chuyên dụng
                $leechController->autoSyncMovieEpisodes($movie->slug);
            }
        })
        ->name('sync_episodes_job') // Đặt tên định danh cho tiến trình
        ->everyFifteenMinutes()
        ->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}