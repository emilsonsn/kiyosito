@php
    $language = App\Models\Language::all();
    $selectedLang = $language->where('code', session('lang'))->first();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp
<header class="header">
    <!--@include($activeTemplate . 'partials.top_header')-->

    <div class="header__bottom" style="padding: 20px;">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                        alt="site-logo"></a>
                <div class="collapse navbar-collapse mt-xl-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu m-auto">
                        @auth
                            <li class="menu_has_children"><a class="{{ menuActive(['ticket.*']) }}"
                                    href="#0">@lang('Support')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('ticket.open') }}">@lang('Open Ticket')</a></li>
                                    <li><a href="{{ route('ticket.index') }}">@lang('My Support Tickets')</a></li>
                                </ul>
                            </li>
                        @endauth
                        <li>
                            @if (gs()->multi_language)
                                <div class="dropdown-lang dropdown mt-0 d-block d-sm-none">
                                    <a href="#" class="language-btn dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img class="flag"
                                            src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                                            alt="us">
                                        <span class="language-text text-white">{{ @$selectedLang->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach ($language as $lang)
                                            <li><a href="{{ route('lang', $lang->code) }}"><img class="flag"
                                                        src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}"
                                                        alt="@lang('image')">
                                                    {{ @$lang->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    </ul>
                    <div class="nav-right gap-sm-3 gap-2">
                        @auth
                            <a href="{{ route('user.home') }}" class="header-login-btn m-0">
                                <i class="las la-tachometer-alt"></i> @lang('Dashboard')</a>

                            <a href="{{ route('user.logout') }}" class="header-register-btn m-0"><i
                                    class="las la-sign-out-alt"></i> @lang('Logout')</a>
                        @else
                            <a href="{{ route('user.login') }}" class="header-login-btn m-0">
                                <i class="las la-user-circle"></i>@lang('Login')</a>
                            <a href="{{ route('user.register') }}" class="header-register-btn m-0">
                                <i class="las la-user-plus"></i> @lang('Register')</a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header__bottom end -->
</header>
