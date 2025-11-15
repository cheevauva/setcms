<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View\View;

class UserPublicLogoutView extends View
{

    use \SetCMS\Traits\RouterTrait;
    use \SetCMS\Traits\ResponseTrait;

    #[\Override]
    public function serve(): void
    {
        $this->response = $this->newResponse()->withStatus(302)->withHeader('Location', $this->router()->generate('Home'));
    }
}
