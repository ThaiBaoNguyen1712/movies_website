<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Movie;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Tạo đối tượng Sitemap
        $sitemap = Sitemap::create();

        // Thêm URL vào sitemap
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'));
        $sitemap->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency('monthly'));
        $sitemap->add(Url::create('/contact')->setPriority(0.8)->setChangeFrequency('monthly'));

        // Thêm URL từ cơ sở dữ liệu (ví dụ bài viết)
        $movies =Movie::all();
        foreach ($movies as $movie) {
            $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $movie->update_at);
            $sitemap->add(Url::create("/phim/{$movie->slug}")
                ->setPriority(0.9)
                ->setChangeFrequency('weekly')
                ->setLastModificationDate($updatedAt));
        }

        // Lưu sitemap vào file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
