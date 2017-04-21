<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function latestNews()
    {
    	return Post::published()
		    		->orderBy('created_at', 'desc')
		    		->skip(0)
                    ->take(10)
                    ->get();
    }

    public function news()
    {
    	return Post::orderBy('created_at', 'desc')
		    		->paginate(10);
    }

    public function create(Request $request)
    {
    	auth()->user()->posts()->create([
    		'title' => $request->title,
    		'content' => $request->content,
    		'published' => $request->published,
    		'published_date' => $request->published ? Carbon::now() : null,
    	]);
    }

    public function update(Request $request)
    {
    	$post = Post::find($request->id);

    	$post->title = $request->title;
    	$post->content = $request->content;
    	$post->published_date = ($request->published != $post->published && $request->published) ? Carbon::now() : null;    	
    	$post->published = $request->published;
    	$post->save();
    }

    public function getById($id)
    {
        return Post::find($id);
    }

    public function get()
    {
        return Post::published()
                    ->orderBy('created_at', 'desc')
                    ->paginate(1000);
    }
}
