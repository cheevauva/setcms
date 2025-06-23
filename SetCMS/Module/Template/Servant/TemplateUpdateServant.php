<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Servant;

use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\DAO\TemplateHasByIdDAO;
use SetCMS\Module\Template\DAO\TemplateSaveDAO;
use SetCMS\Module\Template\Exception\TemplateNotFoundException;

class TemplateUpdateServant extends \UUA\Servant
{

    public TemplateEntity $template;

    #[\Override]
    public function serve(): void
    {
        $hasById = TemplateHasByIdDAO::new($this->container);
        $hasById->id = $this->template->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new TemplateNotFoundException;
        }

        $saveEntity = TemplateSaveDAO::new($this->container);
        $saveEntity->template = $this->template;
        $saveEntity->serve();
    }
}
