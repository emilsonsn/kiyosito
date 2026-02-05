@php
    $fundContent = getContent('fund_allocation.content', true);
    $fundChartData = getContent('fund_allocation.element', orderById: true);
    
    \Log::info('Fund Content:', ['data' => $fundContent]);
    \Log::info('Fund Chart Data:', ['count' => count($fundChartData), 'data' => $fundChartData]);
    
@endphp

<section class="pt-100 pb-100 bg_img overlay--one">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-5">
                <div class="section-heading style-two">
                    <h2 class="section-title mb-3">{{ __(@$fundContent->data_values->heading) }}</h2>
                    <!-- Responsive Spacing -->
                    <div class="stm-spacing" id="stm-spacing-left" style="height: 48px;"></div>
                    <div class="section-heading__desc">
                        <h6>{{ __(@$fundContent->data_values->subheading) }}</h6>
                        <p>{!! nl2br(__($fundContent->data_values->description)) !!}</p>
                    </div>
                </div>
            </div>
            <!-- Right Column -->
            <div class="col-lg-7">
                <div class="chart-wrapper">
                    <!-- Responsive Spacing -->
                    <div class="stm-spacing" id="stm-spacing-right" style="height: 30px;"></div>
                    <div class="allocation-chart">
                        <!-- Chart Canvas -->
                        <div class="fund-chart-canvas">
                            <canvas id="fundAllocationChart" style="width: 100%; height: auto;"></canvas>
                        </div>
                        <!-- Legend -->
                        <ul class="fund-chart-legend">
                            @foreach ($fundChartData as $item)
                                <li>
                                    <span style="background-color: {{ @$item->data_values->color }}"></span>
                                    {{ __(@$item->data_values->percentage) }}% {{ __(@$item->data_values->label) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
<!-- Include Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('fundAllocationChart').getContext('2d');
        if (!ctx) {
            console.error('Canvas element not found!');
            return;
        }

        const percentages = @json($fundChartData->pluck('data_values.percentage')).map(Number);
        const colors = @json($fundChartData->pluck('data_values.color'));

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: percentages,
                    backgroundColor: colors,
                }]
            },
            options: {
                cutout: '50%',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
                }
            }
        });
    });
</script>
<style>
    .allocation-chart {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        max-width: 600px;
        margin: 0 auto;
    }

    .fund-chart-canvas {
        flex: 1;
        max-width: 500px;
    }

    .fund-chart-canvas canvas {
        max-height: 500px;
        width: 100%;
        height: auto;
    }

    .fund-chart-legend {
        flex: 0 0 250px;
        list-style: none;
        padding-left: 0;
        margin-left: 20px;
        margin-top: 0;
    }

    .fund-chart-legend li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .fund-chart-legend span {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 10px;
        display: inline-block;
    }

    .section-heading__desc h6 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .section-heading__desc p {
        font-size: 14px;
        line-height: 1.5;
    }
</style>
@endpush