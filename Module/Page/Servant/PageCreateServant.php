<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\Servant\EntityCreateServant;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageHasByIdDAO;
use Module\Page\DAO\PageCreateDAO;

/**
 * @extends EntityCreateServant<PageEntity>
 */
class PageCreateServant extends EntityCreateServant
{

    protected string $clsHasById = PageHasByIdDAO::class;
    protected string $clsCreate = PageCreateDAO::class;
}
