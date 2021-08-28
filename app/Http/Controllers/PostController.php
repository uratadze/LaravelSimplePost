<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Psr\SimpleCache\InvalidArgumentException;

class PostController extends Controller
{
    /**
     * @var integer POSTS_PER_PAGE
     */
    const POSTS_PER_PAGE = 5;

    /**
     * @var integer COMMENTS_PER_PAGE
     */
    const COMMENTS_PER_PAGE = 2;

    /**
     * @var PostService
     */
    protected PostService $postService;

    /**
     * PostController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the posts.
     *
     * @return Application|Factory|View
     * @throws InvalidArgumentException
     */
    public function index()
    {
        $posts = $this->postService->posts();
        return view('posts')->with(['posts' => $this->postService->paginate($posts, self::POSTS_PER_PAGE)]);
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws InvalidArgumentException
     */
    public function show(int $id)
    {
        $post = $this->postService->post($id);
        $comments = $this->postService->commentsByPostId($id);
        return view('post')->with([
                'post' => $post,
                'comments' => $this->postService->paginate($comments, self::COMMENTS_PER_PAGE)
            ]);
    }

}
