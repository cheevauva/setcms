<?php

declare(strict_types=1);

namespace Module\Menu\Exception;

class MenusNotFoundException extends MenuException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
