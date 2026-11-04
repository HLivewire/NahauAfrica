<?php

//create function for breaking news

use Illuminate\Support\Facades\DB;
use \App\Models\Theme;
use \App\Models\News;
use \App\Models\Photogallery;
use \App\Models\Newscategory;
use \App\Models\Settings;
use \App\Models\Seooptimization;
use App\Models\Socialshare;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Media (uploaded files) helpers
|--------------------------------------------------------------------------
| Uploaded files are stored on the disk named by config('filesystems.media_disk')
| ("media" = the local public/ folder, or an S3 / Laravel Cloud bucket).
| For backward compatibility the database keeps the legacy value format
| "public/uploads/images/..." - these helpers translate it to a disk key.
*/
function media_key($path)
{
    if (!is_string($path) || $path === '') {
        return '';
    }
    $path = str_replace('\\', '/', $path);
    // absolute destination folders such as /var/www/project/public/uploads/x/
    if (($pos = strpos($path, '/public/uploads/')) !== false) {
        $path = substr($path, $pos + 8);
    }
    $path = ltrim($path, '/');
    if (str_starts_with($path, 'public/')) {
        $path = substr($path, 7);
    }
    return $path;
}
function media_disk()
{
    return Storage::disk(config('filesystems.media_disk', 'media'));
}
function media_url($path)
{
    if (empty($path) || !is_string($path)) {
        return '';
    }
    if (preg_match('#^(https?:)?//#i', $path)) {
        return $path;
    }
    $key = media_key($path);
    if (config('filesystems.media_disk', 'media') === 'media') {
        return asset($key);
    }
    return media_disk()->url($key);
}
function media_exists($path)
{
    $key = media_key($path);
    return $key !== '' && media_disk()->exists($key);
}
function media_delete($path)
{
    $key = media_key($path);
    if ($key !== '' && media_disk()->exists($key)) {
        return media_disk()->delete($key);
    }
    return false;
}
function media_put($file, $directory, $fileName)
{
    // Only images and videos may be uploaded (blocks .php, .html and other executable files).
    $allowedExt = ['jpg','jpeg','jfif','png','gif','webp','avif','svg','bmp','ico','mp4','webm','ogg','mov','m4v'];
    $ext = strtolower(pathinfo((string) $fileName, PATHINFO_EXTENSION));
    $mime = (string) $file->getMimeType();
    if (!in_array($ext, $allowedExt, true) || !(str_starts_with($mime, 'image/') || str_starts_with($mime, 'video/'))) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'image' => 'This file type is not allowed. Please upload an image or a video.',
        ]);
    }
    $key = trim(media_key(rtrim($directory, '/\\') . '/'), '/') . '/' . $fileName;
    $stream = fopen($file->getRealPath(), 'r');
    $saved = media_disk()->put($key, $stream, 'public');
    if (is_resource($stream)) {
        fclose($stream);
    }
    return $saved;
}
function imageUpload($image, $imageDirectory, $existFileUrl=null,$name=null)
{
    if ($image)
    {
        if ($existFileUrl) {
            media_delete($existFileUrl);
        }
        $fileName = $name.'.'.$image->getClientOriginalExtension();
        media_put($image, $imageDirectory, $fileName);
        $fileUrl = $imageDirectory.$fileName;
    } else {
        if (isset($existFileUrl))
        {
            $fileUrl = $existFileUrl;
        } else {
            $fileUrl = '';
        }
    }
    return $fileUrl;
}
function breakingnews(){
    $breakingnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
        ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
        ->select('news.id','news.title','news.created_at','newscategories.name as news_category','newscategories.slug as news_categoryslug')
        ->where('news.breaking_news',1)
        ->where('news.status',1)
        ->latest()
        ->get();
    return $breakingnews;
}
function popularsnews(){
    $popularsnews = News::join('newssubcategories','news.subcategory_id','=','newssubcategories.id')
        ->join('newscategories','newssubcategories.category_id','=','newscategories.id')
        ->join('users','news.reporter_id','=','users.id')
        ->select('news.id','news.title','news.image','news.date','newscategories.name as news_category','newscategories.slug as news_categoryslug',DB::raw("CONCAT(users.first_name,' ',users.last_name) AS reporter_name"))
        ->where('news.status',1)
        ->orderByDesc('news.viewers')
        ->limit(3)
        ->get();
    return $popularsnews;
}
function newscategories(){
    $newscategories = Newscategory::where('type','news')
        ->orderBy('id')
        ->get();
    return $newscategories ;
}
function photogalleries(){
    $photogalleries = Photogallery::where('status',1)
        ->select('id','image')
        ->orderByDesc('id')
        ->limit(6)
        ->get();
    return $photogalleries ;
}
function settings(){
    // Empty model fallback keeps pages working on a database without settings rows.
    return Settings::first() ?? new Settings();
}
function seooptimization(){
    return Seooptimization::first() ?? new Seooptimization();
}
function advertisement() {
    return \App\Models\Advertisement::latest()->first() ?? new \App\Models\Advertisement();
}
function googleanalytics() {
    $googleanalytics = \App\Models\Googleanalytic::latest()->get();
    return $googleanalytics ;
}
function home() {
    $home = Newscategory::where('type','home')->value('name');
    return $home ;
}
function contactus() {
    $contactus = Newscategory::where('type','contact')->value('name');
    return $contactus ;
}
function socials(){
    $socials = Socialshare::take(5)->get();
    return $socials;
}
function headers(){
    $header = \App\Models\Header::where('status',1)->where('is_active',1)->first();
    return $header;
}
function menu(){
    $menu = \App\Models\Menu::where('status',1)->where('is_active',1)->first();
    return $menu;
}
function footer(){
    $footer = \App\Models\Footer::where('status',1)->where('is_active',1)->first();
    return $footer;
}
function companies(){
    return \App\Models\Company::where('status',1)->first() ?? new \App\Models\Company();
}
function themeActivation(){
    // Falls back to the first home theme when no theme is marked active.
    $activeTheme = Schema::hasTable('themes') ? Theme::where('is_active',1)->first() : null;
    return $activeTheme ?? (new Theme())->forceFill(['page_slug' => 'home_1']);
}
