@php
    $featureContent = getContent('feature.content', true);
    $featureElement = getContent('feature.element', orderById: true);
@endphp
<!-- feature section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$featureContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$featureContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row mb-none-30">
            @foreach ($featureElement as $element)
                <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="1.3s">
                    <div class="feature-card"
                        style="background-image: url(' {{ frontendImage('feature', @$element->data_values->background_image, '525x580') }} ');">
                        <div class="feature-card__icon">
                            @php echo @$element->data_values->feature_icon; @endphp
                        </div>
                        <div class="feature-card__content">
                            <h4 class="title">{{ __(@$element->data_values->title) }}</h4>
                            <p class="mt-3">{{ __(@$element->data_values->description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
