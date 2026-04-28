<?php

declare(strict_types=1);

namespace Module\Template\DAO;

class TemplateHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityHasByIdTrait;
    use \Module\Template\Traits\TemplateDbalDAOTrait;
}
