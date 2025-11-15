<?php

declare(strict_types=1);

namespace Module\Email\View;

use SetCMS\View\ViewTwig;
use Module\Email\Entity\EmailEntity;

class EmailPrivateReadView extends ViewTwig
{

    public EmailEntity $email;
}
