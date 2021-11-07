<?php

namespace SetCMS\Module\Blocks;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class Block extends OrdinaryEntity
{

    public $module = 'Blocks';
    public $resource = 'block';
    public string $side;
    public string $block;

}
