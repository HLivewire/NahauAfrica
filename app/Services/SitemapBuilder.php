<?php

namespace App\Services;

use App\Models\News;
use App\Models\Newscategory;
use DOMDocument;
use Illuminate\Support\Str;

/**
 * Builds the XML sitemap (home page, news categories and published articles).
 * Replaces the abandoned "laravelium/sitemap" package, which no longer supports
 * recent Laravel versions.
 */
class SitemapBuilder
{
    public static function xml(): string
    {
        $entries = [];

        $entries[] = [url('/'), now()->toAtomString(), '1.0', 'daily'];

        foreach (Newscategory::where('type', 'news')->orderBy('id')->get(['slug', 'updated_at', 'created_at']) as $category) {
            if ($category->slug) {
                $entries[] = [
                    url(strtolower($category->slug)),
                    optional($category->updated_at ?? $category->created_at)->toAtomString(),
                    '1.0',
                    'daily',
                ];
            }
        }

        $articles = News::join('newssubcategories', 'news.subcategory_id', '=', 'newssubcategories.id')
            ->join('newscategories', 'newssubcategories.category_id', '=', 'newscategories.id')
            ->where('news.status', 1)
            ->orderByDesc('news.id')
            ->get(['news.id', 'news.title', 'news.created_at', 'news.updated_at', 'newscategories.slug as category_slug']);

        foreach ($articles as $article) {
            if (! $article->category_slug) {
                continue;
            }
            $entries[] = [
                url(strtolower($article->category_slug).'/details/'.$article->id.'/'.Str::slug($article->title)),
                optional($article->updated_at ?? $article->created_at)->toAtomString(),
                '0.8',
                'weekly',
            ];
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $urlset = $dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $dom->appendChild($urlset);

        foreach ($entries as [$loc, $lastmod, $priority, $changefreq]) {
            $url = $dom->createElement('url');
            $url->appendChild($dom->createElement('loc', htmlspecialchars($loc, ENT_XML1)));
            if ($lastmod) {
                $url->appendChild($dom->createElement('lastmod', $lastmod));
            }
            $url->appendChild($dom->createElement('changefreq', $changefreq));
            $url->appendChild($dom->createElement('priority', $priority));
            $urlset->appendChild($url);
        }

        return $dom->saveXML();
    }
}
