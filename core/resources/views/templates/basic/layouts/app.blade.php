<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{asset('assets/global/css/iziToast_custom.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    @stack('style-lib')

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ gs()->base_color }}&secondColor={{ gs()->secondary_color }}">
</head>

                    
<!-- Container where React will mount the modal -->
<div id="gittu-presale-modal-root" style="position: relative;"></div>
                    
<!-- Gittu Widget JS Bundle -->
<script src="{{ asset('assets/js/gittu-widget/widget.js') }}?v={{ time() }}"></script>

<body>
    @stack('fbComment')

    <div class="cursor"></div>
    <div class="cursor-follower"></div>

    <div class="preloader-holder">
        <div class="preloader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="body-overlay"></div>

    <!-- scroll-to-top start -->
    <div class="scroll-to-top">
        <span class="scroll-icon">
            <i class="fa fa-rocket" aria-hidden="true"></i>
        </span>
    </div>

    @yield('panel')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if (@$cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card custom--card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4 cookies-card__content text-white">
                {{ @$cookie->data_values->short_desc }}
                <a href="{{ route('cookie.policy') }}" class="text--base" target="_blank">
                    @lang('learn more')
                </a>
            </p>
            <div class="cookies-card__btn mt-4">
                <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
            </div>
        </div>
        <!-- cookies dark version end -->
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lightcase.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/tween-max.min.js') }}"></script>
    <!-- Main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')

    @php echo loadExtension('tawk-chat') @endphp

    @if (gs('pn'))
        @include('partials.push_script')
    @endif

    @stack('script')

    @include('partials.notify')

    <script>
        (function($) {

            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            $('.select2').select2();

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
                matched = event.matches;
                if (matched) {
                    $('body').addClass('dark-mode');
                    $('.navbar').addClass('navbar-dark');
                } else {
                    $('body').removeClass('dark-mode');
                    $('.navbar').removeClass('navbar-dark');
                }
            });

            let matched = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (matched) {
                $('body').addClass('dark-mode');
                $('.navbar').addClass('navbar-dark');
            } else {
                $('body').removeClass('dark-mode');
                $('.navbar').removeClass('navbar-dark');
            }


            var inputElements = $('[type=text],[type=password],[type=email],[type=number],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);


            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });


            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }

            });

            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

        })(jQuery);
    </script>

    <!--{{-- Show welcome modal only on homepage --}}-->
    <!--@if(request()->routeIs('home'))-->
    <!--<script>-->
    <!--    $(document).ready(function () {-->
    <!--        if (!sessionStorage.getItem("welcomeModalShown")) {-->
    <!--            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));-->
    <!--            welcomeModal.show();-->
    <!--            sessionStorage.setItem("welcomeModalShown", "true");-->
    <!--        }-->
    <!--    });-->
    <!--</script>-->
    <!--@endif-->
    
    <!--@if(request()->routeIs('home'))-->
    <!-- Welcome Modal -->
    <!--<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">-->
    <!--  <div class="modal-dialog modal-dialog-centered">-->
    <!--    <div class="modal-content text-center" style="background-color: #303030;">-->
    <!--      <div class="modal-header" style="background-color: #303030;">-->
    <!--        <h5 class="modal-title w-100 text-white" style="color: #fa6050 !important;" id="welcomeModalLabel">ITŌ Phase 1: SOLD OUT!</h5>-->
    <!--      </div>-->
    <!--      <div class="modal-body">-->
    <!--        <p>All 50 million ITO tokens from our first presale round were sold out in just 67 minutes!<br>-->
    <!--        Thank you for the overwhelming support and trust.<br><br>-->
    <!--        Phase 2 is coming soon — stay tuned!</p>-->
    <!--      </div>-->
    <!--      <div class="modal-footer justify-content-center">-->
    <!--        <button type="button" class="btn text-white" style="background-color: #fa6050;" data-bs-dismiss="modal">Close</button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!--@endif-->
    
    <?php 
    /*
    {{-- Show welcome modal only on homepage --}}
    
    @if(request()->routeIs('home'))
    <script>
        $(document).ready(function () {
            if (!sessionStorage.getItem("welcomeModalShown")) {
                var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
                welcomeModal.show();
                sessionStorage.setItem("welcomeModalShown", "true");
            }
        });
    </script>
    @endif
    
    @if(request()->routeIs('home'))
     Welcome Modal 
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center" style="background-color: #303030;">
          <div class="modal-header" style="background-color: #303030;">
            <h5 class="modal-title w-100 text-white" style="color: #fa6050 !important;" id="welcomeModalLabel">
              Special Support for Large Investors
            </h5>
          </div>
          <div class="modal-body text-center px-4">
            <p class="mb-3">
              To those looking to acquire <strong>US$10,000.00 or more</strong> in ITO tokens:
            </p>
    
            <p class="mb-4">
              If you experience any difficulties with the transaction process,<br>
              contact us via WhatsApp:<br>
              <strong style="font-size: 1.1rem;">+55 11 91289-1333</strong>
            </p>
    
            <div class="text-start mx-auto" style="max-width: 380px;">
              <p class="mb-2">Our development team will assist you in:</p>
              <ul class="list-unstyled ps-3">
                <li>• Creating a wallet</li>
                <li>• Transferring ITOs to your wallet</li>
                <li>• Visualizing your tokens in your wallet <strong>before making any payment</strong></li>
                <li>• Completing the payment via your preferred method (including Pix)</li>
              </ul>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn text-white" style="background-color: #fa6050;" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    @endif
    ?>

    <!--@if(request()->routeIs('home'))-->
    <!--<script>-->
    <!--    $(document).ready(function () {-->
    <!--        if (!sessionStorage.getItem("welcomeModalShown")) {-->
    <!--            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));-->
    <!--            welcomeModal.show();-->
    <!--            sessionStorage.setItem("welcomeModalShown", "true");-->
    <!--        }-->
    <!--    });-->
    <!--</script>-->
    <!--@endif-->
    
    <!--@if(request()->routeIs('home'))-->
    <!-- Large Investors Support Modal -->
    <!--<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">-->
    <!--  <div class="modal-dialog modal-dialog-centered">-->
    <!--    <div class="modal-content text-white" style="background-color: #1e1e1e; border-radius: 12px;">-->
    <!--      <div class="modal-header border-0">-->
    <!--        <h5 class="modal-title w-100 text-center" style="color: #fa6050; font-weight: bold;" id="welcomeModalLabel">-->
    <!--          <i class="bi bi-info-circle-fill me-2"></i>Special Support for Large Investors-->
    <!--        </h5>-->
    <!--      </div>-->
    <!--      <div class="modal-body text-center px-4">-->
    <!--        <p class="mb-3">-->
    <!--          To those looking to acquire <strong>US$10,000.00 or more</strong> in ITO tokens:-->
    <!--        </p>-->
    
    <!--        <p class="mb-4">-->
    <!--          If you experience any difficulties with the transaction process,<br>-->
    <!--          contact us via WhatsApp:<br>-->
    <!--          <strong style="font-size: 1.1rem;">+55 11 91289-1333</strong>-->
    <!--        </p>-->
    
    <!--        <div class="text-start mx-auto" style="max-width: 380px;">-->
    <!--          <p class="mb-2">Our development team will assist you in:</p>-->
    <!--          <ul class="list-unstyled ps-3">-->
    <!--            <li>• Creating a wallet</li>-->
    <!--            <li>• Transferring ITOs to your wallet</li>-->
    <!--            <li>• Visualizing your tokens in your wallet <strong>before making any payment</strong></li>-->
    <!--            <li>• Completing the payment via your preferred method (including Pix)</li>-->
    <!--          </ul>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="modal-footer border-0 justify-content-center">-->
    <!--        <button type="button" class="btn text-white px-4" style="background-color: #fa6050; border-radius: 6px;" data-bs-dismiss="modal">-->
    <!--          Close-->
    <!--        </button>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->
    <!--@endif-->


</body>

</html>
