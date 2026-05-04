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
            'field01' => 'field01',
        ];
    }

    protected function prepareEntity(): Entity01Entity
    {
        $entity = new Entity01Entity();
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->field01 = 'field01';

        return $entity;
    }
}
