<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use Illuminate\Support\Facades\Log;
use illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * ユーザーの全ID取得し、viewを返す。
     * 
     * @access public
     * 
     * @param  User $user
     * 
     * @see User::getAllUsers()
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.index', [
            'all_users' => $all_users
        ]);
    }

    /**
     * isFollowing()でフォロー状態をbooleanで返し、フォローしていなかった場合はUser::follow()で紐付けする。
     * 
     * @param User $user
     * 
     * @see User::isFollowing(), User::follow()
     * 
     * @return [type]
     */
    public function follow(User $user)
    {
        
        $follower = auth()->user();
        
        $is_following = $follower->isFollowing($user->id);
        if (!$is_following) {
            
            $follower->follow($user->id);
            
        }
        return redirect('/users');
    }

    /**
     * isFollwing()でフォロー状態をbooleanで返し、フォローしていた場合User::unfollow()で紐付けを解除する。
     * 
     * @param User $user
     * 
     * @see User::isFollowing(), User::unfollow()
     * 
     * @return [type]
     */
    public function unfollow(User $user)
    {
        $follower = auth()->user();
        
        $is_following = $follower->isFollowing($user->id);
        if($is_following) {
            $follower->unfollow($user->id);
        }
        
        return redirect('/users');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Tweet $tweet, Follower $follower)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $tweet->getUserTimeLine($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);
        $follow_count = $follower->getFollowCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user'              => $user,
            'is_following'      => $is_following,
            'is_followed'       => $is_followed,
            'timelines'         => $timelines,
            'tweet_count'       => $tweet_count,
            'follow_count'      => $follow_count,
            'follower_count'    => $follower_count
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * ユーザー編集画面を返す。
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     * $requestで取得したデータにバリデーションをかける。
     * Rule::unique()で、重複したデータを弾くように設定する。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'name'          => ['required', 'string', 'max:255'],
            'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
        ]);
        $validator->validate();
        $user->updateProfile($data);

        return redirect('users/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
