<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NahauSlide extends Model
{
    public const MIN_DAYS = 4;
    public const WARN_DAYS = 2;

    protected $table = 'nahau_carousel';
    protected $guarded = [];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];

    public function hero()
    {
        return $this->belongsTo(NahauHero::class, 'hero_id');
    }

    public function scopeLive($q)
    {
        return $q->where(fn ($w) => $w->whereNull('ends_at')->orWhere('ends_at', '>', now()));
    }

    /** Slides that are over, or end within the warning window. */
    public function scopeExpiring($q)
    {
        return $q->whereNotNull('ends_at')->where('ends_at', '<=', now()->addDays(self::WARN_DAYS));
    }

    public function daysLeft(): int
    {
        return $this->ends_at ? (int) max(0, ceil(now()->diffInHours($this->ends_at, false) / 24)) : 999;
    }

    public function expired(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function getTitleAttribute(): string
    {
        return $this->headline ?: $this->resolvedTitle();
    }

    public function getDaysLeftAttribute(): string
    {
        return $this->expired() ? 'Expired' : $this->daysLeft().' '.($this->daysLeft() === 1 ? 'day' : 'days').' left';
    }

    public function resolvedTitle(): string
    {
        return $this->kind === 'hero' ? (string) $this->hero?->name : (string) \App\Models\News::find($this->news_id)?->title;
    }
}
