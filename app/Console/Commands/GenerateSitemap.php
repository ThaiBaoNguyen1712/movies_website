<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use Illuminate\Support\Facades\Log;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Tối ưu Sitemap cho SEO và hiệu suất hệ thống';

    public function handle()
    {
        try {
            $sitemap = Sitemap::create();

            // 1. Trang chủ (Route name: homepage)
            $sitemap->add(Url::create(route('homepage'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

            // 2. Danh mục (Route name: category - danh-muc/{slug})
            \App\Models\Category::all()->each(function ($item) use ($sitemap) {
                $sitemap->add(Url::create(route('category', $item->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency('daily'));
            });

            // 3. Thể loại (Route name: genre - the-loai/{slug})
            \App\Models\Genre::all()->each(function ($item) use ($sitemap) {
                $sitemap->add(Url::create(route('genre', $item->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency('daily'));
            });

            // 4. Quốc gia (Route name: country - quoc-gia/{slug})
            \App\Models\Country::all()->each(function ($item) use ($sitemap) {
                $sitemap->add(Url::create(route('country', $item->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency('daily'));
            });

            // 5. Trang Phim (Route name: movie - phim/{slug})
            // Sử dụng chunk(200) để không bị sập RAM khi dữ liệu lớn
            Movie::select('slug', 'update_at')
                ->where('status', 1)
                ->orderBy('update_at', 'desc')
                ->chunk(200, function ($movies) use ($sitemap) {
                    foreach ($movies as $movie) {
                        $sitemap->add(Url::create(route('movie', $movie->slug))
                            ->setPriority(0.9)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_HOURLY)
                          ->setLastModificationDate(\Carbon\Carbon::parse($movie->update_at)));
                    }
                });

            // 6. Lưu file
            $sitemap->writeToFile(public_path('sitemap.xml'));

            // 7. Ping Google
            $this->pingGoogle();

            $this->info('Sitemap generated successfully with correct Route Mapping!');

        } catch (\Exception $e) {
            \Log::error('Sitemap Error: ' . $e->getMessage());
            $this->error('Check logs for details.');
        }
    }

    // Mẹo SEO: Thông báo cho Google Bot vào quét ngay khi có sitemap mới
    protected function pingGoogle()
    {
        $sitemapUrl = url('/sitemap.xml');
        $pingUrl = "https://www.google.com/ping?sitemap=" . urlencode($sitemapUrl);
        
        try {
            file_get_contents($pingUrl);
        } catch (\Exception $e) {
            // Nếu không ping được cũng không sao, Google sẽ tự quét sau
        }
    }
}