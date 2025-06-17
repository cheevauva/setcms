<?php

declare(strict_types=1);

namespace SetCMS\View;

use Laminas\Diactoros\Response;
use SetCMS\View;

class ViewNotAllow extends View
{

    public string $message;

    #[\Override]
    public function serve(): void
    {
        $response = (new Response)->withStatus(405);
        $response->getBody()->write($this->message);

        $this->response = $response;
    }
}
