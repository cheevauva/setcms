<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\DAO\TemplateUpdateDAO;
use Module\Template\View\TemplatePrivateUpdateView;
use Module\Template\Mapper\TemplateFromRequestMapper;

class TemplatePrivateUpdateController extends ControllerViaPSR7
{

    protected TemplateEntity $template;
    protected TemplateEntity $newtemplate;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            TemplateFromRequestMapper::class,
            TemplateRetrieveManyByCriteriaDAO::class,
            TemplateUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            TemplatePrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $object->id = $this->newtemplate->id;
            $object->expectOne = true;
            $object->limit = 1;
            $object->allowEmptyResult = false;
        }

        if ($object instanceof TemplateUpdateDAO) {
            $object->template = $this->template;
            $object->template->template = $this->newtemplate->template;
            $object->template->title = $this->newtemplate->title;
            $object->template->slug = $this->newtemplate->slug;
        }

        if ($object instanceof TemplatePrivateUpdateView) {
            $object->template = $this->template;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $this->template = $object->template;
        }

        if ($object instanceof TemplateFromRequestMapper) {
            $this->newtemplate = $object->template;
        }
    }
}
