<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Tweet;

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

        $tweet->tweetStore($user->id, $data);
        return redirect('tweets');
    }

    public function updateValidates(PostRequest $request, Tweet $tweet){
        $user = auth()->user();
        $data = $request->all();

        $tweet->tweetUpdate($user->id, $data);
        return redirect('tweets');
    }
}
