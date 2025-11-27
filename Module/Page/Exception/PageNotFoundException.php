<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PageNotFoundException extends PageException
{
    /**
     * @var string
     */
    protected $message = 'Запись не найдена';
}
