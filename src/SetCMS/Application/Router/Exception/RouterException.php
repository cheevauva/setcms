<?php

declare(strict_types=1);

namespace SetCMS\Application\Router\Exception;

use SetCMS\Exception;

class RouterException extends Exception
{

    public function label(): string
    {
        return 'setcms.router';
    }

}
