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
            'carousel' => ['title' => 'Home carousel', 'model' => \App\Models\NahauSlide::class, 'orderBy' => 'slot', 'cols' => ['slot', 'kind', 'title', 'days_left'], 'fields' => [
                ['slot', 'Slot (order on Home; slot 4 uses the cream Bibi Titi colour)', 'select', 'required|integer|between:1,4', fn () => [1 => 'Slot 1', 2 => 'Slot 2', 3 => 'Slot 3', 4 => 'Slot 4']],
                ['kind', 'What is this slide?', 'select', 'required|in:hero,book', fn () => ['hero' => 'Hero', 'book' => 'Book'], 'Up to 2 heroes and 2 books in the carousel.'],
                ['hero_id', 'Hero', 'select', 'nullable|exists:nahau_heroes,id', fn () => \App\Models\NahauHero::orderBy('name')->pluck('name', 'id')->all(), 'Add the hero first under Carousel > Hero profiles.', 'kind=hero'],
                ['news_id', 'Book (fiction story)', 'select', 'nullable|integer', fn () => $newsIn(['fiction']), null, 'kind=book'],
                ['kicker', 'Small label above the title (e.g. New book)', 'text', 'nullable|max:60', null, null, 'kind=book'],
                ['headline', 'Title (leave empty to use the name or book title)', 'text', 'nullable|max:160'],
                ['summary', 'Summary (max 320)', 'textarea', 'nullable|max:320'],
                ['image', 'Image (hero portrait or book cover; optional)', 'image', 'nullable|image|max:4096'],
                ['days', 'Days to show on Home (minimum 4)', 'number', 'required|integer|min:4|max:365', null, 'You get an alert 2 days before it ends, to add days or replace it.']]],
            'heroes' => ['title' => 'Hero profiles', 'model' => \App\Models\NahauHero::class, 'cols' => ['name', 'country', 'show_in_spotlight', 'spotlight_order'], 'fields' => [
                ['news_id', 'Story (African Heroes news item)', 'select', 'required|integer', fn () => $newsIn(['african-heroes'])], ['name', 'Name', 'text', 'required|max:160'],
                ['spotlight_summary', 'Summary (shown under the name, max 320)', 'textarea', 'nullable|max:320', null, 'Shown under the name on the hero page and on the Home spotlight.'],
                ['born', 'Born', 'text', 'nullable|max:40'], ['died', 'Died', 'text', 'nullable|max:40'], ['country', 'Country', 'text', 'nullable|max:80'],
                ['spotlight_order', 'Spotlight order', 'number', 'nullable|integer'],
                ['portrait', 'Portrait', 'image', 'nullable|image|max:4096'], ['portrait_credit', 'Portrait credit and licence', 'text', 'nullable|max:200'], ['sources', 'Sources (one per line: title | URL)', 'textarea', 'nullable']]],
            'opportunities' => ['title' => 'Opportunities', 'model' => \App\Models\NahauOpportunity::class, 'cols' => ['title', 'type', 'employer', 'closing_date', 'status'],
                'tabs' => ['Msingi' => ['title', 'type', 'work_mode', 'employer', 'location', 'terms', 'description', 'closing_date'], 'Maelezo ya kazi' => ['about', 'responsibilities', 'qualifications', 'benefits'],
                    'Kuomba' => ['apply_link', 'apply_notes', 'employer_logo', 'employer_about'], 'Uchapishaji' => ['verified_by', 'verified_on', 'status', 'featured']],
                'fields' => [
                ['title', 'Title', 'text', 'required|max:160'], ['type', 'Type (job, internship, training, grant)', 'select', 'required', fn () => config('nahau.opportunity_types')],
                ['work_mode', 'Work mode', 'select', 'nullable|in:full-time,part-time,remote,hybrid', fn () => \App\Models\NahauOpportunity::WORK_MODES],
                ['employer', 'Employer or organisation', 'text', 'required|max:160'], ['location', 'Location', 'text', 'required|max:120'],
                ['terms', 'Pay or duration (optional, e.g. TZS 200,000 a month, 3 months)', 'text', 'nullable|max:120', null, 'Leave empty when the job does not state it. It is then hidden everywhere.'],
                ['description', 'Short summary shown on the card (max 300)', 'textarea', 'required|max:300'], ['closing_date', 'Closing date', 'date', 'required|date'],
                ['about', 'About the position', 'textarea', 'nullable|max:5000', null, 'Write it freely. A new line starts a new paragraph.'],
                ['responsibilities', 'Key responsibilities', 'textarea', 'nullable|max:5000', null, 'One responsibility per line. Each line becomes a bullet.'],
                ['qualifications', 'Qualifications and requirements', 'textarea', 'nullable|max:5000', null, 'One requirement per line. Each line becomes a bullet.'],
                ['benefits', 'Remuneration and benefits', 'textarea', 'nullable|max:3000', null, 'One item per line.'],
                ['apply_link', 'Apply URL (the employer\'s page, or an email address)', 'text', 'required|max:500', null, 'The "Apply" button sends the reader to this link. Use the employer\'s own site.'],
                ['apply_notes', 'Application requirements', 'textarea', 'nullable|max:3000', null, 'For example: CV, cover letter, two references.'],
                ['employer_logo', 'Employer logo', 'image', 'nullable|image|max:2048'], ['employer_about', 'About the employer', 'textarea', 'nullable|max:2000'],
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
                ['reading_minutes', 'Reading time (minutes, auto if empty)', 'number', 'nullable|integer'], ['featured', 'Featured on Home (only one)', 'checkbox', 'nullable'], ['series_id', 'Series', 'select', 'nullable', fn () => \App\Models\NahauSeries::orderBy('title')->pluck('title', 'id')->all()], ['chapter_no', 'Chapter number', 'number', 'nullable|integer'],
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
        abort_unless(\App\Nahau\Panel::canRes($res), 403);

        return $d + ['create' => true, 'edit' => true, 'show' => []];
    }

    public function dashboard()
    {
        return redirect()->route('admin.dashboard');
    }

    public function index(string $res)
    {
        $d = $this->def($res);
        $q = $d['model']::query();
        $rows = ($res === 'stories'
            ? $q->join('news', 'news.id', '=', 'nahau_story_meta.news_id')->select('nahau_story_meta.*', 'news.title as news_title')->orderByDesc('news.id')
            : $q->orderBy(...(isset($d['orderBy']) ? [$d['orderBy']] : ['id', 'desc'])))->paginate(25);

        return view('nahau-admin.resource', compact('d', 'res', 'rows'));
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

        return $this->form($r, $d, $res, $row);
    }

    protected function form(Request $r, array $d, string $res, $row)
    {
        $data = compact('d', 'res', 'row');

        return $r->ajax()
            ? view('nahau-admin.resource-form', $data)
            : view('nahau-admin.page', ['partial' => 'nahau-admin.resource-form', 'data' => $data, 'title' => $d['title']]);
    }

    public function edit(Request $r, string $res, int $id)
    {
        $d = $this->def($res);
        abort_unless($d['edit'], 404);
        $row = $d['model']::findOrFail($id);

        return $this->form($r, $d, $res, $row);
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
        if ($res === 'carousel') {
            $rules['slot'] = ['required', 'integer', 'between:1,4', \Illuminate\Validation\Rule::unique('nahau_carousel', 'slot')->ignore($row->id)];
            $rules['hero_id'] = 'required_if:kind,hero|nullable|exists:nahau_heroes,id';
            $rules['news_id'] = 'required_if:kind,book|nullable|integer';
        }
        $data = $r->validate($rules, $res === 'carousel' ? ['slot.unique' => 'This slot is already used. Pick another slot or edit that one.', 'days.min' => 'A slide must stay at least 4 days.', 'hero_id.required_if' => 'Choose the hero.', 'news_id.required_if' => 'Choose the book.'] : []);
        if ($res === 'carousel') {
            $same = \App\Models\NahauSlide::where('kind', $data['kind'])->where('id', '!=', $row->id ?? 0)->count();
            if ($same >= 2) {
                $msg = 'The carousel already has 2 '.($data['kind'] === 'hero' ? 'heroes' : 'books').'. Remove one first.';

                return $r->expectsJson() ? response()->json(['message' => $msg, 'errors' => ['kind' => [$msg]]], 422) : back()->withInput()->withErrors(['kind' => $msg]);
            }
        }

        foreach ($d['fields'] as $f) {
            [$name, , $type] = $f;
            if ($type === 'checkbox' || $type === 'radio') {
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

        foreach (['home_order', 'spotlight_order', 'sort'] as $k) {   // ordering columns are NOT NULL
            if (array_key_exists($k, $data) && $data[$k] === null) {
                $data[$k] = 0;
            }
        }

        if ($res === 'opportunities') {
            if (($data['status'] ?? '') === 'published' && (empty($data['verified_by']) || empty($data['verified_on']))) {
                $msg = 'Fursa haiwezi kuchapishwa hadi "Verified by" na "Verified on" zijazwe.';
                if ($r->expectsJson()) {
                    return response()->json(['message' => $msg, 'errors' => ['verified_by' => [$msg]]], 422);
                }

                return back()->withInput()->withErrors(['verified_by' => $msg]);
            }
            $data['slug'] = $row->slug ?: Str::slug($data['title']).'-'.Str::lower(Str::random(4));
            if (($data['status'] ?? '') === 'published' && ! $row->published_at) {
                $data['published_at'] = now();   // the "Posted … ago" and "New" badge count from here
            }
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

        if ($res === 'carousel') {
            $data[$data['kind'] === 'hero' ? 'news_id' : 'hero_id'] = null;
            $start = $row->starts_at ?: now();
            $data['starts_at'] = $start;
            $data['ends_at'] = $start->copy()->addDays((int) $data['days']);
        }

        $row->fill($data)->save();

        if ($r->expectsJson()) {
            return response()->json(['message' => 'Imehifadhiwa']);
        }

        return redirect()->route('admin.nahau.index', $res)->with('success', 'Saved.');
    }

    /** "Add days" from the alert: push the end date out (or restart an expired slide). */
    public function extendSlide(Request $r, int $id)
    {
        abort_unless(\App\Nahau\Panel::canRes('carousel'), 403);
        $add = max(\App\Models\NahauSlide::MIN_DAYS, min(90, (int) $r->input('days', 7)));
        $s = \App\Models\NahauSlide::findOrFail($id);
        $from = $s->ends_at && $s->ends_at->isFuture() ? $s->ends_at : now();
        $s->ends_at = $from->copy()->addDays($add);
        $s->days = (int) ceil(($s->starts_at ?? now())->diffInHours($s->ends_at) / 24);
        $s->save();

        return back()->with('success', 'Siku '.$add.' zimeongezwa.');
    }

    /** One-click Visible/Hidden switch from the list table. */
    public function toggle(Request $r, string $res, int $id, string $field)
    {
        $d = $this->def($res);
        abort_unless(in_array($field, ['show_in_spotlight', 'show_on_home', 'featured'], true) && ($d['edit'] ?? true) !== false, 404);
        abort_unless(in_array($field, $d['cols'], true), 404);
        $row = $d['model']::findOrFail($id);
        $row->{$field} = $r->boolean('value') ? 1 : 0;
        $row->save();

        return response()->json(['message' => $row->{$field} ? 'Inaonekana' : 'Imefichwa', 'value' => (int) $row->{$field}]);
    }

    public function destroy(Request $r, string $res, int $id)
    {
        $d = $this->def($res);
        abort_if($res === 'stories', 404);
        $d['model']::findOrFail($id)->delete();

        if ($r->expectsJson()) {
            return response()->json(['message' => 'Imefutwa']);
        }

        return redirect()->route('admin.nahau.index', $res)->with('success', 'Deleted.');
    }
}
