<?php

declare(strict_types=1);

namespace SetCMS\View;

class ViewInternalServerError extends ViewExceptionHandler
{

    #[\Override]
    public function serve(): void
    {
        $response = $this->newResponse();
        $response->getBody()->write(sprintf('%s<pre>%s</pre>', $this->ex->getMessage(), $this->ex->getTraceAsString()));

        $this->response = $response;
    }
}
