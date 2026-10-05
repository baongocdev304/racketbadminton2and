<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Dữ liệu danh sách vợt thực tế theo từng thương hiệu
     */
    protected static array $racketCatalogue = [
        'Yonex' => [
            ['name' => 'Vợt Cầu Lông Yonex Astrox 88D Pro Gen 3 2024', 'balance' => 'Nặng đầu (~305mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4500000, 'price' => 3250000],
            ['name' => 'Vợt Cầu Lông Yonex Astrox 100ZZ Kurenai', 'balance' => 'Nặng đầu (~310mm)', 'flex' => 'Siêu cứng (Extra Stiff)', 'orig_price' => 4850000, 'price' => 3600000],
            ['name' => 'Vợt Cầu Lông Yonex Nanoflare 1000Z', 'balance' => 'Hơi nặng đầu (~298mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4600000, 'price' => 3350000],
            ['name' => 'Vợt Cầu Lông Yonex Nanoflare 800 Pro', 'balance' => 'Cân bằng (~293mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4400000, 'price' => 3100000],
            ['name' => 'Vợt Cầu Lông Yonex Arcsaber 11 Pro', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Cứng vừa (Medium Stiff)', 'orig_price' => 4550000, 'price' => 3400000],
            ['name' => 'Vợt Cầu Lông Yonex Astrox 77 Pro', 'balance' => 'Hơi nặng đầu (~300mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 4200000, 'price' => 2950000],
            ['name' => 'Vợt Cầu Lông Yonex Duora 10 LT', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 3900000, 'price' => 2450000],
        ],
        'Victor' => [
            ['name' => 'Vợt Cầu Lông Victor Thruster Ryuga II Pro', 'balance' => 'Nặng đầu (~308mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4200000, 'price' => 2850000],
            ['name' => 'Vợt Cầu Lông Victor Thruster Ryuga Metallic', 'balance' => 'Nặng đầu (~312mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4600000, 'price' => 3300000],
            ['name' => 'Vợt Cầu Lông Victor Auraspeed 90K II', 'balance' => 'Hơi nặng đầu (~298mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4100000, 'price' => 2700000],
            ['name' => 'Vợt Cầu Lông Victor Auraspeed 100X', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Cứng vừa (Medium Stiff)', 'orig_price' => 4300000, 'price' => 2900000],
            ['name' => 'Vợt Cầu Lông Victor Brave Sword 12 SE (Kỷ Niệm)', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 3800000, 'price' => 2550000],
            ['name' => 'Vợt Cầu Lông Victor DriveX 10 Metallic', 'balance' => 'Hơi nặng đầu (~300mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4200000, 'price' => 2800000],
        ],
        'Lining' => [
            ['name' => 'Vợt Cầu Lông Lining Axforce 90 Max Đỏ (Rồng)', 'balance' => 'Nặng đầu (~308mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4950000, 'price' => 3650000],
            ['name' => 'Vợt Cầu Lông Lining Axforce 100 Kỵ Sĩ Kim Tự Tháp', 'balance' => 'Nặng đầu (~310mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 5200000, 'price' => 3900000],
            ['name' => 'Vợt Cầu Lông Lining Halbertec 8000', 'balance' => 'Cân bằng (~298mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 4400000, 'price' => 3150000],
            ['name' => 'Vợt Cầu Lông Lining Halbertec 9000', 'balance' => 'Hơi nặng đầu (~302mm)', 'flex' => 'Cứng vừa (Medium Stiff)', 'orig_price' => 5100000, 'price' => 3850000],
            ['name' => 'Vợt Cầu Lông Lining Tectonic 9', 'balance' => 'Nặng đầu (~305mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4300000, 'price' => 2950000],
            ['name' => 'Vợt Cầu Lông Lining Aeronaut 9000C', 'balance' => 'Nặng đầu (~306mm)', 'flex' => 'Cứng vừa (Medium Stiff)', 'orig_price' => 4600000, 'price' => 3100000],
        ],
        'Mizuno' => [
            ['name' => 'Vợt Cầu Lông Mizuno Fortius 11 Quick', 'balance' => 'Cân bằng hơi nặng đầu (~300mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4600000, 'price' => 2950000],
            ['name' => 'Vợt Cầu Lông Mizuno Fortius 11 Power', 'balance' => 'Nặng đầu (~308mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 4700000, 'price' => 3100000],
            ['name' => 'Vợt Cầu Lông Mizuno Altius 01 Feel', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 4200000, 'price' => 2600000],
            ['name' => 'Vợt Cầu Lông Mizuno JPX 8.1', 'balance' => 'Hơi nặng đầu (~298mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 3100000, 'price' => 1950000],
        ],
        'Apacs' => [
            ['name' => 'Vợt Cầu Lông Apacs Tantrum 200 II', 'balance' => 'Cân bằng (~290mm)', 'flex' => 'Cứng (Stiff)', 'orig_price' => 1750000, 'price' => 1150000],
            ['name' => 'Vợt Cầu Lông Apacs Z-Ziggler', 'balance' => 'Nặng đầu (~300mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 1450000, 'price' => 950000],
            ['name' => 'Vợt Cầu Lông Apacs Commander 80', 'balance' => 'Cân bằng (~293mm)', 'flex' => 'Dẻo (Flexible)', 'orig_price' => 1500000, 'price' => 980000],
            ['name' => 'Vợt Cầu Lông Apacs Nano 900 Power', 'balance' => 'Hơi nặng đầu (~295mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 1600000, 'price' => 1050000],
        ],
        'VS' => [
            ['name' => 'Vợt Cầu Lông VS Titan 1000', 'balance' => 'Nặng đầu (~305mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 1250000, 'price' => 790000],
            ['name' => 'Vợt Cầu Lông VS Blade 7200', 'balance' => 'Cân bằng (~295mm)', 'flex' => 'Dẻo (Flexible)', 'orig_price' => 1100000, 'price' => 690000],
            ['name' => 'Vợt Cầu Lông VS Kirin 80', 'balance' => 'Nặng đầu (~302mm)', 'flex' => 'Trung bình (Medium)', 'orig_price' => 1350000, 'price' => 880000],
            ['name' => 'Vợt Cầu Lông VS YouLong (Rồng Xanh)', 'balance' => 'Nặng đầu (~305mm)', 'flex' => 'Cứng vừa (Medium Stiff)', 'orig_price' => 1950000, 'price' => 1350000],
        ],
    ];

    /**
     * Ghi chú tình trạng thực tế của vợt cũ (2hand)
     */
    protected static array $conditionNotes = [
        'A' => [
            'Cây vợt siêu lướt 98-99%, đánh thử 2-3 set, không một vết xước dù là nhỏ nhất. Đã căng sẵn cước Yonex BG65Ti 10.5kg.',
            'Ngoại hình 97%, nước sơn bóng loáng, chưa từng đấu kiếm, gen zin 100% nguyên bản chưa sụt lún.',
            'Vợt like new 96%, chủ cũ chỉ cất túi sơ cua, tem phân phối chính hãng còn nguyên seal cán cầm.',
            'Tình trạng 98%, phôi vợt liền khối nguyên thủy, cam kết không nứt hàn, cước Aerobite mới đan tuần trước.',
        ],
        'B' => [
            'Ngoại hình 90%, có 2 vết xước dăm nhỏ ở góc 11h do vớt cầu trên sân thảm, khung carbon bao chắc chắn đan 11kg thoải mái.',
            'Vợt 92%, tróc sơn nhẹ tại vị trí 2h và 7h, không ảnh hưởng kết cấu khung. Tặng kèm quấn cán VS mới.',
            'Tình trạng 88%, xước sơn viền đầu vợt do va chạm cầu lông, gen đã đảo đều, cước BG80 Power nảy tốt.',
            'Ngoại hình 93%, thân vợt đẹp keng, chỉ trầy decal vành mép ngoài, cầm đánh đầm tay và thoát cầu.',
        ],
        'C' => [
            'Vợt 82%, có vài vết tróc sơn rõ ở vành khung do cọ sát sân, phôi carbon nguyên zin tuyệt đối chưa hàn nhiệt, căng tối đa 10.5kg.',
            'Ngoại hình 85%, nhiều vết xước chiến đấu qua thời gian, thích hợp cho anh em học sinh sinh viên trải nghiệm dòng cao cấp giá rẻ.',
            'Tình trạng 80%, tróc sơn viền đầu nhưng kết cấu đũa và cán cầm hoàn hảo, đã thay bộ gen chống sụt lún bảo vệ cước.',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();
        $category = Category::where('slug', 'vot-cau-long')->first() ?? Category::first() ?? Category::factory()->create();

        $brandName = $brand->name;
        $catalogueList = self::$racketCatalogue[$brandName] ?? self::$racketCatalogue['Yonex'];
        $racketData = $this->faker->randomElement($catalogueList);

        $grade = $this->faker->randomElement(['A', 'A', 'B', 'B', 'B', 'C']);
        $percent = match ($grade) {
            'A' => $this->faker->numberBetween(95, 99),
            'B' => $this->faker->numberBetween(88, 94),
            'C' => $this->faker->numberBetween(80, 87),
        };

        $note = $this->faker->randomElement(self::$conditionNotes[$grade]);
        $weight = $this->faker->randomElement(['3U', '4U', '4U', '5U']);
        $grip = $this->faker->randomElement(['G5', 'G5', 'G6']);
        $maxTension = $this->faker->randomElement([27, 28, 29, 30]);
        $year = $this->faker->numberBetween(2022, 2025);

        // Biến tấu giá nhẹ dựa trên % tình trạng thực tế của cây vợt cụ thể
        $ratio = $percent / 100.0;
        $calculatedPrice = (int) (round(($racketData['price'] * $ratio) / 10000) * 10000);
        $originalPrice = $racketData['orig_price'];

        $uniqueCode = strtoupper(Str::random(5));
        $sku = '2H-' . strtoupper(substr($brandName, 0, 3)) . '-' . $uniqueCode;
        $slug = Str::slug($racketData['name']) . '-' . strtolower($uniqueCode);

        // Phân bổ trạng thái: 75% available, 15% sold, 10% reserved
        $status = $this->faker->randomElement([
            'available', 'available', 'available', 'available',
            'available', 'available', 'available', 'reserved',
            'sold', 'sold',
        ]);

        $isClearance = ($grade === 'C' || $this->faker->boolean(15));

        return [
            'brand_id'          => $brand->id,
            'category_id'       => $category->id,
            'name'              => $racketData['name'],
            'slug'              => $slug,
            'sku'               => $sku,
            'condition_grade'   => $grade,
            'condition_percent' => $percent,
            'condition_note'    => $note,
            'weight_class'      => $weight,
            'grip_size'         => $grip,
            'balance'           => $racketData['balance'],
            'flex'              => $racketData['flex'],
            'max_tension_lbs'   => $maxTension,
            'year'              => $year,
            'price'             => $calculatedPrice,
            'original_price'    => $originalPrice,
            'is_clearance'      => $isClearance,
            'status'            => $status,
            'description'       => "<p>Cây vợt <strong>{$racketData['name']}</strong> mã định danh <code>{$sku}</code> là hàng 2hand nguyên bản chính hãng do shop tuyển chọn kỹ càng.</p><p><strong>Đặc điểm nổi bật:</strong> Khung vợt ứng dụng công nghệ trợ lực và vật liệu Graphite cao cấp. Vợt đã qua quy trình kiểm định cân chỉnh khung và kiểm tra nứt ngầm trước khi mở bán.</p><p><strong>Chính sách bảo hành:</strong> Bao đổi trả hoặc đền tiền 200% nếu phát hiện vợt hàn nhiệt hoặc hàng giả.</p>",
            'specifications'    => [
                'Trọng lượng'     => "{$weight} (khoảng 80-88g)",
                'Chu vi cán vợt'  => $grip,
                'Điểm cân bằng'   => $racketData['balance'],
                'Độ cứng đũa vợt' => $racketData['flex'],
                'Sức căng tối đa' => "{$maxTension} LBS (~13.5kg)",
                'Năm sản xuất'    => (string) $year,
                'Phân hạng hàng'  => "Hạng {$grade} ({$percent}%)",
            ],
        ];
    }

    /**
     * Sau khi tạo sản phẩm, tự động tạo 3-4 ảnh thực tế đi kèm
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $brandSlug = Str::slug($product->brand->name ?? 'yonex');

            // Danh sách các góc chụp ảnh vợt thật (mặt vợt, khung, cán cầm, chụp mũ)
            $angles = [
                ['label' => 'Toàn cảnh thân vợt', 'suffix' => 'full'],
                ['label' => 'Cận cảnh khung và nước sơn', 'suffix' => 'frame'],
                ['label' => 'Cận cảnh chụp cán và tem Sunrise', 'suffix' => 'cone'],
                ['label' => 'Góc chụp tay cầm và quấn cán', 'suffix' => 'grip'],
            ];

            foreach ($angles as $index => $angle) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => "/images/products/{$brandSlug}-sample-{$angle['suffix']}.webp",
                    'alt_text'   => "{$product->name} ({$angle['label']}) - Hàng 2hand mã {$product->sku}",
                    'is_primary' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        });
    }
}
