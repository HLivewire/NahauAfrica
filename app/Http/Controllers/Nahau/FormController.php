<?php

namespace App\Http\Controllers\Nahau;

use App\Http\Controllers\Controller;
use App\Models\NahauMessage;
use App\Models\NahauOpportunity;
use App\Models\NahauOpportunityReport;
use App\Models\NahauOpportunitySubmission;
use App\Models\NahauSubmission;
use App\Models\NahauSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /** Honeypot: bots fill the hidden field; pretend success without saving. */
    protected function isBot(Request $r): bool
    {
        return filled($r->input('nx_website'));
    }

    protected function mail(string $to, string $subject, string $body): void
    {
        try {
            Mail::raw($body, fn ($m) => $m->to($to)->subject($subject));
        } catch (\Throwable $e) {
            report($e);   // never break the form because mail is not configured yet
        }
    }

    protected function messages(): array
    {
        return [
            'required' => __('Please fill in this field.'),
            'email' => __('Please enter an email address like name@example.com'),
            'accepted' => __('Please tick this box to continue.'),
            'url' => __('Please enter a full web address starting with https://'),
            'date' => __('Please enter a valid date.'),
            'max.file' => __('The file is too large. Please keep it under 10 MB.'),
            'mimes' => __('Please attach a .doc, .docx or .pdf file.'),
        ];
    }

    public function submitStory(Request $r)
    {
        if ($this->isBot($r)) {
            return back()->with('nahau_ok', ['first' => 'friend']);
        }
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'section' => 'required|in:'.implode(',', array_keys(config('nahau.sections'))),
            'language' => 'required|in:English,Kiswahili,Both',
            'title' => 'required|string|max:160',
            'summary' => 'nullable|string|max:700',
            'body' => 'required_without:file|nullable|string|max:200000',
            'file' => 'nullable|file|mimes:doc,docx,pdf|max:10240',
            'original' => 'accepted',
            'consent' => 'nullable|boolean',
            'published_before' => 'nullable|boolean',
        ], $this->messages() + ['body.required_without' => __('Please paste your story or attach a file.')]);

        $ref = 'NA-'.now()->format('ymd').'-'.strtoupper(Str::random(4));
        $path = $r->hasFile('file') ? $r->file('file')->store('nahau-submissions') : null;   // private disk, never public

        NahauSubmission::create([
            'reference' => $ref, 'name' => $data['name'], 'email' => $data['email'], 'section' => $data['section'],
            'language' => $data['language'], 'title' => $data['title'], 'summary' => $data['summary'] ?? null,
            'body' => $data['body'] ?? null, 'file_path' => $path, 'original' => true,
            'consent' => $r->boolean('consent'), 'published_before' => $r->boolean('published_before'),
        ]);

        $weeks = config('nahau.reply_weeks');
        $this->mail(config('nahau.editor_email'), "New story submission $ref", "{$data['name']} <{$data['email']}> sent \"{$data['title']}\" ({$data['section']}, {$data['language']}).");
        $this->mail($data['email'], 'We received your story — Nahau Africa', "Asante, {$data['name']}.\n\nWe received \"{$data['title']}\". Your reference is $ref.\nOur editors will review it and reply within about $weeks weeks.\n\nNahau Africa — Our Stories. Our Voices.");

        return back()->with('nahau_ok', ['first' => Str::before($data['name'], ' '), 'ref' => $ref]);
    }

    public function contact(Request $r)
    {
        if ($this->isBot($r)) {
            return back()->with('nahau_ok', true);
        }
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'reason' => 'required|in:'.implode(',', config('nahau.contact_reasons')),
            'page_url' => 'nullable|url|max:300',
            'message' => 'required|string|max:5000',
        ], $this->messages());

        NahauMessage::create($data);
        $this->mail(config('nahau.contact_email'), '['.$data['reason'].'] from '.$data['name'], $data['message']."\n\n".($data['page_url'] ?? '')."\nReply to: ".$data['email']);
        $this->mail($data['email'], 'We received your message — Nahau Africa', "Hello {$data['name']},\n\nThank you for writing to Nahau Africa. We read every message and will reply soon.");

        return back()->with('nahau_ok', true);
    }

    public function submitOpportunity(Request $r)
    {
        if ($this->isBot($r)) {
            return back()->with('nahau_opp_ok', true);
        }
        $data = $r->validate([
            'organisation' => 'required|string|max:160', 'contact_person' => 'required|string|max:120',
            'email' => 'required|email|max:160', 'phone' => 'required|string|max:40', 'website' => 'nullable|url|max:200',
            'title' => 'required|string|max:160', 'type' => 'required|in:'.implode(',', array_keys(config('nahau.opportunity_types'))),
            'location' => 'required|string|max:120', 'terms' => 'required|string|max:120', 'description' => 'required|string|max:300',
            'apply_link' => ['required', 'string', 'max:300', function ($a, $v, $fail) {
                if (! filter_var($v, FILTER_VALIDATE_EMAIL) && ! filter_var($v, FILTER_VALIDATE_URL)) {
                    $fail(__('Please enter the employer\'s web address or email.'));
                }
            }],
            'closing_date' => 'required|date|after_or_equal:today', 'confirm' => 'accepted',
        ], $this->messages());
        unset($data['confirm']);

        NahauOpportunitySubmission::create($data);
        $this->mail(config('nahau.editor_email'), 'New opportunity to verify: '.$data['title'], "{$data['organisation']} / {$data['contact_person']} <{$data['email']}> {$data['phone']}");
        $this->mail($data['email'], 'Your opportunity will be checked — Nahau Africa', "Thank you, {$data['contact_person']}. We verify every advert with the employer before it is published.");

        return back()->with('nahau_opp_ok', true);
    }

    public function report(Request $r, int $id)
    {
        $o = NahauOpportunity::findOrFail($id);
        if (! $this->isBot($r)) {
            $data = $r->validate(['reason' => 'required|in:'.implode(',', config('nahau.report_reasons')), 'details' => 'nullable|string|max:1000'], $this->messages());
            NahauOpportunityReport::create(['opportunity_id' => $o->id] + $data);
            if ($o->reports()->count() >= NahauOpportunity::HIDE_AFTER_REPORTS && $o->status === 'published') {
                $o->update(['status' => 'hidden']);   // hidden until an editor reviews it
            }
            $this->mail(config('nahau.editor_email'), 'Advert reported: '.$o->title, "Reason: {$data['reason']}\n".($data['details'] ?? ''));
        }

        if ($r->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('nahau_reported', $o->id);
    }

    public function subscribe(Request $r)
    {
        if ($this->isBot($r)) {
            return $this->subscribed($r);
        }
        $data = $r->validate(['email' => 'required|email|max:160', 'language' => 'nullable|in:en,sw'], $this->messages());
        $sub = NahauSubscriber::firstOrNew(['email' => strtolower($data['email'])]);
        if (! $sub->exists || ! $sub->confirmed_at) {
            $sub->language = $data['language'] ?? nlocale();
            $sub->token = Str::random(40);
            $sub->consent_text = 'I agree to receive stories and updates from Nahau Africa by email.';
            $sub->unsubscribed_at = null;
            $sub->save();
            $link = route('nahau.newsletter.confirm', $sub->token);
            $this->mail($sub->email, 'Please confirm your subscription — Nahau Africa', "Asante! Please confirm your email to join the list:\n$link\n\nIf this wasn't you, ignore this message.");
        }

        return $this->subscribed($r);
    }

    protected function subscribed(Request $r)
    {
        return $r->expectsJson() ? response()->json(['ok' => true]) : back()->with('nahau_subscribed', true);
    }

    public function confirm(string $token)
    {
        $sub = NahauSubscriber::where('token', $token)->firstOrFail();
        $sub->update(['confirmed_at' => $sub->confirmed_at ?: now(), 'unsubscribed_at' => null]);

        return redirect(nroute('home', [], $sub->language))->with('nahau_notice', __("Asante! You're on the list — look out for our next story."));
    }

    public function unsubscribe(string $token)
    {
        $sub = NahauSubscriber::where('token', $token)->firstOrFail();
        $sub->update(['unsubscribed_at' => now()]);

        return redirect(nroute('home', [], $sub->language))->with('nahau_notice', __('You have been unsubscribed.'));
    }
}
