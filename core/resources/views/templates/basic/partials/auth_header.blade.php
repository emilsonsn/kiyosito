@php
    $phase = App\Models\Phase::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->first();
@endphp

<header class="header">

    <!--@include($activeTemplate . 'partials.top_header')-->

    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                        alt="site-logo"></a>
                <div class="collapse navbar-collapse mt-lg-0 mt-3" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu m-auto">
                        <li><a class="{{ menuActive('user.home') }}"
                                href="{{ route('user.home') }}">@lang('Dashboard')</a></li>
                        <!--li class="menu_has_children"><a class="{{ menuActive('user.deposit.*') }}"
                                href="#0">@lang('Deposit')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.deposit.index') }}">@lang('Deposit Now')</a></li>
                                <li><a href="{{ route('user.deposit.history') }}">@lang('Deposit History')</a></li>
                            </ul>
                        </li-->

                        <!-- wp = Withdraw permissions -->
                        @if (gs()->wp)
                            <li class="menu_has_children"><a
                                    class="{{ menuActive(['user.withdraw', 'user.withdraw.history']) }}"
                                    href="#0">@lang('Withdraw')</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('user.withdraw') }}">@lang('Withdraw Now')</a></li>
                                    <li><a href="{{ route('user.withdraw.history') }}">@lang('Withdraw History')</a></li>
                                </ul>
                            </li>
                        @endif

                        <li><a class="{{ menuActive('user.coin.index') }}"
                                href="{{ route('user.coin.index') }}">@lang('Coin History')</a></li>

                        @if (gs()->auction_permission)
                            <li class="menu_has_children"><a class="{{ menuActive(['user.auction.*']) }}"
                                    href="#0">@lang('Auction')</a>
                                <ul class="sub-menu">
                                    @if ($phase)
                                        <li><a href="{{ route('user.auction.offering') }}">@lang('Offering Auctions')</a></li>
                                    @endif
                                    <li><a href="{{ route('user.auction.my.offers') }}">@lang('My Auctions')</a></li>
                                    <li><a href="{{ route('user.auction.create') }}">@lang('Create Auction')</a></li>
                                    <li><a href="{{ route('user.auction.purchase.history') }}">@lang('Purchase History')</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li class="menu_has_children"><a class="{{ menuActive(['ticket.*']) }}"
                                href="#0">@lang('Support')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('ticket.open') }}">@lang('Open Ticket')</a></li>
                                <li><a href="{{ route('ticket.index') }}">@lang('My Support Tickets')</a></li>
                            </ul>
                        </li>
                        <li class="menu_has_children"><a href="#0"
                                class="{{ menuActive(['user.profile.setting', 'user.twofactor', 'user.change.password', 'user.transactions', 'user.referred', 'user.referral.log']) }}">@lang('Account')</a>
                            <ul class="sub-menu">
                                <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
                                <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
                                <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
                                <li><a href="{{ route('user.transactions') }}">@lang('Transactions')</a></li>
                                <li><a href="{{ route('user.referred') }}">@lang('Referrals Users')</a></li>
                                <li><a
                                        href="{{ route('user.transactions') }}?remark=referral_bonus">@lang('Referral Bonus')</a>
                                </li>
                                <li><a href="{{ route('user.logout') }}">@lang('Logout')</a></li>
                            </ul>
                        </li>

                    </ul>
                    <div class="nav-right">
                        <a href="{{ route('user.logout') }}" class="header-login-btn">
                            <i class="las la-sign-out-alt"></i>@lang('Logout')</a>
                    </div>
                </div>
            </nav>
        </div>
    </div><!-- header__bottom end -->
</header>
