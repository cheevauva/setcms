<?php

declare(strict_types=1);

namespace Module\Page\DAO;

class PageHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use \Module\Page\Traits\PageDbalDAOTrait;
}
