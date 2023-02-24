<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Page\PageEntity;

class PageRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use PageGenericDAO;

    public PageEntity $page;

    public function serve(): void
    {
        parent::serve();

        $this->page = $this->entity;
    }

}
