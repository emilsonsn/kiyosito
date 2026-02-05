@extends($activeTemplate . 'layouts.master')
@php
    $kycContent = getContent('kyc_instruction.content', true);
@endphp
@section('content')
    <div class="container">
        <div class="notice"></div>
        <div class="row gy-4">
            <div class="col-12">
                @php
                    $kyc = getContent('kyc.content', true);
                @endphp
                @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                    <div class="alert d-widget rounded-3 alert-danger" role="alert">
                        <div class="row col-12 d-flex justify-content-between mb-2">
                            <div class="col-6">
                                <h4 class="alert-heading text--danger mb-0">@lang('KYC Documents Rejected')</h4>
                            </div>
                            <div class="col-6 justify-content-end d-flex">
                                <button class="btn btn-outline--base btn--sm" data-bs-toggle="modal"
                                    data-bs-target="#kycRejectionReason">@lang('Show Reason')</button>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-0 text-white">{{ __(@$kyc->data_values->reject) }}
                            <a class="text--base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>.
                        </p>
                        <br>
                        <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                    </div>
                @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                    <div class="alert d-widget rounded-3 alert-info" role="alert">
                        <h4 class="alert-heading text--warning">@lang('KYC Verification required')</h4>
                        <hr>
                        <p class="mb-0 text-white">{{ __(@$kyc->data_values->required) }} <a class="text--base"
                                href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
                    </div>
                @elseif(auth()->user()->kv == Status::KYC_PENDING)
                    <div class="alert d-widget rounded-3 alert-warning" role="alert">
                        <h4 class="alert-heading text-info">@lang('KYC Verification pending')</h4>
                        <hr>
                        <p class="mb-0 text-white">{{ __(@$kyc->data_values->pending) }} <a class="text--base"
                                href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="text-center phase-card">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        @if (@$coinCurrentRate->price)
                            <div class="phase-card-content">
                                <h5 class="mb-2">@lang('Stage'): {{ __(@$coinCurrentRate->stage) }}</h5>
                                <a href="{{ route('user.coin.buy') }}" class="btn btn--base"><i class="fa fa-coins"></i>
                                    @lang('Buy Token')
                                </a>
                            </div>
                        @else
                            <h5> @lang('Plase wait for buy')</h5>
                        @endif
                    </div>
                </div>
            </div>

            <!--<div class="col-lg-4">-->
            <!--    <div class="text-center phase-card">-->
            <!--        <div class="card-header d-flex align-items-center justify-content-center">-->
            <!--            @if (@$coinCurrentRate->price)-->
            <!--                <div class="phase-card-content">-->
            <!--                    <h5 class="mb-2">@lang('Coin Name'): {{ __(gs()->coin_text) }}</h5>-->
            <!--                    <h6>@lang('Current Coin Price'): {{ showAmount($coinCurrentRate->price) }}-->
            <!--                    </h6>-->
            <!--                </div>-->
            <!--            @else-->
            <!--                <h5> @lang('No coin initiated yet!')</h5>-->
            <!--            @endif-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->


            <div class="col-xxl-4 col-lg-4 col-md-6">
                <div class="d-widget rounded-3">
                    <div class="d-widget__icon">
                        <!--<i class="lab la-bitcoin"></i>-->
                        <img src="{{ asset('assets/kiyosito_logo.png') }}" alt="Kiyosito Logo" class="d-widget__icon-img">                        
                    </div>
                    <div class="d-widget__content">
                        <h3 class="d-widget__amount">{{ showAmount($user->coin_balance, currencyFormat: false) }}
                            {{ __(gs('coin_sym')) }}</h3>
                        <p class="captoin text-white">@lang('Coin Balance')</p>
                    </div>
                </div><!-- d-widget end -->
            </div>

            <div class="col-xxl-4 col-lg-4 col-md-6">
                <a href="{{ route('user.transactions') }}" class="w-100">
                    <div class="d-widget rounded-3">
                        <div class="d-widget__icon">
                            <i class="las la-folder-open"></i>
                        </div>
                        <div class="d-widget__content">
                            <h3 class="d-widget__amount">{{ $user['transaction'] }}</h3>
                            <p class="captoin text-white">@lang('Total Transaction')</p>
                        </div>
                    </div><!-- d-widget end -->
                </a>
            </div>

            <!--<div class="col-xxl-4 col-lg-4 col-md-6">-->
            <!--    <a href="{{ route('user.deposit.history') }}" class="w-100">-->
            <!--        <div class="d-widget rounded-3">-->
            <!--            <div class="d-widget__icon">-->
            <!--                <i class="las la-wallet"></i>-->
            <!--            </div>-->
            <!--            <div class="d-widget__content">-->
            <!--                <h3 class="d-widget__amount">{{ $user['deposit'] }}</h3>-->
            <!--                <p class="captoin text-white">@lang('Total Deposit')</p>-->
            <!--            </div>-->
            <!--        </div><!-- d-widget end -->-->
            <!--    </a>-->
            <!--</div>-->

            <div class="col-12">
                <h4 class="mb-2">@lang('Recent Transaction')</h4>
                @include($activeTemplate . 'partials.transactions')
            </div>
        </div>
    </div>


    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
