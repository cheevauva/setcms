<?php

declare(strict_types=1);

namespace SetCMS\Entity\Mapper;

use SetCMS\Entity\Entity;

abstract class EntityToRowMapper extends \UUA\Mapper
{

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row = [];

    protected function id(Entity $entity): void
    {
        $this->row['id'] = $entity->id->uuid;
    }

    public function json(mixed $value): string
    {
        $json = json_encode($value, JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            throw new \Exception('json encode failed');
        }

        return $json;
    }
}
