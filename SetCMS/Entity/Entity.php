<?php

declare(strict_types=1);

namespace SetCMS\Entity;

use SetCMS\UUID;

class Entity
{

    use \UUA\Traits\AsTrait;

    public UUID $id;
    public \DateTimeImmutable $dateCreated;
    public \DateTimeImmutable $dateModified;
    public bool $deleted = false;

    public function __construct()
    {
        $this->id = new UUID;
        $this->dateCreated = new \DateTimeImmutable();
        $this->dateModified = new \DateTimeImmutable();
    }

    public function markDeleted(): void
    {
        $this->deleted = true;
        $this->dateModified = new \DateTimeImmutable();
    }
}
