<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\View\TemplatePrivateReadView;

class TemplatePrivateReadController extends ControllerViaPSR7
{

    protected TemplateEntity $template;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            TemplateRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            TemplatePrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof TemplatePrivateReadView) {
            $object->template = $this->template;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $this->template = TemplateEntity::as($object->template);
        }
    }
}
