<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Post;
use App\Topic;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, Topic $topic)
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

    /**
     * Update the specified resource in storage.
     *
     * @param StorePostRequest $request
     * @param Topic $topic
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Topic $topic
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic, Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();

        return response('done', 204);
    }
}
