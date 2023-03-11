<?php

declare(strict_types=1);

namespace SetCMS\Controller\Hook;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\RequestAttribute;

class FrontControllerResolveHook
{

    use \SetCMS\EventTrait;

    public ?string $token = null;

    public function __construct(public ServerRequestInterface $request)
    {
        $this->token = $request->getCookieParams()[RequestAttribute::accessToken->toString()] ?? null;
    }

    public function withUser(?UserEntity $user = null): void
    {
        if (empty($user)) {
            return;
        }
        
        $this->request = RequestAttribute::currentUser->toRequest($this->request, $user);
    }

}
