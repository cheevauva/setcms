<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\GUID;

class Entity
{

    public string $id;
    public string $entityType;
    public \DateTime $dateCreated;
    public \DateTime $dateModified;
    public bool $deleted = false;

    public function __construct()
    {
        $this->id = GUID::generate();
        $this->dateCreated = new \DateTime();
        $this->dateModified = new \DateTime();
        $this->entityType = get_class($this);
    }

}
