<?php

declare(strict_types=1);

namespace SetCMS\Responder;

use SetCMS\Responder;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Application\Contract\ContractNotAllow;
use SetCMS\Application\Contract\ContractNotFound;
use SetCMS\Application\Contract\ContractForbidden;
use SetCMS\View\ViewInternalServerError;

class ResponderBase extends Responder
{

    public function serve(): void
    {
        if (!$this->messages->valid()) {
            return;
        }
        
        $this->messages->rewind();

        while ($this->messages->valid()) {
            $response = $this->catch($this->messages->current());

            if ($response) {
                $this->response = $response;
                return;
            }

            $this->messages->next();
        }

        $this->messages->rewind();

        $internalServerError = ViewInternalServerError::new($this->container);
        $internalServerError->message = $this->messages->current()->getMessage();
        $internalServerError->serve();

        $this->response = $internalServerError->response;
    }

    protected function catch(\Throwable $ex): ?ResponseInterface
    {
        if ($ex instanceof ContractNotAllow) {
            return $response->withStatus(405);
        }
        if ($ex instanceof ContractNotFound) {
            $notFound = ViewNotFound::new($this->container);
            $notFound->serve();

            return $notFound->response;
        }

        if ($ex instanceof ContractForbidden) {
            return $response->withStatus(403);
        }

        return null;
    }
}
