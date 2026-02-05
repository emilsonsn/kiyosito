@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Stage')</th>
                                    <th>@lang('Start Date') | @lang('End Date')</th>
                                    <th>@lang('Total')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Softcap')</th>
                                    <th>@lang('Hardcap')</th>
                                    <th>@lang('Unsold')</th>
                                    <th>@lang('Sold')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($phases as $phase)
                                    <tr>
                                        <td> {{ __($phase->stage) }} </td>
                                        <td>
                                            {{ showDatetime($phase->start_date, 'F d, Y') }} </br>
                                            {{ showDatetime($phase->end_date, 'F d, Y') }}
                                        </td>
                                        <td> {{ $phase->total_coin }} {{ __(gs()->coin_sym) }} </td>
                                        <td> {{ showAmount($phase->price) }} </td>
                                        <!-- Softcap Data -->
                                        <td>
                                            {{ showAmount($phase->softcap_price) }}<br>
                                            <small>{{ $phase->softcap_label }}</small><br>
                                            <small>{{ $phase->softcap_label_2 }}</small>
                                        </td>
                                        <!-- Hardcap Data -->
                                        <td>
                                            {{ showAmount($phase->hardcap_price) }}<br>
                                            <small>{{ $phase->hardcap_label }}</small><br>
                                            <small>{{ $phase->hardcap_label_2 }}</small>
                                        </td>
                                        <td> {{ $phase->unsold }} {{ __(gs()->coin_sym) }} </td>
                                        <td>
                                            {{ $phase->sold }} {{ __(gs()->coin_sym) }}
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped" role="progressbar"
                                                    style="width: {{ phaseProgress($phase) }}%"
                                                    aria-valuenow="{{ phaseProgress($phase) }}" aria-valuemin="0"
                                                    aria-valuemax="100"> {{ getAmount(phaseProgress($phase), 0) }}%</div>
                                            </div>
                                        </td>
                                        <td>@php echo $phase->statusBadge @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary ms-1 editBtn"
                                                    data-resource="{{ $phase }}"><i class="la la-pen"></i>
                                                    @lang('Edit')
                                                </button>
                                                <a href="{{ route('admin.ico.detail', slug($phase->stage)) }}"
                                                    class="btn btn-sm btn-outline--info ms-1 @if ($phase->end_date > now() && $phase->start_date > now()) disabled @endif"
                                                    data-resource="{{ $phase }}">
                                                    <i class="la la-desktop"></i>
                                                    @lang('Detail')
                                                </a>
                                            </div>
                                        </td>
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
                @if ($phases->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($phases) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!--START ADD PHASE MODAL -->
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Phase')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.ico.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Start Date')</label>
                            <input name="start_date" type="text" data-language="en" class="date form-control bg--white"
                                autocomplete="off" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('End Date')</label>
                            <input name="end_date" type="text" data-language="en" class="date form-control bg--white"
                                autocomplete="off" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Coin Token') <small> (@lang('Total quantity of sales'))</small></label>
                            <div class="input-group">
                                <input type="number" required name="coin_token" value="{{ old('coin_token') }}"
                                    class="form-control">
                                <span class="input-group-text">{{ __(gs('coin_sym')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" required name="price" value="{{ old('price') }}"
                                    class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <!-- Add Softcap Fields -->
                        <div class="form-group">
                            <label>@lang('Softcap Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" required name="softcap_price" value="{{ old('softcap_price') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Softcap Label')</label>
                            <input type="text" required name="softcap_label" value="{{ old('softcap_label') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('Softcap Label 2')</label>
                            <input type="text" required name="softcap_label_2" value="{{ old('softcap_label_2') }}" class="form-control">
                        </div>
                        <!-- Add Hardcap Fields -->
                        <div class="form-group">
                            <label>@lang('Hardcap Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" required name="hardcap_price" value="{{ old('hardcap_price') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Hardcap Label')</label>
                            <input type="text" required name="hardcap_label" value="{{ old('hardcap_label') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('Hardcap Label 2')</label>
                            <input type="text" required name="hardcap_label_2" value="{{ old('hardcap_label_2') }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD PHASE MODAL -->

    <!-- UPDATE PHASE MODAL START-->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Phase')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.ico.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label>@lang('Price') </label>
                            <div class="input-group">
                                <input type="text" required name="price" value="{{ old('price') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs()->cur_text) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Add Coin Token Quantity')</label>
                            <div class="input-group">
                                <input type="number" name="coin_token" value="{{ old('coin_token') }}" placeholder="0" class="form-control">
                                <span class="input-group-text">{{ __(gs()->coin_sym) }}</span>
                            </div>
                            <code>@lang('Add Quantity to Previous Coin Token') <span class="previous-coin-quantity text--danger"></span></code>
                        </div>
                        <!-- Add Softcap Fields -->
                        <div class="form-group">
                            <label>@lang('Softcap Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="softcap_price" value="{{ old('softcap_price') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Softcap Label')</label>
                            <input type="text" name="softcap_label" value="{{ old('softcap_label') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('Softcap Label 2')</label>
                            <input type="text" name="softcap_label_2" value="{{ old('softcap_label_2') }}" class="form-control">
                        </div>
                        <!-- Add Hardcap Fields -->
                        <div class="form-group">
                            <label>@lang('Hardcap Price')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="hardcap_price" value="{{ old('hardcap_price') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Hardcap Label')</label>
                            <input type="text" name="hardcap_label" value="{{ old('hardcap_label') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>@lang('Hardcap Label 2')</label>
                            <input type="text" name="hardcap_label_2" value="{{ old('hardcap_label_2') }}" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- UPDATE PHASE MODAL END -->
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' keySearch="no" />
    <button class="btn btn-sm btn-outline--primary addModal" type="button">
        <i class="las la-plus"></i>@lang('Add new')
    </button>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            const datePicker = $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showDropdowns: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                        .endOf('month')
                    ],
                    'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                },
                maxDate: moment()
            });
            const changeDatePickerText = (event, startDate, endDate) => {
                $(event.target).val(startDate.format('MMMM DD, YYYY') + ' - ' + endDate.format('MMMM DD, YYYY'));
            }


            $('.date-range').on('apply.daterangepicker', (event, picker) => changeDatePickerText(event, picker
                .startDate, picker.endDate));


            if ($('.date-range').val()) {
                let dateRange = $('.date-range').val().split(' - ');
                $('.date-range').data('daterangepicker').setStartDate(new Date(dateRange[0]));
                $('.date-range').data('daterangepicker').setEndDate(new Date(dateRange[1]));
            }

            $('.editBtn').on('click', function() {
                var modal = $('#editModal');
                let data = $(this).data('resource');
                let price = parseFloat(data.price);
            
                modal.find('input[name=id]').val(data.id);
                modal.find('input[name=stage]').val(data.stage);
                modal.find('input[name=price]').val(price.toFixed(2));
                modal.find('input[name=softcap_price]').val(data.softcap_price);
                modal.find('input[name=softcap_label]').val(data.softcap_label);
                modal.find('input[name=softcap_label_2]').val(data.softcap_label_2);
                modal.find('input[name=hardcap_price]').val(data.hardcap_price);
                modal.find('input[name=hardcap_label]').val(data.hardcap_label);
                modal.find('input[name=hardcap_label_2]').val(data.hardcap_label_2);
                modal.modal('show');
            });
            
            $('.addModal').on('click', function() {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                locale: {
                    format: 'Y-MM-DD'
                }
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .datepickers-container {
            z-index: 9999999999;
        }
    </style>
@endpush
