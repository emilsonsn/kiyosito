@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card custom--card">
                    <h2 class="mb-3">@lang('Enter Your Quantity To Purchase')</h2>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between flex-wrap border-0">
                                <span>@lang('Phase') :</span>
                                <span>{{ __($phase->stage) }} @lang('Stage')</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap border-0">
                                <span>@lang('Price') :</span>
                                <span>{{ showAmount($phase->price) }}
                                    (@lang('1') {{ __(gs()->coin_sym) }} @lang('=')
                                    {{ showAmount($phase->price) }})
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap border-0">
                                <span>
                                    @lang('Availabe Quantity') :
                                </span>
                                <span>{{ $phase->coin_token }} {{ __(gs()->coin_sym) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between flex-wrap border-0" id="total_price">
                            </li>
                        </ul>

                        <div class="input-group mt-3">
                            <input type="number" form="form" class="form-control" required name="coin_quantity">
                            <span class="input-group-text text-dark">{{ __(gs()->coin_sym) }}</span>
                        </div>
                        <button type="button" class="btn btn--base w-100 mt-4 confirmationBtn"
                            data-action="{{ route('user.coin.buy.confirm') }}" disabled
                            data-question="@lang('Are you sure to buy ') {{ __(gs()->coin_sym) }} ?">
                            <i class="fa fa-coins"></i> @lang('Buy Now')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";

            $('#total_price').hide();

            let price = parseFloat('{{ getAmount($phase->price) }}');
            let baseCurrency = '{{ __(gs()->cur_text) }}';
            let availableCoin = '{{ $phase->coin_token }}';

            $("[name='coin_quantity']").on('input', function() {
                var $this = $(this).val()
                if ($this) {
                    if (parseFloat($this) > parseFloat(availableCoin)) {
                        notify('error', 'This quantity has been crossed coin limit')
                        $(".confirmationBtn").prop("disabled", true);
                    }
                    $(".confirmationBtn").prop("disabled", false);
                    $('#total_price').show();
                    var totalPrice = parseFloat($(this).val()) * price;
                    $('#total_price').html(
                        `<span>@lang('Total Price'): </span> <span>${totalPrice} ${baseCurrency}</span>`);
                } else {
                    $(".confirmationBtn").prop("disabled", true);
                    $('#total_price').hide();
                }
            });
        })(jQuery);
    </script>
@endpush


@push('modal')
    <x-confirmation-modal />
@endpush
