<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $posts = BlogPost::query()
            ->published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->cursorPaginate(9);

        $featuredPost = BlogPost::query()
            ->published()
            ->featured()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->first();

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('blog.partials.post-cards', [
                    'posts' => $posts,
                ])->render(),
                'next_url' => $posts->nextPageUrl(),
            ]);
        }

        return view('blog.index', [
            'featuredPost' => $featuredPost,
            'posts' => $posts,
        ])->with('body_class', 'page-interior page-blog');
    }

    public function show(BlogPost $blogPost): View
    {
        abort_unless($blogPost->isPublished(), 404);

        return view('blog.show', [
            'attachments' => $blogPost->attachmentItems(),
            'blogPost' => $blogPost,
        ])->with('body_class', 'page-interior page-blog');
    }
}
