<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PagesNotFoundException extends PageException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
