<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Append-only audit trail. Rows are never updated or deleted by the app. */
class ActivityLog extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = ['changes' => 'array', 'created_at' => 'datetime'];

    public const ACTIONS = [
        'login' => 'Ameingia', 'logout' => 'Ametoka', 'login_failed' => 'Kuingia kumeshindwa',
        'created' => 'Ameongeza', 'updated' => 'Amebadilisha', 'deleted' => 'Amefuta',
        'password_change' => 'Amebadilisha nenosiri', 'role_change' => 'Amebadilisha role',
    ];

    public const TONE = [
        'login' => 'ok', 'logout' => 'sw', 'login_failed' => 'er', 'created' => 'ok', 'updated' => 'wr',
        'deleted' => 'er', 'password_change' => 'en', 'role_change' => 'en',
    ];
}
