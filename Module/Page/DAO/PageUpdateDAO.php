<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Module\Page\Mapper\PageToRowMapper;

class PageUpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityUpdateTrait;
    use \Module\Page\Traits\PageCallTrait;
    use \Module\Page\Traits\PageDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return PageToRowMapper::call($this->container, $this->page)->row;
    }
}
