<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use Module\Template\Mapper\TemplateToRowMapper;

class TemplateUpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityUpdateTrait;
    use \Module\Template\Traits\TemplateDbalDAOTrait;
    use \Module\Template\Traits\TemplateCallTrait;

    #[\Override]
    protected function row(): array
    {
        return TemplateToRowMapper::call($this->container, $this->template)->row;
    }
}
