@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (!$auctions->isEmpty())
                    <div class="table-responsive table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Seller')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Percent')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Purchased Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($auctions as $auction)
                                    <tr>
                                        <td>{{ $auctions->firstItem() + $loop->index }} </td>
                                        <td>{{ __($auction->user->fullname) }} </td>
                                        <td>{{ getAmount($auction->quantity) }} {{ __(gs('coin_sym')) }}</td>
                                        <td>{{ showAmount($auction->expected_profit) }}% </td>
                                        <td>{{ showAmount($auction->amount) }}</td>
                                        <td>{{ showDateTime($auction->auction_completed) }} </td>
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
                        'data' => 'No Purchase Found',
                    ])
                @endif

            </div>
        </div><!-- row end -->
    </div>
@endsection

@push('script')
    <script>
        (function($) {

            "use strict";

            $('.confirm').on('click', function() {
                var modal = $('#exampleModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
