<?php

declare(strict_types=1);

namespace SetCMS\Controller\Exception;

class ControllerEmptyResponseException extends \Exception
{

    /**
     * @var string
     */
    protected $message = 'Не задан объект для ответа, контроллер %s';

    public function __construct(string $className)
    {
        parent::__construct(sprintf($this->message, $className));
    }
}
