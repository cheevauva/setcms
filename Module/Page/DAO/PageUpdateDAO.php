<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Page\Entity\PageEntity;
use Module\Page\Mapper\PageToRowMapper;

/**
 * @extends EntityUpdateDAO<PageEntity, PageToRowMapper>
 */
class PageUpdateDAO extends EntityUpdateDAO
{

    use PageCommonDAO;

    #[\Override]
    protected function mapper(): PageToRowMapper
    {
        return PageToRowMapper::new($this->container);
    }
}
