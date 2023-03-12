<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\UUID;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockRetrieveByIdDAO;

class BlockPrivateReadScope extends BlockPrivateScope
{

    protected ?BlockEntity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof BlockRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof BlockRetrieveByIdDAO) {
            $this->entity = $object->block;
        }
    }

    public function toArray(): array
    {
        return [
            'block' => $this->entity,
        ];
    }

}
