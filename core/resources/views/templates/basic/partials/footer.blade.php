@php
    $socialIcons = getContent('social_icon.element', false, null, true);
    $policyPages = getContent('policy_pages.element', false, null, true);
    $footerContent = getContent('footer.content', true);
@endphp
<footer class="footer section-top--border scroll-section">
    <div class="footer__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="{{ route('home') }}" class="footer-logo"><img src="{{ siteLogo() }}" alt="image"></a>
                    <ul class="social-links d-flex flex-wrap align-items-center mt-4 justify-content-center">
                        @foreach ($socialIcons as $icon)
                            <li><a href="{{ @$icon->data_values->url }}" target="_blank">@php echo @$icon->data_values->social_icon @endphp</a></li>
                        @endforeach
                    </ul>
                    <div class="col-lg-8 mx-auto mt-3">
			<!--p>{{ __(@$footerContent->data_values->content) }}</p-->
			{!! __(@$footerContent->data_values->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start text-center">
                    <p> @lang('Copyright') &copy; <?php echo date('Y'); ?> . <a class="text--base"
                            href="{{ route('home') }}">{{ gs()->site_name }}</a> @lang('All Right Reserved.') </p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-menu d-flex flex-wrap justify-content-md-end justify-content-center mt-md-0 mt-1">
                        @foreach ($policyPages as $page)
                            <li><a
                                    href="{{ route('policy.pages', $page->slug) }}">{{ __(@$page->data_values->title) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
