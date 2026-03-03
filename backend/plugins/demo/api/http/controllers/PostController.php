<?php namespace Demo\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Demo\Api\Models\Post;

/**
 * PostController — clean Laravel API controller
 * No CMS. No Twig. Just JSON responses.
 */
class PostController
{
    public function index(): JsonResponse
    {
        $posts = Post::published()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($p) => $p->toApiArray());

        return response()->json([
            'data' => $posts,
            'total' => $posts->count(),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'data' => $post->toApiArray(),
        ]);
    }
}
