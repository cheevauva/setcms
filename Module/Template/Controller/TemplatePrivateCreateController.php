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

    protected TemplateEntity $template;

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
            $object->template = $this->template;
        }

        if ($object instanceof TemplatePrivateCreateView) {
            $object->template = $this->template;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateFromRequestMapper) {
            $this->template = $object->template;
        }
    }
}
