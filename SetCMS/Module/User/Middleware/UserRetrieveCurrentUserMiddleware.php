<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Module\UserSession\Servant\UserSessionRetrieveUserServant;
use SetCMS\Module\User\Entity\UserEntity;

class UserRetrieveCurrentUserMiddleware implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getCookieParams()['X-CSRF-Token'] ?? $request->getHeaderLine(strtolower('X-CSRF-Token'));

        $retrieveUser = UserSessionRetrieveUserServant::new($this->container);
        $retrieveUser->token = $token;
        $retrieveUser->serve();

        if (!empty($retrieveUser->user)) {
            $request = $request->withAttribute('currentUser', $retrieveUser->user);
            $request = $request->withAttribute('currentUserSession', $retrieveUser->session);
        } else {
            $request = $request->withAttribute('currentUser', new UserEntity);
        }

        return $handler->handle($request);
    }
}
