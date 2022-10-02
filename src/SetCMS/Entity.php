<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\UUID;

class Entity
{

    public UUID $id;
    public string $entityType;
    public \DateTime $dateCreated;
    public \DateTime $dateModified;
    public bool $deleted = false;

    public function __construct()
    {
        $this->id = new UUID;
        $this->dateCreated = new \DateTime();
        $this->dateModified = new \DateTime();
        $this->entityType = get_class($this);
    }

}
