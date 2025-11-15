<?php

declare(strict_types=1);

namespace UUA\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class ContainerNotFoundException extends \Exception implements NotFoundExceptionInterface
{

    /**
     * @var string
     */
    protected $message = 'Не найдены данные в контейнере по ключу %s';

    public function __construct(string $key)
    {
        parent::__construct(sprintf($this->message, $key));
    }
}
