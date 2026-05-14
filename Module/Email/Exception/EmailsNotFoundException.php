<?php

declare(strict_types=1);

namespace Module\Email\Exception;

class EmailsNotFoundException extends EmailException
{

    /**
     * @var string
     * @phpstan-ignore missingType.property
     */
    protected $message = 'Записи не найдены';
}
