<?php

declare(strict_types=1);

namespace Module\User\Middleware;

use SetCMS\UUID;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Module\UserSession\Servant\UserSessionRetrieveUserServant;
use Module\User\Entity\UserEntity;
use Module\ACL\VO\ACLRoleVO;

class UserRetrieveCurrentUserMiddleware implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = new \ReflectionClass(UserEntity::class)->newLazyProxy(fn() => $this->userByToken($request));
        $userRole = new \ReflectionClass(ACLRoleVO::class)->newLazyProxy(fn() => $this->roleByUser($user));

        return $handler->handle($request->withAttribute('currentUser', $user)->withAttribute('currentUserRole', $userRole));
    }

    protected function roleByUser(UserEntity $user): ACLRoleVO
    {
        return new ACLRoleVO(UserEntity::as($user)->role->value);
    }

    protected function userByToken(ServerRequestInterface $request): UserEntity
    {
        $sessionId = new UUID($request->getCookieParams()['X-CSRF-Token'] ?? $request->getHeaderLine(strtolower('X-CSRF-Token')));

        $useByToken = UserSessionRetrieveUserServant::new($this->container);
        $useByToken->sessionId = $sessionId;
        $useByToken->serve();

        return $useByToken->user ?? new UserEntity;
    }
}
