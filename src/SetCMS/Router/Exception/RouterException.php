<?php

declare(strict_types=1);

namespace SetCMS\Router\Exception;

use SetCMS\Exception;

class RouterException extends Exception
{

    public function label(): string
    {
        return 'setcms.router';
    }

}
