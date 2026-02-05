@php
    $roadmapContent = getContent('roadmap.content', true);
    // When included from home.blade.php we pass $homeSecs to build a "site summary" (anchors).
    $homeSecs = $homeSecs ?? [];

    $labelMap = [
        'about'             => 'Technical Memorandum',
        'ico_meaning'       => 'Overview',
        'feature'           => 'Ecosystem',
        'token_distribution'=> 'Token Distribution',
        'fund_allocation'   => 'Fund Allocation',
        'faq'               => 'FAQ',
        'blog'              => 'Research / Blog',
        'subscribe'         => 'Subscribe',
        'phase'             => 'ICO Calendar',
    ];
@endphp

<!-- roadmap section start -->
<section class="pt-100 pb-100 bg_img overlay--one"
style="background-image: url('{{ frontendImage('roadmap', @$roadmapContent->data_values->image, '1800x1200') }}');"
data-paroller-factor="0.3"
>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-6 text-center">
      <div class="section-header">
        <h2 class="section-title">{{ __(@$roadmapContent->data_values->heading) }}</h2>
        <p class="mt-3">{{ __(@$roadmapContent->data_values->subheading) }}</p>
      </div>
    </div>
  </div><!-- row end -->
  <div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="roadmap-wrapper">
            <div class="single-roadmap wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.2s">
                <div class="roadmap-dot"></div>
                <h4 class="title mb-3">Site Summary</h4>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="#top" class="btn btn--base btn-sm">@lang('Top')</a>
                    @foreach ($homeSecs as $sec)
                        @continue($sec === 'roadmap')
                        @php
                            $label = $labelMap[$sec] ?? ucwords(str_replace('_', ' ', $sec));
                        @endphp
                        <a href="#sec-{{ $sec }}" class="btn btn-outline--base btn-sm">{{ __($label) }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</section>
