<?php

declare(strict_types=1);

namespace Module\Email\View;

use SetCMS\View\ViewTwig;

class EmailPrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\Email\Entity\EmailEntity[]
     */
    public array $emails = [];
}
