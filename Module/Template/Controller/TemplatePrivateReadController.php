<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\Entity\TemplateEntity;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\View\TemplatePrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class TemplatePrivateReadController extends ControllerViaPSR7
{

    protected TemplateEntity $template;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
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
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->expectOne = true;
            $object->limit = 1;
            $object->allowEmptyResult = false;
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
            $this->template = $object->template;
        }
        
        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
