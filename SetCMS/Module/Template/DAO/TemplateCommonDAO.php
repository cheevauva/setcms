<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\DAO;

use SetCMS\Module\Template\Mapper\TemplateMapper;
use SetCMS\Module\Template\TemplateConstrants;

trait TemplateCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): TemplateMapper
    {
        return TemplateMapper::new($this->container);
    }

    protected function table(): string
    {
        return TemplateConstrants::TABLE_NAME;
    }
}
