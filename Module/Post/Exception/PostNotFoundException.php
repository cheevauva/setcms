<?php

declare(strict_types=1);

namespace Module\Post\Exception;

class PostNotFoundException extends PostException
{

    /**
     * @var string
     */
    protected $message = 'Запись не найдена';
}
