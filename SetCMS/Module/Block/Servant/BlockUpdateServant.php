<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Servant;

use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockHasByIdDAO;
use SetCMS\Module\Block\DAO\BlockSaveDAO;
use SetCMS\Module\Block\Exception\BlockNotFoundException;

class BlockUpdateServant extends \UUA\Servant
{

    public BlockEntity $block;

    public function serve(): void
    {
        $hasById = BlockHasByIdDAO::new($this->container);
        $hasById->id = $this->block->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new BlockNotFoundException;
        }

        $saveEntity = BlockSaveDAO::new($this->container);
        $saveEntity->block = $this->block;
        $saveEntity->serve();
    }
}
