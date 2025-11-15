<?php

declare(strict_types=1);

namespace Module\User\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Module\UserSession\Servant\UserSessionRetrieveUserServant;
use Module\User\Entity\UserEntity;
use SetCMS\ACL\VO\ACLRoleVO;

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
        $userRole = new \ReflectionClass(ACLRoleVO::class)->newLazyProxy(function () use ($user): ACLRoleVO {
            return new ACLRoleVO(UserEntity::as($user)->role->value);
        });

        return $handler->handle($request->withAttribute('currentUser', $user)->withAttribute('currentUserRole', $userRole));
    }
}
