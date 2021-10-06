<?php

namespace SetCMS\HttpStatusCode;

interface InternalServerError extends HttpStatusCode
{

    public const CODE = 500;
    public const REASON = 'Внутренняя ошибка';

}
