@if (!$transactions->isEmpty())
    <div class="card custom--card">
        <div class="card-body p-0">
            <div class="table-responsive table-responsive--md">
                <table class="table custom--table">
                    <thead>
                        <tr>
                            <th>@lang('Trx')</th>
                            <th>@lang('Transacted')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Post Balance')</th>
                            <th>@lang('Detail')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $trx)
                            <tr>
                                <td data-label="TRX">
                                    @if (Str::startsWith($trx->trx, '0x') && strlen($trx->trx) >= 42)
                                        <a href="https://etherscan.io/tx/{{ $trx->trx }}" target="_blank" class="text--base">
                                            <strong>{{ Str::limit($trx->trx, 12, '...') }}</strong>
                                            <i class="fas fa-external-link-alt ms-1"></i>
                                        </a>
                                    @else
                                        <strong>{{ $trx->trx }}</strong>
                                    @endif
                                </td>

                                <td>
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </td>
                                <td class="budget">
                                    <span
                                        class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                        {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                    </span>
                                </td>
                                <td class="budget">
                                    {{ showAmount($trx->post_balance) }}
                                </td>
                                <td>{{ __($trx->details) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    @include($activeTemplate . 'partials.data_not_found', ['data' => 'No Transaction Found'])
@endif
