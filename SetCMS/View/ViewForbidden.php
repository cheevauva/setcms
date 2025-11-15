<?php

declare(strict_types=1);

namespace SetCMS\View;

class ViewForbidden extends ViewExceptionHandler
{

    protected int $statusCode = 403;
}
