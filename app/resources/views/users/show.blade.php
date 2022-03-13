@extends('layouts.app')

@section('content')
<div class="container" style="position: relative">
    <div class="row justify-content-center" style="position:absolute; top: 50%; left: 20%;  width: 80%;">
        <div class="col-md-8 mb-3" style="display: flex; justify-content:center; background-color: white; border-radius: 10px; box-shadow: 0 0 8px gray;">
            <div class="card">
                <div class="d-inline-flex" style="display: flex;">
                    <div class="p-3 d-flex flex-column">
                        <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" style="width: 100px; height: 100px; border-radius: 50%;">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold" style="font-weight:bold; font-size:larger;">{{ $user->name }}</h4>
                            <span class="text-secondary" style="font-size: medium;">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex" style="margin: 2rem;">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn btn-primary" style="display: inline-block; padding: 0.5em 1em; text-decoration: none; background: #668ad8; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin-left: 1rem;">プロフィールを編集する</a>
                                @else
                                    @if ($is_following)
                                        <form action="{{ route('unfollow', ['user' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger" style="padding: 1em; padding: 1rem; margin: 1rem;  color: white;  font-size: 18px;  font-weight: 200;  background-color: red;  box-shadow: 2px 2px 4px;">フォロー解除</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', ['user' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-primary" style="padding: 1em; padding: 1rem; margin: 1rem;  color: white;  font-size: 18px;  font-weight: 200;  background-color: blue;  box-shadow: 2px 2px 4px;">フォローする</button>
                                        </form>
                                    @endif

                                    @if ($is_followed)
                                        <span class="mt-2 px-1 bg-secondary text-light">フォローされています</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-end" style="display: flex; justify-content:space-between">
                            <div class="p-2 d-flex flex-column align-items-center" style="border: solid 1px;">
                                <p class="font-weight-bold" style="font-weight: bold;">ツイート数</p>
                                <span>{{ $tweet_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center" style="border: solid 1px;">
                                <p class="font-weight-bold" style="font-weight: bold;">フォロー数</p>
                                <span>{{ $follow_count }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center" style="border: solid 1px;">
                                <p class="font-weight-bold" style="font-weight: bold;">フォロワー数</p>
                                <span>{{ $follower_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class="col-md-8 mb-3" style="column-count: 2; background-color: white; margin-top: 1rem; border-radius: 10px; box-shadow: 0 0 8px gray;">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" style="border-radius: 50%; width: 3rem; height: 3rem;">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{ url('users/' .$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $timeline->text }}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end" style="display: flex; justify-content:flex-end; margin-right: 1rem; margin-top: 1rem;">
                            @if ($timeline->user->id === Auth::user()->id)
                                <div class="dropdown mr-3 d-flex align-items-center" style="display: flex; align-items:center;">
                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-fw"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <form method="POST" action="{{ url('tweets/' .$timeline->id) }}" class="mb-0">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ url('tweets/' .$timeline->id .'/edit') }}" class="dropdown-item">編集</a>
                                            <button type="submit" class="dropdown-item del-btn">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div style="display: flex;">
                                <div class="mr-3 d-flex align-items-center" style="display: flex;">
                                    <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                    <p class="mb-0 text-secondary">{{ count($timeline->comments) }}</p>
                                </div>
                                <div class="d-flex align-items-center" style="display: flex;">
                                    <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                    <p class="mb-0 text-secondary">{{ count($timeline->favorites) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="my-4 d-flex justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
@endsection