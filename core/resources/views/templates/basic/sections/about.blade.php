@php
    $aboutContent = getContent('about.content', true);
    $aboutElement = getContent('about.element', orderById: true);
    
    // Check if background is video
    $backgroundImage = @$aboutContent->data_values->background_image;
    $isBgVideo = $backgroundImage && pathinfo($backgroundImage, PATHINFO_EXTENSION) === 'webm';
    
    // Check if main image is video
    $mainImage = @$aboutContent->data_values->image;
    $isMainVideo = $mainImage && pathinfo($mainImage, PATHINFO_EXTENSION) === 'webm';
@endphp

<div class="about-section pt-100 pb-100 bg_img overlay--one"
    style="background-image: url('{{ frontendImage('about', $backgroundImage, '1920x1280') }}');">
    <div class="container">
        <div class="row align-items-center flex-wrap-reverse">
            <!-- Video Section (Hidden on Mobile) -->
            <div class="col-lg-6 pe-xl-5 d-none d-lg-block">
                <div class="about-thumb mx-lg-0 mx-md-5">
                    @if($isMainVideo)
                        <!-- Video element -->
                        <video autoplay muted loop playsinline width="100%" height="auto" class="autoplay-video">
                            <source src="{{ frontendImage('about', $mainImage) }}" type="video/webm">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <!-- Image element -->
                        <img src="{{ frontendImage('about', $mainImage, '600x515') }}" alt="About image">
                    @endif
                </div>
            </div>
            <!-- Content Section -->
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-heading style-two">
                        <h2 class="section-title mb-3">{{ __(@$aboutContent->data_values->subheading) }}</h2>
                        <h3 class="section-heading__title mb-4"> {{ __(@$aboutContent->data_values->heading) }}</h3>
                            <div class="section-heading__desc mb-4">
                                {!! nl2br(__($aboutContent->data_values->content)) !!}
                            </div>                            
                    </div>
                    <ul class="text-list">
                        @foreach ($aboutElement as $item)
                            <li class="text-list__item">
                                <span class="text-list__item-icon"> @php echo @$item->data_values->icon; @endphp</span>
                                {{ __(@$item->data_values->title) }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="about-content__button mt-4">
                        <a href="{{ @$aboutContent->data_values->button_link }}"
                            class="btn btn--base">{{ __(@$aboutContent->data_values->button_name) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
    /* Video styling */
    .autoplay-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .autoplay-video::-webkit-media-controls {
        display: none !important;
    }
    
    /* Ensure background image/video container maintains aspect ratio */
    .about-thumb {
        position: relative;
        overflow: hidden;
    }
</style>
@endpush