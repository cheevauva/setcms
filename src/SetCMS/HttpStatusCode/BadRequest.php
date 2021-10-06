<?php

namespace SetCMS\HttpStatusCode;

interface BadRequest extends HttpStatusCode
{

    public const CODE = 400;
    public const REASON = 'Плохой запрос';

}
