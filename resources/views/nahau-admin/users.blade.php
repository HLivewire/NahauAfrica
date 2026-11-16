@extends('nahau-admin.layout')
@section('title', 'Users na Roles')
@section('content')
<div class="ph"><div><h2>Users na Roles</h2><p>Watu wanaoweza kuingia admin, na wanachoweza kufanya.</p></div><div class="sp"></div>
  <button class="btn" data-modal="{{ route('admin.panel.users.create') }}">{!! \App\Nahau\Icons::svg('userplus') !!}Alika mtumiaji</button></div>
<div class="card"><div class="tw"><table>
  <thead><tr><th>Mtumiaji</th><th>Role</th><th>Hali</th><th></th></tr></thead><tbody>
  @foreach($users as $x)
    <tr><td><div class="cell"><span class="mini">{{ strtoupper(mb_substr($x->first_name,0,1)) }}</span><div><div class="t">{{ trim($x->first_name.' '.$x->last_name) }}</div><div class="s">{{ $x->email }}</div></div></div></td>
      <td><span class="bdg pr">{{ \App\Nahau\Panel::roleName($x) }}</span></td>
      <td>@if(!$x->is_active)<span class="bdg er">Amezimwa</span>@elseif($x->must_change_password)<span class="bdg wr">Anasubiri kubadilisha nenosiri</span>@else<span class="bdg ok">Yuko hai</span>@endif</td>
      <td><div class="act"><button class="btn sm sec" data-modal="{{ route('admin.panel.users.edit', $x) }}">{!! \App\Nahau\Icons::svg('edit','sm') !!}Role</button>
        @if($x->id !== auth()->id())<button class="btn sm dng ico" aria-label="Futa" data-del="{{ route('admin.panel.users.destroy', $x) }}" data-name="{{ trim($x->first_name.' '.$x->last_name) }}">{!! \App\Nahau\Icons::svg('trash','sm') !!}</button>@endif</div></td></tr>
  @endforeach
  </tbody></table></div></div>
<div class="card"><h4>Ruhusa za kila role</h4>
<div class="tw" style="margin-top:10px"><table class="matrix"><thead><tr><th>Kazi</th><th>Administrator</th><th>Editor-in-Chief</th><th>Section editor</th><th>Translator</th><th>Contributor</th></tr></thead><tbody>
@foreach([['Hadithi na Series','AES TA' ],['Heroes, Opportunities, Pages, Team','AE'],['Authors','AES'],['Inbox (submissions)','AES'],['Ujumbe na maombi ya fursa','AE'],['Subscribers, Settings, SEO, Users','A']] as [$l,$p])
  @php $p = str_replace(' ','',$p); if ($l === 'Hadithi na Series') $p = 'AEST'; @endphp
  <tr><td>{{ $l }}</td>@foreach(['A','E','S','T','C'] as $k)<td>@if(str_contains($p,$k))<span class="y">✓</span>@else<span class="n">–</span>@endif</td>@endforeach</tr>
@endforeach
</tbody></table></div></div>
@endsection
