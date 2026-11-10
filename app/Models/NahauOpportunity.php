<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NahauOpportunity extends Model
{
    protected $table = 'nahau_opportunities';
    protected $guarded = [];
    protected $casts = ['closing_date' => 'date', 'verified_on' => 'date', 'featured' => 'boolean'];

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
