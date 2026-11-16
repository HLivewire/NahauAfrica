<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NahauStoryMeta;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newssubcategory;
use App\Nahau\Panel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/** All stories (Fiction, Relationships, Jobs, African Heroes): one list, one modal form for the story and its extra details. */
class StoriesAdminController extends Controller
{
    private function sections(): array
    {
        return collect(config('nahau.sections'))->mapWithKeys(fn ($s, $k) => [$k => $s['name']['en']])->all();
    }

    private function base()
    {
        $q = News::query()
            ->join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
            ->join('newscategories', 'newssubcategories.category_id', '=', 'newscategories.id')
            ->leftJoin('nahau_story_meta as m', 'm.news_id', '=', 'news.id')
            ->leftJoin('nahau_authors as a', 'a.id', '=', 'm.author_id')
            ->whereIn('newscategories.slug', array_keys($this->sections()))
            ->select('news.id', 'news.title', 'news.status', 'news.date', 'news.viewers', 'news.image', 'news.user_id', 'newscategories.name as section',
                'm.language', 'm.featured', 'a.name as author_name');
        if (Panel::letter() === 'C') {   // a Contributor only sees their own work
            $q->where('news.user_id', auth()->id());
        }

        return $q;
    }

    public function index(Request $r)
    {
        $q = $this->base();
        if ($s = trim((string) $r->query('q'))) {
            $q->where('news.title', 'like', "%{$s}%");
        }
        if (in_array($r->query('status'), ['0', '1'], true)) {
            $q->where('news.status', (int) $r->query('status'));
        }
        if (in_array($r->query('lang'), ['sw', 'en'], true)) {
            $q->where('m.language', $r->query('lang'));
        }
        if ($sec = $r->query('section')) {
            $q->where('newscategories.slug', $sec);
        }
        $rows = $q->orderByDesc('news.date')->orderByDesc('news.id')->paginate(20)->withQueryString();

        return view('nahau-admin.stories', ['rows' => $rows, 'sections' => $this->sections(), 'f' => $r->only('q', 'status', 'lang', 'section')]);
    }

    private function form(Request $r, ?News $news)
    {
        $meta = $news ? NahauStoryMeta::firstOrNew(['news_id' => $news->id]) : new NahauStoryMeta(['language' => 'sw', 'label' => 'Fiction']);
        $section = $news ? Newscategory::whereIn('id', Newssubcategory::where('id', $news->subcategory_id)->pluck('category_id'))->value('slug') : null;
        $data = [
            'news' => $news, 'meta' => $meta, 'section' => $section, 'sections' => $this->sections(),
            'labels' => array_combine(config('nahau.labels'), config('nahau.labels')),
            'authors' => \App\Models\NahauAuthor::orderBy('name')->pluck('name', 'id')->all(),
            'series' => \App\Models\NahauSeries::orderBy('title')->pluck('title', 'id')->all(),
            'others' => $this->base()->when($news, fn ($q) => $q->where('news.id', '!=', $news->id))->orderByDesc('news.id')->limit(300)->pluck('news.title', 'news.id')->all(),
            'canPublish' => in_array(Panel::letter(), ['A', 'E'], true),
        ];

        return $r->ajax()
            ? view('nahau-admin.story-form', $data)
            : view('nahau-admin.page', ['partial' => 'nahau-admin.story-form', 'data' => $data, 'title' => 'Hadithi']);
    }

    public function create(Request $r)
    {
        return $this->form($r, null);
    }

    public function edit(Request $r, int $id)
    {
        $news = $this->base()->where('news.id', $id)->firstOrFail();

        return $this->form($r, News::findOrFail($news->id));
    }

    public function store(Request $r)
    {
        return $this->save($r, new News);
    }

    public function update(Request $r, int $id)
    {
        $this->base()->where('news.id', $id)->firstOrFail();   // respects "own stories only"

        return $this->save($r, News::findOrFail($id));
    }

    private function save(Request $r, News $news)
    {
        $exists = $news->exists;
        $d = $r->validate([
            'title' => 'required|max:255', 'language' => ['required', Rule::in(['sw', 'en'])],
            'section' => ['required', Rule::in(array_keys($this->sections()))], 'label' => ['required', Rule::in(config('nahau.labels'))],
            'summary' => 'required|max:255', 'description' => 'required', 'date' => 'required|date', 'status' => 'nullable|in:0,1',
            'author_id' => 'nullable|integer', 'series_id' => 'nullable|integer', 'chapter_no' => 'nullable|integer', 'translation_of' => 'nullable|integer',
            'tags' => 'nullable|max:50', 'meta_description' => 'nullable|max:300', 'format' => 'nullable|max:60',
            'image' => 'nullable|image|max:4096', 'image_alt' => 'nullable|max:250', 'image_caption' => 'nullable|max:250', 'image_credit' => 'nullable|max:250',
            'sponsored_by' => 'nullable|max:160', 'corrections' => 'nullable',
        ]);
        $publish = Panel::letter() && in_array(Panel::letter(), ['A', 'E'], true);

        $cat = Newscategory::where('slug', $d['section'])->firstOrFail();
        $sub = Newssubcategory::where('category_id', $cat->id)->orderBy('id')->firstOrFail();
        $row = [
            'title' => $d['title'], 'summary' => trim($d['summary']), 'description' => trim($d['description']),
            'subcategory_id' => $sub->id, 'date' => date('Y-m-d', strtotime($d['date'])), 'tags' => $d['tags'] ?? null,
            'meta_keyword' => $d['tags'] ?? null, 'meta_description' => ($d['meta_description'] ?? null) ?: Str::limit(trim($d['summary']), 290),
            'status' => $publish ? (int) ($d['status'] ?? 0) : ($exists ? $news->status : 0),
        ];
        if (! $exists) {
            $row += ['speciality_id' => 1, 'reporter_id' => auth()->id(), 'user_id' => auth()->id(), 'breaking_news' => 0, 'viewers' => 0];
        }
        if ($r->hasFile('image')) {
            $path = imageUpload($r->file('image'), 'public/uploads/images/nahau/', null, uniqid('nahau_'));
            $row['image'] = json_encode([$path]);
        } elseif (! $exists) {
            $row['image'] = json_encode('');
        }
        $news->fill($row)->save();

        $meta = NahauStoryMeta::firstOrNew(['news_id' => $news->id]);
        $slug = $meta->slug ?: Str::slug($d['title']) ?: 'story';
        if (! $meta->exists && NahauStoryMeta::where('slug', $slug)->exists()) {
            $slug .= '-'.$news->id;
        }
        $feat = $publish && $r->boolean('featured');
        if ($feat) {
            NahauStoryMeta::where('news_id', '!=', $news->id)->update(['featured' => false]);   // only one featured story
        }
        $meta->fill([
            'slug' => $slug, 'format' => $d['format'] ?? null, 'label' => $d['label'], 'language' => $d['language'], 'dek' => Str::limit(trim($d['summary']), 215, ''),
            'reading_minutes' => nreading($d['description']), 'author_id' => $d['author_id'] ?? null, 'series_id' => $d['series_id'] ?? null,
            'chapter_no' => $d['chapter_no'] ?? null, 'translation_of' => $d['translation_of'] ?? null,
            'featured' => $publish ? $feat : (bool) $meta->featured,
            'image_alt' => $d['image_alt'] ?? null, 'image_caption' => $d['image_caption'] ?? null, 'image_credit' => $d['image_credit'] ?? null,
            'sponsored_by' => $d['sponsored_by'] ?? null, 'consent_on_file' => $r->boolean('consent_on_file'), 'corrections' => $d['corrections'] ?? null,
        ])->save();

        return response()->json(['message' => $exists ? 'Hadithi imehifadhiwa' : 'Hadithi imeongezwa']);
    }

    public function destroy(int $id)
    {
        abort_unless(in_array(Panel::letter(), ['A', 'E'], true), 403);
        $news = News::findOrFail($this->base()->where('news.id', $id)->firstOrFail()->id);
        NahauStoryMeta::where('news_id', $news->id)->delete();
        $news->delete();

        return response()->json(['message' => 'Hadithi imefutwa']);
    }
}
