<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Common\DAO\Entity\EntityRetrieveByIdDAO;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\Exception\PageNotFoundException;

class PageRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use PageGenericDAO;
    use \SetCMS\Traits\FactoryTrait;

    public PageEntity $page;
    public bool $throwExceptionIfNotFound = false;

    public function serve(): void
    {
        parent::serve();

        if (empty($this->entity) && $this->throwExceptionIfNotFound) {
            throw new PageNotFoundException;
        }

        $this->page = $this->entity;
    }

}
