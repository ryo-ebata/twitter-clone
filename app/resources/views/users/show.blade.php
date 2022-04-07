@extends('layouts.app')

@section('content')
<div class="container">
    <div class="item">
        <div class="content">
            <div>
                <div class="flex">
                    <div>
                        <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="profile-image">
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="font-weight-bold">{{ $user->name }}</h4>
                            <span class="text-secondary">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="btn-margin">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ url('users/' .$user->id .'/edit') }}" class="btn-edit-profile">プロフィールを編集する</a>
                                @else
                                    @if ($is_following)
                                        <form action="{{ route('unfollow', ['user' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-unfollow">フォロー解除</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', ['user' => $user->id]) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-follow">フォローする</button>
                                        </form>
                                    @endif

                                    @if ($is_followed)
                                        <span class="follow-message">フォローされています</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="flex-content-space">
                            <div class="border-solid">
                                <p class="font-weight-bold">ツイート数</p>
                                <span>{{ $tweet_count }}</span>
                            </div>
                            <div class="border-solid">
                                <p class="font-weight-bold">フォロー数</p>
                                <span>{{ $follow_count }}</span>
                            </div>
                            <div class="border-solid">
                                <p class="font-weight-bold">フォロワー数</p>
                                <span>{{ $follower_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class="user-tweet">
                    <div>
                        <div class="card-haeder">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="tweet-profile-image">
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{ url('users/' .$timeline->user->id) }}">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div>
                                <p>{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $timeline->text }}
                        </div>
                        <div class="card-footer">
                            @if ($timeline->user->id === Auth::user()->id)
                                <div class="flex align-items-center">
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
                            <div class="flex">
                                <div class="flex align-items-center">
                                    <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                    <p>{{ count($timeline->comments) }}</p>
                                </div>
                                <div class="flex align-items-center">
                                    <a href="#"><i class="far fa-comment fa-fw"></i></a>
                                    <p>{{ count($timeline->favorites) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
@endsection