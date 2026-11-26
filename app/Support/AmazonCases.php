<?php

namespace App\Support;

/**
 * The Amazon case files at /work/amazon-cases/{slug}, read from
 * resources/data/amazon-cases.json.
 *
 * Kept as JSON rather than config because each entry is a page of prose,
 * and it is read once per request at most.
 */
class AmazonCases
{
    private static ?array $all = null;

    /** Every case, keyed by slug, in file order. */
    public static function all(): array
    {
        if (self::$all === null) {
            $data = json_decode((string) @file_get_contents(resource_path('data/amazon-cases.json')), true) ?: [];
            self::$all = array_filter($data, fn ($v, $k) => $k[0] !== '_' && is_array($v), ARRAY_FILTER_USE_BOTH);
        }

        return self::$all;
    }

    public static function find(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }

    /** Cases that list this route among their services. Primary service first. */
    public static function forService(?string $route): array
    {
        if (! $route) {
            return [];
        }

        $cases = array_filter(self::all(), fn ($case) => in_array($route, $case['services'] ?? [], true));

        uasort($cases, fn ($a, $b) => array_search($route, $a['services']) <=> array_search($route, $b['services']));

        return $cases;
    }

    public static function lastModified(): int
    {
        return (int) @filemtime(resource_path('data/amazon-cases.json'));
    }
}
