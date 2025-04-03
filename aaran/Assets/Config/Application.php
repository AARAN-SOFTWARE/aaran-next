<?php

namespace Aaran\Assets\Config;

class Application
{
    /**
     * The Aaran App Version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    public static function version(): string
    {
        return self::VERSION;
    }
}
