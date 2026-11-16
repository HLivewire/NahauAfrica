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
        if (!$mode) { foreach (\App\Models\NahauOpportunity::WORK_MODES as $k => $lbl) { if (stripos((string) $o->terms, $lbl) !== false || stripos((string) $o->terms, str_replace('-', ' ', $k)) !== false) { $mode = $lbl; break; } } }
    @endphp
    <article class="nx-opp nx-opp--{{ $o->type }}{{ $o->isNew() ? ' is-new' : '' }}" id="opp-{{ $o->id }}">
        <div class="nx-opp-logo">@if($o->employer_logo)<img src="{{ media_url($o->employer_logo) }}" alt="">@else<span>{{ mb_strtoupper(mb_substr($o->employer, 0, 1)) }}</span>@endif</div>
        <div class="nx-opp-main">
            <div class="nx-opp-chips">
                @if($o->isNew())<span class="nx-new">{!! nxi('spark') !!}{{ __('New') }}</span>@endif
                <span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? ucfirst($o->type)) }}</span>
                @if($mode)<span class="nx-mode">{!! nxi('brief') !!}{{ __($mode) }}</span>@endif
                @if($left >= 0 && $left <= 7)<span class="nx-soon">{!! nxi('bolt') !!}{{ $left === 0 ? __('Closes today') : trans_choice('{1} Closes in 1 day|[2,*] Closes in :n days', $left, ['n' => $left]) }}</span>@endif
            </div>
            <h3><a href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ $o->title }}</a></h3>
            <p class="nx-opp-emp">{{ $o->employer }}</p>
            <ul class="nx-opp-meta">
                <li>{!! nxi('pin') !!}{{ $o->location }}</li>
                @if($o->terms && (!$mode || stripos($o->terms, $mode) === false))<li>{!! nxi('tag') !!}{{ $o->terms }}</li>@endif
                <li>{!! nxi('clock') !!}{{ __('Posted') }} {{ nposted($o->postedAt()) }}</li>
            </ul>
            <p class="nx-opp-sum">{{ $o->description }}</p>
        </div>
        <div class="nx-side">
            <span class="nx-deadline">{!! nxi('cal') !!}<span>{{ __('Closes') }} <strong>{{ ndate($o->closing_date) }}</strong></span></span>
            <a class="nx-btn nx-btn--sm" href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ __('View job') }}</a>
        </div>
    </article>
    @endforeach
@endif
