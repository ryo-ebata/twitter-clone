<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $primaryKey = [
        'following_id',
        'followed_id'
    ];
    protected $fillable = [
        'following_id',
        'followed_id'
    ];
    public $timestamps = false;
    public $incrementing = false;

    /**
     * フォローしているユーザー数を取得する。
     * 
     * @param mixed $user_id
     * 
     * @return Int
     */
    public function getFollowCount($user_id): int
    {
        return $this->where('following_id', $user_id)->count();
    }

    /**
     * フォロワー数を取得する。
     * 
     * @param mixed $user_id
     * 
     * @return Int
     */
    public function getFollowerCount($user_id): int
    {
        return $this->where('followed_id', $user_id)->count();
    }

    /**
     * フォローしているユーザーのIDを取得する。
     * 
     * @param Int $user_id
     */
    public function followingIds(Int $user_id)
    {
        return $this->where('following_id', $user_id)->get('followed_id');
    }
}
