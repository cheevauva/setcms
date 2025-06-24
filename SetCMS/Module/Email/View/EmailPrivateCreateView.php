<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\Module\Email\Entity\EmailEntity;

class EmailPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?EmailEntity $email = null;
}
