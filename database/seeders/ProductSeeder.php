<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('slug', 'vot-cau-long')->firstOrFail();
        $brands = Brand::all();

        if ($brands->isEmpty()) {
            $this->call(BrandSeeder::class);
            $brands = Brand::all();
        }

        // Tạo 30 sản phẩm vợt cầu lông cũ trải đều cho 6 thương hiệu (mỗi hãng 5 cây vợt độc bản)
        foreach ($brands as $brand) {
            Product::factory()
                ->count(5)
                ->create([
                    'brand_id'    => $brand->id,
                    'category_id' => $category->id,
                ]);
        }
    }
}
