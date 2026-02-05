<label>@lang('Referral Link')</label>
<div class="input-group">
<input type="text" name="key"
    value="{{ route('home') }}?reference={{ auth()->user()->username }}"
    class="form-control form--control referralURL" readonly>
<button type="button" class="input-group-text copytext" id="copyBoard"> <i class="fa fa-copy"></i> </button>
</div>


@push('style')
    <style>
        .copied::after {
            background-color: #{{gs()->base_color }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
