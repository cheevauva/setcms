<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\Servant\TemplateUpdateServant;
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
            TemplateUpdateServant::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newtemplate = new TemplateEntity;
        $this->newtemplate->id = $validation->uuid('template.id')->notEmpty()->val();
        $this->newtemplate->template = $validation->string('template.template')->notEmpty()->val();
        $this->newtemplate->slug = $validation->string('template.slug')->notEmpty()->val();
        $this->newtemplate->title = $validation->string('template.title')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $object->id = $this->newtemplate->id;
            $object->orThrow = true;
        }

        if ($object instanceof TemplateUpdateServant) {
            $object->template = $this->template;
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
            $this->template = TemplateEntity::as($object->template);
            $this->template->template = $this->newtemplate->template;
        }
    }
}
