<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\UUID;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockRetrieveByIdDAO;
use SetCMS\Attribute\Http\Parameter\Attributes;

class BlockPrivateReadScope extends BlockPrivateScope
{

    protected ?BlockEntity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof BlockRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

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
