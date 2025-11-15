<?php

declare(strict_types=1);

namespace Module\User\View;

use SetCMS\View\ViewJson;

class UserPublicDoLoginView extends ViewJson
{

    public ?string $sessionId = null;
}
