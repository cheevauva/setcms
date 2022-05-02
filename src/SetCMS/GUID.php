<?php

declare(strict_types=1);

namespace SetCMS;

class GUID
{

    public const REGEX = '[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}';

    public static function generate(): string
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', ...[
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        ]);
    }

    public static function valid(string $guid): bool
    {
        return !!preg_match('/^\{?' . self::REGEX . '\}?$/', $guid);
    }

}
