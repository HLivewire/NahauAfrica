<div class="nx-formbox" style="max-width:900px">
@if(session('nahau_opp_ok'))
    <div class="nx-ok" role="status"><h3>{{ __('Thank you — we will check your advert.') }}</h3><p>{{ __('We verify every advert with the employer before it is published. We will email you once it is checked.') }}</p></div>
@else
    <h3 style="font-size:28px;margin-bottom:6px">{{ __('Submit an opportunity') }}</h3>
    <p class="nx-meta" style="margin-bottom:24px">{{ __('Fields marked * are required.') }}</p>
    <form method="POST" action="{{ route('nahau.opportunity.store') }}" class="nx-form" novalidate>
        @csrf @include('nahau.partials.hp')
        @php $f = fn($n,$l,$t='text',$req=true) => compact('n','l','t','req'); @endphp
        <div class="nx-formgrid">
        @foreach([['organisation','Organisation'],['contact_person','Contact person'],['email','Work email','email'],['phone','Phone','tel'],['website','Organisation website','url',false],['title','Opportunity title']] as $row)
            @php [$n,$l,$t,$req] = [$row[0],$row[1],$row[2] ?? 'text',$row[3] ?? true]; @endphp
            <div class="nx-field"><label for="o-{{ $n }}">{{ __($l) }}{{ $req ? ' *' : '' }}</label><input id="o-{{ $n }}" class="nx-input" type="{{ $t }}" name="{{ $n }}" value="{{ old($n) }}" aria-describedby="e-{{ $n }}">@include('nahau.partials.field_error',['f'=>$n])</div>
        @endforeach
            <div class="nx-field"><label for="o-type">{{ __('Type') }} *</label><select id="o-type" name="type" class="nx-input">@foreach(config('nahau.opportunity_types') as $k=>$l)<option value="{{ $k }}" @selected(old('type')===$k)>{{ __($l) }}</option>@endforeach</select></div>
            <div class="nx-field"><label for="o-location">{{ __('Location') }} *</label><input id="o-location" class="nx-input" name="location" value="{{ old('location') }}">@include('nahau.partials.field_error',['f'=>'location'])</div>
            <div class="nx-field"><label for="o-terms">{{ __('Terms') }} *</label><input id="o-terms" class="nx-input" name="terms" value="{{ old('terms') }}" placeholder="Full-time / Free, 8 weeks">@include('nahau.partials.field_error',['f'=>'terms'])</div>
        </div>
        <div class="nx-field"><label for="o-description">{{ __('Description (max 300 characters)') }} *</label><textarea id="o-description" class="nx-input" name="description" rows="3" maxlength="300">{{ old('description') }}</textarea>@include('nahau.partials.field_error',['f'=>'description'])</div>
        <div class="nx-formgrid">
            <div class="nx-field"><label for="o-apply">{{ __('Apply link or email') }} *</label><input id="o-apply" class="nx-input" name="apply_link" value="{{ old('apply_link') }}">@include('nahau.partials.field_error',['f'=>'apply_link'])</div>
            <div class="nx-field"><label for="o-closing">{{ __('Closing date') }} *</label><input id="o-closing" class="nx-input" type="date" name="closing_date" value="{{ old('closing_date') }}">@include('nahau.partials.field_error',['f'=>'closing_date'])</div>
        </div>
        <div><label class="nx-check"><input type="checkbox" name="confirm" value="1" @checked(old('confirm'))><span>{{ __('I confirm applicants are never charged.') }} *</span></label>@include('nahau.partials.field_error',['f'=>'confirm'])</div>
        <p class="nx-meta"><a href="{{ nroute('privacy') }}" style="text-decoration:underline">{{ __('Privacy notice') }}</a></p>
        <div><button class="nx-btn" type="submit">{{ __('Submit for checking') }}</button></div>
    </form>
@endif
</div>
