@php
    $phases = App\Models\Phase::get();
    $phaseContent = getContent('phase.content', true);
@endphp

<!-- ico section start -->
<section class="pt-100 pb-100 bg_img overlay--one"
    style="background-image: url('{{ frontendImage('phase', @$phaseContent->data_values->background_image, '1920x1280') }} ');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$phaseContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$phaseContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row">
            <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s">
                <div class="table-responsive table-responsive--md">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Start Date')</th>
                                <th>@lang('End Date')</th>
                                <th>@lang('Quantity')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Sold')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($phases as $phase)
                                <tr>
                                    <td>{{ showDateTime($phase->start_date,"F d, Y") }}</td>
                                    <td>{{ showDateTime($phase->end_date,"F d, Y") }}</td>
                                    <td>{{ $phase->total_coin }} {{ __(gs('coin_text')) }}</td>
                                    <td>{{ showAmount($phase->price) }}</td>
                                    <td>
                                        @php
                                            $progress = ($phase->sold / $phase->total_coin) * 100;
                                        @endphp
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100"
                                                style="width: {{ getAmount($progress, 4) }}%">

                                            </div>
                                        </div>
                                        <span class="text--success custom--cl">
                                            {{ getAmount($progress, 4) }}%
                                        </span>
                                    </td>

                                    <td>
                                        @php echo $phase->statusBadge @endphp
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><span
                                            class="text-white">{{ __($emptyMessage) }}</span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- row end -->
    </div>
</section>
<!-- ico section end -->

@push('style')
    <style>
        .badge {
            border-radius: 10px !important;
        }
        .progress {
            height: 10px;
        }
    </style>
@endpush
