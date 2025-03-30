<?php

declare(strict_types=1);

namespace SetCMS;

class Exception extends \Exception
{

    public function label(): string
    {
        return 'setcms.label';
    }

    public function placeholders(): array
    {
        return [];
    }
}
