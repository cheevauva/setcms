<?php

declare(strict_types=1);

namespace Module\Module01\View;

use SetCMS\View\ViewJson;
use Module\Module01\Entity\Entity01Entity;

class Entity01PrivateUpdateView extends ViewJson
{

    public ?Entity01Entity $Entity01LC = null;
}
