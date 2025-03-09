<?php

declare(strict_types=1);

namespace SetCMS\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NotBlank
{
    public function __construct(protected ?string $field = null)
    {
        ;
    }
}
