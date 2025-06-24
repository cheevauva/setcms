<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Email\Entity\EmailEntity;

class EmailPrivateUpdateView extends ViewJson
{

    public ?EmailEntity $email = null;
}
