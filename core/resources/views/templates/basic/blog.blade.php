@extends($activeTemplate . 'layouts.frontend')
@section('content')
@php $userPageBg = getContent('user_page_bg.content', true); @endphp


    <section class="pt-100 pb-100 overlay--one bg_img" style="background-image: url('{{ frontendImage('user_page_bg', @$userPageBg->data_values->background_image, '1920x1080') }}');">
        <div class="container">
            <div class="row justify-content-center mb-none-30">
                @forelse($blogs as $blog)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="blog-card">
                            <div class="blog-card__thumb">
                                <img src="{{ frontendImage('blog', @$blog->data_values->image, '430x280', thumb:true) }}"
                                    alt="@lang('image')">
                            </div>
                            <div class="blog-card__content">
                                <h4 class="blog-card__title mb-3"><a
                                        href="{{ route('blog.details', @$blog->slug) }}">{{ __(strLimit(@$blog->data_values->title, 66)) }}</a>
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
                                    <p class="mb-3">{{ __(strLimit($excerpt, 180)) }}</p>
                                @endif
                                    <a class="btn btn--base mt-3 see-more" href="{{ route('blog.details', @$blog->slug) }}">@lang('Read More') <i class="las la-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center"> {{ __(@$emptyMessage) }}</div>
                @endforelse

            </div>
            @if ($blogs->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ paginateLinks($blogs) }}
                </div>
            @endif
        </div>
    </section>
    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
