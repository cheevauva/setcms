<?php

declare(strict_types=1);

namespace Module\Basic\Entity;

use SetCMS\UUID;

class BasicEntity extends \SetCMS\Entity\Entity
{

    public \DateTimeImmutable $dateCreated;
    public \DateTimeImmutable $dateModified;
    public UUID $assignedBy;
    public UUID $createdBy;
    public UUID $modifiedBy;
    public bool $deleted = false;

    public function __construct()
    {
        parent::__construct();

        $this->assignedBy = new UUID(ADMIN_USER_UUID);
        $this->createdBy = new UUID(ADMIN_USER_UUID);
        $this->modifiedBy = new UUID(ADMIN_USER_UUID);
        $this->dateCreated = new \DateTimeImmutable();
        $this->dateModified = new \DateTimeImmutable();
    }

    public function markDeleted(): void
    {
        $this->deleted = true;
        $this->dateModified = new \DateTimeImmutable();
    }
}
