<?php

declare(strict_types=1);

namespace Module\RAD99\View;

use SetCMS\View\ViewTwig;
use Module\RAD99\Entity\RAD99Entity;

class RAD99PrivateIndexView extends ViewTwig
{

    /**
     * @var RAD99Entity[]
     */
    public array $rad99s;
}
