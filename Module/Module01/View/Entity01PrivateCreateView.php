<?php

declare(strict_types=1);

namespace Module\Module01\View;

use Module\Module01\Entity\Entity01Entity;

class Entity01PrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?Entity01Entity $entity = null;
}
