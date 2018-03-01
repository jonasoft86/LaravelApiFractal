<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Transformers\PostTransformer;
use App\Topic;
use App\Post;

class PostController extends Controller
{
    public function store(StorePostRequest $request,Topic $topic)
    {
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->posts()->save($post);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(UpdatePostRequest $request,Topic $topic,Post $post)
    {
        $this->authorize('update',$post);

        $post->body = $request->get('body',$post->body);
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(Topic $topic,Post $post)
    {
        $this->authorize('delete',$post);

        $post->delete();

        return response(null,204); 
    }
}
