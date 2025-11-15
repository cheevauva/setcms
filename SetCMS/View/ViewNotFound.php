<?php

declare(strict_types=1);

namespace SetCMS\View;

class ViewNotFound extends ViewExceptionHandler
{

    protected int $statusCode = 404;
}
