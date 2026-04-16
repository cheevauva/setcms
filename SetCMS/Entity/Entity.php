<?php

declare(strict_types=1);

namespace SetCMS\Entity;

use SetCMS\UUID;

class Entity
{

    use \UUA\Traits\AsTrait;

    public UUID $id;

    public function __construct()
    {
        $this->id = new UUID;
    }
}
