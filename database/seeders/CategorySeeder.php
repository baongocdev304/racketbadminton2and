<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Vợt cầu lông',
                'slug'        => 'vot-cau-long',
                'description' => 'Các dòng vợt cầu lông cũ (2hand) chính hãng tuyển chọn từ hạng A đến C, bảo hành uy tín.',
                'image'       => '/images/categories/racket-cat.png',
                'is_active'   => true,
            ],
            [
                'name'        => 'Giày cầu lông',
                'slug'        => 'giay-cau-long',
                'description' => 'Giày cầu lông lướt chính hãng các thương hiệu Yonex, Lining, Victor, Mizuno đế bám tốt, êm chân.',
                'image'       => '/images/categories/shoes-cat.png',
                'is_active'   => true,
            ],
            [
                'name'        => 'Phụ kiện cầu lông',
                'slug'        => 'phu-kien-cau-long',
                'description' => 'Cước đan vợt, quấn cán, túi vợt, bao vợt, băng bảo vệ khớp gối cổ chân và quả cầu lông.',
                'image'       => '/images/categories/accessories-cat.png',
                'is_active'   => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
