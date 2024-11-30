<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockRetrieveByIdDAO;
use SetCMS\Module\Block\DAO\BlockSaveDAO;
use SetCMS\Module\Block\Exception\BlockNotFoundException;

class BlockDeleteServant implements Servant
{

    use \SetCMS\Traits\DITrait;

    public ?BlockEntity $block = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = BlockRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->block->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new BlockNotFoundException;
        }

        $entity = $retrieveById->block;
        $entity->deleted = true;

        $save = BlockSaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
