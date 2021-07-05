@extends('layouts.app')

@section('content')
<div class="container">
    <div class="w-full max-w-xs">
            <form  method="POST" action="{{ route('login') }}" class="bg-gray-100 shadow-md px-8 pt-6 pb-8 mb-4">
            @csrf
                <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" >
                    E-Mail
                </label>
                <input class="w-full shadow border border-gray-100 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-orange-500 @error('email') border border-red-500 @enderror" id="email" type="email"  name="email" value="{{ old('email') }}"   placeholder="email">
                @error('email')
                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
                </div>

                <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" >
                    Password
                </label>
                <input class="w-full shadow border border-gray-100 py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-orange-500 @error('password') border border-red-500 @enderror" id="password" type="password" name="password"  placeholder="******************">
                @error('password')
                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
                </div>

                <div class="flex items-center justify-between">
                <button class="shadow bg-orange-500 hover:bg-orange-400 text-white font-bold py-2 px-4 focus:outline-none" type="submit">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                    Forgot Password?
                </a>
                </div>

            </form>
            <p class="text-center text-gray-500 text-xs">
                ©2019 iTech Empires. All rights reserved.
            </p>
            </div>
{{--     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
