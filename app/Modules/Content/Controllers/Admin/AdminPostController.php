<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Modules\Content\Requests\PostRequest;
use App\Modules\Content\Services\PostService;

class AdminPostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index()
    {
        $posts = $this->postService->getAllLatest();
        return view('admin.content.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.content.posts.create');
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published', true);

        $this->postService->createPost($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita/Artikel berhasil diterbitkan.');
    }

    public function edit(Post $post)
    {
        return view('admin.content.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');

        $this->postService->updatePost($post, $data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita/Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->postService->deletePost($post);
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}
