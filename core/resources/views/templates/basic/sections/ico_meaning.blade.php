@php
    $icoContent = getContent('ico_meaning.content', true);
    $backgroundImage = @$icoContent->data_values->background_image;
    $isVideo = $backgroundImage && pathinfo($backgroundImage, PATHINFO_EXTENSION) === 'webm';
@endphp

<!-- about section start -->
<section class="pt-100 pb-100 scroll-section">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6 wow fadeInLeft" data-wow-duration="0.5" data-wow-delay="0.3s">
                <h2 class="section-title">{{ __(@$icoContent->data_values->heading) }}</h2>
                <div class="ico-meaning">
                    {!! __(@$icoContent->data_values->description) !!}
                </div>
                <div class="btn--group mt-4">
                    <a href="{{ __(@$icoContent->data_values->button_link) }}" class="btn btn--base">{{ __(@$icoContent->data_values->button_name) }}</a>
                    <!-- Hide the play button on small screens -->
                    <!--a href="{{ @$icoContent->data_values->video_link }}" data-rel="lightcase:myCollection" class="video-btn video-btn--sm d-lg-inline-flex d-none"><i class="las la-play"></i></a-->
                </div>
            </div>
            <div class="col-lg-5 d-lg-block d-none wow fadeInRight" data-wow-duration="0.5" data-wow-delay="0.5s">
                <div class="about-thumb">
                    @if ($isVideo)
                        <!-- Render video -->
                        <video autoplay muted loop playsinline width="100%" height="auto" class="autoplay-video">
                            <source src="{{ frontendImage('ico_meaning', $backgroundImage) }}" type="video/webm">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <!-- Render image -->
                        <img src="{{ frontendImage('ico_meaning', $backgroundImage, '530x585') }}" alt="image">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- about section end -->

@push('style')
<style>
    .about-thumb:hover a {
        color: #fff;
    }

    /* Hide the play button and controls */
    .autoplay-video::-webkit-media-controls {
        display: none !important;
    }

    .autoplay-video {
        object-fit: cover; /* Ensure the video covers the container */
    }

    /* Hide the play button on small screens */
    @media (max-width: 767px) {
        .video-btn--sm {
            display: none !important;
        }
    }
</style>
@endpush
