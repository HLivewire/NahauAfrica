<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NahauStoryMeta;
use App\Nahau\Stories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * One compact admin screen set for all NahauAfrica content types
 * (stories' extra fields, authors, series, heroes, opportunities, inboxes, pages, team).
 */
class NahauAdminController extends Controller
{
    protected function defs(): array
    {
        $sections = collect(config('nahau.sections'))->mapWithKeys(fn ($s, $k) => [$k => $s['name']['en']])->all();
        $newsIn = fn (array $keys) => News::query()
            ->join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
            ->join('newscategories', 'newssubcategories.category_id', '=', 'newscategories.id')
            ->whereIn('newscategories.slug', $keys)->orderByDesc('news.id')->pluck('news.title', 'news.id')->all();
        $authors = fn () => \App\Models\NahauAuthor::orderBy('name')->pluck('name', 'id')->all();
        $labels = array_combine(config('nahau.labels'), config('nahau.labels'));

        return [
            'authors' => ['title' => 'Authors', 'model' => \App\Models\NahauAuthor::class, 'cols' => ['name', 'role', 'city', 'show_on_home'], 'fields' => [
                ['name', 'Name', 'text', 'required|max:120'], ['slug', 'Slug (auto if empty)', 'text', 'nullable|alpha_dash|max:120'], ['role', 'Role', 'text', 'nullable|max:120'], ['city', 'City', 'text', 'nullable|max:120'],
                ['bio', 'Biography (max 120 words)', 'textarea', 'nullable|max:1200'], ['photo', 'Photo', 'image', 'nullable|image|max:4096'], ['email', 'Email (private)', 'text', 'nullable|email'],
                ['website', 'Website', 'text', 'nullable|url'], ['show_on_home', 'Show in "Meet the voices"', 'checkbox', 'nullable'], ['home_order', 'Home order', 'number', 'nullable|integer']]],
            'series' => ['title' => 'Series', 'model' => \App\Models\NahauSeries::class, 'cols' => ['title', 'title_sw', 'featured'], 'fields' => [
                ['title', 'Title (English)', 'text', 'required|max:160'], ['title_sw', 'Title (Kiswahili)', 'text', 'nullable|max:160'], ['slug', 'Slug (auto if empty)', 'text', 'nullable|alpha_dash'],
                ['description', 'Description', 'textarea', 'nullable'], ['cover', 'Cover image', 'image', 'nullable|image|max:4096'], ['author_id', 'Author', 'select', 'nullable', $authors],
                ['rhythm', 'Publishing rhythm', 'text', 'nullable|max:160'], ['featured', 'Featured on Home', 'checkbox', 'nullable'], ['next_chapter_date', 'Next chapter date', 'date', 'nullable|date']]],
            'heroes' => ['title' => 'Hero profiles', 'model' => \App\Models\NahauHero::class, 'cols' => ['name', 'country', 'show_in_spotlight', 'spotlight_order'], 'fields' => [
                ['news_id', 'Story (African Heroes news item)', 'select', 'required|integer', fn () => $newsIn(['african-heroes'])], ['name', 'Name', 'text', 'required|max:160'], ['born', 'Born', 'text', 'nullable|max:40'], ['died', 'Died', 'text', 'nullable|max:40'],
                ['country', 'Country', 'text', 'nullable|max:80'], ['known_for', 'Known for (one line)', 'text', 'nullable|max:200'], ['spotlight_summary', 'Home spotlight summary (max 220)', 'textarea', 'nullable|max:220'],
                ['show_in_spotlight', 'Show in Home spotlight', 'checkbox', 'nullable'], ['spotlight_order', 'Spotlight order', 'number', 'nullable|integer'],
                ['portrait', 'Portrait', 'image', 'nullable|image|max:4096'], ['portrait_credit', 'Portrait credit and licence', 'text', 'nullable|max:200'], ['sources', 'Sources (one per line: title | URL)', 'textarea', 'nullable']]],
            'opportunities' => ['title' => 'Opportunities', 'model' => \App\Models\NahauOpportunity::class, 'cols' => ['title', 'type', 'employer', 'closing_date', 'status'], 'fields' => [
                ['title', 'Title', 'text', 'required|max:160'], ['type', 'Type', 'select', 'required', fn () => config('nahau.opportunity_types')], ['employer', 'Employer or organisation', 'text', 'required|max:160'],
                ['location', 'Location', 'text', 'required|max:120'], ['terms', 'Terms', 'text', 'required|max:120'], ['description', 'Description (max 300)', 'textarea', 'required|max:300'],
                ['apply_link', 'Apply link or email (employer\'s own channel)', 'text', 'required|max:300'], ['closing_date', 'Closing date', 'date', 'required|date'],
                ['verified_by', 'Verified by', 'text', 'nullable|max:120'], ['verified_on', 'Verified on', 'date', 'nullable|date'],
                ['status', 'Status', 'select', 'required', fn () => ['draft' => 'Draft', 'published' => 'Published', 'hidden' => 'Hidden']], ['featured', 'Featured', 'checkbox', 'nullable']]],
            'submissions' => ['title' => 'Story submissions', 'model' => \App\Models\NahauSubmission::class, 'create' => false, 'cols' => ['reference', 'name', 'title', 'section', 'status', 'created_at'], 'fields' => [
                ['status', 'Status', 'select', 'required', fn () => ['new' => 'New', 'under_review' => 'Under review', 'revisions' => 'Revisions requested', 'accepted' => 'Accepted', 'declined' => 'Declined']], ['notes', 'Editor notes', 'textarea', 'nullable']],
                'show' => ['reference', 'name', 'email', 'section', 'language', 'title', 'summary', 'body', 'original', 'consent', 'published_before']],
            'messages' => ['title' => 'Contact messages', 'model' => \App\Models\NahauMessage::class, 'create' => false, 'cols' => ['name', 'email', 'reason', 'status', 'created_at'], 'fields' => [
                ['status', 'Status', 'select', 'required', fn () => ['new' => 'New', 'answered' => 'Answered', 'closed' => 'Closed']]], 'show' => ['name', 'email', 'reason', 'page_url', 'message']],
            'opportunity-submissions' => ['title' => 'Opportunity submissions', 'model' => \App\Models\NahauOpportunitySubmission::class, 'create' => false, 'cols' => ['organisation', 'title', 'type', 'closing_date', 'status'], 'fields' => [
                ['status', 'Status', 'select', 'required', fn () => ['new' => 'New', 'verifying' => 'Verifying', 'listed' => 'Listed', 'declined' => 'Declined']]], 'show' => ['organisation', 'contact_person', 'email', 'phone', 'website', 'title', 'type', 'location', 'terms', 'description', 'apply_link', 'closing_date']],
            'subscribers' => ['title' => 'Newsletter subscribers', 'model' => \App\Models\NahauSubscriber::class, 'create' => false, 'edit' => false, 'cols' => ['email', 'language', 'confirmed_at', 'unsubscribed_at'], 'fields' => []],
            'pages' => ['title' => 'Policy pages', 'model' => \App\Models\NahauPage::class, 'cols' => ['slug', 'title_en', 'title_sw'], 'fields' => [
                ['slug', 'Slug', 'text', 'required|alpha_dash'], ['title_en', 'Title (English)', 'text', 'required'], ['title_sw', 'Title (Kiswahili)', 'text', 'nullable'],
                ['body_en', 'Text (English, HTML)', 'textarea', 'nullable'], ['body_sw', 'Text (Kiswahili, HTML)', 'textarea', 'nullable']]],
            'team' => ['title' => 'Team members', 'model' => \App\Models\NahauTeam::class, 'cols' => ['name', 'role', 'sort'], 'fields' => [
                ['name', 'Name', 'text', 'required'], ['role', 'Role', 'text', 'required'], ['photo', 'Photo', 'image', 'nullable|image|max:4096'], ['sort', 'Order', 'number', 'nullable|integer']]],
            // Extra fields for a news row that sits in a Nahau section. Edited via /admin/nahau/stories/{news}
            'stories' => ['title' => 'Story details', 'model' => NahauStoryMeta::class, 'create' => false, 'cols' => ['slug', 'format', 'label', 'language', 'featured'], 'fields' => [
                ['format', 'Format', 'text', 'nullable|max:60'], ['label', 'Content label', 'select', 'required', fn () => $labels], ['language', 'Language', 'select', 'required', fn () => ['en' => 'English', 'sw' => 'Kiswahili']],
                ['dek', 'Dek / standfirst (max 220)', 'textarea', 'nullable|max:220'], ['slug', 'Slug', 'text', 'required|alpha_dash|max:120'], ['author_id', 'Author', 'select', 'nullable', $authors],
                ['reading_minutes', 'Reading time (minutes, auto if empty)', 'number', 'nullable|integer'], ['featured', 'Featured on Home (only one)', 'checkbox', 'nullable'],
                ['series_id', 'Series', 'select', 'nullable', fn () => \App\Models\NahauSeries::orderBy('title')->pluck('title', 'id')->all()], ['chapter_no', 'Chapter number', 'number', 'nullable|integer'],
                ['translation_of', 'Translation of (story)', 'select', 'nullable', fn () => $newsIn(array_keys(config('nahau.sections')))],
                ['image_alt', 'Lead image alt text', 'text', 'nullable|max:250'], ['image_caption', 'Lead image caption', 'text', 'nullable|max:250'], ['image_credit', 'Lead image credit', 'text', 'nullable|max:250'],
                ['sponsored_by', 'Sponsored by (partner name)', 'text', 'nullable|max:160'], ['consent_on_file', 'Consent on file (private)', 'checkbox', 'nullable'],
                ['corrections', 'Corrections (one per line: date | note)', 'textarea', 'nullable'],
                ['related_1', 'Related story 1', 'select', 'nullable', fn () => $newsIn(array_keys(config('nahau.sections')))], ['related_2', 'Related story 2', 'select', 'nullable', fn () => $newsIn(array_keys(config('nahau.sections')))], ['related_3', 'Related story 3', 'select', 'nullable', fn () => $newsIn(array_keys(config('nahau.sections')))]]],
        ];
    }

    protected function def(string $res): array
    {
        $d = $this->defs()[$res] ?? null;
        abort_unless($d, 404);

        return $d + ['create' => true, 'edit' => true, 'show' => []];
    }

    public function dashboard()
    {
        $c = [
            'New story submissions' => [\App\Models\NahauSubmission::where('status', 'new')->count(), 'submissions'],
            'Opportunities awaiting verification' => [\App\Models\NahauOpportunity::whereNull('verified_by')->count(), 'opportunities'],
            'New opportunity submissions' => [\App\Models\NahauOpportunitySubmission::where('status', 'new')->count(), 'opportunity-submissions'],
            'Reported adverts' => [\App\Models\NahauOpportunityReport::distinct('opportunity_id')->count('opportunity_id'), 'opportunities'],
            'Correction requests / new messages' => [\App\Models\NahauMessage::where('status', 'new')->count(), 'messages'],
            'Listings closing in 7 days' => [\App\Models\NahauOpportunity::open()->whereDate('closing_date', '<=', now()->addDays(7))->count(), 'opportunities'],
            'Stories without translation' => [Stories::query()->whereNull('m.translation_of')->whereNotIn('news.id', NahauStoryMeta::whereNotNull('translation_of')->pluck('translation_of'))->count(), 'stories'],
            'Confirmed subscribers' => [\App\Models\NahauSubscriber::whereNotNull('confirmed_at')->whereNull('unsubscribed_at')->count(), 'subscribers'],
        ];

        return view('admin.pages.nahau.dashboard', compact('c'));
    }

    public function index(string $res)
    {
        $d = $this->def($res);
        $q = $d['model']::query();
        $rows = ($res === 'stories'
            ? $q->join('news', 'news.id', '=', 'nahau_story_meta.news_id')->select('nahau_story_meta.*', 'news.title as news_title')->orderByDesc('news.id')
            : $q->orderByDesc('id'))->paginate(25);

        return view('admin.pages.nahau.index', compact('d', 'res', 'rows'));
    }

    public function create(Request $r, string $res)
    {
        $d = $this->def($res);
        abort_unless($d['create'], 404);
        $row = new $d['model'];
        if ($res === 'opportunities' && $r->query('from')) {
            $s = \App\Models\NahauOpportunitySubmission::find($r->query('from'));
            if ($s) {
                $row->fill($s->only(['title', 'type', 'location', 'terms', 'description', 'apply_link', 'closing_date']) + ['employer' => $s->organisation]);
            }
        }

        return view('admin.pages.nahau.form', compact('d', 'res', 'row'));
    }

    public function edit(string $res, int $id)
    {
        $d = $this->def($res);
        abort_unless($d['edit'], 404);
        $row = $d['model']::findOrFail($id);

        return view('admin.pages.nahau.form', compact('d', 'res', 'row'));
    }

    public function store(Request $r, string $res)
    {
        $d = $this->def($res);
        abort_unless($d['create'], 404);

        return $this->save($r, $res, $d, new $d['model']);
    }

    public function update(Request $r, string $res, int $id)
    {
        $d = $this->def($res);
        abort_unless($d['edit'], 404);

        return $this->save($r, $res, $d, $d['model']::findOrFail($id));
    }

    protected function save(Request $r, string $res, array $d, $row)
    {
        $rules = [];
        foreach ($d['fields'] as $f) {
            $rules[$f[0]] = $f[3];
        }
        $data = $r->validate($rules);

        foreach ($d['fields'] as $f) {
            [$name, , $type] = $f;
            if ($type === 'checkbox') {
                $data[$name] = $r->boolean($name);
            } elseif ($type === 'image') {
                unset($data[$name]);
                if ($r->hasFile($name)) {
                    $data[$name] = imageUpload($r->file($name), 'public/uploads/images/nahau/', $row->{$name} ?: null, uniqid('nahau_'));
                }
            } elseif (($data[$name] ?? null) === '') {
                $data[$name] = null;
            }
        }

        if ($res === 'opportunities') {
            if (($data['status'] ?? '') === 'published' && (empty($data['verified_by']) || empty($data['verified_on']))) {
                return back()->withInput()->withErrors(['verified_by' => 'An opportunity cannot be published until "Verified by" and "Verified on" are filled in.']);
            }
            $data['slug'] = $row->slug ?: Str::slug($data['title']).'-'.Str::lower(Str::random(4));
        }
        if (in_array($res, ['authors', 'series'], true)) {
            $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title'] ?? $data['name']);
        }
        if ($res === 'stories' && ! empty($data['featured'])) {
            NahauStoryMeta::where('id', '!=', $row->id)->update(['featured' => false]);   // only one featured story
        }
        if ($res === 'stories' && empty($data['reading_minutes'])) {
            $data['reading_minutes'] = nreading(News::find($row->news_id)?->description);
        }

        $row->fill($data)->save();

        return redirect()->route('admin.nahau.index', $res)->with('success', 'Saved.');
    }

    public function destroy(string $res, int $id)
    {
        $d = $this->def($res);
        abort_if($res === 'stories', 404);
        $d['model']::findOrFail($id)->delete();

        return redirect()->route('admin.nahau.index', $res)->with('success', 'Deleted.');
    }
}
