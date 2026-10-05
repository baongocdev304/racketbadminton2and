<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $posts = [
            [
                'title'        => 'Kinh nghiệm chọn mua vợt cầu lông cũ (2hand) không bị lừa hàn nhiệt',
                'slug'         => 'kinh-nghiem-chon-mua-vot-cau-long-cu-2hand',
                'thumbnail'    => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=800&auto=format&fit=crop',
                'summary'      => 'Bỏ túi 5 mẹo soi vết nứt ngầm, kiểm tra chụp mũ, mã số khắc laser trên cán và cách nhận biết vợt đã qua hàn carbon nhiệt.',
                'content'      => '<p>Mua vợt cầu lông cũ là giải pháp thông minh giúp người chơi tiết kiệm 40% - 60% chi phí so với mua mới. Tuy nhiên, nếu không có kiến thức kiểm tra, bạn rất dễ mua phải vợt nứt ngầm hoặc hàn nhiệt...</p><p><strong>1. Soi kỹ vành khung dưới ánh sáng mạnh:</strong> Vợt hàn nhiệt thường có vết sơn dặm lại không đồng nhất, độ dày khung tại vị trí hàn sẽ gồ lên bất thường.</p><p><strong>2. Gõ nhẹ khung để nghe tiếng vang:</strong> Vợt nguyên bản khi gõ nhẹ sẽ phát ra âm thanh đanh gọn, không bị rè hoặc tịt âm.</p><p><strong>3. Kiểm tra độ sụt lún gen:</strong> Các vị trí 12h, 2h, 10h là nơi chịu lực căng lớn nhất, gen bị lún sâu vào carbon là dấu hiệu vợt đã căng quá số kg khuyến nghị.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title'        => 'Top 5 cây vợt công thủ toàn diện cũ đáng mua nhất tầm giá 1 đến 2 triệu',
                'slug'         => 'top-5-cay-vot-cong-thu-toan-dien-cu-dang-mua-nhat',
                'thumbnail'    => 'https://images.unsplash.com/photo-1613918108466-292b78a8ef95?q=80&w=800&auto=format&fit=crop',
                'summary'      => 'Đánh giá chi tiết các dòng vợt quốc dân như Arcsaber 11 cũ, Victor Auraspeed 90K, Lining Halbertec 8000 đã qua sử dụng.',
                'content'      => '<p>Với ngân sách từ 1 đến 2 triệu đồng, thay vì mua những dòng vợt sơ cấp mới, việc chọn một cây vợt cận cao cấp hoặc cao cấp lướt sẽ mang lại trải nghiệm thi đấu vượt trội...</p><p>Danh sách đề xuất hàng đầu gồm có Yonex Arcsaber Series, Lining Tectonic và Victor Brave Sword 12 trứ danh.</p>',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title'        => 'Ý nghĩa thông số 3U, 4U, G5 và điểm cân bằng trên vợt cầu lông',
                'slug'         => 'y-nghia-thong-so-3u-4u-g5-diem-can-bang',
                'thumbnail'    => 'https://images.unsplash.com/photo-1599474924187-334a4ae5bd3c?q=80&w=800&auto=format&fit=crop',
                'summary'      => 'Hiểu rõ các thông số kỹ thuật cốt lõi giúp bạn chọn đúng cây vợt phù hợp với lực cổ tay và lối chơi của bản thân.',
                'content'      => '<p>U biểu thị trọng lượng thân vợt: 3U (85-89g) đòi hỏi lực tay tốt, 4U (80-84g) phổ biến và dễ chơi nhất cho phong trào. G biểu thị chu vi tay cầm, phổ biến nhất tại Việt Nam là cán G5...</p>',
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, ['user_id' => $admin?->id ?? 1])
            );
        }
    }
}
