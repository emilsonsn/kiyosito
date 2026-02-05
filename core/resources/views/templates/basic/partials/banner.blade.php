<div style="margin-top: 80px; text-align: center; padding: 40px 0; background-color: #111; border-bottom: 1px solid #333;">
    <h3 style="color: #fff; font-family: sans-serif; margin-bottom: 20px; letter-spacing: 1px;">PRIMARY ANNOUNCEMENT</h3>
    <embed src="{{ asset('assets/THE_WISE_ARCHITECT_STRIPPED.pdf') }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="85%" height="800px" style="border: 1px solid #444; box-shadow: 0 10px 30px rgba(0,0,0,0.5);" />
</div>

@php
    $bannerContent = getContent('banner.content', true);
@endphp
<section class="hero bg_img scroll-section"
    style="background-image: url({{ frontendImage('banner', @$bannerContent->data_values->image, '1920x1080') }});"
    data-paroller-factor="0.3">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-xxl-6 col-lg-6 text-lg-start text-center">
		    <h2 class="hero__title wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
		                    {{ __(@$bannerContent->data_values->heading) }} </h2>
		                <p class="mt-3 wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.5s">
		                    {{ __(@$bannerContent->data_values->subheading) }}</p>
                <div class="mt-lg-5 mt-3 wow fadeInUp" data-wow-duration="0.5" data-wow-delay="0.3s">
                    <a href="{{ @$bannerContent->data_values->button_link }}" class="btn btn--base magnetic-effect">
                        {{ __(@$bannerContent->data_values->button_name) }}
                    </a>
                </div>
	            </div>
	            <div class="col-xxl-5 col-lg-6 mt-lg-0 mt-5">
	                <div class="count-wrapper glass--bg rounded-2 text-center">
		    <h2 class="title">@lang('Timeline')</h2>
		    <p class="mt-2">@lang('Scheduled milestone countdown')</p>
	                    <div id="countdown" class="mt-5" data-date=" @if ($phaseType == 'RUNNING') {{ showDateTime(@$phase->end_date,'m/d/Y H:i:s') }} @elseif($phaseType == 'UPCOMING'){{ showDateTime(@$phase->start_date,'m/d/Y H:i:s') }} @else {{ Carbon\Carbon::now()->subDays(1)->format('m/d/Y H:i:s') }} @endif ">
	                        <ul class="date-unit-list d-flex flex-wrap justify-content-between">
	                            <li class="single-unit"><span id="days"></span>@lang('Days')</li>
	                            <li class="single-unit"><span id="hours"></span>@lang('Hours')</li>
	                            <li class="single-unit"><span id="minutes"></span>@lang('Minutes')</li>
	                            <li class="single-unit"><span id="seconds"></span>@lang('Seconds')</li>
	                        </ul>
	                    </div>

	                </div>
	            </div>
	        </div>
    </div>
</section>
@push('script')
    <script>
        (function($) {
            "use strict"
            // variable for time units
            const second = 1000,
                  minute = second * 60,
                  hour   = minute * 60,
                  day    = hour * 24;

            // get attribute date data from HTML
            let dateData  = document.querySelector('#countdown').getAttribute('data-date');

            let finalDay  = dateData,

                countDown = new Date(finalDay).getTime(),
                       x  = setInterval(function() {

                    let now      = new Date().getTime(),
                        distance = countDown - now;

                    let daysVar    = document.getElementById("days");
                    let hoursVar   = document.getElementById("hours");
                    let minutesVar = document.getElementById("minutes");
                    let secondsVar = document.getElementById("seconds");

                    daysVar.innerText    = Math.floor(distance / (day)),
                    hoursVar.innerText   = Math.floor((distance % (day)) / (hour)),
                    minutesVar.innerText = Math.floor((distance % (hour)) / (minute)),
                    secondsVar.innerText = Math.floor((distance % (minute)) / second);

                    //do something later when date is reached
                    if (distance < 0) {
                        daysVar.innerText    = "0";
                        hoursVar.innerText   = "0";
                        minutesVar.innerText = "0";
                        secondsVar.innerText = "0";
                        clearInterval(x);
                    }
                    seconds
                }, 0)
        })(jQuery);
    </script>
@endpush
