<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\View\View;
use Laminas\Diactoros\Response;

class ViewNoContent extends View
{
    public string $message;

    #[\Override]
    public function serve(): void
    {
        $response = new Response;
        $response->getBody()->write($this->message);
        $response->getBody()->rewind();

        $this->response = $response->withStatus(500);
    }
}
