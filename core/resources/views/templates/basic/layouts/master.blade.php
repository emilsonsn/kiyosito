@extends($activeTemplate . 'layouts.app')
@php $userPageBg = getContent('user_page_bg.content', true); @endphp

@section('panel')
    @include($activeTemplate . 'partials.auth_header')
    <div class="main-wrapper">
        @include($activeTemplate . 'partials.breadcrumb')
        <div class="pt-100 pb-100 overlay--one bg_img"
            style="background-image: url('{{ frontendImage('user_page_bg', @$userPageBg->data_values->background_image, '1920x1080') }}');">
            @yield('content')
        </div>
    </div>
    @stack('modal')
    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });

            //Table-data//
            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach(row => {
                    Array.from(row.querySelectorAll('td')).forEach((column, i) => {
                        (column.colSpan == 100) || column.setAttribute('data-label', heading[i]
                            .innerText)
                    });
                });
            });

            ///customize confirmation modal
            window.addEventListener('DOMContentLoaded', function(e) {
                let confirmationModal = $('#confirmationModal');
                if (confirmationModal.length > 0) {
                    $(confirmationModal).find('.close').remove();
                    $(confirmationModal).find('.modal-header').append(`<span class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>`);
                    $(confirmationModal).find('.btn--primary').addClass('btn--base btn--sm').removeClass(
                        'btn--primary');
                    $(confirmationModal).find('.btn--dark').addClass('btn--danger btn--sm').removeClass(
                        'btn--dark');
                    $(confirmationModal).find('form').attr('id', 'form')
                }
            });

        })(jQuery);
    </script>
@endpush
