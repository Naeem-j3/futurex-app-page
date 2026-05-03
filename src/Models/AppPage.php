<?php

namespace FutureX\AppPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppPage extends Model
{
    protected $table = 'app_pages';

    protected $guarded = [];
    public function images()
    {
        return $this->hasMany(AppPageImage::class)->orderBy('order');
    }
    public function features(): HasMany
    {
        return $this->hasMany(AppPageFeature::class)
            ->where('is_active', true)
            ->orderBy('order');
    }
}
