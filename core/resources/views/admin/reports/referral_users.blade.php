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
                                    <th>@lang('Fullname')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Referral At')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referralUsers as $user)
                                <tr>
                                    <td> {{ $referralUsers->firstItem() + $loop->index}}</td>
                                    <td> {{ $user->username}}</td>
                                    <td>
                                        <a href="{{ route('admin.users.detail', $user->id) }}">
                                            {{ __($user->username) }}
                                        </a>
                                    </td>
                                    <td> {{ showDateTime($user->created_at) }} </td>
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
                @if ($referralUsers->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($referralUsers) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

