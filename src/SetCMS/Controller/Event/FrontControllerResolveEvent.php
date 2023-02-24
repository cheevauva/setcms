<?php

declare(strict_types=1);

namespace SetCMS\Controller\Event;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\ServerRequestAttribute;

class FrontControllerResolveEvent
{

    use \SetCMS\EventTrait;

    public ?string $token = null;

    public function __construct(public ServerRequestInterface $request)
    {
        $this->token = $request->getCookieParams()[ServerRequestAttribute::ACCESS_TOKEN] ?? null;
    }

    public function withUser(UserEntity $user): void
    {
        $this->request = $this->request->withAttribute(ServerRequestAttribute::CURRENT_USER, $user);
    }

}
