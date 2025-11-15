<?php

declare(strict_types=1);

namespace Module\Template\DAO;

use Module\Template\Mapper\TemplateMapper;
use Module\Template\TemplateConstrants;

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
