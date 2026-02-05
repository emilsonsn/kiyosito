@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $registerContent = getContent('register.content', true);
    @endphp

    @if (gs('registration'))

        <section class="account-section bg_img"
            style="background-image: url('{{ frontendImage('register', @$registerContent->data_values->background_image, '1900x1000') }}');">
            <div class="account-area">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="account-wrapper">
                                <form class="account-form verify-gcaptcha disableSubmission"
                                    action="{{ route('user.register') }}" method="POST">
                                    @csrf
                                    <div class="account-thumb-area text-center">
                                        <a href="{{ route('home') }}" class="account-wrapper-logo">
                                            <img src="{{ siteLogo() }}" alt="image">
                                        </a>
                                        <h4 class="title">{{ __(@$registerContent->data_values->heading) }}</h4>
                                    </div>

                                    <div class="row">
                                        @if (session()->get('reference') != null)
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Reference By')</label>
                                                    <input id="firstname" type="text" id="reference" required
                                                        class="form-control" name="referBy"
                                                        value="{{ session()->get('reference') }}" readonly>
                                                </div>
                                            </div>
                                        @endif

                                        @include($activeTemplate . 'partials.social_login')

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('First Name')</label>
                                                <input type="text" class="form-control" name="firstname"
                                                    value="{{ old('firstname') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Last Name')</label>
                                                <input type="text" class="form-control" name="lastname"
                                                    value="{{ old('lastname') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Email')</label>
                                                <input type="email" class="form-control checkUser" name="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Password')</label>
                                                <input type="password"
                                                    class="form-control @if (gs('secure_password')) secure-password @endif"
                                                    name="password" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">@lang('Confirm Password')</label>
                                                <input type="password" class="form-control form--control"
                                                    name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <x-captcha />

                                        @if (gs('agree'))
                                            <div class="col-md-12 form-group">
                                                <input type="checkbox" id="agree" @checked(old('agree'))
                                                    name="agree" required>
                                                <label for="agree">@lang('I agree with')
                                                    @foreach ($policyPages as $policy)
                                                        <a class="text--base"
                                                            href="{{ route('policy.pages', $policy->slug) }}">{{ __(@$policy->data_values->title) }}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        @endif

                                        <div class="col-md-12">
                                            <button type="submit" id="recaptcha"
                                                class="btn btn--base w-100">@lang('Register')</button>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="mt-2 text-center">@lang('Do you have an account')? <a class="text--base"
                                                    href="{{ route('user.login') }}">@lang('Login').</a>
                                            </p>
                                        </div>
                                    </div><!-- row end -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @include($activeTemplate . 'partials.registration_disabled')



    @endif

    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn--sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .register-disable {
            height: 100vh;
            width: 100%;
            /* background-color: #fff; */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-disable-image {
            max-width: 300px;
            width: 100%;
            margin: 0 auto 32px;
        }

        .register-disable-title {
            color: white;
            font-size: 42px;
            margin-bottom: 18px;
            text-align: center
        }

        .register-disable-icon {
            font-size: 16px;
            background: rgb(255, 15, 15, .07);
            color: rgb(255, 15, 15, .8);
            border-radius: 3px;
            padding: 6px;
            margin-right: 4px;
        }

        .register-disable-desc {
            color: white;
            font-size: 18px;
            max-width: 565px;
            width: 100%;
            margin: 0 auto 32px;
            text-align: center;
        }

        .scroll-icon {
            margin-top: 19px;
        }
    </style>

    @if (gs('secure_password'))
        @push('script-lib')
            <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
        @endpush
    @endif

    @push('script')
        <script>
            "use strict";
            (function($) {

                $('.checkUser').on('focusout', function(e) {
                    var url = '{{ route('user.checkUser') }}';
                    var value = $(this).val();
                    var token = '{{ csrf_token() }}';

                    var data = {
                        email: value,
                        _token: token
                    }

                    $.post(url, data, function(response) {
                        if (response.data != false) {
                            $('#existModalCenter').modal('show');
                        }
                    });
                });
            })(jQuery);
        </script>
    @endpush
