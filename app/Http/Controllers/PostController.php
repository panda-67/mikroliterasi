<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\ResearchProject;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PostController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: [
                'dashboardIndex',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ]),

            new Middleware(
                'can:viewAny,' . Post::class,
                only: ['dashboardIndex']
            ),

            new Middleware(
                'can:create,' . Post::class,
                only: ['create', 'store']
            ),

            new Middleware(
                'can:update,post',
                only: ['edit', 'update']
            ),

            new Middleware(
                'can:delete,post',
                only: ['destroy']
            ),
        ];
    }

    /**
     * Public post listing.
     */
    public function index(Request $request): View
    {
        $posts = $this->postService->getPublished();

        return view('posts.index', compact('posts'));
    }

    /**
     * Dashboard post listing.
     */
    public function dashboardIndex(): View
    {
        $posts = $this->postService->getAll();

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Dashboard create form.
     */
    public function create(): View
    {
        $post = null;

        $researchProjects = ResearchProject::query()
            ->orderBy('title')
            ->get();

        return view('dashboard.posts.create', compact('post', 'researchProjects'));
    }

    /**
     * Store a new post.
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $this->postService->create(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Public post detail.
     */
    public function show(Post $post): View
    {
        $post = $this->postService->findPublishedBySlug(
            $post->slug
        );

        return view('posts.show', compact('post'));
    }

    /**
     * Dashboard edit form.
     */
    public function edit(Post $post): View
    {
        $researchProjects = ResearchProject::query()
            ->orderBy('title')
            ->get();

        return view('dashboard.posts.edit', compact('post', 'researchProjects'));
    }

    /**
     * Update an existing post.
     */
    public function update(
        PostRequest $request,
        Post $post
    ): RedirectResponse {
        $this->postService->update(
            $post,
            $request->validated()
        );

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Delete a post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->delete($post);

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
