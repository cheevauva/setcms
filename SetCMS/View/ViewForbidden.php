<?php

declare(strict_types=1);

namespace SetCMS\View;

use Laminas\Diactoros\Response;
use SetCMS\View\View;

class ViewForbidden extends View
{

    public string $message;

    #[\Override]
    public function serve(): void
    {
        $response = (new Response)->withStatus(403);
        $response->getBody()->write($this->message);

        $this->response = $response;
    }
}
