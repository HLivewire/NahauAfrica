@include('nahau.partials.opportunity_icons')
<p class="nx-count">{{ $list->count() }} {{ trans_choice('{1} open opportunity|[0,*] open opportunities', $list->count()) }}</p>
@if($list->isEmpty())
    <p class="nx-empty">{{ __('No open opportunities in this category right now. Check back soon.') }}</p>
@else
    @foreach($list as $o)
    @php
        $isMail = filter_var($o->apply_link, FILTER_VALIDATE_EMAIL);
        $left = $o->daysLeft();
        $mode = \App\Models\NahauOpportunity::WORK_MODES[$o->work_mode] ?? null;
    @endphp
    <article class="nx-opp nx-opp--{{ $o->type }}{{ $o->isNew() ? ' is-new' : '' }}" id="opp-{{ $o->id }}">
        <div class="nx-opp-logo">@if($o->employer_logo)<img src="{{ media_url($o->employer_logo) }}" alt="">@else<span>{{ mb_strtoupper(mb_substr($o->employer, 0, 1)) }}</span>@endif</div>
        <div class="nx-opp-main">
            <div class="nx-opp-chips">
                @if($o->isNew())<span class="nx-new">{!! nxi('spark') !!}{{ __('New') }}</span>@endif
                <span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? ucfirst($o->type)) }}</span>
                @if($left >= 0 && $left <= 7)<span class="nx-soon">{!! nxi('bolt') !!}{{ $left === 0 ? __('Closes today') : trans_choice('{1} Closes in 1 day|[2,*] Closes in :n days', $left, ['n' => $left]) }}</span>@endif
            </div>
            <h3><a href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ $o->title }}</a></h3>
            <p class="nx-opp-emp">{{ $o->employer }}</p>
            <ul class="nx-opp-meta">
                <li>{!! nxi('pin') !!}{{ $o->location }}</li>
                @if($mode)<li>{!! nxi('brief') !!}{{ __($mode) }}</li>@endif
                @if(!$mode || strcasecmp($o->terms, $mode))<li>{!! nxi('tag') !!}{{ $o->terms }}</li>@endif
                <li>{!! nxi('clock') !!}{{ __('Posted') }} {{ nposted($o->postedAt()) }}</li>
            </ul>
            <p class="nx-opp-sum">{{ $o->description }}</p>
        </div>
        <div class="nx-side">
            <span class="nx-deadline">{!! nxi('cal') !!}<span>{{ __('Closes') }} <strong>{{ ndate($o->closing_date) }}</strong></span></span>
            <a class="nx-btn nx-btn--sm" data-nx-track="opportunity_apply_click" data-id="{{ $o->id }}" href="{{ $isMail ? 'mailto:'.$o->apply_link : $o->apply_link }}" target="_blank" rel="noopener nofollow">{{ __("Apply on employer's site") }} ↗</a>
            <a class="nx-textbtn" href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ __('View details') }}</a>
            <button class="nx-textbtn" type="button" data-nx-toggle="#rep-{{ $o->id }}" aria-expanded="false">{{ __('Report this advert') }}</button>
        </div>
        <div class="nx-reportform" id="rep-{{ $o->id }}" hidden>
            @if(session('nahau_reported') == $o->id)
                <p role="status" style="font-weight:600">{{ __('Thanks — our editors will review this advert.') }}</p>
            @else
            <form method="POST" action="{{ route('nahau.report', $o->id) }}" data-nx-report class="nx-form" style="gap:14px">
                @csrf
                @include('nahau.partials.hp')
                <div class="nx-field"><label for="rr-{{ $o->id }}">{{ __('Reason') }} *</label>
                    <select id="rr-{{ $o->id }}" name="reason" class="nx-input" required>@foreach(config('nahau.report_reasons') as $r)<option value="{{ $r }}">{{ __($r) }}</option>@endforeach</select></div>
                <div class="nx-field"><label for="rd-{{ $o->id }}">{{ __('Details (optional)') }}</label><textarea id="rd-{{ $o->id }}" name="details" rows="2" class="nx-input"></textarea></div>
                <div><button class="nx-btn nx-btn--sm" type="submit">{{ __('Send report') }}</button></div>
            </form>
            @endif
        </div>
    </article>
    @endforeach
@endif
