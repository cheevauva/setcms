<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\Servant\TemplateCreateServant;
use Module\Template\View\TemplatePrivateCreateView;

class TemplatePrivateCreateController extends ControllerViaPSR7
{

    protected TemplateEntity $template;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            TemplateCreateServant::class,
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
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('template')->notEmpty()->validate();

        $this->template = new TemplateEntity();
        $this->template->id = $validation->uuid('template.id')->val();
        $this->template->template = $validation->string('template.template')->notEmpty()->val();
        $this->template->slug = $validation->string('template.slug')->notEmpty()->val();
        $this->template->title = $validation->string('template.title')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateCreateServant) {
            $object->template = $this->template;
        }

        if ($object instanceof TemplatePrivateCreateView) {
            $object->template = $this->template;
        }
    }
}
