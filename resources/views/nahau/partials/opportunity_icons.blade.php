@php
if (! function_exists('nxi')) { function nxi($n, $c = '') { static $P = null; if ($P === null) { $P = [
 'pin' => '<path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>',
 'brief' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/>',
 'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
 'cal' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
 'spark' => '<path d="M12 2l1.9 5.6L19.5 9l-5.6 1.9L12 16.5l-1.9-5.6L4.5 9l5.6-1.4z"/><path d="M19 15l.7 2.1 2.1.7-2.1.7L19 20.6l-.7-2.1-2.1-.7 2.1-.7z"/>',
 'tag' => '<path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><path d="M7 7h.01"/>',
 'bolt' => '<path d="M13 2L3 14h9l-1 8 10-12h-9z"/>',
]; } return '<svg class="nx-i '.$c.'" viewBox="0 0 24 24" aria-hidden="true">'.($P[$n] ?? '').'</svg>'; } }
@endphp
