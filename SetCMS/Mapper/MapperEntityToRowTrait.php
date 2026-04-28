<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\Entity;

trait MapperEntityToRowTrait
{

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row = [];

    private function mappingDefault(Entity $entity): void
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
