<?php

declare(strict_types=1);

namespace Module\Template\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Template\DAO\TemplateRetrieveManyByCriteriaDAO;
use Module\Template\View\TemplatePrivateIndexView;
use Module\Template\Entity\TemplateEntity;

class TemplatePrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var TemplateEntity[]
     */
    protected array $templates = [];

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
            TemplatePrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof TemplateRetrieveManyByCriteriaDAO) {
            $this->templates = $object->templates;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof TemplatePrivateIndexView) {
            $object->templates = $this->templates;
        }
    }
}
