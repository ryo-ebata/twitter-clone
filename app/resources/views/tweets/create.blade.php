@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="create_tweet" style="justify-content: center; width: 80%; margin: 2rem auto 0 auto;">
        <div class="col-md-8">
            <div class="card" style="background-color: white; border-radius: 10px; box-shadow: 0 0 8px gray;">
                <div class="card-header" style="background-color: #668ad8; padding: 1rem; color: white; border-radius: 10px 10px 0 0; font-weight: bold;">{{ $user->name }}の新規ツイート</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tweet.validates') }}">
                        @csrf

                        <div class="form-group row mb-0">
                            <div class="col-md-12 p-3 w-100 d-flex" style="display: flex; justify-content: center;">
                                <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                <div class="ml-2 d-flex flex-column">
                                    <p class="mb-0">{{ $user->name }}</p>
                                    <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: flex; justify-content: center;">
                                <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>

                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-right" style="display: flex; text-align:center; justify-content: flex-end; margin-top: 1rem;">
                                <p class="mb-4 text-danger">140文字以内</p>
                                <button type="submit" class="btn btn-primary" style="display: inline-block; padding: 0.5em 1em; text-decoration: none; background: #668ad8; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin: 0 1rem 1rem 1rem;">
                                    ツイートする
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection