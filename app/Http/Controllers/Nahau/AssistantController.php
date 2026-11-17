<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauOpportunity;
use App\Nahau\Stories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/** Floating "Ask Nahau" helper. Uses Claude when ANTHROPIC_API_KEY is set, otherwise a built-in guide. */
class AssistantController extends Controller
{
    public function ask(Request $r)
    {
        $q = trim((string) $r->input('message', ''));
        abort_if($q === '' || mb_strlen($q) > 500, 422);
        app()->setLocale($r->input('lang') === 'sw' ? 'sw' : 'en');
        $sw = nlocale() === 'sw';

        $links = [];
        $reply = null;
        if (config('nahau.assistant.key')) {
            $reply = $this->claude($q, $sw);
        }
        [$fallback, $links] = $this->guide($q, $sw);

        return response()->json(['reply' => $reply ?: $fallback, 'links' => $links]);
    }

    private function claude(string $q, bool $sw): ?string
    {
        $opps = NahauOpportunity::where('status', 'published')->latest('id')->limit(8)->get(['title', 'employer', 'location', 'type', 'closing_date'])
            ->map(fn ($o) => "- {$o->title} ({$o->type}) at {$o->employer}, {$o->location}, closes {$o->closing_date}")->implode("\n");
        $system = "You are Nahau, the friendly help assistant of NahauAfrica, a Tanzanian/African storytelling site (fiction, relationships, jobs & opportunities, African heroes). "
            ."Help readers find stories, understand how to apply for jobs, internships, grants and training (they apply on the employer's own site; we never charge fees), submit a story (Write for Us page) or contact the team (Contact page). "
            ."Answer briefly (max 4 short sentences) in ".($sw ? 'Kiswahili' : 'English').". Never invent listings; use only these open opportunities:\n".($opps ?: '(none right now)');
        try {
            $res = Http::withHeaders(['x-api-key' => config('nahau.assistant.key'), 'anthropic-version' => '2023-06-01'])->timeout(15)
                ->post('https://api.anthropic.com/v1/messages', ['model' => config('nahau.assistant.model'), 'max_tokens' => 350, 'system' => $system, 'messages' => [['role' => 'user', 'content' => $q]]]);

            return $res->ok() ? trim((string) data_get($res->json(), 'content.0.text')) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function guide(string $q, bool $sw): array
    {
        $t = mb_strtolower($q);
        $has = fn (array $w) => collect($w)->contains(fn ($x) => str_contains($t, $x));
        $links = [];

        if ($has(['apply', 'omba', 'kuomba', 'job', 'kazi', 'internship', 'grant', 'ruzuku', 'training', 'mafunzo', 'opportun', 'fursa'])) {
            foreach (NahauOpportunity::where('status', 'published')->latest('id')->limit(3)->get() as $o) {
                $links[] = ['title' => $o->title.' — '.$o->employer, 'url' => nroute('opportunity', ['slug' => $o->slug])];
            }
            $links[] = ['title' => $sw ? 'Fursa zote' : 'All opportunities', 'url' => nroute('opportunities')];

            return [$sw ? 'Fungua kazi unayoipenda, soma sifa zinazohitajika, kisha bonyeza "Omba sasa" ili kuendelea kwenye tovuti ya mwajiri. Nahau Africa haitozi ada yoyote ya kuomba.' : 'Open the job you like, read the requirements, then press "Apply now" to continue on the employer\'s own site. Nahau Africa never charges a fee to apply.', $links];
        }
        if ($has(['write', 'submit', 'andika', 'tuma', 'story', 'hadithi yangu'])) {
            return [$sw ? 'Unaweza kututumia hadithi yako kupitia ukurasa wa "Write for Us". Wahariri wetu watairejea kabla ya kuchapishwa.' : 'You can send us your story on the "Write for Us" page. Our editors review every submission before it is published.', [['title' => 'Write for Us', 'url' => nroute('write')]]];
        }
        if ($has(['contact', 'wasiliana', 'help', 'msaada', 'email', 'report', 'ripoti'])) {
            return [$sw ? 'Tuandikie kupitia ukurasa wa Mawasiliano na tutakujibu haraka iwezekanavyo.' : 'Write to us on the Contact page and we will reply as soon as we can.', [['title' => $sw ? 'Wasiliana nasi' : 'Contact us', 'url' => nroute('contact')]]];
        }
        $words = collect(preg_split('/\W+/u', $t))->filter(fn ($w) => mb_strlen($w) > 3)->take(4);
        if ($words->isNotEmpty()) {
            $q2 = Stories::query();
            $q2->where(function ($w) use ($words) { foreach ($words as $x) { $w->orWhere('news.title', 'like', "%$x%"); } });
            foreach ($q2->limit(3)->get() as $s) { $links[] = ['title' => $s->title, 'url' => Stories::url($s)]; }
        }
        if ($links) {
            return [$sw ? 'Nimepata hadithi hizi zinazoweza kukufaa:' : 'I found these stories that may help:', $links];
        }

        return [$sw ? 'Naweza kukusaidia kupata hadithi, kuomba kazi, kutuma hadithi yako au kuwasiliana nasi. Unahitaji nini?' : 'I can help you find stories, apply for opportunities, submit your own story or contact the team. What do you need?', [['title' => $sw ? 'Fursa' : 'Opportunities', 'url' => nroute('opportunities')], ['title' => $sw ? 'Hadithi' : 'Stories', 'url' => nroute('fiction')]]];
    }
}
