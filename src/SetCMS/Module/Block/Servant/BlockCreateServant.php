<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Servant;

use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockHasByIdDAO;
use SetCMS\Module\Block\DAO\BlockSaveDAO;
use SetCMS\Module\Block\Exception\BlockAlreadyExistsException;

class BlockCreateServant extends \UUA\Servant
{

    public BlockEntity $block;

    public function serve(): void
    {
        $hasEntityById = BlockHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->block->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new BlockAlreadyExistsException;
        }

        $saveEntity = BlockSaveDAO::new($this->container);
        $saveEntity->block = $this->block;
        $saveEntity->serve();
    }
}
