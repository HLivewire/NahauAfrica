<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Newscategory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Smoke tests for the public site. They run against a copy of the real
 * database (see phpunit.xml) and are read-only.
 */
class FrontendTest extends TestCase
{
    use DatabaseTransactions;

    public function test_public_pages_load(): void
    {
        foreach (['/', '/home-one', '/home-two', '/photogallery', '/contactus', '/signup', '/signin', '/search?search=news'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_every_category_page_and_one_article_per_category_loads(): void
    {
        $categories = Newscategory::where('type', 'news')->get();
        $this->assertNotEmpty($categories);

        foreach ($categories as $category) {
            $this->get(route($category->slug, strtolower($category->name)))->assertOk();
            $this->get('/'.$category->slug)->assertOk(); // optional parameter

            $news = News::join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
                ->where('newssubcategories.category_id', $category->id)
                ->where('news.status', 1)
                ->select('news.id', 'news.title')
                ->first();

            if ($news) {
                $this->get(route($category->slug.'.details', ['id' => $news->id, 'slug' => \Str::slug($news->title)]))
                    ->assertOk();
            }
        }
    }

    public function test_unknown_article_is_not_a_server_error(): void
    {
        $category = Newscategory::where('type', 'news')->first();
        $this->assertLessThan(500, $this->get($category->slug.'/details/99999999')->getStatusCode());
    }

    public function test_search_does_not_leak_unpublished_news(): void
    {
        $published = News::where('status', 1)->first();
        $draft = $published->replicate();
        $draft->title = 'Zzqx hidden draft headline';
        $draft->status = 0;
        $draft->save();

        $this->get('/search?search=Zzqx')->assertOk()->assertDontSee('Zzqx hidden draft headline');
        $this->postJson('/api/search_news', ['search' => 'Zzqx'])->assertOk()->assertJsonPath('data.total', 0);
    }

    public function test_uploads_reject_executable_files(): void
    {
        $file = \Illuminate\Http\UploadedFile::fake()->createWithContent('shell.php', '<?php echo 1;');
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        media_put($file, base_path('public/uploads/images/test/'), 'shell.php');
    }

    public function test_image_upload_helper_stores_and_deletes_files(): void
    {
        \Illuminate\Support\Facades\Storage::fake('media');
        config(['filesystems.media_disk' => 'media']);
        $img = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg', 20, 20);
        $this->assertTrue((bool) media_put($img, base_path('public/uploads/images/test/'), 'photo.jpg'));
        $this->assertTrue(media_exists('public/uploads/images/test/photo.jpg'));
        $this->assertStringEndsWith('/uploads/images/test/photo.jpg', media_url('public/uploads/images/test/photo.jpg'));
        media_delete('public/uploads/images/test/photo.jpg');
        $this->assertFalse(media_exists('public/uploads/images/test/photo.jpg'));
    }

    public function test_legacy_public_urls_redirect(): void
    {
        $this->get('/public/frontend/css/style.css')->assertRedirect(asset('frontend/css/style.css'));
        $this->get('/public/uploads/images/logo/logo.png')->assertRedirect();
    }

    public function test_dangerous_maintenance_routes_are_gone(): void
    {
        foreach (['/migrate', '/clear-all', '/clear-view-cache'] as $url) {
            $this->get($url)->assertNotFound();
        }
    }

    public function test_comment_can_be_posted(): void
    {
        $news = News::where('status', 1)->first();
        $this->post('news/comment/'.$news->id, [
            'name' => 'Tester', 'email' => 'tester@example.com', 'comment' => 'Nice article',
        ])->assertRedirect();
        $this->assertDatabaseHas('newscomments', ['news_id' => $news->id, 'email' => 'tester@example.com']);
    }
}
