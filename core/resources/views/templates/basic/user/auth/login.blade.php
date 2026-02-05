@extends($activeTemplate . 'layouts.app')
@php
    $loginContent = getContent('login.content', true);
@endphp
@section('panel')
    <section class="account-section bg_img"
        style="background-image: url('{{ frontendImage('login', @$loginContent->data_values->background_image, '1900x1000') }}');">
        <div class="account-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="account-wrapper">
                            <form method="POST" action="{{ route('user.login') }}" class="account-form verify-gcaptcha">
                                @csrf

                                <div class="account-thumb-area text-center">
                                    <a href="{{ route('home') }}" class="account-wrapper-logo">
                                        <img src="{{ siteLogo() }}" alt="image">
                                    </a>

                                    <h3 class="title">{{ __(@$loginContent->data_values->heading) }}</h3>
                                </div>

                                @include($activeTemplate . 'partials.social_login')

                                <div class="form-group">
                                    <label>@lang('Username or Email')</label>
                                    <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Password')</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <x-captcha/>

                                <div class="form-group">
                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                        <div>
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                @lang('Remember Me')
                                            </label>
                                        </div>
                                        <a class="forgot-pass text--base" href="{{ route('user.password.request') }}">
                                            @lang('Forgot your password?')
                                        </a>
                                    </div>
                                </div>

                                <button type="submit" id="recaptcha" class="btn btn--base w-100" id="recaptcha">@lang('Login')</button>
                                <p class="mt-2 text-center">@lang('Don\'t have any account?') <a
                                        href="{{ route('user.register') }}" class="text--base">@lang('Register')</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
