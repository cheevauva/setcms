<?php

declare(strict_types=1);

namespace Tests\Module\RAD99;

use SetCMS\UUID;
use Module\RAD99\Entity\RAD99Entity;

trait RAD99HelperTestTrait
{

    /**
     * @return array<string, mixed>
     */
    protected function prepareRow(): array
    {
        return [
            'id' => '331c1832-d5e1-43a6-aef0-6fa6ffbe01a6',
            'created_by' => ADMIN_USER_UUID,
            'modified_by' => ADMIN_USER_UUID,
            'assigned_by' => ADMIN_USER_UUID,
            'entity_type' => RAD99Entity::class,
            'date_created' => '2025-11-29 19:56:10',
            'date_modified' => '2025-11-29 19:56:10',
            'deleted' => 0,
            'field99' => 'field99',
        ];
    }

    protected function prepareEntity(): RAD99Entity
    {
        $entity = new RAD99Entity();
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->assignedBy = new UUID(ADMIN_USER_UUID);
        $entity->createdBy = new UUID(ADMIN_USER_UUID);
        $entity->modifiedBy = new UUID(ADMIN_USER_UUID);
        $entity->dateCreated = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->dateModified = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->deleted = false;
        $entity->field99 = 'field99';

        return $entity;
    }
}
