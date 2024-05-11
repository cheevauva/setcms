<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use SetCMS\RequestAttribute;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Module\UserSession\Servant\UserSessionRetrieveUserServant;
use SetCMS\Module\User\UserEntity;

class RetrieveCurrentUserMiddleware implements MiddlewareInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $tokenName = RequestAttribute::accessToken->toString();
        $token = $request->getCookieParams()[$tokenName] ?? $request->getHeaderLine(strtolower($tokenName));

        $retrieveUser = UserSessionRetrieveUserServant::make($this->factory());
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
