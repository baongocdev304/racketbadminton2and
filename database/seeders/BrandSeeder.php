<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name'        => 'Yonex',
                'slug'        => 'yonex',
                'description' => 'Thương hiệu cầu lông số 1 thế giới đến từ Nhật Bản, nổi tiếng với các dòng Astrox, Nanoflare, Arcsaber.',
                'logo'        => '/images/brands/yonex.png',
                'website'     => 'https://www.yonex.com',
                'is_active'   => true,
            ],
            [
                'name'        => 'Victor',
                'slug'        => 'victor',
                'description' => 'Thương hiệu hàng đầu Đài Loan, bảo trợ cho nhiều vận động viên thế giới với các dòng Thruster, Auraspeed, DriveX.',
                'logo'        => '/images/brands/victor.png',
                'website'     => 'https://www.victorsport.com',
                'is_active'   => true,
            ],
            [
                'name'        => 'Lining',
                'slug'        => 'lining',
                'description' => 'Thương hiệu thể thao quyền lực Trung Quốc, nổi bật với thiết kế hầm hố, đầm tay như Axforce, Halbertec, Tectonic.',
                'logo'        => '/images/brands/lining.png',
                'website'     => 'https://www.lining.com',
                'is_active'   => true,
            ],
            [
                'name'        => 'Mizuno',
                'slug'        => 'mizuno',
                'description' => 'Đỉnh cao cơ khí chính xác Nhật Bản, nước sơn cao cấp và công nghệ khung vợt Fortius, Altius, JPX.',
                'logo'        => '/images/brands/mizuno.png',
                'website'     => 'https://mizuno.com',
                'is_active'   => true,
            ],
            [
                'name'        => 'Apacs',
                'slug'        => 'apacs',
                'description' => 'Thương hiệu quốc dân đến từ Malaysia, độ bền cực cao, chịu lực căng lớn, giá thành vô cùng hợp lý.',
                'logo'        => '/images/brands/apacs.png',
                'website'     => 'https://apacssports.com',
                'is_active'   => true,
            ],
            [
                'name'        => 'VS',
                'slug'        => 'vs',
                'description' => 'Thương hiệu vợt quốc dân VenSon (VS), nổi danh với các dòng vợt giá rẻ siêu bền bỉ cho người mới và phong trào.',
                'logo'        => '/images/brands/vs.png',
                'website'     => 'https://vssport.com',
                'is_active'   => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                $brand
            );
        }
    }
}
