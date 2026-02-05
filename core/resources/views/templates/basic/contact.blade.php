@php $contactContent = getContent('contact_us.content', true); @endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="pt-100 pb-100 overlay--one bg_img"
        style="background-image: url(' {{ frontendImage('contact_us', @$contactContent->data_values->background_image, '1900x1000') }} ');">
        <div class="container">
            <div class="row justify-content-center overlay--one mb-5">
                <div class="col-md-4 col-sm-12 mb-30">
                    <div class="contact-card rounded-3">
                        <div class="contact-card__icon text--base">
                            <i class="las la-envelope"></i>
                        </div>
                        <div class="contact-card__content">
                            <h4 class="title">@lang('Email')</h4>
                            <p class="caption">
                                <a
                                    href="mailto:{{ @$contactContent->data_values->email }}">{{ @$contactContent->data_values->email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mb-30">
                    <div class="contact-card rounded-3">
                        <div class="contact-card__icon text--base">
                            <i class="las la-phone"></i>
                        </div>
                        <div class="contact-card__content">
                            <h4 class="title">@lang('Phone')</h4>
                            <p class="caption">
                                <a
                                    href="tel:{{ @$contactContent->data_values->phone }}">{{ @$contactContent->data_values->phone }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 mb-30">
                    <div class="contact-card rounded-3">
                        <div class="contact-card__icon text--base">
                            <i class="las la-map-marker"></i>
                        </div>
                        <div class="contact-card__content">
                            <h4 class="title">@lang('Address')</h4>
                            <p class="caption">{{ @$contactContent->data_values->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form method="post" class="verify-gcaptcha contact-form rounded-3">
                        @csrf
                        <h2 class="text-white mb-4">{{ __(@$contactContent->data_values->heading) }}</h2>
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input name="name" type="text" class="form-control form--control"
                                value="@if (auth()->user()) {{ auth()->user()->fullname }} @else{{ old('name') }} @endif"
                                @if (auth()->user()) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Email')</label>
                            <input name="email" type="email" class="form-control form--control"
                                value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                @if (auth()->user()) readonly @endif required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Subject')</label>
                            <input name="subject" type="text" class="form-control form--control"
                                value="{{ old('subject') }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Message')</label>
                            <textarea name="message" wrap="off" class="form-control form--control" required>{{ old('message') }}</textarea>
                        </div>
                        <x-captcha />
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
