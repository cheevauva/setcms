<?php

namespace SetCMS\Module\Blocks;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Blocks\BlockService;
use SetCMS\Module\Blocks\Model\BlockModelSave;

class BlockResource
{

    use \SetCMS\Module\Ordinary\OrdinaryResourceTrait;

    public function __construct(BlockService $blockService)
    {
        $this->service($blockService);
    }

    public function update(ServerRequestInterface $request, BlockModelSave $model): BlockModelSave
    {
        return $this->save($request, $model);
    }

    public function create(ServerRequestInterface $request, BlockModelSave $model): BlockModelSave
    {
        return $this->save($request, $model);
    }

}
