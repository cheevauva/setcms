<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\Servant\EntityDeleteServant;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use Module\Page\DAO\PageDeleteByIdDAO;
use Module\Page\DAO\PageUpdateDAO;

/**
 * @extends EntityDeleteServant<PageEntity>
 */
class PageDeleteServant extends EntityDeleteServant
{

    protected string $clsRetrieve = PageRetrieveManyByCriteriaDAO::class;
    protected string $clsUpdate = PageUpdateDAO::class;
    protected string $clsDelete = PageDeleteByIdDAO::class;
}
