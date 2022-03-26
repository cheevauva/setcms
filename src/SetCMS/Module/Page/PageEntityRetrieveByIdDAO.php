<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Core\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Page\PageEntityDbMapper;

class PageEntityRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    public function __construct()
    {
        $this->mapper = new PageEntityDbMapper;
    }

}
