@php
    $privacyPolicy = getContent('policy_pages.content', true);
@endphp
@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="overlay--one bg_img"
        style="background-image: url('{{ frontendImage('policy_pages', @$privacyPolicy->data_values->image, '1900x1000') }}');">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                @php
                    echo @$policy->data_values->details
                @endphp
            </div>
        </div>

    </div>
</section>
@endsection
