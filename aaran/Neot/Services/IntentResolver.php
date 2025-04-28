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

        $patterns = ChatbotIntent::orderByDesc('priority')->get();

        foreach ($patterns as $intent) {
            if (preg_match($intent->pattern, $message)) {
                $handlerClass = $intent->handler_class;
                return [
                    'handler' => new $handlerClass($connection),
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
}
