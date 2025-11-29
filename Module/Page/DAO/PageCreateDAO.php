<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\DAO\EntityCreateDAO;
use Module\Page\Entity\PageEntity;
use Module\Page\Mapper\PageToRowMapper;

/**
 * @extends EntityCreateDAO<PageEntity, PageToRowMapper>
 */
class PageCreateDAO extends EntityCreateDAO
{

    use PageCommonDAO;

    #[\Override]
    protected function mapper(): PageToRowMapper
    {
        return PageToRowMapper::new($this->container);
    }
}
