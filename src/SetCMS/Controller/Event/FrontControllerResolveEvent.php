<?php

declare(strict_types=1);

namespace SetCMS\Controller\Event;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\RequestAttribute;

class FrontControllerResolveEvent
{

    use \SetCMS\EventTrait;

    public ?string $token = null;

    public function __construct(public ServerRequestInterface $request)
    {
        $this->token = $request->getCookieParams()[RequestAttribute::accessToken->toString()] ?? null;
    }

    public function withUser(UserEntity $user): void
    {
        $this->request = RequestAttribute::currentUser->toRequest($this->request, $user);
    }

}
