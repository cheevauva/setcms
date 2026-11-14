<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use Module\Template\Mapper\TemplateToRowMapper;

class TemplateCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\Template\Traits\TemplateDbalDAOTrait;
    

    #[\Override]
    protected function row(): array
    {
        return TemplateToRowMapper::call($this, $this->entity)->row;
    }
}
