<?php

declare(strict_types=1);

namespace SetCMS\Attribute\Http\Parameter;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
final class Attributes
{

    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
