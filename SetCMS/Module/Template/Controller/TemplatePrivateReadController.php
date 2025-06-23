<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use SetCMS\Module\Template\View\TemplatePrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

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
        $validation = $this->validation(RouterMatchDTO::as($this->ctx['routerMatch'])->params);

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
