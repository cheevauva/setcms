<?php

declare(strict_types=1);

namespace Module\Module01\View;

use SetCMS\View\ViewTwig;
use Module\Module01\Entity\Entity01Entity;

class Entity01PrivateIndexView extends ViewTwig
{

    /**
     * @var Entity01Entity[]
     */
    public array $entities = [];
}
