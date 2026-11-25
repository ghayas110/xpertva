<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'content',
        'tags',
        'image'
    ];

    /**
     * Posts that should be visible on the site: everything except the ones
     * merged into another post and now answering with a 301. Keeping them
     * out of the index, related posts and sitemap stops the site linking to
     * its own redirects. See config/content.php.
     */
    public function scopeListed($query)
    {
        $merged = array_keys(config('content.blog_redirects', []));

        return $merged ? $query->whereNotIn('slug', $merged) : $query;
    }

    /**
     * The service page this post supports, as ['url', 'label', 'pitch'],
     * or null if the post is not mapped to one.
     */
    public function supportedService(): ?array
    {
        // Plain array lookups, not config('a.b.' . $key): route names contain
        // dots, which config() would read as nested keys and never find.
        $route = config('content.post_service', [])[$this->slug] ?? null;
        $service = $route ? (config('content.services', [])[$route] ?? null) : null;

        if (! $service || ! \Illuminate\Support\Facades\Route::has($route)) {
            return null;
        }

        return ['url' => route($route)] + $service;
    }
}
