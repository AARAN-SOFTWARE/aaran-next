<?php

namespace Aaran\Neot\Services;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Neot\Models\ChatbotIntent;

class IntentResolver
{
    use TenantAwareTrait;

    public static function resolve(string $message)
    {
        $instance = new self();
        $connection = $instance->getTenantConnection();
        $message = strtolower($message);

        $patterns = ChatbotIntent::on($connection)->orderByDesc('priority')->get();

        foreach ($patterns as $intent) {
            $pattern = self::prepareRegex($intent->pattern);

            if (preg_match($pattern, $message)) {
                return [
                    'handler' => new DynamicQueryHandler($connection, $intent, auth()->user()),
                    'suggestions' => [],
                ];
            }
        }

        $suggestions = $patterns->pluck('title')->toArray();

        return [
            'handler' => null,
            'suggestions' => $suggestions,
        ];
    }

    protected static function prepareRegex(string $pattern): string
    {
        // If pattern already has proper regex format, use it
        if (preg_match('~^/.+/[a-z]*$~i', $pattern)) {
            return $pattern;
        }

        // Otherwise auto-wrap into safe regex
        return '/' . preg_quote($pattern, '/') . '/i';
    }
}
