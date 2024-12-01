<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\Mapper\PostMapper;
use SetCMS\Module\Post\PostConstrants;

trait PostGenericDAO
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;
    use \SetCMS\Application\Database\DatabaseMainConnectionTrait;

    protected function mapper(): PostMapper
    {
        return PostMapper::make($this->factory());
    }

    protected function table(): string
    {
        return PostConstrants::TABLE_NAME;
    }

}
