<?php

namespace SetCMS\Throwable;

interface Forbidden extends \Throwable
{

    public const CODE = 403;
    public const REASON = 'Доступ ограничен';

}
