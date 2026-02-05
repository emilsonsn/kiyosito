@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $recovery = getContent('account_recovery.content', true);
    @endphp

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
                        </div>
                        <h5 class="pb-3 text-center border-bottom mb-3">@lang('2FA Verification')</h5>
                        <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form">
                            @csrf
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="form--group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                        <div class="form-group">
                            <p class="mt-2">
                                @lang('Please enter verification code from your google authenticator')
                            </p>
                            <a class="text--base" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
