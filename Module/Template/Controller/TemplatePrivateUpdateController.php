<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\DAO\TemplateUpdateDAO;
use Module\Template\View\TemplatePrivateUpdateView;

class TemplatePrivateUpdateController extends ControllerViaPSR7
{

    protected TemplateEntity $template;
    protected TemplateEntity $newtemplate;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function fromRequest(): void
    {
        $body = $this->validationBody();

        $this->newtemplate = new TemplateEntity;
        $this->newtemplate->id = $body->uuid('template.id')->notEmpty()->val();
        $this->newtemplate->template = $body->string('template.template')->notEmpty()->val();
        $this->newtemplate->slug = $body->string('template.slug')->notEmpty()->val();
        $this->newtemplate->title = $body->string('template.title')->notEmpty()->val();
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
        }

        if ($object instanceof TemplatePrivateUpdateView) {
            $object->template = $this->template ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $this->template = $object->template;
        }
    }
}
