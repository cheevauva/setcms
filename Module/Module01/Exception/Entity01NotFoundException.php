<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01NotFoundException extends Entity01Exception
{
    /**
     * @var string
     */
    protected $message = 'Запись не найдена';

}
