<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\View\ViewTwig;

class EmailPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\Email\Entity\EmailEntity[]
     */
    public array $emails = [];
}
