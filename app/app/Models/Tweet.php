<?php

namespace App\Models;

use App\Consts\paginateConsts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tweet extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    /**
     * User::classのデータを参照。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 一つの投稿に対して、複数のfavoriteのリレーション。
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * 一つの投稿に対して、複数のコメントのリレーション。
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * $user_idと一致する'user_id'の投稿を新着順で1ページ50件表示。
     * 
     * @param Int $user_id
     */
    public function getUserTimeLine(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(paginateConsts::displayTweets);
    }

    /**
     * ＄user_idと一致する'user_id'の投稿数をカウントする。
     * 
     * @param Int $user_id
     * 
     * @return Int
     */
    public function getTweetCount(Int $user_id): int
    {
        return $this->where('user_id', $user_id)->count();
    }

    /**
     * $follow_ids[]内のデータと一致する'user_id'の投稿を取得し、新着順で1ページ50件表示。
     * フォローしているアカウントと自身の投稿のみを表示する。
     * 
     * @param Int $user_id
     * @param Array $follow_ids
     */
    public function getTimeLines(Int $user_id, Array $follow_ids)
    {
        $follow_ids[] = $user_id;
        return $this->whereIn('user_id', $follow_ids)->orderBy('created_at', 'DESC')->paginate(paginateConsts::displayTweets);
    }

    /**
     * ツイートを取得するメソッド。
     * 'user'内の $tweet_id と一致する 'id' の投稿を取得。
     * 
     * @param Int $tweet_id
     */
    public function getTweet(Int $tweet_id)
    {
        return $this->with('user')->where('id', $tweet_id)->first();
    }

    /**
     * ツイートを保存する機能。
     * 
     * @param Int $user_id
     * @param Array $data
     */
    public function storeTweet(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->text = $data['text'];
        $this->save();

        return;
    }

    /**
     * ツイート編集用のデータを取得する。
     * 'user_id' と 'tweet_id' の一致する投稿を取得する。
     * 
     * @param Int $user_id
     * @param Int $tweet_id
     */
    public function getTweetEditing(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->first();
    }

    /**
     * ツイート編集後の保存用メソッド。
     * 
     * @param Int $tweet_id
     * @param Array $data
     */
    public function updateTweet(Int $tweet_id, Array $data)
    {
        $this->id = $tweet_id;
        $this->text = $data['text'];
        $this->update();

        return;
    }

    /**
     * ツイート削除用のメソッド。
     * 'user_id' と 'tweet_id' の一致する投稿を取得し、 delete()で削除する。
     * 
     * @param Int $user_id
     * @param Int $tweet_id
     */
    public function destroyTweet(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('id', $tweet_id)->delete();
    }
}
