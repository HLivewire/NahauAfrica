<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NahauSeries extends Model
{
    protected $table = 'nahau_series';
    protected $guarded = [];
    protected $casts = ['featured' => 'boolean', 'next_chapter_date' => 'date'];

    public function author()
    {
        return $this->belongsTo(NahauAuthor::class, 'author_id');
    }

    public function titleFor(?string $locale = null): string
    {
        return ($locale ?: nlocale()) === 'sw' && $this->title_sw ? $this->title_sw : $this->title;
    }
}
