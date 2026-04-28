<?php

declare(strict_types=1);

namespace Module\Page\DAO;

class PageDeleteByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityDeleteByIdTrait;
    use \Module\Page\Traits\PageDbalDAOTrait;
}
