<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Tweet;
use App\Models\User;

class FormController extends Controller
{
    /**
     * FormRequestを使用した、ツイートのバリデーション。
     * 
     * @param PostRequest $request
     * @param Tweet $tweet
     * 
     * @return [type]
     */
    public function postValidates(PostRequest $request, Tweet $tweet) {
        $user = auth()->user();
        $data = $request->all();

        $tweet->storeTweet($user->id, $data);
        return redirect('tweets');
    }

    /**
     * ツイート編集用のバリデーション。
     * 
     * @param PostRequest $request
     * @param Tweet $tweet
     * 
     * @return [type]
     */
    public function updateValidates(PostRequest $request, Tweet $tweet){
        $user = auth()->user();
        $data = $request->all();

        $tweet->updateTweet($user->id, $data);
        return redirect('tweets');
    }

    public function updateProfile(PostRequest $request, User $user){
        $data = $request->all();

        $user->updateProfile($data);
        return redirect('users/'.$user->id);
    }
}
