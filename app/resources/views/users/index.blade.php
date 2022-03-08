@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="row justify-center" style="display: grid; justify-content: center;">
            <div class="col-md-8" style="margin: 3rem 0; ">
                @foreach ($all_users as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex" style="display: flex; padding: 1rem; border: solid silver; background-color: #fff; width: 100%;">
                            <img src="{{ $user->profile_image }}" class="rounded-circle" width="50" height="50" style="border-radius: 50%;">
                            <div class="ml-2 d-flex flex-column" style="margin-left: 0.5rem; display:flex; flex-direction: column;">
                                <p class="mb-0" style="margin-bottom: 0;">{{ $user->name }}</p>
                                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                            </div>

                            @if (auth()->user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end flex-grow-1">
                                @if (auth()->user()->isFollowing($user->id))
                                    <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-danger">フォロー解除</button>
                                    </form>
                                @else
                                    <form action="{{ route('follow', $user->id) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit" class="btn btn-primary" style="display: inline-block; padding: 0.5em 1em; text-decoration: none; background: #668ad8; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin-left: 1rem;">フォローする</button>
                                    </form>
                                @endif

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