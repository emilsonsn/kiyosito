@php
    $subscribeContent = getContent('subscribe.content', true);
@endphp

<!-- subscribe section start -->
<div class="pt-100 pb-100 bg_img"
    style="background-image: url('{{ frontendImage('subscribe', @$subscribeContent->data_values->image, '1920x865') }}')">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="subscribe-wrapper text-center">
                    <h2 class="title">{{ __(@$subscribeContent->data_values->heading) }}</h2>
                    <p>{{ __(@$subscribeContent->data_values->subheading) }}</p>
                    <form class="subscribe-form mt-4" method="post" id="subscribe">
                        @csrf
                        <input type="email" required name="email" class="form-control email"
                            placeholder="Enter email address">
                        <button type="submit" class="subscribe-btn">@lang('Subscribe Now') <i
                                class="far fa-paper-plane ms-2"></i></button>
                    </form>
                </div><!-- subscribe-wrapper end -->
            </div>
        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript">
        $('.subscribe-form').on('submit', function(e) {
            e.preventDefault();
            let url = `{{ route('subscribe') }}`;

            let data = {
                email: $(this).find('input[name=email]').val()
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': `{{ csrf_token() }}`
                }
            });
            $.post(url, data, function(response) {
                if (response.error) {
                    $('.subscribe-form').trigger("reset");
                    notify('error', response.error);
                } else {
                    $('.subscribe-form').trigger("reset");
                    notify('success', response.success);
                }
            });
            this.reset();
        })
    </script>
@endpush
