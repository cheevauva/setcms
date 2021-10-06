<?php

namespace SetCMS\HttpStatusCode;

interface NotFound extends HttpStatusCode
{

    public const CODE = 404;
    public const REASON = 'Страница не найдена';

}
