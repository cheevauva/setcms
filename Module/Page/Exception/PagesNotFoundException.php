<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PagesNotFoundException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Записи не найдены';
}
