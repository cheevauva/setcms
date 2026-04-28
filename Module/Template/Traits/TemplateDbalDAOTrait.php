<?php

declare(strict_types=1);

namespace Module\Template\Traits;

use Module\Template\TemplateConstrants;

trait TemplateDbalDAOTrait
{

    use \SetCMS\Traits\TraitsDatabaseMain;

    protected function table(): string
    {
        return TemplateConstrants::TABLE_NAME;
    }
}
