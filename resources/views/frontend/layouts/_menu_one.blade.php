@foreach( newscategories() as $newscategory )
    @if($newscategory->menu_publish)
        <li>
            @if(array_key_exists($newscategory->slug, config('nahau.sections')))
                <a href="{{ nroute($newscategory->slug) }}">{{ nsection($newscategory->slug, 'name') }}</a>
            @else
                <a href="{{ route($newscategory->slug,strtolower($newscategory->name)) }}">{{ $newscategory->name  }} </a>
            @endif
        </li>
    @endif
@endforeach
