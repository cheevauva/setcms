<?php

declare(strict_types=1);

namespace SetCMS\Entity;

use SetCMS\UUID;

class Entity
{

    use \UUA\Traits\AsTrait;

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

    public function markDeleted(): void
    {
        $this->deleted = true;
        $this->dateModified = new \DateTime();
    }
}
