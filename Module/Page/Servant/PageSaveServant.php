<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\Servant\EntitySaveServant;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\DAO\PageUpdateDAO;

/**
 * @extends EntitySaveServant<PageEntity>
 */
class PageSaveServant extends EntitySaveServant
{

    public string $clsHas = PageHasByIdDAO::class;
    public string $clsUpdate = PageUpdateDAO::class;
    public string $clsCreate = PageCreateDAO::class;
}
