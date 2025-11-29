<?php

declare(strict_types=1);

namespace Module\Module01\Exception;

class Entity01EntitiesNotFoundException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Записи не найдены';
}
