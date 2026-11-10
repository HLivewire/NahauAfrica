<p class="nx-count">{{ $list->count() }} {{ trans_choice('{1} open opportunity|[0,*] open opportunities', $list->count()) }}</p>
@if($list->isEmpty())
    <p class="nx-empty">{{ __('No open opportunities in this category right now. Check back soon.') }}</p>
@else
    @foreach($list as $o)
    @php $isMail = filter_var($o->apply_link, FILTER_VALIDATE_EMAIL); @endphp
    <article class="nx-opp nx-s-jobs-careers" id="opp-{{ $o->id }}">
        <div>
            <span class="nx-badge">{{ __(config('nahau.opportunity_types')[$o->type] ?? ucfirst($o->type)) }}</span>
            <h3><a href="{{ nroute('opportunity',['slug'=>$o->slug]) }}">{{ $o->title }}</a></h3>
            <p class="nx-meta" style="margin-bottom:6px">{{ $o->employer }} · {{ $o->location }} · {{ $o->terms }}</p>
            <p style="color:#4A4A4A;font-size:16px">{{ $o->description }}</p>
        </div>
        <div class="nx-side">
            <span class="nx-meta"><strong>{{ __('Closes') }} {{ ndate($o->closing_date) }}</strong></span>
            <a class="nx-btn nx-btn--sm" data-nx-track="opportunity_apply_click" data-id="{{ $o->id }}" href="{{ $isMail ? 'mailto:'.$o->apply_link : $o->apply_link }}" target="_blank" rel="noopener nofollow">{{ __("Apply on employer's site") }} ↗</a>
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
