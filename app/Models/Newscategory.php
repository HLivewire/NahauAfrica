<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newscategory extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected static function booted(): void
    {
        // Category routes are cached - refresh them when categories change.
        $forget = fn () => \Illuminate\Support\Facades\Cache::forget(\App\Providers\CategoryRouteServiceProvider::CACHE_KEY);
        static::saved($forget);
        static::deleted($forget);
    }

    public function newssubcategory()
    {
        return $this->belongsTo(Newssubcategory::class,'category_id');
    }

    public function newsSubCategories()
    {
        return $this->hasMany(Newssubcategory::class,'category_id');
    }
    public function news()
    {
        return $this->hasManyThrough(News::class,Newssubcategory::class,'category_id','subcategory_id','id','id');
    }



}
