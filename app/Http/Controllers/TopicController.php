<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTopicRequest;
use App\Transformers\TopicTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Topic;
use App\Post;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::latest()->first()->paginate(10);
        $topicsCollection = $topics->getCollection();

        return fractal()
            ->collection($topicsCollection)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($topics))
            ->toArray();
    }

    public function show(Topic $topic)
    {
        return fractal()
            ->item($topic)
            ->parseIncludes(['user','posts','posts.user','posts.likes'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);
        
        return fractal()
            ->item($topic)
            ->parseIncludes(['user','posts','posts.user'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    /*
    public function update(StoreTopicRequest $request)
    {
        $this->authorize('delete',$topic);

        $topic->title = $request->get('title',$topic->title);
        $topic->save();
    
        return fractal()
            ->item($topic)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }
    */

    
    public function destroy(Topic $topic)
    {
        $this->authorize('delete',$topic);
        $topic->delete();
        return response(null,204); 
    } 

    
}
