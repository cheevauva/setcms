<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\Mapper\PostEntityDbMapper;
use SetCMS\Module\Post\PostConstants;

trait PostEntityDbDAOTrait
{   
    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): PostEntityDbMapper
    {
        return PostEntityDbMapper::make($this->factory());
    }
    
    protected function table(): string
    {
        return PostConstants::TABLE_NAME;
    }

}
