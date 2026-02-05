@extends($activeTemplate . 'layouts.master')
@php
    $userDashboardImage = getContent('user.content', true);
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center g-3">
            @forelse($auctions as $auction)
                <div class="col-lg-3">
                    <div class="card custom--card">
                        <div class="text-center">
                            <div class="auction-card-header">
                                <h3>@lang('Quantity'): {{ getAmount($auction->quantity) }} {{ __(gs('coin_sym')) }}</h3>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">@lang('Seller'): {{ __($auction->user->fullname) }}</h5>
                                <p class="card-text"> @lang('Total Price'): @php
                                    $getAmountOfParcent = ($auction->expected_profit * $phase->price) / 100;
                                    $finalPrice = $phase->price + $getAmountOfParcent;
                                    $amount = $auction->quantity * $finalPrice;
                                @endphp
                                    {{ getAmount($amount) }} {{ __(gs('cur_text')) }} </p>
                                <button class="btn btn--base w-100 mt-3 confirmationBtn" data-question="@lang('Are you sure buy this auction')?"
                                    data-action="{{ route('user.auction.buy', $auction->id) }}"> <i
                                        class="las la-coins"></i>
                                    @lang('Buy Now')</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @include($activeTemplate . 'partials.data_not_found', ['data' => 'Data Not Found'])
            @endforelse
        </div>
        @if ($auctions->hasPages())
            <div class="mt-4">{{ $auctions->links() }}</div>
        @endif
    </div>
@endsection

@push('modal')
    <x-confirmation-modal />
@endpush
