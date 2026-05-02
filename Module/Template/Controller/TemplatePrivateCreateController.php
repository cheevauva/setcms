<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateCreateDAO;
use Module\Template\View\TemplatePrivateCreateView;

class TemplatePrivateCreateController extends ControllerViaPSR7
{

    protected TemplateEntity $template;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            TemplateCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            TemplatePrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $body = $this->validationBody();
        $body->array('template')->notEmpty()->validate();

        $this->template = new TemplateEntity();
        $this->template->id = $body->uuid('template.id')->val();
        $this->template->template = $body->string('template.template')->notEmpty()->val();
        $this->template->slug = $body->string('template.slug')->notEmpty()->val();
        $this->template->title = $body->string('template.title')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateCreateDAO) {
            $object->template = $this->template;
        }

        if ($object instanceof TemplatePrivateCreateView) {
            $object->template = $this->template;
        }
    }
}
