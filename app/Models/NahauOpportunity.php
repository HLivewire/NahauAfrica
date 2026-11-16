<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NahauOpportunity extends Model
{
    protected $table = 'nahau_opportunities';
    protected $guarded = [];
    protected $casts = ['closing_date' => 'date', 'verified_on' => 'date', 'featured' => 'boolean', 'published_at' => 'datetime'];

    public const WORK_MODES = ['full-time' => 'Full-time', 'part-time' => 'Part-time', 'remote' => 'Remote', 'hybrid' => 'Hybrid'];

    /** When the advert went live (falls back to the row's creation time). */
    public function postedAt()
    {
        return $this->published_at ?: $this->created_at;
    }

    /** "New" for the first 7 days after it went live. */
    public function isNew(): bool
    {
        return $this->postedAt() && $this->postedAt()->gt(now()->subDays(7));
    }

    public function daysLeft(): int
    {
        return (int) now('Africa/Dar_es_Salaam')->startOfDay()->diffInDays($this->closing_date->copy()->startOfDay(), false);
    }

    public const HIDE_AFTER_REPORTS = 3;

    public function reports()
    {
        return $this->hasMany(NahauOpportunityReport::class, 'opportunity_id');
    }

    /** Public list: published, verified, not past 23:59 EAT on the closing date, fewer than 3 reports. */
    public function scopeOpen($q)
    {
        $today = now('Africa/Dar_es_Salaam')->toDateString();

        return $q->where('status', 'published')
            ->whereNotNull('verified_by')->whereNotNull('verified_on')
            ->whereDate('closing_date', '>=', $today)
            ->has('reports', '<', self::HIDE_AFTER_REPORTS);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->closing_date->lt(now('Africa/Dar_es_Salaam')->startOfDay());
    }
}
