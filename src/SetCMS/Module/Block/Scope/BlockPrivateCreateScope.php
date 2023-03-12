<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\Servant\BlockCreateServant;

class BlockPrivateCreateScope extends BlockPrivateScope
{

    protected ?BlockEntity $entity = null;
    public BlockPrivateBlockScope $block;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof BlockCreateServant) {
            $this->entity = new BlockEntity;
            $this->block->to($this->entity);
            $object->block = $this->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'block' => $this->entity,
        ];
    }

}
