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
        $response = new Response;
        $response->getBody()->write('No content');
        $response->getBody()->rewind();

        $this->response = $response->withStatus(204);
    }
}
