<?php

declare(strict_types=1);

namespace SetCMS;

class UUID
{

    public const REGEX = '[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}';

    public string $uuid;

    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid ?? $this->generate();

        if (!$this->isValid()) {
            throw new \RuntimeException('UUID имеет неправильный формат');
        }
    }

    private function generate(): string
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

    public function isValid(): bool
    {
        return !!preg_match('/^\{?' . static::REGEX . '\}?$/', $this->uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

}
