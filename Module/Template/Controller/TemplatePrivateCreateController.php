<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateCreateDAO;
use Module\Template\View\TemplatePrivateCreateView;
use Module\Template\Mapper\TemplateFromRequestMapper;

class TemplatePrivateCreateController extends ControllerViaPSR7
{

    protected TemplateEntity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            TemplateFromRequestMapper::class,
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
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateCreateDAO) {
            $object->entity = $this->entity;
        }

        if ($object instanceof TemplatePrivateCreateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateFromRequestMapper) {
            $this->entity = $object->entity;
        }
    }
}
