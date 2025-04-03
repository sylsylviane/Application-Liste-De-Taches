@extends('layouts.app')
@section('title', trans('Login'))
@section('content')
<h1>@lang('Login')</h1>
<div class="row justify-content-center">
    <div class="col-md-6">
        @if(!$errors->isEmpty())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">@lang('Login')</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">@lang('Username')</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email')}}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">@lang('Password')</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <input type="submit" value="@lang('Login')" class="btn btn-primary mb-2">
                </form>
                <a href="{{route('user.forgot')}}">Forgot Password</a>
            </div>
        </div>
    </div>
</div>
@endsection