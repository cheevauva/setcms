<?php

declare(strict_types=1);

namespace SetCMS\Responder;

use SetCMS\Responder;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Application\Contract\ContractNotAllow;
use SetCMS\Application\Contract\ContractNotFound;
use SetCMS\Application\Contract\ContractForbidden;
use SetCMS\View\ViewInternalServerError;
use SetCMS\View\ViewNotFound;
use SetCMS\View\ViewNotAllow;
use SetCMS\View\ViewForbidden;

class ResponderBase extends Responder
{

    #[\Override]
    public function serve(): void
    {
        if (!$this->messages->valid()) {
            return;
        }

        $this->messages->rewind();

        $response = null;

        while ($this->messages->valid()) {
            $message = $this->messages->current();

            if ($message instanceof \Throwable) {
                $response = $this->catch($message);
            }

            if ($response) {
                $this->response = $response;
                return;
            }

            $this->messages->next();
        }

        $this->messages->rewind();

        $message = $this->messages->current();

        if ($message instanceof \Throwable) {
            $internalServerError = ViewInternalServerError::new($this->container);
            $internalServerError->message = $message->getMessage();
            $internalServerError->serve();

            $this->response = $internalServerError->response;
        }
    }

    protected function catch(\Throwable $ex): ?ResponseInterface
    {
        if ($ex instanceof ContractNotAllow) {
            $notAllow = ViewNotAllow::new($this->container);
            $notAllow->serve();

            return $notAllow->response;
        }
        if ($ex instanceof ContractNotFound) {
            $notFound = ViewNotFound::new($this->container);
            $notFound->serve();

            return $notFound->response;
        }

        if ($ex instanceof ContractForbidden) {
            $forbidden = ViewForbidden::new($this->container);
            $forbidden->serve();

            return $forbidden->response;
        }

        return null;
    }
}
