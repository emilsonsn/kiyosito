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
                                    <th>@lang('Coin')</th>
                                    <th>@lang('Rate')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coinHistories as $coin)
                                    <tr>
                                        <td> {{ $coinHistories->firstItem() + $loop->index}}</td>

                                        <td class="budget">
                                            <span class="fw-bold @if($coin->type == '+')text--success @else text--danger @endif">
                                                {{ $coin->type }} {{ showAmount($coin->coin_quantity, currencyFormat:false) }}
                                                {{ __(gs('coin_text')) }}
                                            </span>
                                        </td>

                                        <td> {{ showAmount($coin->coin_rate) }} </td>
                                        <td> {{ showAmount($coin->amount) }} </td>
                                        <td> {{ showAmount($coin->coin_post_balance, currencyFormat:false) }} {{ __(gs('coin_text')) }}
                                        </td>
                                        <td>
                                            {{ __(@$coin->user->fullname) }}
                                            <br>
                                            <small>
                                                <a href="{{ route('admin.users.detail', $coin->user_id) }}">
                                                    {{ __($coin->user->username) }}
                                                </a>
                                            </small>
                                        </td>
                                        <td> {{ __($coin->details) }} </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center">{{__($emptyMessage)}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($coinHistories->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($coinHistories) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="username..." />
@endpush

