@extends($activeTemplate . 'layouts.frontend')
@section('content')

@php
    // Used by the "Roadmap as summary" section to render anchor links to other home sections.
    $homeSecs = $sections->secs ? json_decode($sections->secs, true) : [];
@endphp

@push('style')
    <style>
        /* Prevent fixed header from covering anchor targets */
        .section-anchor {
            scroll-margin-top: 110px;
        }
    </style>
@endpush

<div id="top"></div>



@if (!empty($homeSecs))
    @foreach ($homeSecs as $sec)
        <div id="sec-{{ $sec }}" class="section-anchor">
            @if ($sec === 'roadmap')
                @include($activeTemplate . 'sections.' . $sec, ['homeSecs' => $homeSecs])
            @else
                @include($activeTemplate . 'sections.' . $sec)
            @endif
        </div>
    @endforeach

    <div id="sec-banner" class="section-anchor">
        @include($activeTemplate . 'partials.banner')
    </div>
@endif
@endsection
