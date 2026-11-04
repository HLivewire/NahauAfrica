<?php

namespace Tests\Feature;

use App\Models\Blogcategory;
use App\Models\News;
use App\Models\Newscategory;
use App\Models\Newssubcategory;
use App\Models\Newsspeciality;
use App\Models\Photogallery;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('media');
        $this->actingAs(User::whereHas('roles', fn ($q) => $q->where('slug', 'super-admin'))->firstOrFail());
    }

    public function test_news_category_crud(): void
    {
        $this->post('/admin/news/category', [
            'name' => 'Test Cat', 'slug' => 'test-cat-x', 'type' => 'news',
            'image' => UploadedFile::fake()->image('c.png', 300, 200)->size(50),
        ])->assertSessionHasNoErrors();
        $cat = Newscategory::where('slug', 'test-cat-x')->firstOrFail();

        $this->put(route('admin.news.category.update', $cat->id), [
            'name' => 'Test Cat 2', 'slug' => 'test-cat-x', 'type' => 'news',
        ])->assertSessionHasNoErrors();
        $this->assertSame('Test Cat 2', $cat->fresh()->name);

        $this->delete(route('admin.news.category.destroy', $cat->id))->assertSessionHasNoErrors();
        $this->assertNull(Newscategory::find($cat->id));
    }

    public function test_news_subcategory_and_news_crud(): void
    {
        $category = Newscategory::firstOrFail();
        $this->post('/admin/news/subcategory', ['name' => 'Sub X', 'category_id' => $category->id])
            ->assertSessionHasNoErrors();
        $sub = Newssubcategory::where('name', 'Sub X')->firstOrFail();

        $payload = [
            'title' => 'Feature Test Story', 'summary' => 'sum', 'description' => '<p>body</p>',
            'category_id' => $category->id, 'subcategory_id' => $sub->id, 'date' => '2026-01-02',
            'tags' => 'a,b', 'speciality_id' => Newsspeciality::value('id'),
            'reporter_id' => User::value('id'), 'meta_keyword' => 'k', 'meta_description' => 'd',
            'status' => 1, 'image' => [UploadedFile::fake()->image('n.jpg', 400, 300)->size(100)],
        ];
        $response = $this->post('/admin/news', $payload);
        $response->assertSessionHasNoErrors();
        $news = News::where('title', 'Feature Test Story')->firstOrFail();

        $this->get(route('admin.news.edit', $news->id))->assertOk();
        $this->put(route('admin.news.update', $news->id), array_merge($payload, ['title' => 'Feature Test Story 2']))
            ->assertSessionHasNoErrors();
        $this->assertSame('Feature Test Story 2', $news->fresh()->title);

        $this->delete(route('admin.news.destroy', $news->id))->assertSessionHasNoErrors();
        $this->assertNull(News::find($news->id));
        $this->delete(route('admin.news.subcategory.destroy', $sub->id))->assertSessionHasNoErrors();
    }

    public function test_blog_category_and_photogallery_crud(): void
    {
        $this->post('/admin/blog/category', ['name' => 'Blog Cat X'])->assertSessionHasNoErrors();
        $bc = Blogcategory::where('name', 'Blog Cat X')->firstOrFail();
        $this->put(route('admin.blog.category.update', $bc->id), ['name' => 'Blog Cat Y'])->assertSessionHasNoErrors();
        $this->delete(route('admin.blog.category.destroy', $bc->id))->assertSessionHasNoErrors();

        $this->post('/admin/photogallery', [
            'title' => 'Pic Story', 'description' => 'desc', 'status' => 1,
            'image' => [UploadedFile::fake()->image('p.jpg', 300, 300)->size(80)],
        ])->assertSessionHasNoErrors();
        $photo = Photogallery::where('title', 'Pic Story')->firstOrFail();
        $this->get(route('admin.photogallery.edit', $photo->id))->assertOk();
        $this->delete(route('admin.photogallery.destroy', $photo->id))->assertSessionHasNoErrors();
    }

    public function test_executable_upload_is_rejected_by_admin_forms(): void
    {
        $category = Newscategory::firstOrFail();
        $sub = Newssubcategory::firstOrFail();
        $this->post('/admin/photogallery', [
            'title' => 'Bad', 'description' => 'd',
            'image' => [UploadedFile::fake()->create('shell.php', 1, 'application/x-php')],
        ]);
        $this->assertDatabaseMissing('photogalleries', ['title' => 'Bad']);
    }
}
