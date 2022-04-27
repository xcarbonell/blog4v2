<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;
use App\Tag;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        /* si s'utilitza la autoritzacio des del constructor les policies no
        em funcionen correctament, en canvi si vaig autoritzant una a una
        amb $this->authorize('action', $model) si que funcionen;*/

        //$this->authorizeResource(Post::class, 'post');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();

        $post_tag = [];
        $i = 0;

        foreach ($posts as $post) {
            $post_tag[$i] = $post->tags()->get();
            $i++;
        }

        return view('posts.index', ['posts' => $posts, 'post_tag' => $post_tag]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', Post::class);

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|max:191',
            'content' => 'required|max:191',
            'tags' => 'required'
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $tags = explode(',', trim($request->get('tags')));

        foreach ($tags as $tag) {
            $t = Tag::create(['text' => $tag]);
            $post->tags()->attach($t);
        }

        $post->save();

        //redireccio al metode index perque ens torni a mostrar tots els nostres posts
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);

        //$this->authorize('view', $post);

        $comments = Comment::where('post_id', $post->id)->get();

        $tags = $post->tags()->get();

        return view('posts.show', ['post' => $post, 'comments' => $comments, 'tags' => $tags]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);

        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::find($id);

        $this->authorize('update', $post);

        $post->title = $request->get('title');
        $post->content = $request->get('content');
        $post->updated_at = now();

        $post->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $this->authorize('delete', $post);

        DB::table('post_tag')->where('post_id', '=', $id)->delete();

        Comment::where('post_id', $id)->delete();

        $post->delete();

        return redirect('posts');
    }
}
