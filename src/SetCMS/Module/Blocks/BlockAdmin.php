<?php

namespace SetCMS\Module\Blocks;

use SetCMS\Module\Ordinary\OrdinaryController;

class BlockAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryAdminTrait;

    public function __construct(BlockService $postService, OrdinaryController $ordinaryAdmin)
    {
        $this->ordinary($ordinaryAdmin);
        $this->ordinary()->service($postService);
    }

}
