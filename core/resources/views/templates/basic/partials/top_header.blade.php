@php
    $contactContent = getContent('contact_us.content', true);
    $language = App\Models\Language::all();
    $selectedLang = $language->where('code', session('lang'))->first();
@endphp

<div class="header__top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8 col-sm-8">
                <div class="top-info d-flex flex-wrap align-items-center justify-content-md-start justify-content-center text-white font-size--12px">
                    <a href="tel:{{ @$contactContent->data_values->phone }}" class="me-3">
                        <i class="las la-phone-volume font-size--18px"></i>
                        <span class="font-size--14px">
                            {{ @$contactContent->data_values->phone }}
                        </span>
                    </a>
                    <a href="mailto:{{ @$contactContent->data_values->email }}">
                        <i class="las la-envelope font-size--18px"></i>
                        <span class="font-size--14px">{{ @$contactContent->data_values->email }}</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-4 text-sm-end text-center">
                @if (gs('multi_language'))
                            <div class="dropdown-lang dropdown mt-0 d-none d-sm-block">
                                <a href="#" class="language-btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img class="flag"
                                        src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                                        alt="us">
                                    <span class="language-text text-white">{{ @$selectedLang->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($language as $lang)
                                        <li><a href="{{ route('lang', $lang->code) }}"><img class="flag"
                                                    src="{{ getImage(getFilePath('language') . '/' . @$lang->image, getFileSize('language')) }}"
                                                    alt="@lang('image')">
                                                {{ @$lang->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif
            </div>
        </div>
    </div>
</div>
