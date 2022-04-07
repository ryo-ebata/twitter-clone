<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    /**
     * いいねしているかを判断する。
     * 
     * @param Int $user_id
     * @param Int $tweet_id
     */
    public function isFavorite(Int $user_id, Int $tweet_id)
    {
        return $this->where('user_id', $user_id)->where('tweet_id', $tweet_id)->exists();
    }

    /**
     * いいねを保存する。
     * 
     * @param Int $user_id
     * @param Int $tweet_id
     */
    public function storeFavorite(Int $user_id, Int $tweet_id)
    {
        $this->user_id = $user_id;
        $this->tweet_id = $tweet_id;
        $this->save();

        return;
    }

    /**
     * いいねを削除する。
     * 
     * @param Int $favorite_id
     */
    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }


}
