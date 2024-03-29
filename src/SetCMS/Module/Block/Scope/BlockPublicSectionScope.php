<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\Scope;
use SetCMS\Module\Block\DAO\BlockRetrieveManyBySectionDAO;

class BlockPublicSectionScope extends Scope
{

    public string $section;
    private array $blocks = [];
    
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof BlockRetrieveManyBySectionDAO) {
            $this->blocks = iterator_to_array($object->entities);
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof BlockRetrieveManyBySectionDAO) {
            $object->section = $this->section;
        }
    }
    
    public function toArray(): array
    {
        return [
            'blocks' => $this->blocks,
        ];
    }

}
