<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Module\Page\PageEntity;

class PageEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO
{

    public ?PageEntity $page = null;

    use PageEntityDbTrait;

    public function serve(): void
    {
        parent::serve();

        $this->page = $this->entity;
    }

}
