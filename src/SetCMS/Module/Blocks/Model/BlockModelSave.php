<?php

namespace SetCMS\Module\Blocks\Model;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Blocks\Block;

class BlockModelSave extends OrdinaryModel
{

    public $id = '';

    /**
     * @setcms-required
     * @var type 
     */
    public $name = '';

    /**
     * @setcms-required
     * @var type 
     */
    public $block = '';

    /**
     * @setcms-required
     * @var type 
     */
    public $side = '';

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): Block
    {
        $entity->side = $this->side;
        $entity->name = $this->name;
        $entity->block = $this->block;

        return parent::bind($entity);
    }

}
