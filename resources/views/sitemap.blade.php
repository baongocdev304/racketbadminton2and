{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Trang chủ -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Danh mục vợt cầu lông chung -->
    <url>
        <loc>{{ url('/vot-cau-long.html') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Các trang tĩnh giới thiệu, chính sách, hướng dẫn -->
    <url>
        <loc>{{ url('/gioi-thieu') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('/chinh-sach-doi-tra') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('/huong-dan-mua-hang') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ url('/huong-dan-chon-vot') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/tin-tuc') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- URLs SEO từng thương hiệu -->
    @foreach($brands as $brand)
        <url>
            <loc>{{ url('/vot-cau-long-' . $brand->slug . '.html') }}</loc>
            <lastmod>{{ $brand->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Chi tiết từng cây vợt 2hand độc bản -->
    @foreach($products as $product)
        <url>
            <loc>{{ url('/vot/' . $product->slug . '.html') }}</loc>
            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    <!-- Bài viết tin tức & cẩm nang -->
    @foreach($posts as $post)
        <url>
            <loc>{{ url('/bai-viet/' . $post->slug . '.html') }}</loc>
            <lastmod>{{ ($post->published_at ?? $post->updated_at)->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach
</urlset>
