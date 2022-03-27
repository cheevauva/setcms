<?php

namespace SetCMS\Throwable;

interface BadRequest extends \Throwable
{

    public const CODE = 400;
    public const REASON = 'Плохой запрос';

}
