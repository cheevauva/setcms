<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class CSRFProtectServant extends \UUA\Servant
{

    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function serve(): void
    {
        if ($this->request->getHeaderLine('Authorization')) {
            return;
        }

        if ($this->request->getMethod() === 'GET') {
            $token = md5(microtime(true) . rand(1, 100000));
            $this->response = $this->response->withHeader('X-CSRF-Token', $token)->withHeader('Set-Cookie', sprintf('X-CSRF-Token=%s;Path=/;SameSite=Strict', $token));
        }

        if (in_array($this->request->getMethod(), ['POST'], true)) {
            if (empty($this->request->getCookieParams()['X-CSRF-Token']) || empty($this->request->getHeaderLine('X-CSRF-Token'))) {
                throw new \RuntimeException('Один из CSRF токенов пуст');
            }

            if ($this->request->getCookieParams()['X-CSRF-Token'] !== $this->request->getHeaderLine('X-CSRF-Token')) {
                throw new \RuntimeException('CSRF токены не совпадают');
            }
        }
    }
}
