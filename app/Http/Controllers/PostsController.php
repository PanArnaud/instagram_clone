<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
    
        $posts = Post::whereIn('user_id', $users)->with('user')->withCount('comments')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'another' => '',
            'caption' =>'required',
            'image' => 'required|image',
        ]);
        
        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect("/profile/" . auth()->user()->id);
    }

    public function show(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->with('user')->get();
        $follows = (auth()->user()) ? auth()->user()->following->contains($post->user->id) : false;
        return view('posts.show', compact('post', 'follows', 'comments'));
    }

    public function addComment(Post $post)
    {
        $data = request()->validate([
            'content' =>'required',
        ]);

        auth()->user()->comments()->create([
            'content' => $data['content'],
            'post_id' => $post->id,
        ]);

        return redirect()->back();
    }

    public function deleteComment(Post $post, Comment $comment)
    {
        if (auth()->user()->id == $comment->user_id) {
            $comment->delete();
        }

        return redirect()->back();
    }
}
