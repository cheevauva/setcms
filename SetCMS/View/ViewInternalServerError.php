<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\View;
use Laminas\Diactoros\Response;

class ViewInternalServerError extends View
{

    public string $message;

    #[\Override]
    public function serve(): void
    {
        $response = (new Response)->withStatus(500);
        $response->getBody()->write($this->message);

        $this->response = $response;
    }
}
