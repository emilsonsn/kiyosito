@php
    $teamMemberContent = getContent('team_member.content', true);
    $teamMemberElement = getContent('team_member.element', orderById: true);
@endphp
<!-- team section start -->
<section class="pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$teamMemberContent->data_values->heading) }}</h2>
                    <p class="mt-3">
                        {{ __(@$teamMemberContent->data_values->subheading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-none-30">
            @foreach($teamMemberElement as $member)
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-30 wow fadeInUp" data-wow-duration="0.5s"
                    data-wow-delay="0.3s">
                    <!-- Wrap the team card with an anchor tag -->
                    <a href="{{ @$member->data_values->profile_link }}" target="_blank" style="text-decoration: none; color: inherit;">
                        <div class="team-card h-100"
                            style="background-image: url('{{ getImage($activeTemplateTrue.'images/team/team-bg.jpg') }}')">
                            <div class="team-card__thumb">
                                <img src="{{ frontendImage('team_member', @$member->data_values->image, '275x335') }}" alt="image" class="rounded-3 w-100">
                            </div>
                            <div class="team-card__content text-center">
                                <h3 class="name">{{ __(@$member->data_values->name) }}</h3>
                                <span class="designation">{{ __(@$member->data_values->designation) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>