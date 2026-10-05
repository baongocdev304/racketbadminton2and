<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title'      => 'Săn Vợt Cầu Lông 2Hand Siêu Lướt - Tiết Kiệm Đến 50%',
                'image_path' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=1600&auto=format&fit=crop',
                'link_url'   => '/vot-cau-long.html',
                'position'   => 'home_hero',
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'title'      => 'Bộ Sưu Tập Yonex Astrox & Nanoflare Like New 99%',
                'image_path' => 'https://images.unsplash.com/photo-1613918108466-292b78a8ef95?q=80&w=1600&auto=format&fit=crop',
                'link_url'   => '/vot-cau-long-yonex.html',
                'position'   => 'home_hero',
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'title'      => 'Thanh Lý Vợt Cũ Giá Học Sinh Sinh Viên - Bao Đập Cầu Tẹt Ga',
                'image_path' => 'https://images.unsplash.com/photo-1599474924187-334a4ae5bd3c?q=80&w=1600&auto=format&fit=crop',
                'link_url'   => '/vot-cau-long.html?is_clearance=1',
                'position'   => 'home_hero',
                'sort_order' => 3,
                'is_active'  => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
