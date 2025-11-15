<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View;
use Laminas\Diactoros\Response;

class UserPublicLogoutView extends View
{
    use \SetCMS\Traits\RouterTrait;

    #[\Override]
    public function serve(): void
    {
        $this->response = (new Response)->withStatus(302)->withHeader('Location', $this->router()->generate('Home'));
    }
}
