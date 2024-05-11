<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockRetrieveByIdDAO;
use SetCMS\Module\Block\Servant\BlockUpdateServant;

class BlockPrivateUpdateScope extends BlockPrivateScope
{

    protected BlockEntity $entity;

    #[Body('block')]
    public BlockPrivateBlockScope $block;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof BlockRetrieveByIdDAO) {
            $this->entity = new BlockEntity;
            $this->block->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof BlockUpdateServant) {
            $this->block->to($this->entity);
            $object->block = $this->entity;
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
