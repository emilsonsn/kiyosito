@extends($activeTemplate . 'layouts.app')
@php
    $recovery = getContent('account_recovery.content', true);
@endphp
@section('panel')
    <section class="account-section bg_img"
        style="background-image: url(' {{ frontendImage('account_recovery', @$recovery->data_values->background_image, '1900x1000') }} ');">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper account-wrapper">
                    <div class="verification-area">
                        <div class="account-thumb-area text-center">
                            <a href="{{ route('home') }}" class="account-wrapper-logo">
                                <img src="{{ siteLogo() }}" alt="image">
                            </a>
                            <h4 class="card-title">@lang('Verify Email Address')</h4>
                        </div>
                        <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                            @csrf
                            <p class="verification-text">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                            <input type="hidden" name="email" value="{{ $email }}">
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                            <div class="form-group">
                                @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
