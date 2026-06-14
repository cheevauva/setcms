<?php

declare(strict_types=1);

namespace SetCMS\View;

class ViewBadRequest extends ViewExceptionHandler
{

    protected int $statusCode = 400;
}
