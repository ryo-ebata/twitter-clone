<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Comment;
use App\Models\Follower;
use App\Http\Requests\TweetValidates\PostRequest;

class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Tweet::classに各データを渡す。
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tweet $tweet, Follower $follower)
    {
        $user = auth()->user();
        $follow_ids = $follower->followingIds($user->id);
        /* followed_idだけ抜き出す */
        $following_ids = $follow_ids->pluck('followed_id')->toArray();

        $timelines = $tweet->getTimelines($user->id, $following_ids);

        return view('tweets.index', [
            'user'      => $user,
            'timelines' => $timelines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * 新規投稿画面を返す。
     * 
     * @return \Illuminate\Http\Response
     * 
     */
    public function create()
    {
        $user = auth()->user();

        return view('tweets.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * ツイートのバリデーション。
     * 140字以内の文字列データを tweetStore() で保存する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Tweet $tweet)
    {
        $user_id = auth()->id();
        $data = $request->all();
        $tweet->storeTweet($user_id, $data);

        return redirect('tweets');
    }

    /**
     * Display the specified resource.
     * 投稿一覧画面を返すメソッド。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet, Comment $comment)
    {
        $user = auth()->user();
        $tweet = $tweet->getTweet($tweet->id);
        $comments = $comment->getComments($tweet->id);

        return view('tweets.show', [
            'user'     => $user,
            'tweet' => $tweet,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 投稿編集画面を返すメソッド。
     *
     * @param Tweet $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        $user = auth()->user();
        $tweets = $tweet->getTweetEditing($user->id, $tweet->id);

        if(!isset($tweets)){
            return redirect('tweets');
        }

        return view('tweets.edit', [
            'user'  => $user,
            'tweets' => $tweets
        ]);
    }

    /**
     * Update the specified resource in storage.
     * 投稿編集用のバリデーション。
     * 140字以内の文字データを tweetUpdate() で保存する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Tweet $tweet)
    {
        $data = $request->all();
        $tweet->updateTweet($tweet->id, $data);
        return redirect('tweets');
    }

    /**
     * Remove the specified resource from storage.
     * 投稿削除用のメソッド。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $user_id = auth()->id();
        $tweet->destroyTweet($user_id, $tweet->id);

        return back();
    }
}
