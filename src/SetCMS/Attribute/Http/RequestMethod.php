<?php

declare(strict_types=1);

namespace SetCMS\Attribute\Http;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
class RequestMethod
{
    //put your code here
}
