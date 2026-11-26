<?php

namespace App\Support;

use App\Models\Blog;
use Illuminate\Support\Collection;

/**
 * The people credited on blog posts, read from config/content.php.
 *
 * Kept in config rather than a table because there are two of them and
 * they change about as often as the team page does.
 */
class Authors
{
    public static function find(?string $key): ?array
    {
        $author = $key ? (config('content.authors', [])[$key] ?? null) : null;

        return $author ? ['key' => $key, 'url' => route('team.member', $key)] + $author : null;
    }

    /** Slugs of the posts credited to one author. */
    public static function slugsFor(string $key): array
    {
        $default = config('content.default_author');
        $map = config('content.post_author', []);

        return Blog::listed()->pluck('slug')
            ->filter(fn ($slug) => ($map[$slug] ?? $default) === $key)
            ->values()
            ->all();
    }

    /**
     * schema.org Person for an author entry. The @id is stable, so the
     * BlogPosting author and the bio page describe the same node.
     */
    public static function schema(array $author): array
    {
        return array_filter([
            '@type'      => 'Person',
            '@id'        => $author['url'] . '#person',
            'name'       => $author['name'],
            'jobTitle'   => $author['role'],
            'url'        => $author['url'],
            'image'      => asset($author['photo']),
            'worksFor'   => ['@id' => 'https://xpertva.com/#organization'],
            'knowsAbout' => $author['knowsAbout'] ?? null,
            'sameAs'     => array_values(array_filter([$author['linkedin'] ?? null])) ?: null,
        ]);
    }
}
