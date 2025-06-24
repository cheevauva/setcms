<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Email\Entity\EmailEntity;

class EmailPrivateReadView extends ViewTwig
{

    public EmailEntity $email;
}
