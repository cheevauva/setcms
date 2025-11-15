<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use SetCMS\DAO\EntitySaveDAO;
use Module\Page\PageEntity;

class PageSaveDAO extends EntitySaveDAO
{

    use PageCommonDAO;

    public PageEntity $page;

    public function serve(): void
    {
        $this->entity = $this->page;

        parent::serve();
    }
}
