<?php

declare(strict_types=1);

namespace Module\Menu\Exception;

class MenusNotFoundException extends MenuException
{

    use \SetCMS\Exception\ExceptionEntitiesNotFoundTrait;
}
