@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" >
                <div class="card-header" style="background-color: white; margin: 1rem auto 2rem auto; padding: 2rem; font-weight:bold; border-radius: 10px; box-shadow: 0 0 8px gray; width: 80％;">{{ $user->name }}の編集画面</div>

                <div class="card-body" style="background-color: white; border-radius: 10px; box-shadow: 0 0 8px gray; width: 80%; margin: 0 auto 0 auto;">
                    <form method="POST" action="{{ url('users/' .$user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row align-items-center" style="margin: 2rem; padding-top:1rem; text-align:center;">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-right" style="font-weight: bold; border: solid 1px #6775f5; padding: 0.5rem 1rem;">{{ __('プロフィール画像') }}</label>

                            <div class="col-md-6 d-flex align-items-center" style="margin: 2rem auto 2rem auto;">
                                <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="mr-2 rounded-circle" width="80" height="80" alt="profile_image">
                                <input type="file" name="profile_image" class="@error('profile_image') is-invalid @enderror" autocomplete="profile_image">
                                <br>
                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="form-group row" style="margin: 1rem; padding: 2rem; text-align:center;">
                            <label for="screen_name" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; border: solid 1px #6775f5; padding: 0.5rem 1rem;">{{ __('アカウント名') }}</label>

                            <div class="col-md-6">
                                <input id="screen_name" type="text" class="form-control @error('screen_name') is-invalid @enderror" name="screen_name" value="{{ $user->screen_name }}" required autocomplete="screen_name" autofocus>

                                @error('screen_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="margin: 2rem; padding: 2rem; text-align:center;">
                            <label for="name" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; border: solid 1px #6775f5; padding: 0.5rem 1rem;">{{ __('ニックネーム') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" style="margin: 2rem; padding: 2rem; text-align:center;">
                            <label for="email" class="col-md-4 col-form-label text-md-right" style="font-weight:bold; border: solid 1px #6775f5; padding: 0.5rem 1rem;">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" style="margin: 2rem;">
                                <button type="submit" class="btn btn-primary" style="display: inline-block; text-decoration: none; padding: 0.5rem 1rem; background: #668ad8; color: #FFF; border-bottom: solid 4px #627295; border-radius: 3px; margin: 1rem;">更新する</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection