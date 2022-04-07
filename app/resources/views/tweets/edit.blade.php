@extends('layouts.app')

@section('content')
<div class="container">
    <div class="" style="justify-content: center; width: 80%; margin: 2rem auto 0 auto;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update</div>

                <div>
                    <form method="POST" action="{{ route('tweets.update', [$tweets->id]) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <div class="flex-content-center">
                                <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" width="50" height="50">
                                <div>
                                    <p>{{ $user->name }}</p>
                                    <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                                </div>
                            </div>
                            <div class="flex-content-center">
                                <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') ? : $tweets->text }}</textarea>

                                @error('text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <div class="btn-flexend">
                                <p>140文字以内</p>
                                <button type="submit" class="btn-submit">
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