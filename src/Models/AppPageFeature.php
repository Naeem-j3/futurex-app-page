<?php
// src/Models/AppPageFeature.php

namespace FutureX\AppPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppPageFeature extends Model
{
    protected $fillable = [
        'app_page_id', 'title', 'description', 'icon', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function appPage(): BelongsTo
    {
        return $this->belongsTo(AppPage::class);
    }
}
