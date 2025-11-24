<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\Servant\EntityUpdateServant;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageUpdateDAO;

/**
 * @extends EntityUpdateServant<PageEntity>
 */
class PageUpdateServant extends EntityUpdateServant
{
    protected string $clsHasById = PageHasByIdDAO::class;
    protected string $clsUpdate = PageUpdateDAO::class;
}
