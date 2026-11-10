<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class News extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    protected static function booted(): void
    {
        // Every story gets a Nahau meta row (slug, reading time ...) automatically.
        static::saved(function (News $news) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('nahau_story_meta')) {
                    \App\Nahau\Stories::ensureMeta($news);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        });
    }

    public function subCategories()
    {
        return $this->belongsTo(Newssubcategory::class,'subcategory_id');
    }

    public function comments()
    {
        return $this->hasMany(Newscomment::class,'news_id');
    }

    public function category()
    {
        return $this->hasOneThrough(Newscategory::class,Newssubcategory::class,'id','id','subcategory_id','category_id');
    }

}
