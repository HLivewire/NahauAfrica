<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/** Every admin screen must open (no 500s) for super admin and admin. */
class NahauAdminCrawlTest extends TestCase
{
    private function urls(): array
    {
        $urls = [];
        foreach (app('router')->getRoutes() as $r) {
            $u = $r->uri();
            if (! in_array('GET', $r->methods(), true) || strpos($u, 'admin') !== 0) {
                continue;
            }
            // ajax helpers and downloads are not screens
            if (preg_match('#/ajax|publish/|logout|sitemap#', $u)) {
                continue;
            }
            if (strpos($u, '{') === false) {
                $urls[] = '/'.$u;
            }
        }
        // parameterised screens, using real rows
        foreach (['stories', 'authors', 'series', 'heroes', 'opportunities', 'submissions', 'messages', 'opportunity-submissions'] as $res) {
            $urls[] = "/admin/nahau/$res";
            $urls[] = "/admin/nahau/$res/create";
        }
        $first = fn ($t) => DB::table($t)->value('id');
        foreach ([
            ['news', 'news/edit'], ['users', 'user/edit'], ['reporters', 'reporter/edit'], ['blogs', 'blog/edit'],
            ['photogalleries', 'photogallery/edit'], ['videogalleries', 'videogallery/edit'], ['headers', 'header/edit'], ['footers', 'footer/edit'],
        ] as [$t, $p]) {
            try {
                if ($id = $first($t)) {
                    $urls[] = "/admin/$p/$id";
                }
            } catch (\Throwable $e) {
            }
        }

        return array_values(array_unique($urls));
    }

    public function test_every_admin_page_opens_for_super_admin_and_admin(): void
    {
        $failures = [];
        foreach (['4', '3'] as $type) {
            $u = User::where('user_type', $type)->first();
            $this->assertNotNull($u);
            foreach ($this->urls() as $url) {
                $res = $this->actingAs($u)->get($url);
                if ($res->getStatusCode() >= 500) {
                    $failures[] = "type $type $url -> ".$res->getStatusCode().' '.substr((string) ($res->exception?->getMessage() ?? ''), 0, 160);
                }
            }
        }
        $this->assertSame([], $failures, implode("\n", $failures));
    }
}
