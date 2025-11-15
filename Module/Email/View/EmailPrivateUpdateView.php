<?php

declare(strict_types=1);

namespace Module\Email\View;

use SetCMS\View\ViewJson;
use Module\Email\Entity\EmailEntity;

class EmailPrivateUpdateView extends ViewJson
{

    public ?EmailEntity $email = null;
}
