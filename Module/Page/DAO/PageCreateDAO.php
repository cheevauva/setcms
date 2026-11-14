<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Module\Page\Mapper\PageToRowMapper;

class PageCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Page\Traits\PageDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return PageToRowMapper::call($this, $this->entity)->row;
    }
}
