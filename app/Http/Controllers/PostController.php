<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Danh sách bài viết tin tức & cẩm nang cầu lông
     */
    public function index(): View
    {
        $posts = Post::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(9);

        $featuredPost = Post::published()
            ->with('author')
            ->latest('published_at')
            ->first();

        return view('posts.index', compact('posts', 'featuredPost'));
    }

    /**
     * Chi tiết bài viết tin tức & kiến thức
     */
    public function show(string $slug): View
    {
        $post = Post::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->with('author')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
