@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-12 mt-0">
                <div class="text-end">
                    <a href="{{ route('user.coin.buy') }}" class="btn btn--base px-4">
                        <i class="fa fa-coins"></i> @lang('Buy Now')
                    </a>
                </div>
            </div>
            <div class="col-12">
                @if (!$histories->isEmpty())
                    <div class="card custom--card">
                        <div class="card-body p-0">
                            <div class="table-responsive table-responsive--md">
                                <table class="table custom--table">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Coin')</th>
                                            <th>@lang('Rate')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Balance')</th>
                                            <th>@lang('Details')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($histories as $history)
                                            <tr>
                                                <td> {{ $histories->firstItem() + $loop->index }}</td>
                                                <td>
                                                    {{ showDateTime($history->created_at, 'Y-m-d') }}
                                                </td>

                                                <td>
                                                    <span
                                                        class="@if ($history->type == '+') text--success @else text--danger @endif">
                                                        {{ $history->type }}
                                                        {{ showAmount($history->coin_quantity, currencyFormat: false) }}
                                                        {{ __(gs('coin_sym')) }}
                                                    </span>
                                                </td>


                                                <td>
                                                    {{ showAmount($history->coin_rate) }}
                                                </td>
                                                <td>
                                                    {{ showAmount($history->amount) }}
                                                </td>
                                                <td>
                                                    {{ showAmount($history->coin_post_balance, currencyFormat: false) }}
                                                    {{ __(gs('coin_sym')) }}
                                                </td>
                                                <td>
                                                    {{ __($history->details) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($histories->hasPages())
                            <div class="card-footer">
                                {{ paginateLinks($histories) }}
                            </div>
                        @endif
                    </div>
            </div>
        @else
            @include($activeTemplate . 'partials.data_not_found', ['data' => 'No History Found'])
            @endif
        </div>
    </div>
@endsection

@push('style')
    <style>
        .highlighted-text {
            border-radius: 7px !important;
        }
    </style>
@endpush
