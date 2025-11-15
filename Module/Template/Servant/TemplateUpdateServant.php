<?php

declare(strict_types=1);

namespace Module\Template\Servant;

use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateHasByIdDAO;
use Module\Template\DAO\TemplateSaveDAO;
use Module\Template\Exception\TemplateNotFoundException;

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
