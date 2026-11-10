<?php

declare(strict_types=1);

namespace SetCMS\View;

abstract class ViewExceptionHandler extends View
{

    use \SetCMS\Traits\TraitsResponse;

    public \Throwable $ex;
    protected int $statusCode;

    #[\Override]
    protected function run(): void
    {
        $response = $this->newResponse();
        $response->getBody()->write($this->ex->getMessage());
        $response->getBody()->rewind();

        $this->response = $response->withStatus($this->statusCode);
    }
}
