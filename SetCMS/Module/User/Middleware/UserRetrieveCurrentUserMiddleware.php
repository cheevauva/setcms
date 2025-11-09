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

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = new \ReflectionClass(UserEntity::class)->newLazyProxy(function () use ($request): UserEntity {
            $token = $request->getCookieParams()['X-CSRF-Token'] ?? $request->getHeaderLine(strtolower('X-CSRF-Token'));

            $useByToken = UserSessionRetrieveUserServant::new($this->container);
            $useByToken->token = $token;
            $useByToken->serve();

            return $useByToken->user ?? new UserEntity;
        });

        return $handler->handle($request->withAttribute('currentUser', $user)->withAttribute('currentUserRole', function () use ($user) {
            return UserEntity::as($user)->role->value;
        }));
    }
}
