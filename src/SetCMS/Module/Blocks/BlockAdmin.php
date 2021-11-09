<?php

namespace SetCMS\Module\Blocks;

class BlockAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait {
        read as private;
    }

    public function __construct(BlockService $blockService)
    {
        $this->service($blockService);
    }

}
