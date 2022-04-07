<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Boolean;
use App\Consts\paginateConsts;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'screen_name',
        'name',
        'profile_image',
        'email',
        'password'
    ];

    /**
     * User::class, 'followers', 'followed_id', 'following_id'のリレーション。中間テーブルのデータを参照。
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

    /**
     * User::class, 'followers', 'following_id', 'followed_id'のリレーション。中間テーブルのデータを参照。
     */
    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    /**
     * $user_idと一致する'id'を取得し、1ページ5件表示でページネーションする。
     * 
     * @param Int $user_id
     */
    public function getAllUsers(Int $user_id)
    {
        return $this->Where('id', '<>', $user_id)->paginate(paginateConsts::displayUsers);
    }

    /**
     * follows()で定義した中間テーブルに、紐付けデータを保存する。紐付けされている場合はフォロー状態。引数にはフォローしたいユーザーのIDを渡す。
     * 
     * @param Int $user_id
     * 
     * @see follows()
     */
    public function follow(Int $user_id) 
    {
        return $this->follows()->attach($user_id);
    }

    /**
     * follows()で定義した中間テーブルの紐付けデータを削除する。紐付けがないので、アンフォローの状態。引数にはフォロー解除したいユーザーのIDを渡す。
     * 
     * @param Int $user_id
     * 
     * @see follows()
     */
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    /**
     * フォローしているかどうかを、follows()中間テーブル内のレコードの有無で判断する。
     * 
     * @param Int $user_id
     * 
     * @see follows()
     */
    public function isFollowing(Int $user_id)
    {
        return $this->follows()->where('followed_id', $user_id)->exists('id');
    }

    /**
     * フォローされているかどうかを、followers()中間テーブル内のレコードの有無で判断する。
     * 
     * @param Int $user_id
     * 
     * @see followers()
     */
    public function isFollowed(Int $user_id) 
    {
        return $this->followers()->where('following_id', $user_id)->exists('id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * @param Array $params
     */
    public function updateProfile(Array $params)
    {
        if (isset($params['profile_image'])) {
            $file_name = $params['profile_image']->store('public/profile_image/');

            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'profile_image' => basename($file_name),
                    'email'         => $params['email'],
                ]);
        } else {
            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'email'         => $params['email'],
                ]); 
        }

        return;
    }
}
