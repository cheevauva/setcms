<?php

declare(strict_types=1);

namespace Tests\Module\Module01;

use SetCMS\UUID;
use Module\Module01\Entity\Entity01Entity;

trait Entity01HelperTestTrait
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
            'entity_type' => 'entity01lc',
            'date_created' => '2025-11-29 19:56:10',
            'date_modified' => '2025-11-29 19:56:10',
            'deleted' => 0,
            'field01' => 'field01',
        ];
    }

    protected function prepareEntity(): Entity01Entity
    {
        $entity = new Entity01Entity();
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->assignedBy = new UUID(ADMIN_USER_UUID);
        $entity->createdBy = new UUID(ADMIN_USER_UUID);
        $entity->modifiedBy = new UUID(ADMIN_USER_UUID);
        $entity->dateCreated = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->dateModified = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->deleted = false;
        $entity->field01 = 'field01';

        return $entity;
    }
}
