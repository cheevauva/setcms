<?php

declare(strict_types=1);

namespace Module\Template\Servant;

use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateHasByIdDAO;
use Module\Template\DAO\TemplateSaveDAO;
use Module\Template\Exception\TemplateAlreadyExistsException;

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
