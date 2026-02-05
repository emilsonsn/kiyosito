@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')
    <div class="main-wrapper">
        @if (!request()->routeIs('home') && !request()->routeIs('user.login') && !request()->routeIs('user.register') && !request()->routeIs('maintenance'))
            @include($activeTemplate . 'partials.breadcrumb')
        @endif
        @yield('content')
    </div>
    @include($activeTemplate . 'partials.footer')
@endsection
