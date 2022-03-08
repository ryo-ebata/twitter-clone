@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-center" style="display: grid; justify-content: center;">
            <div class="col-md-8" style="margin: 3rem 0;">
                @foreach ($all_users as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex" style="display: flex; padding: 1rem 30rem 1rem 0; border: solid silver; background-color: #fff; ">
                            <img src="{{ $user->profile_image }}" class="rounded-circle" width="50" height="50" style="border-radius: 50%;">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $user->name }}</p>
                                <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
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