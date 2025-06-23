<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Servant;

use SetCMS\UUID;
use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use SetCMS\Module\Template\DAO\TemplateSaveDAO;
use SetCMS\Module\Template\Exception\TemplateNotFoundException;

class TemplateDeleteServant extends \UUA\Servant
{

    public ?TemplateEntity $template = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $templateById = TemplateRetrieveManyByCriteriaDAO::new($this->container);
        $templateById->id = $this->id ?? ($this->template->id ?? throw new \RuntimeException('id is undefined'));
        $templateById->serve();

        if (!$templateById->template) {
            throw new TemplateNotFoundException;
        }

        $template = TemplateEntity::as($templateById->template);
        $template->deleted = true;

        $save = TemplateSaveDAO::new($this->container);
        $save->template = $template;
        $save->serve();

        $this->template = $template;
    }
}
