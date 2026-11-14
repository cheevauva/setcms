<?php

declare(strict_types=1);

namespace SetCMS\Entity\Mapper;

use SetCMS\Entity\Entity;
use SetCMS\Entity\Traits\EntityCallTrait;

abstract class EntityToRowMapper extends \UUA\Mapper
{

    use EntityCallTrait;

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row = [];

    #[\Override]
    protected function run(): void
    {
        $this->row['id'] = $this->entity->id->uuid;
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
