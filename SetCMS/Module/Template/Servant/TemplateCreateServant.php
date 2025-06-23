<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Servant;

use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\DAO\TemplateHasByIdDAO;
use SetCMS\Module\Template\DAO\TemplateSaveDAO;
use SetCMS\Module\Template\Exception\TemplateAlreadyExistsException;

class TemplateCreateServant extends \UUA\Servant
{

    public TemplateEntity $template;

    #[\Override]
    public function serve(): void
    {
        $hasEntityById = TemplateHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->template->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new TemplateAlreadyExistsException;
        }

        $saveEntity = TemplateSaveDAO::new($this->container);
        $saveEntity->template = $this->template;
        $saveEntity->serve();
    }
}
