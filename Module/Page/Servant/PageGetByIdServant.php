<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageRetrieveByCriteriaDAO;
use Module\Basic\Servant\BasicEntityGetByIdServant;

/**
 * @extends BasicEntityGetByIdServant<PageEntity>
 */
class PageGetByIdServant extends BasicEntityGetByIdServant
{

    #[\Override]
    protected function manyByCriteria(): PageRetrieveByCriteriaDAO
    {
        return PageRetrieveByCriteriaDAO::new($this);
    }
}
