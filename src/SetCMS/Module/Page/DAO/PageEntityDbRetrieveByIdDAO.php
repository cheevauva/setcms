<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\PageEntity;

class PageEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityRetrieveByIdDAO
{

    public ?PageEntity $page = null;

    use PageEntityDbDAOTrait;

    public function serve(): void
    {
        parent::serve();

        $this->page = $this->entity;
    }

}
