<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\Page\PageEntity;

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
