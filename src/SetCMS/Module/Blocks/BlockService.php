<?php

namespace SetCMS\Module\Blocks;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Blocks\BlockDAO;
use SetCMS\Module\Blocks\Block;

class BlockService extends OrdinaryService
{

    private BlockDAO $blockDAO;

    public function __construct(BlockDAO $blockDAO)
    {
        $this->blockDAO = $blockDAO;
    }

    protected function dao(): BlockDAO
    {
        return $this->blockDAO;
    }

    public function entity(): Block
    {
        return new Block;
    }

}
