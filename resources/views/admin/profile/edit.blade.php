{{-- layouts/profile.blade.phpを読み込む --}}
@extends('layouts.profile')


{{-- profile.blade.phpの@yield('title')に'Profile'を埋め込む --}}
@section('title', 'Profile')

{{-- profile.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィール編集画面</h2>
                                <form action="{{ action('Admin\ProfileController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                    <ul>
                        @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="form-group row">
                    <label class="col-md-2" for="name">氏名</label>
                    <div class="col-md-10">
                    <input type="text" class="form-control" name="name" value="{{ $profile_form->name }}">
                    </div>
                </div>
                 <div class="form-group row">
                    <label class="col-md-2" for="gender">性別</label>
                    <div class="col-md-10">
                  <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender"  value="男性">
                  <label class="form-check-label">男性</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender"  value="女性">
                  <label class="form-check-label">女性</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender"  value="その他">
                  <label class="form-check-label">その他</label>
                </div>
                </div>
                </div>
              <div class="form-group row">
                    <label class="col-md-2">趣味</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="hobby" value="{{ $profile_form->hobby }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2">自己紹介欄</label>
                    <div class="col-md-10">
                            <textarea class="form-control" name="introduction" rows="20">{{ $profile_form->introduction }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $profile_form->id }}">
                        {{ csrf_field() }}
                   <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>
            </form>
                    <div class="row mt-5">
                    <div class="col-md-4 mx-auto">
                        <h2>編集履歴</h2>
                        <ul class="list-group">
                            @if ($profile_form->profilehists != NULL)
                                @foreach ($profile_form->profilehists as $profile)
                                    <li class="list-group-item">{{ $profile->edited_at }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection