<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauOpportunity;
use App\Nahau\Stories;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function show(Request $request, string $section)
    {
        $cfg = config("nahau.sections.$section");
        abort_unless($cfg, 404);

        $format = in_array($request->query('format'), $cfg['formats'], true)
            ? $request->query('format')
            : (collect($cfg['formats'])->first(fn ($f) => \Illuminate\Support\Str::slug($f) === $request->query('format')));
        $q = trim((string) $request->query('q', ''));

        $query = Stories::inSection($section)->reorder();
        if ($format) {
            $query->where('m.format', $format);
        }
        if ($q !== '') {
            $like = '%'.str_replace(['%', '_'], ['\%', '\_'], $q).'%';
            $query->where(function ($w) use ($like) {
                $w->where('news.title', 'like', $like)->orWhere('m.dek', 'like', $like)
                    ->orWhere('news.summary', 'like', $like)->orWhere('a.name', 'like', $like)
                    ->orWhere('news.tags', 'like', $like);
            });
        }
        // Site language first, other language after (with a language tag on the card)
        $query->orderByRaw("CASE WHEN COALESCE(m.language,'en') = ? THEN 0 ELSE 1 END", [nlocale()])
            ->orderByDesc('news.date')->orderByDesc('news.id');

        $stories = $query->paginate(12)->withQueryString();

        if ($request->ajax() || $request->header('X-Nahau-Fragment')) {
            return view('nahau.partials.results', compact('section', 'cfg', 'stories', 'format', 'q'));
        }

        return view('nahau.section', compact('section', 'cfg', 'stories', 'format', 'q'));
    }

    public function opportunities(Request $request)
    {
        $type = array_key_exists($request->query('type'), config('nahau.opportunity_types')) ? $request->query('type') : null;
        $list = NahauOpportunity::open()->when($type, fn ($q) => $q->where('type', $type))
            ->orderBy('closing_date')->orderBy('id')->get();

        $view = $request->ajax() ? 'nahau.partials.opportunity_list' : 'nahau.opportunities';

        return view($view, ['section' => 'jobs-careers', 'cfg' => config('nahau.sections.jobs-careers'), 'list' => $list, 'type' => $type]);
    }

    public function opportunity(string $slug)
    {
        $o = NahauOpportunity::open()->where('slug', $slug)->firstOrFail();

        return view('nahau.opportunity', ['o' => $o, 'section' => 'jobs-careers', 'cfg' => config('nahau.sections.jobs-careers')]);
    }
}
