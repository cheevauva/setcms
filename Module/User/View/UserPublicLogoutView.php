<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View;
use Laminas\Diactoros\Response;
use SetCMS\Application\Router\Router;

class UserPublicLogoutView extends View
{

    #[\Override]
    public function serve(): void
    {
        $this->response = (new Response)->withStatus(302)->withHeader('Location', Router::singleton($this->container)->generate('Home'));
    }
}
