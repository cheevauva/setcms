<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockHasByIdDAO;
use SetCMS\Module\Block\DAO\BlockSaveDAO;
use SetCMS\Module\Block\Exception\BlockAlreadyExistsException;

class BlockCreateServant implements Servant
{

    use \SetCMS\Traits\DITrait;

    public BlockEntity $block;

    public function serve(): void
    {
        $hasEntityById = BlockHasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->block->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new BlockAlreadyExistsException;
        }

        $saveEntity = BlockSaveDAO::make($this->factory());
        $saveEntity->block = $this->block;
        $saveEntity->serve();
    }

}
