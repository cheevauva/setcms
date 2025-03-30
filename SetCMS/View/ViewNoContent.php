<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\View;
use Laminas\Diactoros\Response;

class ViewNoContent extends View
{

    #[\Override]
    public function serve(): void
    {
        $this->response = (new Response)->withStatus(204);
    }
}
