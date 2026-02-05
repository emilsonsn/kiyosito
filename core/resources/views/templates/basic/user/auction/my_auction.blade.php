@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (auth()->user()->coin_balance > 0)
                    <div class="text-end mb-4">
                        <a href="{{ route('user.auction.create') }}" class="btn btn--base">
                            <i class="fa fa-coins"></i> @lang('Create Auction')
                        </a>
                    </div>
                @else
                    <div class="text-end mb-4">
                        <button type="button" class="brn btn--base btn-md highlighted-text notify-auction">
                            <i class="fa fa-coins"></i> @lang('Create Auction')
                        </button>
                    </div>
                @endif
                @if (!$auctions->isEmpty())
                    <div class="table-responsive table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Buyer')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Expected Profit')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Completed Date')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($auctions as $auction)
                                    <tr>
                                        <td> {{ $auctions->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if ($auction->auction_buyer)
                                                {{ __($auction->buyer->fullname) }}
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>
                                        <td>{{ showAmount($auction->quantity, 0) }}</td>
                                        <td>{{ getAmount($auction->expected_profit, 0) }}%</td>
                                        <td>{{ showAmount($auction->amount) }}</td>
                                        <td>
                                            @php echo $auction->statusBadge; @endphp
                                        </td>
                                        <td>
                                            {{ $auction->auction_completed != null ? showDateTime($auction->auction_completed, 'Y-m-d') : __('N/A') }}
                                        </td>
                                        <td>
                                            @if ($auction->status == Status::AUCTION_RUNNING)
                                                <button class="btn btn--base btn--sm confirmationBtn"
                                                    data-question="@lang('Are you sure to get back/returned this auction')?"
                                                    data-action="{{ route('user.auction.returned', $auction->id) }}">
                                                    <i class="fa fa-arrow-left"></i> @lang('Get Return')
                                                </button>
                                            @elseif($auction->status == Status::AUCTION_RETURNED)
                                                <button type="button" class="btn btn--danger btn--sm" disabled>
                                                    <i class="fa fa-arrow-left"></i> @lang('Returned')</button>
                                            @elseif($auction->status == Status::AUCTION_COMPLETED)
                                                <button type="button" class="btn btn--success btn--sm" disabled>
                                                    <i class="fa fa-check"></i> @lang('Completed')</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($auctions->hasPages())
                            <div class="mt-4">
                                {{ $auctions->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    @include($activeTemplate . 'partials.data_not_found', [
                        'data' => 'No Auction Found',
                    ])
                @endif

            </div>
        </div><!-- row end -->
    </div>
@endsection

@push('script')
    <script>
        $('.notify-auction').on('click', function() {
            notify('error', "You don't have any coins to create an auctin.")
        })
    </script>
@endpush


@push('modal')
    <x-confirmation-modal />
@endpush
