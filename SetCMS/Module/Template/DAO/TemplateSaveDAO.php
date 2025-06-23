<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\Template\Entity\TemplateEntity;

class TemplateSaveDAO extends EntitySaveDAO
{

    use TemplateCommonDAO;

    public TemplateEntity $template;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->template;

        parent::serve();
    }
}
