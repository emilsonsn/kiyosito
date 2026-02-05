@extends($activeTemplate . 'layouts.app')
@php
    $recovery = getContent('account_recovery.content', true);
@endphp
@section('panel')
    <section class="account-section bg_img"
        style="background-image: url(' {{ frontendImage('account_recovery', @$recovery->data_values->background_image, '1900x1000') }} ');">
        <div class="account-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-5">
                        <div class="account-wrapper">
                            <div class="account-thumb-area text-center">
                                <a href="{{ route('home') }}" class="account-wrapper-logo">
                                    <img src="{{ siteLogo() }}" alt="@lang('image')">
                                </a>
                                <h4 class="card-title">@lang('Reset Password')</h4>
                            </div>

                            <div class="card-body">
                                <div class="mb-4">
                                    <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                                </div>
                                <form method="POST" action="{{ route('user.password.update') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label class="form-label">@lang('Password')</label>
                                        <input type="password"
                                            class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                            name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">@lang('Confirm Password')</label>
                                        <input type="password" class="form-control form--control"
                                            name="password_confirmation" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100"> @lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
