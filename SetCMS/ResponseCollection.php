<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Http\Message\ResponseInterface;

class ResponseCollection extends \SplObjectStorage
{

    public function first(): ?ResponseInterface
    {
        return $this->response[0] ?? null;
    }
}
