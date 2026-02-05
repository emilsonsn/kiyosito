@extends($activeTemplate . 'layouts.app')
@php
    $recovery = getContent('account_recovery.content', true);
@endphp
@section('panel')
    <section class="account-section "
        style="background-image: url(' {{ frontendImage('account_recovery', @$recovery->data_values->background_image, '1900x1000') }} ');">
        <div class="account-area">
            <div class="container custom-container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-5">
                        <div class="account-wrapper">
                            <div class="account-thumb-area text-center">
                                <a href="{{ route('home') }}" class="account-wrapper-logo">
                                    <img src="{{ siteLogo() }}" alt="@lang('image')">
                                </a>
                                <h4 class="title">{{ __($pageTitle) }}</h4>
                            </div>
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                            </div>
                            <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">@lang('Email or Username')</label>
                                    <input type="text" class="form-control form--control" name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                </div>

                                <x-captcha />

                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    <p class="text-center mt-2">@lang('Remember your credential') ? <a href="{{ route('user.login') }}"
                                            class="text--base">@lang('Login')</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    @endsection
