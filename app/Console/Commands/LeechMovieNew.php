<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LeechMovieNew extends Command
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
   // app/Console/Commands/LeechMovieNew.php
    public function handle()
    {
        $sources = [
            'OPhim' => 'https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1',
            'KKPhim' => 'https://phimapi.com/danh-sach/phim-moi-cap-nhat?page=1'
        ];

        foreach ($sources as $name => $url) {
            $response = Http::get($url)->json();
            if (isset($response['items'])) {
                foreach ($response['items'] as $item) {
                    // Kiểm tra nếu phim chưa tồn tại theo slug
                    $exists = Movie::where('slug', $item['slug'])->exists();
                    if (!$exists) {
                        // Logic tạo Movie mới (bạn có thể gọi hàm Leech chi tiết ở đây)
                        $this->info("Đang thêm phim mới: " . $item['name']);
                        // Ví dụ: $this->leechDetail($item['slug'], $name);
                    }
                }
            }
        }
    }
}
