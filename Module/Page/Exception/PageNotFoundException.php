<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageNotFoundException extends PageException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Запись не найдена';
}
