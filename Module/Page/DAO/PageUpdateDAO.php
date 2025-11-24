<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\DAO\EntityUpdateDAO;
use Module\Page\Entity\PageEntity;
use Module\Page\Mapper\PageToRowMapper;

/**
 * @extends EntityUpdateDAO<PageEntity>
 */
class PageUpdateDAO extends EntityUpdateDAO
{

    use PageCommonDAO;

    protected string $clsMapper = PageToRowMapper::class;
}
