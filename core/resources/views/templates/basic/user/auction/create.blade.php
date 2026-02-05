@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="custom--card">
                    <h2 class="title mb-5 text-center">@lang('Manage Auction Create Information')</h2>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="las la-exclamation-triangle f-30"></i>
                        @lang('Your Auctionable Quantity'): &nbsp; <span class="text-black"> {{ $actionableCoinSum }}
                            {{ gs('coin_sym') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Coin Quantity')</label>
                        <div class="input-group">
                            <input type="number" class="form-control" form="form" name="coin_quantity">
                            <span class="input-group-text">{{ __(gs('coin_sym')) }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('Expected Percentage of Profit')</label>
                        <div class="input-group">
                            <input type="text" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')"
                                class="form-control" form="form" name="percent" readonly>
                            <span class="input-group-text">@lang('%')</span>
                        </div>
                    </div>
                    <h6 id="calculation_result"></h6>
                    <button type="button" class="btn btn--base w-100 mt-3 confirmationBtn"
                        data-action="{{ route('user.auction.store') }}"
                        data-question="@lang('Are you sure to create auction') ?">@lang('Submit')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict'

            $('body').on('input', '#percent', function() {
                totalAmount()
            });

            $('body').on('input', '#coin_quantity', function() {
                let coinQuntity = parseInt($(this).val());
                if (coinQuntity) {
                    $('body').find("#percent").attr('readonly', false);

                } else {
                    $('body').find("#percent").attr('readonly', true);
                }
                let auctionableQty = `{{ $actionableCoinSum }}`;

                if (parseInt(auctionableQty) < coinQuntity) {
                    notify('error', 'Can\'t cross your auctionable limit');
                    $(this).val(` `);
                }

                totalAmount();
            });

            function totalAmount() {
                let percentOfProfit = parseFloat($('body').find("#percent").val());
                const currentCoinPrice = parseFloat('{{ getAmount($phase->price) }}');
                let getAmountOfPercent = (percentOfProfit * currentCoinPrice) / 100;
                let finalPrice = currentCoinPrice + getAmountOfPercent;
                let coinQuantity = parseFloat($("body").find("#coin_quantity").val());
                let amount = coinQuantity * finalPrice;
                if (isNaN(amount)) {
                    amount = 0;
                }
                $('#calculation_result').text(`@lang('Total Amount'): ${amount.toFixed(2)} {{ gs()->cur_text }} `);
            }

            $(`input[name=coin_quantity], input[name=percent]`).on('keyup keypress keydown', function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

        })(jQuery);
    </script>
@endpush

@push('modal')
    <x-confirmation-modal />
@endpush
