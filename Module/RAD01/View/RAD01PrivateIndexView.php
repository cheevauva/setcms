<?php

declare(strict_types=1);

namespace Module\RAD01\View;

use SetCMS\View\ViewTwig;
use Module\RAD01\Entity\RAD01Entity;

class RAD01PrivateIndexView extends ViewTwig
{

    /**
     * @var RAD01Entity[]
     */
    public array $rad01s;
}
