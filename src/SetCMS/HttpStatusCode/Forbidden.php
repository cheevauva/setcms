<?php

namespace SetCMS\HttpStatusCode;

interface Forbidden extends HttpStatusCode
{

    public const CODE = 403;
    public const REASON = 'Доступ ограничен';

}
