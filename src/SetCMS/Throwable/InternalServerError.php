<?php

namespace SetCMS\Throwable;

interface InternalServerError extends \Throwable
{

    public const CODE = 500;
    public const REASON = 'Внутренняя ошибка';

}
