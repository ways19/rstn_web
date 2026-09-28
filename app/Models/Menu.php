<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    protected $fillable = [
        'location',
        'parent_id',
        'title',
        'url',
        'route_name',
        'icon',
        'target',
        'permission_name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function activeChildren(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->where('is_active', true)->orderBy('order');
    }

    public function getLinkAttribute(): string
    {
        if ($this->route_name && Route::has($this->route_name)) {
            try {
                return route($this->route_name);
            } catch (\Exception $e) {
                // Ignore route parameter exception
            }
        }

        return $this->url ?? '#';
    }

    public function isActiveRoute(): bool
    {
        if ($this->route_name && Route::has($this->route_name)) {
            return request()->routeIs($this->route_name . '*');
        }

        if ($this->url && $this->url !== '#') {
            return request()->is(ltrim($this->url, '/') . '*');
        }

        return false;
    }
}
