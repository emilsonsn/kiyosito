@php
    $faqContent = getContent('faq.content', true);
    $faqElement = getContent('faq.element', orderById: true);
@endphp

<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$faqContent->data_values->heading) }}</h2>
                    <p class="mt-3">{{ __(@$faqContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="accordion custom--accordion" id="faqAccordion">
            <div class="row gy-4">
                @foreach ($faqElement as $faq)
                    <div class="col-lg-6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h-{{ $faq->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#c-{{ $faq->id }}" aria-expanded="false"
                                    aria-controls="{{ $faq->id }}">
                                    {{ __($faq->data_values->question) }}
                                </button>
                            </h2>
                            <div id="c-{{ $faq->id }}" class="accordion-collapse collapse"
                                aria-labelledby="h-{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-white">
                                    {!! __(@$faq->data_values->answer) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
