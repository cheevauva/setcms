<?php

declare(strict_types=1);

namespace Module\Email\View;

use Module\Email\Entity\EmailEntity;

class EmailPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?EmailEntity $email = null;
}
