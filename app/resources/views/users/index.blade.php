@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="grid">
            <div class="margin-tb-3rem">
                @foreach ($all_users as $user)
                    <div class="user-card">
                        <div class="card-haeder p-3 w-100 d-flex" style="display: flex; padding: 1rem; margin: 1rem; background-color: #fff; width: 100%; box-shadow: 0 0 8px gray; border-radius: 10px;">
                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" style="border-radius: 50%; width: 3rem; height: 3rem;">
                            <div class="ml-2 d-flex flex-column" style="margin-left: 0.5rem; display:flex; flex-direction: column;">
                                <p class="mb-0" style="margin-bottom: 0;">{{ $user->name }}</p>
                                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                            </div>

                            <div>
                                @if (auth()->user()->isFollowed($user->id))
                                    <div class="px-2">
                                        <span class="px-1 bg-secondary text-light" style="background-color: #6c757d; color:#FFF;">フォローされています</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-end flex-grow-1">
                                    @if (auth()->user()->isFollowing($user->id))
                                        <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger" style="display: inline-block; padding: 0.5em 1em; text-decoration: none; background: #dc143c; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin-left: 1rem; font-weight: bold;">フォロー解除</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow', $user->id) }}" method="POST">
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-primary" style="display: inline-block; padding: 0.5em 1em; text-decoration: none; background: #668ad8; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin-left: 1rem; font-weight: bold;">フォローする</button>
                                        </form>
                                    @endif
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center" style="display: grid; justify-content: center;">
            {{ $all_users->links() }}
        </div>
    </div>
@endsection