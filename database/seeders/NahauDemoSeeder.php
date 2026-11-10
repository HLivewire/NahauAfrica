<?php

namespace Database\Seeders;

use App\Models\NahauAuthor;
use App\Models\NahauHero;
use App\Models\NahauOpportunity;
use App\Models\NahauSeries;
use App\Models\NahauStoryMeta;
use App\Models\NahauTeam;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newssubcategory;
use Illuminate\Database\Seeder;

/**
 * SAMPLE CONTENT ONLY - for checking the design. Do not publish.
 *   php artisan db:seed --class=NahauDemoSeeder
 * Remove later in the admin (News / Nahau screens) or with: php artisan migrate:fresh is NOT needed.
 */
class NahauDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::first();
        $spec = \Illuminate\Support\Facades\DB::table('newsspecialities')->value('id');
        if (! $user) {
            return;
        }
        if (! $spec) {
            $spec = \Illuminate\Support\Facades\DB::table('newsspecialities')->insertGetId(['name' => 'General', 'created_at' => now(), 'updated_at' => now()]);
        }

        $authors = [
            ['Juma Mwakyusa', 'juma-mwakyusa', 'Fiction writer', 'Dar es Salaam', 'Juma writes short fiction about city life, buses and the people who keep Dar moving.'],
            ['Baraka Ndege', 'baraka-ndege', 'Features writer', 'Arusha', 'Baraka writes about work, ambition and small businesses across East Africa.'],
            ['Neema Kileo', 'neema-kileo', 'Researcher', 'Mwanza', 'Neema researches the lives of African women who changed their communities.'],
        ];
        $aid = [];
        foreach ($authors as $i => [$n, $s, $r, $c, $b]) {
            $aid[] = NahauAuthor::updateOrCreate(['slug' => $s], ['name' => $n, 'role' => $r, 'city' => $c, 'bio' => $b, 'photo' => [0 => 'public/uploads/images/nahau/author_1.jpg', 1 => 'public/uploads/images/nahau/author_2.jpg'][$i] ?? null, 'show_on_home' => true, 'home_order' => $i])->id;
        }

        $series = NahauSeries::updateOrCreate(['slug' => 'mto-wa-kesho'], ['title' => 'River of Tomorrow', 'title_sw' => 'Mto wa Kesho', 'description' => 'A family on the banks of the Ruvu faces a drought, an inheritance and a secret that cannot stay buried.', 'author_id' => $aid[0], 'rhythm' => 'New chapters every second Friday', 'featured' => true, 'next_chapter_date' => now()->addDays(10)]);

        $mk = function (string $section, string $title, string $dek, string $format, string $label, int $author, array $extra = [], string $body = null) use ($user, $spec) {
            $cat = Newscategory::where('slug', $section)->first();
            if (! $cat) {
                return null;
            }
            $sub = Newssubcategory::where('category_id', $cat->id)->first();
            if (! $sub) {
                return null;
            }
            $news = News::firstOrCreate(['title' => $title], [
                'subcategory_id' => $sub->id, 'summary' => $dek, 'status' => 1, 'date' => now()->subDays(rand(1, 40))->toDateString(),
                'speciality_id' => $spec, 'image' => '["public\\/uploads\\/images\\/newsimages\\/maannewsimage18092021_101225_b-post-2.jpg"]', 'reporter_id' => $user->id, 'user_id' => $user->id,
                'description' => $body ?: '<p>The conductor of the last bus had one rule: no ticket, no seat. He had kept that rule for eleven years, through floods, elections and one unforgettable goat.</p><p>So when the woman in the blue kitenge climbed aboard with nothing but a small bag and a tired smile, he held out his hand and waited.</p><p>“I will pay you at the stand,” she said. “My brother is waiting.”</p><p>He had heard that sentence a hundred times. He opened his mouth to say so, and then the bus lurched forward and the lights of the city slid away behind them.</p>',
            ]);
            $sample = ['The Last Bus to Morogoro' => 8, 'Nyumba ya Bibi' => 4, 'River of Tomorrow · Chapter 1: The Drought' => 6, 'River of Tomorrow · Chapter 2: The Inheritance' => 7, 'River of Tomorrow · Chapter 3: What the River Kept' => 5, 'Sunday Calls with Mama' => 9, 'Two Weddings and a Funeral' => 'story_1', 'Ten Years at the Kariakoo Stall' => 'story_2', 'I Quit Banking to Farm Avocados' => 'story_3', 'Wangari Maathai' => 1, 'Bibi Titi Mohammed' => 2][$title] ?? null;
            if ($sample && is_file(public_path("uploads/images/nahau/" . (is_int($sample) ? "sample_{$sample}" : $sample) . ".jpg"))) {
                $news->update(['image' => json_encode(["public/uploads/images/nahau/" . (is_int($sample) ? "sample_{$sample}" : $sample) . ".jpg"])]);
            }
            NahauStoryMeta::updateOrCreate(['news_id' => $news->id], array_merge(['slug' => \App\Nahau\Stories::makeSlug($title, $news->id), 'format' => $format, 'label' => $label, 'dek' => $dek, 'author_id' => $author, 'language' => 'en', 'reading_minutes' => rand(4, 14)], $extra));

            return $news;
        };

        $mk('fiction', 'The Last Bus to Morogoro', 'A bus conductor, a stranger with no ticket, and one night that changes what both believe about home.', 'Short story', 'Fiction', $aid[0], ['featured' => true]);
        $mk('fiction', 'Nyumba ya Bibi', 'Grandmother\'s house keeps its own secrets.', 'Flash fiction', 'Fiction', $aid[0], ['language' => 'sw']);
        foreach ([1 => 'The Drought', 2 => 'The Inheritance', 3 => 'What the River Kept'] as $n => $t) {
            $mk('fiction', "River of Tomorrow · Chapter $n: $t", 'A family on the banks of the Ruvu.', 'Serialised', 'Fiction', $aid[0], ['series_id' => $series->id, 'chapter_no' => $n]);
        }
        $mk('relationships', 'Sunday Calls with Mama', 'Every Sunday at six, a daughter in Nairobi phones home to Kigoma.', 'Personal essay', 'Personal experience', $aid[1]);
        $mk('relationships', 'Two Weddings and a Funeral', 'What a family learns when everyone finally sits at one table.', 'Reader story', 'Personal experience', $aid[1]);
        $mk('jobs-careers', 'Ten Years at the Kariakoo Stall', 'What a decade of selling second-hand shoes taught one trader about trust.', 'Interview', 'Interview', $aid[1]);
        $mk('jobs-careers', 'I Quit Banking to Farm Avocados', 'A risky move, a hard first harvest and the lessons that stayed.', 'Business journey', 'Personal experience', $aid[1]);

        $heroNames = [['Wangari Maathai', 'Kenya', '1940', '2011', 'Planted millions of trees and won the Nobel Peace Prize.'], ['Bibi Titi Mohammed', 'Tanzania', '1926', '2000', 'Mobilised women for independence.'], ['Miriam Makeba', 'South Africa', '1932', '2008', 'Voice of a continent in exile.']];
        foreach ($heroNames as $i => [$n, $c, $b, $d, $sum]) {
            $news = $mk('african-heroes', $n, $sum, 'Biography', 'Researched biography', $aid[2], [], '<h2>What they did</h2><p>[Sample text for design review only.]</p><h2>Their contribution</h2><p>[Sample text for design review only.]</p>');
            if ($news) {
                NahauHero::updateOrCreate(['news_id' => $news->id], ['name' => $n, 'born' => $b, 'died' => $d, 'country' => $c, 'known_for' => $sum, 'spotlight_summary' => $sum, 'show_in_spotlight' => true, 'spotlight_order' => $i, 'sources' => "Nobel Prize biography | https://www.nobelprize.org\nSample source"]);
            }
        }

        $opps = [['Junior Editor', 'job', 'Mwananchi Media', 'Dar es Salaam', 'Full-time', 'Edit and proofread stories in English and Kiswahili.', '+12 days'], ['Writing Internship', 'internship', 'Nahau Africa', 'Online', '3 months, paid', 'Work with editors on features.', '+20 days'], ['Digital Storytelling Course', 'training', 'DAS Academy', 'Arusha', 'Free, 8 weeks', 'Learn to tell stories with audio and photos.', '+8 days'], ['Women Writers Grant', 'grant', 'African Voices Fund', 'Online', 'Up to $2,000', 'Support for emerging women writers.', '+30 days']];
        foreach ($opps as $oi => [$t, $ty, $em, $loc, $terms, $desc, $close]) {
            NahauOpportunity::updateOrCreate(['slug' => \Illuminate\Support\Str::slug($t)], ['title' => $t, 'type' => $ty, 'employer' => $em, 'location' => $loc, 'terms' => $terms, 'description' => $desc, 'apply_link' => 'https://example.com/apply', 'closing_date' => now()->modify($close)->toDateString(), 'verified_by' => 'Sample Editor', 'verified_on' => now()->toDateString(), 'status' => 'published']);
        }
        foreach ([['Founder & Editor-in-Chief', 1], ['Fiction Editor', 2], ['Features & Research Editor', 3]] as [$r, $s]) {
            NahauTeam::updateOrCreate(['role' => $r], ['name' => '[Name]', 'sort' => $s]);
        }
    }
}
