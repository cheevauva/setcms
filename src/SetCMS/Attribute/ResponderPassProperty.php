<?php

declare(strict_types=1);

namespace SetCMS\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ResponderPassProperty
{

    public function __construct(protected ?string $name = null)
    {
        
    }
}
