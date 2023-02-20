<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\Mapper\PostMapper;
use SetCMS\Module\Post\PostConstants;

trait PostGenericDAO
{   
    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): PostMapper
    {
        return PostMapper::make($this->factory());
    }
    
    protected function table(): string
    {
        return PostConstants::TABLE_NAME;
    }

}
