<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Block\BlockEntity;
use SetCMS\Module\Block\DAO\BlockHasByIdDAO;
use SetCMS\Module\Block\DAO\BlockSaveDAO;
use SetCMS\Module\Block\Exception\BlockNotFoundException;

class BlockUpdateServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;

    public BlockEntity $block;

    public function serve(): void
    {
        $hasById = BlockHasByIdDAO::make($this->factory());
        $hasById->id = $this->block->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new BlockNotFoundException;
        }

        $saveEntity = BlockSaveDAO::make($this->factory());
        $saveEntity->block = $this->block;
        $saveEntity->serve();
    }

}
