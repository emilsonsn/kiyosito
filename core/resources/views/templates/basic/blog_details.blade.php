@extends($activeTemplate . 'layouts.frontend')

@php
    $nicHtml = $blog->data_values->description_nic ?? '';
    $nicHtml = preg_replace('/<br\s*\/?>/i', '', $nicHtml);
    $nicHtml = htmlspecialchars($nicHtml, ENT_HTML5 | ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true);
@endphp

@section('content')
    <section class="pt-100 pb-100 custom--bg-two">
        <div class="container">
            <div class="row">
                <!-- Main Content (10 columns) -->
                <div class="col-lg-custom-10 pr-lg-3">
                    <div class="blog-details-wrapper">
                        <div class="blog-details__thumb">
                            <div class="image-container">
                                <img src="{{ frontendImage('blog', @$blog->data_values->image, '860x570') }}" 
                                     alt="image"
                                     class="centered-image">
                                <div class="post__date">
                                    <span class="date">{{ showDateTime($blog->created_at, 'd') }}</span>
                                    <span class="month">{{ showDateTime($blog->created_at, 'M') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="blog-details__content">
                            <div class="embedded-content-wrapper">
                                <iframe 
                                    srcdoc="{!! $nicHtml !!}"
                                    style="width: 100%; height: 100vh; border: none;"
                                    sandbox="allow-same-origin"
                                    scrolling="yes"
                                    loading="eager"
                                    onload="this.style.visibility='visible'"
                                ></iframe>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts (2 columns) -->
                <div class="col-lg-custom-2 pl-lg-3">
                    <div class="sidebar">
                        <div class="widget">
                            <h3 class="widget-title">@lang('Recent Blog Posts')</h3>
                            <ul class="small-post-list">
                                @foreach ($recentBlogs as $item)
                                    <li class="small-post-single">
                                        <div class="thumb">
                                            <img src="{{ frontendImage('blog', @$item->data_values->image, '430x280', thumb: true) }}" alt="image">
                                        </div>
                                        <div class="content">
                                            <h6 class="post-title">
                                                <a href="{{ route('blog.details', $item->slug) }}">
                                                    {{ __(strLimit(@$item->data_values->title, 80)) }}</a>
                                            </h6>
                                            <small>{{ showDateTime($item->created_at) }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
<style>
    /* Custom Grid */
    @media (min-width: 992px) {
        .col-lg-custom-10 {
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
        }
        .col-lg-custom-2 {
            flex: 0 0 16.666667%;
            max-width: 16.666667%;
        }
    }

    /* Image Centering */
    .blog-details__thumb {
        max-width: 860px;
        margin: 0 auto 40px;
        position: relative;
    }

    .image-container {
        position: relative;
        padding-top: 66.28%; /* 570/860 aspect ratio */
        overflow: hidden;
    }

    .centered-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post__date {
        position: absolute;
        bottom: 20px;
        left: 20px;
        z-index: 2;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
    }

    @media (max-width: 991px) {
        .blog-details__thumb {
            max-width: 100%;
            margin: 0 0 30px;
        }
        .image-container {
            padding-top: 56.25%; /* 16:9 fallback */
        }
    }
</style>
@endpush

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush
