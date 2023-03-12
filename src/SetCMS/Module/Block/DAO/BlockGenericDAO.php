<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\DAO;

use SetCMS\Module\Block\Mapper\BlockMapper;
use SetCMS\Module\Block\BlockConstrants;

trait BlockGenericDAO
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): BlockMapper
    {
        return BlockMapper::make($this->factory());
    }

    protected function table(): string
    {
        return BlockConstrants::TABLE_NAME;
    }

}
