@php
    $blogContent = getContent('blog.content', true);
    $blogElement = getContent('blog.element', false, 3, false);
@endphp
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title"><span
                            class="font-weight-normal">{{ __(@$blogContent->data_values->heading) }}</span></h2>
                    <p>{{ __(@$blogContent->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row justify-content-center">
            @foreach ($blogElement as $blog)
                <div class="col-lg-4 col-md-6 gy-3">
                    <div class="blog-card">
                        <div class="blog-card__thumb">
                            <img src="{{ frontendImage('blog', @$blog->data_values->image, '430x280', thumb: true) }}">
                        </div>
                    <div class="blog-card__content">
                        <h4 class="blog-card__title mb-3">
                            <a href="{{ route('blog.details', $blog->slug) }}">
                                {{ __(strLimit(@$blog->data_values->title, 60)) }}
                            </a>
                        </h4>
                        @php
                            $raw = $blog->data_values->description_nic
                                ?? $blog->data_values->description
                                ?? $blog->data_values->details
                                ?? '';

                            // blog.element content may be a full HTML document (pdf2htmlEX). Strip noisy parts.
                            $raw = preg_replace('~<head\\b[^>]*>.*?</head>~is', '', (string) $raw);
                            $raw = preg_replace('~<script\\b[^>]*>.*?</script>~is', '', (string) $raw);
                            $raw = preg_replace('~<style\\b[^>]*>.*?</style>~is', '', (string) $raw);

                            $excerpt = trim(html_entity_decode(strip_tags($raw)));
                            $excerpt = preg_replace('/\\s+/', ' ', $excerpt);
                        @endphp
                        @if ($excerpt)
                            <p class="mb-3">{{ __(strLimit($excerpt, 140)) }}</p>
                        @endif
                        <a class="btn btn--base mt-3 see-more" href="{{ route('blog.details', $blog->slug) }}">
                            @lang('Read More') <i class="las la-long-arrow-alt-right"></i>
                        </a>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
