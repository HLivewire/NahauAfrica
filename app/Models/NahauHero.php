<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NahauHero extends Model
{
    protected $table = 'nahau_heroes';
    protected $guarded = [];
    protected $casts = ['active' => 'boolean'];

    /** The story text for the admin form (the story itself is a news row). */
    public function getStoryTextAttribute(): string
    {
        return $this->news_id ? \App\Nahau\HeroStories::text(News::where('id', $this->news_id)->value('description')) : '';
    }
}
