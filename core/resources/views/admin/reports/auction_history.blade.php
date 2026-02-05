@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Profit')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Auction Owner')</th>
                                    <th>@lang('Auction Buyer')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Published At')</th>
                                    @if (Route::currentRouteName() == 'admin.auction.bakced')
                                        <th>@lang('Backed At')</th>
                                    @else
                                        <th>@lang('Completed At')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($auctions as $auction)
                                    <tr>
                                        <td>{{ $auctions->firstItem() + $loop->index}}</td>
                                        <td> {{ getAmount($auction->quantity) }}
                                            {{ __(gs('coin_sym')) }}
                                        </td>
                                        <td> {{ getAmount($auction->expected_profit) }}% </td>

                                        <td> {{ showAmount($auction->amount) }}
                                            {{ __(gs('cur_text')) }}
                                        </td>
                                        <td> <a href="{{ route('admin.users.detail', $auction->auction_owner) }}">
                                                {{ __($auction->user->username) }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($auction->auction_buyer)
                                                <a href="{{ route('admin.users.detail', $auction->auction_buyer) }}">
                                                    {{ __($auction->buyer->username) }}
                                                </a>
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>

                                        <td>
                                            @php echo $auction->statusBadge @endphp
                                        </td>

                                        <td>
                                            {{ showDateTime($auction->created_at) }}
                                        </td>

                                        @if (Route::currentRouteName() == 'admin.auction.bakced')
                                            <td data-label="@lang('Backed At')">
                                                {{ showDateTime($auction->updated_at) }}
                                            </td>
                                        @else
                                            <td>
                                                @if ($auction->auction_completed)
                                                    {{ showDateTime($auction->auction_completed) }}
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </td>
                                        @endif

                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($auctions->hasPages())
                        <div class="card-footer py-4">
                            {{ paginateLinks($auctions) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection


    @push('breadcrumb-plugins')
        <x-search-form  dateSearch='yes' auctionFilter='yes' />
    @endpush

    @push('script')
        <script>
            (function($) {

                "use strict";
                if (!$('.datepicker-here').val()) {
                    $('.datepicker-here').datepicker();
                }

                $('.datepicker').css('z-index', 10000);

                $('.editBtn').on('click', function() {
                    var modal = $('#editModal');
                    let data = $(this).data('resource');
                    let price = parseFloat(data.stage);

                    modal.find('input[name=id]').val(data.id);
                    modal.find('input[name=stage]').val(data.stage);
                    modal.find('input[name=price]').val(price.toFixed(2));
                    modal.modal('show');
                });


                $('.addModal').on('click', function() {
                    var modal = $('#addModal');
                    modal.modal('show');
                });

            })(jQuery);
        </script>
    @endpush
