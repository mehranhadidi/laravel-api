<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Post;
use App\Http\Requests\StoreTopicRequest;
use App\Transformers\TopicTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // fetch topics
        $topics = Topic::latestFirst()->paginate(3);

        // create a collection from it
        $topicsCollection = $topics->getCollection();

        return fractal()
            ->collection($topicsCollection) // transform only topics collection
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($topics)) // paginate the query result based on laravel pagination meta data
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopicRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        // Create topic
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        // Create post
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return fractal()
            ->item($topic)
            ->parseIncludes(['user'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        return fractal()
            ->item($topic)
            ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
            ->transformWith(new TopicTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTopicRequest $request, Topic $topic)
    {
        // Authorize user
        $this->authorize('update', $topic);

        $topic->title = $request->get('title', $topic->title);
        $topic->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Topic $topic
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Topic $topic)
    {
        // Authorize user
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }
}
