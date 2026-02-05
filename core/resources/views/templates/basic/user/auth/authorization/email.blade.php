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
                        </div>
                        <h5 class="pb-3 text-center border-bottom">@lang('Verify Email Address')</h5>
                        <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                            @csrf
                            <p class="verification-text">@lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}
                            </p>

                            @include($activeTemplate . 'partials.verification_code')

                            <div class="mb-3">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>

                            <div class="mb-3">
                                <p>
                                    @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span
                                            id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                        href="{{ route('user.send.verify.code', 'email') }}" class="try-again-link d-none">
                                        @lang('Try again')</a>
                                </p>
                                <a class="text--base" href="{{ route('user.logout') }}">@lang('Logout')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
