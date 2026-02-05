@extends($activeTemplate . 'layouts.app')
@section('panel')
    @php
        $banned = getContent('banned.content', true);
    @endphp
    <section class="pt-100 pb-100 main-wrapper">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-8 col-lg-12">
                            <h3 class="text--danger mb-3">{{ __(@$banned->data_values->heading) }}</h3>
                            <img src="{{ frontendImage('banned', @$banned->data_values->image, '700x400') }}"
                                alt="@lang('image')" class="img-fluid mx-auto">
                        </div>
                    </div>
                    <div class="reason-wrapper mt-3 mb-3">
                        <h5 class="text-white">@lang('Ban Reason'): </h5>
                        <span class="text--danger"> {{ __(auth()->user()->ban_reason) }}</span>
                    </div>
                    <a href="{{ route('home') }}" class="btn--base btn">@lang('Go To Home')</a>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('style')
    <style>
        .main-wrapper{
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

    </style>
@endpush
