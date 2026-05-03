<?php

declare(strict_types=1);

namespace SetCMS\View;

class ViewInternalServerError extends ViewExceptionHandler
{

    use \UUA\Traits\EnvTrait;

    protected bool $isDebug;

    #[\Override]
    protected function init(): void
    {
        parent::init();
        
        $this->isDebug = boolval($this->env()['VIEW_INTERNAL_SERVER_ERROR_DEBUG'] ?? false);
    }

    #[\Override]
    public function serve(): void
    {
        if ($this->isDebug) {
            $message = sprintf('%s: %s<pre>%s</pre>', $this->ex::class, $this->ex->getMessage(), $this->ex->getTraceAsString());
        } else {
            $message = 'Internal Server Error';
        }
        
        $response = $this->newResponse()->withStatus(500);
        $response->getBody()->write($message);

        $this->response = $response;
    }
}
